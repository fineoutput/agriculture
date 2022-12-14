<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Managementcontroller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }
    //====================================================DAILY RECORDS==========================================//
    public function daily_records()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {

            $this->form_validation->set_rules('farmer_id', 'farmer_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('date', 'date', 'required|xss_clean|trim');
            $this->form_validation->set_rules('green_forage', 'green_forage', 'required|xss_clean|trim');
            $this->form_validation->set_rules('silage', 'silage', 'required|xss_clean|trim');
            $this->form_validation->set_rules('dry_fodder', 'dry_fodder', 'required|xss_clean|trim');
            $this->form_validation->set_rules('cake', 'cake', 'required|xss_clean|trim');
            $this->form_validation->set_rules('grains', 'grains', 'required|xss_clean|trim');
            $this->form_validation->set_rules('biproducts', 'biproducts', 'required|xss_clean|trim');
            $this->form_validation->set_rules('churi', 'churi', 'required|xss_clean|trim');
            $this->form_validation->set_rules('oil_seeds', 'oil_seeds', 'required|xss_clean|trim');
            $this->form_validation->set_rules('feed', 'feed', 'required|xss_clean|trim');
            $this->form_validation->set_rules('minerals', 'minerals', 'required|xss_clean|trim');
            $this->form_validation->set_rules('btpass_fat', 'btpass_fat', 'required|xss_clean|trim');
            $this->form_validation->set_rules('tocins', 'tocins', 'required|xss_clean|trim');
            $this->form_validation->set_rules('buffer', 'buffer', 'required|xss_clean|trim');
            $this->form_validation->set_rules('yeast', 'yeast', 'required|xss_clean|trim');
            $this->form_validation->set_rules('milk_records', 'milk_records', 'required|xss_clean|trim');
            $this->form_validation->set_rules('pregnancy_care', 'pregnancy_care', 'required|xss_clean|trim');
            $this->form_validation->set_rules('animal_purchase', 'animal_purchase', 'required|xss_clean|trim');
            $this->form_validation->set_rules('labour_cost', 'labour_cost', 'required|xss_clean|trim');
            $this->form_validation->set_rules('farm_equipments', 'farm_equipments', 'required|xss_clean|trim');
            $this->form_validation->set_rules('others1', 'others1', 'required|xss_clean|trim');
            $this->form_validation->set_rules('others2', 'others2', 'required|xss_clean|trim');
            $this->form_validation->set_rules('others3', 'others3', 'required|xss_clean|trim');
            $this->form_validation->set_rules('others4', 'others4', 'required|xss_clean|trim');
            $this->form_validation->set_rules('others5', 'others5', 'required|xss_clean|trim');

            if ($this->form_validation->run() == true) {
                $date = $this->input->post('date');
                $green_forage = $this->input->post('green_forage');
                $silage = $this->input->post('silage');
                $dry_fodder = $this->input->post('dry_fodder');
                $cake = $this->input->post('cake');
                $grains = $this->input->post('grains');
                $biproducts = $this->input->post('biproducts');
                $churi = $this->input->post('churi');
                $oil_seeds = $this->input->post('oil_seeds');
                $feed = $this->input->post('feed');
                $minerals = $this->input->post('minerals');
                $btpass_fat = $this->input->post('btpass_fat');
                $tocins = $this->input->post('tocins');
                $buffer = $this->input->post('buffer');
                $yeast = $this->input->post('yeast');
                $milk_records = $this->input->post('milk_records');
                $pregnancy_care = $this->input->post('pregnancy_care');
                $animal_purchase = $this->input->post('animal_purchase');
                $labour_cost = $this->input->post('labour_cost');
                $farm_equipments = $this->input->post('farm_equipments');

                $others1 = $this->input->post('others1');
                $others2 = $this->input->post('others2');
                $others3 = $this->input->post('others3');
                $others4 = $this->input->post('others4');
                $others5 = $this->input->post('others5');




                $data = [];
                $data = array(
                    'date' => $date,

                    //    'tag_no'=>$tag_no,
                    'green_forage' => $green_forage,
                    'silage' => $silage,
                    'dry_fodder' => $dry_fodder,
                    'cake' => $cake,
                    'grains' => $grains,
                    'biproducts' => $biproducts,
                    'churi' => $churi,
                    'oil_seeds' => $oil_seeds,
                    'feed' => $feed,
                    'minerals' => $minerals,
                    'btpass_fat' => $btpass_fat,
                    'tocins' => $tocins,
                    'buffer' => $buffer,
                    'yeast' => $yeast,
                    'milk_records' => $milk_records,
                    'pregnancy_care' => $pregnancy_care,
                    'animal_purchase' => $animal_purchase,
                    'labour_cost' => $labour_cost,
                    'farm_equipments' => $farm_equipments,

                    'others1' => $others1,
                    'others2' => $others2,
                    'others3' => $others3,
                    'others4' => $others4,
                    'others5' => $others5,


                );

                $last_id = $this->base_model->insert_table("tbl_daily_records", $data, 1);

                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => []
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'please insert data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================MILK RECORDING==========================================================//
    public function milk_records()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {

            $this->form_validation->set_rules('farmer_id', 'farmer_id', 'xss_clean|trim');
            $this->form_validation->set_rules('date', 'date', 'xss_clean|trim');
            $this->form_validation->set_rules('entry_milk', 'entry_milk', 'xss_clean|trim');
            $this->form_validation->set_rules('price_milk', 'price_milk', 'xss_clean|trim');
            $this->form_validation->set_rules('fat', 'fat', 'xss_clean|trim');
            $this->form_validation->set_rules('snf', 'snf', 'xss_clean|trim');
            $this->form_validation->set_rules('group_id', 'group_id', 'xss_clean|trim');
            $this->form_validation->set_rules('animal', 'animal', 'xss_clean|trim');


            if ($this->form_validation->run() == true) {
                $date = $this->input->post('date');
                $entry_milk = $this->input->post('entry_milk');
                $price_milk = $this->input->post('price_milk');
                $fat = $this->input->post('fat');
                $snf = $this->input->post('snf');
                $group_id = $this->input->post('group_id');
                $animal = $this->input->post('animal');




                $data = [];
                $data = array(
                    'date' => $date,

                    //    'tag_no'=>$tag_no,
                    'entry_milk' => $entry_milk,
                    'price_milk' => $price_milk,
                    'fat' => $fat,
                    'snf' => $snf,
                    'group_id' => $group_id,
                    'animal' => $animal,


                );

                $last_id = $this->base_model->insert_table("tbl_milk_records", $data, 1);

                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => []
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'please insert data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //=========================================================MEDICAL EXPENSES=========================================//
    public function medical_expenses()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {

            $this->form_validation->set_rules('farmer_id', 'farmer_id', 'xss_clean|trim');
            $this->form_validation->set_rules('date', 'date', 'xss_clean|trim');
            $this->form_validation->set_rules('entry_milk', 'entry_milk', 'xss_clean|trim');
            $this->form_validation->set_rules('price_milk', 'price_milk', 'xss_clean|trim');
            $this->form_validation->set_rules('fat', 'fat', 'xss_clean|trim');
            $this->form_validation->set_rules('snf', 'snf', 'xss_clean|trim');
            $this->form_validation->set_rules('group_id', 'group_id', 'xss_clean|trim');
            $this->form_validation->set_rules('animal', 'animal', 'xss_clean|trim');

            if ($this->form_validation->run() == true) {
                $date = $this->input->post('date');
                $doctor_fess = $this->input->post('doctor_fess');
                $treatment_expenses = $this->input->post('treatment_expenses');
                $vaccination_expenses = $this->input->post('vaccination_expenses');
                $deworming_expenses = $this->input->post('deworming_expenses');


                $others1 = $this->input->post('others1');
                $others2 = $this->input->post('others2');
                $others3 = $this->input->post('others3');
                $others4 = $this->input->post('others4');
                $others5 = $this->input->post('others5');




                $data = [];
                $data = array(
                    'date' => $date,

                    //    'tag_no'=>$tag_no,
                    'doctor_fess' => $doctor_fess,
                    'treatment_expenses' => $treatment_expenses,
                    'vaccination_expenses' => $vaccination_expenses,
                    'deworming_expenses' => $deworming_expenses,


                    'others1' => $others1,
                    'others2' => $others2,
                    'others3' => $others3,
                    'others4' => $others4,
                    'others5' => $others5,


                );

                $last_id = $this->base_model->insert_table("tbl_medical_expenses", $data, 1);

                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => []
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'please insert data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //==========================================================REPORTS=================================================//
    public function reports()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {

            $this->form_validation->set_rules('farmer_id', 'farmer_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('date', 'date', 'required|xss_clean|trim');
            $this->form_validation->set_rules('sale', 'sale', 'required|xss_clean|trim');
            $this->form_validation->set_rules('purchase', 'purchase', 'required|xss_clean|trim');
            $this->form_validation->set_rules('profit', 'profit', 'required|xss_clean|trim');
            $this->form_validation->set_rules('feed_expense', 'feed_expense', 'required|xss_clean|trim');


            $this->form_validation->set_rules('milk_income', 'milk_income', 'required|xss_clean|trim');
            $this->form_validation->set_rules('breeding_income', 'breeding_income', 'required|xss_clean|trim');
            $this->form_validation->set_rules('animal_expense', 'animal_expense', 'required|xss_clean|trim');
            $this->form_validation->set_rules('animal_income', 'animal_income', 'required|xss_clean|trim');


            if ($this->form_validation->run() == true) {
                $date = $this->input->post('date');
                $sale = $this->input->post('sale');
                $purchase = $this->input->post('purchase');
                $profit = $this->input->post('profit');
                $feed_expense = $this->input->post('feed_expense');
                $milk_income = $this->input->post('milk_income');
                $breeding_income = $this->input->post('breeding_income');
                $animal_expense = $this->input->post('animal_expense');
                $animal_income = $this->input->post('animal_income');

                $data = [];
                $data = array(
                    'date' => $date,

                    'sale' => $sale,
                    'purchase' => $purchase,
                    'profit' => $profit,
                    'feed_expense' => $feed_expense,
                    'milk_income' => $milk_income,
                    'breeding_income' => $breeding_income,
                    'animal_expense' => $animal_expense,
                    'animal_income' => $animal_income,

                );

                $last_id = $this->base_model->insert_table("tbl_reports", $data, 1);

                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => []
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'please insert data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //=========================================================SALE PURCHASE============================================//
    public function sale_purchase()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {

            $this->form_validation->set_rules('animal_name', 'animal_name', 'xss_clean|trim');
            $this->form_validation->set_rules('milk_production', 'milk_production', 'xss_clean|trim');
            $this->form_validation->set_rules('lactation', 'lactation', 'xss_clean|trim');
            $this->form_validation->set_rules('price', 'price', 'xss_clean|trim');
            $this->form_validation->set_rules('location', 'location', 'xss_clean|trim');
            $this->form_validation->set_rules('parturate_pregnant', 'parturate_pregnant', 'xss_clean|trim');
            $this->form_validation->set_rules('expected_price', 'expected_price', 'xss_clean|trim');


            if ($this->form_validation->run() == true) {
                $animal_name = $this->input->post('animal_name');
                $milk_production = $this->input->post('milk_production');
                $lactation = $this->input->post('lactation');
                $price = $this->input->post('price');
                $location = $this->input->post('location');
                $parturate_pregnant = $this->input->post('parturate_pregnant');
                $expected_price = $this->input->post('expected_price');
                $animal_expense = $this->input->post('animal_expense');
                //================================IMAGE UPLODE BANNER==================================//

                $this->load->library('upload');
                $img1 = 'image1';
                $nnnn = '';
                $file_check = ($_FILES['image1']['error']);
                if ($file_check != 4) {
                    $image_upload_folder = FCPATH . "assets/uploads/sales/";
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
                        $videoNAmePath = "assets/uploads/sales/" . $new_file_name . $file_info['file_ext'];
                        $nnnn = $videoNAmePath;
                    }
                }
                //===================================================IMAGE2==================================================//
                $img2 = 'image2';
                $nnnn2 = '';
                $file_check = ($_FILES['image2']['error']);
                if ($file_check != 4) {
                    $image_upload_folder = FCPATH . "assets/uploads/sales/";
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
                        $videoNAmePath = "assets/uploads/sales/" . $new_file_name . $file_info['file_ext'];
                        $nnnn2 = $videoNAmePath;
                    }
                }

                //=======================================================IMAGE3=======================================================//
                $img3 = 'image3';
                $nnnn3 = '';
                $file_check = ($_FILES['image3']['error']);
                if ($file_check != 4) {
                    $image_upload_folder = FCPATH . "assets/uploads/sales/";
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
                        $videoNAmePath = "assets/uploads/sales/" . $new_file_name . $file_info['file_ext'];
                        $nnnn3 = $videoNAmePath;
                    }
                }
                //=======================================================IMAGE4=======================================================//
                $img4 = 'image4';
                $nnnn4 = '';
                $file_check = ($_FILES['image4']['error']);
                if ($file_check != 4) {
                    $image_upload_folder = FCPATH . "assets/uploads/sales/";
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
                        $videoNAmePath = "assets/uploads/sales/" . $new_file_name . $file_info['file_ext'];
                        $nnnn4 = $videoNAmePath;
                    }
                }



                $data = [];
                $data = array(
                    'animal_name' => $animal_name,

                    'milk_production' => $milk_production,
                    'lactation' => $lactation,
                    'price' => $price,
                    'location' => $location,
                    'parturate_pregnant' => $parturate_pregnant,
                    'expected_price' => $expected_price,
                    'animal_expense' => $animal_expense,
                    'image1' => $nnnn,
                    'image2' => $nnnn2,
                    'image3' => $nnnn3,
                    'image4' => $nnnn4,

                );

                $last_id = $this->base_model->insert_table("tbl_sale_purchase", $data, 1);

                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => []
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'please insert data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
}
