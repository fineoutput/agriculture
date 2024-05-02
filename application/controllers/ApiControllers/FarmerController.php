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
                                $data = array(
                                    'farmer_id' => $farmer_data[0]->id,
                                    'is_admin' => $is_admin,
                                    'vendor_id' => $vendor_id,
                                    'product_id' => $product_id,
                                    'qty' => $ProData[0]->min_qty ? $ProData[0]->min_qty : 1,
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
                                'min_qty' => $ProData->min_qty ? $ProData->min_qty : 1,

                                // 'mrp' => $ProData->mrp,
                                'selling_price' => $ProData->selling_price * $cart->qty,
                                // 'suffix' => $ProData->suffix,
                                'stock' => $stock,
                                'vendor_id' => $ProData->added_by,
                                'is_admin' => $cart->is_admin,
                                'qty' => $cart->qty,
                                'product_cod'=>$ProData->cod,
                                'is_cod' => $farmer_data[0]->cod,
                               
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
                                'min_qty' => $ProData->min_qty ? $ProData->min_qty : 1,

                                'stock' => $stock,
                                'vendor_id' => $ProData->added_by,
                                'is_admin' => $cart->is_admin,
                                'qty' => $cart->qty,
                                'product_cod'=>$ProData->cod,
                                'is_cod' => $farmer_data[0]->cod,
                                
                            );
                        } else if ($lang == "pn") {
                            $data[] = array(
                                'cart_id' => $cart->id,
                                'pro_id' => $ProData->id,
                                'name' => $ProData->name_punjabi,
                                'description' => $ProData->description_punjabi,
                                'image' => $image,
                                'min_qty' => $ProData->min_qty ? $ProData->min_qty : 1,

                                // 'mrp' => $ProData->mrp,
                                'selling_price' => $ProData->selling_price * $cart->qty,
                                // 'suffix' => $ProData->suffix,
                                'stock' => $stock,
                                'vendor_id' => $ProData->added_by,
                                'is_admin' => $cart->is_admin,
                                'qty' => $cart->qty,
                                'product_cod'=>$ProData->cod,
                                'is_cod' => $farmer_data[0]->cod,
                                
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
                                //---- check mini qty ---
                                if ($ProData[0]->min_qty && $qty < $ProData[0]->min_qty) {
                                    $res = array(
                                        'message' => "Minimum Quantity should be " . $ProData[0]->min_qty,
                                        'status' => 201,
                                        'data' => []
                                    );
                                    echo json_encode($res);
                                    return;
                                }
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
                                'message' => $ProData->name_english . ' is out of stock. Please remove this from cart!',
                                'status' => 201
                            );
                            echo json_encode($res);
                            die();
                        }
                        //---- check mini qty ---
                        if ($ProData->min_qty && $cart->qty < $ProData->min_qty) {
                            $res = array(
                                'message' =>  $ProData->name_english . " minimum quantity should be " . $ProData->min_qty,
                                'status' => 201,
                                'data' => []
                            );
                            echo json_encode($res);
                            return;
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
                        'product_name_en' => $ProData->name_english,
                        'product_name_hi' => $ProData->name_hindi,
                        'product_name_pn' => $ProData->name_punjabi,
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
                    $cod = $this->input->post('cod');
                    $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->result();
                    

                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $success = base_url() . 'ApiControllers/FarmerController/payment_success';
                    $fail = base_url() . 'ApiControllers/FarmerController/payment_failed';
                    if (!empty($CartData)) {
                        if ($cod == 0) {
                            
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
                                    //---- check mini qty ---
                                    if ($ProData->min_qty && $cart->qty < $ProData->min_qty) {
                                        $res = array(
                                            'message' =>  $ProData->name . " minimum quantity should be " . $ProData->min_qty,
                                            'status' => 201,
                                            'data' => []
                                        );
                                        echo json_encode($res);
                                        return;
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
                                'gateway' => 'CC Avenue',
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
                                'merchant_param1' => 'Order Payment',
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
                                'merchant_param1' => 'Order Payment',
                            );
                            $res = array(
                                'message' => "Success!",
                                'status' => 200,
                                'data' => $send,
                            );
                            echo json_encode($res);
                        } else {

                            foreach ($CartData as $cart) {
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
                                    //---- check mini qty ---
                                    if ($ProData->min_qty && $cart->qty < $ProData->min_qty) {
                                        
                                        $res = array(
                                            'message' =>  $ProData->name . " minimum quantity should be " . $ProData->min_qty,
                                            'status' => 201,
                                            'data' => []
                                        );
                                        echo json_encode($res);
                                        return;
                                    }
                                }
                            }
                            $state_da = $this->db->get_where('all_states', array('id' => $state))->result();
                            $data_update = array(
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
                            $this->db->select('*');
                            $this->db->from('tbl_order1');
                            $this->db->where('payment_status', 0);
                            $this->db->where('id', $order_id);
                            $order_data = $this->db->get()->row();
                            
                            if (!empty($order_data)) {
                               
                                //---- start calculate invoice number ----
                                $now = date('y');
                                $next = date('y', strtotime('+1 year'));
                                $order1 = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('payment_status' => 1, 'invoice_year' => $now . '-' . $next))->result();
                                
                                if (empty($order1)) {
                                    $invoice_year = $now . '-' . $next;
                                    $invoice_no = 1;
                                } else {
                                    $invoice_year = $now . '-' . $next;
                                    $invoice_no = $order1[0]->invoice_no + 1;
                                }
                                $data_update = array(
                                    'payment_status' => 1,
                                    'order_status' => 1,
                                    'invoice_year' => $invoice_year,
                                    'invoice_no' => $invoice_no,
                                );
                                $this->db->where('id', $order_id);
                                $this->db->update('tbl_order1', $data_update);
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
                                if ($order1_data[0]->is_admin == 0) {
                                    $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $order1_data[0]->vendor_id))->result();
                                    //------ create amount txn in the table -------------
                                    if (!empty($vendor_data[0]->comission)) {
                                        $amt = $order1_data[0]->total_amount * $vendor_data[0]->comission / 100;
                                        $data2 = array(
                                            'req_id' => $order_id,
                                            'vendor_id' => $order1_data[0]->vendor_id,
                                            'cr' =>  $order1_data[0]->total_amount - $amt,
                                            'date' => $cur_date
                                        );
                                        $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                                        //------ update vendor account ------
                                        $data_update = array(
                                            'account' => $vendor_data[0]->account + $order1_data[0]->total_amount - $amt,
                                        );
                                        $this->db->where('id', $order1_data[0]->vendor_id);
                                        $zapak = $this->db->update('tbl_vendor', $data_update);
                                    }
                                    //------ send notification to vendor -----
                                    if (!empty($vendor_data[0]->fcm_token)) {
                                        // echo $user_device_tokens->device_token;
                                        //success notification code
                                        $url = 'https://fcm.googleapis.com/fcm/send';
                                        $title = "New Order";
                                        $message = "New order #" . $order_id . "  received with the  amount of  ₹" . $order1_data[0]->final_amount;
                                        $msg2 = array(
                                            'title' => $title,
                                            'body' => $message,
                                            "sound" => "default"
                                        );
                                        $fields = array(
                                            // 'to'=>"/topics/all",
                                            'to' => $vendor_data[0]->fcm_token,
                                            'notification' => $msg2,
                                            'priority' => 'high'
                                        );
                                        $fields = json_encode($fields);
                                        $headers = array(
                                            'Authorization: key=' . "AAAAAIDR4rw:APA91bHaVxhjsODWyIDSiQXCpBhC46GL-9Ycxa9VKwtsPefjLy6NfiiLsajh8db55tRrIOag_A9wh9iXREo2-Obbt1U-fdHmpjy3zvgvTWFleqY5S_8dJtoYz0uKxPRZ76E3sXpgjISv",
                                            'Content-Type: application/json'
                                        );
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_URL, $url);
                                        curl_setopt($ch, CURLOPT_POST, true);
                                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                                        $result = curl_exec($ch);
                                        // echo $fields;
                                        // echo $result;
                                        curl_close($ch);
                                        //End success notification code
                                        $data_insert = array(
                                            'vendor_id' => $order1_data[0]->vendor_id,
                                            'name' => $title,
                                            'dsc' => $message,
                                            'date' => $cur_date
                                        );
                                        $last_id = $this->base_model->insert_table("tbl_vendor_notification", $data_insert, 1);
                                    }
                                } else {
                                  
                                    //--- send email to admin -----------------
                                    $config = array(
                                        'protocol' => 'SMTP',
                                        'smtp_host' => SMTP_HOST,
                                        'smtp_port' => SMTP_PORT,
                                        'smtp_user' => USER_NAME, // change it to yours
                                        'smtp_pass' => PASSWORD, // change it to yours
                                        'mailtype' => 'html',
                                        'charset' => 'iso-8859-1',
                                        'wordwrap' => true
                                    );
                                    $message2 = '
                        Hello Admin<br/><br/>
                        You have received new Order and below are the details<br/><br/>
                        <b>Order ID</b> - ' . $order_id . '<br/>
                        <b>Amount</b> - Rs.' . $order1_data[0]->final_amount . '<br/>
                          ';
                                    $this->load->library('email', $config);
                                    $this->email->set_newline("");
                                    $this->email->from(EMAIL); // change it to yours
                                    $this->email->to(TO, 'Dairy Muneem'); // change it to yours
                                    $this->email->subject('New Order received');
                                    $this->email->message($message2);
                                    if ($this->email->send()) {
                                    } else {
                                    }
                                    $order1_data = $order1_data[0];
                                    $user_data = $this->db->get_where('tbl_farmers', array('id' => $order1_data->user_id))->row();
                                    //---------- send whatsapp order msg to admin -----
                                    $this->send_whatsapp_msg_admin($order1_data, $user_data);
                                }
                                echo 'Success';
                                exit;
                            }
                        }
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
    public function check()
    {

        $url = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay';
        $success = base_url() . 'ApiControllers/FarmerController/payment_success';

        $payload = array(
            "merchantId" => "PGTESTPAYUAT102",
            "merchantTransactionId" => "MT4518752444",
            "merchantUserId" => "MUID123",
            "amount" => 1000,
            "redirectUrl" => base_url() . 'ApiControllers/FarmerController/get_response',
            "callbackUrl" => base_url() . 'ApiControllers/FarmerController/get_response',
            "mobileNumber" => "9876543210",
            "redirectMode" => "POST",
        );

        $json = json_encode($payload);
        $payload = json_decode($json);
        $payload->paymentInstrument = new stdClass();
        $payload->paymentInstrument->type = "PAY_PAGE";

        $jsonPayload = json_encode($payload);
        $encode_jsonPayload = base64_encode($jsonPayload);
        $saltKey = 'e777554e-58ca-4847-8f19-72abac9eb6b3';
        $saltIndex = '1';
        $verifyHeader = hash('sha256', $encode_jsonPayload . '/pg/v1/pay' . $saltKey) . '###' . $saltIndex;
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
        // echo $response;
        $res = json_decode($response);
        if ($res->code == 'PAYMENT_INITIATED') {
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $res,
            );
            echo json_encode($res);
            //     // redirect($res->data->instrumentResponse->redirectInfo->url);
        } else {

            // redirect('web/checkout');
        }
    }

    public function get_response()
    {
        $body = $_POST;
        // Takes raw data from the request
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        // Converts it into a PHP object
        $data = json_encode($body);
        $data_insert = array(
            'body' => $data,
            'date' => $cur_date,
        );
        $last_id = $this->base_model->insert_table("tbl_ccavenue_response", $data_insert, 1);
        echo $data;
        die();
        $merchantId = 'PGTESTPAYUAT102';
        $saltKey = 'e777554e-58ca-4847-8f19-72abac9eb6b3';
        $saltIndex = '1';
        if ($body['code'] == 'PAYMENT_SUCCESS') {
            $url = 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status/PGTESTPAYUAT102/' . $body['transactionId'] . '';
            $verifyHeader = hash('sha256', '/pg/v1/status/' . $merchantId . '/' . $body['transactionId'] . $saltKey) . '###' . $saltIndex;
            $ch = curl_init();
            // Set the cURL options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-VERIFY: ' . $verifyHeader,
                'X-MERCHANT-ID: MT4518752444',
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
            $res = json_decode($response);
            if ($res->code == 'PAYMENT_SUCCESS') {
                echo "payment success";
            } else {
                // redirect('web/checkout');
            }
        }
    }
    //============================================= PhonePeCheckout ============================================//
    public function PhonePeCheckout()
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
                    $success = base_url() . 'ApiControllers/FarmerController/phone_pe_payment_success';
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
                        $txn_id = bin2hex(random_bytes(12));
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
                            'gateway' => 'Phone Pe',
                        );
                        $this->db->where('id', $order_id);
                        $this->db->update('tbl_order1', $data_update);
                        $order1_data = $this->db->get_where('tbl_order1', array('id' => $order_id))->result();
                        $param1 = 'Order Payment';
                        $response = $this->initiate_phone_pe_payment($txn_id, $order1_data[0]->final_amount, $phone, $success, $param1);
                        if ($response && $response->code == 'PAYMENT_INITIATED') {
                            $send = array(
                                'url' => $response->data->instrumentResponse->redirectInfo->url,
                                'redirect_url' => $success,
                                'merchant_param1' => $param1,
                                'order_id' => $order_id,
                            );
                            $res = array(
                                'message' => "Success!",
                                'status' => 200,
                                'data' => $send,
                            );
                        } else {
                            $res = array(
                                'message' => "Some error occurred!",
                                'status' => 201,
                            );
                        }
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
        log_message('error', 'url-----' . $url);
        log_message('error', 'jsonPayload-----' . $jsonPayload);
        $encode_jsonPayload = base64_encode($jsonPayload);
        log_message('error', 'base64-----' . $encode_jsonPayload);
        $verifyHeader = hash('sha256', $encode_jsonPayload . '/pg/v1/pay' . PHONE_PE_SALT) . '###' . PHONE_PE_SALT_INDEX;
        $request_json = new stdClass();
        $request_json->request = $encode_jsonPayload;
        log_message('error', 'X-VERIFY-----' . $verifyHeader);
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
        log_message('error', 'response-----' . json_encode($response));

        return json_decode($response);
    }
    // ====================== START PHONE PE INITIATE PAYMENT ==================================
    public function verify_phone_pe_payment($body)
    {

        if ($body['code'] == 'PAYMENT_SUCCESS') {
            $url = PHONE_PE_URL . '/pg/v1/status/' . PHONE_PE_MERCHANT_ID . '/' . $body['transactionId'] . '';
            log_message('error', 'verify url-----' . $url);
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
    public function phone_pe_payment_success()
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
        if ($response && $response->code == 'PAYMENT_SUCCESS') {
            $txn_id = $response->data->merchantTransactionId;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $txn_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                $order_id = $order_data->id;
                //---- start calculate invoice number ----
                $now = date('y');
                $next = date('y', strtotime('+1 year'));
                $order1 = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('payment_status' => 1, 'invoice_year' => $now . '-' . $next))->result();
                if (empty($order1)) {
                    $invoice_year = $now . '-' . $next;
                    $invoice_no = 1;
                } else {
                    $invoice_year = $now . '-' . $next;
                    $invoice_no = $order1[0]->invoice_no + 1;
                }
                $data_update = array(
                    'payment_status' => 1,
                    'order_status' => 1,
                    'invoice_year' => $invoice_year,
                    'invoice_no' => $invoice_no,
                    'cc_response' => json_encode($body),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_order1', $data_update);
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
                if ($order1_data[0]->is_admin == 0) {
                    $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $order1_data[0]->vendor_id))->result();
                    //------ create amount txn in the table -------------
                    if (!empty($vendor_data[0]->comission)) {
                        $amt = $order1_data[0]->total_amount * $vendor_data[0]->comission / 100;
                        $data2 = array(
                            'req_id' => $order_id,
                            'vendor_id' => $order1_data[0]->vendor_id,
                            'cr' =>  $order1_data[0]->total_amount - $amt,
                            'date' => $cur_date
                        );
                        $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                        //------ update vendor account ------
                        $data_update = array(
                            'account' => $vendor_data[0]->account + $order1_data[0]->total_amount - $amt,
                        );
                        $this->db->where('id', $order1_data[0]->vendor_id);
                        $zapak = $this->db->update('tbl_vendor', $data_update);
                    }
                    //------ send notification to vendor -----
                    if (!empty($vendor_data[0]->fcm_token)) {
                        // echo $user_device_tokens->device_token;
                        //success notification code
                        $url = 'https://fcm.googleapis.com/fcm/send';
                        $title = "New Order";
                        $message = "New order #" . $order_id . "  received with the  amount of  ₹" . $order1_data[0]->final_amount;
                        $msg2 = array(
                            'title' => $title,
                            'body' => $message,
                            "sound" => "default"
                        );
                        $fields = array(
                            // 'to'=>"/topics/all",
                            'to' => $vendor_data[0]->fcm_token,
                            'notification' => $msg2,
                            'priority' => 'high'
                        );
                        $fields = json_encode($fields);
                        $headers = array(
                            'Authorization: key=' . "AAAAAIDR4rw:APA91bHaVxhjsODWyIDSiQXCpBhC46GL-9Ycxa9VKwtsPefjLy6NfiiLsajh8db55tRrIOag_A9wh9iXREo2-Obbt1U-fdHmpjy3zvgvTWFleqY5S_8dJtoYz0uKxPRZ76E3sXpgjISv",
                            'Content-Type: application/json'
                        );
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        $result = curl_exec($ch);
                        // echo $fields;
                        // echo $result;
                        curl_close($ch);
                        //End success notification code
                        $data_insert = array(
                            'vendor_id' => $order1_data[0]->vendor_id,
                            'name' => $title,
                            'dsc' => $message,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_vendor_notification", $data_insert, 1);
                    }
                } else {
                    //--- send email to admin -----------------
                    $config = array(
                        'protocol' => 'SMTP',
                        'smtp_host' => SMTP_HOST,
                        'smtp_port' => SMTP_PORT,
                        'smtp_user' => USER_NAME, // change it to yours
                        'smtp_pass' => PASSWORD, // change it to yours
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => true
                    );
                    $message2 = '
                        Hello Admin<br/><br/>
                        You have received new Order and below are the details<br/><br/>
                        <b>Order ID</b> - ' . $order_id . '<br/>
                        <b>Amount</b> - Rs.' . $order1_data[0]->final_amount . '<br/>
                          ';
                    $this->load->library('email', $config);
                    $this->email->set_newline("");
                    $this->email->from(EMAIL); // change it to yours
                    $this->email->to(TO, 'Dairy Muneem'); // change it to yours
                    $this->email->subject('New Order received');
                    $this->email->message($message2);
                    if ($this->email->send()) {
                    } else {
                    }
                    $order1_data = $order1_data[0];
                    $user_data = $this->db->get_where('tbl_farmers', array('id' => $order1_data->user_id))->row();
                    //---------- send whatsapp order msg to admin -----
                    $this->send_whatsapp_msg_admin($order1_data, $user_data);
                }
                echo 'Success';
                exit;
            }
        } else {
            log_message('error', 'fail response-----' . json_encode($response));
        }
    }
    // ====================== END PHONE PE INITIATE PAYMENT ==================================}
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
        // echo $order_status;die();
        if ($order_status === "Success") {
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 0);
            $this->db->where('id', $order_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                //---- start calculate invoice number ----
                $now = date('y');
                $next = date('y', strtotime('+1 year'));
                $order1 = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('payment_status' => 1, 'invoice_year' => $now . '-' . $next))->result();
                if (empty($order1)) {
                    $invoice_year = $now . '-' . $next;
                    $invoice_no = 1;
                } else {
                    $invoice_year = $now . '-' . $next;
                    $invoice_no = $order1[0]->invoice_no + 1;
                }
                $data_update = array(
                    'payment_status' => 1,
                    'order_status' => 1,
                    'invoice_year' => $invoice_year,
                    'invoice_no' => $invoice_no,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_order1', $data_update);
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
                if ($order1_data[0]->is_admin == 0) {
                    $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $order1_data[0]->vendor_id))->result();
                    //------ create amount txn in the table -------------
                    if (!empty($vendor_data[0]->comission)) {
                        $amt = $order1_data[0]->total_amount * $vendor_data[0]->comission / 100;
                        $data2 = array(
                            'req_id' => $order_id,
                            'vendor_id' => $order1_data[0]->vendor_id,
                            'cr' =>  $order1_data[0]->total_amount - $amt,
                            'date' => $cur_date
                        );
                        $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                        //------ update vendor account ------
                        $data_update = array(
                            'account' => $vendor_data[0]->account + $order1_data[0]->total_amount - $amt,
                        );
                        $this->db->where('id', $order1_data[0]->vendor_id);
                        $zapak = $this->db->update('tbl_vendor', $data_update);
                    }
                    //------ send notification to vendor -----
                    if (!empty($vendor_data[0]->fcm_token)) {
                        // echo $user_device_tokens->device_token;
                        //success notification code
                        $url = 'https://fcm.googleapis.com/fcm/send';
                        $title = "New Order";
                        $message = "New order #" . $order_id . "  received with the  amount of  ₹" . $order1_data[0]->final_amount;
                        $msg2 = array(
                            'title' => $title,
                            'body' => $message,
                            "sound" => "default"
                        );
                        $fields = array(
                            // 'to'=>"/topics/all",
                            'to' => $vendor_data[0]->fcm_token,
                            'notification' => $msg2,
                            'priority' => 'high'
                        );
                        $fields = json_encode($fields);
                        $headers = array(
                            'Authorization: key=' . "AAAAAIDR4rw:APA91bHaVxhjsODWyIDSiQXCpBhC46GL-9Ycxa9VKwtsPefjLy6NfiiLsajh8db55tRrIOag_A9wh9iXREo2-Obbt1U-fdHmpjy3zvgvTWFleqY5S_8dJtoYz0uKxPRZ76E3sXpgjISv",
                            'Content-Type: application/json'
                        );
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        $result = curl_exec($ch);
                        // echo $fields;
                        // echo $result;
                        curl_close($ch);
                        //End success notification code
                        $data_insert = array(
                            'vendor_id' => $order1_data[0]->vendor_id,
                            'name' => $title,
                            'dsc' => $message,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_vendor_notification", $data_insert, 1);
                    }
                } else {
                    //--- send email to admin -----------------
                    $config = array(
                        'protocol' => 'SMTP',
                        'smtp_host' => SMTP_HOST,
                        'smtp_port' => SMTP_PORT,
                        'smtp_user' => USER_NAME, // change it to yours
                        'smtp_pass' => PASSWORD, // change it to yours
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => true
                    );
                    $message2 = '
                        Hello Admin<br/><br/>
                        You have received new Order and below are the details<br/><br/>
                        <b>Order ID</b> - ' . $order_id . '<br/>
                        <b>Amount</b> - Rs.' . $order1_data[0]->final_amount . '<br/>
                          ';
                    $this->load->library('email', $config);
                    $this->email->set_newline("");
                    $this->email->from(EMAIL); // change it to yours
                    $this->email->to(TO, 'Dairy Muneem'); // change it to yours
                    $this->email->subject('New Order received');
                    $this->email->message($message2);
                    if ($this->email->send()) {
                    } else {
                    }
                    $order1_data = $order1_data[0];
                    $user_data = $this->db->get_where('tbl_farmers', array('id' => $order1_data->user_id))->row();
                    //---------- send whatsapp order msg to admin -----
                    $this->send_whatsapp_msg_admin($order1_data, $user_data);
                }
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
    public function VerifyPayment($order_id)
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $order1_data = $this->db->get_where('tbl_order1', array('id' => $order_id, 'farmer_id' => $farmer_data[0]->id, 'payment_status' => 1))->result();
            if (!empty($order1_data)) {
                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $order1_data[0]->farmer_id))->num_rows();
                $send = array(
                    'count' => $count,
                    'order_id' => $order_id,
                    'amount' => $order1_data[0]->final_amount,
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
                            'cr' => $total - $amt,
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
                } else {
                    $order1_data = $this->db->get_where('tbl_order1', array('id' => $order1_id))->row();
                    $user_data = $this->db->get_where('tbl_farmers', array('id' => $order1_data->user_id))->row();
                    //---------- send whatsapp order msg to admin -----
                    $this->send_whatsapp_msg_admin($order1_data, $user_data);
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
                            'en' => $order2->product_name_en,
                            'hi' => $order2->product_name_hi,
                            'pn' => $order2->product_name_pn,
                            'image' => $image,
                            'qty' => $order2->qty,
                            'selling_price' => $order2->selling_price,
                            'total_amount' => $order2->total_amount,
                        );
                    }
                    if ($order->is_admin == 1) {
                        $en = "Dairy Mart";
                        $hi = "डेयरी मार्ट";
                        $pn = "ਡੇਅਰੀ ਮਾਰਟ";
                    } else {
                        $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $order->vendor_id))->result();
                        if (!empty($vendor_data)) {
                            $en = $vendor_data[0]->shop_name;
                            $hi = $vendor_data[0]->shop_hi_name;
                            $pn = $vendor_data[0]->shop_pn_name;
                        } else {
                            $en = "Vendor not found";
                            $hi = "विक्रेता नहीं मिला";
                            $pn = "ਵਿਕਰੇਤਾ ਨਹੀਂ ਮਿਲਿਆ";
                        }
                    }
                    $data[] = array(
                        'id' => $order->id,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'en' => $en,
                        'hi' => $hi,
                        'pn' => $pn,
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
    public function ccAvenueWebhook()
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
        // echo $order_status;die();
        if ($order_status === "Success") {
            //============ START PRODUCT SUCCESS ============
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('payment_status', 0);
            $this->db->where('id', $order_id);
            $order_data = $this->db->get()->row();
            if (!empty($order_data)) {
                //---- start calculate invoice number ----
                $now = date('y');
                $next = date('y', strtotime('+1 year'));
                $order1 = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('payment_status' => 1, 'invoice_year' => $now . '-' . $next))->result();
                if (empty($order1)) {
                    $invoice_year = $now . '-' . $next;
                    $invoice_no = 1;
                } else {
                    $invoice_year = $now . '-' . $next;
                    $invoice_no = $order1[0]->invoice_no + 1;
                }
                $data_update = array(
                    'payment_status' => 1,
                    'order_status' => 1,
                    'invoice_year' => $invoice_year,
                    'invoice_no' => $invoice_no,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_order1', $data_update);
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
                if ($order1_data[0]->is_admin == 0) {
                    $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $order1_data[0]->vendor_id))->result();
                    //------ create amount txn in the table -------------
                    if (!empty($vendor_data[0]->comission)) {
                        $amt = $order1_data[0]->total_amount * $vendor_data[0]->comission / 100;
                        $data2 = array(
                            'req_id' => $order_id,
                            'vendor_id' => $order1_data[0]->vendor_id,
                            'cr' =>  $order1_data[0]->total_amount - $amt,
                            'date' => $cur_date
                        );
                        $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                        //------ update vendor account ------
                        $data_update = array(
                            'account' => $vendor_data[0]->account + $order1_data[0]->total_amount - $amt,
                        );
                        $this->db->where('id', $order1_data[0]->vendor_id);
                        $zapak = $this->db->update('tbl_vendor', $data_update);
                    }
                    //------ send notification to vendor -----
                    if (!empty($vendor_data[0]->fcm_token)) {
                        // echo $user_device_tokens->device_token;
                        //success notification code
                        $url = 'https://fcm.googleapis.com/fcm/send';
                        $title = "New Order";
                        $message = "New order #" . $order_id . "  received with the  amount of  ₹" . $order1_data[0]->final_amount;
                        $msg2 = array(
                            'title' => $title,
                            'body' => $message,
                            "sound" => "default"
                        );
                        $fields = array(
                            // 'to'=>"/topics/all",
                            'to' => $vendor_data[0]->fcm_token,
                            'notification' => $msg2,
                            'priority' => 'high'
                        );
                        $fields = json_encode($fields);
                        $headers = array(
                            'Authorization: key=' . "AAAAAIDR4rw:APA91bHaVxhjsODWyIDSiQXCpBhC46GL-9Ycxa9VKwtsPefjLy6NfiiLsajh8db55tRrIOag_A9wh9iXREo2-Obbt1U-fdHmpjy3zvgvTWFleqY5S_8dJtoYz0uKxPRZ76E3sXpgjISv",
                            'Content-Type: application/json'
                        );
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                        $result = curl_exec($ch);
                        // echo $fields;
                        // echo $result;
                        curl_close($ch);
                        //End success notification code
                        $data_insert = array(
                            'vendor_id' => $order1_data[0]->vendor_id,
                            'name' => $title,
                            'dsc' => $message,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_vendor_notification", $data_insert, 1);
                    }
                } else {
                    //--- send email to admin -----------------
                    $config = array(
                        'protocol' => 'SMTP',
                        'smtp_host' => SMTP_HOST,
                        'smtp_port' => SMTP_PORT,
                        'smtp_user' => USER_NAME, // change it to yours
                        'smtp_pass' => PASSWORD, // change it to yours
                        'mailtype' => 'html',
                        'charset' => 'iso-8859-1',
                        'wordwrap' => true
                    );
                    $message2 = '
                         Hello Admin<br/><br/>
                         You have received new Order and below are the details<br/><br/>
                         <b>Order ID</b> - ' . $order_id . '<br/>
                         <b>Amount</b> - Rs.' . $order1_data[0]->final_amount . '<br/>
                           ';
                    $this->load->library('email', $config);
                    $this->email->set_newline("");
                    $this->email->from(EMAIL); // change it to yours
                    $this->email->to(TO, 'Dairy Muneem'); // change it to yours
                    $this->email->subject('New Order received');
                    $this->email->message($message2);
                    if ($this->email->send()) {
                    } else {
                    }
                    $order1_data = $order1_data[0];
                    $user_data = $this->db->get_where('tbl_farmers', array('id' => $order1_data->user_id))->row();
                    //---------- send whatsapp order msg to admin -----
                    $this->send_whatsapp_msg_admin($order1_data, $user_data);
                }
            }
            //============ END PRODUCT SUCCESS ============
            //============ START SUBCRIPTION SUCCESS ============
            $this->db->select('*');
            $this->db->from('tbl_subscription_buy');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $order_id);
            $subcription_data = $this->db->get()->row();
            if (!empty($subcription_data)) {
                $order_id = $subcription_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_subscription_buy', $data_update);
                echo 'Success';
                exit;
            }
            //============ END SUBCRIPTION SUCCESS ============
            //============ START FEED PAYMENT SUCCESS ============
            $this->db->select('*');
            $this->db->from('tbl_check_my_feed_buy');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $order_id);
            $feed_data = $this->db->get()->row();
            if (!empty($feed_data)) {
                $order_id = $feed_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_check_my_feed_buy', $data_update);
                echo 'Success';
                exit;
            }
            //============ END FEED PAYMENT SUCCESS ============
            //============ START DOCTOR PAYMENT SUCCESS ============
            $this->db->select('*');
            $this->db->from('tbl_doctor_req');
            $this->db->where('payment_status', 0);
            $this->db->where('txn_id', $order_id);
            $doc_data = $this->db->get()->row();
            if (!empty($doc_data)) {
                $order_id = $doc_data->id;
                $data_update = array(
                    'payment_status' => 1,
                    'cc_response' => json_encode($decryptValues),
                );
                $this->db->where('id', $order_id);
                $this->db->update('tbl_doctor_req', $data_update);
                $docData = $this->db->get_where('tbl_doctor', array('id' => $doc_data->doctor_id,))->result();
                //------ create amount txn in the table -------------
                if (!empty($docData[0]->commission)) {
                    $amt = $doc_data->fees * $docData[0]->commission / 100;
                    $data2 = array(
                        'req_id' => $order_id,
                        'doctor_id' => $doc_data->doctor_id,
                        'cr' =>  $doc_data->fees - $amt,
                        'date' => $cur_date
                    );
                    $last_id2 = $this->base_model->insert_table("tbl_payment_txn", $data2, 1);
                    //------ update doctor account ------
                    $data_update = array(
                        'account' => $docData[0]->account + $doc_data->fees - $amt,
                    );
                    $this->db->where('id', $doc_data->doctor_id);
                    $zapak = $this->db->update('tbl_doctor', $data_update);
                }
                //------ send notification to doctor -----
                if (!empty($docData[0]->fcm_token)) {
                    // echo $user_device_tokens->device_token;
                    //success notification code
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $title = "New Request";
                    $message = "New request #" . $order_id . "  received with the  amount of  ₹" . ($doc_data->fees - $amt);
                    $msg2 = array(
                        'title' => $title,
                        'body' => $message,
                        "sound" => "default"
                    );
                    $fields = array(
                        // 'to'=>"/topics/all",
                        'to' => $docData[0]->fcm_token,
                        'notification' => $msg2,
                        'priority' => 'high'
                    );
                    $fields = json_encode($fields);
                    $headers = array(
                        'Authorization: key=' . "AAAAAIDR4rw:APA91bHaVxhjsODWyIDSiQXCpBhC46GL-9Ycxa9VKwtsPefjLy6NfiiLsajh8db55tRrIOag_A9wh9iXREo2-Obbt1U-fdHmpjy3zvgvTWFleqY5S_8dJtoYz0uKxPRZ76E3sXpgjISv",
                        'Content-Type: application/json'
                    );
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    $result = curl_exec($ch);
                    // echo $fields;
                    // echo $result;
                    curl_close($ch);
                    //End success notification code
                    $data_insert = array(
                        'doctor_id' => $doc_data->doctor_id,
                        'name' => $title,
                        'dsc' => $message,
                        'date' => $cur_date
                    );
                    $last_id = $this->base_model->insert_table("tbl_doctor_notification", $data_insert, 1);
                }
                echo 'Success';
                exit;
            }
            //============ END DOCTOR PAYMENT SUCCESS ============
        }
    }

    //======================== START ORDER WHATSAPP MESSAGE TO ADMIN  ==========================
    public function send_whatsapp_msg_admin($orderData, $user_data)
    {

        $userName = $user_data->name;
        $payment_type = $orderData->paymnet_type == 1 ? 'Cash On Delivery' : "Online Paymnet";
        $other_details = "NA";
        $order2_data = $this->db->get_where('tbl_order2', array('main_id' => $orderData->id))->result();
        $products_details = '';
        foreach ($order2_data as $order2) {
            $products_details = $products_details . '&product name=' . $$order2->product_name_en .  '*'   .  $order2->qty;
        }
        //---- sending whatspp msg to admin -------
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://whatsapp.fineoutput.com/send_order_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'phone=' . WHATSAPP_NUMBER . '&order_id=' . $orderData->id . '&amount=' . $orderData->final_amount . '&date=' . $orderData->date . '&method=' . $payment_type . '&products=' . $products_details . '&customer_name=' . $userName . '&others=' . $other_details .  '',
            CURLOPT_HTTPHEADER => array(
                'token:' . TOKEN . '',
                'Content-Type:application/x-www-form-urlencoded',
                'Cookie:ci_session=e40e757b02bc2d8fb6f5bf9c5b7bb2ea74c897e8'
            ),
        ));
        $respons = curl_exec($curl);
        curl_close($curl);
        return true;
    }
    //======================== get farmer date ==========================
    public function GetProfile()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            if (!empty($farmer_data[0]->image)) {
                $image = base_url() . $farmer_data[0]->image;
            } else {
                $image = '';
            }
            // // $state_data = $this->db->get_where('all_states', array('id' => $farmer_data[0]->state,))->result();
            // if (!empty($state_data)) {
            //     $state = $state_data[0]->state_name;
            // } else {
            //     $state = '';
            // }
            $data = array(
                'name' => $farmer_data[0]->name,
                'district' => $farmer_data[0]->district,
                'city' => $farmer_data[0]->city,
                'state' => $farmer_data[0]->state,
                'state_id' => $farmer_data[0]->village,
                'phone' => $farmer_data[0]->phone,
                'pincode' => $farmer_data[0]->pincode,
                'image' => $image,
                'no_animals' => $farmer_data[0]->no_animals,
                'gst_no' => $farmer_data[0]->gst_no,
            );
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
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
    //======================== update farmer profile ==========================
    public function UpdateProfile()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('district', 'district', 'required|xss_clean|trim');
            $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
            $this->form_validation->set_rules('village', 'village', 'required|xss_clean|trim');
            //$this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
            //$this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $district = $this->input->post('district');
                $city = $this->input->post('city');
                $village = $this->input->post('village');
                $state = $this->input->post('state');
                $phone = $this->input->post('phone');
                $pincode = $this->input->post('pincode');
                $gst_no = $this->input->post('gst_no');
                $this->load->library('upload');
                $image = '';
                $img1 = 'image';
                if (!empty($_FILES['image'])) {
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/doctor/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "image" . date("YmdHis");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1)) {
                            $upload_error = $this->upload->display_errors();
                            $respone['status'] = false;
                            $respone['message'] = $upload_error;
                            echo json_encode($respone);
                            die();
                        } else {
                            $file_info = $this->upload->data();
                            $image = "assets/uploads/doctor/" . $file_info['file_name'];
                        }
                    }
                }
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1,  'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    $data_update = array(
                        'name' => $name,
                        'district' => $district,
                        'city' => $city,
                        'village' => $village,
                        'state' => $state,
                        //'pincode' => $pincode,
                        //'gst_no' => $gst_no,
                        'image' => $image ? $image : $farmer_data[0]->image,

                    );
                    $this->db->where('id', $farmer_data[0]->id);
                    $zapak = $this->db->update('tbl_farmers', $data_update);
                    $res = array(
                        'message' => "Success",
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
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //======================== delete farmer account ==========================
    public function deleteAccount()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
        if (!empty($farmer_data)) {
            $data_update = array('is_active' => 0);
            $this->db->where('id', $farmer_data->id);
            $zapak = $this->db->update('tbl_farmers', $data_update);
            if (!empty($zapak)) {
                $res = array(
                    'message' => "Account successfully deleted!",
                    'status' => 200,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => 'Some error occurred!!',
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
    //======================== END BOOKING WHATSAPP MESSAGE TO ADMIN ==========================
}
  //=========================================END FarmerController======================================//
