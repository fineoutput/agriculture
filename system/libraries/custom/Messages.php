<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}
class CI_Messages
{
  protected $CI;
  public function __construct()
  {
    $this->CI = &get_instance();
    $this->CI->load->helper('form');
    $this->CI->load->model("admin/login_model");
    $this->CI->load->model("admin/base_model");
  }
  //=========================================== SENT MSG91 SMS =============================================
  public function sendOtpMsg91($phone, $otp, $dlt)
  {
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
"template_id": "' . $dlt . '",
"short_url": "1",
"recipients": [
{
"mobiles": "91' . $phone . '",
"var": "' . $otp . '"
}
]
}
',
      CURLOPT_HTTPHEADER => array(
        'accept: application/json',
        'authkey: '.SMSAUTH.'',
        'content-type: application/json',
        'Cookie: PHPSESSID=4al34vh1tsa69nuiceksh6me22'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    // echo $response;
  }
  //=========================================== SENT MSG91 SMS =============================================
  public function sendSmsMsg91($phone, $msg, $dlt)
  {
    $message = urlencode($msg);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://api.msg91.com/api/sendhttp.php?authkey=' . SMSAUTH . '&mobiles=91' . $phone . '&message=' . $message . '&sender=' . SMSID . '&route=4&DLT_TE_ID=' . $dlt . '',
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
