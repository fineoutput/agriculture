<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class FarmerController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }
    //============================================= AddToCart ============================================//
    public function AddToCart()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('vendor_id', 'vendor_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('is_admin', 'is_admin', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $product_id = $this->input->post('product_id');
                $vendor_id = $this->input->post('vendor_id');
                $is_admin = $this->input->post('is_admin');
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                //----- Verify Auth --------
                if (!empty($farmer_data)) {
                    $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id, 'product_id' => $product_id, 'vendor_id' => $vendor_id, 'is_admin' => $is_admin))->result();
                    if (empty($CartData)) {
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $product_id))->result();
                        if (!empty($ProData)) {
                            //----- Check Inventory  --------
                            if ($ProData[0]->inventory > 0) {
                                $vendorData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id, 'vendor_id' => $vendor_id, 'is_admin' => $is_admin))->result();
                                //----- Empty cart if new vendor ----------
                                if (empty($vendorData)) {
                                    $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id,));
                                }
                                $data = array(
                                    'farmer_id' => $farmer_data[0]->id,
                                    'is_admin' => $is_admin,
                                    'vendor_id' => $vendor_id,
                                    'product_id' => $product_id,
                                    'qty' => 1,
                                    'date' => $cur_date
                                );
                                $last_id = $this->base_model->insert_table("tbl_cart", $data, 1);
                                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                                $res = array(
                                    'message' => "Product Successfully Added!",
                                    'status' => 200,
                                    'data' => $count
                                );
                                echo json_encode($res);
                            } else {
                                $res = array(
                                    'message' => "Product is out of Stock!",
                                    'status' => 201,
                                    'data' => []
                                );
                                echo json_encode($res);
                            }
                        } else {
                            $res = array(
                                'message' => "Product Not Found!",
                                'status' => 201,
                                'data' => []
                            );
                            echo json_encode($res);
                        }
                    } else {
                        $res = array(
                            'message' => "Product is already in your cart!",
                            'status' => 201,
                            'data' => []
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
    //============================================= GetCart ============================================//
    public function GetCart($lang)
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->result();
            $data = [];
            $total = 0;
            $en_data = [];
            $hi_data = [];
            $pn_data = [];
            if (!empty($CartData)) {
                foreach ($CartData as $cart) {
                    if ($cart->is_admin == 1) {
                        //---admin products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    } else {
                        //---vendor products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    }
                    $ProData = $ProData[0];
                    if (!empty($ProData)) {
                        if (!empty($ProData->image)) {
                            $image = base_url() . $ProData->image;
                        } else {
                            $image = '';
                        }
                        //----- Check Inventory  --------
                        if ($ProData->inventory != 0) {
                            $stock = 'In Stock';
                        } else {
                            $stock = 'Out of Stock';
                        }
                        $total += $ProData->selling_price * $cart->qty;
                        if ($lang == "en") {
                            $data[] = array(
                                'cart_id' => $cart->id,
                                'pro_id' => $ProData->id,
                                'name' => $ProData->name_english,
                                'description' => $ProData->description_english,
                                'image' => $image,
                                // 'mrp' => $ProData->mrp,
                                'selling_price' => $ProData->selling_price * $cart->qty,
                                // 'suffix' => $ProData->suffix,
                                'stock' => $stock,
                                'vendor_id' => $ProData->added_by,
                                'is_admin' => $cart->is_admin,
                                'qty' => $cart->qty,
                            );
                        } else if ($lang == "hi") {
                            $data[] = array(
                                'cart_id' => $cart->id,
                                'pro_id' => $ProData->id,
                                'name' => $ProData->name_hindi,
                                'description' => $ProData->description_hindi,
                                'image' => $image,
                                // 'mrp' => $ProData->mrp,
                                'selling_price' => $ProData->selling_price * $cart->qty,
                                // 'suffix' => $ProData->suffix,
                                'stock' => $stock,
                                'vendor_id' => $ProData->added_by,
                                'is_admin' => $cart->is_admin,
                                'qty' => $cart->qty,
                            );
                        } else if ($lang == "pn") {
                            $data[] = array(
                                'cart_id' => $cart->id,
                                'pro_id' => $ProData->id,
                                'name' => $ProData->name_punjabi,
                                'description' => $ProData->description_punjabi,
                                'image' => $image,
                                // 'mrp' => $ProData->mrp,
                                'selling_price' => $ProData->selling_price * $cart->qty,
                                // 'suffix' => $ProData->suffix,
                                'stock' => $stock,
                                'vendor_id' => $ProData->added_by,
                                'is_admin' => $cart->is_admin,
                                'qty' => $cart->qty,
                            );
                        }
                    } else {
                        $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id, 'product_id' => $cart->product_id));
                    }
                }
                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                // $data = array(
                //     'en' => $en_data,
                //     'hi' => $hi_data,
                //     'pn' => $pn_data,
                // );
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                    'count' => $count,
                    'total' => $total
                );
                echo json_encode($res);
            } else {
                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                $res = array(
                    'message' => "Cart is empty!",
                    'status' => 201,
                    'data' => [],
                    'count' => $count
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
    //============================================= UpdateCart ============================================//
    public function UpdateCart()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('qty', 'qty', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $product_id = $this->input->post('product_id');
                $qty = $this->input->post('qty');
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                //----- Verify Auth --------
                if (!empty($farmer_data)) {
                    $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->result();
                    if (!empty($CartData)) {
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $product_id))->result();
                        if (!empty($ProData)) {
                            //----- Check Inventory  --------
                            if ($ProData[0]->inventory >= $qty) {
                                $data_update = array('qty' => $qty,);
                                $this->db->where('product_id', $product_id);
                                $this->db->where('farmer_id', $farmer_data[0]->id);
                                $zapak = $this->db->update('tbl_cart', $data_update);
                                $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->result();
                                $amount = 0;
                                $total = 0;
                                foreach ($CartData as $cart) {
                                    if ($cart->is_admin == 1) {
                                        //---admin products ----
                                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                                    } else {
                                        //---vendor products ----
                                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                                    }
                                    $ProData = $ProData[0];
                                    if (!empty($ProData)) {
                                        if ($cart->product_id == $product_id) {
                                            $amount = $ProData->selling_price * $cart->qty;
                                        }
                                        $total += $ProData->selling_price * $cart->qty;
                                    } else {
                                        $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id, 'product_id' => $cart->product_id));
                                    }
                                }
                                $res = array(
                                    'message' => "Success!",
                                    'status' => 200,
                                    'amount' => $amount,
                                    'total' => $total,
                                );
                                echo json_encode($res);
                            } else {
                                $res = array(
                                    'message' => "Product is out of Stock!",
                                    'status' => 201,
                                    'data' => []
                                );
                                echo json_encode($res);
                            }
                        } else {
                            $res = array(
                                'message' => "Product Not Found!",
                                'status' => 201,
                                'data' => []
                            );
                            echo json_encode($res);
                        }
                    } else {
                        $res = array(
                            'message' => "Cart is empty!",
                            'status' => 201,
                            'data' => []
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
    //============================================= RemoveCart ============================================//
    public function RemoveCart()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $product_id = $this->input->post('product_id');
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                //----- Verify Auth --------
                if (!empty($farmer_data)) {
                    $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id, 'product_id' => $product_id));
                    $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $count,
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
    //============================================= calculate ============================================//
    public function calculate()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->result();
            $data = [];
            $total = 0;
            $is_admin = 0;
            $charges = 0;
            $vendor_id = 0;
            date_default_timezone_set("Asia/Calcutta");
            $cur_date = date("Y-m-d H:i:s");
            if (!empty($CartData)) {
                foreach ($CartData as $cart) {
                    $is_admin = $cart->is_admin;
                    if ($cart->is_admin == 1) {
                        //---admin products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    } else {
                        //---vendor products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    }
                    $ProData = $ProData[0];
                    $vendor_id =  $ProData->added_by;
                    if (!empty($ProData)) {
                        //----- Check Inventory  --------
                        if ($ProData->inventory < $cart->qty) {
                            $res = array(
                                'message' => $ProData->name . ' is out of stock. Please remove this from cart!',
                                'status' => 201
                            );
                            echo json_encode($res);
                            die();
                        }
                        $charges = $cart->qty * VENDOR_CHARGES;
                        $total += $ProData->selling_price * $cart->qty;
                    } else {
                        $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id, 'product_id' => $cart->product_id));
                    }
                }
                //--- CALCULATE CHARGES ------ 
                if ($is_admin == 1) {
                    if ($total <= ADMIN_AMOUNT) {
                        $charges = ADMIN_CHARGES;
                    } else {
                        $charges = 0;
                    }
                }
                //------- order1 entry -----------
                $Order1Data = array(
                    'farmer_id' => $farmer_data[0]->id,
                    'is_admin' => $is_admin,
                    'vendor_id' => $vendor_id,
                    'total_amount' => $total,
                    'charges' => $charges,
                    'final_amount' => $total + $charges,
                    'payment_status' => 0,
                    'order_status' => 0,
                    'date' => $cur_date,
                );
                $order1_id = $this->base_model->insert_table("tbl_order1", $Order1Data, 1);
                //------- order2 entry -----------
                foreach ($CartData as $cart) {
                    if ($cart->is_admin == 1) {
                        //---admin products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    } else {
                        //---vendor products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    }
                    $ProData = $ProData[0];
                    $Order2Data = array(
                        'main_id' => $order1_id,
                        'product_id' => $ProData->id,
                        'product_name' => $ProData->name_english,
                        'image' => $ProData->image,
                        'qty' => $cart->qty,
                        'mrp' => $ProData->mrp,
                        'selling_price' => $ProData->selling_price,
                        'gst' => $ProData->gst,
                        'gst_price' => $ProData->gst_price,
                        'selling_price_wo_gst' => $ProData->selling_price_wo_gst,
                        'total_amount' => $ProData->selling_price * $cart->qty,
                        'date' => $cur_date,
                    );
                    $order2_id = $this->base_model->insert_table("tbl_order2", $Order2Data, 1);
                }
                $send = array(
                    'order_id' => $order1_id,
                    'total' => $total,
                    'charges' => $charges,
                    'final' => $total + $charges,
                );
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $send,
                );
                echo json_encode($res);
            } else {
                $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id));
                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                $res = array(
                    'message' => "Cart is empty!",
                    'status' => 201,
                    'data' => [],
                    'count' => $count
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
    //============================================= Checkout ============================================//
    public function Checkout()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
            //----- Verify Auth --------
            if (!empty($farmer_data)) {
                $this->form_validation->set_rules('order_id', 'order_id', 'required|xss_clean|trim');
                $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');
                $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
                $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
                $this->form_validation->set_rules('district', 'district', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
                $this->form_validation->set_rules('phone', 'pincode', 'required|xss_clean|trim');
                if ($this->form_validation->run() == true) {
                    $order_id = $this->input->post('order_id');
                    $name = $this->input->post('name');
                    $address = $this->input->post('address');
                    $city = $this->input->post('city');
                    $state = $this->input->post('state');
                    $district = $this->input->post('district');
                    $pincode = $this->input->post('pincode');
                    $phone = $this->input->post('phone');
                    $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->result();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $success = base_url() . 'ApiController/FarmerController/payment_success';
                    $fail = base_url() . 'ApiController/FarmerController/payment_failed';
                    if (!empty($CartData)) {
                        foreach ($CartData as $cart) {
                            $is_admin = $cart->is_admin;
                            if ($cart->is_admin == 1) {
                                //---admin products ----
                                $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                            } else {
                                //---vendor products ----
                                $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                            }
                            $ProData = $ProData[0];
                            $vendor_id =  $ProData->added_by;
                            if (!empty($ProData)) {
                                //----- Check Inventory  --------
                                if ($ProData->inventory < $cart->qty) {
                                    $res = array(
                                        'message' => $ProData->name . ' is out of stock. Please remove this from cart!',
                                        'status' => 201
                                    );
                                    echo json_encode($res);
                                    die();
                                }
                            }
                        }
                        $txn_id = mt_rand(999999, 999999999999);
                        $state_da = $this->db->get_where('all_states', array('id' => $state))->result();
                        $data_update = array(
                            'txn_id' => $txn_id,
                            'name' => $name,
                            'address' => $address,
                            'city' => $city,
                            'state' => $state_da[0]->state_name,
                            'district' => $district,
                            'pincode' => $pincode,
                            'phone' => $phone,
                        );
                        $this->db->where('id', $order_id);
                        $this->db->update('tbl_order1', $data_update);
                        $order1_data = $this->db->get_where('tbl_order1', array('id' => $order_id))->result();
                        $post = array(
                            'txn_id' => $txn_id,
                            'merchant_id' => MERCHAND_ID,
                            'order_id' => $order_id,
                            'amount' => $order1_data[0]->final_amount,
                            'currency' => "INR",
                            'redirect_url' => $success,
                            'cancel_url' => $fail,
                            'billing_name' => $name,
                            'billing_address' => $address,
                            'billing_city' => $city,
                            'billing_state' => $state_da[0]->state_name,
                            'billing_zip' => $pincode,
                            'billing_country' => 'India',
                            'billing_tel' => $phone,
                            'billing_email' => '',
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
                            'order_id' => $order_id,
                            'access_code' => $access_code,
                            'redirect_url' => $success,
                            'cancel_url' => $fail,
                            'enc_val' => $encrypted_data,
                            'plain' => $merchant_data,
                        );
                        $res = array(
                            'message' => "Success!",
                            'status' => 200,
                            'data' => $send,
                        );
                        echo json_encode($res);
                    } else {
                        $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id));
                        $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                        $res = array(
                            'message' => "Cart is empty!",
                            'status' => 201,
                            'data' => [],
                            'count' => $count
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
    public function payment_success()
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
            if ($i == 0) $order_id = $information[1];
        }
        $data_insert = array(
            'body' => json_encode($decryptValues),
            'date' => $cur_date
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
        if ($order_status === "Success") {
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 0);
            $this->db->where('id', $order_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                $data_update = array(
                    'payment_status' => 1,
                    'order_status' => 1,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_order1', $data_update);
                $order1_id = $this->base_model->insert_table("tbl_order1", $Order1Data, 1);
                $order1_data = $this->db->get_where('tbl_order1', array('id' => $order_id))->result();
                $order2_data = $this->db->get_where('tbl_order2', array('main_id' => $order_id))->result();
                //------- order2 entry -----------
                foreach ($order2_data as $cart) {
                    if ($order1_data[0]->is_admin == 1) {
                        //---admin products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    } else {
                        //---vendor products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    }
                    $ProData = $ProData[0];
                    $new_inventory = $ProData->inventory - $cart->qty;
                    //--------- create inventory transaction -------
                    $inv_txn = array(
                        'order_id' => $order_id,
                        'at_time' => $ProData->inventory,
                        'less_inventory' => $cart->qty,
                        'updated_inventory' => $new_inventory,
                        'date' => $cur_date,
                    );
                    $idd = $this->base_model->insert_table("tbl_inventory_txn", $inv_txn, 1);
                    //------ Update inventory --------------------
                    $data_update = array('inventory' => $new_inventory,);
                    $this->db->where('id', $ProData->id);
                    $zapak = $this->db->update('tbl_products', $data_update);
                }
                //--- Delete Cart -----------
                $this->db->delete('tbl_cart', array('farmer_id' => $order1_data[0]->farmer_id));
                if ($order1_data[0]->$is_admin == 0) {
                    $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $order1_data[0]->vendor_id))->result();
                    //------ create amount txn in the table -------------
                    if (!empty($vendor_data[0]->comission)) {
                        $amt = $order1_data[0]->total_amount * $vendor_data[0]->comission / 100;
                        $data2 = array(
                            'req_id' => $order_id,
                            'vendor_id' => $vendor_id,
                            'cr' => $amt,
                            'date' => $cur_date
                        );
                        $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                        //------ update vendor account ------
                        $data_update = array(
                            'account' => $vendor_data[0]->account + $amt,
                        );
                        $this->db->where('id', $vendor_id);
                        $zapak = $this->db->update('tbl_vendor', $data_update);
                    }
                }
                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $order1_data[0]->farmer_id))->num_rows();
                $send = array(
                    'count' => $count,
                    'order_id' => $order1_id,
                    'amount' => $order1_data[0]->final_amount,
                );
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'order_id' => $order_id,
                    'user_id' => $user_id,
                );
                echo '<p style="display:none">Success</p>';
                exit;
            }
        } else if ($order_status === "Failure") {
            echo '<p style="display:none">Failure</p>';
            exit;
        } else {
            echo '<p style="display:none">Aborted</p>';
        }
    }
    public function payment_failed()
    {
        $encResponse = $this->input->post('encResp'); //This is the response sent by the CCAvenue Server
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        error_reporting(0);
        $workingKey = WORKING_KEY;            //Working Key should be provided here.
        $rcvdString = $this->decrypt($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
        $order_status = "";
        $decryptValues = explode('&', $rcvdString);
        $dataSize = sizeof($decryptValues);
        for ($i = 0; $i < $dataSize; $i++) {
            $information = explode('=', $decryptValues[$i]);
            if ($i == 3)    $order_status = $information[1];
        }
        $data_insert = array(
            'body' => json_encode($decryptValues),
            'date' => $cur_date
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
    }
    //============================================= Checkout ============================================//
    public function Success()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->result();
            $data = [];
            $total = 0;
            $is_admin = 0;
            $charges = 0;
            $vendor_id = 0;
            date_default_timezone_set("Asia/Calcutta");
            $cur_date = date("Y-m-d H:i:s");
            if (!empty($CartData)) {
                foreach ($CartData as $cart) {
                    $is_admin = $cart->is_admin;
                    if ($cart->is_admin == 1) {
                        //---admin products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    } else {
                        //---vendor products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    }
                    $ProData = $ProData[0];
                    $vendor_id =  $ProData->added_by;
                    if (!empty($ProData)) {
                        //----- Check Inventory  --------
                        if ($ProData->inventory < $cart->qty) {
                            $res = array(
                                'message' => $ProData->name . ' is out of stock. Please remove this from cart!',
                                'status' => 201
                            );
                            echo json_encode($res);
                            die();
                        }
                        $charges = $cart->qty * VENDOR_CHARGES;
                        $total += $ProData->selling_price * $cart->qty;
                    }
                }
                //--- CALCULATE CHARGES ------ 
                if ($is_admin == 1) {
                    if ($total <= ADMIN_AMOUNT) {
                        $charges = ADMIN_CHARGES;
                    } else {
                        $charges = 0;
                    }
                }
                //------- order1 entry -----------
                $Order1Data = array(
                    'farmer_id' => $farmer_data[0]->id,
                    'is_admin' => $is_admin,
                    'vendor_id' => $vendor_id,
                    'total_amount' => $total,
                    'charges' => $charges,
                    'final_amount' => $total + $charges,
                    'payment_status' => 1,
                    'order_status' => 1,
                    'date' => $cur_date,
                );
                $order1_id = $this->base_model->insert_table("tbl_order1", $Order1Data, 1);
                //------- order2 entry -----------
                foreach ($CartData as $cart) {
                    if ($cart->is_admin == 1) {
                        //---admin products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    } else {
                        //---vendor products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    }
                    $ProData = $ProData[0];
                    $Order2Data = array(
                        'main_id' => $order1_id,
                        'product_id' => $ProData->id,
                        'product_name' => $ProData->name_english,
                        'image' => $ProData->image,
                        'qty' => $cart->qty,
                        'mrp' => $ProData->mrp,
                        'selling_price' => $ProData->selling_price,
                        'gst' => $ProData->gst,
                        'gst_price' => $ProData->gst_price,
                        'selling_price_wo_gst' => $ProData->selling_price_wo_gst,
                        'total_amount' => $ProData->selling_price * $cart->qty,
                        'date' => $cur_date,
                    );
                    $order2_id = $this->base_model->insert_table("tbl_order2", $Order2Data, 1);
                    $new_inventory = $ProData->inventory - $cart->qty;
                    //--------- create inventory transaction -------
                    $inv_txn = array(
                        'order_id' => $order1_id,
                        'at_time' => $ProData->inventory,
                        'less_inventory' => $cart->qty,
                        'updated_inventory' => $new_inventory,
                        'date' => $cur_date,
                    );
                    $idd = $this->base_model->insert_table("tbl_inventory_txn", $inv_txn, 1);
                    //------ Update inventory --------------------
                    $data_update = array('inventory' => $new_inventory,);
                    $this->db->where('id', $ProData->id);
                    $zapak = $this->db->update('tbl_products', $data_update);
                }
                //--- Delete Cart -----------
                $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id));
                if ($is_admin == 0) {
                    $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $vendor_id))->result();
                    //------ create amount txn in the table -------------
                    if (!empty($vendor_data[0]->comission)) {
                        $amt = $total * $vendor_data[0]->comission / 100;
                        $data2 = array(
                            'req_id' => $order1_id,
                            'vendor_id' => $vendor_id,
                            'cr' => $amt,
                            'date' => $cur_date
                        );
                        $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                        //------ update vendor account ------
                        $data_update = array(
                            'account' => $vendor_data[0]->account + $amt,
                        );
                        $this->db->where('id', $vendor_id);
                        $zapak = $this->db->update('tbl_vendor', $data_update);
                    }
                }
                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                $send = array(
                    'count' => $count,
                    'order_id' => $order1_id,
                    'amount' => $total,
                );
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $send,
                );
                echo json_encode($res);
            } else {
                $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id));
                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                $res = array(
                    'message' => "Cart is empty!",
                    'status' => 201,
                    'data' => [],
                    'count' => $count
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
    //============================================= GetOrders ============================================//
    public function GetOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $orderData = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('farmer_id' => $farmer_data[0]->id, 'payment_status' => 1))->result();
            $data = [];
            $total = 0;
            if (!empty($orderData)) {
                foreach ($orderData as $order) {
                    $newDate = new DateTime($order->date);
                    if ($order->order_status == 1) {
                        $status = 'Pending';
                        $bg_color = '#65bcd7';
                    } elseif ($order->order_status == 2) {
                        $status = 'Accepted';
                        $bg_color = '#3b71ca';
                    } elseif ($order->order_status == 3) {
                        $status = 'Dispatched';
                        $bg_color = '#e4a11b';
                    } elseif ($order->order_status == 4) {
                        $status = 'Completed';
                        $bg_color = '#139c49';
                    } elseif ($order->order_status == 5) {
                        $status = 'Rejected';
                        $bg_color = '#dc4c64';
                    } elseif ($order->order_status == 6) {
                        $status = 'Cancelled';
                        $bg_color = '#dc4c64';
                    }
                    $details = [];
                    $orderDetails = $this->db->get_where('tbl_order2', array('main_id' => $order->id))->result();
                    foreach ($orderDetails as $order2) {
                        if (!empty($order2->image)) {
                            $image = base_url() . $order2->image;
                        } else {
                            $image = '';
                        }
                        $details[] = array(
                            'id' => $order2->id,
                            'product_name' => $order2->product_name,
                            'image' => $image,
                            'qty' => $order2->qty,
                            'selling_price' => $order2->selling_price,
                            'total_amount' => $order2->total_amount,
                        );
                    }
                    $data[] = array(
                        'id' => $order->id,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'date' => $newDate->format('d/m/Y'),
                        'details' => $details
                    );
                }
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => "No Orders Found!",
                    'status' => 201,
                    'data' => [],
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
    //============================================= GetRequests ============================================//
    public function GetRequests()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $RequestData = $this->db->order_by('id', 'desc')->get_where('tbl_doctor_req', array('farmer_id' => $farmer_data[0]->id, 'payment_status' => 1))->result();
            $data = [];
            if (!empty($RequestData)) {
                foreach ($RequestData as $request) {
                    $DocData = $this->db->get_where('tbl_doctor', array('id' => $request->doctor_id))->result();
                    $newDate = new DateTime($request->date);
                    if ($request->status == 0) {
                        $status = 'Pending';
                        $bg_color = '#e4a11b';
                    } elseif ($request->status == 1) {
                        $status = 'Completed';
                        $bg_color = '#139c49';
                    }
                    if (!empty($request->image1)) {
                        $image1 = base_url() . $request->image1;
                    } else {
                        $image1 = '';
                    }
                    if (!empty($request->image2)) {
                        $image2 = base_url() . $request->image2;
                    } else {
                        $image2 = '';
                    }
                    if (!empty($request->image3)) {
                        $image3 = base_url() . $request->image3;
                    } else {
                        $image3 = '';
                    }
                    if (!empty($request->image4)) {
                        $image4 = base_url() . $request->image4;
                    } else {
                        $image4 = '';
                    }
                    if (!empty($request->image5)) {
                        $image5 = base_url() . $request->image5;
                    } else {
                        $image5 = '';
                    }
                    if (!empty($DocData[0]->image)) {
                        $doctor_image = base_url() . $DocData[0]->image;
                    } else {
                        $doctor_image = '';
                    }
                    $data[] = array(
                        'id' => $request->id,
                        'doctor_name' => $DocData[0]->name,
                        'doctor_image' => $doctor_image,
                        'reason' => $request->reason,
                        'description' => $request->description,
                        'fees' => $request->fees,
                        'image1' => $image1,
                        'image2' => $image2,
                        'image3' => $image3,
                        'image4' => $image4,
                        'image5' => $image5,
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'date' => $newDate->format('d/m/Y'),
                    );
                }
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => "No Orders Found!",
                    'status' => 201,
                    'data' => [],
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
    /*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
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
}
  //=========================================END FarmerController======================================//
