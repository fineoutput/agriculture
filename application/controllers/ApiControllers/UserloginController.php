<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class UserloginController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('custom/Login');
        $this->load->library('custom/Messages');
    }
    public function msgtest()
    {
        //--- send welcome msg ---------
        $msg = 'आदरणीय  डॉक्टर जी, आपका पंजीकरण सफल हुआ, DAIRY MUNEEM में आपका स्वागत है। कुछ देर में आप की आईडी एक्टिव हो जाएगी ।व्हाट्सएप द्वारा हमसे जुड़ने के लिए क्लिक करें bit.ly/dairy_muneem। अधिक जानकारी के लिए 7891029090 पर कॉल करें । धन्यवाद ! – DAIRY MUNEEM';
        $dlt = D_DLT;
        $sendmsg = $this->messages->sendSmsMsg91('8387039990', $msg, $dlt);
    }
    //======================================USER LOGIN API CONTROLLER START========================//
    //======================================= USER REGISTER PROCESS===================================//
    public function farmer_register_process()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('village', 'village', 'xss_clean|trim');
            $this->form_validation->set_rules('district', 'district', 'xss_clean|trim');
            $this->form_validation->set_rules('city', 'city', 'xss_clean|trim');
            $this->form_validation->set_rules('state', 'state', 'xss_clean|trim');
            $this->form_validation->set_rules('pincode', 'pincode', 'xss_clean|trim');
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
            $this->form_validation->set_rules('email', 'email', 'xss_clean|trim');
            $this->form_validation->set_rules('doc_type', 'doc_type', 'xss_clean|trim');
            $this->form_validation->set_rules('degree', 'degree', 'xss_clean|trim');
            $this->form_validation->set_rules('experience', 'experience', 'xss_clean|trim');
            // $this->form_validation->set_rules('qualification', 'qualification', 'xss_clean|trim');
            $this->form_validation->set_rules('shop_name', 'shop_name', 'xss_clean|trim');
            $this->form_validation->set_rules('address', 'address', 'xss_clean|trim');
            $this->form_validation->set_rules('gst_no', 'gst_no', 'xss_clean|trim');
            $this->form_validation->set_rules('aadhar_no', 'aadhar_no', 'xss_clean|trim');
            $this->form_validation->set_rules('pan_no', 'pan_no', 'xss_clean|trim');
            $this->form_validation->set_rules('latitude', 'latitude', 'xss_clean|trim');
            $this->form_validation->set_rules('longitude', 'longitude', 'xss_clean|trim');
            $this->form_validation->set_rules('no_of_animals', 'no_of_animals', 'xss_clean|trim');
            $this->form_validation->set_rules('expert_category', 'expert_category', 'xss_clean');

            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $village = $this->input->post('village');
                $district = $this->input->post('district');
                $city = $this->input->post('city');
                $state = $this->input->post('state');
                $pincode = $this->input->post('pincode');
                $refer_code = $this->input->post('refer_code');
                $phone = $this->input->post('phone');
                $email = $this->input->post('email');
                $doc_type = $this->input->post('doc_type');
                $degree = $this->input->post('degree');
                $experience = $this->input->post('experience');
                // $qualification = $this->input->post('qualification');
                $shop_name = $this->input->post('shop_name');
                $address = $this->input->post('address');
                $gst_no = $this->input->post('gst_no');
                $aadhar_no = $this->input->post('aadhar_no');
                $pan_no = $this->input->post('pan_no');
                $type = $this->input->post('type');
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $no_animals = $this->input->post('no_of_animals');
                $expert_category = $this->input->post('expert_category');
                $this->load->library('upload');
                $image = '';
                $img1 = 'image';
                if (!empty($_FILES['image'])) {
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/aadhar/";
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
                            $image = "assets/uploads/aadhar/" . $file_info['file_name'];
                        }
                    }
                }
                $send = array(
                    'name' => $name,
                    'village' => $village,
                    'district' => $district,
                    'city' => $city,
                    'state' => $state,
                    'pincode' => $pincode,
                    'refer_code' => $refer_code,
                    'phone' => $phone,
                    'email' => $email,
                    'image' => $image,
                    'doc_type' => $doc_type,
                    'degree' => $degree,
                    'experience' => $experience,
                    // 'qualification' => $qualification,
                    'shop_name' => $shop_name,
                    'address' => $address,
                    'gst_no' => $gst_no,
                    'aadhar_no' => $aadhar_no,
                    'pan_no' => $pan_no,
                    'type' => $type,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'no_animals' => $no_animals,
                    'expert_category' => $expert_category,
                );
                //-------------- register user  with otp ------------
                $Register = $this->login->farmer_RegisterOtpVerify($send);
                echo $Register;
            } else {
                $respone['status'] = false;
                $respone['message'] = validation_errors();
                echo json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            $respone['message'] = 'Please Insert Some Data';
            echo json_encode($respone);
        }
    }
    //==================================== USER LOGIN PROCESS ========================================//
    public function farmer_login_process()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
           // $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
               // $type = $this->input->post('type');
                //------ user login send otp ----------
                $Login = $this->login->farmer_LogindWithOtp($phone); 
                echo $Login;
            } else {
                $respone['status'] = false;
                $respone['message'] = validation_errors();
                echo json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            $respone['message'] = 'Please Insert Some Data';
            echo json_encode($respone);
        }
    }
    //================================== USER LOGIN OTP VERIFY =======================================//
    public function farmer_login_otp_verify()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('otp', 'otp', 'required|xss_clean|trim');
            $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $otp = $this->input->post('otp');
                $type = $this->input->post('type');
                //-------------- register otp verify ------------
                $LoginVerify = $this->login->farmer_LoginOtpVerify($phone, $otp ,$type);
                echo $LoginVerify;
            } else {
                $respone['status'] = false;
                $respone['message'] = validation_errors();
                echo json_encode($respone);
            }
        } else {
            $respone['status'] = false;
            $respone['message'] = 'Please Insert Some Data';
            echo json_encode($respone);
        }
    }

      //======================================= doctor and vendor REGISTER PROCESS===================================//
      public function register_process()
      {

    //    echo'hii';
    //    exit;
          $this->load->helper(array('form', 'url'));
          $this->load->library('form_validation');
          $this->load->helper('security');
          if ($this->input->post()) {
              $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
              $this->form_validation->set_rules('village', 'village', 'xss_clean|trim');
              $this->form_validation->set_rules('district', 'district', 'xss_clean|trim');
              $this->form_validation->set_rules('city', 'city', 'xss_clean|trim');
              $this->form_validation->set_rules('state', 'state', 'xss_clean|trim');
              $this->form_validation->set_rules('pincode', 'pincode', 'xss_clean|trim');
              $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
              $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
              $this->form_validation->set_rules('email', 'email', 'xss_clean|trim');
              $this->form_validation->set_rules('doc_type', 'doc_type', 'xss_clean|trim');
              $this->form_validation->set_rules('degree', 'degree', 'xss_clean|trim');
              $this->form_validation->set_rules('experience', 'experience', 'xss_clean|trim');
              // $this->form_validation->set_rules('qualification', 'qualification', 'xss_clean|trim');
              $this->form_validation->set_rules('shop_name', 'shop_name', 'xss_clean|trim');
              $this->form_validation->set_rules('address', 'address', 'xss_clean|trim');
              $this->form_validation->set_rules('gst_no', 'gst_no', 'xss_clean|trim');
              $this->form_validation->set_rules('aadhar_no', 'aadhar_no', 'xss_clean|trim');
              $this->form_validation->set_rules('pan_no', 'pan_no', 'xss_clean|trim');
              $this->form_validation->set_rules('latitude', 'latitude', 'xss_clean|trim');
              $this->form_validation->set_rules('longitude', 'longitude', 'xss_clean|trim');
              $this->form_validation->set_rules('no_of_animals', 'no_of_animals', 'xss_clean|trim');
              $this->form_validation->set_rules('expert_category', 'expert_category', 'xss_clean');
  
              if ($this->form_validation->run() == true) {
                  $name = $this->input->post('name');
                  $village = $this->input->post('village');
                  $district = $this->input->post('district');
                  $city = $this->input->post('city');
                  $refer_code = $this->input->post('refer_code');
                  $state = $this->input->post('state');
                  $pincode = $this->input->post('pincode');
                  $phone = $this->input->post('phone');
                  $email = $this->input->post('email');
                  $doc_type = $this->input->post('doc_type');
                  $degree = $this->input->post('degree');
                  $experience = $this->input->post('experience');
                  // $qualification = $this->input->post('qualification');
                  $shop_name = $this->input->post('shop_name');
                  $address = $this->input->post('address');
                  $gst_no = $this->input->post('gst_no');
                  $aadhar_no = $this->input->post('aadhar_no');
                  $pan_no = $this->input->post('pan_no');
                  $type = $this->input->post('type');
                  $latitude = $this->input->post('latitude');
                  $longitude = $this->input->post('longitude');
                  $no_animals = $this->input->post('no_of_animals');
                  $expert_category = $this->input->post('expert_category');
                  $this->load->library('upload');
                  $image = '';
                  $img1 = 'image';
                  if (!empty($_FILES['image'])) {
                      $file_check = ($_FILES['image']['error']);
                      if ($file_check != 4) {
                          $image_upload_folder = FCPATH . "assets/uploads/aadhar/";
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
                              $image = "assets/uploads/aadhar/" . $file_info['file_name'];
                          }
                      }
                  }
                  $send = array(
                      'name' => $name,
                      'village' => $village,
                      'district' => $district,
                      'city' => $city,
                      'state' => $state,
                      'pincode' => $pincode,
                      'refer_code' => $refer_code,
                      'phone' => $phone,
                      'email' => $email,
                      'image' => $image,
                      'doc_type' => $doc_type,
                      'degree' => $degree,
                      'experience' => $experience,
                      // 'qualification' => $qualification,
                      'shop_name' => $shop_name,
                      'address' => $address,
                      'gst_no' => $gst_no,
                      'aadhar_no' => $aadhar_no,
                      'pan_no' => $pan_no,
                      'type' => $type,
                      'latitude' => $latitude,
                      'longitude' => $longitude,
                      'no_animals' => $no_animals,
                      'expert_category' => $expert_category,
                  );
                //   echo('data is 2 not comming');
                    // echo "<pre>";
                    // print_r($send);
                    // echo "<pre>";
                //   exit;
                  //-------------- register user  with otp ------------
                  $Register = $this->login->RegisterWithOtp($send);
                  echo $Register;
              } else {
                  $respone['status'] = false;
                  $respone['message'] = validation_errors();
                  echo json_encode($respone);
              }
          } else {
              $respone['status'] = false;
              $respone['message'] = 'Please Insert Some Data';
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
              if ($this->form_validation->run() == true)
               {
                  $phone = $this->input->post('phone');
                  $otp = $this->input->post('otp');
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
              $respone['message'] = 'Please Insert Some Data';
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
              $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
              if ($this->form_validation->run() == true) {
                  $phone = $this->input->post('phone');
                  $type = $this->input->post('type');
                  //------ user login send otp ----------
                  $Login = $this->login->LoginWithOtp($phone, $type);
                  echo $Login;
                
              } else {
                  $respone['status'] = false;
                  $respone['message'] = validation_errors();
                  echo json_encode($respone);
              }
          } else {
              $respone['status'] = false;
              $respone['message'] = 'Please Insert Some Data';
              echo json_encode($respone);
          }
      }
      //================================= USER LOGIN OTP VERIFY ======================================//
      public function login_otp_verify()
      {
          $this->load->helper(array('form', 'url'));
          $this->load->library('form_validation');
          $this->load->helper('security');
          if ($this->input->post()) {
              $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
              $this->form_validation->set_rules('otp', 'otp', 'required|xss_clean|trim');
              if ($this->form_validation->run() == true) {
                  $phone = $this->input->post('phone');
                  $otp = $this->input->post('otp');
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
              $respone['message'] = 'Please Insert Some Data';
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
            if ($this->form_validation->run() == true) {
                $fname = $this->input->post('fname');
                $lname = $this->input->post('lname');
                $update = array('f_name' => $fname, 'l_name' => $lname);
                $this->db->where('id', $this->session->userdata('user_id'));
                $zapak2 = $this->db->update('tbl_users', $update);
                if ($zapak2 == 1) {
                    $this->session->set_flashdata('smessage', 'Profile Updated Successfully!');
                    redirect('Home/my_profile/account', 'refresh');
                } else {
                    $this->session->set_flashdata('emessage', 'Some Unknown Error Occurred');
                    redirect('Home/my_profile/account', 'refresh');
                }
            } else {
                $this->session->set_flashdata('emessage', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('emessage', 'Please Insert Some Data, No Data Available');
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
