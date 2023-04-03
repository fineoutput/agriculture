<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Home extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }
    //****************************view Dash Function**************************************
    function index()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            $this->db->select('*');
            $this->db->from('tbl_admin_sidebar');
            // $this->db->where('student_shift',$cvf);
            $data['sidebar_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('tbl_farmers');
            $b = $this->db->count_all_results();
            $data['farmer'] = $b;
            $this->db->select('*');
            $this->db->from('tbl_vendor');
            $c = $this->db->count_all_results();
            $data['vendor'] = $c;
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_expert',1);
            $expert = $this->db->count_all_results();
            $data['expert'] = $expert;
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_expert',1);
            $normal = $this->db->count_all_results();
            $data['normal'] = $normal;
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('is_admin',1);
            $admin_product = $this->db->count_all_results();
            $data['admin_product'] = $admin_product;
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('is_admin',0);
            $vendor_product = $this->db->count_all_results();
            $data['vendor_product'] = $vendor_product;
            $this->db->select('*');
            $this->db->from('tbl_service_records');
            $data['service_report'] = $this->db->get()->row();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/dash');
            $this->load->view('admin/common/footer_view');
        } else {
            $this->load->view('admin/login/index');
        }
    }
}
