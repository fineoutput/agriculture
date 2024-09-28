<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Vendor_order extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }
    //==============================new_order=========================\\
    public function new_order()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where_in('payment_status', [1, 2]);
            $this->db->order_by('id', 'desc');
            $this->db->where('order_status', 1); //new orders
            $this->db->where('is_admin', 0); //vendor orders
            $data['order1_data'] = $this->db->get();
            $count=0;
            foreach ($data['order1_data']->result() as $datas) {
                $this->db->select('*');
                $this->db->from('tbl_payment_txn');
                $this->db->where('req_id',$datas->id);
                $this->db->where('vendor_id	',$datas->vendor_id);
                $dsa_ptx= $this->db->get()->row();
               if(!empty($dsa_ptx->cr)){
                $count+=$datas->total_amount-$dsa_ptx->cr;
               }

            }
            $data['count']=$count;
            $data['heading'] = "New";
            $data['order_type'] = 1;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //================================confirmed_orders=======================\\
    public function accepted_order()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where_in('payment_status', [1, 2]);
            $this->db->order_by('id', 'desc');
            $this->db->where('order_status', 2); //accepted orders
            $this->db->where('is_admin', 0); //vendor orders
            $order1_data = $this->db->get();
            $count=0;
            foreach ($order1_data->result() as $datas) {
                $this->db->select('*');
                $this->db->from('tbl_payment_txn');
                $this->db->where('req_id',$datas->id);
                $this->db->where('vendor_id	',$datas->vendor_id);
                $dsa_ptx= $this->db->get()->row();
               if(!empty($dsa_ptx->cr)){
                $count=$count+$datas->total_amount-$dsa_ptx->cr;
               }

            }
            $data['count']=$count;


            $data['order1_data']=$order1_data; 




            $data['heading'] = "Accepted";
            $data['order_type'] = 1;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //===============================dispatched_orders========================\\
    public function dispatched_order()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->order_by('id', 'desc');
            $this->db->where('order_status', 3); //dispatched_orders
            $this->db->where('is_admin', 0); //vendor orders
          
            $order1_data = $this->db->get();
            $count=0;
            foreach ($order1_data->result() as $datas) {
                $this->db->select('*');
                $this->db->from('tbl_payment_txn');
                $this->db->where('req_id',$datas->id);
                $this->db->where('vendor_id	',$datas->vendor_id);
                $dsa_ptx= $this->db->get()->row();
               if(!empty($dsa_ptx->cr)){
                $count=$count+$datas->total_amount-$dsa_ptx->cr;
               }

            }
            $data['count']=$count;


            $data['order1_data']=$order1_data; 
            $data['heading'] = "Dispatched";
            $data['order_type'] = 1;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //=========================delievered_orders=========================\\
    public function completed_order()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->order_by('id', 'desc');
            $this->db->where('order_status', 4); //delivered orders
            $this->db->where('is_admin', 0); //vendor orders
           
            $order1_data = $this->db->get();
            $count=0;
            foreach ($order1_data->result() as $datas) {
                $this->db->select('*');
                $this->db->from('tbl_payment_txn');
                $this->db->where('req_id',$datas->id);
                $this->db->where('vendor_id	',$datas->vendor_id);
                $dsa_ptx= $this->db->get()->row();
               if(!empty($dsa_ptx->cr)){
                $count=$count+$datas->total_amount-$dsa_ptx->cr;
               }

            }
            $data['count']=$count;


            $data['order1_data']=$order1_data; 
            $data['heading'] = "Completed";
            $data['order_type'] = 1;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //=============================cancelled_order==========================\\
    public function cancelled_order()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->order_by('id', 'desc');
            $this->db->where('payment_status', 1);
            $this->db->where('order_status > ', 4); //cancelled orders
            $this->db->where('is_admin', 0); //vendor orders
            
            $order1_data = $this->db->get();
            $count=0;
            foreach ($order1_data->result() as $datas) {
                $this->db->select('*');
                $this->db->from('tbl_payment_txn');
                $this->db->where('req_id',$datas->id);
                $this->db->where('vendor_id	',$datas->vendor_id);
                $dsa_ptx= $this->db->get()->row();
               if(!empty($dsa_ptx->cr)){
                $count=$count+$datas->total_amount-$dsa_ptx->cr;
               }

            }
            $data['count']=$count;


            $data['order1_data']=$order1_data; 
            $data['heading'] = "Rejected/Cancelled";
            $data['order_type'] = 1;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function rejected_order()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 1);
            $this->db->order_by('id', 'desc');
            $this->db->where('order_status', 6); //rejected orders
            $this->db->where('is_admin', 0); //vendor orders
            
            $order1_data = $this->db->get();
            $count=0;
            foreach ($order1_data->result() as $datas) {
                $this->db->select('*');
                $this->db->from('tbl_payment_txn');
                $this->db->where('req_id',$datas->id);
                $this->db->where('vendor_id	',$datas->vendor_id);
                $dsa_ptx= $this->db->get()->row();
               if(!empty($dsa_ptx->cr)){
                $count=$count+$datas->total_amount-$dsa_ptx->cr;
               }

            }
            $data['count']=$count;


            $data['order1_data']=$order1_data; 
            $data['heading'] = "Rejected";
            $data['order_type'] = 1;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
}
