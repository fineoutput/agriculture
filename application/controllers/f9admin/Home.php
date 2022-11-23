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

		function index(){

			if(!empty($this->session->userdata('admin_data'))){


				$data['user_name']=$this->load->get_var('user_name');

				// echo SITE_NAME;

				$this->db->select('*');
				$this->db->from('tbl_admin_sidebar');
				// $this->db->where('student_shift',$cvf);
				$data['sidebar_data']= $this->db->get();

				// echo $this->session->userdata('image');
				// echo $this->session->userdata('position');
			// exit;

			      			$this->db->select('*');
			$this->db->from('tbl_team');
			//$this->db->where('id',$usr);
			$a= $this->db->count_all_results();

			$this->db->select('*');
	$this->db->from('tbl_farmers');
	//$this->db->where('id',$usr);
	$b= $this->db->count_all_results();

	$this->db->select('*');
$this->db->from('tbl_vendor');
//$this->db->where('id',$usr);
$c= $this->db->count_all_results();

$this->db->select('*');
$this->db->from('tbl_doctor');
//$this->db->where('id',$usr);
$d= $this->db->count_all_results();

$this->db->select('*');
$this->db->from('tbl_products');
//$this->db->where('id',$usr);
$e= $this->db->count_all_results();




// echo $a;
// exit;

$data['team']=$a;
$data['farmers']=$b;
$data['vendor']=$c;

$data['doctor']=$d;
$data['products']=$e;





			$this->load->view('admin/common/header_view',$data);
				$this->load->view('admin/dash');
				$this->load->view('admin/common/footer_view');

		}
		else{

				$this->load->view('admin/login/index');
		}

		}



}
