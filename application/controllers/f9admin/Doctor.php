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
    //****************************View Vendor Function**************************************
    public function new_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_approved', 0);
            $data['doctor_data'] = $this->db->get();
            $data['heading'] = "New";
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //================================accepted_vendors=======================\\
    public function accepted_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_approved', 1);
            $data['doctor_data'] = $this->db->get();
            $data['heading'] = "Accepted";
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function rejected_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_approved', 2);
            $data['doctor_data'] = $this->db->get();
            $data['heading'] = "Rejected";
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
            $this->db->where('payment_status', 1);
            $data['request_data'] = $this->db->get();
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
        } else {
            $this->load->view('admin/login/index');
        }
    }
    // public function update_doctor($idd)
    // {
    //     if (!empty($this->session->userdata('admin_data'))) {
    //         $data['user_name'] = $this->load->get_var('user_name');
    //         $id = base64_decode($idd);
    //         $data['id'] = $idd;
    //         $this->db->select('*');
    //         $this->db->from('tbl_doctor');
    //         $this->db->where('id', $id);
    //         $dsa = $this->db->get();
    //         $data['doctor'] = $dsa->row();
    //         $this->db->select('*');
    //         $this->db->from('all_cities');
    //         //$this->db->where('id',$usr);
    //         $data['city_data'] = $this->db->get();
    //         $this->db->select('*');
    //         $this->db->from('all_states');
    //         //$this->db->where('id',$usr);
    //         $data['state_data'] = $this->db->get();
    //         $this->load->view('admin/common/header_view', $data);
    //         $this->load->view('admin/doctor/update_doctor');
    //         $this->load->view('admin/common/footer_view');
    //     } else {
    //         redirect("login/admin_login", "refresh");
    //     }
    // }
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
}
