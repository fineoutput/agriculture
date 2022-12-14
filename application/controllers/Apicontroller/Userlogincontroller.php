<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Userlogincontroller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('custom/Login');
        // $this->load->library('custom/Forms');
    }
    //======================================USER LOGIN API CONTROLLER START========================//

    //======================================= USER REGISTER PROCESS===================================//
    public function register_process()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('village', 'village', 'required|xss_clean|trim');
            $this->form_validation->set_rules('district', 'district', 'required|xss_clean|trim');
            $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
            $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
            $this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            if ($this->form_validation->run()== true) {
                $name=$this->input->post('name');
                $village=$this->input->post('village');
                $district=$this->input->post('district');
                $city=$this->input->post('city');
                $state=$this->input->post('state');
                $pincode=$this->input->post('pincode');
               
                $phone=$this->input->post('phone');
                //-------------- register user  with otp ------------
                $Register = $this->login->RegisterWithOtp($name, $village, $district, $city, $state, $pincode, $phone);
                echo $Register;
            } else {
                $respone['status'] = false;
                $respone['message'] = validation_errors();
                echo json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            $respone['message'] = 'Please insert some data';
            echo json_encode($respone);
        }
    }
    //============================== USER REGISTER OTP VERIFY =====================================//
    public function register_otp_verify()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('otp', 'otp', 'required|xss_clean|trim');
            if ($this->form_validation->run()== true) {
                $phone=$this->input->post('phone');
                $otp=$this->input->post('otp');
                //-------------- register otp verify ------------
                $RegisterVerify = $this->login->RegisterOtpVerify($phone, $otp);
                // redirect($_SERVER['HTTP_REFERER']);
                echo $RegisterVerify;
            } else {
                $respone['status'] = false;
                $respone['message'] = validation_errors();
                echo json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            $respone['message'] = 'Please insert some data';
            echo json_encode($respone);
        }
    }
    //==================================== USER LOGIN PROCESS ========================================//
    public function login_process()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            if ($this->form_validation->run()== true) {
                $phone=$this->input->post('phone');
                //------ user login send otp ----------
                $Login = $this->login->LoginWithOtp($phone);
                echo $Login;
      } else {
                $respone['status'] = false;
                $respone['message'] = validation_errors();
                echo json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            $respone['message'] = 'Please insert some data';
            echo json_encode($respone);
        }
    }
    //================================== USER LOGIN OTP VERIFY =======================================//
    public function login_otp_verify()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('otp', 'otp', 'required|xss_clean|trim');
            if ($this->form_validation->run()== true) {
                $phone=$this->input->post('phone');
                $otp=$this->input->post('otp');
                //-------------- register otp verify ------------
                $LoginVerify = $this->login->LoginOtpVerify($phone, $otp);
                echo $LoginVerify;
            } else {
                $respone['status'] = false;
                $respone['message'] = validation_errors();
                echo json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            $respone['message'] = 'Please insert some data';
            echo json_encode($respone);
        }
    }
    //================================ UPDATE USER PROFILE ===========================================//
    public function update_profile()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('fname', 'fname', 'required|xss_clean|trim');
            $this->form_validation->set_rules('lname', 'lname', 'required|xss_clean|trim');
            if ($this->form_validation->run()== true) {
                $fname=$this->input->post('fname');
                $lname=$this->input->post('lname');
                $update = array('f_name'=>$fname, 'l_name'=>$lname);
                $this->db->where('id', $this->session->userdata('user_id'));
                $zapak2 = $this->db->update('tbl_users', $update);
                if ($zapak2==1) {
                    $this->session->set_flashdata('smessage', 'Profile updated successfully!');
                    redirect('Home/my_profile/account', 'refresh');
                } else {
                    $this->session->set_flashdata('emessage', 'Some unknown error occurred');
                    redirect('Home/my_profile/account', 'refresh');
                }
            } else {
                $this->session->set_flashdata('emessage', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //================================== UPDATE RESELLER PROFILE =======================================
    public function update_reseller_profile()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('email', 'email', 'required|xss_clean|trim');
            $this->form_validation->set_rules('shop', 'shop', 'required|xss_clean|trim');
            $this->form_validation->set_rules('gstin', 'gstin', 'xss_clean|trim');
            $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
            $this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');
            if ($this->form_validation->run()== true) {
                $name=$this->input->post('name');
                $email=$this->input->post('email');
                $shop=$this->input->post('shop');
                $gstin=$this->input->post('gstin');
                $city=$this->input->post('city');
                $address=$this->input->post('address');
                $update = array('name'=>$name, 'email'=>$email, 'shop'=>$shop, 'gst_number'=>$gstin, 'city'=>$city, 'address'=>$address);
                $this->db->where('id', $this->session->userdata('user_id'));
                $zapak2 = $this->db->update('tbl_reseller', $update);
                if ($zapak2==1) {
                    $this->session->set_flashdata('smessage', 'Profile updated successfully!');
                    redirect('Home/my_profile', 'refresh');
                } else {
                    $this->session->set_flashdata('emessage', 'Some unknown error occurred');
                    redirect('Home/my_profile', 'refresh');
                }
            } else {
                $this->session->set_flashdata('emessage', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //======================================= REDEEM POINTS ==================================================
    public function redeem_points()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('points', 'points', 'required|xss_clean|trim');
            $this->form_validation->set_rules('accountnumber', 'accountnumber', 'required|xss_clean|trim');
            $this->form_validation->set_rules('ifsccode', 'ifsccode', 'required|xss_clean|trim');
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            if ($this->form_validation->run()== true) {
                $points=$this->input->post('points');
                $accountnumber=$this->input->post('accountnumber');
                $ifsccode=$this->input->post('ifsccode');
                $name=$this->input->post('name');
                $submit_request = $this->forms->redeemModelPoints($points, $accountnumber, $ifsccode, $points);
                redirect('Home/my_profile', 'refresh');
            } else {
                $this->session->set_flashdata('emessage', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //======================================== USER LOGOUT ========================================================
    public function logout()
    {
        $Logout = $this->login->UserOtpLogout();
        redirect("/", "refresh");
    }
}
