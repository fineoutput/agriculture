<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class ToolsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }
    //====================================================== SILAGE MAKING================================================//

    public function Silage_making()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('number_of_cows', 'number_of_cows', 'required|xss_clean|trim');
            $this->form_validation->set_rules('feeding', 'feeding', 'required|xss_clean|trim');
            $this->form_validation->set_rules('total_feeding_days', 'total_feeding_days', 'required|xss_clean|trim');
            $this->form_validation->set_rules('density', 'density', 'required|xss_clean|trim');
            $this->form_validation->set_rules('breadth', 'breadth', 'required|xss_clean|trim');
            $this->form_validation->set_rules('height', 'height', 'required|xss_clean|trim');
            $this->form_validation->set_rules('number_of_pits', 'number_of_pits', 'required|xss_clean|trim');
            $this->form_validation->set_rules('fodder_required', 'fodder_required', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $number_of_cows = $this->input->post('number_of_cows');
                $feeding = $this->input->post('feeding');
                $total_feeding_days = $this->input->post('total_feeding_days');
                $density = $this->input->post('density');
                $breadth = $this->input->post('breadth');
                $height = $this->input->post('height');
                $number_of_pits = $this->input->post('number_of_pits');
                $fodder_required = $this->input->post('fodder_required');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                $addedby = $this->session->userdata('admin_id');
                $data = [];
                $data = array('farmer_id' => $farmer_data[0]->id,
                    'number_of_cows' => $number_of_cows,
                    'feeding' => $feeding,
                    'total_feeding_days' => $total_feeding_days,
                    'density' => $density,
                    'breadth' => $breadth,
                    'height' => $height,
                    'number_of_pits' => $number_of_pits,
                    'fodder_required' => $fodder_required,
                    'ip' => $ip,
                    'added_by' => $addedby,
                    'is_active' => 1,
                    'date' => $cur_date
                );
                $last_id = $this->base_model->insert_table("tbl_silage_making", $data, 1);
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
  //====================================================== PREGNANCY CALCULATOR================================================//

    public function pregnancy_calculator()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('breeding_date', 'breeding_date', 'required|xss_clean|trim');
            $this->form_validation->set_rules('estrous_cycle_heat_detection', 'estrous_cycle_heat_detection', 'required|xss_clean|trim');
            $this->form_validation->set_rules('age_of_pregnancy', 'age_of_pregnancy', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $breeding_date = $this->input->post('breeding_date');
                $estrous_cycle_heat_detection = $this->input->post('estrous_cycle_heat_detection');
                $age_of_pregnancy = $this->input->post('age_of_pregnancy');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                $addedby = $this->session->userdata('admin_id');
                $data = [];
                $data = array('farmer_id' => $farmer_data[0]->id,
                    'breeding_date' => $breeding_date,
                    'estrous_cycle_heat_detection' => $estrous_cycle_heat_detection,
                    'age_of_pregnancy' => $age_of_pregnancy,
                    'ip' => $ip,
                    'added_by' => $addedby,
                    'is_active' => 1,
                    'date' => $cur_date
                );
                $last_id = $this->base_model->insert_table("tbl_pregnancy_calculator", $data, 1);
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
  //====================================================== END TOOLSCONTROLLER================================================//