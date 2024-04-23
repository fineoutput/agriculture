<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Doctor extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }
    //****************************view Doctor Function**************************************
    public function new_doctors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_approved', 0);
            $this->db->order_by('id', 'desc');
            $data['doctor_data'] = $this->db->get();
            $data['heading'] = "New";
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //================================accepted_doctors=======================\\
    public function accepted_doctors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_approved', 1);
            $this->db->order_by('id', 'desc');
            $data['doctor_data'] = $this->db->get();
            $data['heading'] = "Accepted";
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function rejected_doctors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_approved', 2);
            $this->db->order_by('id', 'desc');
            $data['doctor_data'] = $this->db->get();
            $data['heading'] = "Rejected";
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function view_pdf($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id=base64_decode($idd);
        
            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('payment_status', 1);
            $this->db->where('id', $id);
            $this->db->order_by('id', 'desc');

            $request_data = $this->db->get()->row();

            $data['data'] = $request_data;


            $this->load->view('admin/doctor/view_pdf', $data);
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************view Doctor Function**************************************
    public function doctor_request()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('payment_status', 1);
            $this->db->order_by('id', 'desc');

            $request_data = $this->db->get();
            $count = 0;
            foreach ($request_data->result() as $datas) {
                $this->db->select('*');
                $this->db->from('tbl_payment_txn');
                $this->db->where('req_id', $datas->id);
                $this->db->where('doctor_id	', $datas->doctor_id);
                $dsa_ptx = $this->db->get()->row();
                if (!empty($dsa_ptx->cr)) {
                    $count = $count + $datas->fees - $dsa_ptx->cr;
                }
            }
            $data['count'] = $count;


            $data['request_data'] = $request_data;






            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor_req');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Delete Doctor Function**************************************
    public function delete_doctor($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($this->load->get_var('position') == "Super Admin") {
                $zapak = $this->db->delete('tbl_doctor', array('id' => $id));
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Data deleted successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            } else {
                $data['e'] = "Sorry You Don't Have Permission To Delete Anything.";
                // exit;
                $this->load->view('errors/error500admin', $data);
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    //****************************Update Doctor Status Function**************************************
    public function updateDoctorStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($t == "reject") {
                $data_update = array(
                    'is_approved' => 2
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t == "approve") {
                $data_update = array(
                    'is_approved' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
            if ($t == "inactive") {
                $data_update = array(
                    'is_active' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
            if ($t == "active") {
                $data_update = array(
                    'is_active' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
            if ($t == "normal") {
                $data_update = array(
                    'is_expert' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
            if ($t == "expert") {
                $data_update = array(
                    'is_expert' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    public function update_doctor($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['doctor'] = $dsa->row();
            $this->db->select('*');
            $this->db->from('all_states');
            //$this->db->where('id',$usr);
            $data['state_data'] = $this->db->get();
            $data['expert_data'] = $this->db->get_where('tbl_expertise_category', array('is_active' => 1,))->result();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/update_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function set_commission_doctor($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['doctor'] = $dsa->row();
            $data['user_name'] = $this->load->get_var('user_name');
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/set_comission');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Insert Doctor comission Function**************************************
    public function add_doctor_data2($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('set_commission', 'set_commission', 'required|xss_clean');
                $this->form_validation->set_rules('fees', 'fees', 'required|xss_clean');
                if ($this->form_validation->run() == TRUE) {
                    $set_commission = $this->input->post('set_commission');
                    $fees = $this->input->post('fees');

                    $id = base64_decode($idd);
                    $data['id'] = $idd;
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $data_update = array(
                        'commission' => $set_commission,
                        'fees' => $fees,
                    );
                    $this->db->where('id', $id);
                    $last_id = $this->db->update('tbl_doctor', $data_update);
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data updated successfully');
                        redirect("dcadmin/Doctor/accepted_doctors", "refresh");
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
    //**************************** Doctor Fees Function**************************************
    public function add_fees_doctor($y)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $id = base64_decode($y);
            $data['id'] = $y;
            $data['user_name'] = $this->load->get_var('user_name');
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/add_fees');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Insert Doctor Fees Function**************************************
    public function add_doctor_data3($y)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('fees', 'fees', 'xss_clean');
                $this->form_validation->set_rules('expertise', 'expertise', 'xss_clean');
                if ($this->form_validation->run() == TRUE) {
                    $fees = $this->input->post('fees');
                    $expertise = $this->input->post('expertise');
                    $id = base64_decode($y);
                    $data['id'] = $y;
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $data_update = array(
                        'fees' => $fees,
                        'expertise' => $expertise,
                        'is_active2' => 1
                    );
                    $this->db->where('id', $id);
                    $last_id = $this->db->update('tbl_doctor', $data_update);
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data updated successfully');
                        redirect("dcadmin/doctor/view_doctor", "refresh");
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
    //****************************Insert Doctor Fees Function**************************************
    public function update_doctor_data($y)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('hi_name', 'hi_name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pn_name', 'pn_name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('email', 'email', 'required|xss_clean|trim');
                $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
                $this->form_validation->set_rules('degree', 'degree', 'xss_clean|trim');
                $this->form_validation->set_rules('experience', 'experience', 'xss_clean|trim');
                $this->form_validation->set_rules('district', 'district', 'required|xss_clean|trim');
                $this->form_validation->set_rules('hi_district', 'hi_district', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pn_district', 'pn_district', 'required|xss_clean|trim');
                $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
                $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
                $this->form_validation->set_rules('hi_city', 'hi_city', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pn_city', 'pn_city', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
                $this->form_validation->set_rules('aadhar_no', 'aadhar_no', 'required|xss_clean|trim');
                $this->form_validation->set_rules('expert_category[]', 'expert_category', 'required|xss_clean');

                if ($this->form_validation->run() == TRUE) {
                    $name = $this->input->post('name');
                    $hi_name = $this->input->post('hi_name');
                    $pn_name = $this->input->post('pn_name');
                    $email = $this->input->post('email');
                    $type = $this->input->post('type');
                    $degree = $this->input->post('degree');
                    $experience = $this->input->post('experience');
                    $district = $this->input->post('district');
                    $hi_district = $this->input->post('hi_district');
                    $pn_district = $this->input->post('pn_district');
                    $state = $this->input->post('state');
                    $city = $this->input->post('city');
                    $hi_city = $this->input->post('hi_city');
                    $pn_city = $this->input->post('pn_city');
                    $pincode = $this->input->post('pincode');
                    $aadhar_no = $this->input->post('aadhar_no');
                    $expert_category = $this->input->post('expert_category');
                    $id = base64_decode($y);
                    $data['id'] = $y;
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    //--------------image-----------------------------------
                    $this->load->library('upload');
                    $image = "";
                    $img1 = 'image';
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/doctor/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "doctor" . date("YmdHis");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1)) {
                            $upload_error = $this->upload->display_errors();
                            // echo json_encode($upload_error);
                            echo $upload_error;
                        } else {
                            $file_info = $this->upload->data();
                            $image = "assets/uploads/doctor/" . $file_info['file_name'];
                            $file_info['new_name'] = $image;
                            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                            $nnnn = $file_info['file_name'];
                            // echo json_encode($file_info);
                        }
                    }
                    $vendor_data = $this->db->get_where('tbl_doctor', array('id' => $id,))->result();
                    if (empty($image)) {
                        $image = $vendor_data[0]->image;
                    }
                    $data_update = array(
                        'name' => $name,
                        'hi_name' => $hi_name,
                        'pn_name' => $pn_name,
                        'email' => $email,
                        'type' => $type,
                        'degree' => $degree,
                        'experience' => $experience,
                        'district' => $district,
                        'hi_district' => $hi_district,
                        'pn_district' => $pn_district,
                        'state' => $state,
                        'city' => $city,
                        'hi_city' => $hi_city,
                        'pn_city' => $pn_city,
                        'pincode' => $pincode,
                        'aadhar_no' => $aadhar_no,
                        'expert_category' => json_encode($expert_category),
                        'image' => $image,
                    );
                    $this->db->where('id', $id);
                    $last_id = $this->db->update('tbl_doctor', $data_update);
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data updated successfully');
                        redirect("dcadmin/Doctor/accepted_doctors", "refresh");
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
}
