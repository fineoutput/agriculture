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
    //====================================================== SILAGE MAKING================================================//
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
                    $data['number_of_cows'] = 50;
                    $message = $this->load->view('pdf/25_cows', $data, true);
                    // $data = array(
                    //     'silage_qty_required' => $silage_qty_required,
                    //     'pit_vol_required' => $pit_vol_required,
                    //     'length' => $length,
                    //     'fodder_required' => $fodder_required,
                    // );
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
        $data['number_of_cows'] = 50;
        require_once APPPATH . "/third_party/PHPExcel.php"; //------ INCLUDE EXCEL
        //-------- start excel read and insert into db
        $inputFileName = 'assets/excel/25_cows.xlsx';
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
            PHPExcel_Calculation::getInstance($objPHPExcel)->disableCalculationCache();
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
        //  Get worksheet dimensions
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B9', '50');
        // // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('B9')->getValue());
        // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C12')->getFormattedValue());
        $data['objPHPExcel'] = $objPHPExcel;
        $data['C12'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C12')->getFormattedValue();
        $data['C13'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C13')->getFormattedValue();
        $data['C14'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C14')->getFormattedValue();
        //----------//
        $data['C15'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C15')->getFormattedValue();
        $data['D15'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('D15')->getFormattedValue();
        $data['E15'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('E15')->getFormattedValue();
        $data['F15'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('F15')->getFormattedValue();
        $data['G15'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('G15')->getFormattedValue();
        $data['H15'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('H15')->getFormattedValue();
        //----------//
        $data['C16'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C16')->getFormattedValue();
        $data['D16'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('D16')->getFormattedValue();
        $data['E16'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('E16')->getFormattedValue();
        $data['F16'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('F16')->getFormattedValue();
        $data['G16'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('G16')->getFormattedValue();
        $data['H16'] = $objPHPExcel->setActiveSheetIndex(0)->getCell('H16')->getFormattedValue();
        // //  Loop through each row of the worksheet in turn
        // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('B9')->getValue());
        // echo "<br/>";
        // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('C12')->getFormattedValue());
        // echo "<br/>";
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B9', '49');
        // print_r($dataset[] = $objPHPExcel->setActiveSheetIndex(0)->getCell('B9')->getValue());
        // die();
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
    //====================================================== DAIRY MART ================================================//
    public function dairy_mart()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $ProData = $this->db->get_where('tbl_products', array('is_active' => 1))->result();
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
                    'vendor_id' => $pro->added_by
                );
            }
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
    }
    //------ Distance calculator ---------
    function distance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return ($miles * 1.609344);
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
            $this->form_validation->set_rules('$lat1', '$lat1', 'required|xss_clean|trim');
            $this->form_validation->set_rules('$lon1', '$lon1', 'required|xss_clean|trim');
            $this->form_validation->set_rules('$lat2', '$lat2', 'required|xss_clean|trim');
            $this->form_validation->set_rules('$lon2', '$lon2', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $lat1 = $this->input->post('lat1');
                $lon1 = $this->input->post('lon1');
                $lat2 = $this->input->post('lat2');
                $lon2 = $this->input->post('lon2');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $City_data = $this->db->get_where('tbl_doctor', array('is_active2' => 0))->result();
                    $data = [];
                    foreach ($City_data as $DOCTOR) {
                        if (!empty($DOCTOR->image)) {
                            $image = base_url() . $DOCTOR->image;
                        } else {
                            $image = '';
                        }
                        $data[] = array(
                            'name_english' => $DOCTOR->name_english,
                            'name_hindi' => $DOCTOR->name_hindi,
                            'name_punjabi' => $DOCTOR->name_punjabi,
                            'email' => $DOCTOR->email,
                            'degree_english' => $DOCTOR->degree_english,
                            'degree_hindi' => $DOCTOR->degree_hindi,
                            'degree_punjabi' => $DOCTOR->degree_punjabi,
                            'image' => $image
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
        $Expert_data = $this->db->get_where('tbl_doctor', array('is_active2' => 1))->result();
        $data = [];
        foreach ($Expert_data as $Expert) {
            if (!empty($Expert->image)) {
                $image = base_url() . $Expert->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name_english' => $Expert->name_english,
                'name_hindi' => $Expert->name_hindi,
                'name_punjabi' => $Expert->name_punjabi,
                'email' => $Expert->email,
                'type' => $Expert->type,
                'degree_english' => $Expert->degree_english,
                'degree_hindi' => $Expert->degree_hindi,
                'degree_punjabi' => $Expert->degree_punjabi,
                'education_qualification' => $Expert->education_qualification,
                'city' => $Expert->city,
                'state' => $Expert->state,
                'phone_number' => $Expert->phone_number,
                'image' => $Expert->image
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== RADIUS VENDOR================================================//
    public function radius_vendor()
    {
        $Vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 0))->result();
        $data = [];
        foreach ($Vendor_data as $Vendor) {
            $data[] = array(
                'name_english' => $Vendor->name_english,
                'name_hindi' => $Vendor->name_hindi,
                'name_punjabi' => $Vendor->name_punjabi,
                'shop_name_english' => $Vendor->shop_name_english,
                'shop_name_hindi' => $Vendor->shop_name_hindi,
                'shop_name_punjabi' => $Vendor->shop_name_punjabi,
                'address_english' => $Vendor->address_english,
                'address_hindi' => $Vendor->address_hindi,
                'address_punjabi' => $Vendor->address_punjabi,
                'district_english' => $Vendor->district_english,
                'district_hindi' => $Vendor->district_hindi,
                'district_punjabi' => $Vendor->district_punjabi,
                'city' => $Vendor->city,
                'state' => $Vendor->state,
                'pincode' => $Vendor->pincode
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
}
  //====================================================== END TOOLSCONTROLLER================================================//
