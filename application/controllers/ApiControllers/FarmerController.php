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
    public function GetCart()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($farmer_data)) {
            $CartData = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->result();
            $data=[];
            $total =0;
            if (!empty($CartData)) {
                foreach ($CartData as $cart) {
                    if ($cart->is_admin == 1) {
                        //---admin products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    } else {
                        //---vendor products ----
                        $ProData = $this->db->get_where('tbl_products', array('is_active' => 1, 'id' => $cart->product_id))->result();
                    }
                    $ProData=$ProData[0];
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
                        $total += $ProData->selling_price *$cart->qty;
                        $data[] = array(
                            'cart_id' => $cart->id,
                            'pro_id' => $ProData->id,
                            'name_english' => $ProData->name_english,
                            'name_hindi' => $ProData->name_hindi,
                            'name_punjabi' => $ProData->name_punjabi,
                            'description_english' => $ProData->description_english,
                            'description_hindi' => $ProData->description_hindi,
                            'description_punjabi' => $ProData->description_punjabi,
                            'image' => $image,
                            // 'mrp' => $ProData->mrp,
                            'selling_price' => $ProData->selling_price,
                            // 'suffix' => $ProData->suffix,
                            'stock' => $stock,
                            'vendor_id' => $ProData->added_by,
                            'is_admin' => $cart->is_admin,
                            'qty' => $cart->qty,
                        );
                    } else {
                        $this->db->delete('tbl_cart', array('farmer_id' => $farmer_data[0]->id, 'product_id' => $cart->product_id));
                    }
                }
                $count = $this->db->get_where('tbl_cart', array('farmer_id' => $farmer_data[0]->id))->num_rows();
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                    'count' => $count,
                    'total'=>$total
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
}
  //=========================================END FarmerController======================================//
