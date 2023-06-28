<?php
if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class CI_Messages
{
    protected $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('form');
        $this->CI->load->model("admin/login_model");
        $this->CI->load->model("admin/base_model");
    }
    //=========================================== SENT MSG91 SMS =============================================
    public function sendOtpMsg91($phone, $msg,$otp,$dlt)
    {
      $message = urlencode($msg);
      $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://api.msg91.com/api/sendotp.php?authkey='.SMSAUTH.'&mobile=91'.$phone.'&message='.$message.'&sender='.SMSID.'&otp='.$otp.'&DLT_TE_ID='.$dlt.'',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Cookie: PHPSESSID=prqus0jgeu7bi43bp2d1hjgtv0'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    // echo $response;die();
    }
    //=========================================== SENT MSG91 SMS =============================================
    public function sendSmsMsg91($phone, $msg,$dlt)
    {
      $message = urlencode($msg);
      $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://api.msg91.com/api/sendhttp.php?authkey='.SMSAUTH.'&mobiles=91'.$phone.'&message='.$message.'&sender='.SMSID.'&DLT_TE_ID='.$dlt.'',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Cookie: PHPSESSID=prqus0jgeu7bi43bp2d1hjgtv0'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    // echo $response;die();
    }
}
