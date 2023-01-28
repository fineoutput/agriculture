<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}
class ManagementController extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("admin/login_model");
    $this->load->model("admin/base_model");
    $this->load->library('pagination');
  }
  //================================================ DAILY RECORDS==============================================//
  public function daily_records()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
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
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'date' => $date,
            'farmer_id' => $farmer_data[0]->id,
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
            'ip' => $ip,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_daily_records", $data, 1);
          $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => []
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
  //====================================================== MILK RECORDS================================================//
  public function milk_records()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('information_type', 'information_type', 'required|xss_clean|trim');
      $this->form_validation->set_rules('group_id', 'group_id', 'xss_clean|trim');
      $this->form_validation->set_rules('cattle_type', 'cattle_type', 'xss_clean|trim');
      $this->form_validation->set_rules('milking_slot', 'milking_slot', 'required|xss_clean|trim');
      $this->form_validation->set_rules('milk_date', 'milk_date', 'required|xss_clean|trim');
      $this->form_validation->set_rules('entry_milk', 'entry_milk', 'required|xss_clean|trim');
      $this->form_validation->set_rules('price_milk', 'price_milk', 'required|xss_clean|trim');
      $this->form_validation->set_rules('fat', 'fat', 'required|xss_clean|trim');
      $this->form_validation->set_rules('snf', 'snf', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $information_type = $this->input->post('information_type');
        $group_id = $this->input->post('group_id');
        $cattle_type = $this->input->post('cattle_type');
        $milking_slot = $this->input->post('milking_slot');
        $milk_date = $this->input->post('milk_date');
        $entry_milk = $this->input->post('entry_milk');
        $price_milk = $this->input->post('price_milk');
        $fat = $this->input->post('fat');
        $snf = $this->input->post('snf');
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'information_type' => $information_type,
            'group_id' => $group_id,
            'cattle_type' => $cattle_type,
            'milking_slot' => $milking_slot,
            'milk_date' => $milk_date,
            'entry_milk' => $entry_milk,
            'price_milk' => $price_milk,
            'fat' => $fat,
            'snf' => $snf,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_milk_records", $data, 1);
          $res = array(
            'message' => "Record Successfully Inserted!",
            'status' => 200,
            'data' => []
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
  //================= view Milk Record -----------------------------
  public function view_milk_records()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $milk_data = $this->db->order_by('id', 'desc')->get_where('tbl_milk_records', array('farmer_id' => $farmer_data[0]->id))->result();
      $data = [];
      $i = 1;
      foreach ($milk_data as $milk) {
        if (!empty($milk->group_id)) {
          $group_data = $this->db->get_where('tbl_group', array('id' => $milk->group_id))->result();
          $group = $group_data[0]->name;
        } else {
          $group = '';
        }
        $newdate = new DateTime($milk->date);
        $data[] = array(
          's_no' => $i,
          'information_type' => $milk->information_type,
          'group' => $group,
          'cattle_type' => $milk->cattle_type,
          'milking_slot' => $milk->milking_slot,
          'milk_date' => $milk->milk_date,
          'entry_milk' => $milk->entry_milk,
          'price_milk' => $milk->price_milk,
          'fat' => $milk->fat,
          'snf' => $milk->snf,
          'date' => $newdate->format('d/m/Y')
        );
        $i++;
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
  //====================================================== SALE PURCHASE================================================//
  public function sale_purchase()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('information_type', 'information_type', 'required|xss_clean|trim');
      $this->form_validation->set_rules('animal_name', 'animal_name', 'xss_clean|trim');
      $this->form_validation->set_rules('milk_production', 'milk_production', 'required|xss_clean|trim');
      $this->form_validation->set_rules('lactation', 'lactation', 'required|xss_clean|trim');
      $this->form_validation->set_rules('pastorate_pregnant', 'pastorate_pregnant', 'xss_clean|trim');
      $this->form_validation->set_rules('expected_price', 'expected_price', 'required|xss_clean|trim');
      $this->form_validation->set_rules('location', 'location', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $information_type = $this->input->post('information_type');
        $animal_name = $this->input->post('animal_name');
        $milk_production = $this->input->post('milk_production');
        $lactation = $this->input->post('lactation');
        $expected_price = $this->input->post('expected_price');
        $pastorate_pregnant = $this->input->post('pastorate_pregnant');
        $location = $this->input->post('location');
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        //=============================================IMAGE1 ====================================================//
        $this->load->library('upload');
        $img1 = 'image1';
        $nnnn = '';
        if (!empty($_FILES['image1'])) {
          if ($_FILES['image1']['size'] != 0 && $_FILES['image1']['error'] == 0) {
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
          }
        }
        //===================================================IMAGE2====================================================//
        $img2 = 'image2';
        $nnnn2 = '';
        if (!empty($_FILES['image2'])) {
          if ($_FILES['image2']['size'] != 0 && $_FILES['image2']['error'] == 0) {
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
          }
        }
        //=======================================================IMAGE3===================================================//
        $img3 = 'image3';
        $nnnn3 = '';
        if (!empty($_FILES['image3'])) {
          if ($_FILES['image3']['size'] != 0 && $_FILES['image3']['error'] == 0) {
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
          }
        }
        //=======================================================IMAGE4======================================================//
        $img4 = 'image4';
        $nnnn4 = '';
        if (!empty($_FILES['image4'])) {
          if ($_FILES['image4']['size'] != 0 && $_FILES['image4']['error'] == 0) {
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
          }
        }
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'information_type' => $information_type,
            'animal_name' => $animal_name,
            'milk_production' => $milk_production,
            'lactation' => $lactation,
            'location' => $location,
            'expected_price' => $expected_price,
            'pastorate_pregnant' => $pastorate_pregnant,
            'image1' => $nnnn,
            'image2' => $nnnn2,
            'image3' => $nnnn3,
            'image4' => $nnnn4,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_sale_purchase", $data, 1);
          $res = array(
            'message' => "Record Successfully Inserted!",
            'status' => 200,
            'data' => []
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
  //================= view Sale Purchase -----------------------------
  public function view_sale_purchase()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $exp_data = $this->db->order_by('id', 'desc')->get_where('tbl_sale_purchase', array('farmer_id' => $farmer_data[0]->id))->result();
      $data = [];
      $i = 1;
      foreach ($exp_data as $exp) {
        $newdate = new DateTime($exp->date);
        if (!empty($exp->image1)) {
          $image1 = base_url() . $exp->image1;
        } else {
          $image1 = '';
        }
        if (!empty($exp->image2)) {
          $image2 = base_url() . $exp->image2;
        } else {
          $image2 = '';
        }
        if (!empty($exp->image3)) {
          $image3 = base_url() . $exp->image3;
        } else {
          $image3 = '';
        }
        if (!empty($exp->image4)) {
          $image4 = base_url() . $exp->image4;
        } else {
          $image4 = '';
        }
        $data[] = array(
          's_no' => $i,
          'information_type' => $exp->information_type,
          'animal_name' => $exp->animal_name,
          'milk_production' => $exp->milk_production,
          'lactation' => $exp->lactation,
          'location' => $exp->location,
          'expected_price' => $exp->expected_price,
          'pastorate_pregnant' => $exp->pastorate_pregnant,
          'image1' => $image1,
          'image2' => $image2,
          'image3' => $image3,
          'image4' => $image4,
          'date' => $newdate->format('d/m/Y')
        );
        $i++;
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
  //====================================================== MEDICAL EXPENSES================================================//
  public function medical_expenses()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('expense_date', 'expense_date', 'required|xss_clean|trim');
      $this->form_validation->set_rules('doctor_visit_fees', 'doctor_visit_fees', 'xss_clean|trim');
      $this->form_validation->set_rules('treatment_expenses', 'treatment_expenses', 'xss_clean|trim');
      $this->form_validation->set_rules('vaccination_expenses', 'vaccination_expenses', 'xss_clean|trim');
      $this->form_validation->set_rules('deworming_expenses', 'deworming_expenses', 'xss_clean|trim');
      $this->form_validation->set_rules('other1', 'other1', 'xss_clean|trim');
      $this->form_validation->set_rules('other2', 'other2', 'xss_clean|trim');
      $this->form_validation->set_rules('other3', 'other3', 'xss_clean|trim');
      $this->form_validation->set_rules('other4', 'other4', 'xss_clean|trim');
      $this->form_validation->set_rules('other5', 'other5', 'xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $expense_date = $this->input->post('expense_date');
        $doctor_visit_fees = $this->input->post('doctor_visit_fees');
        $treatment_expenses = $this->input->post('treatment_expenses');
        $vaccination_expenses = $this->input->post('vaccination_expenses');
        $deworming_expenses = $this->input->post('deworming_expenses');
        $other1 = $this->input->post('other1');
        $other2 = $this->input->post('other2');
        $other3 = $this->input->post('other3');
        $other4 = $this->input->post('other4');
        $other5 = $this->input->post('other5');
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'expense_date' => $expense_date,
            'doctor_visit_fees' => $doctor_visit_fees,
            'treatment_expenses' => $treatment_expenses,
            'vaccination_expenses' => $vaccination_expenses,
            'deworming_expenses' => $deworming_expenses,
            'other1' => $other1,
            'other2' => $other2,
            'other3' => $other3,
            'other4' => $other4,
            'other5' => $other5,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_medical_expenses", $data, 1);
          $res = array(
            'message' => "Record Successfully Inserted!",
            'status' => 200,
            'data' => []
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
  //================= view Medical Expense -----------------------------
  public function view_medical_expense()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $exp_data = $this->db->order_by('id', 'desc')->get_where('tbl_medical_expenses', array('farmer_id' => $farmer_data[0]->id))->result();
      $data = [];
      $i = 1;
      foreach ($exp_data as $exp) {
        $newdate = new DateTime($exp->date);
        $data[] = array(
          's_no' => $i,
          'expense_date' => $exp->expense_date,
          'doctor_visit_fees' => $exp->doctor_visit_fees,
          'treatment_expenses' => $exp->treatment_expenses,
          'vaccination_expenses' => $exp->vaccination_expenses,
          'deworming_expenses' => $exp->deworming_expenses,
          'other1' => $exp->other1,
          'other2' => $exp->other2,
          'other3' => $exp->other3,
          'other4' => $exp->other4,
          'other5' => $exp->other5,
          'date' => $newdate->format('d/m/Y')
        );
        $i++;
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
  //======================================================REPORTS================================================//
  public function Reports()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('filter_reports_by_calendar', 'filter_reports_by_calendar', 'required|xss_clean|trim');
      $this->form_validation->set_rules('sale', 'sale', 'required|xss_clean|trim');
      $this->form_validation->set_rules('purchase', 'purchase', 'required|xss_clean|trim');
      $this->form_validation->set_rules('profit_loss', 'profit_loss', 'required|xss_clean|trim');
      $this->form_validation->set_rules('feed_expenses', 'feed_expenses', 'required|xss_clean|trim');
      $this->form_validation->set_rules('milk_income', 'milk_income', 'required|xss_clean|trim');
      $this->form_validation->set_rules('breeding_income', 'breeding_income', 'required|xss_clean|trim');
      $this->form_validation->set_rules('animal_expenses', 'animal_expenses', 'required|xss_clean|trim');
      $this->form_validation->set_rules('animal_income', 'animal_income', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $filter_reports_by_calendar = $this->input->post('filter_reports_by_calendar');
        $sale = $this->input->post('sale');
        $purchase = $this->input->post('purchase');
        $profit_loss = $this->input->post('profit_loss');
        $feed_expenses = $this->input->post('feed_expenses');
        $milk_income = $this->input->post('milk_income');
        $breeding_income = $this->input->post('breeding_income');
        $animal_expenses = $this->input->post('animal_expenses');
        $animal_income = $this->input->post('animal_income');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'filter_reports_by_calendar' => $filter_reports_by_calendar,
            'sale' => $sale,
            'purchase' => $purchase,
            'profit_loss' => $profit_loss,
            'feed_expenses' => $feed_expenses,
            'milk_income' => $milk_income,
            'breeding_income' => $breeding_income,
            'animal_expenses' => $animal_expenses,
            'animal_income' => $animal_income,
            'ip' => $ip,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_reports", $data, 1);
          $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => []
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
  //====================================================== DISEASE INFO================================================//
  public function disease_info()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $Disease_data = $this->db->get_where('tbl_disease', array('is_active' => 1))->result();
      $data = [];
      foreach ($Disease_data as $Disease) {
        if (!empty($Disease->image1)) {
          $image1 = base_url() . $Disease->image1;
        } else {
          $image1 = '';
        }
        $data[] = array(
          'title' => $Disease->title,
          'description' => $Disease->content,
          'image' => $image1,
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
  //====================================================== STOCK HANDLING================================================//
  public function stock_handling()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('date', 'date', 'required|xss_clean|trim');
      $this->form_validation->set_rules('green_forage', 'green_forage', 'required|xss_clean|trim');
      $this->form_validation->set_rules('dry_fodder', 'dry_fodder', 'required|xss_clean|trim');
      $this->form_validation->set_rules('silage', 'silage', 'required|xss_clean|trim');
      $this->form_validation->set_rules('cake', 'cake', 'required|xss_clean|trim');
      $this->form_validation->set_rules('grains', 'grains', 'required|xss_clean|trim');
      $this->form_validation->set_rules('biproducts', 'biproducts', 'required|xss_clean|trim');
      $this->form_validation->set_rules('churi', 'churi', 'required|xss_clean|trim');
      $this->form_validation->set_rules('oil_seeds', 'oil_seeds', 'required|xss_clean|trim');
      $this->form_validation->set_rules('minerals', 'minerals', 'required|xss_clean|trim');
      $this->form_validation->set_rules('bypass_fat', 'bypass_fat', 'required|xss_clean|trim');
      $this->form_validation->set_rules('toxins', 'toxins', 'required|xss_clean|trim');
      $this->form_validation->set_rules('buffer', 'buffer', 'required|xss_clean|trim');
      $this->form_validation->set_rules('yeast', 'yeast', 'required|xss_clean|trim');
      $this->form_validation->set_rules('calcium', 'calcium', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $date = $this->input->post('date');
        $green_forage = $this->input->post('green_forage');
        $dry_fodder = $this->input->post('dry_fodder');
        $silage = $this->input->post('silage');
        $cake = $this->input->post('cake');
        $grains = $this->input->post('grains');
        $biproducts = $this->input->post('biproducts');
        $churi = $this->input->post('churi');
        $oil_seeds = $this->input->post('oil_seeds');
        $minerals = $this->input->post('minerals');
        $bypass_fat = $this->input->post('bypass_fat');
        $toxins = $this->input->post('toxins');
        $buffer = $this->input->post('buffer');
        $yeast = $this->input->post('yeast');
        $calcium = $this->input->post('calcium');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'date' => $date,
            'green_forage' => $green_forage,
            'dry_fodder' => $dry_fodder,
            'silage' => $silage,
            'cake' => $cake,
            'grains' => $grains,
            'biproducts' => $biproducts,
            'churi' => $churi,
            'oil_seeds' => $oil_seeds,
            'minerals' => $minerals,
            'bypass_fat' => $bypass_fat,
            'toxins' => $toxins,
            'buffer' => $buffer,
            'yeast' => $yeast,
            'calcium' => $calcium,
            'ip' => $ip,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_stock_handling", $data, 1);
          $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => []
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
  //===================================================TANK =========================================================//
  public function add_semen_tank()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $name = $this->input->post('name');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'name' => $name,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_tank", $data, 1);
          //---- create 6 canister ----
          for ($i = 0; $i < 6; $i++) {
            $data = array(
              'farmer_id' => $farmer_data[0]->id,
              'tank_id' => $last_id,
              'date' => $cur_date
            );
            $last_id2 = $this->base_model->insert_table("tbl_canister", $data, 1);
          }
          $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => []
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
  //==============================================================CANISTER==============================================//
  public function update_canister()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('canister_id', 'canister_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('tag_no', 'tag_no', 'required|xss_clean|trim');
      $this->form_validation->set_rules('tank_id', 'tank_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('tag_no', 'tag_no', 'required|xss_clean|trim');
      $this->form_validation->set_rules('bull_name', 'bull_name', 'required|xss_clean|trim');
      $this->form_validation->set_rules('company_name', 'company_name', 'required|xss_clean|trim');
      $this->form_validation->set_rules('no_of_units', 'no_of_units', 'required|xss_clean|trim');
      $this->form_validation->set_rules('milk_production_of_mounts', 'milk_production_of_mounts', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $canister_id = $this->input->post('canister_id');
        $tank_id = $this->input->post('tank_id');
        $tag_no = $this->input->post('tag_no');
        $bull_name = $this->input->post('bull_name');
        $company_name = $this->input->post('company_name');
        $no_of_units = $this->input->post('no_of_units');
        $milk_production_of_mounts = $this->input->post('milk_production_of_mounts');;
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data_update = array(
            'farmer_id' => $farmer_data[0]->id,
            'tank_id' => $tank_id,
            'tag_no' => $tag_no,
            'bull_name' => $bull_name,
            'company_name' => $company_name,
            'no_of_units' => $no_of_units,
            'milk_production_of_mounts' => $milk_production_of_mounts,
            'ip' => $ip,
            'date' => $cur_date
          );
          $this->db->where('id', $canister_id);
          $zapak=$this->db->update('tbl_canister', $data_update);
          $res = array(
            'message' => "Record Successfully Updated!",
            'status' => 200,
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
  //====================================================== farm_summary ================================================//
  public function farm_summary()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $inseminate_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'is_inseminated' => 'Yes'))->num_rows();
      $pregnant_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'is_pregnant' => 'Yes'))->num_rows();
      $not_pregnant_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'is_pregnant' => 'No'))->num_rows();
      $bull_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Bull'))->num_rows();
      $heifer_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Heifer'))->num_rows();
      $milking_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Milking'))->num_rows();
      $calf_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Calf'))->num_rows();
      $data = array(
        'open' => 1,
        'inseminate' => $inseminate_count,
        'pregnant' => $pregnant_count,
        'not_pregnant' => $not_pregnant_count,
        'dry' => 5,
        'milking' => $milking_count,
        'calves' => $calf_count,
        'bull' => $bull_count,
        'heifers' => $heifer_count,
        'repeater' => 0,
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
  }
}
//==============================================================END MANAGECONTROLLER====================================//
