<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Sale_purchase extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }

    public function view_salepurchase()
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $this->db->select('*');
            $this->db->from('tbl_sale_purchase');
            //$this->db->where('id',$usr);
            $data['sale_purchase'] = $this->db->get();




            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/sale_purchase/view_salepurchase');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }

    public function farmer_salepurchse_pending()
    {
        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $this->db->select('*');
            $this->db->from('tbl_sale_purchase');
            $this->db->where('status', 0);
            $data['sale_purchase'] = $this->db->get();
            $data['heading'] ='Pending Sale/Purchase List';




            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/sale_purchase/view_salepurchase');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }
    public function farmer_salepurchse_accepted()
    {
        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $this->db->select('*');
            $this->db->from('tbl_sale_purchase');
            $this->db->where('status', 1);
            $data['sale_purchase'] = $this->db->get();
            $data['heading'] ='Accepted Sale/Purchase List';



            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/sale_purchase/view_salepurchase');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }
    public function farmer_salepurchse_completed()
    {
        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $this->db->select('*');
            $this->db->from('tbl_sale_purchase');
            $this->db->where('status', 2);
            $data['sale_purchase'] = $this->db->get();
            $data['heading'] ='Completed Sale/Purchase List';




            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/sale_purchase/view_salepurchase');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }
    public function farmer_salepurchse_rejected()
    {
        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $this->db->select('*');
            $this->db->from('tbl_sale_purchase');
            $this->db->where('status', 3);
            $data['sale_purchase'] = $this->db->get();
            $data['heading'] ='Rejected Sale/Purchase List';




            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/sale_purchase/view_salepurchase');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }

    public function updatesalepurchaseStatus($idd, $t)
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');


            $id = base64_decode($idd);

            if ($t == "accept") {

                $data_update = array(
                    'status' => 1

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_sale_purchase', $data_update);

                if ($zapak != 0) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }

            if ($t == "reject") {

                $data_update = array(
                    'status' => 3

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_sale_purchase', $data_update);

                if ($zapak != 0) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t == "complete") {

                $data_update = array(
                    'status' => 2

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_sale_purchase', $data_update);

                if ($zapak != 0) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
        } else {

            $this->load->view('admin/login/index');
        }
    }
}
