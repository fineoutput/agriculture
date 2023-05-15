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
      $this->form_validation->set_rules('data', 'data', 'required|xss_clean|trim');
      $this->form_validation->set_rules('update_inventory', 'update_inventory', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $date = $this->input->post('date');
        $data = json_decode($this->input->post('data'));
        $update_inventory = $this->input->post('update_inventory');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $entry_id = bin2hex(random_bytes(5));
          foreach ($data as $d) {
            if (!empty($d->values->qty) && !empty($d->values->price) && !empty($d->values->amount)) {
              $data = array(
                'record_date' => $date,
                'farmer_id' => $farmer_data[0]->id,
                'entry_id' => $entry_id,
                'name' => $d->name,
                'type' => $d->values->type,
                'qty' => $d->values->qty,
                'price' => $d->values->price,
                'amount' => $d->values->amount,
                'update_inventory' => $update_inventory,
                'date' => $cur_date
              );
              $last_id = $this->base_model->insert_table("tbl_daily_records", $data, 1);
              //----- update inventory -------
              if ($update_inventory == "Yes" && $d->values->type == 'feed' &&  $d->column != 'feed') {
                $data = array(
                  'farmer_id' => $farmer_data[0]->id,
                  $d->column => -$d->values->qty,
                  'date' => $cur_date
                );
                $last_id = $this->base_model->insert_table("tbl_stock_handling", $data, 1);
              }
            }
          }
          $res = array(
            'message' => "Record Successfully Inserted!",
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
  //================= view Milk Record -----------------------------
  public function view_daily_records()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $page_index = $headers['Index'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $this->db->select('entry_id');
      $this->db->distinct();
      $this->db->where('farmer_id', $farmer_data[0]->id);
      $query = $this->db->get('tbl_daily_records');
      $count =  $query->num_rows();
      $limit = 20;
      if (!empty($page_index)) {
        $start = ($page_index - 1) * $limit;
      } else {
        $start = 0;
      }
      $this->db->distinct();
      $this->db->select('entry_id');
      $this->db->where('farmer_id', $farmer_data[0]->id);
      $this->db->order_by('id', 'desc');
      $this->db->limit($limit, $start);
      $query = $this->db->get('tbl_daily_records');
      // $count2 =  $query->num_rows();
      // echo $count2;die();
      $pages = round($count / $limit);
      $pagination = $this->CreatePagination($page_index, $pages);
      $data = [];
      $big = [];
      $i = 1;
      foreach ($query->result() as $entry) {
        $daily_data = $this->db->get_where('tbl_daily_records', array('entry_id' => $entry->entry_id))->result();
        foreach ($daily_data as $daily) {
          $newdate = new DateTime($daily->date);
          $data[] = array(
            'record_date' => $daily->record_date,
            'name' => $daily->name,
            'qty' => $daily->qty,
            'price' => $daily->price,
            'amount' => $daily->amount,
            'date' => $newdate->format('d/m/Y')
          );
        }
        $i++;
        $big[] = $data;
      }
      $res = array(
        'message' => "Success!",
        'status' => 200,
        'data' => $big,
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
      $this->form_validation->set_rules('total_price', 'total_price', 'required|xss_clean|trim');
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
        $total_price = $this->input->post('total_price');
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
            'total_price' => $total_price,
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
    $page_index = $headers['Index'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $count = $this->db->get_where('tbl_milk_records', array('farmer_id' => $farmer_data[0]->id))->num_rows();
      $limit = 20;
      if (!empty($page_index)) {
        $start = ($page_index - 1) * $limit;
      } else {
        $start = 0;
      }
      $this->db->select('*');
      $this->db->from('tbl_milk_records');
      $this->db->where('farmer_id', $farmer_data[0]->id);
      $this->db->order_by('id', 'desc');
      $this->db->limit($limit, $start);
      $milk_data = $this->db->get();
      $pages = round($count / $limit);
      $pagination = $this->CreatePagination($page_index, $pages);
      $data = [];
      $i = 1;
      foreach ($milk_data->result() as $milk) {
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
          'total_price' => $milk->total_price,
          'date' => $newdate->format('d/m/Y')
        );
        $i++;
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
    $page_index = $headers['Index'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $count = $this->db->get_where('tbl_sale_purchase', array('farmer_id' => $farmer_data[0]->id))->num_rows();
      $limit = 20;
      if (!empty($page_index)) {
        $start = ($page_index - 1) * $limit;
      } else {
        $start = 0;
      }
      $this->db->select('*');
      $this->db->from('tbl_sale_purchase');
      $this->db->where('farmer_id', $farmer_data[0]->id);
      $this->db->order_by('id', 'desc');
      $this->db->limit($limit, $start);
      $exp_data = $this->db->get();
      $pages = round($count / $limit);
      $pagination = $this->CreatePagination($page_index, $pages);
      $data = [];
      $i = 1;
      foreach ($exp_data->result() as $exp) {
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
  //================= view other Sale Purchase -----------------------------
  public function view_others_sale_purchase()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $page_index = $headers['Index'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $count = $this->db->get_where('tbl_sale_purchase', array('farmer_id !=' => $farmer_data[0]->id))->num_rows();
      $limit = 20;
      if (!empty($page_index)) {
        $start = ($page_index - 1) * $limit;
      } else {
        $start = 0;
      }
      $this->db->select('*');
      $this->db->from('tbl_sale_purchase');
      $this->db->where('farmer_id !=', $farmer_data[0]->id);
      $this->db->order_by('id', 'desc');
      $this->db->limit($limit, $start);
      $exp_data = $this->db->get();
      $pages = round($count / $limit);
      $pagination = $this->CreatePagination($page_index, $pages);
      $data = [];
      $i = 1;
      foreach ($exp_data->result() as $exp) {
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
        $farmerData = $this->db->get_where('tbl_farmers', array('id' => $exp->farmer_id))->result();
        if (!empty($farmerData)) {
          $f_name = $farmerData[0]->name;
          $f_phone = $farmerData[0]->phone;
        } else {
          $f_name = '';
          $f_phone = '';
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
          'f_name' => $f_name,
          'f_phone' => $f_phone,
          'date' => $newdate->format('d/m/Y')
        );
        $i++;
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
      $this->form_validation->set_rules('total_price', 'total_price', 'xss_clean|trim');
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
        $total_price = $this->input->post('total_price');
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
            'total_price' => $total_price,
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
    $page_index = $headers['Index'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $count = $this->db->get_where('tbl_medical_expenses', array('farmer_id' => $farmer_data[0]->id))->num_rows();
      $limit = 20;
      if (!empty($page_index)) {
        $start = ($page_index - 1) * $limit;
      } else {
        $start = 0;
      }
      $this->db->select('*');
      $this->db->from('tbl_medical_expenses');
      $this->db->where('farmer_id', $farmer_data[0]->id);
      $this->db->order_by('id', 'desc');
      $this->db->limit($limit, $start);
      $exp_data = $this->db->get();
      $pages = round($count / $limit);
      $pagination = $this->CreatePagination($page_index, $pages);
      $data = [];
      $i = 1;
      foreach ($exp_data->result() as $exp) {
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
          'total_price' => $exp->total_price,
          'date' => $newdate->format('d/m/Y')
        );
        $i++;
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
  //======================================================REPORTS================================================//
  public function Reports()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('from', 'from', 'xss_clean|trim');
      $this->form_validation->set_rules('to', 'to', 'xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        date_default_timezone_set("Asia/Calcutta");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          if (!empty($from) && !empty($to)) {
            $newdate = new DateTime($from);
            $From = $newdate->format('d-m-Y');
            $newdate2 = new DateTime($to);
            $To = $newdate2->format('d-m-Y');
          } else {
            $From = '';
            $To = '';
          }
          // echo  $to;die();
          //------ medical exp ---------
          $this->db->select_sum('total_price');
          $this->db->from('tbl_medical_expenses');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          if (!empty($From) && !empty($To)) {
            $this->db->where('expense_date >=', $From);
            $this->db->where('expense_date <=', $To);
          }
          $medical = $this->db->get();
          $medical_exp = $medical->row()->total_price ? $medical->row()->total_price : 0;
          //------ Doctor exp ---------
          $this->db->select_sum('fees');
          $this->db->from('tbl_doctor_req');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          if (!empty($From) && !empty($To)) {
            $this->db->where('payment_status >=', 1);
            $this->db->where('req_date >=', $From);
            $this->db->where('req_date <=', $To);
          }
          $doc = $this->db->get();
          $doc_exp = $doc->row()->fees ? $doc->row()->fees : 0;
          //------ milk count ---------
          $this->db->select_sum('total_price');
          $this->db->from('tbl_milk_records');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          if (!empty($From) && !empty($To)) {
            $this->db->where('milk_date >=', $From);
            $this->db->where('milk_date <=', $To);
          }
          $milk = $this->db->get();
          $milk_income = $milk->row()->total_price ? $milk->row()->total_price : 0;
          //------ feed exp ---------
          $this->db->select_sum('amount');
          $this->db->from('tbl_daily_records');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          $this->db->where('type', 'feed');
          if (!empty($From) && !empty($To)) {
            $this->db->where('record_date >=', $From);
            $this->db->where('record_date <=', $To);
          }
          $feed = $this->db->get();
          $feed_exp = $feed->row()->amount ? $feed->row()->amount : 0;
          //------ sale ---------
          $this->db->select_sum('amount');
          $this->db->from('tbl_daily_records');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          $this->db->where('name', 'Animal Sell');
          if (!empty($From) && !empty($To)) {
            $this->db->where('record_date >=', $From);
            $this->db->where('record_date <=', $To);
          }
          $sale_data = $this->db->get();
          $sale = $sale_data->row()->amount ? $sale_data->row()->amount : 0;
          //------ purchase ---------
          $this->db->select_sum('amount');
          $this->db->from('tbl_daily_records');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          $this->db->where('name', 'Animal Purchase');
          if (!empty($From) && !empty($To)) {
            $this->db->where('record_date >=', $From);
            $this->db->where('record_date <=', $To);
          }
          $purchase_data = $this->db->get();
          $purchase = $purchase_data->row()->amount ? $purchase_data->row()->amount : 0;
          //------ pregnancy care ---------
          $this->db->select_sum('amount');
          $this->db->from('tbl_daily_records');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          $this->db->where('name', 'Pregnancy Care');
          if (!empty($From) && !empty($To)) {
            $this->db->where('record_date >=', $From);
            $this->db->where('record_date <=', $To);
          }
          $pg_data = $this->db->get();
          $prg_care = $pg_data->row()->amount ? $pg_data->row()->amount : 0;
          //------ sale ---------
          $this->db->select_sum('amount');
          $this->db->from('tbl_daily_records');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          $this->db->where('name', 'Pregnancy Care');
          if (!empty($From) && !empty($To)) {
            $this->db->where('record_date >=', $From);
            $this->db->where('record_date <=', $To);
          }
          $pg_data = $this->db->get();
          $prg_care = $pg_data->row()->amount ? $pg_data->row()->amount : 0;
          //------ profit ---------
          $this->db->select_sum('amount');
          $this->db->from('tbl_daily_records');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          $this->db->where('type', 'profit');
          if (!empty($From) && !empty($To)) {
            $this->db->where('record_date >=', $From);
            $this->db->where('record_date <=', $To);
          }
          $profit_data = $this->db->get();
          $profit = $profit_data->row()->amount ? $profit_data->row()->amount : 0;
          //------ expense ---------
          $this->db->select_sum('amount');
          $this->db->from('tbl_daily_records');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          $this->db->where('type', 'expense');
          if (!empty($From) && !empty($To)) {
            $this->db->where('record_date >=', $From);
            $this->db->where('record_date <=', $To);
          }
          $exp_data = $this->db->get();
          $expense = $exp_data->row()->amount ? $exp_data->row()->amount : 0;
          $profit_loss = 0;
          $animal_expenses = $medical_exp + $doc_exp;
          $sub_profit = $profit + $milk_income;
          $sub_expense = $expense + $feed_exp + $animal_expenses;
          $data = array(
            'sale' => $sale,
            'purchase' => $purchase,
            'profit_loss' => $sub_profit - $sub_expense,
            'feed_expenses' => $feed_exp,
            'milk_income' => $milk_income,
            'animal_expenses' => $animal_expenses + $prg_care,
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
      $this->form_validation->set_rules('stock_date', 'stock_date', 'required|xss_clean|trim');
      $this->form_validation->set_rules('green_forage', 'green_forage', 'xss_clean|trim');
      $this->form_validation->set_rules('dry_fodder', 'dry_fodder', 'xss_clean|trim');
      $this->form_validation->set_rules('silage', 'silage', 'xss_clean|trim');
      $this->form_validation->set_rules('cake', 'cake', 'xss_clean|trim');
      $this->form_validation->set_rules('grains', 'grains', 'xss_clean|trim');
      $this->form_validation->set_rules('bioproducts', 'bioproducts', 'xss_clean|trim');
      $this->form_validation->set_rules('churi', 'churi', 'xss_clean|trim');
      $this->form_validation->set_rules('oil_seeds', 'oil_seeds', 'xss_clean|trim');
      $this->form_validation->set_rules('minerals', 'minerals', 'xss_clean|trim');
      $this->form_validation->set_rules('bypass_fat', 'bypass_fat', 'xss_clean|trim');
      $this->form_validation->set_rules('toxins', 'toxins', 'xss_clean|trim');
      $this->form_validation->set_rules('buffer', 'buffer', 'xss_clean|trim');
      $this->form_validation->set_rules('yeast', 'yeast', 'xss_clean|trim');
      $this->form_validation->set_rules('calcium', 'calcium', 'xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $stock_date = $this->input->post('stock_date');
        $green_forage = $this->input->post('green_forage');
        $dry_fodder = $this->input->post('dry_fodder');
        $silage = $this->input->post('silage');
        $cake = $this->input->post('cake');
        $grains = $this->input->post('grains');
        $bioproducts = $this->input->post('bioproducts');
        $churi = $this->input->post('churi');
        $oil_seeds = $this->input->post('oil_seeds');
        $minerals = $this->input->post('minerals');
        $bypass_fat = $this->input->post('bypass_fat');
        $toxins = $this->input->post('toxins');
        $buffer = $this->input->post('buffer');
        $yeast = $this->input->post('yeast');
        $calcium = $this->input->post('calcium');
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data = array(
            'farmer_id' => $farmer_data[0]->id,
            'stock_date' => $stock_date,
            'green_forage' => $green_forage,
            'dry_fodder' => $dry_fodder,
            'silage' => $silage,
            'cake' => $cake,
            'grains' => $grains,
            'bioproducts' => $bioproducts,
            'churi' => $churi,
            'oil_seeds' => $oil_seeds,
            'minerals' => $minerals,
            'bypass_fat' => $bypass_fat,
            'toxins' => $toxins,
            'buffer' => $buffer,
            'yeast' => $yeast,
            'calcium' => $calcium,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_stock_handling", $data, 1);
          $res = array(
            'message' => "Record Successfully Inserted!",
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
  } //==================================view_stokes =========================================//
  public function view_stocks()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $page_index = $headers['Index'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $count = $this->db->get_where('tbl_stock_handling', array('farmer_id' => $farmer_data[0]->id))->num_rows();
      $summary = [];
      $this->db->select_sum('green_forage');
      $this->db->select_sum('dry_fodder');
      $this->db->select_sum('silage');
      $this->db->select_sum('cake');
      $this->db->select_sum('grains');
      $this->db->select_sum('bioproducts');
      $this->db->select_sum('churi');
      $this->db->select_sum('oil_seeds');
      $this->db->select_sum('minerals');
      $this->db->select_sum('bypass_fat');
      $this->db->select_sum('toxins');
      $this->db->select_sum('buffer');
      $this->db->select_sum('yeast');
      $this->db->select_sum('calcium');
      $this->db->from('tbl_stock_handling');
      $this->db->where('farmer_id', $farmer_data[0]->id);
      $query = $this->db->get();
      $summary = array(
        'green_forage' => $query->row()->green_forage,
        'dry_fodder' => $query->row()->dry_fodder,
        'silage' => $query->row()->silage,
        'cake' => $query->row()->cake,
        'grains' => $query->row()->grains,
        'bioproducts' => $query->row()->bioproducts,
        'churi' => $query->row()->churi,
        'oil_seeds' => $query->row()->oil_seeds,
        'minerals' => $query->row()->minerals,
        'bypass_fat' => $query->row()->bypass_fat,
        'toxins' => $query->row()->toxins,
        'buffer' => $query->row()->buffer,
        'yeast' => $query->row()->yeast,
        'calcium' => $query->row()->calcium,
      );
      $limit = 20;
      if (!empty($page_index)) {
        $start = ($page_index - 1) * $limit;
      } else {
        $start = 0;
      }
      $this->db->select('*');
      $this->db->from('tbl_stock_handling');
      $this->db->where('farmer_id', $farmer_data[0]->id);
      $this->db->order_by('id', 'desc');
      $this->db->limit($limit, $start);
      $stock_data = $this->db->get();
      $pages = round($count / $limit);
      $pagination = $this->CreatePagination($page_index, $pages);
      $data = [];
      $i = 1;
      foreach ($stock_data->result() as $stock) {
        $newdate = new DateTime($stock->date);
        $data[] = array(
          'stock_date' => $stock->stock_date,
          'green_forage' => $stock->green_forage,
          'dry_fodder' => $stock->dry_fodder,
          'silage' => $stock->silage,
          'cake' => $stock->cake,
          'grains' => $stock->grains,
          'bioproducts' => $stock->bioproducts,
          'churi' => $stock->churi,
          'oil_seeds' => $stock->oil_seeds,
          'minerals' => $stock->minerals,
          'bypass_fat' => $stock->bypass_fat,
          'toxins' => $stock->toxins,
          'buffer' => $stock->buffer,
          'yeast' => $stock->yeast,
          'calcium' => $stock->calcium,
          'date' => $newdate->format('d/m/Y')
        );
        $i++;
      }
      $res = array(
        'message' => "Success!",
        'status' => 200,
        'data' => $data,
        'summary' => $summary,
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
  //==================================TANK =========================================//
  public function view_semen_tank()
  {
    $headers = apache_request_headers();
    $authentication = $headers['Authentication'];
    $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
    if (!empty($farmer_data)) {
      $tank_data = $this->db->get_where('tbl_tank', array('farmer_id' => $farmer_data[0]->id))->result();
      $data = [];
      $i = 1;
      foreach ($tank_data as $tank) {
        $canister_data = $this->db->get_where('tbl_canister', array('farmer_id' => $farmer_data[0]->id, 'tank_id' => $tank->id))->result();
        $data[] = array(
          's_no' => $i,
          'id' => $tank->id,
          'name' => $tank->name,
          'canister' => $canister_data,
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
          $check = $this->db->get_where('tbl_tank', array('farmer_id' => $farmer_data[0]->id, 'name' => $name))->result();
          if (empty($check)) {
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
              'message' => "Record Successfully Inserted!",
              'status' => 200,
            );
            echo json_encode($res);
          } else {
            $res = array(
              'message' => "Tank name already exist!",
              'status' => 201,
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
  public function delete_semen_tank()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $id = $this->input->post('id');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $delete = $this->db->delete('tbl_tank', array('farmer_id' => $farmer_data[0]->id, 'id' => $id));
          $delete2 = $this->db->delete('tbl_canister', array('farmer_id' => $farmer_data[0]->id, 'tank_id' => $id));
          if (!empty($delete) && !empty($delete2)) {
            $res = array(
              'message' => "Tank Successfully Deleted!",
              'status' => 200,
            );
            echo json_encode($res);
          } else {
            $res = array(
              'message' => 'Some error ocurred!',
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
      $this->form_validation->set_rules('farm_bull', 'farm_bull', 'xss_clean|trim');
      $this->form_validation->set_rules('tag_no', 'tag_no', 'xss_clean|trim');
      $this->form_validation->set_rules('bull_name', 'bull_name', 'is_unique[tbl_canister.bull_name]xss_clean|trim');
      $this->form_validation->set_rules('company_name', 'company_name', 'xss_clean|trim');
      $this->form_validation->set_rules('no_of_units', 'no_of_units', 'xss_clean|trim');
      $this->form_validation->set_rules('milk_production_of_mother', 'milk_production_of_mother', 'xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $canister_id = $this->input->post('canister_id');
        $farm_bull = $this->input->post('farm_bull');
        $tag_no = $this->input->post('tag_no');
        $bull_name = $this->input->post('bull_name');
        $company_name = $this->input->post('company_name');
        $no_of_units = $this->input->post('no_of_units');
        $milk_production_of_mother = $this->input->post('milk_production_of_mother');;
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $data_update = array(
            'farm_bull' => $farm_bull,
            'tag_no' => $tag_no,
            'bull_name' => $bull_name,
            'company_name' => $company_name,
            'no_of_units' => $no_of_units,
            'milk_production_of_mother' => $milk_production_of_mother,
            'date' => $cur_date
          );
          $this->db->where('id', $canister_id);
          $zapak = $this->db->update('tbl_canister', $data_update);
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
      $open_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'delivered_date is NOT NULL' => NULL, FALSE))->num_rows();
      $inseminate_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'is_inseminated' => 'Yes'))->num_rows();
      $pregnant_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'is_pregnant' => 'Yes'))->num_rows();
      $not_pregnant_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'is_pregnant' => 'No'))->num_rows();
      $pregnant_data = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'is_pregnant' => 'Yes'))->result();
      $bull_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Bull'))->num_rows();
      $heifer_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Heifer'))->num_rows();
      $milking_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Milking'))->num_rows();
      $calf_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Calf'))->num_rows();
      $dry_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'dry_date is NOT NULL' => NULL, FALSE))->num_rows();
      // $dry_count = 0;
      // date_default_timezone_set("Asia/Calcutta");
      // $cur_date = date("Y-m-d");
      // foreach ($pregnant_data as $pregnant) {
      //   $dry_date = date('Y-m-d', strtotime("+7 months", strtotime($pregnant->pregnancy_test_date)));
      //   if ($cur_date > $dry_date) {
      //     $dry_count++;
      //   }
      // }
      $data = array(
        'open' => $open_count,
        'inseminate' => $inseminate_count,
        'pregnant' => $pregnant_count,
        'not_pregnant' => $not_pregnant_count,
        'dry' => $dry_count,
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
  public function get_animals()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('animal_type', 'animal_type', 'xss_clean|trim');
      $this->form_validation->set_rules('other', 'other', 'xss_clean|trim');
      $this->form_validation->set_rules('group_id', 'group_id', 'xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $animal_type = $this->input->post('animal_type');
        $other = $this->input->post('other');
        $group_id = $this->input->post('group_id');
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          $data = [];
          $this->db->select('*');
          $this->db->from('tbl_my_animal');
          $this->db->where('farmer_id', $farmer_data[0]->id);
          $this->db->order_by('id', 'desc');
          if (!empty($animal_type)) {
            $this->db->where('animal_type', $animal_type);
          }
          if (!empty($group_id) && $group_id != 'none') {
            $this->db->where('assign_to_group', $group_id);
          }
          if (!empty($other)) {
            if ($other == "inseminate") {
              $this->db->where('is_inseminated', 'Yes');
            } else if ($other == "pregnant") {
              $this->db->where('is_pregnant', 'Yes');
            } else if ($other == "not_pregnant") {
              $this->db->where('is_pregnant', 'No');
            } else if ($other == "Open") {
              $this->db->where('delivered_date is NOT NULL', NULL, FALSE);
            } else if ($other == "Dry") {
              $this->db->where('dry_date is NOT NULL', NULL, FALSE);
            } else if ($other == "repeater") {
              $this->db->where('id', 0);
            }
          }
          $animal_data = $this->db->get();
          $groups[] = array(
            'value' => "none",
            'label' => "None",
          );;
          foreach ($animal_data->result() as $animal) {
            $newdate = new DateTime($animal->date);
            $a = 1;
            // if ($other == "Dry") {
            //   $dry_date = date('Y-m-d', strtotime("+7 months", strtotime($animal->pregnancy_test_date)));
            //   if ($cur_date > $dry_date) {
            //     $a = 1;
            //   } else {
            //     $a = 0;
            //   }
            // }
            $group_data = $this->db->get_where('tbl_group', array('id' => $animal->assign_to_group, 'farmer_id' => $farmer_data[0]->id))->result();
            if ($a == 1) {
              if ($animal->insemination_date = "undefined") {
                $insemination_date = '';
              } else {
                $insemination_date = $animal->insemination_date;
              }
              $labels = array_column($groups, 'label');
              if (!in_array($group_data[0]->name, $labels)) {
                $groups[] = array(
                  'value' => $group_data[0]->id,
                  'label' => $group_data[0]->name,
                );
              }
              $data[] = array(
                'id' => $animal->id,
                'animal_type' => $animal->animal_type,
                'assign_to_group' => $group_data[0]->name,
                'animal_name' => $animal->animal_name,
                'tag_no' => $animal->tag_no,
                'dob' => $animal->dob,
                'father_name' => $animal->father_name,
                'mother_name' => $animal->mother_name,
                'weight' => $animal->weight,
                'age' => $animal->age,
                'breed_type' => $animal->breed_type,
                'semen_brand' => $animal->semen_brand,
                'animal_gender' => $animal->animal_gender,
                'is_inseminated' => $animal->is_inseminated,
                'insemination_type' => $animal->insemination_type,
                'insemination_date' => $insemination_date,
                'is_pregnant' => $animal->is_pregnant,
                'pregnancy_test_date' => $animal->pregnancy_test_date,
                'service_status' => $animal->service_status,
                'in_house' => $animal->in_house,
                'lactation' => $animal->lactation,
                'calving_date' => $animal->calving_date,
                'insured_value' => $animal->insured_value,
                'insurance_no' => $animal->insurance_no,
                'renewal_period' => $animal->renewal_period,
                'insurance_date' => $animal->insurance_date,
                'dry_date' => $animal->dry_date,
                'delivered_date' => $animal->delivered_date,
                'date' => $newdate->format('d/m/Y'),
              );
            }
          }
          $res = array(
            'message' => "Success!",
            'status' => 200,
            'data' => $data,
            'groups' => $groups,
            'group_id' => $group_id
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
  public function update_animal_status()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      $headers = apache_request_headers();
      $authentication = $headers['Authentication'];
      $this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
      $this->form_validation->set_rules('status', 'status', 'required|xss_clean|trim');
      $this->form_validation->set_rules('date', 'date', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $date = $this->input->post('date');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
          //---animal cycle entry -----
          $data = array(
            'record_date' => $date,
            'farmer_id' => $farmer_data[0]->id,
            'animal_id' => $id,
            'status' => $status,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_animal_cycle", $data, 1);
          if ($status == 'Dry') {
            $data_update = array(
              'dry_date' => $date,
            );
          } else {
            $data_update = array(
              'delivered_date' => $date,
              'is_pregnant' => 'No',
              'pregnancy_test_date' => '',
              'dry_date' => '',
            );
          }
          $this->db->where('id', $id);
          $zapak = $this->db->update('tbl_my_animal', $data_update);
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
}
//==============================================================END MANAGECONTROLLER====================================//
