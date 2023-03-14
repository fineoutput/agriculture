<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Payments extends CI_finecontrol
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("login_model");
		$this->load->model("admin/base_model");
		$this->load->library('user_agent');
		$this->load->library('upload');
	}
	//****************************view Payments Function**************************************
	public function vendor_pending_payments()
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$this->db->select('*');
			$this->db->from('tbl_payments_req');
			$this->db->where('vendor_id is NOT NULL', NULL, FALSE);
			$this->db->where('status', 0);
			$data['Payments_data'] = $this->db->get();
			$data['title'] = 'Vendor';
			$data['type'] = 'Pending';
			$this->load->view('admin/common/header_view', $data);
			$this->load->view('admin/payments/View_payments');
			$this->load->view('admin/common/footer_view');
		} else {
			redirect("login/admin_login", "refresh");
		}
	}
	//****************************view Payments Function**************************************
	public function vendor_accepted_payments()
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$this->db->select('*');
			$this->db->from('tbl_payments_req');
			$this->db->where('vendor_id is NOT NULL', NULL, FALSE);
			$this->db->where('status', 1);
			$data['Payments_data'] = $this->db->get();
			$data['title'] = 'Vendor';
			$data['type'] = 'Accepted';
			$this->load->view('admin/common/header_view', $data);
			$this->load->view('admin/payments/View_payments');
			$this->load->view('admin/common/footer_view');
		} else {
			redirect("login/admin_login", "refresh");
		}
	}
	//****************************view Payments Function**************************************
	public function vendor_rejected_payments()
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$this->db->select('*');
			$this->db->from('tbl_payments_req');
			$this->db->where('vendor_id is NOT NULL', NULL, FALSE);
			$this->db->where('status', 2);
			$data['Payments_data'] = $this->db->get();
			$data['title'] = 'Vendor';
			$data['type'] = 'Rejected';
			$this->load->view('admin/common/header_view', $data);
			$this->load->view('admin/payments/View_payments');
			$this->load->view('admin/common/footer_view');
		} else {
			redirect("login/admin_login", "refresh");
		}
	}
	//****************************view Payments Function**************************************
	public function doctor_pending_payments()
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$this->db->select('*');
			$this->db->from('tbl_payments_req');
			$this->db->where('doctor_id is NOT NULL', NULL, FALSE);
			$this->db->where('status', 0);
			$data['Payments_data'] = $this->db->get();
			$data['type'] = 'Pending';
			$data['title'] = 'Doctor';
			$this->load->view('admin/common/header_view', $data);
			$this->load->view('admin/payments/View_payments');
			$this->load->view('admin/common/footer_view');
		} else {
			redirect("login/admin_login", "refresh");
		}
	}
	//****************************view Payments Function**************************************
	public function doctor_accepted_payments()
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$this->db->select('*');
			$this->db->from('tbl_payments_req');
			$this->db->where('doctor_id is NOT NULL', NULL, FALSE);
			$this->db->where('status', 1);
			$data['Payments_data'] = $this->db->get();
			$data['type'] = 'Accepted';
			$data['title'] = 'Doctor';
			$this->load->view('admin/common/header_view', $data);
			$this->load->view('admin/payments/View_payments');
			$this->load->view('admin/common/footer_view');
		} else {
			redirect("login/admin_login", "refresh");
		}
	}
	//****************************view Payments Function**************************************
	public function doctor_rejected_payments()
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$this->db->select('*');
			$this->db->from('tbl_payments_req');
			$this->db->where('doctor_id is NOT NULL', NULL, FALSE);
			$this->db->where('status', 2);
			$data['Payments_data'] = $this->db->get();
			$data['type'] = 'Rejected';
			$data['title'] = 'Doctor';
			$this->load->view('admin/common/header_view', $data);
			$this->load->view('admin/payments/View_payments');
			$this->load->view('admin/common/footer_view');
		} else {
			redirect("login/admin_login", "refresh");
		}
	}
	//****************************doctor_txn**************************************
	public function doctor_txn()
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$this->db->select('*');
			$this->db->from('tbl_payment_txn');
			$this->db->where('doctor_id is NOT NULL', NULL, FALSE);
			$data['txn_data'] = $this->db->get();
			$data['title'] = 'Doctor';
			$this->load->view('admin/common/header_view', $data);
			$this->load->view('admin/payments/view_payment_txn');
			$this->load->view('admin/common/footer_view');
		} else {
			redirect("login/admin_login", "refresh");
		}
	}
	//****************************vendor_txn**************************************
	public function vendor_txn()
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$this->db->select('*');
			$this->db->from('tbl_payment_txn');
			$this->db->where('vendor_id is NOT NULL', NULL, FALSE);
			$data['txn_data'] = $this->db->get();
			$data['title'] = 'Doctor';
			$this->load->view('admin/common/header_view', $data);
			$this->load->view('admin/payments/view_payment_txn');
			$this->load->view('admin/common/footer_view');
		} else {
			redirect("login/admin_login", "refresh");
		}
	}
	//****************************Update Payments Status Function**************************************
	public function updatePaymentsStatus($idd, $t)
	{
		if (!empty($this->session->userdata('admin_data'))) {
			$data['user_name'] = $this->load->get_var('user_name');
			$id = base64_decode($idd);
			if ($t == "accept") {
				$data_update = array(
					'status' => 1
				);
				$this->db->where('id', $id);
				$zapak = $this->db->update('tbl_payments_req', $data_update);
				$req_data = $this->db->get_where('tbl_payments_req', array('id' => $id))->result();
				//---- create transaction entry ----
				//---update account amount --------
				if (!empty($req_data[0]->vendor_id)) {
					$data_update = array('account' => $req_data[0]->available - $req_data[0]->amount,);
					$this->db->where('id', $req_data[0]->vendor_id);
					$zapak2 = $this->db->update('tbl_vendor', $data_update);
				} else {
					$data_update = array('account' => $req_data[0]->available - $req_data[0]->amount,);
					$this->db->where('id', $req_data[0]->doctor_id);
					$zapak2 = $this->db->update('tbl_doctor', $data_update);
				}
				$this->session->set_flashdata('smessage', 'Request accepted successfully!');
				redirect($_SERVER['HTTP_REFERER']);
			}
			if ($t == "reject") {
				$data_update = array(
					'status' => 2
				);
				$this->db->where('id', $id);
				$zapak = $this->db->update('tbl_payments_req', $data_update);
				$this->session->set_flashdata('smessage', 'Request rejected successfully!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		} else {
			$this->load->view('admin/login/index');
		}
	}
}
