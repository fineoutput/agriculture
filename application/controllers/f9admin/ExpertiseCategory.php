<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class ExpertiseCategory extends CI_finecontrol
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("login_model");
    $this->load->model("admin/base_model");
    $this->load->library('user_agent');
    $this->load->library('upload');
  }
  // ************************view expertise_category Function**************************************
  public function view_expertise_category()
  {
    if (!empty($this->session->userdata('admin_data'))) {
      $data['user_name'] = $this->load->get_var('user_name');
      // echo SITE_NAME;
      // echo $this->session->userdata('image');
      // echo $this->session->userdata('position');
      // exit;
      $this->db->select('*');
      $this->db->from('tbl_expertise_category');
      //$this->db->where('id',$usr);
      $data['expertise_category_data'] = $this->db->get();
      $this->load->view('admin/common/header_view', $data);
      $this->load->view('admin/expertise_category/View_expertise_category');
      $this->load->view('admin/common/footer_view');
    } else {
      redirect("login/admin_login", "refresh");
    }
  }
  // ************************Add expertise_category Function**************************************
  public function add_expertise_category()
  {
    if (!empty($this->session->userdata('admin_data'))) {
      $this->load->view('admin/common/header_view');
      $this->load->view('admin/expertise_category/add_expertise_category');
      $this->load->view('admin/common/footer_view');
    } else {
      redirect("login/admin_login", "refresh");
    }
  }
  // ************************Update expertise_category Function**************************************
  public function update_expertise_category($idd)
  {
    if (!empty($this->session->userdata('admin_data'))) {
      $data['user_name'] = $this->load->get_var('user_name');
      // echo SITE_NAME;
      // echo $this->session->userdata('image');
      // echo $this->session->userdata('position');
      // exit;
      $id = base64_decode($idd);
      $data['id'] = $idd;
      $this->db->select('*');
      $this->db->from('tbl_expertise_category');
      $this->db->where('id', $id);
      $data['expertise_category_data'] = $this->db->get()->row();
      $this->load->view('admin/common/header_view', $data);
      $this->load->view('admin/expertise_category/update_expertise_category');
      $this->load->view('admin/common/footer_view');
    } else {
      redirect("login/admin_login", "refresh");
    }
  }
  // ************************Insert expertise_category Data Function**************************************
  public function add_expertise_category_data($t, $iw = "")
  {
    if (!empty($this->session->userdata('admin_data'))) {
      $this->load->helper(array('form', 'url'));
      $this->load->library('form_validation');
      $this->load->helper('security');
      if ($this->input->post()) {
        // print_r($this->input->post());
        // exit;
        $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
        if ($this->form_validation->run() == TRUE) {
          $name = $this->input->post('name');
          //------------------------------------image insert-----------------------------------------
          $this->load->library('upload');
          $img1 = 'image';
          $image1 = "";
          $file_check = ($_FILES['image']['error']);
          if ($file_check != 4) {
            $image_upload_folder = FCPATH . "assets/uploads/expertise_category/";
            if (!file_exists($image_upload_folder)) {
              mkdir($image_upload_folder, DIR_WRITE_MODE, true);
            }
            $new_file_name = "expertise_category" . date("YmdHis");
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
              $image1 = "assets/uploads/expertise_category/" . $new_file_name . $file_info['file_ext'];
              $file_info['new_name'] = $image1;
              // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
              $nnnn = $file_info['file_name'];
              // echo json_encode($file_info);
            }
          }
          //-----------------------image tag end------------------------------------------
          //------------------------------------image Hindi insert-----------------------------------------
          $image_hindi = "";
          $img1_hindi = 'image_hindi';
          $file_check = ($_FILES['image_hindi']['error']);
          if ($file_check != 4) {
            $image_upload_folder = FCPATH . "assets/uploads/expertise_category/";
            if (!file_exists($image_upload_folder)) {
              mkdir($image_upload_folder, DIR_WRITE_MODE, true);
            }
            $new_file_name = "expertise_category2" . date("YmdHis");
            $this->upload_config = array(
              'upload_path'   => $image_upload_folder,
              'file_name' => $new_file_name,
              'allowed_types' => 'jpg|jpeg|png',
              'max_size'      => 25000
            );
            $this->upload->initialize($this->upload_config);
            if (!$this->upload->do_upload($img1_hindi)) {
              $upload_error = $this->upload->display_errors();
              // echo json_encode($upload_error);
              // echo $upload_error;
              $this->session->set_flashdata('emessage', $upload_error);
              redirect($_SERVER['HTTP_REFERER']);
            } else {
              $file_info = $this->upload->data();
              $image_hindi = "assets/uploads/expertise_category/" . $file_info['file_name'];
            }
          } else {
            $image_hindi = '';
          }
          //-----------------------image Hindi  tag end------------------------------------------
          //------------------------------------image Punjabi insert-----------------------------------------
          $image_punjabi = "";
          $img1_punjabi = 'image_punjabi';
          $file_check = ($_FILES['image_punjabi']['error']);
          if ($file_check != 4) {
            $image_upload_folder = FCPATH . "assets/uploads/expertise_category/";
            if (!file_exists($image_upload_folder)) {
              mkdir($image_upload_folder, DIR_WRITE_MODE, true);
            }
            $new_file_name = "expertise_category3" . date("YmdHis");
            $this->upload_config = array(
              'upload_path'   => $image_upload_folder,
              'file_name' => $new_file_name,
              'allowed_types' => 'jpg|jpeg|png',
              'max_size'      => 25000
            );
            $this->upload->initialize($this->upload_config);
            if (!$this->upload->do_upload($img1_punjabi)) {
              $upload_error = $this->upload->display_errors();
              // echo json_encode($upload_error);
              // echo $upload_error;
              $this->session->set_flashdata('emessage', $upload_error);
              redirect($_SERVER['HTTP_REFERER']);
            } else {
              $file_info = $this->upload->data();
              $image_punjabi = "assets/uploads/expertise_category/" . $file_info['file_name'];
            }
          } else {
            $image_punjabi = '';
          }
          //-----------------------image tag end------------------------------------------
          $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
          $cur_date = date("Y-m-d H:i:s");
          $addedby = $this->session->userdata('admin_id');
          $typ = base64_decode($t);
          if ($typ == 1) {
            $data_insert = array(
              'name' => $name,
              'image' => $image1,
              'image_hindi' => $image_hindi,
              'image_punjabi' => $image_punjabi,
              'ip' => $ip,
              'added_by' => $addedby,
              'is_active' => 1,
              'date' => $cur_date
            );
            $last_id = $this->base_model->insert_table("tbl_expertise_category", $data_insert, 1);
          }
          if ($typ == 2) {
            $idw = base64_decode($iw);
            $d_data = $this->db->get_where('tbl_expertise_category', array('id' => $idw))->result();
            if (empty($image1)) {
              $image1 = $d_data[0]->image;
            }
            if (empty($image_punjabi)) {
              $img_punjabi = $d_data[0]->image_punjabi;
            } else {
              $img_punjabi = $image_punjabi;
            }
            if (empty($image_hindi)) {
              $img_hindi = $d_data[0]->image_hindi;
            } else {
              $img_hindi = $image_hindi;
            }
            $data_insert = array(
              'name' => $name,
              'image' => $image1,
              'image_hindi' => $img_hindi,
              'image_punjabi' => $img_punjabi
            );
            $this->db->where('id', $idw);
            $last_id = $this->db->update('tbl_expertise_category', $data_insert);
          }
          if ($last_id != 0) {
            $this->session->set_flashdata('smessage', 'Data inserted successfully');
            redirect("dcadmin/ExpertiseCategory/view_expertise_category", "refresh");
          } else {
            $this->session->set_flashdata('emessage', 'Sorry error occured');
            redirect($_SERVER['HTTP_REFERER']);
          }
        } else {
          $this->session->set_flashdata('emessage', validation_errors());
          redirect($_SERVER['HTTP_REFERER']);
        }
      } else {
        $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
        redirect($_SERVER['HTTP_REFERER']);
      }
    } else {
      redirect("login/admin_login", "refresh");
    }
  }
  // ************************Update expertise_category Status Function**************************************
  public function updateexpertise_categoryStatus($idd, $t)
  {
    if (!empty($this->session->userdata('admin_data'))) {
      $data['user_name'] = $this->load->get_var('user_name');
      // echo SITE_NAME;
      // echo $this->session->userdata('image');
      // echo $this->session->userdata('position');
      // exit;
      $id = base64_decode($idd);
      if ($t == "active") {
        $data_update = array(
          'is_active' => 1
        );
        $this->db->where('id', $id);
        $zapak = $this->db->update('tbl_expertise_category', $data_update);
        if ($zapak != 0) {
          redirect("dcadmin/ExpertiseCategory/view_expertise_category", "refresh");
        } else {
          $this->session->set_flashdata('emessage', 'Sorry error occured');
          redirect($_SERVER['HTTP_REFERER']);
        }
      }
      if ($t == "inactive") {
        $data_update = array(
          'is_active' => 0
        );
        $this->db->where('id', $id);
        $zapak = $this->db->update('tbl_expertise_category', $data_update);
        if ($zapak != 0) {
          redirect("dcadmin/ExpertiseCategory/view_expertise_category", "refresh");
        } else {
          $this->session->set_flashdata('emessage', 'Sorry error occured');
          redirect($_SERVER['HTTP_REFERER']);
        }
      }
    } else {
      redirect("login/admin_login", "refresh");
    }
  }
  // ************************Delete expertise_category Function**************************************
  public function delete_expertise_category($idd)
  {
    if (!empty($this->session->userdata('admin_data'))) {
      $data['user_name'] = $this->load->get_var('user_name');
      // echo SITE_NAME;
      // echo $this->session->userdata('image');
      // echo $this->session->userdata('position');
      // exit;
      $id = base64_decode($idd);
      if ($this->load->get_var('position') == "Super Admin") {
        $zapak = $this->db->delete('tbl_expertise_category', array('id' => $id));
        if ($zapak != 0) {
          redirect("dcadmin/ExpertiseCategory/view_expertise_category", "refresh");
        } else {
          $this->session->set_flashdata('emessage', 'Sorry error occured');
          redirect($_SERVER['HTTP_REFERER']);
        }
      } else {
        $this->session->set_flashdata('emessage', 'Sorry you not a super admin you dont have permission to delete anything');
        redirect($_SERVER['HTTP_REFERER']);
      }
    } else {
      redirect("login/admin_login", "refresh");
    }
  }
}
