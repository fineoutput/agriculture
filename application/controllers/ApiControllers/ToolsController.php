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
    public function request_expert_doctor()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('reason', 'reason', 'required|xss_clean|trim');
            $this->form_validation->set_rules('description', 'description', 'required|xss_clean|trim');
            $this->form_validation->set_rules('fees', 'fees', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
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
                        'information_type' => $reason,
                        'animal_name' => $description,
                        'fees' => $fees,
                        'payment_status' => 0,
                        'status' => 0,
                        'image1' => $nnnn,
                        'image2' => $nnnn2,
                        'image3' => $nnnn3,
                        'image4' => $nnnn4,
                        'image5' => $nnnn5,
                        'date' => $cur_date
                    );
                    $last_id = $this->base_model->insert_table("tbl_expert_doctor_req", $data, 1);
                    $res = array(
                        'message' => "Success",
                        'status' => 200,
                        'data' => $last_id
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
