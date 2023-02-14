<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class FeedController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }
    //====================================================== CalculateWeight================================================//
    public function CalculateWeight()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
            $this->form_validation->set_rules('grith', 'grith', 'required|xss_clean|trim');
            $this->form_validation->set_rules('length', 'length', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $type = $this->input->post('type');
                $grith = $this->input->post('grith');
                $length = $this->input->post('length');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    if ($type == 'Inches') {
                        $weight = ($grith * $grith * $length) / 660 + 0.5;
                    } else {
                        $weight = ($grith * $grith * $length) / 10797 + 0.5;
                    }
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $weight
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
    //====================================================== DMI CALCULATOR================================================//
    public function dmi_calculator()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('feed_percentage', 'feed_percentage', 'required|xss_clean|trim');
            $this->form_validation->set_rules('milk_yield', 'milk_yield', 'required|xss_clean|trim');
            $this->form_validation->set_rules('weight', 'weight', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $feed_percentage = $this->input->post('feed_percentage');
                $milk_yield = $this->input->post('milk_yield');
                $weight = $this->input->post('weight');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $dry_matter_intake = 33/100*$milk_yield + 2/100*$weight;
                    $feed = $feed_percentage / 100 * $dry_matter_intake;
                    $fodder = $dry_matter_intake - $feed;
                    $feed_qty = 100 / 90 * $feed;
                    //---green fodder ------
                    $green_fodder = 60 / 100 * $fodder;
                    $maize = 100 / 22 * $green_fodder;
                    $barseem = 100 / 17 * $green_fodder;
                    //--- dry fodder ------
                    $dry_fodder = 40 / 100 * $fodder;
                    $hary = 100 / 95 * $dry_fodder;
                    //---silage ------
                    $silage_dm = $fodder;
                    $silage = 100 / 30 * $silage_dm;
                    $data = [];
                    $data = array(
                        'dry_matter_intake' => round($dry_matter_intake,2),
                        'feed' => round($feed,2),
                        'fodder' => round($fodder,2),
                        'feed_qty' => round($feed_qty,2),
                        'green_fodder' => round($green_fodder,2),
                        'maize' => round($maize,2),
                        'barseem' => round($barseem,2),
                        'dry_fodder' => round($dry_fodder,2),
                        'hary' => round($hary,2),
                        'silage_dm' => round($silage_dm,2),
                        'silage' => round($silage,2),
                    );
                    $res = array(
                        'message' => "Success!",
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
    //====================================================== DAIRY MART ================================================//
    public function dairy_mart()
    {
        $City_data = $this->db->get_where('tbl_products', array('is_active' => 1))->result();
        $data = [];
        foreach ($City_data as $API) {
            if (!empty($API->image)) {
                $image = base_url() . $API->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name_english' => $API->name_english,
                'name_hindi' => $API->name_hindi,
                'name_punjabi' => $API->name_punjabi,
                'description_english' => $API->description_english,
                'description_hindi' => $API->description_hindi,
                'description_punjabi' => $API->description_punjabi,
                'image1' => $API->image1,
                'image2' => $API->image2,
                'mrp' => $API->mrp,
                'selling_price' => $API->selling_price,
                'inventory' => $API->inventory
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== DOCTOR ON CALL================================================//
    public function doctor_on_call()
    {
        $City_data = $this->db->get_where('tbl_doctor', array('is_active2' => 0))->result();
        $data = [];
        foreach ($City_data as $DOCTOR) {
            if (!empty($DOCTOR->image)) {
                $image = base_url() . $DOCTOR->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name_english' => $DOCTOR->name_english,
                'name_hindi' => $DOCTOR->name_hindi,
                'name_punjabi' => $DOCTOR->name_punjabi,
                'email' => $DOCTOR->email,
                'degree_english' => $DOCTOR->degree_english,
                'degree_hindi' => $DOCTOR->degree_hindi,
                'degree_punjabi' => $DOCTOR->degree_punjabi,
                'image' => $DOCTOR->image
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== EXPERT ADVICE ================================================//
    public function expert_advice()
    {
        $Expert_data = $this->db->get_where('tbl_doctor', array('is_active2' => 1))->result();
        $data = [];
        foreach ($Expert_data as $Expert) {
            if (!empty($Expert->image)) {
                $image = base_url() . $Expert->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name_english' => $Expert->name_english,
                'name_hindi' => $Expert->name_hindi,
                'name_punjabi' => $Expert->name_punjabi,
                'email' => $Expert->email,
                'type' => $Expert->type,
                'degree_english' => $Expert->degree_english,
                'degree_hindi' => $Expert->degree_hindi,
                'degree_punjabi' => $Expert->degree_punjabi,
                'education_qualification' => $Expert->education_qualification,
                'city' => $Expert->city,
                'state' => $Expert->state,
                'phone_number' => $Expert->phone_number,
                'image' => $Expert->image
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== RADIUS VENDOR================================================//
    public function radius_vendor()
    {
        $Vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 0))->result();
        $data = [];
        foreach ($Vendor_data as $Vendor) {
            $data[] = array(
                'name_english' => $Vendor->name_english,
                'name_hindi' => $Vendor->name_hindi,
                'name_punjabi' => $Vendor->name_punjabi,
                'shop_name_english' => $Vendor->shop_name_english,
                'shop_name_hindi' => $Vendor->shop_name_hindi,
                'shop_name_punjabi' => $Vendor->shop_name_punjabi,
                'address_english' => $Vendor->address_english,
                'address_hindi' => $Vendor->address_hindi,
                'address_punjabi' => $Vendor->address_punjabi,
                'district_english' => $Vendor->district_english,
                'district_hindi' => $Vendor->district_hindi,
                'district_punjabi' => $Vendor->district_punjabi,
                'city' => $Vendor->city,
                'state' => $Vendor->state,
                'pincode' => $Vendor->pincode
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
  //====================================================== END FEEDCONTROLLER================================================//
