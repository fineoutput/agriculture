<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class CI_Login
{
    protected $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('form');
        $this->CI->load->model("admin/login_model");
        $this->CI->load->model("admin/base_model");
        $this->CI->load->library('custom/Messages');
    }
    // ================================================= START OTP SYSTEM =============================================================
    //============================================= REGISTER  WITH OTP ==============================================
    public function RegisterWithOtp($name, $village, $district,$city ,$state ,$pincode ,$phone)
    {
            $ip = $this->CI->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
            $cur_date=date("Y-m-d H:i:s");
            $userCheck = $this->CI->db->get_where('tbl_farmer', array('phone'=> $phone))->result();
            if (empty($userCheck)) {//---- check user is exist or not ---------
                //------- insert into temp table ------------
                $data_insert = array(
            'name'=>$name,
            'village'=>$village,
            'district'=>$district,
            'city'=>$city,
            'state'=>$state,
            'pincode'=>$pincode,
            'phone'=>$phone,
            'ip' =>$ip,
            'date'=>$cur_date
            );
                $last_id=$this->CI->base_model->insert_table("tbl_farmer_temp", $data_insert, 1) ;
                $OTP = random_int(100000, 999999);
                // $OTP = 123456;
                //--------------- Insert data into OTP table -----
                $data_insert2 = array(
                  'phone'=>$phone,
                  'otp'=>$OTP,
                  'status'=>0,
                  'temp_id'=>$last_id,
                  'ip' =>$ip,
                  'date'=>$cur_date
                  );
                $last_id2=$this->CI->base_model->insert_table("tbl_otp", $data_insert2, 1) ;
                if (!empty($last_id2)) {
                    //--------------- Send Register OTP -----------
                    $msg ='Dear User, Your OTP for signup to CABME is '.$OTP.' Valid for 30 minutes. Please do not share this OTP. Regards, CABME INDIA';
                    $temp_id=1707166480333123421;
                    // $sendmsg = $this->CI->messages->sendOtpDigitalIndiasms($phone,$msg,$temp_id);
                    $respone['status'] = true;
                    $respone['message'] ='Please enter otp sent to your register mobile number';
                    // $this->CI->session->set_flashdata('smessage', 'Please enter otp sent to your register mobile number');
                    return json_encode($respone);
                    log_message('error', json_encode($respone));
                } else {
                    $respone['status'] = false;
                    $respone['message'] ='Some error occurred!';
                    // $this->CI->session->set_flashdata('emessage', 'Some error occurred!');
                    return json_encode($respone);
                }
            } else {
                $respone['status'] = false;
                $respone['message'] ='User Already Exist!';
                // $this->CI->session->set_flashdata('emessage', 'User Already Exist!');
                return json_encode($respone);
            }
        
    }
    //=================================================== REGISTER OTP VERIFY ======================================
    public function RegisterOtpVerify($phone, $input_otp)
    {
        
            $ip = $this->CI->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
            $cur_date=date("Y-m-d H:i:s");
            $otpData = $this->CI->db->order_by('id', 'desc')->get_where('tbl_otp', array('phone'=> $phone))->result();
            if (!empty($otpData[0])) {//---- OTP not found
      if ($otpData[0]->otp == $input_otp) {//----- Match OTP ----
          if ($otpData[0]->status==0) {//----- check OTP used or not ----
            //--------- Update OTP status -------
            $data_insert = array('status'=>1);
              $this->CI->db->where('id', $otpData[0]->id);
              $last_id=$this->CI->db->update('tbl_otp', $data_insert);
              if (!empty($last_id)) {// check status is updated or not
                  $temp_data = $this->CI->db->get_where('tbl_farmer_temp', array('phone'=> $otpData[0]->phone))->result();
                  //------ insert user data from temp to user table -----------
                  $data_insert = array('name'=>$temp_data[0]->name,
                       'village'=>$temp_data[0]->village,
                       'district'=>$temp_data[0]->district,
                       'city'=>$temp_data[0]->city,
                       'state'=>$temp_data[0]->state,
                       'pincode'=>$temp_data[0]->pincode,
                       'phone'=>$temp_data[0]->phone,
                       'ip' =>$ip,
                       'is_active' =>1,
                       'date'=>$cur_date
                );
                  $last_id2=$this->CI->base_model->insert_table("tbl_farmer", $data_insert, 1) ;
                  //---------- set login session -------------------
                  $this->CI->session->set_userdata('user_data', 1);
                  $this->CI->session->set_userdata('name', $temp_data[0]->name);
                  $this->CI->session->set_userdata('phone', $phone);
                  $this->CI->session->set_userdata('village', $temp_data[0]->village);
                  $this->CI->session->set_userdata('district', $temp_data[0]->district);
                  $this->CI->session->set_userdata('city', $temp_data[0]->city);
                  $this->CI->session->set_userdata('state', $temp_data[0]->state);
                  $this->CI->session->set_userdata('pincode', $temp_data[0]->pincode);
                  $this->CI->session->set_userdata('user_id', $last_id2);
                  $respone['status'] = true;
                  $respone['message'] ='Successfully Registered!';
                  // $this->CI->session->set_flashdata('smessage', 'Successfully Registered!');
                  return json_encode($respone);
              } else {
                  $respone['status'] = false;
                  $respone['message'] ='Some error occurred! Please try again';
                  // $this->CI->session->set_flashdata('emessage', 'Some error occurred! Please try again');
                  return json_encode($respone);
              }
          } else {
              $respone['status'] = false;
              $respone['message'] ='OTP is already used!';
              // $this->CI->session->set_flashdata('emessage', 'OTP is already used!');
              return json_encode($respone);
          }
      } else {
          $respone['status'] = false;
          $respone['message'] ='Wrong OTP Entered!';
          // $this->CI->session->set_flashdata('emessage', 'Wrong OTP Entered!');
          return json_encode($respone);
      }
            } else {
                $respone['status'] = false;
                $respone['message'] ='Invalid OTP!';
                // $this->CI->session->set_flashdata('emessage', 'Invalid OTP!');
                return json_encode($respone);
            }
        } 
    
    //============================================= LOGIN WITH OTP ==============================================
    public function LoginWithOtp($phone)
    {
        // if (empty($this->CI->session->userdata('user_data'))) {
            $ip = $this->CI->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
            $cur_date=date("Y-m-d H:i:s");
            //------ Check for user  exist or not ----------
            $userCheck = $this->CI->db->get_where('tbl_farmer', array('phone'=> $phone))->result();
            if (empty($userCheck)) {//--------------- user not found -----------------
              $respone['status'] = false;
              $respone['message'] ='User Not Found! Please Register First';
              $this->CI->session->set_flashdata('emessage', 'Some error occurred!');
              return json_encode($respone);
            }
            //----------------------- user login handle --------------------------------
                if ($userCheck[0]->is_active==1) {
                    //--------------- Insert data into otp table -----
                    $OTP = random_int(100000, 999999);
                    // $OTP = 123456;
                    $data_insert2 = array(
                            'phone'=>$phone,
                            'otp'=>$OTP,
                            'status'=>0,
                            'ip' =>$ip,
                            'date'=>$cur_date
                            );
                    $last_id2=$this->CI->base_model->insert_table("tbl_otp", $data_insert2, 1) ;
                    if (!empty($last_id2)) {
                        //--------------- Send login OTP----- -----
                        $msg ='Dear User, Your OTP for login to CABME is '.$OTP.' Valid for 30 minutes. Please do not share this OTP. Thank You, CABME INDIA';
                        $temp_id=1707166572968709050;
                        // $sendmsg = $this->CI->messages->sendOtpDigitalIndiasms($phone,$msg,$temp_id);
                        $respone['status'] = true;
                        $respone['message'] ='Please enter otp sent to your register mobile number';
                        // $this->CI->session->set_flashdata('smessage', 'Please enter otp sent to your register mobile number');
                        return json_encode($respone);
                    } else {
                        $respone['status'] = false;
                        $respone['message'] ='Some error occurred!';
                        // $this->CI->session->set_flashdata('emessage', 'Some error occurred!');
                        return json_encode($respone);
                    }
                }
                //------ user is inactive --------
                else {
                    $respone['status'] = false;
                    $respone['message'] ='Your Account is blocked! Please contact to admin';
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
        $otpData = $this->CI->db->order_by('id', 'desc')->get_where('tbl_otp', array('phone'=> $phone))->result();
        $ip = $this->CI->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date=date("Y-m-d H:i:s");
        if (!empty($otpData[0])) {//---- OTP not found
            if ($otpData[0]->otp == $input_otp) {//----- Match OTP ----
                if ($otpData[0]->status==0) {//----- check OTP used or not ----
                  //--------- Update OTP status -------
                  $data_insert = array('status'=>1);
                    $this->CI->db->where('id', $otpData[0]->id);
                    $last_id=$this->CI->db->update('tbl_otp', $data_insert);
                    if (!empty($last_id)) {// check status is updated or not
                        $user_data = $this->CI->db->get_where('tbl_farmer', array('phone'=> $phone))->result();
                        if ($user_data[0]->is_active==1) {
                            $auth =bin2hex(random_bytes(18));//--- generate auth ---
                            $data_update = array('auth'=>$auth,
                          );
                            $this->CI->db->where('id', $user_data[0]->id);
                            $zapak=$this->CI->db->update('tbl_farmer', $data_update);
                            $respone['status'] = true;
                            $respone['message'] ='Login Successfully';
                            $respone['data'] =$auth;
                            return json_encode($respone);
                        } else {
                            $respone['status'] = true;
                            $respone['message'] ='Your account is inactive!';
                            return json_encode($respone);
                        }
                    } else {
                        $respone['status'] = false;
                        $respone['message'] ='Some error occurred! Please try again';
                        return json_encode($respone);
                    }
                } else {
                    $respone['status'] = false;
                    $respone['message'] ='OTP is already used!';
                    return json_encode($respone);
                }
            } else {
                $respone['status'] = false;
                $respone['message'] ='Wrong OTP Entered!';
                return json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            $respone['message'] ='Invalid OTP!';
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
            $respone['data_message'] ='Logout Successfully!';
            $this->CI->session->set_flashdata('smessage', 'Logout Successfully!');
            return json_encode($respone);
        } else {
            $respone['status'] = false;
            return json_encode($respone);
        }
    }
    // ================================================= STOP OTP SYSTEM =============================================================
}
