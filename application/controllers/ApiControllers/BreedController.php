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
      $this->form_validation->set_rules('group_id', 'group_id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('cattle', 'cattle', 'required|xss_clean|trim');
      $this->form_validation->set_rules('tag_no', 'tag_no', 'required|xss_clean|trim');
      $this->form_validation->set_rules('date', 'date', 'required|xss_clean|trim');
      $this->form_validation->set_rules('diesse_name', 'diesse_name', 'required|xss_clean|trim');
      $this->form_validation->set_rules('vaccine', 'vaccine', 'required|xss_clean|trim');
      $this->form_validation->set_rules('medicine', 'medicine', 'required|xss_clean|trim');
      $this->form_validation->set_rules('deworming', 'deworming', 'required|xss_clean|trim');
      $this->form_validation->set_rules('other1', 'other1', 'required|xss_clean|trim');
      $this->form_validation->set_rules('other2', 'other2', 'required|xss_clean|trim');
      $this->form_validation->set_rules('other3', 'other3', 'required|xss_clean|trim');
      $this->form_validation->set_rules('other4', 'other4', 'required|xss_clean|trim');
      $this->form_validation->set_rules('other5', 'other5', 'required|xss_clean|trim');
      $this->form_validation->set_rules('milk_loss', 'milk_loss', 'required|xss_clean|trim');
      $this->form_validation->set_rules('treat_cost', 'treat_cost', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $group_id = $this->input->post('group_id');
        $cattle = $this->input->post('cattle');
        $tag_no = $this->input->post('tag_no');
        $date = $this->input->post('date');
        $diesse_name = $this->input->post('diesse_name');
        $vaccine = $this->input->post('vaccine');
        $medicine = $this->input->post('medicine');
        $deworming = $this->input->post('deworming');
        $other1 = $this->input->post('other1');
        $other2 = $this->input->post('other2');
        $other3 = $this->input->post('other3');
        $other4 = $this->input->post('other4');
        $other5 = $this->input->post('other5');
        $milk_loss = $this->input->post('milk_loss');
        $treat_cost = $this->input->post('treat_cost');
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
        $data = [];
        $data = array('farmer_id' => $farmer_data[0]->id,
          'group_id' => $group_id,
          'cattle' => $cattle,
          'tag_no' => $tag_no,
          'date' => $date,
          'diesse_name' => $diesse_name,
          'vaccine' => $vaccine,
          'medicine' => $medicine,
          'deworming' => $deworming,
          'other1' => $other1,
          'other2' => $other2,
          'other3' => $other3,
          'other4' => $other4,
          'other5' => $other5,
          'milk_loss' => $milk_loss,
          'treat_cost' => $treat_cost,
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
        $data = array('farmer_id' => $farmer_data[0]->id,
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
      $this->form_validation->set_rules('pregnancy_test_date', 'pregnancy_test_date', 'xss_clean|trim');
      $this->form_validation->set_rules('animal_gender', 'animal_gender', 'xss_clean|trim');
      $this->form_validation->set_rules('animal_inseminated', 'animal_inseminated', 'xss_clean|trim');
      $this->form_validation->set_rules('insemination_type', 'insemination_type', 'xss_clean|trim');
      $this->form_validation->set_rules('animal_pregnant', 'animal_pregnant', 'xss_clean|trim');
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
         $animal_inseminated = $this->input->post('animal_inseminated');
          $insemination_type = $this->input->post('insemination_type');
          $animal_pregnant = $this->input->post('animal_pregnant');

        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
        $data = [];
        $data = array('farmer_id' => $farmer_data[0]->id,
          'animal_type' => $animal_type,
          'assign_to_group' => $assign_to_group,
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
          'animal_inseminated' => $animal_inseminated,
          'insemination_type' => $insemination_type,
          'animal_pregnant' => $animal_pregnant,

          'date' => $cur_date
        );
        $last_id = $this->base_model->insert_table("tbl_my_animal", $data, 1);
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
}
  //======================================================END BREEDCONTROLLER================================================//
