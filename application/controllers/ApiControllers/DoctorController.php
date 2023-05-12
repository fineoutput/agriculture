<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class DoctorController extends CI_Controller
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
    //============================================= GetRequests ============================================//
    public function HomeData()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            //---- Doctor slider data -------
            $DoctorSlider_data = $this->db->get_where('tbl_doctorsliderslider', array('is_active' => 1))->result();
            $data = [];
            $doctorslider = [];
            foreach ($DoctorSlider_data as $doctorslide) {
                if (!empty($doctorslide->image)) {
                    $image = base_url() . $doctorslide->image;
                } else {
                    $image = '';
                }
                $doctorslider[] = $image;
            }
            //---- Cart Count -------
            $CartCount = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
            $data =  array('Doctor_slider' => $doctorslider, 'CartCount' => $CartCount);
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
    public function GetRequests()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($doctor_data)) {
            $count = $this->db->get_where('tbl_doctor_req', array('doctor_id' => $doctor_data[0]->id, 'is_expert' => $doctor_data[0]->is_expert, 'payment_status' => 1))->num_rows();
            $limit = 20;
            if (!empty($page_index)) {
                $start = ($page_index - 1) * $limit;
            } else {
                $start = 0;
            }
            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $this->db->where('is_expert', $doctor_data[0]->is_expert);
            $this->db->where('payment_status', 1);
            $this->db->order_by('id', 'desc');
            $this->db->limit($limit, $start);
            $RequestData = $this->db->get();
            $pages = round($count / $limit);
            $pagination = $this->CreatePagination($page_index, $pages);
            $data = [];
            if (!empty($RequestData)) {
                foreach ($RequestData->result() as $request) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $request->farmer_id))->result();
                    $newDate = new DateTime($request->date);
                    if ($request->status == 0) {
                        $status = 'Pending';
                        $bg_color = '#e4a11b';
                    } elseif ($request->status == 1) {
                        $status = 'Completed';
                        $bg_color = '#139c49';
                    }
                    if (!empty($request->image1)) {
                        $image1 = base_url() . $request->image1;
                    } else {
                        $image1 = '';
                    }
                    if (!empty($request->image2)) {
                        $image2 = base_url() . $request->image2;
                    } else {
                        $image2 = '';
                    }
                    if (!empty($request->image3)) {
                        $image3 = base_url() . $request->image3;
                    } else {
                        $image3 = '';
                    }
                    if (!empty($request->image4)) {
                        $image4 = base_url() . $request->image4;
                    } else {
                        $image4 = '';
                    }
                    if (!empty($request->image5)) {
                        $image5 = base_url() . $request->image5;
                    } else {
                        $image5 = '';
                    }
                    $data[] = array(
                        'id' => $request->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'farmer_village' => $farData[0]->village,
                        'reason' => $request->reason,
                        'description' => $request->description,
                        'is_expert' => $request->is_expert,
                        'fees' => $request->fees,
                        'image1' => $image1,
                        'image2' => $image2,
                        'image3' => $image3,
                        'image4' => $image4,
                        'image5' => $image5,
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'date' => $newDate->format('d/m/Y'),
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
                    'message' => "No Orders Found!",
                    'status' => 201,
                    'data' => [],
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
    //============================================= ReqMarkComplete ============================================//
    public function ReqMarkComplete($id)
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($doctor_data)) {
            $data_update = array(
                'status' => 1,
            );
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $this->db->where('is_expert', $doctor_data[0]->is_expert);
            $this->db->where('id', $id);
            $zapak = $this->db->update('tbl_doctor_req', $data_update);
            if (!empty($zapak)) {
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => "Some error occurred!",
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
    }
    //============================================= GetProfile ============================================//
    public function GetProfile()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($doctor_data)) {
            if (!empty($doctor_data[0]->image)) {
                $image = base_url() . $doctor_data[0]->image;
            } else {
                $image = '';
            }
            $state_data = $this->db->get_where('all_states', array('id' => $doctor_data[0]->state,))->result();
            if (!empty($state_data)) {
                $state = $state_data[0]->state_name;
            } else {
                $state = '';
            }
            $data = array(
                'name' => $doctor_data[0]->name,
                'district' => $doctor_data[0]->district,
                'city' => $doctor_data[0]->city,
                'state' => $state,
                'phone' => $doctor_data[0]->phone,
                'email' => $doctor_data[0]->email,
                'type' => $doctor_data[0]->type,
                'degree' => $doctor_data[0]->degree,
                'experience' => $doctor_data[0]->experience,
                'qualification' => $doctor_data[0]->qualification,
                'commission' => $doctor_data[0]->commission,
                'aadhar_no' => $doctor_data[0]->aadhar_no,
                'image' => $image,
                'is_expert' => $doctor_data[0]->is_expert,
                'expertise' => $doctor_data[0]->expertise,
            );
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
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
    //====================================================== UpdateProfile ================================================//
    public function UpdateProfile()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('expertise', 'expertise', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $expertise = $this->input->post('expertise');
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    $data_update = array('expertise' => $expertise,);
                    $this->db->where('id', $doctor_data[0]->id);
                    $zapak = $this->db->update('tbl_doctor', $data_update);
                    $res = array(
                        'message' => "Success",
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
    //============================================= PaymentInfo ============================================//
    public function PaymentInfo()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($doctor_data)) {
            $this->db->select('*');
            $this->db->from('tbl_payment_txn');
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $this->db->where('req_id is NOT NULL', NULL, FALSE);
            $this->db->order_by('id', 'desc');
            $this->db->limit(20);
            $txn_data = $this->db->get();
            $data = [];
            foreach ($txn_data->result() as $txn) {
                $newDate = new DateTime($txn->date);
                $data[] = array(
                    'req_id' => $txn->req_id,
                    'cr' => $txn->cr,
                    'date' => $newDate->format('d/m/Y'),
                );
            }
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
                'account' => $doctor_data[0]->account,
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
    //============================= AdminPaymentInfo =====================================//
    public function AdminPaymentInfo()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($doctor_data)) {
            $this->db->select('*');
            $this->db->from('tbl_payments_req');
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $this->db->order_by('id', 'desc');
            $this->db->limit(20);
            $txn_data = $this->db->get();
            $data = [];
            foreach ($txn_data->result() as $txn) {
                $newDate = new DateTime($txn->date);
                if ($txn->status == 0) {
                    $status = 'Pending';
                    $bg_color = '#65bcd7';
                } elseif ($txn->status == 1) {
                    $status = 'Completed';
                    $bg_color = '#139c49';
                } elseif ($txn->status == 2) {
                    $status = 'Rejected';
                    $bg_color = '#dc4c64';
                }
                $data[] = array(
                    'req_id' => $txn->id,
                    'amount' => $txn->amount,
                    'status' => $status,
                    'bg_color' => $bg_color,
                    'date' => $newDate->format('d/m/Y'),
                );
            }
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
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
    //============================= DocReqPayment =====================================//
    public function DocReqPayment()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('amount', 'amount', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $amount = $this->input->post('amount');
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    if ($amount > $doctor_data[0]->account) {
                        $res = array(
                            'message' => 'Amount should be less than to your wallet amount!',
                            'status' => 201
                        );
                        echo json_encode($res);
                        die();
                    }
                    $reqData = $this->db->get_where('tbl_payments_req', array('status' => 0, 'doctor_id' => $doctor_data[0]->id,))->result();
                    if (empty($reqData)) {
                        date_default_timezone_set("Asia/Calcutta");
                        $cur_date = date("Y-m-d H:i:s");
                        $data_insert = array(
                            'doctor_id' => $doctor_data[0]->id,
                            'available' => $doctor_data[0]->account,
                            'amount' => $amount,
                            'status' => 0,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_payments_req", $data_insert, 1);
                        $res = array(
                            'message' => "Success",
                            'status' => 200,
                        );
                        echo json_encode($res);
                    } else {
                        $res = array(
                            'message' => "Can not submit more than one request!",
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
    //============================= HomeData =====================================//
    public function HomeData()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        $cur_date = date("Y-m-d");
        if (!empty($doctor_data)) {
            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $this->db->like("date", $cur_date);
            $today_req = $this->db->count_all_results();
            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $total_req = $this->db->count_all_results();
            $this->db->select_sum('cr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $this->db->where('req_id is NOT NULL', NULL, FALSE);
            $this->db->like("date", $cur_date);
            $query = $this->db->get();
            if (!empty($query->row()->cr)) {
                $today_income = $query->row()->cr;
            } else {
                $today_income = 0;
            }
            $this->db->select_sum('cr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $this->db->where('req_id is NOT NULL', NULL, FALSE);
            $query2 = $this->db->get();
            if (!empty($query2->row()->cr)) {
                $total_income = $query2->row()->cr;
            } else {
                $total_income = 0;
            }
            $data = [];
            $data = array(
                'today_req' => $today_req,
                'total_req' => $total_req,
                'today_income' =>  round($today_income, 2),
                'total_income' => round($total_income, 2),
                'is_expert' => $doctor_data[0]->is_expert
            );
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
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
    //------------------------------Semen Management ---------------
    public function doc_semen_tank()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        if (!empty($doctor_data)) {
            $tank_data = $this->db->get_where('tbl_doctor_tank', array('doctor_id' => $doctor_data[0]->id))->result();
            $data = [];
            $i = 1;
            foreach ($tank_data as $tank) {
                $canister_data = $this->db->get_where('tbl_doctor_canister', array('doctor_id' => $doctor_data[0]->id, 'tank_id' => $tank->id))->result();
                $data[] = array(
                    's_no' => $i,
                    'name' => $tank->name,
                    'tank_id' => $tank->id,
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
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        if (!empty($doctor_data)) {
          $delete = $this->db->delete('tbl_doctor_tank', array('doctor_id' => $doctor_data[0]->id, 'id'=> $id));
          $delete2 = $this->db->delete('tbl_doctor_canister', array('doctor_id' => $doctor_data[0]->id, 'tank_id'=> $id));
          if(!empty($delete) && !empty($delete2)){
          $res = array(
            'message' => "Tank Successfully Deleted!",
            'status' => 200,
          );
          echo json_encode($res);
        }else{
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
    public function add_doc_semen_tank()
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
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    $check = $this->db->get_where('tbl_doctor_tank', array('doctor_id' => $doctor_data[0]->id, 'name' => $name))->result();
                    if (empty($check)) {
                        $data = array(
                            'doctor_id' => $doctor_data[0]->id,
                            'name' => $name,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_doctor_tank", $data, 1);
                        //---- create 6 canister ----
                        for ($i = 0; $i < 6; $i++) {
                            $data = array(
                                'doctor_id' => $doctor_data[0]->id,
                                'tank_id' => $last_id,
                                'date' => $cur_date
                            );
                            $last_id2 = $this->base_model->insert_table("tbl_doctor_canister", $data, 1);
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
    //==============================================================CANISTER==============================================//
    public function update_doc_canister()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('canister_id', 'canister_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('bull_name', 'bull_name', 'xss_clean|trim');
            $this->form_validation->set_rules('company_name', 'company_name', 'xss_clean|trim');
            $this->form_validation->set_rules('no_of_units', 'no_of_units', 'xss_clean|trim');
            $this->form_validation->set_rules('milk_production_of_mother', 'milk_production_of_mother', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $canister_id = $this->input->post('canister_id');
                $bull_name = $this->input->post('bull_name');
                $company_name = $this->input->post('company_name');
                $no_of_units = $this->input->post('no_of_units');
                $milk_production_of_mother = $this->input->post('milk_production_of_mother');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    $data = [];
                    $data_update = array(
                        'bull_name' => $bull_name,
                        'company_name' => $company_name,
                        'no_of_units' => $no_of_units,
                        'milk_production_of_mother' => $milk_production_of_mother,
                        'date' => $cur_date
                    );
                    $this->db->where('id', $canister_id);
                    $zapak = $this->db->update('tbl_doctor_canister', $data_update);
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
    //==============================================================sell_semen==============================================//
    public function sell_semen()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('tank_id', 'tank_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('canister', 'canister', 'required|xss_clean|trim');
            $this->form_validation->set_rules('quantity', 'quantity', 'required|xss_clean|trim');
            $this->form_validation->set_rules('farmer_name', 'farmer_name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('farmer_phone', 'farmer_phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $tank_id = $this->input->post('tank_id');
                $canister = $this->input->post('canister');
                $quantity = $this->input->post('quantity');
                $farmer_name = $this->input->post('farmer_name');
                $farmer_phone = $this->input->post('farmer_phone');
                $address = $this->input->post('address');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    $canister_data = $this->db->get_where('tbl_doctor_canister', array('doctor_id' => $doctor_data[0]->id, 'tank_id' => $tank_id))->result();
                    $index = $canister - 1;
                    if ($canister_data[$index]->no_of_units >= $quantity) {
                        $data = [];
                        $data_insert = array(
                            'doctor_id' => $canister_data[$index]->doctor_id,
                            'tank_id' => $canister_data[$index]->tank_id,
                            'canister' => $canister,
                            'bull_name' => $canister_data[$index]->bull_name,
                            'company_name' => $canister_data[$index]->company_name,
                            'no_of_units' => $canister_data[$index]->no_of_units,
                            'sell_unit' => $quantity,
                            'milk_production_of_mother' => $canister_data[$index]->milk_production_of_mother,
                            'farmer_name' => $farmer_name,
                            'farmer_phone' => $farmer_phone,
                            'address' => $address,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_doctor_semen_txn", $data_insert, 1);
                        $data_update = array(
                            'no_of_units' => $canister_data[$index]->no_of_units - $quantity,
                        );
                        $this->db->where('id', $canister_data[$canister]->id);
                        $zapak = $this->db->update('tbl_doctor_canister', $data_update);
                        $res = array(
                            'message' => "Record Successfully saved!",
                            'status' => 200,
                        );
                        echo json_encode($res);
                    } else {
                        $res = array(
                            'message' => "Left Semen Unit is " . $canister_data[$canister]->no_of_units,
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
    //------------------------------sell_transactions ---------------
    public function sell_transactions()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        if (!empty($doctor_data)) {
            $sell_data = $this->db->order_by('id', 'desc')->get_where('tbl_doctor_semen_txn', array('doctor_id' => $doctor_data[0]->id))->result();
            $tank_data = $this->db->get_where('tbl_doctor_tank', array('id' => $sell_data[0]->tank_id))->result();
            $data = [];
            $i = 1;
            foreach ($sell_data as $sell) {
                $newDate = new DateTime($sell->date);
                $data[] = array(
                    's_no' => $i,
                    'tank' => $tank_data[0]->name,
                    'canister' => 'Canister ' . $sell->canister,
                    'sell_unit' => $sell->sell_unit,
                    'farmer_name' => $sell->farmer_name,
                    'farmer_phone' => $sell->farmer_phone,
                    'address' => $sell->address,
                    'date' => $newDate->format('d/m/Y'),
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
}
  //=========================================END DoctorController======================================//
