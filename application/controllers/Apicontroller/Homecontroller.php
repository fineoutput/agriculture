<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Homecontroller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }

  //====================================================== GROUPS================================================//

    public function Groups()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('create_group', 'create_group', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $create_group = $this->input->post('create_group');
                $data = [];
                $data = array(
                    'create_group' => $create_group
                );
                $last_id = $this->base_model->insert_table("tbl_group", $data, 1);
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => []
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'please insert data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== GET SLIDER================================================//

    public function get_slider()

    {
        $Slider_data = $this->db->get_where('tbl_slider', array('is_active' => 1))->result();
        $data = [];
        foreach ($Slider_data as $a) {
            if (!empty($a->image)) {
                $image = base_url() . $a->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'image' => $a->image
            );
        }
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== SUBSCRIPTION PLAN================================================//

    public function subscription_plan()

    {
        $Subscription_data = $this->db->get_where('tbl_subscription', array('is_active' => 1))->result();
        $data = [];
        foreach ($Subscription_data as $a) {
            if (!empty($a->image)) {
                $image = base_url() . $a->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name' => $a->name,
                'price' => $a->price
            );
        }
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }

    //=======================================================NOTIFICATIONS===============================================//
    public function notifications()

    {
        $notifications_data = $this->db->get_where('tbl_notification', array('is_active' => 1))->result();
        $data = [];
        foreach ($notifications_data as $notifications) {
            if (!empty($notifications->image)) {
                $image = base_url() . $notifications->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name' => $notifications->name,
                'dsc' => $notifications->dsc,
                'image' => $notifications->image
            );
        }
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
}
  //======================================================END HOMECONTROLLER================================================//
