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
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
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
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
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
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
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
    public function AllProducts($is_admin, $vendor_id = "")
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $limit = 20;
            if (!empty($page_index)) {
                $start = ($page_index - 1) * $limit;
            } else {
                $start = 0;
            }
            if ($is_admin == 'admin') {
                $count = $this->db->get_where('tbl_products', array('is_active' => 1, 'is_admin' => 1))->num_rows();
                $ProData = $this->db->limit($limit, $start)->get_where('tbl_products', array('is_active' => 1, 'is_admin' => 1))->result();
            } else {
                $count = $this->db->get_where('tbl_products', array('is_active' => 1, 'is_admin' => 0, 'added_by' => $vendor_id))->num_rows();
                $ProData = $this->db->limit($limit, $start)->get_where('tbl_products', array('is_active' => 1, 'is_admin' => 0, 'added_by' => $vendor_id))->result();
            }
            $pages = round($count / $limit);
            $pagination = $this->CreatePagination($page_index, $pages);
            $data = [];
            foreach ($ProData as $pro) {
                if (!empty($pro->image)) {
                    $image = base_url() . $pro->image;
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
                $data[] = array(
                    'pro_id' => $pro->id,
                    'name_english' => $pro->name_english,
                    'name_hindi' => $pro->name_hindi,
                    'name_punjabi' => $pro->name_punjabi,
                    'description_english' => $pro->description_english,
                    'description_hindi' => $pro->description_hindi,
                    'description_punjabi' => $pro->description_punjabi,
                    'image' => $image,
                    'mrp' => $pro->mrp,
                    'selling_price' => $pro->selling_price,
                    'suffix' => $pro->suffix,
                    'stock' => $stock,
                    'percent' => $percent,
                    'vendor_id' => $pro->added_by,
                    'is_admin' => $pro->is_admin
                );
            }
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
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
    }
    //------ Distance calculator ---------
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return (round($miles * 1.609344, 2));
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
                    $data = [];
                    foreach ($DoctorData as $doctor) {
                        if (!empty($doctor->latitude) && !empty($doctor->latitude)) {
                            $km = $this->distance($latitude, $longitude, $doctor->latitude, $doctor->longitude);
                            // echo $km;
                            // echo "<br>";
                            // if ($km <= $radius) {
                            if (!empty($doctor->image)) {
                                $image = base_url() . $doctor->image;
                            } else {
                                $image = '';
                            }
                            $data[] = array(
                                'id' => $doctor->id,
                                'name' => $doctor->name,
                                'email' => $doctor->email,
                                'degree' => $doctor->degree,
                                'phone' => $doctor->phone,
                                'type' => $doctor->type,
                                'image' => $image
                            );
                            // }
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
    public function expert_advice()
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
                    $DoctorData = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'is_expert' => 1))->result();
                    $data = [];
                    foreach ($DoctorData as $doctor) {
                        if (!empty($doctor->latitude) && !empty($doctor->latitude)) {
                            $km = $this->distance($latitude, $longitude, $doctor->latitude, $doctor->longitude);
                            // echo $km;
                            // echo "<br>";
                            // if ($km <= $radius) {
                            if (!empty($doctor->image)) {
                                $image = base_url() . $doctor->image;
                            } else {
                                $image = '';
                            }
                            $data[] = array(
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
                                'state' => $doctor->state,
                                'image' => $image
                            );
                            // }
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
                                $new_file_name = "upload_image1" . date("Ymdhms");
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
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $new_file_name . $file_info['file_ext'];
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
                                $new_file_name = "upload_image2" . date("Ymdhms");
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
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $new_file_name . $file_info['file_ext'];
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
                                $new_file_name = "upload_image3" . date("Ymdhms");
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
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $new_file_name . $file_info['file_ext'];
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
                                $new_file_name = "upload_image3" . date("Ymdhms");
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
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $new_file_name . $file_info['file_ext'];
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
                                $new_file_name = "upload_image3" . date("Ymdhms");
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
                                    $videoNAmePath = "assets/uploads/export_doctor/" . $new_file_name . $file_info['file_ext'];
                                    $nnnn5 = $videoNAmePath;
                                }
                            }
                        }
                    }
                    $data = [];
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $data = array(
                        'farmer_id' => $farmer_data[0]->id,
                        'is_expert' => $is_expert,
                        'doctor_id' => $doctor_id,
                        'reason' => $reason,
                        'description' => $description,
                        'fees' => $fees,
                        'payment_status' => 1,
                        'status' => 0,
                        'image1' => $nnnn,
                        'image2' => $nnnn2,
                        'image3' => $nnnn3,
                        'image4' => $nnnn4,
                        'image5' => $nnnn5,
                        'date' => $cur_date
                    );
                    $last_id = $this->base_model->insert_table("tbl_doctor_req", $data, 1);
                    $docData = $this->db->get_where('tbl_doctor', array('id' => $doctor_id,))->result();
                    //------ create amount txn in the table -------------
                    if (!empty($docData[0]->commission)) {
                        $amt = $fees * $docData[0]->commission / 100;
                        $data2 = array(
                            'req_id' => $last_id,
                            'doctor_id' => $doctor_id,
                            'cr' => $amt,
                            'date' => $cur_date
                        );
                        $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                        //------ update doctor account ------
                        $data_update = array(
                            'account' => $docData[0]->account + $amt,
                        );
                        $this->db->where('id', $doctor_id);
                        $zapak = $this->db->update('tbl_doctor', $data_update);
                    }
                    $send = array(
                        'order_id' => $last_id,
                        'amount' => $fees,
                    );
                    $res = array(
                        'message' => "Success",
                        'status' => 200,
                        'data' => $send
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
                    $data = [];
                    foreach ($vendorData as $vendor) {
                        $km = $this->distance($latitude, $longitude, $vendor->latitude, $vendor->longitude);
                        // echo $km;
                        // echo "<br>";
                        // if ($km <= $radius) {
                        $data[] = array(
                            'vendor_id' => $vendor->id,
                            'name' => $vendor->name,
                            'shop_name' => $vendor->shop_name,
                            'address' => $vendor->address,
                            'district' => $vendor->district,
                            'city' => $vendor->city,
                            'state' => $vendor->state,
                            'pincode' => $vendor->pincode,
                        );
                        // }
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
}
  //====================================================== END TOOLSCONTROLLER================================================//
