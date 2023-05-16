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
    //=======================================================HomeData===============================================//
    public function HomeData()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists("Fcm_token", $headers)) {
            $fcm_token = $headers['Fcm_token'];
        } else {
            $fcm_token = '';
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
                $Famerslider[] = $image2;
            }
            //---- Categoryslider data -------
            $CategorySlider_data = $this->db->get_where('tbl_category_images', array('is_active' => 1))->result();
            $CategoryData = [];
            foreach ($CategorySlider_data as $category) {
                $subCategoryData = [];
                $subCategoryDatas = $this->db->get_where('tbl_subcategory_images', array('is_active' => 1, 'category_id' => $category->id))->result();
                foreach ($subCategoryDatas as $subcategory) {
                    $subCategoryData[] = array(
                        'id' => $subcategory->id,
                        'name' => $subcategory->name,
                        'image' => $subcategory->image ? base_url() . $subcategory->image : ''
                    );
                }
                $CategoryData[] = array(
                    'id' => $category->id,
                    'name' => $category->name,
                    'image' => $category->image ? base_url() . $category->image : '',
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
            $en_data = [];
            $hi_data = [];
            $pn_data = [];
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
                $en_data[] = array(
                    'pro_id' => $pro->id,
                    'name' => $pro->name_english,
                    'description' => $pro->description_english,
                    'image' => $image,
                    'mrp' => $pro->mrp,
                    'selling_price' => $pro->selling_price,
                    'suffix' => $pro->suffix,
                    'stock' => $stock,
                    'percent' => $percent,
                    'vendor_id' => $pro->added_by,
                    'is_admin' => $pro->is_admin
                );
                $hi_data[] = array(
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
                    'is_admin' => $pro->is_admin
                );
                $pn_data[] = array(
                    'pro_id' => $pro->id,
                    'name' => $pro->name_punjabi,
                    'description' => $pro->description_punjabi,
                    'image' => $image ,
                    'mrp' => $pro->mrp,
                    'selling_price' => $pro->selling_price,
                    'suffix' => $pro->suffix,
                    'stock' => $stock,
                    'percent' => $percent,
                    'vendor_id' => $pro->added_by,
                    'is_admin' => $pro->is_admin
                );
            }
            $product_data = array(
                'en' => $en_data,
                'hi' => $hi_data,
                'pn' => $pn_data,
            );
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
                    'image' => $farmernotification_data->image ? base_url() . $farmernotification_data->image:'',
                    'description' => $farmernotification_data->dsc,
                    'date' => $newDate->format('d-m-y, g:i a'),
                );
            }
            $this->db->select('*');
            $this->db->from('tbl_farmer_notification');
            $this->db->where('farmer_id', $farmer_data[0]->id);
            $count_farmer = $this->db->count_all_results();
            $data =  array(
                'slider' => $slider, 'Farmer_slider' => $Famerslider, 'Category_Data' => $CategoryData, 'product_data' => $product_data, 'notification_data' => $farmer_nft,
                'notification_count' => $count_farmer, 'CartCount' => $CartCount
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
}
  //======================================================END HOMECONTROLLER================================================//
