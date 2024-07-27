<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class ToolsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }
    public function CreatePagination($page_index, $pages)
    {
        $pagination = [];
        $i = $page_index - 2;
        if ($i <= 0) {
            $i = 1;
        }
        $s = 1;
        for ($i; $i <= $pages; $i++) {
            if ($s == 6) {
                break;
            }
            if ($i == $page_index) {
                $pagination[] = array('index' => $i, 'status' => 'active');
            } else {
                $pagination[] = array('index' => $i, 'status' => 'inactive');
            }
            $s++;
        }
        return $pagination;
    }
    //====================================================== SILAGE MAKING================================================//
    public function Silage_making()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('number_of_cows', 'number_of_cows', 'required|xss_clean|trim');
            $this->form_validation->set_rules('feeding', 'feeding', 'required|xss_clean|trim');
            $this->form_validation->set_rules('total_feeding_days', 'total_feeding_days', 'required|xss_clean|trim');
            $this->form_validation->set_rules('density', 'density', 'required|xss_clean|trim');
            $this->form_validation->set_rules('breadth', 'breadth', 'required|xss_clean|trim');
            $this->form_validation->set_rules('height', 'height', 'required|xss_clean|trim');
            $this->form_validation->set_rules('number_of_pits', 'number_of_pits', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $number_of_cows = $this->input->post('number_of_cows');
                $feeding = $this->input->post('feeding');
                $total_feeding_days = $this->input->post('total_feeding_days');
                $density = $this->input->post('density');
                $breadth = $this->input->post('breadth');
                $height = $this->input->post('height');
                $number_of_pits = $this->input->post('number_of_pits');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    $data = [];
                    $silage_qty_required = round(($number_of_cows * $feeding * $total_feeding_days), 2);
                    $pit_vol_required = round(($silage_qty_required / $density), 2);
                    $length = round(($pit_vol_required / ($breadth * $height * $number_of_pits)), 2);
                    $fodder_required = round((($silage_qty_required * 15 / 10) / 1000), 2);
                    $data = array(
                        'silage_qty_required' => $silage_qty_required,
                        'pit_vol_required' => $pit_vol_required,
                        'length' => $length,
                        'fodder_required' => $fodder_required,
                    );
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('silage_making' => $service_data[0]->silage_making + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'silage_making',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $data
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== project_requirements ================================================//
    public function project_requirements()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('number_of_cows', 'number_of_cows', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $number_of_cows = $this->input->post('number_of_cows');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    $data = [];
                    $data['number_of_cows'] = $number_of_cows;
                    require_once APPPATH . "/third_party/PHPExcel.php"; //------ INCLUDE EXCEL
                    $inputFileName = 'assets/excel/25_cows.xls';
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel1 = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }
                    //  Get worksheet dimensions
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('B9', $number_of_cows);
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel1, 'Excel2007');
                    $objWriter->setPreCalculateFormulas(true);
                    $objWriter->save('assets/excel/25_cows.xls');
                    // // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('B9')->getValue());
                    // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C12')->getFormattedValue());
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }
                    $data['objPHPExcel'] = $objPHPExcel;
                    $message = $this->load->view('pdf/25_cows', $data, true);
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('pro_req' => $service_data[0]->pro_req + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'pro_req',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $message
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== SILAGE MAKING================================================//
    public function project_test()
    {
        $data['number_of_cows'] = 40;
        require_once APPPATH . "/third_party/PHPExcel.php"; //------ INCLUDE EXCEL
        //-------- start excel read and insert into db
        $inputFileName = 'assets/excel/25_cows.xls';
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel1 = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
        //  Get worksheet dimensions
        $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('B9', '50');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel1, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save('assets/excel/25_cows.xls');
        // // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('B9')->getValue());
        // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C12')->getFormattedValue());
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
        $data['objPHPExcel'] = $objPHPExcel;
        // $data['C12'] = number_format($objPHPExcel->setActiveSheetIndex(0)->getCell('C12')->getOldCalculatedValue());
        // $data['C13'] = number_format($objPHPExcel->setActiveSheetIndex(0)->getCell('C13')->getOldCalculatedValue());
        // $data['C14'] = number_format($objPHPExcel->setActiveSheetIndex(0)->getCell('C14')->getOldCalculatedValue());
        // //----------//
        // $data['C15'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('C15')->getOldCalculatedValue(), 2);
        // $data['D15'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('D15')->getOldCalculatedValue(), 2);
        // $data['E15'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('E15')->getOldCalculatedValue(), 2);
        // $data['F15'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('F15')->getFormattedValue(), 2);
        // $data['G15'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('G15')->getFormattedValue(), 2);
        // $data['H15'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('H15')->getFormattedValue(), 2);
        // //----------//
        // $data['C16'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('C16')->getFormattedValue(), 2);
        // $data['D16'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('D16')->getFormattedValue(), 2);
        // $data['E16'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('E16')->getFormattedValue(), 2);
        // $data['F16'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('F16')->getFormattedValue(), 2);
        // $data['G16'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('G16')->getFormattedValue(), 2);
        // $data['H16'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('H16')->getFormattedValue(), 2);
        // //----------//
        // $data['C17'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('C17')->getFormattedValue(), 2);
        // $data['D17'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('D17')->getFormattedValue(), 2);
        // $data['E17'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('E17')->getFormattedValue(), 2);
        // $data['F17'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('F17')->getFormattedValue(), 2);
        // $data['G17'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('G17')->getFormattedValue(), 2);
        // $data['H17'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('H17')->getFormattedValue(), 2);
        // //----------//
        // $data['C18'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('C18')->getFormattedValue(), 2);
        // $data['D18'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('D18')->getFormattedValue(), 2);
        // $data['E18'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('E18')->getFormattedValue(), 2);
        // $data['F18'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('F18')->getFormattedValue(), 2);
        // $data['G18'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('G18')->getFormattedValue(), 2);
        // $data['H18'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('H18')->getFormattedValue(), 2);
        // //----------//
        // $data['C19'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('C19')->getFormattedValue(), 2);
        // $data['D19'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('D19')->getFormattedValue(), 2);
        // $data['E19'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('E19')->getFormattedValue(), 2);
        // $data['F19'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('F19')->getFormattedValue(), 2);
        // $data['G19'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('G19')->getFormattedValue(), 2);
        // $data['H19'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('H19')->getFormattedValue(), 2);
        // //----------//
        // $data['C22'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('C22')->getFormattedValue(), 2);
        // //----------//
        // $data['D23'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('D23')->getFormattedValue(), 2);
        // $data['E23'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('E23')->getFormattedValue(), 2);
        // $data['F23'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('F23')->getFormattedValue(), 2);
        // $data['G23'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('G23')->getFormattedValue(), 2);
        // $data['H23'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('H23')->getFormattedValue(), 2);
        // //----------//
        // $data['C24'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('C24')->getFormattedValue(), 2);
        // $data['D24'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('D24')->getFormattedValue(), 2);
        // $data['E24'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('E24')->getFormattedValue(), 2);
        // $data['F24'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('F24')->getFormattedValue(), 2);
        // $data['G24'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('G24')->getFormattedValue(), 2);
        // $data['H24'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('H24')->getFormattedValue(), 2);
        // //----------//
        // $data['C25'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('C25')->getFormattedValue(), 2);
        // $data['D25'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('D25')->getFormattedValue(), 2);
        // $data['E25'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('E25')->getFormattedValue(), 2);
        // $data['F25'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('F25')->getFormattedValue(), 2);
        // $data['G25'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('G25')->getFormattedValue(), 2);
        // $data['H25'] = round($objPHPExcel->setActiveSheetIndex(0)->getCell('H25')->getFormattedValue(), 2);
        $message = $this->load->view('pdf/25_cows', $data, true);
        print_r($message);
        // $data = array(
        //     'silage_qty_required' => $silage_qty_required,
        //     'pit_vol_required' => $pit_vol_required,
        //     'length' => $length,
        //     'fodder_required' => $fodder_required,
        // );
    }
    //====================================================== PREGNANCY CALCULATOR================================================//
    public function pregnancy_calculator()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('breeding_date', 'breeding_date', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $breeding_date = $this->input->post('breeding_date');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    $date = strtotime($breeding_date);
                    $cycle1 = strtotime("+21 day", $date);
                    $cycle2 = strtotime("+42 day", $date);
                    $cycle3 = strtotime("+63 day", $date);
                    $calving = strtotime("+283 day", $date);
                    $weaning = strtotime("+488 day", $date);
                    $data = [];
                    $data = array(
                        'cycle1_date' => date('d/m/Y', $cycle1),
                        'cycle2_date' =>  date('d/m/Y', $cycle2),
                        'cycle3_date' =>  date('d/m/Y', $cycle3),
                        'calving_date' =>  date('d/m/Y', $calving),
                        'weaning_date' =>  date('d/m/Y', $weaning),
                    );
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('preg_calculator' => $service_data[0]->preg_calculator + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'preg_calculator',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $data
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== SNF CALCULATOR================================================//
    public function snf_calculator()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
            $this->form_validation->set_rules('snf', 'snf', 'xss_clean|trim');
            $this->form_validation->set_rules('clr', 'clr', 'xss_clean|trim');
            $this->form_validation->set_rules('fat', 'fat', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $type = $this->input->post('type');
                $snf = $this->input->post('snf');
                $clr = $this->input->post('clr');
                $fat = $this->input->post('fat');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    if ($type == 'CLR') {
                        $percentage = round(($clr / 4) + (0.21 * $fat) + 0.66, 2);
                    } else {
                        $percentage = round(($snf - (0.21 * $fat) - 0.66) * 4, 2);
                    }
                    // $cow = [];
                    // $buffalo = [];
                    // $cow = array(
                    //     'lactose' =>  round($snf ? $snf : $percentage * 0.55, 3),
                    //     'solid' =>  round($snf ? $snf : $percentage * 0.083, 3),
                    //     'protein' => round($snf ? $snf : $percentage * 0.367, 3),
                    // );
                    // $buffalo = array(
                    //     'lactose' => round($snf ? $snf : $percentage * 0.45, 3),
                    //     'solid' =>   round($snf ? $snf : $percentage * 0.076, 3),
                    //     'protein' =>  round($snf ? $snf : $percentage * 0.475, 3),
                    // );
                    $lsp = [
                        ['Lactose',  round(($type == 'SNF' ? $snf : $percentage) * 0.55, 3), round(($type == 'SNF'  ? $snf : $percentage) * 0.45, 3)],
                        ['Solid', round(($type == 'SNF'  ? $snf : $percentage) * 0.083, 3), round(($type == 'SNF'  ? $snf : $percentage) * 0.076, 3)],
                        ['Protein',  round(($type == 'SNF'  ? $snf : $percentage) * 0.367, 3),  round(($type == 'SNF'  ? $snf : $percentage) * 0.475, 3)],
                    ];
                    $data = [];
                    $data = array(
                        'percentage' => $percentage,
                        'lsp' =>  $lsp,
                    );
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('snf_calculator' => $service_data[0]->snf_calculator + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'snf_calculator',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $data
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== AllProducts ================================================//
    public function AllProducts()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('is_admin', 'is_admin', 'required|xss_clean|trim');
            $this->form_validation->set_rules('vendor_id', 'vendor_id', 'xss_clean|trim');
            $this->form_validation->set_rules('search', 'search', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $is_admin = $this->input->post('is_admin');
                $vendor_id = $this->input->post('vendor_id');
                $search = $this->input->post('search');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $limit = 20;
                    if (!empty($page_index)) {
                        $start = ($page_index - 1) * $limit;
                    } else {
                        $start = 0;
                    }
                    if ($is_admin == 'admin') {
                        if (empty($search)) {
                            $count = $this->db->get_where('tbl_products', array('is_active' => 1, 'is_admin' => 1))->num_rows();
                            $ProData = $this->db->limit($limit, $start)->get_where('tbl_products', array('is_active' => 1, 'is_admin' => 1));
                        } else {
                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('is_active', 1);
                            $this->db->where('is_admin', 1);
                            $this->db->where("(name_english LIKE '%" . $search . "%' OR name_hindi LIKE '%" . $search . "%' OR name_punjabi LIKE '%" . $search . "%')", NULL, FALSE);
                            $count = $this->db->count_all_results();
                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('is_active', 1);
                            $this->db->where('is_admin', 1);
                            $this->db->limit($limit, $start);
                            $this->db->where("(name_english LIKE '%" . $search . "%' OR name_hindi LIKE '%" . $search . "%' OR name_punjabi LIKE '%" . $search . "%')", NULL, FALSE);
                            $ProData = $this->db->get();
                        }
                    } else {
                        if (empty($search)) {
                            $count = $this->db->get_where('tbl_products', array('is_active' => 1, 'is_approved' => 1, 'is_admin' => 0, 'added_by' => $vendor_id))->num_rows();
                            $ProData = $this->db->limit($limit, $start)->get_where('tbl_products', array('is_active' => 1, 'is_approved' => 1, 'is_admin' => 0, 'added_by' => $vendor_id));
                        } else {
                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('is_active', 1);
                            $this->db->where('is_approved', 1);
                            $this->db->where('is_admin', 0);
                            $this->db->where('added_by', $vendor_id);
                            $this->db->where("(name_english LIKE '%" . $search . "%' OR name_hindi LIKE '%" . $search . "%' OR name_punjabi LIKE '%" . $search . "%')", NULL, FALSE);
                            $count = $this->db->count_all_results();
                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('is_active', 1);
                            $this->db->where('is_approved', 1);
                            $this->db->where('is_admin', 0);
                            $this->db->where('added_by', $vendor_id);
                            $this->db->limit($limit, $start);
                            $this->db->where("(name_english LIKE '%" . $search . "%' OR name_hindi LIKE '%" . $search . "%' OR name_punjabi LIKE '%" . $search . "%')", NULL, FALSE);
                            $ProData = $this->db->get();
                        }
                    }
                    $pages = round($count / $limit);
                    $pagination = $this->CreatePagination($page_index, $pages);
                    $en_data = [];
                    $hi_data = [];
                    $pn_data = [];
                    foreach ($ProData->result() as $pro) {
                            
                        if (!empty($pro->image)) {
                            
                            $imageArray = json_decode($pro->image, true);
                            if (is_array($imageArray) && !empty($imageArray)) {
                                   $image= base_url() . $imageArray[0];
                            }else{
                                $image= base_url() . $pro->image;
                            }
                          
                        } else {
                            $image = '';
                        }


                        if ($pro->inventory != 0) {
                            $stock = 'In Stock';
                        } else {
                            $stock = 'Out of Stock';
                        }
                        $discount = (int)$pro->mrp - (int)$pro->selling_price;
                        $percent = 0;
                        if ($discount > 0) {
                            $percent = round($discount / $pro->mrp * 100);
                        }
                        $en_data[] = array(
                            'pro_id' => $pro->id,
                            'name' => $pro->name_english,
                            'description' => $pro->description_english,
                            'image' => $image,
                            'mrp' => $pro->mrp,
                            'min_qty' => $pro->min_qty ? $pro->min_qty : 1,
                            'selling_price' => $pro->selling_price,
                            'suffix' => $pro->suffix,
                            'stock' => $stock,
                            'percent' => $percent,
                            'vendor_id' => $pro->added_by,
                            'is_admin' => $pro->is_admin,
                            'offer' => $pro->offer,
                            'product_cod' => $pro->cod
                        );
                        $hi_data[] = array(
                            'pro_id' => $pro->id,
                            'name' => $pro->name_hindi,
                            'description' => $pro->description_hindi,
                            'image' => $image,
                            'min_qty' => $pro->min_qty ? $pro->min_qty : 1,
                            'mrp' => $pro->mrp,
                            'selling_price' => $pro->selling_price,
                            'suffix' => $pro->suffix,
                            'stock' => $stock,
                            'percent' => $percent,
                            'vendor_id' => $pro->added_by,
                            'is_admin' => $pro->is_admin,
                            'offer' => $pro->offer,
                            'product_cod' => $pro->cod
                        );
                        $pn_data[] = array(
                            'pro_id' => $pro->id,
                            'name' => $pro->name_punjabi,
                            'description' => $pro->description_punjabi,
                            'image' => $image,
                            'mrp' => $pro->mrp,
                            'min_qty' => $pro->min_qty ? $pro->min_qty : 1,
                            'selling_price' => $pro->selling_price,
                            'suffix' => $pro->suffix,
                            'stock' => $stock,
                            'percent' => $percent,
                            'vendor_id' => $pro->added_by,
                            'is_admin' => $pro->is_admin,
                            'offer' => $pro->offer,
                            'product_cod' => $pro->cod
                        );
                    }
                    $data = array(
                        'en' => $en_data,
                        'hi' => $hi_data,
                        'pn' => $pn_data,
                    );
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $data,
                        'is_cod' => $farmer_data[0]->cod,
                        'pagination' => $pagination,
                        'last' => $pages,
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //------ Distance calculator ---------
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        //ordignal method
        // $theta = $lon1 - $lon2;
        // $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        // $dist = acos($dist);
        // $dist = rad2deg($dist);
        // $miles = $dist * 60 * 1.1515;
        // return (round($miles * 1.609344, 2));
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        // Calculate the distance using Haversine formula
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $distance = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $distance * 6371000;

         
    }
    //====================================================== DOCTOR ON CALL================================================//
    public function doctor_on_call()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('latitude', 'latitude', 'required|xss_clean|trim');
            $this->form_validation->set_rules('longitude', 'longitude', 'required|xss_clean|trim');
            $this->form_validation->set_rules('radius', 'radius', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $radius = $this->input->post('radius');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $DoctorData = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'is_expert' => 0))->result();
                    $en_data = [];
                    $hi_data = [];
                    $pn_data = [];
                    foreach ($DoctorData as $doctor) {
                        if (!empty($doctor->latitude) && !empty($doctor->longitude)) {

                            // echo $latitude.' '.$longitude.' ' .$doctor->latitude.' '.$doctor->longitude;
                            // exit();
                            $km = $this->distance($latitude, $longitude, $doctor->latitude, $doctor->longitude);

                            $distance = $km / 1000;


                            //     $earth_radius_km = 6371; // Earth's average radius in kilometers
                            //     $angular_distance = $km / $earth_radius_km;
                            // // in radians


                            // echo "<br>";
                            if ($distance <= $radius && $radius <= 40) {

                                // echo ("kilo meter = " . $km);
                                // echo ("Radius = " . $radius);
                                // exit();
                                // if (true) {
                                if (!empty($doctor->image)) {
                                    $image = base_url() . $doctor->image;
                                } else {
                                    $image = '';
                                }
                                $en_data[] = array(
                                    'id' => $doctor->id,
                                    'name' => $doctor->name,
                                    'email' => $doctor->email,
                                    'qualification' => $doctor->qualification,
                                    'expertise' => $doctor->expertise,
                                    'phone' => $doctor->phone,
                                    'type' => $doctor->type,
                                    'image' => $image,
                                    'km' => $distance
                                );
                                $hi_data[] = array(
                                    'id' => $doctor->id,
                                    'name' => $doctor->hi_name,
                                    'email' => $doctor->email,
                                    'qualification' => $doctor->qualification,
                                    'expertise' => $doctor->expertise,
                                    'phone' => $doctor->phone,
                                    'type' => $doctor->type,
                                    'image' => $image,
                                    'km' => $distance
                                );
                                $pn_data[] = array(
                                    'id' => $doctor->id,
                                    'name' => $doctor->pn_name,
                                    'email' => $doctor->email,
                                    'expertise' => $doctor->expertise,
                                    'qualification' => $doctor->qualification,
                                    'phone' => $doctor->phone,
                                    'type' => $doctor->type,
                                    'image' => $image,
                                    'km' => $distance
                                );
                            }
                            // else
                            // {
                            //    break;

                            // }
                        }
                        $data = array(
                            'en' => $en_data,
                            'hi' => $hi_data,
                            'pn' => $pn_data,
                        );
                    }
                    $res = array(
                        'message' => "Success",
                        'status' => 200,
                        'data' => $data
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== EXPERT ADVICE ================================================//
    public function expert_advice()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            //     $this->form_validation->set_rules('latitude', 'latitude', 'required|xss_clean|trim');
            //     $this->form_validation->set_rules('longitude', 'longitude', 'required|xss_clean|trim');
            //     $this->form_validation->set_rules('radius', 'radius', 'required|xss_clean|trim');
            $this->form_validation->set_rules('expert_id', 'expert_id', 'required|xss_clean|trim');

            if ($this->form_validation->run() == true) {
                //         $latitude = $this->input->post('latitude');
                //         $longitude = $this->input->post('longitude');
                //         $radius = $this->input->post('radius');
                $expert_id = $this->input->post('expert_id');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $DoctorData = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'is_expert' => 1))->result();
                    $en_data = [];
                    $hi_data = [];
                    $pn_data = [];
                    foreach ($DoctorData as $doctor) {
                        $expert_category = json_decode($doctor->expert_category);
                        if (is_array($expert_category)) {
                            if (in_array($expert_id, $expert_category)) {
                                // if (!empty($doctor->latitude) && !empty($doctor->latitude)) {
                                //     $km = $this->distance($latitude, $longitude, $doctor->latitude, $doctor->longitude);
                                // echo $km;
                                // echo "<br>";
                                // if ($km <= $radius) {
                                if (!empty($doctor->image)) {
                                    $image = base_url() . $doctor->image;
                                } else {
                                    $image = '';
                                }
                                $state_data = $this->db->get_where('all_states', array('id' =>  $doctor->state))->result();
                                $en_data[] = array(
                                    'id' => $doctor->id,
                                    'name' => $doctor->name,
                                    'email' => $doctor->email,
                                    'degree' => $doctor->degree,
                                    'phone' => $doctor->phone,
                                    'type' => $doctor->type,
                                    'experience' => $doctor->experience,
                                    'fees' => $doctor->fees,
                                    'expertise' => $doctor->expertise,
                                    'qualification' => $doctor->qualification,
                                    'district' => $doctor->district,
                                    'city' => $doctor->city,
                                    'state' => $state_data ? $state_data[0]->state_name : '',
                                    'image' => $image
                                );
                                $hi_data[] = array(
                                    'id' => $doctor->id,
                                    'name' => $doctor->hi_name,
                                    'email' => $doctor->email,
                                    'degree' => $doctor->degree,
                                    'phone' => $doctor->phone,
                                    'type' => $doctor->type,
                                    'experience' => $doctor->experience,
                                    'fees' => $doctor->fees,
                                    'expertise' => $doctor->expertise,
                                    'qualification' => $doctor->qualification,
                                    'district' => $doctor->hi_district,
                                    'city' => $doctor->hi_city,
                                    'state' => $state_data ? $state_data[0]->state_name : '',
                                    'image' => $image
                                );
                                $pn_data[] = array(
                                    'id' => $doctor->id,
                                    'name' => $doctor->pn_name,
                                    'email' => $doctor->email,
                                    'degree' => $doctor->degree,
                                    'phone' => $doctor->phone,
                                    'type' => $doctor->type,
                                    'experience' => $doctor->experience,
                                    'fees' => $doctor->fees,
                                    'expertise' => $doctor->expertise,
                                    'qualification' => $doctor->qualification,
                                    'district' => $doctor->pn_district,
                                    'city' => $doctor->pn_city,
                                    'state' => $state_data ? $state_data[0]->state_name : '',
                                    'image' => $image
                                );
                                // }
                                // }
                                $data = array(
                                    'en' => $en_data,
                                    'hi' => $hi_data,
                                    'pn' => $pn_data,
                                );
                            }
                        }
                    }
                    $res = array(
                        'message' => "Success",
                        'status' => 200,
                        'data' => $data
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== EXPERT ADVICE ================================================//
    public function request_doctor()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('doctor_id', 'doctor_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('is_expert', 'is_expert', 'required|xss_clean|trim');
            $this->form_validation->set_rules('reason', 'reason', 'xss_clean|trim');
            $this->form_validation->set_rules('description', 'description', 'xss_clean|trim');
            $this->form_validation->set_rules('fees', 'fees', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $doctor_id = $this->input->post('doctor_id');
                $is_expert = $this->input->post('is_expert');
                $reason = $this->input->post('reason');
                $description = $this->input->post('description');
                $fees = $this->input->post('fees');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    //=============================================IMAGE1 ====================================================//
                    $this->load->library('upload');
                    $img1 = 'image1';
                    $nnnn = '';
                    if (!empty($_FILES['image1'])) {
                        if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0) {
                            $file_check = ($_FILES['image1']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image1" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img1)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn = $videoNAmePath;
                                }
                            }
                        }
                    }
                    //===================================================IMAGE2====================================================//
                    $img2 = 'image2';
                    $nnnn2 = '';
                    if (!empty($_FILES['image2'])) {
                        if ($_FILES['image2']['size'] != 0 && $_FILES['image2']['error'] == 0) {
                            $file_check = ($_FILES['image2']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image2" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img2)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn2 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    //=======================================================IMAGE3===================================================//
                    $img3 = 'image3';
                    $nnnn3 = '';
                    if (!empty($_FILES['image3'])) {
                        if ($_FILES['image3']['size'] != 0 && $_FILES['image3']['error'] == 0) {
                            $file_check = ($_FILES['image3']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image3" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img3)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn3 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    //=======================================================IMAGE4======================================================//
                    $img4 = 'image4';
                    $nnnn4 = '';
                    if (!empty($_FILES['image4'])) {
                        if ($_FILES['image4']['size'] != 0 && $_FILES['image4']['error'] == 0) {
                            $file_check = ($_FILES['image4']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image3" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img4)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn4 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    //=======================================================IMAGE5======================================================//
                    $img5 = 'image5';
                    $nnnn5 = '';
                    if (!empty($_FILES['image5'])) {
                        if ($_FILES['image5']['size'] != 0 && $_FILES['image5']['error'] == 0) {
                            $file_check = ($_FILES['image5']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image3" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img5)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn5 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    $data = [];
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $cur_date2 = date("d-m-Y");
                    $txn_id = mt_rand(999999, 999999999999);
                    $data = array(
                        'farmer_id' => $farmer_data[0]->id,
                        'is_expert' => $is_expert,
                        'doctor_id' => $doctor_id,
                        'reason' => $reason,
                        'description' => $description,
                        'fees' => $fees,
                        'payment_status' => 0,
                        'status' => 0,
                        'image1' => $nnnn,
                        'image2' => $nnnn2,
                        'image3' => $nnnn3,
                        'image4' => $nnnn4,
                        'image5' => $nnnn5,
                        'req_date' => $cur_date2,
                        'txn_id' => $txn_id,
                        'date' => $cur_date,
                        'gateway' => 'CC Avenue',
                    );
                    $req_id = $this->base_model->insert_table("tbl_doctor_req", $data, 1);
                    $docData = $this->db->get_where('tbl_doctor', array('id' => $doctor_id,))->result();
                    $success = base_url() . 'ApiControllers/ToolsController/doctor_payment_success';
                    $fail = base_url() . 'ApiControllers/ToolsController/payment_failed';
                    $post = array(
                        'txn_id' => '',
                        'merchant_id' => MERCHAND_ID,
                        'order_id' => $txn_id,
                        'amount' => $fees,
                        'currency' => "INR",
                        'redirect_url' => $success,
                        'cancel_url' => $fail,
                        'billing_name' => $farmer_data[0]->name,
                        'billing_address' => $farmer_data[0]->village,
                        'billing_city' => $farmer_data[0]->city,
                        'billing_state' => $farmer_data[0]->state,
                        'billing_zip' => $farmer_data[0]->pincode,
                        'billing_country' => 'India',
                        'billing_tel' => $farmer_data[0]->phone,
                        'billing_email' => '',
                        'merchant_param1' => 'Doctor Payment',
                    );
                    $merchant_data = '';
                    $working_key = WORKING_KEY; //Shared by CCAVENUES
                    $access_code = ACCESS_CODE; //Shared by CCAVENUES
                    foreach ($post as $key => $value) {
                        $merchant_data .= $key . '=' . $value . '&';
                    }
                    $length = strlen(md5($working_key));
                    $binString = "";
                    $count = 0;
                    while ($count < $length) {
                        $subString = substr(md5($working_key), $count, 2);
                        $packedString = pack("H*", $subString);
                        if ($count == 0) {
                            $binString = $packedString;
                        } else {
                            $binString .= $packedString;
                        }
                        $count += 2;
                    }
                    $key = $binString;
                    $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
                    $openMode = openssl_encrypt($merchant_data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
                    $encrypted_data = bin2hex($openMode);
                    $send = array(
                        'order_id' => $req_id,
                        'access_code' => $access_code,
                        'redirect_url' => $success,
                        'cancel_url' => $fail,
                        'enc_val' => $encrypted_data,
                        'plain' => $merchant_data,
                        'merchant_param1' => 'Doctor Payment',
                    );
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $send,
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function phone_pe_request_doctor()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('doctor_id', 'doctor_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('is_expert', 'is_expert', 'required|xss_clean|trim');
            $this->form_validation->set_rules('reason', 'reason', 'xss_clean|trim');
            $this->form_validation->set_rules('description', 'description', 'xss_clean|trim');
            $this->form_validation->set_rules('fees', 'fees', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $doctor_id = $this->input->post('doctor_id');
                $is_expert = $this->input->post('is_expert');
                $reason = $this->input->post('reason');
                $description = $this->input->post('description');
                $fees = $this->input->post('fees');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    //=============================================IMAGE1 ====================================================//
                    $this->load->library('upload');
                    $img1 = 'image1';
                    $nnnn = '';
                    if (!empty($_FILES['image1'])) {
                        if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0) {
                            $file_check = ($_FILES['image1']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image1" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img1)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn = $videoNAmePath;
                                }
                            }
                        }
                    }
                    //===================================================IMAGE2====================================================//
                    $img2 = 'image2';
                    $nnnn2 = '';
                    if (!empty($_FILES['image2'])) {
                        if ($_FILES['image2']['size'] != 0 && $_FILES['image2']['error'] == 0) {
                            $file_check = ($_FILES['image2']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image2" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img2)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn2 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    //=======================================================IMAGE3===================================================//
                    $img3 = 'image3';
                    $nnnn3 = '';
                    if (!empty($_FILES['image3'])) {
                        if ($_FILES['image3']['size'] != 0 && $_FILES['image3']['error'] == 0) {
                            $file_check = ($_FILES['image3']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image3" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img3)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn3 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    //=======================================================IMAGE4======================================================//
                    $img4 = 'image4';
                    $nnnn4 = '';
                    if (!empty($_FILES['image4'])) {
                        if ($_FILES['image4']['size'] != 0 && $_FILES['image4']['error'] == 0) {
                            $file_check = ($_FILES['image4']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image3" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img4)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn4 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    //=======================================================IMAGE5======================================================//
                    $img5 = 'image5';
                    $nnnn5 = '';
                    if (!empty($_FILES['image5'])) {
                        if ($_FILES['image5']['size'] != 0 && $_FILES['image5']['error'] == 0) {
                            $file_check = ($_FILES['image5']['error']);
                            if ($file_check != 4) {
                                $image_upload_folder = FCPATH . "assets/uploads/export_doctor/";
                                if (!file_exists($image_upload_folder)) {
                                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                }
                                $new_file_name = "upload_image3" . date("YmdHis");
                                $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' => 'jpg|jpeg|png',
                                    'max_size'      => 25000
                                );
                                $this->upload->initialize($this->upload_config);
                                if (!$this->upload->do_upload($img5)) {
                                    $upload_error = $this->upload->display_errors();
                                    $this->session->set_flashdata('emessage', $upload_error);
                                    redirect($_SERVER['HTTP_REFERER']);
                                } else {
                                    $file_info = $this->upload->data();
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $file_info['file_name'];
                                    $nnnn5 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    $data = [];
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $cur_date2 = date("d-m-Y");
                    $txn_id = bin2hex(random_bytes(12));
                    $data = array(
                        'farmer_id' => $farmer_data[0]->id,
                        'is_expert' => $is_expert,
                        'doctor_id' => $doctor_id,
                        'reason' => $reason,
                        'description' => $description,
                        'fees' => $fees,
                        'payment_status' => 0,
                        'status' => 0,
                        'image1' => $nnnn,
                        'image2' => $nnnn2,
                        'image3' => $nnnn3,
                        'image4' => $nnnn4,
                        'image5' => $nnnn5,
                        'req_date' => $cur_date2,
                        'txn_id' => $txn_id,
                        'date' => $cur_date,
                        'gateway' => 'Phone Pe',
                    );
                    $req_id = $this->base_model->insert_table("tbl_doctor_req", $data, 1);
                    $docData = $this->db->get_where('tbl_doctor', array('id' => $doctor_id,))->result();
                    $success = base_url() . 'ApiControllers/ToolsController/phone_pe_doctor_payment_success';
                    $param1 = 'Doctor Payment';
                    $response = $this->initiate_phone_pe_payment($txn_id, $fees, $farmer_data[0]->phone, $success, $param1);
                    if ($response && $response->code == 'PAYMENT_INITIATED') {
                        $send = array(
                            'url' => $response->data->instrumentResponse->redirectInfo->url,
                            'redirect_url' => $success,
                            'merchant_param1' => $param1,
                            'order_id' => $req_id,
                        );
                        $res = array(
                            'message' => "Success!",
                            'status' => 200,
                            'data' => $send,
                        );
                        echo json_encode($res);
                    } else {
                        $res = array(
                            'message' => 'Some error occurred!',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function doctor_payment_success()
    {
        $encResponse = $this->input->post('encResp'); //This is the response sent by the CCAvenue Server
        log_message('error', $encResponse);
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        error_reporting(0);
        $workingKey = WORKING_KEY;        //Working Key should be provided here.
        $rcvdString = $this->decrypt($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $order_id = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3)    $order_status = $information[1];
            if ($i == 0) $txn_id = $information[1];
        }
        $data_insert = array(
            'body' => json_encode($decryptValues),
            'date' => $cur_date
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
        // echo $order_status;die();
        if ($order_status === "Success") {
            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $txn_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                $order_id = $order_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_doctor_req', $data_update);
                $docData = $this->db->get_where('tbl_doctor', array('id' => $order_data->doctor_id,))->result();
                //------ create amount txn in the table -------------
                if (!empty($docData[0]->commission)) {
                    $amt = $order_data->fees * $docData[0]->commission / 100;
                    $data2 = array(
                        'req_id' => $order_id,
                        'doctor_id' => $order_data->doctor_id,
                        'cr' =>  $order_data->fees - $amt,
                        'date' => $cur_date
                    );
                    $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                    //------ update doctor account ------
                    $data_update = array(
                        'account' => $docData[0]->account + $order_data->fees - $amt,
                    );
                    $this->db->where('id', $order_data->doctor_id);
                    $zapak = $this->db->update('tbl_doctor', $data_update);
                }
                //------ send notification to doctor -----
                if (!empty($docData[0]->fcm_token)) {
                    // echo $user_device_tokens->device_token;
                    //success notification code
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $title = "New Request";
                    $message = "New request #" . $order_id . "  received with the  amount of  ₹" . ($order_data->fees - $amt);
                    $msg2 = array(
                        'title' => $title,
                        'body' => $message,
                        "sound" => "default"
                    );
                    $fields = array(
                        // 'to'=>"/topics/all",
                        'to' => $docData[0]->fcm_token,
                        'notification' => $msg2,
                        'priority' => 'high'
                    );
                    $fields = json_encode($fields);
                    $headers = array(
                        'Authorization: key=' . "AAAAAIDR4rw:APA91bHaVxhjsODWyIDSiQXCpBhC46GL-9Ycxa9VKwtsPefjLy6NfiiLsajh8db55tRrIOag_A9wh9iXREo2-Obbt1U-fdHmpjy3zvgvTWFleqY5S_8dJtoYz0uKxPRZ76E3sXpgjISv",
                        'Content-Type: application/json'
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    $result = curl_exec($ch);
                    // echo $fields;
                    // echo $result;
                    curl_close($ch);
                    //End success notification code
                    $data_insert = array(
                        'doctor_id' => $order_data->doctor_id,
                        'name' => $title,
                        'dsc' => $message,
                        'date' => $cur_date
                    );
                    $last_id = $this->base_model->insert_table("tbl_doctor_notification", $data_insert, 1);
                }
                echo 'Success';
                exit;
            }
        } else if ($order_status === "Failure") {
            echo 'Failure';
            exit;
        } else {
            echo 'Aborted';
        }
    }
    public function phone_pe_doctor_payment_success()
    {
        $body = $_POST;
        // Takes raw data from the request
        date_default_timezone_set("Asia/Calcutta");
        $ip = $this->input->ip_address();
        $cur_date = date("Y-m-d H:i:s");
        // Converts it into a PHP object
        $data = json_encode($body);
        $data_insert = array(
            'body' => $data,
            'date' => $cur_date,
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");

        $response = $this->verify_phone_pe_payment($body);
        if ($response->code == 'PAYMENT_SUCCESS') {
            $txn_id = $response->data->merchantTransactionId;
            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $txn_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                $order_id = $order_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($body),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_doctor_req', $data_update);
                $docData = $this->db->get_where('tbl_doctor', array('id' => $order_data->doctor_id,))->result();
                //------ create amount txn in the table -------------
                if (!empty($docData[0]->commission)) {
                    $amt = $order_data->fees * $docData[0]->commission / 100;
                    $data2 = array(
                        'req_id' => $order_id,
                        'doctor_id' => $order_data->doctor_id,
                        'cr' =>  $order_data->fees - $amt,
                        'date' => $cur_date
                    );
                    $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                    //------ update doctor account ------
                    $data_update = array(
                        'account' => $docData[0]->account + $order_data->fees - $amt,
                    );
                    $this->db->where('id', $order_data->doctor_id);
                    $zapak = $this->db->update('tbl_doctor', $data_update);
                }
                //------ send notification to doctor -----
                if (!empty($docData[0]->fcm_token)) {
                    // echo $user_device_tokens->device_token;
                    //success notification code
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $title = "New Request";
                    $message = "New request #" . $order_id . "  received with the  amount of  ₹" . ($order_data->fees - $amt);
                    $msg2 = array(
                        'title' => $title,
                        'body' => $message,
                        "sound" => "default"
                    );
                    $fields = array(
                        // 'to'=>"/topics/all",
                        'to' => $docData[0]->fcm_token,
                        'notification' => $msg2,
                        'priority' => 'high'
                    );
                    $fields = json_encode($fields);
                    $headers = array(
                        'Authorization: key=' . "AAAAAIDR4rw:APA91bHaVxhjsODWyIDSiQXCpBhC46GL-9Ycxa9VKwtsPefjLy6NfiiLsajh8db55tRrIOag_A9wh9iXREo2-Obbt1U-fdHmpjy3zvgvTWFleqY5S_8dJtoYz0uKxPRZ76E3sXpgjISv",
                        'Content-Type: application/json'
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    $result = curl_exec($ch);
                    // echo $fields;
                    // echo $result;
                    curl_close($ch);
                    //End success notification code
                    $data_insert = array(
                        'doctor_id' => $order_data->doctor_id,
                        'name' => $title,
                        'dsc' => $message,
                        'date' => $cur_date
                    );
                    $last_id = $this->base_model->insert_table("tbl_doctor_notification", $data_insert, 1);
                }
                echo 'Success';
                exit;
            }
        } else {
            echo $response->code;
        }
    }
    public function VerifyDoctorPayment($order_id)
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $req_data = $this->db->get_where('tbl_doctor_req', array('id' => $order_id, 'farmer_id' => $farmer_data[0]->id, 'payment_status' => 1))->result();
            if (!empty($req_data)) {
                $send = array(
                    'order_id' => $req_data[0]->id,
                    'amount' => $req_data[0]->fees,
                );
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => $send,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => 'Please Check Manually!',
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Permission Denied!',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== Vendors ================================================//
    public function GetVendors()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('latitude', 'latitude', 'required|xss_clean|trim');
            $this->form_validation->set_rules('longitude', 'longitude', 'required|xss_clean|trim');
            $this->form_validation->set_rules('radius', 'radius', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $radius = $this->input->post('radius');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $vendorData = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1))->result();
                    $en_data = [];
                    $hi_data = [];
                    $pn_data = [];
                    foreach ($vendorData as $vendor) {
                        if ((!empty($vendor->latitude) && !empty($vendor->longitude))) {


                            $km = $this->distance($latitude, $longitude, $vendor->latitude, $vendor->longitude);
                            $distance = $km / 1000;
                            
                            // echo $km;
                            // exit();
                            // echo "<br>";
                            if ($distance <= $radius && $radius <= 60) {
                                // echo 'Kilo meter = ' .$km. ' Radius = '.$radius;
                                // exit();
                                $state_data = $this->db->get_where('all_states', array('id' =>  $vendor->state))->result();
                                $en_data[] = array(
                                    'vendor_id' => $vendor->id,
                                    'name' => $vendor->name,
                                    'shop_name' => $vendor->shop_name,
                                    'address' => $vendor->address,
                                    'district' => $vendor->district,
                                    'city' => $vendor->city,
                                    'state' => $state_data[0]->state_name,
                                    'pincode' => $vendor->pincode,
                                    'km' => $distance,
                                );
                                $hi_data[] = array(
                                    'vendor_id' => $vendor->id,
                                    'name' => $vendor->hi_name,
                                    'shop_name' => $vendor->shop_hi_name,
                                    'address' => $vendor->hi_address,
                                    'district' => $vendor->hi_district,
                                    'city' => $vendor->hi_city,
                                    'state' => $state_data[0]->state_name,
                                    'pincode' => $vendor->pincode,
                                    'km' => $distance,
                                );
                                $pn_data[] = array(
                                    'vendor_id' => $vendor->id,
                                    'name' => $vendor->pn_name,
                                    'shop_name' => $vendor->shop_pn_name,
                                    'address' => $vendor->pn_address,
                                    'district' => $vendor->pn_district,
                                    'city' => $vendor->pn_city,
                                    'state' => $state_data[0]->state_name,
                                    'pincode' => $vendor->pincode,
                                    'km' => $distance,
                                );
                                // echo('here is not data');
                                // exit();
                            }
                            // else
                            // {
                               
                            // }
                        }
                    }
                    $data = array(
                        'en' => $en_data,
                        'hi' => $hi_data,
                        'pn' => $pn_data,
                    );
                    $res = array(
                        'message' => "Success",
                        'status' => 200,
                        'data' => $data
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function encrypt($plainText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }
    /*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
    public function decrypt($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }
    public function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }
            $count += 2;
        }
        return $binString;
    }
    public function payment_failed()
    {
        $encResponse = $this->input->post('encResp'); //This is the response sent by the CCAvenue Server
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        error_reporting(0);
        $workingKey = WORKING_KEY;            //Working Key should be provided here.
        $rcvdString = $this->decrypt($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3)    $order_status = $information[1];
        }
        $data_insert = array(
            'body' => json_encode($decryptValues),
            'date' => $cur_date
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
    }
    // ====================== START PHONE PE INITIATE PAYMENT ==================================
    public function initiate_phone_pe_payment($txn_id, $amount, $phone, $redirect_url, $param1 = '')
    {
        $payload = array(
            "merchantId" => PHONE_PE_MERCHANT_ID,
            "merchantTransactionId" => $txn_id,
            "merchantUserId" => "MUID123",
            'amount' => $amount * 100,
            "redirectUrl" => $redirect_url,
            "callbackUrl" => $redirect_url,
            "mobileNumber" => $phone,
            "redirectMode" => "POST",
        );
        $url = PHONE_PE_URL . '/pg/v1/pay';
        $json = json_encode($payload);
        $payload = json_decode($json);
        $payload->paymentInstrument = new stdClass();
        $payload->paymentInstrument->type = "PAY_PAGE";

        // print_r($payload);die();
        $jsonPayload = json_encode($payload);
        $encode_jsonPayload = base64_encode($jsonPayload);
        $verifyHeader = hash('sha256', $encode_jsonPayload . '/pg/v1/pay' . PHONE_PE_SALT) . '###' . PHONE_PE_SALT_INDEX;
        $request_json = new stdClass();
        $request_json->request = $encode_jsonPayload;
        // Set up cURL
        $ch = curl_init();
        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-VERIFY: ' . $verifyHeader,
        ]);

        // Execute the cURL request and store the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        // Close the cURL session
        curl_close($ch);

        // Print the response

        return json_decode($response);
    }
    // ====================== START PHONE PE INITIATE PAYMENT ==================================
    public function verify_phone_pe_payment($body)
    {

        if ($body['code'] == 'PAYMENT_SUCCESS') {
            $url = PHONE_PE_URL . '/pg/v1/status/' . PHONE_PE_MERCHANT_ID . '/' . $body['transactionId'] . '';
            $verifyHeader = hash('sha256', '/pg/v1/status/' . PHONE_PE_MERCHANT_ID . '/' . $body['transactionId'] . PHONE_PE_SALT) . '###' . PHONE_PE_SALT_INDEX;
            $ch = curl_init();
            // Set the cURL options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-VERIFY: ' . $verifyHeader,
                'X-MERCHANT-ID: ' . PHONE_PE_MERCHANT_ID,
            ]);

            // Execute the cURL request and store the response
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                echo 'cURL Error: ' . curl_error($ch);
            }

            // Close the cURL session
            curl_close($ch);

            // Print the response
            // echo $response;
            return json_decode($response);
            // $res = json_decode($response);
            // return $res->code;
            // if ($res->code == 'PAYMENT_SUCCESS') {
            //    return $res->code;
            // } else {
            //     // redirect('web/checkout');
            // }
        }
    }
    //=======================================================HomeData===============================================//
    public function expertCategory()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists("Lang", $headers)) {
            $language = $headers['Lang'];
        } else {
            $language = 'en';
        }
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            //---- Categoryslider data -------
            $CategorySlider_data = $this->db->get_where('tbl_expertise_category', array('is_active' => 1))->result();
            $CategoryData = [];
            foreach ($CategorySlider_data as $category) {
                if ($language == 'en') {
                    $cat_image =  $category->image ? base_url() . $category->image : '';
                } elseif ($language == 'hi') {
                    $cat_image =  $category->image_hindi ? base_url() . $category->image_hindi : '';
                } else {
                    $cat_image =  $category->image_punjabi ? base_url() . $category->image_punjabi : '';
                    '';
                }
                $CategoryData[] = array(
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $cat_image,
                );
            }
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $CategoryData
            );
            echo json_encode($res);
        } else {
            $res = array(
                'message' => 'Permission Denied!',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
}
  //====================================================== END TOOLSCONTROLLER================================================//
