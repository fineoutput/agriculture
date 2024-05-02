<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Admin_orders extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }
     //==============================all_order=========================\\
     public function all_order()
     {
         if (!empty($this->session->userdata('admin_data'))) {
             $data['user_name'] = $this->load->get_var('user_name');
             $this->db->select('*');
             $this->db->from('tbl_order1');
             $this->db->where('payment_status', 1);
             $this->db->order_by('id', 'desc');
            
             $this->db->where('is_admin', 1); //admin orders
             $data['order1_data'] = $this->db->get();
             $data['heading'] = "New";
             $data['order_type'] = 1;
             $this->load->view('admin/common/header_view', $data);
             $this->load->view('admin/order/view_order');
             $this->load->view('admin/common/footer_view');
         } else {
             redirect("login/admin_login", "refresh");
         }
     }
    //==============================new_order=========================\\
    public function new_order()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where_in('payment_status', array(1, 2));
            $this->db->order_by('id', 'desc');
            $this->db->where('order_status', 1); //new orders
            $this->db->where('is_admin', 1); //admin orders
            $data['order1_data'] = $this->db->get();
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
            $this->db->where('payment_status', 1);
            $this->db->order_by('id', 'desc');
            $this->db->where('order_status', 2); //accepted orders
            $this->db->where('is_admin', 1); //admin orders
            $data['order1_data'] = $this->db->get();
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
            $this->db->where('is_admin', 1); //admin orders
            $this->db->where('order_status', 3); //dispatched_orders
            $data['order1_data'] = $this->db->get();
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
            $this->db->where('order_status', 4); //delievered orders
            $this->db->where('is_admin', 1); //admin orders
            $data['order1_data'] = $this->db->get();
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
            $this->db->where('is_admin', 1); //admin orders
            $data['order1_data'] = $this->db->get();
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
            $this->db->where('is_admin', 1); //admin orders
            $data['order1_data'] = $this->db->get();
            $data['heading'] = "Rejected";
            $data['order_type'] = 1;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //==============================update_order_status========================\\
    public function updateorderStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($t == "confirmed") {
                $data_update = array(
                    'order_status' => 2
                );
                $this->db->where('is_admin', 1); //admin orders
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occurred');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($t == "dispatched") {
                $data_update = array(
                    'order_status' => 3
                );
                $this->db->where('is_admin', 1); //admin orders
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occurred');
                    redirect($_SERVER['HTTP_REFERER']);

                }
            }
            if ($t == "completed") {
                $data_update = array(
                    'order_status' => 4
                );
                $this->db->where('is_admin', 1); //admin orders
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occurred');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($t == "reject") {
                $data_update = array('order_status' => 6);
                $this->db->where('is_admin', 1); //admin orders
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);
                //-------update inventory-------
                $this->db->select('*');
                $this->db->from('tbl_order2');
                $this->db->where('main_id', $id);
                $data_order2 = $this->db->get();
                foreach ($data_order2->result() as $data) {
                    $this->db->select('*');
                    $this->db->from('tbl_products');
                    $this->db->where('id', $data->product_id);
                    $pro_data = $this->db->get()->row();
                    if (!empty($pro_data)) {
                        $update_inv = $pro_data->inventory + $data->qty;
                        $data_update = array('inventory' => $update_inv);
                        $this->db->where('id', $pro_data->id);
                        $zapak2 = $this->db->update('tbl_products', $data_update);
                    }
                }
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error occurred";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    //==================================order_detail==========================\\
    public function order_detail($idd, $t = '')
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_order2');
            $this->db->where('main_id', $id);
            $data['order2_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('id', $id);
            $order1_data = $this->db->get()->row();
            $data['status'] = $order1_data->order_status;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/order_details');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //=================================view_bill=============================\\
    public function view_bill($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('id', $id);
            $data['order1_data'] = $this->db->get()->row();
            $this->db->select('*');
            $this->db->from('tbl_order2');
            $this->db->where('main_id', $id);
            $data['order2_data'] = $this->db->get();
            $this->load->view('admin/order/view_bill', $data);
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
}
