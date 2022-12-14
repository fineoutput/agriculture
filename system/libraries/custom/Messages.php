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
    //=========================================== SENT PRIORITY SMS =============================================
    public function sendOtpPrioritysms($phone, $msg)
    {
        $sms_text = urlencode($msg);
        //-------- Start Curl -----------
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://alerts.prioritysms.com/api/web2sms.php?workingkey=A3dd249c096dabadfca43a97952624aed&to=".$phone."&sender=SUPTEC&message=".$sms_text."",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_POSTFIELDS => "",
          CURLOPT_HTTPHEADER => array(
            "Postman-Token: 29403299-fe01-4795-bf32-437b3bdb487b",
            "cache-control: no-cache"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "CURL Error #:" . $err;
        } else {
            //echo $response;
        }
    }
    public function sendOtpDigitalIndiasms($phone, $msg,$temp_id){
      $sms_text = urlencode($msg);
      //-------- Start Curl -----------
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "http://bulksms.thedigitalindia.in/index.php/smsapi/httpapi/?secret=".SMSAUTH."&sender=CABMEI&tempid=".$temp_id."&receiver=".$phone."&route=TA&msgtype=1&sms=".$sms_text."",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
          "Postman-Token: 29403299-fe01-4795-bf32-437b3bdb487b",
          "cache-control: no-cache"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
          echo "CURL Error #:" . $err;
      } else {
          //echo $response;
      }

    }
}
