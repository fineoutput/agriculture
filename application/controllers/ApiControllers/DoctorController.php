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
                'state_id' => $doctor_data[0]->state,
                'phone' => $doctor_data[0]->phone,
                'email' => $doctor_data[0]->email,
                'type' => $doctor_data[0]->type,
                'pincode' => $doctor_data[0]->pincode,
                'degree' => $doctor_data[0]->degree,
                'experience' => $doctor_data[0]->experience,
                'qualification' => $doctor_data[0]->qualification,
                'commission' => $doctor_data[0]->commission,
                'aadhar_no' => $doctor_data[0]->aadhar_no,
                'image' => $image,
                'is_expert' => $doctor_data[0]->is_expert,
                'expertise' => $doctor_data[0]->expertise,
                'bank_name' => $doctor_data[0]->bank_name,
                'bank_phone' => $doctor_data[0]->bank_phone,
                'bank_ac' => $doctor_data[0]->bank_ac,
                'ifsc' => $doctor_data[0]->ifsc,
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
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('email', 'email', 'required|xss_clean|trim');
            $this->form_validation->set_rules('district', 'district', 'required|xss_clean|trim');
            $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
            $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
            $this->form_validation->set_rules('doc_type', 'doc_type', 'required|xss_clean|trim');
            $this->form_validation->set_rules('qualification', 'qualification', 'required|xss_clean|trim');
            $this->form_validation->set_rules('experience', 'experience', 'xss_clean|trim');
            $this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
            $this->form_validation->set_rules('aadhar_no', 'aadhar_no', 'xss_clean|trim');
            $this->form_validation->set_rules('expertise', 'expertise', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $district = $this->input->post('district');
                $city = $this->input->post('city');
                $state = $this->input->post('state');
                $doc_type = $this->input->post('doc_type');
                $experience = $this->input->post('experience');
                $pincode = $this->input->post('pincode');
                $aadhar_no = $this->input->post('aadhar_no');
                $expertise = $this->input->post('expertise');
                $qualification = $this->input->post('qualification');
                $this->load->library('upload');
                $image = '';
                $img1 = 'image';
                if (!empty($_FILES['image'])) {
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/doctor/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "image" . date("YmdHis");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1)) {
                            $upload_error = $this->upload->display_errors();
                            $respone['status'] = false;
                            $respone['message'] = $upload_error;
                            echo json_encode($respone);
                            die();
                        } else {
                            $file_info = $this->upload->data();
                            $image = "assets/uploads/doctor/" . $file_info['file_name'];
                        }
                    }
                }
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    if ($doc_type == 1) {
                        $dt = "Vet";
                    } else if ($doc_type == 2) {
                        $dt = "Livestock Assistant";
                    } else {
                        $dt = "Private Practitioner";
                    }
                    $data_update = array(
                        'name' => $name,
                        'email' => $email,
                        'district' => $district,
                        'city' => $city,
                        'state' => $state,
                        'type' => $dt,
                        'qualification' => $qualification,
                        'experience' => $experience,
                        'pincode' => $pincode,
                        'aadhar_no' => $aadhar_no,
                        'expertise' => $expertise,
                        'image' => $image ? $image : $doctor_data[0]->image,
                    );
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
    //============================= updateBankInfo =====================================//
    public function updateBankInfo()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('bank_name', 'bank_name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('bank_phone', 'bank_phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('bank_ac', 'bank_ac', 'required|xss_clean|trim');
            $this->form_validation->set_rules('ifsc', 'ifsc', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $bank_name = $this->input->post('bank_name');
                $bank_phone = $this->input->post('bank_phone');
                $bank_ac = $this->input->post('bank_ac');
                $ifsc = $this->input->post('ifsc');
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $data_update = array(
                        'bank_name' => $bank_name,
                        'bank_phone' => $bank_phone,
                        'bank_ac' => $bank_ac,
                        'ifsc' => $ifsc,
                    );
                    $this->db->where('id', $doctor_data[0]->id);
                    $zapak = $this->db->update('tbl_doctor', $data_update);
                    if (!empty($zapak)) {
                        $res = array(
                            'message' => "Success",
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
    //====================================================== UpdateLocation ================================================//
    public function UpdateLocation()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('latitude', 'Latitude', 'required|xss_clean|trim');
            $this->form_validation->set_rules('longitude', 'Longitude', 'required|xss_clean|trim');
            $this->form_validation->set_rules('fcm_token', 'Fcm Token', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $fcm_token = $this->input->post('fcm_token');
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    $data_update = array('latitude' => $latitude, 'longitude' => $longitude, 'fcm_token' => $fcm_token);
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
                        //--- send email to admin -----------------
                        $config = array(
                            'protocol' => 'smtp',
                            'smtp_host' => SMTP_HOST,
                            'smtp_port' => SMTP_PORT,
                            'smtp_user' => USER_NAME, // change it to yours
                            'smtp_pass' => PASSWORD, // change it to yours
                            'mailtype' => 'html',
                            'charset' => 'iso-8859-1',
                            'wordwrap' => true
                        );
                        $message2 = '
                            Hello Admin<br/><br/>
                            You have received new payment request from a doctor and below are the details<br/><br/>
                            <b>Doctor ID</b> - ' . $doctor_data[0]->id . '<br/>
                            <b>Doctor Name</b> - ' . $doctor_data[0]->name . '<br/>
                            <b>Request ID</b> - ' . $last_id . '<br/>
                            <b>Available Balance</b> - ₹' . $doctor_data[0]->account . '<br/>
                            <b>Requested Amount</b> - ₹' . $amount . '<br/>
                              ';
                        $this->load->library('email', $config);
                        $this->email->set_newline("");
                        $this->email->from(EMAIL); // change it to yours
                        $this->email->to(TO, 'Dairy Muneem'); // change it to yours
                        $this->email->subject('New payment request received from a doctor');
                        $this->email->message($message2);
                        if ($this->email->send()) {
                        } else {
                        }
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
            //---- Doctor slider data -------
            $DoctorSliderData = $this->db->get_where('tbl_doctorsliderslider', array('is_active' => 1))->result();
            $data = [];
            $doctorSlider = [];
            foreach ($DoctorSliderData as $slider) {
                if (!empty($slider->image)) {
                    $image = base_url() . $slider->image;
                } else {
                    $image = '';
                }
                $doctorSlider[] = array('image' => $image);
            }
            //---- Doctor notification data -------
            $notifications = [];
            $DoctorNotifications = $this->db->get_where('tbl_doctor_notification', array('doctor_id' => $doctor_data[0]->id))->result();
            foreach ($DoctorNotifications as $notification) {
                $newDate = new DateTime($notification->date);
                $notifications[] = array(
                    'id' => $notification->id,
                    'name' => $notification->name,
                    'image' => $notification->image ? base_url() . $notification->image : '',
                    'description' => $notification->dsc,
                    'date' => $newDate->format('d-m-y, g:i a'),
                );
            }
            $this->db->select('*');
            $this->db->from('tbl_doctor_notification');
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $count_dr = $this->db->count_all_results();
            $data = array(
                'today_req' => $today_req,
                'total_req' => $total_req,
                'today_income' =>  round($today_income, 2),
                'total_income' => round($total_income, 2),
                'is_expert' => $doctor_data[0]->is_expert,
                'doctor_slider' => $doctorSlider,
                'notification_data' => $notifications,
                'notification_count' => $count_dr
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
                    $delete = $this->db->delete('tbl_doctor_tank', array('doctor_id' => $doctor_data[0]->id, 'id' => $id));
                    $delete2 = $this->db->delete('tbl_doctor_canister', array('doctor_id' => $doctor_data[0]->id, 'tank_id' => $id));
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
                        $this->db->where('id', $canister_data[$index]->id);
                        $zapak = $this->db->update('tbl_doctor_canister', $data_update);
                        $res = array(
                            'message' => "Record Successfully saved!",
                            'status' => 200,
                        );
                        echo json_encode($res);
                    } else {
                        $a = $canister_data[$canister]->no_of_units ? $canister_data[$canister]->no_of_units : 0;
                        $res = array(
                            'message' => "Available semen unit is " . $a,
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
