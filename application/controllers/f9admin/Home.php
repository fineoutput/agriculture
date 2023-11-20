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
            $this->db->where('is_expert', 1);
            $expert = $this->db->count_all_results();
            $data['expert'] = $expert;
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_expert', 1);
            $normal = $this->db->count_all_results();
            $data['normal'] = $normal;
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('is_admin', 1);
            $admin_product = $this->db->count_all_results();
            $data['admin_product'] = $admin_product;
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('is_admin', 0);
            $vendor_product = $this->db->count_all_results();
            $data['vendor_product'] = $vendor_product;
            $this->db->select('*');
            $this->db->from('tbl_service_records');
            $data['service_report'] = $this->db->get()->row();

            //Admin Orders

            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 1);
            $data['total_orders'] = $this->db->count_all_results();

            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 1); //new orders
            $this->db->where('is_admin', 1);
            $data['new_orders'] = $this->db->count_all_results();

            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 1);
            $this->db->where('order_status', 2); //accepted orders
            $data['accepted_orders'] = $this->db->count_all_results();

            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 1);
            $this->db->where('order_status', 3); //dispatched orders
            $data['dispatched_orders'] = $this->db->count_all_results();

            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 1);
            $this->db->where('order_status', 4); //delivered orders
            $data['delivered_orders'] = $this->db->count_all_results();


            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 1);
            $this->db->where('order_status', 4); //delivered orders
            $data['delivered_orders'] = $this->db->count_all_results();

            $this->db->select_sum('final_amount');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 1);
            $query = $this->db->get();
            $data['total_earning'] = $query->row()->final_amount;


            $this->db->select_sum('cr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('req_id !=','NULL');
            $this->db->where('doctor_id	 !=','NULL');
            $queryd = $this->db->get();
            $data['doctors_earning'] = $queryd->row()->cr;

            $this->db->select_sum('cr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('req_id !=','NULL');
            $this->db->where('vendor_id	 !=','NULL');
            $queryv = $this->db->get();
            $data['vendor_earning'] = $queryv->row()->cr;


            $this->db->select_sum('dr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('admin_id !=','NULL');
            $this->db->where('doctor_id	 !=','NULL');
            $querydq = $this->db->get();
            $data['total_payments_processed_to_doctor'] = $querydq->row()->dr;

            $this->db->select_sum('dr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('admin_id !=','NULL');
            $this->db->where('vendor_id	 !=','NULL');
            $queryvq = $this->db->get();
            $data['total_payments_processed_to_vendor'] = $queryvq->row()->dr;


            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('payment_status', 1);
            $data['total_doctor_requests'] = $this->db->count_all_results();

            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 0);
            $data['total_vendor_orders'] = $this->db->count_all_results();


            $this->db->select_sum('price');
            $this->db->from('tbl_subscription_buy');
            $this->db->where('payment_status', 1);
            $querysb = $this->db->get();
            $data['subscriptions_purchased'] = $querysb->row()->price;

            $this->db->select_sum('price');
            $this->db->from('tbl_check_my_feed_buy');
            $this->db->where('payment_status', 1);
            $querysb2 = $this->db->get();
            $data['check_my_feed'] = $querysb2->row()->price;

           

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/dash');
            $this->load->view('admin/common/footer_view');
        } else {
            $this->load->view('admin/login/index');
        }
    }
}
