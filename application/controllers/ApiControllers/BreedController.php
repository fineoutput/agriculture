<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}
class BreedController extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("admin/login_model");
    $this->load->model("admin/base_model");
    $this->load->library('pagination');
  }
  //====================================================== HEALTH INFO================================================//
  public function Health_info()
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
      $this->form_validation->set_rules('tag_no', 'tag_no', 'xss_clean|trim');
      $this->form_validation->set_rules('vaccination_date', 'vaccination_date', 'required|xss_clean|trim');
      $this->form_validation->set_rules('diesse_name', 'diesse_name', 'xss_clean|trim');
      $this->form_validation->set_rules('vaccination', 'vaccination', 'xss_clean|trim');
      $this->form_validation->set_rules('medicine', 'medicine', 'xss_clean|trim');
      $this->form_validation->set_rules('deworming', 'deworming', 'xss_clean|trim');
      $this->form_validation->set_rules('other1', 'other1', 'xss_clean|trim');
      $this->form_validation->set_rules('other2', 'other2', 'xss_clean|trim');
      $this->form_validation->set_rules('other3', 'other3', 'xss_clean|trim');
      $this->form_validation->set_rules('other4', 'other4', 'xss_clean|trim');
      $this->form_validation->set_rules('other5', 'other5', 'xss_clean|trim');
      $this->form_validation->set_rules('milk_loss', 'milk_loss', 'xss_clean|trim');
      $this->form_validation->set_rules('treatment_cost', 'treatment_cost', 'xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $information_type = $this->input->post('information_type');
        $group_id = $this->input->post('group_id');
        $cattle_type = $this->input->post('cattle_type');
        $tag_no = $this->input->post('tag_no');
        $vaccination_date = $this->input->post('vaccination_date');
        $diesse_name = $this->input->post('diesse_name');
        $vaccination = $this->input->post('vaccination');
        $medicine = $this->input->post('medicine');
        $deworming = $this->input->post('deworming');
        $other1 = $this->input->post('other1');
        $other2 = $this->input->post('other2');
        $other3 = $this->input->post('other3');
        $other4 = $this->input->post('other4');
        $other5 = $this->input->post('other5');
        $milk_loss = $this->input->post('milk_loss');
        $treatment_cost = $this->input->post('treatment_cost');
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
            'tag_no' => $tag_no,
            'vaccination_date' => $vaccination_date,
            'diesse_name' => $diesse_name,
            'vaccination' => $vaccination,
            'medicine' => $medicine,
            'deworming' => $deworming,
            'other1' => $other1,
            'other2' => $other2,
            'other3' => $other3,
            'other4' => $other4,
            'other5' => $other5,
            'milk_loss' => $milk_loss,
            'treatment_cost' => $treatment_cost,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_health_info", $data, 1);
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
  //====================================================== BREEDING RECORDS================================================//
  public function Breeding_Record()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('group_id', 'group_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('cattle', 'cattle', 'required|xss_clean|trim');
      $this->form_validation->set_rules('heifer_details', 'heifer_details', 'required|xss_clean|trim');
      $this->form_validation->set_rules('date', 'date', 'required|xss_clean|trim');
      $this->form_validation->set_rules('weight', 'weight', 'required|xss_clean|trim');
      $this->form_validation->set_rules('date_of_ai', 'date_of_ai', 'required|xss_clean|trim');
      $this->form_validation->set_rules('bull_name_number', 'bull_name_number', 'required|xss_clean|trim');
      $this->form_validation->set_rules('expenses', 'expenses', 'required|xss_clean|trim');
      $this->form_validation->set_rules('vet_name', 'vet_name', 'required|xss_clean|trim');
      $this->form_validation->set_rules('pregnancy_status', 'pregnancy_status', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $group_id = $this->input->post('group_id');
        $cattle = $this->input->post('cattle');
        $heifer_details = $this->input->post('heifer_details');
        $date = $this->input->post('date');
        $weight = $this->input->post('weight');
        $date_of_ai = $this->input->post('date_of_ai');
        $bull_name_number = $this->input->post('bull_name_number');
        $expenses = $this->input->post('expenses');
        $vet_name = $this->input->post('vet_name');
        $pregnancy_status = $this->input->post('pregnancy_status');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'group_id' => $group_id,
            'cattle' => $cattle,
            'heifer_details' => $heifer_details,
            'date' => $date,
            'weight' => $weight,
            'date_of_ai' => $date_of_ai,
            'bull_name_number' => $bull_name_number,
            'expenses' => $expenses,
            'vet_name' => $vet_name,
            'pregnancy_status' => $pregnancy_status,
            'ip' => $ip,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_breeding_record", $data, 1);
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
  //====================================================== MY ANIMAL================================================//
  public function my_animal()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('animal_type', 'animal_type', 'required|xss_clean|trim');
      $this->form_validation->set_rules('assign_to_group', 'assign_to_group', 'required|xss_clean|trim');
      $this->form_validation->set_rules('tag_no', 'tag_no', 'required|xss_clean|trim');
      $this->form_validation->set_rules('animal_name', 'animal_name', 'required|xss_clean|trim');
      $this->form_validation->set_rules('dob', 'dob', 'xss_clean|trim');
      $this->form_validation->set_rules('father_name', 'father_name', 'xss_clean|trim');
      $this->form_validation->set_rules('mother_name', 'mother_name', 'xss_clean|trim');
      $this->form_validation->set_rules('weight', 'weight', 'xss_clean|trim');
      $this->form_validation->set_rules('age', 'age', 'xss_clean|trim');
      $this->form_validation->set_rules('breed_type', 'breed_type', 'xss_clean|trim');
      $this->form_validation->set_rules('semen_brand', 'semen_brand', 'xss_clean|trim');
      $this->form_validation->set_rules('insemination_date', 'insemination_date', 'xss_clean|trim');
      $this->form_validation->set_rules('is_pregnant', 'is_pregnant', 'xss_clean|trim');
      $this->form_validation->set_rules('pregnancy_test_date', 'pregnancy_test_date', 'xss_clean|trim');
      $this->form_validation->set_rules('animal_gender', 'animal_gender', 'xss_clean|trim');
      $this->form_validation->set_rules('is_inseminated', 'is_inseminated', 'xss_clean|trim');
      $this->form_validation->set_rules('insemination_type', 'insemination_type', 'xss_clean|trim');
      $this->form_validation->set_rules('service_status', 'service_status', 'xss_clean|trim');
      $this->form_validation->set_rules('in_house', 'in_house', 'xss_clean|trim');
      $this->form_validation->set_rules('lactation', 'lactation', 'xss_clean|trim');
      $this->form_validation->set_rules('calving_date', 'calving_date', 'xss_clean|trim');
      $this->form_validation->set_rules('insured_value', 'insured_value', 'xss_clean|trim');
      $this->form_validation->set_rules('insurance_no', 'insurance_no', 'xss_clean|trim');
      $this->form_validation->set_rules('renewal_period', 'renewal_period', 'xss_clean|trim');
      $this->form_validation->set_rules('insurance_date', 'insurance_date', 'xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $animal_type = $this->input->post('animal_type');
        $assign_to_group = $this->input->post('assign_to_group');
        $tag_no = $this->input->post('tag_no');
        $animal_name = $this->input->post('animal_name');
        $dob = $this->input->post('dob');
        $father_name = $this->input->post('father_name');
        $mother_name = $this->input->post('mother_name');
        $weight = $this->input->post('weight');
        $age = $this->input->post('age');
        $breed_type = $this->input->post('breed_type');
        $semen_brand = $this->input->post('semen_brand');
        $insemination_date = $this->input->post('insemination_date');
        $pregnancy_test_date = $this->input->post('pregnancy_test_date');
        $animal_gender = $this->input->post('animal_gender');
        $is_inseminated = $this->input->post('is_inseminated');
        $insemination_type = $this->input->post('insemination_type');
        $is_pregnant = $this->input->post('is_pregnant');
        $service_status = $this->input->post('service_status');
        $in_house = $this->input->post('in_house');
        $lactation = $this->input->post('lactation');
        $calving_date = $this->input->post('calving_date');
        $insured_value = $this->input->post('insured_value');
        $insurance_no = $this->input->post('insurance_no');
        $renewal_period = $this->input->post('renewal_period');
        $insurance_date = $this->input->post('insurance_date');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'animal_type' => $animal_type,
            'assign_to_group' => $assign_to_group,
            'animal_name' => $animal_name,
            'tag_no' => $tag_no,
            'dob' => $dob,
            'father_name' => $father_name,
            'mother_name' => $mother_name,
            'weight' => $weight,
            'age' => $age,
            'breed_type' => $breed_type,
            'semen_brand' => $semen_brand,
            'insemination_date' => $insemination_date,
            'pregnancy_test_date' => $pregnancy_test_date,
            'animal_gender' => $animal_gender,
            'is_inseminated' => $is_inseminated,
            'insemination_type' => $insemination_type,
            'is_pregnant' => $is_pregnant,
            'service_status' => $service_status,
            'in_house' => $in_house,
            'lactation' => $lactation,
            'calving_date' => $calving_date,
            'insured_value' => $insured_value,
            'insurance_no' => $insurance_no,
            'renewal_period' => $renewal_period,
            'insurance_date' => $insurance_date,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_my_animal", $data, 1);
          $res = array(
            'message' => "Animal Successfully Registered!",
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
}
  //======================================================END BREEDCONTROLLER================================================//