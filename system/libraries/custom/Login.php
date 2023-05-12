<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class CI_Login
{
    protected $CI;
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->helper('form');
        $this->CI->load->model("admin/login_model");
        $this->CI->load->model("admin/base_model");
        $this->CI->load->library('custom/Messages');
    }
    // ================================================= START OTP SYSTEM =============================================================
    //============================================= REGISTER  WITH OTP ==============================================
    public function RegisterWithOtp($receive)
    {
        $ip = $this->CI->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $type = '';
        $farmerCheck = $this->CI->db->get_where('tbl_farmers', array('phone' => $receive['phone']))->result();
        if (!empty($farmerCheck)) {
            $type = "farmer";
        } else {
            $doctorCheck = $this->CI->db->get_where('tbl_doctor', array('phone' => $receive['phone']))->result();
            if (!empty($doctorCheck)) {
                $type = "doctor";
            } else {
                $vendorCheck = $this->CI->db->get_where('tbl_vendor', array('phone' => $receive['phone']))->result();
                if (!empty($vendorCheck)) {
                    $type = "vendor";
                }
            }
        }
        if (empty($type)) { //---- check user is exist or not ---------
            //------- insert into temp table ------------
            $data_insert = array(
                'name' => $receive['name'],
                'village' => $receive['village'],
                'district' => $receive['district'],
                'city' => $receive['city'],
                'state' => $receive['state'],
                'pincode' => $receive['pincode'],
                'phone' => $receive['phone'],
                'type' => $receive['type'],
                'email' => $receive['email'],
                'image' => $receive['image'],
                'doc_type' => $receive['doc_type'],
                'degree' => $receive['degree'],
                'experience' => $receive['experience'],
                // 'qualification' => $receive['qualification'],
                'shop_name' => $receive['shop_name'],
                'address' => $receive['address'],
                'gst' => $receive['gst_no'],
                'aadhar_no' => $receive['aadhar_no'],
                'pan_no' => $receive['pan_no'],
                'ip' => $ip,
                'date' => $cur_date
            );
            $last_id = $this->CI->base_model->insert_table("tbl_register_temp", $data_insert, 1);
            $OTP = random_int(100000, 999999);
            // $OTP = 123456;
            //--------------- Insert data into OTP table -----
            $data_insert2 = array(
                'phone' => $receive['phone'],
                'otp' => $OTP,
                'status' => 0,
                'temp_id' => $last_id,
                'ip' => $ip,
                'date' => $cur_date
            );
            $last_id2 = $this->CI->base_model->insert_table("tbl_otp", $data_insert2, 1);
            if (!empty($last_id2)) {
                //--------------- Send Register OTP -----------
                $msg = 'Dear User, Your OTP for Signup on Dairy Muneem is ' . $OTP . ' and is valid for 10 minutes. Please do not share this OTP';
                $dlt = SIGNUP_DLT;
                $sendmsg = $this->CI->messages->sendOtpMsg91($receive['phone'], $msg,$OTP,$dlt);
                $respone['status'] = 200;
                $respone['message'] = 'Please enter otp sent to your register mobile number';
                // $this->CI->session->set_flashdata('smessage', 'Please enter otp sent to your register mobile number');
                return json_encode($respone);
                log_message('error', json_encode($respone));
            } else {
                $respone['status'] = 201;
                $respone['message'] = 'Some error occurred!';
                // $this->CI->session->set_flashdata('emessage', 'Some error occurred!');
                return json_encode($respone);
            }
        } else {
            $respone['status'] = 201;
            $respone['message'] = 'User Already Exist!';
            // $this->CI->session->set_flashdata('emessage', 'User Already Exist!');
            return json_encode($respone);
        }
    }
    //=================================================== REGISTER OTP VERIFY ======================================
    public function RegisterOtpVerify($phone, $input_otp)
    {
        $ip = $this->CI->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $otpData = $this->CI->db->order_by('id', 'desc')->get_where('tbl_otp', array('phone' => $phone))->result();
        if (!empty($otpData[0])) { //---- OTP not found
            if ($otpData[0]->otp == $input_otp) { //----- Match OTP ----
                if ($otpData[0]->status == 0) { //----- check OTP used or not ----
                    //--------- Update OTP status -------
                    $data_insert = array('status' => 1);
                    $this->CI->db->where('id', $otpData[0]->id);
                    $last_id = $this->CI->db->update('tbl_otp', $data_insert);
                    if (!empty($last_id)) { // check status is updated or not
                        $temp_data = $this->CI->db->order_by('id', 'desc')->get_where('tbl_register_temp', array('phone' => $otpData[0]->phone))->result();
                        if ($temp_data[0]->type == 'farmer') {
                            $auth = bin2hex(random_bytes(18)); //--- generate auth ---
                            $data_insert = array(
                                'name' => $temp_data[0]->name,
                                'village' => $temp_data[0]->village,
                                'district' => $temp_data[0]->district,
                                'city' => $temp_data[0]->city,
                                'state' => $temp_data[0]->state,
                                'pincode' => $temp_data[0]->pincode,
                                'phone' => $temp_data[0]->phone,
                                'auth' => $auth,
                                'ip' => $ip,
                                'is_active' => 1,
                                'date' => $cur_date
                            );
                            $last_id2 = $this->CI->base_model->insert_table("tbl_farmers", $data_insert, 1);
                            $data = array(
                                'name' => $temp_data[0]->name,
                                'auth' => $auth,
                            );
                            $respone['status'] = 200;
                            $respone['message'] = 'Successfully Registered!';
                            $respone['data'] = $data;
                            return json_encode($respone);
                        } else if ($temp_data[0]->type == 'doctor') {
                            //------ insert user data from temp to user table -----------
                            $auth = bin2hex(random_bytes(18)); //--- generate auth ---
                            if ($temp_data[0]->doc_type == 1) {
                                $dt = "Vet";
                            } else if ($temp_data[0]->doc_type == 2) {
                                $dt = "Livestock Assistant";
                            } else {
                                $dt = "Private Practitioner";
                            }
                            $data_insert = array(
                                'name' => $temp_data[0]->name,
                                'district' => $temp_data[0]->district,
                                'city' => $temp_data[0]->city,
                                'state' => $temp_data[0]->state,
                                'phone' => $temp_data[0]->phone,
                                'email' => $temp_data[0]->email,
                                'type' => $dt,
                                'degree' => $temp_data[0]->degree,
                                'experience' => $temp_data[0]->experience,
                                'pincode' => $temp_data[0]->pincode,
                                // 'qualification' => $temp_data[0]->qualification,
                                'aadhar_no' => $temp_data[0]->aadhar_no,
                                'image' => $temp_data[0]->image,
                                'auth' => $auth,
                                'is_active' => 1,
                                'is_approved' => 0,
                                'is_expert' => 0,
                                'account' => 0,
                                'latitude' => 26.9029328,
                                'longitude' => 75.7380032,
                                'date' => $cur_date
                            );
                            $last_id2 = $this->CI->base_model->insert_table("tbl_doctor", $data_insert, 1);
                            $data = array(
                                'name' => $temp_data[0]->name,
                                'is_expert' => 0,
                                'auth' => $auth,
                            );
                            $respone['status'] = 200;
                            $respone['message'] = 'Successfully Registered!';
                            $respone['data'] = $data;
                            return json_encode($respone);
                        } else {
                            //------ insert user data from temp to user table -----------
                            $auth = bin2hex(random_bytes(18)); //--- generate auth ---
                            $data_insert = array(
                                'name' => $temp_data[0]->name,
                                'district' => $temp_data[0]->district,
                                'city' => $temp_data[0]->city,
                                'state' => $temp_data[0]->state,
                                'pincode' => $temp_data[0]->pincode,
                                'phone' => $temp_data[0]->phone,
                                'shop_name' => $temp_data[0]->shop_name,
                                'address' => $temp_data[0]->address,
                                'image' => $temp_data[0]->image,
                                'pan_number' => $temp_data[0]->pan_no,
                                'gst_no' => $temp_data[0]->gst,
                                'aadhar_no' => $temp_data[0]->aadhar_no,
                                'email' => $temp_data[0]->email,
                                'auth' => $auth,
                                'is_approved' => 0,
                                'is_active' => 1,
                                'latitude' => 26.9029328,
                                'longitude' => 75.7380032,
                                'date' => $cur_date
                            );
                            $last_id2 = $this->CI->base_model->insert_table("tbl_vendor", $data_insert, 1);
                            $data = array(
                                'name' => $temp_data[0]->name,
                                'auth' => $auth,
                            );
                            $respone['status'] = 200;
                            $respone['message'] = 'Successfully Registered!';
                            $respone['data'] = $data;
                            return json_encode($respone);
                        }
                    } else {
                        $respone['status'] = 201;
                        $respone['message'] = 'Some error occurred! Please try again';
                        // $this->CI->session->set_flashdata('emessage', 'Some error occurred! Please try again');
                        return json_encode($respone);
                    }
                } else {
                    $respone['status'] = 201;
                    $respone['message'] = 'OTP is already used!';
                    // $this->CI->session->set_flashdata('emessage', 'OTP is already used!');
                    return json_encode($respone);
                }
            } else {
                $respone['status'] = 201;
                $respone['message'] = 'Wrong OTP Entered!';
                // $this->CI->session->set_flashdata('emessage', 'Wrong OTP Entered!');
                return json_encode($respone);
            }
        } else {
            $respone['status'] = 201;
            $respone['message'] = 'Invalid OTP!';
            // $this->CI->session->set_flashdata('emessage', 'Invalid OTP!');
            return json_encode($respone);
        }
    }
    //============================================= LOGIN WITH OTP ==============================================
    public function LoginWithOtp($phone, $call_type)
    {
        // if (empty($this->CI->session->userdata('user_data'))) {
        $ip = $this->CI->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        //------ Check for user  exist or not ----------
        $type = '';
        $farmerCheck = $this->CI->db->get_where('tbl_farmers', array('phone' => $phone))->result();
        if (!empty($farmerCheck)) {
            $type = "farmer";
            $userCheck = $farmerCheck;
        } else {
            $doctorCheck = $this->CI->db->get_where('tbl_doctor', array('phone' => $phone))->result();
            if (!empty($doctorCheck)) {
                $type = "doctor";
                $userCheck = $doctorCheck;
            } else {
                $vendorCheck = $this->CI->db->get_where('tbl_vendor', array('phone' => $phone))->result();
                if (!empty($vendorCheck)) {
                    $type = "vendor";
                    $userCheck = $vendorCheck;
                }
            }
        }
        if (empty($type)) { //--------------- user not found -----------------
            $respone['status'] = false;
            $respone['message'] = 'User Not Found! Please Register First';
            $this->CI->session->set_flashdata('emessage', 'Some error occurred!');
            return json_encode($respone);
            die();
        }
        if ($call_type != $type) {
            $respone['status'] = false;
            if ($call_type == 'farmer') {
                $respone['message'] = 'This number is not registered as a farmer!';
            } else if ($call_type == 'doctor') {
                $respone['message'] = 'This number is not registered as a doctor!';
            } else {
                $respone['message'] = 'This number is not registered as a vendor!';
            }
            $this->CI->session->set_flashdata('emessage', 'Some error occurred!');
            return json_encode($respone);
            die();
        }
        //----------------------- user login handle --------------------------------
        if ($userCheck[0]->is_active == 1) {
            if ($type == 'vendor' || $type == 'doctor') {
                if ($userCheck[0]->is_approved == 0) {
                    $respone['status'] = 201;
                    $respone['message'] = 'Your account request is pending! Please contact to admin';
                    // $this->CI->session->set_flashdata('emessage', 'Your Account is blocked! Please contact to admin');
                    return json_encode($respone);
                    die();
                } else if ($userCheck[0]->is_approved == 2) {
                    $respone['status'] = 201;
                    $respone['message'] = 'Your account  request is rejected! Please contact to admin';
                    // $this->CI->session->set_flashdata('emessage', 'Your Account is blocked! Please contact to admin');
                    return json_encode($respone);
                    die();
                }
            }
            //--------------- Insert data into otp table -----
            $OTP = random_int(100000, 999999);
            // $OTP = 123456;
            $data_insert2 = array(
                'phone' => $phone,
                'otp' => $OTP,
                'status' => 0,
                'ip' => $ip,
                'date' => $cur_date
            );
            $last_id2 = $this->CI->base_model->insert_table("tbl_otp", $data_insert2, 1);
            if (!empty($last_id2)) {
                //--------------- Send login OTP----- -----
                $msg = 'Dear User, Your OTP for log in on Dairy Muneem is ' . $OTP . ' and is valid for 10 minutes. Please do not share this OTP';
                $dlt = LOGIN_DLT;
                $sendmsg = $this->CI->messages->sendOtpMsg91($phone, $msg,$OTP,$dlt);
                $respone['status'] = 200;
                $respone['message'] = 'Please enter otp sent to your register mobile number';
                // $this->CI->session->set_flashdata('smessage', 'Please enter otp sent to your register mobile number');
                return json_encode($respone);
            } else {
                $respone['status'] = 201;
                $respone['message'] = 'Some error occurred!';
                // $this->CI->session->set_flashdata('emessage', 'Some error occurred!');
                return json_encode($respone);
            }
        }
        //------ user is inactive --------
        else {
            $respone['status'] = 201;
            $respone['message'] = 'Your Account is blocked! Please contact to admin';
            // $this->CI->session->set_flashdata('emessage', 'Your Account is blocked! Please contact to admin');
            return json_encode($respone);
        }
        // } else {
        //     $respone['status'] = false;
        //     return json_encode($respone);
        // }
    }
    //============================================== LOGIN OTP VERIFY =============================================
    public function LoginOtpVerify($phone, $input_otp)
    {
        $otpData = $this->CI->db->order_by('id', 'desc')->get_where('tbl_otp', array('phone' => $phone))->result();
        $ip = $this->CI->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        if (!empty($otpData[0])) { //---- OTP not found
            if ($otpData[0]->otp == $input_otp) { //----- Match OTP ----
                if ($otpData[0]->status == 0) { //----- check OTP used or not ----
                    //--------- Update OTP status -------
                    $data_insert = array('status' => 1);
                    $this->CI->db->where('id', $otpData[0]->id);
                    $last_id = $this->CI->db->update('tbl_otp', $data_insert);
                    if (!empty($last_id)) { // check status is updated or not
                        $farmerCheck = $this->CI->db->get_where('tbl_farmers', array('phone' => $phone))->result();
                        if (!empty($farmerCheck)) {
                            $type = "farmer";
                            $user_data = $farmerCheck;
                        } else {
                            $doctorCheck = $this->CI->db->get_where('tbl_doctor', array('phone' => $phone))->result();
                            if (!empty($doctorCheck)) {
                                $type = "doctor";
                                $user_data = $doctorCheck;
                            } else {
                                $vendorCheck = $this->CI->db->get_where('tbl_vendor', array('phone' => $phone))->result();
                                if (!empty($vendorCheck)) {
                                    $type = "vendor";
                                    $user_data = $vendorCheck;
                                }
                            }
                        }
                        if ($user_data[0]->is_active == 1) {
                            if ($type == 'vendor' || $type == 'doctor') {
                                if ($user_data[0]->is_approved == 0) {
                                    $respone['status'] = 201;
                                    $respone['message'] = 'Your account request is pending! Please contact to admin';
                                    return json_encode($respone);
                                    die();
                                } else if ($user_data[0]->is_approved == 2) {
                                    $respone['status'] = 201;
                                    $respone['message'] = 'Your account  request is rejected! Please contact to admin';
                                    return json_encode($respone);
                                    die();
                                }
                            }
                            if ($type == 'doctor') {
                                $data = array(
                                    'name' => $user_data[0]->name,
                                    'auth' => $user_data[0]->auth,
                                    'is_expert' => $user_data[0]->is_expert,
                                );
                            } else {
                                $data = array(
                                    'name' => $user_data[0]->name,
                                    'auth' => $user_data[0]->auth,
                                );
                            }
                            $respone['status'] = 200;
                            $respone['message'] = 'Login Successfully';
                            $respone['data'] = $data;
                            return json_encode($respone);
                        } else {
                            $respone['status'] = 200;
                            $respone['message'] = 'Your account is inactive!';
                            return json_encode($respone);
                        }
                    } else {
                        $respone['status'] = 201;
                        $respone['message'] = 'Some error occurred! Please try again';
                        return json_encode($respone);
                    }
                } else {
                    $respone['status'] = 201;
                    $respone['message'] = 'OTP is already used!';
                    return json_encode($respone);
                }
            } else {
                $respone['status'] = 201;
                $respone['message'] = 'Wrong OTP Entered!';
                return json_encode($respone);
            }
        } else {
            $respone['status'] = 201;
            $respone['message'] = 'Invalid OTP!';
            return json_encode($respone);
        }
    }
    //============================= USER OTP LOGOUT ==========================================
    public function UserOtpLogout()
    {
        if (!empty($this->CI->session->userdata('user_data'))) {
            $this->CI->session->unset_userdata('user_data');
            $this->CI->session->unset_userdata('user_id');
            $this->CI->session->unset_userdata('name');
            $this->CI->session->unset_userdata('phone');
            $this->CI->session->unset_userdata('email');
            $respone['status'] = true;
            $respone['data_message'] = 'Logout Successfully!';
            $this->CI->session->set_flashdata('smessage', 'Logout Successfully!');
            return json_encode($respone);
        } else {
            $respone['status'] = false;
            return json_encode($respone);
        }
    }
    // ================================================= STOP OTP SYSTEM =============================================================
}
