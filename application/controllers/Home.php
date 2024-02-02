<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("admin/login_model");
		$this->load->model("admin/base_model");
	}
	public function index()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/index');
		$this->load->view('frontend/common/footer');
	}
	public function farmer()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/farmer');
		$this->load->view('frontend/common/footer');
	}
	public function about()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/about');
		$this->load->view('frontend/common/footer');
	}
	public function vendor()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/vendor');
		$this->load->view('frontend/common/footer');
	}
	public function doctor()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/doctor');
		$this->load->view('frontend/common/footer');
	}
	public function gallery()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/gallery');
		$this->load->view('frontend/common/footer');
	}

	public function contact()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/contact');
		$this->load->view('frontend/common/footer');
	}
	public function terms_and_conditions()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/terms_and_conditions');
		$this->load->view('frontend/common/footer');
	}
	public function refund_cancelation_policy()
	{
		$this->load->view('frontend/common/header');
		$this->load->view('frontend/refund-cancelation-policy');
		$this->load->view('frontend/common/footer');
	}
	public function error404()
	{
		$this->load->view('errors/error404');
	}
	public function privacy_policy()
	{
		$this->load->view('privacy_policy');
	}
	public function check1()
	{
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
                                "mobiles": "918387039990"
                                }
                                ',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'authkey: 396335ADmdafsq6458f062P1',
				'content-type: application/json',
				'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}
	public function check2()
	{
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
								"mobiles": "918387039990"
                                }
                                ',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'authkey: 396335ADmdafsq6458f062P1',
				'content-type: application/json',
				'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}
	public function check3()
	{
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
                                "mobiles": "918387039990"
                                }
                                ',
			CURLOPT_HTTPHEADER => array(
				'accept: application/json',
				'authkey: 396335ADmdafsq6458f062P1',
				'content-type: application/json',
				'Cookie: PHPSESSID=7nsedpqloairsa36o6h6iivst5'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
	}
}
