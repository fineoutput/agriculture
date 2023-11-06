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
    //========================================= get_group ===================================//
    public function get_group()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $group_data = $this->db->get_where('tbl_group', array('is_active' => 1, 'farmer_id' => $farmer_data[0]->id))->result();
            $total = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id))->num_rows();
            $data = [];
            $i = 1;
            foreach ($group_data as $a) {
                $animal_count = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'assign_to_group' => $a->id))->num_rows();
                $data[] = array(
                    's_no' => $i,
                    'value' => $a->id,
                    'label' => $a->name,
                    'animal_count' => $animal_count,
                );
                $i++;
            }
            $res = array(
                'message' => "Success",
                'status' => 200,
                'data' => $data,
                'total' => $total,
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
    //========================================= get_cattle ===================================//
    public function get_cattle()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('assign_to_group', 'assign_to_group', 'required|xss_clean|trim');
            $this->form_validation->set_rules('milking', 'milking', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $assign_to_group = $this->input->post('assign_to_group');
                $milking = $this->input->post('milking');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $this->db->distinct();
                    $this->db->select('animal_type');
                    $this->db->where('farmer_id', $farmer_data[0]->id);
                    $this->db->where('assign_to_group', $assign_to_group);
                    if (!empty($milking)) {
                        $this->db->where('animal_type', 'Milking');
                    }
                    $query = $this->db->get('tbl_my_animal');
                    $data = [];
                    $i = 1;
                    foreach ($query->result() as $a) {
                        $data[] = array(
                            'value' => $a->animal_type,
                            'label' => $a->animal_type,
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
    //========================================= get_tag_no ===================================//
    public function get_tag_no()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
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
                            'value' => $a->tag_no,
                            'label' => $a->tag_no,
                        );
                        $i++;
                    }
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
    //========================================= get_bull_tag_no ===================================//
    public function get_bull_tag_no()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $tag_data = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'animal_type' => 'Bull'))->result();
            $data = [];
            $i = 1;
            foreach ($tag_data as $a) {
                $data[] = array(
                    'value' => $a->tag_no,
                    'label' => $a->tag_no,
                );
                $i++;
            }
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
    }
    public function get_semen_bulls()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $tag_data = $this->db->get_where('tbl_canister', array('farmer_id' => $farmer_data[0]->id, 'farm_bull' => 'No'))->result();
            $data = [];
            $i = 1;
            foreach ($tag_data as $a) {
                $data[] = array(
                    'value' => $a->id,
                    'label' => $a->bull_name,
                );
                $i++;
            }
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
    }
    //========================================= get_animal_data ===================================//
    public function get_animal_data()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('tag_no', 'tag_no', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $tag_no = $this->input->post('tag_no');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $animal_data = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'tag_no' => $tag_no))->result();
                    $data = [];
                    $i = 1;
                    foreach ($animal_data as $a) {
                        $data = array(
                            'id' => $a->id,
                            'tag_no' => $a->tag_no,
                            'animal_name' => $a->animal_name,
                            'animal_type' => $a->animal_type,
                            'breed_type' => $a->breed_type,
                            'dob' => $a->dob,
                            'animal_gender' => $a->animal_gender,
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
    //====================================================== SUBSCRIPTION PLAN================================================//
    public function subscription_plan()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $Subscription_data = $this->db->get_where('tbl_subscription', array('is_active' => 1))->result();
            date_default_timezone_set("Asia/Calcutta");
            $cur_date = date("Y-m-d");
            $Subscribed = $this->db->order_by('id', 'desc')->get_where('tbl_subscription_buy', array('farmer_id' => $farmer_data[0]->id, 'expiry_date >=' => $cur_date))->result();
            $data = [];
            foreach ($Subscription_data as $a) {
                $active = 0;
                $plan_details = [];
                if (!empty($Subscribed) && $Subscribed[0]->plan_id == $a->id) {
                    $active = 1;
                    $newdate = new DateTime($Subscribed[0]->expiry_date);
                    $plan_details = array('months' => $Subscribed[0]->months, 'price' => $Subscribed[0]->price, 'expiry_date' => $newdate->format('d-m-y'));
                } else if (!empty($Subscribed)) {
                    $active = 2;
                }
                $data[] = array(
                    'id' => $a->id,
                    'service_name' => $a->service_name,
                    'monthly_price' => $a->monthly_price,
                    'monthly_description' => $a->monthly_description,
                    'monthly_service' => $a->monthly_service,
                    'quarterly_price' => $a->quarterly_price,
                    'quarterly_description' => $a->quarterly_description,
                    'quarterly_service' => $a->quarterly_service,
                    'halfyearly_price' => $a->halfyearly_price,
                    'halfyearly_description' => $a->halfyearly_description,
                    'halfyearly_service' => $a->halfyearly_service,
                    'yearly_price' => $a->yearly_price,
                    'yearly_description' => $a->yearly_description,
                    'yearly_service' => $a->yearly_service,
                    'animals' => $a->animals,
                    'doctor_calls' => $a->doctor_calls,
                    'active' => $active,
                    'plan_details' => $plan_details,
                );
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
    //=======================================================HomeData===============================================//
    public function HomeData()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists("Fcm_token", $headers)) {
            $fcm_token = $headers['Fcm_token'];
        } else {
            $fcm_token = '';
        }
        if (array_key_exists("Lang", $headers)) {
            $language = $headers['Lang'];
        } else {
            $language = 'en';
        }
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            //update fcm_token
            if (!empty($fcm_token) && $fcm_token !=  $farmer_data[0]->fcm_token) {
                $data_updatev = array(
                    'fcm_token' => $fcm_token,
                );
                $this->db->where('id', $farmer_data[0]->id);
                $zapakv = $this->db->update('tbl_farmers', $data_updatev);
            }
            //---- slider data -------
            $Slider_data = $this->db->get_where('tbl_slider', array('is_active' => 1))->result();
            $data = [];
            $slider = [];
            foreach ($Slider_data as $slide) {
                if (!empty($slide->image)) {
                    $image = base_url() . $slide->image;
                } else {
                    $image = '';
                }
                $slider[] = $image;
            }
            //---- Farmerslider2 data -------
            $FarmerSlider_data = $this->db->get_where('tbl_farmersliderslider', array('is_active' => 1))->result();
            $Famerslider = [];
            foreach ($FarmerSlider_data as $farmerslide) {
                if (!empty($farmerslide->image)) {
                    $image2 = base_url() . $farmerslide->image;
                } else {
                    $image2 = '';
                }
                $Famerslider[] = array('image' => $image2);
            }
            //---- Categoryslider data -------
            $CategorySlider_data = $this->db->get_where('tbl_category_images', array('is_active' => 1))->result();
            $CategoryData = [];
            foreach ($CategorySlider_data as $category) {
                $subCategoryData = [];
                $subCategoryDatas = $this->db->get_where('tbl_subcategory_images', array('is_active' => 1, 'category_id' => $category->id))->result();
                foreach ($subCategoryDatas as $subcategory) {
                    if ($language == 'en') {
                        $cat_image =  $category->image ? base_url() . $category->image : '';
                        $sub_image =  $subcategory->image ? base_url() . $subcategory->image : '';
                    } elseif ($language == 'hi') {
                        $cat_image =  $category->image_hindi ? base_url() . $category->image_hindi : '';
                        $sub_image =  $subcategory->image_hindi ? base_url() . $subcategory->image_hindi : '';
                    } else {
                        $cat_image =  $category->image_punjabi ? base_url() . $category->image_punjabi : '';
                        $sub_image =  $subcategory->image_punjabi ? base_url() . $subcategory->image_punjabi : '';
                    }
                    $subCategoryData[] = array(
                        'id' => $subcategory->id,
                        'name' => $subcategory->name,
                        'image' => $sub_image
                    );
                }
                $CategoryData[] = array(
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $cat_image,
                    'subcatgory' => $subCategoryData,
                );
            }
            //tranding products
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('tranding_products', 1);
            $this->db->where('is_active', 1);
            $this->db->where('is_admin', 1);
            $data_products = $this->db->get();
            $product_data = [];
            foreach ($data_products->result() as $pro) {
                if (!empty($pro->image)) {
                    $image = base_url() . $pro->image;
                } else {
                    $image = '';
                }
                if ($pro->inventory != 0) {
                    $stock = 'In Stock';
                } else {
                    $stock = 'Out of Stock';
                }
                $discount = (int)$pro->mrp - (int)$pro->selling_price;
                $percent = 0;
                if ($discount > 0) {
                    $percent = round($discount / $pro->mrp * 100);
                }
                if ($language == 'en') {
                    $product_data[] = array(
                        'pro_id' => $pro->id,
                        'name' => $pro->name_english,
                        'description' => $pro->description_english,
                        'image' => $image,
                        'mrp' => $pro->mrp,
                        'min_qty' => $pro->min_qty ? $pro->min_qty : 1,
                        'selling_price' => $pro->selling_price,
                        'suffix' => $pro->suffix,
                        'stock' => $stock,
                        'percent' => $percent,
                        'vendor_id' => $pro->added_by,
                        'is_admin' => $pro->is_admin,
                        'offer' => $pro->offer,
                    );
                } elseif ($language == 'en') {
                    $product_data[] = array(
                        'pro_id' => $pro->id,
                        'name' => $pro->name_hindi,
                        'description' => $pro->description_hindi,
                        'image' => $image,
                        'mrp' => $pro->mrp,
                        'selling_price' => $pro->selling_price,
                        'suffix' => $pro->suffix,
                        'stock' => $stock,
                        'percent' => $percent,
                        'vendor_id' => $pro->added_by,
                        'is_admin' => $pro->is_admin,
                        'offer' => $pro->offer,
                    );
                } else {
                    $product_data[] = array(
                        'pro_id' => $pro->id,
                        'name' => $pro->name_punjabi,
                        'description' => $pro->description_punjabi,
                        'image' => $image,
                        'mrp' => $pro->mrp,
                        'selling_price' => $pro->selling_price,
                        'suffix' => $pro->suffix,
                        'stock' => $stock,
                        'percent' => $percent,
                        'vendor_id' => $pro->added_by,
                        'is_admin' => $pro->is_admin,
                        'offer' => $pro->offer,
                    );
                }
            }
            //---- Cart Count -------
            $CartCount = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
            //---- farmer notification data -------
            $farmer_nft = [];
            $farmernotification_datas = $this->db->get_where('tbl_farmer_notification', array('farmer_id' => $farmer_data[0]->id))->result();
            foreach ($farmernotification_datas as $farmernotification_data) {
                $newDate = new DateTime($farmernotification_data->date);
                $farmer_nft[] = array(
                    'id' => $farmernotification_data->id,
                    'name' => $farmernotification_data->name,
                    'image' => $farmernotification_data->image ? base_url() . $farmernotification_data->image : '',
                    'description' => $farmernotification_data->dsc,
                    'date' => $newDate->format('d-m-y, g:i a'),
                );
            }
            $this->db->select('*');
            $this->db->from('tbl_farmer_notification');
            $this->db->where('farmer_id', $farmer_data[0]->id);
            $count_farmer = $this->db->count_all_results();
            $feedCheck = $this->db->get_where('tbl_check_my_feed_buy', array('payment_status' => 1, 'farmer_id' => $farmer_data[0]->id))->row();
            if (!empty($feedCheck)) {
                $feedBuy = 1;
            } else {
                $feedBuy = 0;
            }
            $feedAmount = FEED_AMOUNT;
            $data =  array(
                'slider' => $slider, 'Farmer_slider' => $Famerslider, 'Category_Data' => $CategoryData, 'product_data' => $product_data, 'notification_data' => $farmer_nft,
                'notification_count' => $count_farmer, 'CartCount' => $CartCount, 'feedBuy' => $feedBuy, 'feedAmount' => $feedAmount
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
    }
    public function get_state()
    {
        $state_data = $this->db->get_where('all_states')->result();
        $data = [];
        foreach ($state_data as $state) {
            $data[] = array(
                'value' => $state->id,
                'label' => $state->state_name,
            );
        }
        $res = array(
            'message' => "Success!",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== buyPlan ================================================//
    public function buyPlan()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('plan_id', 'plan_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
            $this->form_validation->set_rules('months', 'months', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $plan_id = $this->input->post('plan_id');
                $type = $this->input->post('type');
                $months = $this->input->post('months');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $data = [];
                    $plan_data = $this->db->get_where('tbl_subscription', array('is_active' => 1, 'id' => $plan_id))->result();
                    if (!empty($plan_data)) {
                        date_default_timezone_set("Asia/Calcutta");
                        $cur_date = date("Y-m-d H:i:s");
                        $start_date = date("Y-m-d");
                        $expiry_date = date('Y-m-d', strtotime("+" . $months . " month"));
                        $txn_id = mt_rand(999999, 999999999999);
                        $data = array(
                            'farmer_id' => $farmer_data[0]->id,
                            'plan_id' => $plan_id,
                            'months' => $months,
                            'price' => $plan_data[0]->$type,
                            'animals' => $plan_data[0]->animals,
                            'doctor_calls' => $plan_data[0]->doctor_calls,
                            'start_date' => $start_date,
                            'expiry_date' => $expiry_date,
                            'payment_status' => 0,
                            'txn_id' => $txn_id,
                            'date' => $cur_date,
                            'gateway' => 'CC Avenue',
                        );
                        $req_id = $this->base_model->insert_table("tbl_subscription_buy", $data, 1);
                        $success = base_url() . 'ApiControllers/HomeController/plan_payment_success';
                        $fail = base_url() . 'ApiControllers/FarmerController/payment_failed';
                        $post = array(
                            'txn_id' => '',
                            'merchant_id' => MERCHAND_ID,
                            'order_id' => $txn_id,
                            'amount' => $plan_data[0]->$type,
                            'currency' => "INR",
                            'redirect_url' => $success,
                            'cancel_url' => $fail,
                            'billing_name' => $farmer_data[0]->name,
                            'billing_address' => $farmer_data[0]->village,
                            'billing_city' => $farmer_data[0]->city,
                            'billing_state' => $farmer_data[0]->state,
                            'billing_zip' => $farmer_data[0]->pincode,
                            'billing_country' => 'India',
                            'billing_tel' => $farmer_data[0]->phone,
                            'billing_email' => '',
                            'merchant_param1' => 'Plan Payment',
                        );
                        $merchant_data = '';
                        $working_key = WORKING_KEY; //Shared by CCAVENUES
                        $access_code = ACCESS_CODE; //Shared by CCAVENUES
                        foreach ($post as $key => $value) {
                            $merchant_data .= $key . '=' . $value . '&';
                        }
                        $length = strlen(md5($working_key));
                        $binString = "";
                        $count = 0;
                        while ($count < $length) {
                            $subString = substr(md5($working_key), $count, 2);
                            $packedString = pack("H*", $subString);
                            if ($count == 0) {
                                $binString = $packedString;
                            } else {
                                $binString .= $packedString;
                            }
                            $count += 2;
                        }
                        $key = $binString;
                        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
                        $openMode = openssl_encrypt($merchant_data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
                        $encrypted_data = bin2hex($openMode);
                        $send = array(
                            'order_id' => $req_id,
                            'access_code' => $access_code,
                            'redirect_url' => $success,
                            'cancel_url' => $fail,
                            'enc_val' => $encrypted_data,
                            'plain' => $merchant_data,
                            'merchant_param1' => 'Plan Payment',
                        );
                        $res = array(
                            'message' => "Success!",
                            'status' => 200,
                            'data' => $send,
                        );
                        echo json_encode($res);
                    } else {
                        $res = array(
                            'message' => 'Some error occurred!',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
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
    public function phone_pe_buyPlan()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('plan_id', 'plan_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
            $this->form_validation->set_rules('months', 'months', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $plan_id = $this->input->post('plan_id');
                $type = $this->input->post('type');
                $months = $this->input->post('months');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $data = [];
                    $plan_data = $this->db->get_where('tbl_subscription', array('is_active' => 1, 'id' => $plan_id))->result();
                    if (!empty($plan_data)) {
                        date_default_timezone_set("Asia/Calcutta");
                        $cur_date = date("Y-m-d H:i:s");
                        $start_date = date("Y-m-d");
                        $expiry_date = date('Y-m-d', strtotime("+" . $months . " month"));
                        $txn_id = bin2hex(random_bytes(12));
                        $data = array(
                            'farmer_id' => $farmer_data[0]->id,
                            'plan_id' => $plan_id,
                            'months' => $months,
                            'price' => $plan_data[0]->$type,
                            'animals' => $plan_data[0]->animals,
                            'doctor_calls' => $plan_data[0]->doctor_calls,
                            'start_date' => $start_date,
                            'expiry_date' => $expiry_date,
                            'payment_status' => 0,
                            'txn_id' => $txn_id,
                            'date' => $cur_date,
                            'gateway' => 'Phone Pe',
                        );
                        $req_id = $this->base_model->insert_table("tbl_subscription_buy", $data, 1);
                        $success = base_url() . 'ApiControllers/HomeController/phone_pe_plan_payment_success';
                        $param1 = 'Plan Payment';
                        $response = $this->initiate_phone_pe_payment($txn_id, $plan_data[0]->$type, $farmer_data[0]->phone, $success, $param1);
                        if ($response && $response->code == 'PAYMENT_INITIATED') {
                            $send = array(
                                'url' => $response->data->instrumentResponse->redirectInfo->url,
                                'redirect_url' => $success,
                                'merchant_param1' => $param1,
                                'order_id' => $req_id,
                            );
                            $res = array(
                                'message' => "Success!",
                                'status' => 200,
                                'data' => $send,
                            );
                            echo json_encode($res);
                        } else {
                            $res = array(
                                'message' => 'Some error occurred!',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        $res = array(
                            'message' => 'Some error occurred!',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
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
    public function plan_payment_success()
    {
        $encResponse = $this->input->post('encResp'); //This is the response sent by the CCAvenue Server
        log_message('error', $encResponse);
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        error_reporting(0);
        $workingKey = WORKING_KEY;        //Working Key should be provided here.
        $rcvdString = $this->decrypt($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $order_id = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3)    $order_status = $information[1];
            if ($i == 0) $txn_id = $information[1];
        }
        $data_insert = array(
            'body' => json_encode($decryptValues),
            'date' => $cur_date
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
        // echo $order_status;die();
        if ($order_status === "Success") {
            $this->db->select('*');
            $this->db->from('tbl_subscription_buy');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $txn_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                $order_id = $order_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_subscription_buy', $data_update);
                echo 'Success';
                exit;
            }
        } else if ($order_status === "Failure") {
            echo 'Failure';
            exit;
        } else {
            echo 'Aborted';
        }
    }
    public function phone_pe_plan_payment_success()
    {
        $body = $_POST;
        // Takes raw data from the request
        date_default_timezone_set("Asia/Calcutta");
        $ip = $this->input->ip_address();
        $cur_date = date("Y-m-d H:i:s");
        // Converts it into a PHP object
        $data = json_encode($body);
        $data_insert = array(
            'body' => $data,
            'date' => $cur_date,
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");

        $response = $this->verify_phone_pe_payment($body);
        if ($response->code == 'PAYMENT_SUCCESS') {
            $txn_id = $response->data->merchantTransactionId;
            $this->db->select('*');
            $this->db->from('tbl_subscription_buy');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $txn_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                $order_id = $order_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($body),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_subscription_buy', $data_update);
                echo 'Success';
                exit;
            }
        } else {
            echo $response->code;
        }
    }
    public function feed_payment_success()
    {
        $encResponse = $this->input->post('encResp'); //This is the response sent by the CCAvenue Server
        log_message('error', $encResponse);
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        error_reporting(0);
        $workingKey = WORKING_KEY;        //Working Key should be provided here.
        $rcvdString = $this->decrypt($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $order_id = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3)    $order_status = $information[1];
            if ($i == 0) $txn_id = $information[1];
        }
        $data_insert = array(
            'body' => json_encode($decryptValues),
            'date' => $cur_date
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
        // echo $order_status;die();
        if ($order_status === "Success") {
            $this->db->select('*');
            $this->db->from('tbl_check_my_feed_buy');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $txn_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                $order_id = $order_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_check_my_feed_buy', $data_update);
                echo 'Success';
                exit;
            }
        } else if ($order_status === "Failure") {
            echo 'Failure';
            exit;
        } else {
            echo 'Aborted';
        }
    }
    public function phone_pe_feed_payment_success()
    {
        $body = $_POST;
        // Takes raw data from the request
        date_default_timezone_set("Asia/Calcutta");
        $ip = $this->input->ip_address();
        $cur_date = date("Y-m-d H:i:s");
        // Converts it into a PHP object
        $data = json_encode($body);
        $data_insert = array(
            'body' => $data,
            'date' => $cur_date,
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");

        $response = $this->verify_phone_pe_payment($body);
        if ($response->code == 'PAYMENT_SUCCESS') {
            $txn_id = $response->data->merchantTransactionId;
            $this->db->select('*');
            $this->db->from('tbl_check_my_feed_buy');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $txn_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                $order_id = $order_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($body),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_check_my_feed_buy', $data_update);
                echo 'Success';
                exit;
            }
        } else {
            echo $response->code;
        }
    }
    public function VerifyPlanPayment($order_id)
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $req_data = $this->db->get_where('tbl_subscription_buy', array('id' => $order_id, 'farmer_id' => $farmer_data[0]->id, 'payment_status' => 1))->result();
            if (!empty($req_data)) {
                $send = array(
                    'order_id' => $req_data[0]->id,
                    'amount' => $req_data[0]->price,
                );
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => $send,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => 'Please Check Manually!',
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Permission Denied!',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function VerifyFeedPayment($order_id)
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $req_data = $this->db->get_where('tbl_check_my_feed_buy', array('id' => $order_id, 'farmer_id' => $farmer_data[0]->id, 'payment_status' => 1))->result();
            if (!empty($req_data)) {
                $send = array(
                    'order_id' => $req_data[0]->id,
                    'amount' => $req_data[0]->price,
                );
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => $send,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => 'Please Check Manually!',
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Permission Denied!',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function encrypt($plainText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }
    public function decrypt($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }
    public function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }
            $count += 2;
        }
        return $binString;
    }
    //========================================= get__milking_tag_no ===================================//
    public function get_milking_tag_no()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('assign_to_group', 'assign_to_group', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $assign_to_group = $this->input->post('assign_to_group');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $tag_data = $this->db->get_where('tbl_my_animal', array('farmer_id' => $farmer_data[0]->id, 'assign_to_group' => $assign_to_group, 'animal_type' => 'Milking'))->result();
                    $data = [];
                    $i = 1;
                    foreach ($tag_data as $a) {
                        $data[] = array(
                            'value' => $a->tag_no,
                            'label' => $a->tag_no,
                        );
                        $i++;
                    }
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
    public function update_group()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
            if (!empty($farmer_data)) {
                if ($this->form_validation->run() == true) {
                    $id = $this->input->post('id');
                    $name = $this->input->post('name');
                    $data_update = array(
                        'name' => $name
                    );
                    $this->db->where('id', $id);
                    $zapak = $this->db->update('tbl_group', $data_update);
                    if ($zapak > 0) {
                        $res = array(
                            'message' => "Record Successfully Updated!",
                            'status' => 200,
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
                    'message' => 'Permission Denied!',
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
    public function delete_group()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
            $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
            if (!empty($farmer_data)) {
                if ($this->form_validation->run() == true) {
                    $id = $this->input->post('id');
                    $delete = $this->db->delete('tbl_group', array('id' => $id, 'farmer_id' => $farmer_data[0]->id));
                    $this->db->select('*');
                    $this->db->from('tbl_my_animal');
                    $this->db->where('assign_to_group', $id);
                    $data_animl = $this->db->get();
                    foreach ($data_animl->result() as $data_animls) {
                        $animl_id = $data_animls->id;
                        $tag_no = $data_animls->tag_no;
                        $animal_del = $this->db->delete('tbl_my_animal', array('id' => $animl_id));
                        $animal_cyc = $this->db->delete('tbl_animal_cycle', array('animal_id' => $animl_id));
                        //$animal_cns=$this->db->delete('tbl_canister', array('tag_no' => $tag_no));
                        $data_update = array(
                            'farm_bull' => '',
                            'bull_name' => '',
                            'company_name' => '',
                            'no_of_units' => '',
                            'milk_production_of_mother' => '',
                            'date' => ''
                        );
                        $this->db->where('tag_no', $tag_no);
                        $zapak = $this->db->update('tbl_canister', $data_update);
                    }
                    $animal_brd = $this->db->delete('tbl_breeding_record', array('group_id' => $id));
                    $animal_hlt = $this->db->delete('tbl_health_info', array('group_id' => $id));
                    $animal_mlkr = $this->db->delete('tbl_milk_records', array('group_id' => $id));
                    if ($delete > 0) {
                        $res = array(
                            'message' => "Record Successfully Deleted!",
                            'status' => 200,
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
                    'message' => 'Permission Denied!',
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
    // ====================== START PHONE PE INITIATE PAYMENT ==================================
    public function initiate_phone_pe_payment($txn_id, $amount, $phone, $redirect_url, $param1 = '')
    {
        $payload = array(
            "merchantId" => PHONE_PE_MERCHANT_ID,
            "merchantTransactionId" => $txn_id,
            "merchantUserId" => "MUID123",
            'amount' => $amount * 100,
            "redirectUrl" => $redirect_url,
            "callbackUrl" => $redirect_url,
            "mobileNumber" => $phone,
            "redirectMode" => "POST",
        );
        $url = PHONE_PE_URL . '/pg/v1/pay';
        $json = json_encode($payload);
        $payload = json_decode($json);
        $payload->paymentInstrument = new stdClass();
        $payload->paymentInstrument->type = "PAY_PAGE";

        // print_r($payload);die();
        $jsonPayload = json_encode($payload);
        $encode_jsonPayload = base64_encode($jsonPayload);
        $verifyHeader = hash('sha256', $encode_jsonPayload . '/pg/v1/pay' . PHONE_PE_SALT) . '###' . PHONE_PE_SALT_INDEX;
        $request_json = new stdClass();
        $request_json->request = $encode_jsonPayload;
        // Set up cURL
        $ch = curl_init();
        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-VERIFY: ' . $verifyHeader,
        ]);

        // Execute the cURL request and store the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        // Close the cURL session
        curl_close($ch);

        // Print the response

        return json_decode($response);
    }
    // ====================== START PHONE PE INITIATE PAYMENT ==================================
    public function verify_phone_pe_payment($body)
    {

        if ($body['code'] == 'PAYMENT_SUCCESS') {
            $url = PHONE_PE_URL . '/pg/v1/status/' . PHONE_PE_MERCHANT_ID . '/' . $body['transactionId'] . '';
            $verifyHeader = hash('sha256', '/pg/v1/status/' . PHONE_PE_MERCHANT_ID . '/' . $body['transactionId'] . PHONE_PE_SALT) . '###' . PHONE_PE_SALT_INDEX;
            $ch = curl_init();
            // Set the cURL options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-VERIFY: ' . $verifyHeader,
                'X-MERCHANT-ID: ' . PHONE_PE_MERCHANT_ID,
            ]);

            // Execute the cURL request and store the response
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                echo 'cURL Error: ' . curl_error($ch);
            }

            // Close the cURL session
            curl_close($ch);

            // Print the response
            // echo $response;
            return json_decode($response);
            // $res = json_decode($response);
            // return $res->code;
            // if ($res->code == 'PAYMENT_SUCCESS') {
            //    return $res->code;
            // } else {
            //     // redirect('web/checkout');
            // }
        }
    }
}
  //======================================================END HOMECONTROLLER================================================//
