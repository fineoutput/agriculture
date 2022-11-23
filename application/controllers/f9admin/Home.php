<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Home extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}
		//-------------------------------------------------------------------------
		function index(){


			if(!empty($this->session->userdata('admin_data'))){


				$data['user_name']=$this->load->get_var('user_name');

				// echo SITE_NAME;

				$this->db->select('*');
				$this->db->from('tbl_admin_sidebar');
				// $this->db->where('student_shift',$cvf);
				$data['sidebar_data']= $this->db->get();

	      	      			$this->db->select('*');
	      	$this->db->from('tbl_farmers');
					$b= $this->db->count_all_results();

					$data['farmer']=$b;

			      			$this->db->select('*');
			$this->db->from('tbl_team');
			$a= $this->db->count_all_results();
$data['team']=$a;

$this->db->select('*');
$this->db->from('tbl_vendor');
$c= $this->db->count_all_results();

$data['vendor']=$c;

$this->db->select('*');
$this->db->from('tbl_doctor');
$d= $this->db->count_all_results();

$data['doctor']=$d;

$this->db->select('*');
$this->db->from('tbl_products');
$e= $this->db->count_all_results();

$data['product']=$e;


$this->db->select('*');
$this->db->from('tbl_payments');
$f= $this->db->count_all_results();

$data['payments']=$f;

			$this->load->view('admin/common/header_view',$data);
				$this->load->view('admin/dash');
				$this->load->view('admin/common/footer_view');

		}
		else{

				$this->load->view('admin/login/index');
		}

		}



}
