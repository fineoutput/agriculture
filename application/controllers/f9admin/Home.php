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
            $this->db->where('is_approved', 1);
            $c = $this->db->count_all_results();
            $data['vendor'] = $c;
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_approved', 1);
            $this->db->where('is_expert', 1);
            $expert = $this->db->count_all_results();
            $data['expert'] = $expert;
            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('is_approved', 1);
            $this->db->where('is_expert', 0);
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
            $this->db->where('is_approved', 1);
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
            $this->db->where('order_status', 1); //new orders
            $this->db->where('is_admin', 1);
            $todays = $this->db->get();
            $today = 0;
            foreach ($todays->result() as $td) {
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d");
                $datetime = new DateTime($td->date);
                $date_only = $datetime->format("Y-m-d");
                if ($cur_date == $date_only) {
                    $today++;
                }
            }
            $data['today'] = $today;
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

            $this->db->select_sum('final_amount');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 0);
            $query = $this->db->get();
            $data['total_v_orders'] = $query->row()->final_amount;

            $this->db->select_sum('fees');
            $this->db->from('tbl_doctor_req');
            $this->db->where('payment_status', 1);
            $query = $this->db->get();
            $data['total_d_orders'] = $query->row()->fees;


            $this->db->select_sum('cr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('req_id !=', 'NULL');
            $this->db->where('doctor_id	 !=', 'NULL');
            $queryd = $this->db->get();
            $data['doctors_earning'] = $queryd->row()->cr;

            $this->db->select_sum('cr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('req_id !=', 'NULL');
            $this->db->where('vendor_id	 !=', 'NULL');
            $queryv = $this->db->get();
            $data['vendor_earning'] = $queryv->row()->cr;


            // $this->db->select_sum('dr');
            // $this->db->from('tbl_payment_txn');
            // $this->db->where('admin_id !=', 'NULL');
            // $this->db->where('doctor_id	 !=', 'NULL');
            // $querydq = $this->db->get();
            // $data['total_payments_processed_to_doctor'] = $querydq->row()->dr;

            // $this->db->select_sum('dr');
            // $this->db->from('tbl_payment_txn');
            // $this->db->where('admin_id !=', 'NULL');
            // $this->db->where('vendor_id	 !=', 'NULL');
            // $queryvq = $this->db->get();
            // $data['total_payments_processed_to_vendor'] = $queryvq->row()->dr;
            $this->db->select_sum('amount');
            $this->db->from('tbl_payments_req');
            $this->db->where('doctor_id	 !=', 'NULL');
            $this->db->where('status', 1);
            $querydq = $this->db->get();
            $data['total_payments_processed_to_doctor'] = $querydq->row()->amount;

            $this->db->select_sum('amount');
            $this->db->from('tbl_payments_req');
            $this->db->where('vendor_id	 !=', 'NULL');
            $this->db->where('status', 1);
            $queryvq = $this->db->get();
            $data['total_payments_processed_to_vendor'] = $queryvq->row()->amount;


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
    public function view_service_report()
    {

        if (!empty($this->session->userdata('admin_data'))) {
            $type = $_GET['type'];
            $data['user_name'] = $this->load->get_var('user_name');

            if (empty($type)) {
                $this->load->view('admin/login/index');
                die();
            }
            $send = [];
            $heading = '';
            if ($type == 'weight_calculator') {
                $heading = 'Weight Calculator';
                $send = $this->db->get_where('tbl_service_records_txn', array('service' => 'weight_calculator'))->result();
            }
            if ($type == 'dmi_calculator') {
                $heading = 'DMI Calculator';
                $send = $this->db->get_where('tbl_service_records_txn', array('service' => 'dmi_calculator'))->result();
            }
            if ($type == 'feed_calculator') {
                $heading = 'Feed Calculator';
                $send = $this->db->get_where('tbl_service_records_txn', array('service' => 'feed_calculator'))->result();
            }
            if ($type == 'preg_calculator') {
                $heading = 'Pregnancy Calculator';

                $send = $this->db->get_where('tbl_service_records_txn', array('service' => 'preg_calculator'))->result();
            }
            if ($type == 'silage_making') {
                $heading = 'Silage Making';
                $send = $this->db->get_where('tbl_service_records_txn', array('service' => 'silage_making'))->result();
            }
            if ($type == 'animal_req') {
                $heading = 'Animal Requirement';
                $send = $this->db->get_where('tbl_service_records_txn', array('service' => 'animal_req'))->result();
            }
            if ($type == 'pro_req') {
                $heading = 'Project Requirement';
                $send = $this->db->get_where('tbl_service_records_txn', array('service' => 'pro_req'))->result();
            }
            $data['service_data'] = $send;
            $data['heading'] = $heading;

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/subscription/view_service_reports');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }
}
