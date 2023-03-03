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
    public function view_doctor()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            //$this->db->where('id',$usr);
            $data['doctor_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('all_states');
            //$this->db->where('id',$usr);
            $data['state_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('all_cities');
            //$this->db->where('id',$usr);
            $data['city_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor');
            $this->load->view('admin/common/footer_view');
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
            $this->db->from('tbl_expert_doctor_req');
            $this->db->where('payment_status',1);
            $data['request_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor_req');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Add Doctor Function**************************************
    public function add_doctor()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('all_states');
            //$this->db->where('id',$usr);
            $data['state_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('all_cities');
            //$this->db->where('id',$usr);
            $data['city_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/add_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Insert Doctor Data Function**************************************
    public function add_doctor_data($t, $iw = "")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('name', 'name', 'required|xss_clean');
                $this->form_validation->set_rules('degree', 'degree', 'required|xss_clean');
                $this->form_validation->set_rules('district', 'district', 'required|xss_clean');
                $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');
                $this->form_validation->set_rules('type_colume', 'type_colume', 'xss_clean');
                // $this->form_validation->set_rules('type_colume2', 'type_colume2', 'xss_clean');
                $this->form_validation->set_rules('vet', 'vet', 'xss_clean');
                $this->form_validation->set_rules('private_colume', 'private_colume', 'required|xss_clean');
                // $this->form_validation->set_rules('degree_english', 'degree_english', 'required|required|xss_clean');
                // $this->form_validation->set_rules('degree_hindi', 'degree_hindi', 'required|xss_clean');
                // $this->form_validation->set_rules('degree_punjabi', 'degree_punjabi', 'required|xss_clean');
                $this->form_validation->set_rules('experiance_colume', 'experiance_colume', 'required|xss_clean');
                $this->form_validation->set_rules('assistant_colume', 'assistant_colume', 'required|xss_clean');
                $this->form_validation->set_rules('education_colume', 'education_colume', 'required|xss_clean');
                // $this->form_validation->set_rules('district_english', 'district_english', 'required|xss_clean');
                // $this->form_validation->set_rules('district_hindi', 'district_hindi', 'required|xss_clean');
                // $this->form_validation->set_rules('district_punjabi', 'district_punjabi', 'required|xss_clean');
                $this->form_validation->set_rules('state_colume', 'state_colume', 'required|xss_clean');
                $this->form_validation->set_rules('city_colume', 'city_colume', 'required|xss_clean');
                $this->form_validation->set_rules('phone_colume', 'phone_colume', 'required|xss_clean');
                if ($this->form_validation->run() == TRUE) {
                    $name = $this->input->post('name');
                    $degree = $this->input->post('degree');
                    $district = $this->input->post('district');
                    $email = $this->input->post('email');
                    $type_colume = $this->input->post('type_colume');
                    // $type_colume2=$this->input->post('type_colume2');
                    $vet = $this->input->post('vet');
                    $private_colume = $this->input->post('private_colume');
                    // $degree_english=$this->input->post('degree_english');
                    // $degree_hindi=$this->input->post('degree_hindi');
                    // $degree_punjabi=$this->input->post('degree_punjabi');
                    $experiance_colume = $this->input->post('experiance_colume');
                    $assistant_colume = $this->input->post('assistant_colume');
                    $education_colume = $this->input->post('education_colume');
                    // $district_english=$this->input->post('district_english');
                    // $district_hindi=$this->input->post('district_hindi');
                    // $district_punjabi=$this->input->post('district_punjabi');
                    $state_colume = $this->input->post('state_colume');
                    $city_colume = $this->input->post('city_colume');
                    $phone_colume = $this->input->post('phone_colume');
                    //-----------------------image----------------------------
                    $this->load->library('upload');
                    $image = "";
                    $img1 = 'image';
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/team/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "team" . date("Ymdhms");
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
                            $image = "assets/uploads/team/" . $new_file_name . $file_info['file_ext'];
                            $file_info['new_name'] = $image;
                            $nnnn = $file_info['file_name'];
                        }
                    }
                    //----------image tag end-------------------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $typ = base64_decode($t);
                    if ($typ == 1) {
                        $data_insert = array(
                            'name' => $name,
                            // 'name_hindi'=>$name_hindi,
                            // 'name_punjabi'=>$name_punjabi,
                            'email' => $email,
                            'image' => $image,
                            'type' => $type_colume,
                            // 'type'=>$type_colume2,
                            'vet' => $vet,
                            'private_practitioner' => $private_colume,
                            'degree' => $degree,
                            // 'degree_hindi'=>$degree_hindi,
                            // 'degree_punjabi'=>$degree_punjabi,
                            'experience' => $experiance_colume,
                            'assistant' => $assistant_colume,
                            'education_qualification' => $education_colume,
                            'district' => $district,
                            // 'district_hindi'=>$district_hindi,
                            // 'district_punjabi'=>$district_punjabi,
                            'state' => $state_colume,
                            'city' => $city_colume,
                            'phone_number' => $phone_colume,
                            'ip' => $ip,
                            // 'added_by' =>$addedby,
                            'added_by' => $addedby,
                            'is_active' => 1,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_doctor", $data_insert, 1);
                    }
                    if ($typ == 2) {
                        $idw = base64_decode($iw);
                        $data_insert = array(
                            'name' => $name,
                            // 'name_hindi'=>$name_hindi,
                            // 'name_punjabi'=>$name_punjabi,
                            'email' => $email,
                            'image' => $image,
                            'type' => $type_colume,
                            'vet' => $vet,
                            'private_practitioner' => $private_colume,
                            'degree' => $degree,
                            // 'degree_hindi'=>$degree_hindi,
                            // 'degree_punjabi'=>$degree_punjabi,
                            'experience' => $experiance_colume,
                            'assistant' => $assistant_colume,
                            'education_qualification' => $education_colume,
                            'district' => $district,
                            // 'district_hindi'=>$district_hindi,
                            // 'district_punjabi'=>$district_punjabi,
                            'state' => $state_colume,
                            'city' => $city_colume,
                            'phone_number' => $phone_colume
                        );
                        $this->db->where('id', $idw);
                        $last_id = $this->db->update('tbl_doctor', $data_insert);
                    }
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data inserted successfully');
                        redirect("dcadmin/Doctor/view_doctor", "refresh");
                    } else {
                        $this->session->set_flashdata('smessage', 'Sorry error occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $this->session->set_flashdata('smessage', validation_errors());
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('smessage', 'Please insert some data, No data available');
                redirect($_SERVER['HTTP_REFERER']);
            }
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
                    redirect("dcadmin/doctor/view_doctor", "refresh");
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
    public function updatedoctorStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($t == "active") {
                $data_update = array(
                    'is_active' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/doctor/view_doctor", "refresh");
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t == "inactive") {
                $data_update = array(
                    'is_active' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/doctor/view_doctor", "refresh");
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
            $this->db->from('all_cities');
            //$this->db->where('id',$usr);
            $data['city_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('all_states');
            //$this->db->where('id',$usr);
            $data['state_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/update_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function set_comission_doctor($idd)
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
                $this->form_validation->set_rules('set_comission', 'set_comission', 'xss_clean');
                if ($this->form_validation->run() == TRUE) {
                    $set_comission = $this->input->post('set_comission');
                    $id = base64_decode($idd);
                    $data['id'] = $idd;
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $data_update = array(
                        'comission' => $set_comission,
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
    //****************************Update Doctor Status 2 Function**************************************
    public function updatedoctorStatus2($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($t == "active") {
                $data_update = array(
                    'is_active2' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/doctor/view_doctor", "refresh");
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t == "inactive") {
                $data_update = array(
                    'is_active2' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_doctor', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/doctor/view_doctor", "refresh");
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
}
