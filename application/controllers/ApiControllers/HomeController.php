<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class HomeController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }
    //====================================================== GROUPS================================================//
    public function create_group()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $data = [];
                    $data = array(
                        'farmer_id' => $farmer_data[0]->id,
                        'name' => $name,
                        'ip' => $ip,
                        'is_active' => 1,
                        'date' => $cur_date
                    );
                    $last_id = $this->base_model->insert_table("tbl_group", $data, 1);
                    $res = array(
                        'message' => "Success",
                        'status' => 200,
                        'data' => []
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function get_group()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $group_data = $this->db->get_where('tbl_group', array('is_active' => 1, 'farmer_id' => $farmer_data[0]->id))->result();
            $data = [];
            $i = 1;
            foreach ($group_data as $a) {
                $data[] = array(
                    's_no' => $i,
                    'value' => $a->id,
                    'label' => $a->name,
                );
                $i++;
            }
            $res = array(
                'message' => "Success",
                'status' => 200,
                'data' => $data
            );
            echo json_encode($res);
        } else {
            $res = array(
                'message' => 'Permission Denied!',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function get_tag_no()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('assign_to_group', 'assign_to_group', 'required|xss_clean|trim');
            $this->form_validation->set_rules('animal_type', 'animal_type', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $assign_to_group = $this->input->post('assign_to_group');
                $animal_type = $this->input->post('animal_type');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $tag_data = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'assign_to_group' => $assign_to_group, 'animal_type' => $animal_type))->result();
                    $data = [];
                    $i = 1;
                    foreach ($tag_data as $a) {
                        $data[] = array(
                            'value' => $a->id,
                            'label' => $a->name,
                        );
                        $i++;
                    }
                    $res = array(
                        'message' => "Success",
                        'status' => 200,
                        'data' => $data
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
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
            'message' => "Success",
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
            'message' => "Success",
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
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
}
  //======================================================END HOMECONTROLLER================================================//
