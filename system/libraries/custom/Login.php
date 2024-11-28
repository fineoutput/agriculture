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
//============================================= REGISTER OTP VERIFY ======================================
public function farmer_RegisterOtpVerify($receive)
{
$ip = $this->CI->input->ip_address();
date_default_timezone_set("Asia/Calcutta"); 
$cur_date = date("Y-m-d H:i:s");

$type = '';
$farmerCheck = $this->CI->db->get_where('tbl_farmers', array('phone' => $receive['phone']))->result();
if (empty($farmerCheck)) {

if ($receive['type'] == 'farmer') {
$auth = bin2hex(random_bytes(18)); //--- generate auth ---

$this->db->select('*');
$this->db->from('gift_card');
$this->db->order_by('amount','ASC');
$gf = $this->db->get()->row();

$url = base_url."assets/uploads/gift_card/".$gf->image;

$data_insert = array(
    'name' => $receive['name'],
    'village' => $receive['village'],
    'district' => $receive['district'],
    'city' => $receive['city'],
    'state' => $receive['state'],
    'pincode' => $receive['pincode'],
    'refer_code' => $receive['refer_code'],
    'phone' => $receive['phone'],
    'no_animals' => $receive['no_animals'],
    'gst_no' => $receive['gst_no'],
    'auth' => $auth,
    'ip' => $ip,
    'is_active' => 1,
    'giftcard_id' => $gf->id,
    'date' => $cur_date
);
$last_id2 = $this->CI->base_model->insert_table("tbl_farmers", $data_insert, 1);
$data = array(
    'name' => $receive['name'],
    'auth' => $auth,
    'is_login' => 1,
    'giftcard' => GIFTCARD,
    'giftcard_url' => $url

);
//--- send welcome msg ---------
// $msg = 'प्रिय किसान, आपका पंजीकरण सफल हुआ, DAIRY MUNEEM में आपका स्वागत है। विभिन्न सुविधाओं के लिए डेयरी मुनीम ऐप का इस्तेमाल करें। व्हाट्सएप द्वारा हमसे जुड़ने के लिए क्लिक करें bit.ly/dairy_muneem। अधिक जानकारी के लिए 7891029090 पर कॉल करें । धन्यवाद ! – DAIRY MUNEEM';
// $dlt = F_DLT;
// $sendmsg = $this->CI->messages->sendSmsMsg91($receive['phone'], $msg, $dlt);
//--- send welcome msg ---------
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://control.msg91.com/api/v5/flow/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '
                {
                "template_id": "649e7ef5d6fc055fd16f92a2",
                "sender": "514279",
                "short_url": "0",
                "mobiles": "91' . $receive['phone'] . '"
                }
                ',
    CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'authkey: ' . SMSAUTH . '',
        'charset: UTF-8',
        'content-type: application/json',
        'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
    ),
));
$response = curl_exec($curl);
curl_close($curl);
// echo $response;
$respone['status'] = 200;
$respone['message'] = 'Successfully Registered!';
$respone['data'] = $data;
return json_encode($respone);
} else if ($receive['type'] == 'doctor') {
//------ insert user data from temp to user table -----------
$auth = bin2hex(random_bytes(18)); //--- generate auth ---
if ($receive['doc_type'] == 1) {
    $dt = "Vet";
} else if ($receive['doc_type'] == 2) {
    $dt = "Livestock Assistant";
} else {
    $dt = "Private Practitioner";
}
$data_insert = array(
    'name' => $receive['name'],
    'district' => $receive['district'],
    'city' => $receive['city'],
    'state' => $receive['state'],
    'phone' => $receive['phone'],
    'email' => $receive['email'],
    'type' => $dt,
    'degree' => $receive['degree'],
    'experience' => $receive['experience'],
    'pincode' => $receive['pincode'],
    'refer_code' => $receive['refer_code'],
    // 'qualification' => $receive->qualification,
    'aadhar_no' => $receive['aadhar_no'],
    'image' => $receive['image'],
    'expert_category' => $receive['expert_category'],
    'auth' => $auth,
    'is_active' => 1,
    'is_approved' => 0,
    'is_expert' => 0,
    'account' => 0,
    'latitude' => '',
    'longitude' => '',
    'date' => $cur_date
);

$last_id2 = $this->CI->base_model->insert_table("tbl_doctor", $data_insert, 1);
$data = array(
    'name' => $receive['name'],
    'is_expert' => 0,
    'auth' => $auth,
    'is_login' => 1,
);
//--- send welcome msg ---------
// $msg = 'आदरणीय  डॉक्टर जी, आपका पंजीकरण सफल हुआ, DAIRY MUNEEM में आपका स्वागत है। कुछ देर में आप की आईडी एक्टिव हो जाएगी।व्हाट्सएप द्वारा हमसे जुड़ने के लिए क्लिक करें bit.ly/dairy_muneem। अधिक जानकारी के लिए 7891029090 पर कॉल करें । धन्यवाद ! – DAIRY MUNEEM';
// $dlt = D_DLT;
// $sendmsg = $this->CI->messages->sendSmsMsg91($receive['phone'], $msg, $dlt);
//--- send welcome msg ---------
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://control.msg91.com/api/v5/flow/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '
                {
                "template_id": "649e7f1bd6fc0504df28fcc3",
                "sender": "514279",
                "short_url": "0",
                "mobiles": "91' . $receive['phone'] . '"
                }
                ',
    CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'authkey: ' . SMSAUTH . '',
        'charset: UTF-8',
        'content-type: application/json',
        'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
    ),
));
$response = curl_exec($curl);
curl_close($curl);
//--- send email to admin -----------------
$this->db->select('*');
$this->db->from('all_states');
$this->db->where('id',$receive['state']);
$dsa= $this->db->get()->row();
if(!empty($dsa)){
$nn221 = $dsa->state_name;
}
else{
    $nn221 = ""; 
}
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
            You have received new registration request from a doctor and below are the details<br/><br/>
            <b>Doctor ID</b> - ' . $last_id2 . '<br/>
            <b>Doctor Name</b> - ' . $receive['name'] . '<br/>
            <b>District</b> - ' . $receive['district'] . '<br/>
            <b>City</b> - ' . $receive['city'] . '<br/>
            <b>State</b> - ' . $nn221 . '<br/>
            <b>Phone</b> - ' . $receive['phone'] . '<br/>
            <b>Email</b> - ' . $receive['email'] . '<br/>
            <b>Type</b> - ' . $receive['type'] . '<br/>
            <b>Degree</b> - ' . $receive['degree'] . '<br/>
            <b>Experience</b> - ' . $receive['experience'] . '<br/>
            <b>Pincode</b> - ' . $receive['pincode'] . '<br/>
                ';
$this->CI->load->library('email', $config);
$this->CI->email->set_newline("");
$this->CI->email->from(EMAIL); // change it to yours
$this->CI->email->to(TO, 'Dairy Muneem'); // change it to yours
$this->CI->email->subject('New registration request received from a doctor');
$this->CI->email->message($message2);
if ($this->CI->email->send()) {
} else {
}
$respone['status'] = 200;
$respone['message'] = 'Successfully Registered!';
$respone['data'] = $data;
return json_encode($respone);
} else {
//------ insert user data from temp to user table -----------

$auth = bin2hex(random_bytes(18)); //--- generate auth ---
$data_insert = array(
    'name' => $receive['name'],
    'district' => $receive['district'],
    'city' => $receive['city'],
    'state' => $receive['state'],
    'pincode' => $receive['pincode'],
    'refer_code' => $receive['refer_code'],
    'phone' => $receive['phone'],
    'shop_name' => $receive['shop_name'],
    'address' => $receive['address'],
    'image' => $receive['image'],
    'pan_number' => $receive['pan_no'],
    'gst_no' => $receive['gst_no'],
    'aadhar_no' => $receive['aadhar_no'],
    'email' => $receive['email'],
    'auth' => $auth,
    'is_approved' => 0,
    'is_active' => 1,
    'latitude' => $receive['latitude'],
    'longitude' => $receive['longitude'],
    'date' => $cur_date
);
$last_id2 = $this->CI->base_model->insert_table("tbl_vendor", $data_insert, 1);
$data = array(
    'name' => $receive['name'],
    'auth' => $auth,
    'is_login' => 1,
);
//--- send welcome msg ---------
// $msg = 'प्रिय  दुकानदार जी, आपका पंजीकरण सफल हुआ, DAIRY MUNEEM में आपका स्वागत है। कुछ देर में आप की आईडी एक्टिव हो जाएगी। उसके बाद आप अपने उत्पादों को बेचने के लिए डाल सकते हैं । व्हाट्सएप द्वारा हमसे जुड़ने के लिए क्लिक करें bit.ly/dairy_muneem। अधिक जानकारी के लिए 7891029090 पर कॉल करें । धन्यवाद ! – DAIRY MUNEEM';
// $dlt = V_DLT;
// $sendmsg = $this->CI->messages->sendSmsMsg91($receive['phone'], $msg, $dlt);
//--- send welcome msg ---------
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://control.msg91.com/api/v5/flow/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '
                {
                "template_id": "649e7f76d6fc056e32336712",
                "sender": "514279",
                "short_url": "0",
                "mobiles": "91' . $receive['phone'] . '"
                }
                ',
    CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'authkey: ' . SMSAUTH . '',
        'charset: UTF-8',
        'content-type: application/json',
        'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
    ),
));
$response = curl_exec($curl);
curl_close($curl);
//--- send email to admin -----------------
$this->db->select('*');
$this->db->from('all_states');
$this->db->where('id',$receive['state']);
$dsa= $this->db->get()->row();
if(!empty($dsa)){
$nn221 = $dsa->state_name;
}
else{
    $nn221 = ""; 
}
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
            You have received new registration request from a vendor and below are the details<br/><br/>
            <b>Vendor ID</b> - ' . $last_id2 . '<br/>
            <b>Vendor Name</b> - ' . $receive['name'] . '<br/>
            <b>Shop Name</b> - ' . $receive['shop_name'] . '<br/>
            <b>Address</b> - ' . $receive['address'] . '<br/>
            <b>District</b> - ' . $receive['district'] . '<br/>
            <b>City</b> - ' . $receive['city'] . '<br/>
            <b>State</b> - ' . $nn221 . '<br/>
            <b>Phone</b> - ' . $receive['phone'] . '<br/>
            <b>Email</b> - ' . $receive['email'] . '<br/>
            <b>Type</b> - ' . $receive['type'] . '<br/>
            <b>Degree</b> - ' . $receive['degree'] . '<br/>
            <b>Experience</b> - ' . $receive['experience'] . '<br/>
            <b>Pincode</b> - ' . $receive['pincode'] . '<br/>
                ';
$this->CI->load->library('email', $config);
$this->CI->email->set_newline("");
$this->CI->email->from(EMAIL); // change it to yours
$this->CI->email->to(TO, 'Dairy Muneem'); // change it to yours
$this->CI->email->subject('New registration request received from a vendor');
$this->CI->email->message($message2);
if ($this->CI->email->send()) {
} else {
}
$respone['status'] = 200;
$respone['message'] = 'Successfully Registered!';
$respone['data'] = $data;
return json_encode($respone);
}
} else {
$respone['status'] = false;
$respone['message'] = 'User allready registered';
$this->CI->session->set_flashdata('emessage', 'Some error occurred!');
return json_encode($respone);
die();
}
}
//============================================= LOGIN WITH OTP ==============================================
public function farmer_LogindWithOtp($phone)
{
// if (empty($this->CI->session->userdata('user_data'))) {
$ip = $this->CI->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date = date("Y-m-d H:i:s");
//------ Check for user  exist or not ----------


//--------------- Insert data into otp table -----
$OTP = random_int(100000, 999999);
if ($phone == '0000000000' || $phone == '7777777777' || $phone == '5555555555') {
$OTP = 123456;
}
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
// $dlt = '645ca712d6fc053e3918af93';
$dlt = '1407172223704961719';
// $message = "Dear User, your OTP for login on Dairy Muneem is $OTP and is valid for 5 minutes pUv%2BEzzZ5mI";
$message = "Dear User, your OTP for login on Dairy Muneem is $OTP and is valid for 5 minutes OQDN0bWIEBF";

// $sendmsg = $this->CI->messages->sendOtpMsg91($phone, $OTP, $dlt);
$sendmsg = $this->CI->messages->sendSmsMsg91($phone, $message, $dlt);
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


//==================================== LOGIN OTP VERIFY ==========================================


public function farmer_LoginOtpVerify($phone, $input_otp, $call_type)
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
    // -------------check user register or not-----------------

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
    if (!empty($type)) {

        if ($call_type != $type) {
            $respone['status'] = 200;
            if ($call_type == 'farmer') {
                $respone['message'] = 'This number is not registered as a farmer!';
                $respone['data'] = array(
                    'phone' => $phone,
                    'is_login' => 0,
                );
            } else if ($call_type == 'doctor') {
                $respone['message'] = 'This number is not registered as a doctor!';
                $respone['data'] = array(
                    'phone' => $phone,
                    'is_login' => 0,
                );
            } else {
                $respone['message'] = 'This number is not registered as a vendor!';
                $respone['data'] = array(
                    'phone' => $phone,
                    'is_login' => 0,
                );
            }
            $this->CI->session->set_flashdata('emessage', 'Some error occurred!');
            return json_encode($respone);
            die();
        }
        // ----------------------- user login handle --------------------------------
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
        }
        //------ user is inactive --------
        else {
            $respone['status'] = 201;
            $respone['message'] = 'Your Account is blocked! Please contact to admin';
            // $this->CI->session->set_flashdata('emessage', 'Your Account is blocked! Please contact to admin');
            return json_encode($respone);
        }


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
                        'image' => $user_data[0]->image ? base_url() . $user_data[0]->image : '',
                        'auth' => $user_data[0]->auth,
                        'is_expert' => $user_data[0]->is_expert,
                        'is_login' => 1,
                    );
                }
                if ($type == 'vendor') {
                    $data = array(
                        'name' => $user_data[0]->name,
                        'image' => $user_data[0]->image ? base_url() . $user_data[0]->image : '',
                        'auth' => $user_data[0]->auth,
                        'is_login' => 1,
                    );
                } else {
                    $data = array(
                        'name' => $user_data[0]->name,
                        'auth' => $user_data[0]->auth,
                        'is_login' => 1,
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
        $respone['status'] = 200;
        $respone['message'] = 'User Not Found! Please Register First';
        $respone['data'] = array(
            'phone' => $phone,
            'is_login' => 0,
        );
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
'refer_code' => (isset($receive['refer_code'])) ? $receive['refer_code'] : '',
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
'latitude' => $receive['latitude'],
'longitude' => $receive['longitude'],
'no_animals' => $receive['no_animals'],
'expert_category' => $receive['expert_category'],
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
$dlt = '645ca6f9d6fc057295695743';
$sendmsg = $this->CI->messages->sendOtpMsg91($receive['phone'], $OTP, $dlt);
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
                'refer_code'=>$temp_data[0]->refer_code ?? '',
                'no_animals' => $temp_data[0]->no_animals,
                'gst_no' => $temp_data[0]->gst,
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
            //--- send welcome msg ---------
            // $msg = 'प्रिय किसान, आपका पंजीकरण सफल हुआ, DAIRY MUNEEM में आपका स्वागत है। विभिन्न सुविधाओं के लिए डेयरी मुनीम ऐप का इस्तेमाल करें। व्हाट्सएप द्वारा हमसे जुड़ने के लिए क्लिक करें bit.ly/dairy_muneem। अधिक जानकारी के लिए 7891029090 पर कॉल करें । धन्यवाद ! – DAIRY MUNEEM';
            // $dlt = F_DLT;
            // $sendmsg = $this->CI->messages->sendSmsMsg91($temp_data[0]->phone, $msg, $dlt);
            //--- send welcome msg ---------
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://control.msg91.com/api/v5/flow/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '
                {
                "template_id": "649e7ef5d6fc055fd16f92a2",
                "sender": "514279",
                "short_url": "0",
                "mobiles": "91' . $temp_data[0]->phone . '"
                }
                ',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'authkey: ' . SMSAUTH . '',
                    'charset: UTF-8',
                    'content-type: application/json',
                    'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            // echo $response;
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
                'refer_code'=>$temp_data[0]->refer_code ?? '',
                'email' => $temp_data[0]->email,
                'type' => $dt,
                'degree' => $temp_data[0]->degree,
                'experience' => $temp_data[0]->experience,
                'pincode' => $temp_data[0]->pincode,
                // 'qualification' => $temp_data[0]->qualification,
                'aadhar_no' => $temp_data[0]->aadhar_no,
                'image' => $temp_data[0]->image,
                'expert_category' => $temp_data[0]->expert_category,
                'auth' => $auth,
                'is_active' => 1,
                'is_approved' => 1,
                'is_expert' => 0,
                'account' => 0,
                'latitude' => '',
                'longitude' => '',
                'date' => $cur_date
            );
            $last_id2 = $this->CI->base_model->insert_table("tbl_doctor", $data_insert, 1);
            $data = array(
                'name' => $temp_data[0]->name,
                'is_expert' => 0,
                'auth' => $auth,
            );
            //--- send welcome msg ---------
            // $msg = 'आदरणीय  डॉक्टर जी, आपका पंजीकरण सफल हुआ, DAIRY MUNEEM में आपका स्वागत है। कुछ देर में आप की आईडी एक्टिव हो जाएगी।व्हाट्सएप द्वारा हमसे जुड़ने के लिए क्लिक करें bit.ly/dairy_muneem। अधिक जानकारी के लिए 7891029090 पर कॉल करें । धन्यवाद ! – DAIRY MUNEEM';
            // $dlt = D_DLT;
            // $sendmsg = $this->CI->messages->sendSmsMsg91($temp_data[0]->phone, $msg, $dlt);
            //--- send welcome msg ---------
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://control.msg91.com/api/v5/flow/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '
                {
                "template_id": "649e7f1bd6fc0504df28fcc3",
                "sender": "514279",
                "short_url": "0",
                "mobiles": "91' . $temp_data[0]->phone . '"
                }
                ',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'authkey: ' . SMSAUTH . '',
                    'charset: UTF-8',
                    'content-type: application/json',
                    'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            //--- send email to admin -----------------
            $this->CI->db->select('*');
            $this->CI->db->from('all_states');
            $this->CI->db->where('id',$temp_data[0]->state);
            $dsa= $this->CI->db->get()->row();
            if(!empty($dsa)){
            $nn221 = $dsa->state_name;
            }
            else{
                $nn221 = ""; 
            }
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
            You have received new registration request from a doctor and below are the details<br/><br/>
            <b>Doctor ID</b> - ' . $last_id2 . '<br/>
            <b>Doctor Name</b> - ' . $temp_data[0]->name . '<br/>
            <b>District</b> - ' . $temp_data[0]->district . '<br/>
            <b>City</b> - ' . $temp_data[0]->city . '<br/>
            <b>State</b> - ' . $nn221 . '<br/>
            <b>Phone</b> - ' . $temp_data[0]->phone . '<br/>
            <b>Email</b> - ' . $temp_data[0]->email . '<br/>
            <b>Type</b> - ' . $temp_data[0]->type . '<br/>
            <b>Degree</b> - ' . $temp_data[0]->degree . '<br/>
            <b>Experience</b> - ' . $temp_data[0]->experience . '<br/>
            <b>Pincode</b> - ' . $temp_data[0]->pincode . '<br/>
                ';
            $this->CI->load->library('email', $config);
            $this->CI->email->set_newline("");
            $this->CI->email->from(EMAIL); // change it to yours
            $this->CI->email->to(TO, 'Dairy Muneem'); // change it to yours
            $this->CI->email->subject('New registration request received from a doctor');
            $this->CI->email->message($message2);
            if ($this->CI->email->send()) {
            } else {
            }
            //Send Whatsapp Message to Admin 
            $form_type = "Registration Request of Doctor";
            $url_type = "RegisterDoctor";
            $full_name = 'Dairy Muneem';
            $details = 'Name - ' . $temp_data[0]->name . ',District - ' . $temp_data[0]->district . ', City - ' . $temp_data[0]->city . ',Phone - ' . $temp_data[0]->phone . ',Type - ' . $temp_data[0]->type . ',Degree - ' . $temp_data[0]->degree . ',Experience - ' . $temp_data[0]->experience . '';
            $this->send_whatsapp_msg_admin($details,$full_name,$form_type,$url_type);
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
                'refer_code'=>$temp_data[0]->refer_code ?? '',
                'shop_name' => $temp_data[0]->shop_name,
                'address' => $temp_data[0]->address,
                'image' => $temp_data[0]->image,
                'pan_number' => $temp_data[0]->pan_no,
                'gst_no' => $temp_data[0]->gst,
                'aadhar_no' => $temp_data[0]->aadhar_no,
                'email' => $temp_data[0]->email,
                'auth' => $auth,
                'is_approved' => 1, //change 0 to 1 for no approval required on june 
                'is_active' => 1,
                'latitude' => $temp_data[0]->latitude,
                'longitude' => $temp_data[0]->longitude,
                'date' => $cur_date
            );
            $last_id2 = $this->CI->base_model->insert_table("tbl_vendor", $data_insert, 1);
            $data = array(
                'name' => $temp_data[0]->name,
                'auth' => $auth,
            );
            //--- send welcome msg ---------
            // $msg = 'प्रिय  दुकानदार जी, आपका पंजीकरण सफल हुआ, DAIRY MUNEEM में आपका स्वागत है। कुछ देर में आप की आईडी एक्टिव हो जाएगी। उसके बाद आप अपने उत्पादों को बेचने के लिए डाल सकते हैं । व्हाट्सएप द्वारा हमसे जुड़ने के लिए क्लिक करें bit.ly/dairy_muneem। अधिक जानकारी के लिए 7891029090 पर कॉल करें । धन्यवाद ! – DAIRY MUNEEM';
            // $dlt = V_DLT;
            // $sendmsg = $this->CI->messages->sendSmsMsg91($temp_data[0]->phone, $msg, $dlt);
            //--- send welcome msg ---------
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://control.msg91.com/api/v5/flow/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '
                {
                "template_id": "649e7f76d6fc056e32336712",
                "sender": "514279",
                "short_url": "0",
                "mobiles": "91' . $temp_data[0]->phone . '"
                }
                ',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'authkey: ' . SMSAUTH . '',
                    'charset: UTF-8',
                    'content-type: application/json',
                    'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            //--- send email to admin -----------------
            $this->CI->db->select('*');
$this->CI->db->from('all_states');
$this->CI->db->where('id',$temp_data[0]->state);
$dsa= $this->CI->db->get()->row();
if(!empty($dsa)){
$nn221 = $dsa->state_name;
}
else{
    $nn221 = ""; 
}
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
            You have received new registration request from a vendor and below are the details<br/><br/>
            <b>Vendor ID</b> - ' . $last_id2 . '<br/>
            <b>Vendor Name</b> - ' . $temp_data[0]->name . '<br/>
            <b>Shop Name</b> - ' . $temp_data[0]->shop_name . '<br/>
            <b>Address</b> - ' . $temp_data[0]->address . '<br/>
            <b>District</b> - ' . $temp_data[0]->district . '<br/>
            <b>City</b> - ' . $temp_data[0]->city . '<br/>
            <b>State</b> - ' . $nn221 . '<br/>
            <b>Phone</b> - ' . $temp_data[0]->phone . '<br/>
            <b>Email</b> - ' . $temp_data[0]->email . '<br/>
            <b>Type</b> - ' . $temp_data[0]->type . '<br/>
            <b>Degree</b> - ' . $temp_data[0]->degree . '<br/>
            <b>Experience</b> - ' . $temp_data[0]->experience . '<br/>
            <b>Pincode</b> - ' . $temp_data[0]->pincode . '<br/>
                ';
            $this->CI->load->library('email', $config);
            $this->CI->email->set_newline("");
            $this->CI->email->from(EMAIL); // change it to yours
            $this->CI->email->to(TO, 'Dairy Muneem'); // change it to yours
            $this->CI->email->subject('New registration request received from a vendor');
            $this->CI->email->message($message2);
            if ($this->CI->email->send()) {
            } else {
            }
             //Send Whatsapp Message to Admin 
             $form_type = "Registration Request of Vendor";
             $url_type = "RegisterVendor";
             $full_name = 'Dairy Muneem';
             $details = 'Name - ' . $temp_data[0]->name . ',District - ' . $temp_data[0]->district . ', City - ' . $temp_data[0]->city . ',Phone - ' . $temp_data[0]->phone . ',Type - ' . $temp_data[0]->type . ',Degree - ' . $temp_data[0]->degree . ',Experience - ' . $temp_data[0]->experience . '';
             $this->send_whatsapp_msg_admin($details,$full_name,$form_type,$url_type);
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
if ($type == 'vendor' || $type == 'doctor')
 {
// if ($userCheck[0]->is_approved == 0) {
//     $respone['status'] = 201;
//     $respone['message'] = 'Your account request is pending! Please contact to admin';
//     // $this->CI->session->set_flashdata('emessage', 'Your Account is blocked! Please contact to admin');
//     return json_encode($respone);
//     die();
// } else 
if ($userCheck[0]->is_approved == 2) {
    $respone['status'] = 201;
    $respone['message'] = 'Your account  request is rejected! Please contact to admin';
    // $this->CI->session->set_flashdata('emessage', 'Your Account is blocked! Please contact to admin');
    return json_encode($respone);
    die();
}
}
//--------------- Insert data into otp table -----
$OTP = random_int(100000, 999999);
if ($phone == '0000000000' || $phone == '7777777777' || $phone == '5555555555') {
$OTP = 123456;
}
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
$dlt = '645ca712d6fc053e3918af93';
$sendmsg = $this->CI->messages->sendOtpMsg91($phone, $OTP, $dlt);
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
            if ($type == 'doctor') {
                // if ($user_data[0]->is_approved == 0) {
                //     $respone['status'] = 201;
                //     $respone['message'] = 'Your account request is pending! Please contact to admin';
                //     return json_encode($respone);
                //     die();
                // } 
                // else 
                if ($user_data[0]->is_approved == 2) {
                    $respone['status'] = 201;
                    $respone['message'] = 'Your account  request is rejected! Please contact to admin';
                    return json_encode($respone);
                    die();
                }
            }
            // changes for vendor aproval not required
            // if ($type == 'vendor' || $type == 'doctor') {
            //     if ($user_data[0]->is_approved == 0) {
            //         $respone['status'] = 201;
            //         $respone['message'] = 'Your account request is pending! Please contact to admin';
            //         return json_encode($respone);
            //         die();
            //     } else if ($user_data[0]->is_approved == 2) {
            //         $respone['status'] = 201;
            //         $respone['message'] = 'Your account  request is rejected! Please contact to admin';
            //         return json_encode($respone);
            //         die();
            //     }
            // }
            if ($type == 'doctor') {
                $data = array(
                    'name' => $user_data[0]->name,
                    'image' => $user_data[0]->image ? base_url() . $user_data[0]->image : '',
                    'auth' => $user_data[0]->auth,
                    'is_expert' => $user_data[0]->is_expert,
                );
            }
            if ($type == 'vendor') {
                $data = array(
                    'name' => $user_data[0]->name,
                    'image' => $user_data[0]->image ? base_url() . $user_data[0]->image : '',
                    'auth' => $user_data[0]->auth,
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
public function send_whatsapp_msg_admin($details,$full_name,$form_type,$url_type)
{

//---- sending whatspp msg to admin -------
$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://whatsapp.fineoutput.com/send_request_message',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS => 'customer_name='.$full_name.'&phone=' . 6350618905 . '&form_name='.$form_type.'&details=' . $details . '&url_type='.$url_type,
// CURLOPT_POSTFIELDS => 'customer_name='.$full_name.'&phone=' . WHATSAPP_NUMBER1 . '&form_name='.$form_type.'&details=' . $details . '&url_type='.$url_type,
CURLOPT_HTTPHEADER => array(
// 'token:'.TOKEN.'',
'Content-Type:application/x-www-form-urlencoded',
'Cookie:ci_session=e40e757b02bc2d8fb6f5bf9c5b7bb2ea74c897e8'
),
));
$respons = curl_exec($curl);
curl_close($curl);
return true;
}
}
