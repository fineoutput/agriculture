<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class VendorController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
    }
    public function CreatePagination($page_index, $pages)
    {
        $pagination = [];
        $i = $page_index - 2;
        if ($i <= 0) {
            $i = 1;
        }
        $s = 1;
        for ($i; $i <= $pages; $i++) {
            if ($s == 6) {
                break;
            }
            if ($i == $page_index) {
                $pagination[] = array('index' => $i, 'status' => 'active');
            } else {
                $pagination[] = array('index' => $i, 'status' => 'inactive');
            }
            $s++;
        }
        return $pagination;
    }
    //================================ Orders ==========================================
    //====================================== NewOrders =================================//
    public function NewOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $count = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 1))->num_rows();
            $limit = 20;
            if (!empty($page_index)) {
                $start = ($page_index - 1) * $limit;
            } else {
                $start = 0;
            }
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('is_admin', 0);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 1);
            $this->db->order_by('id', 'desc');
            $this->db->limit($limit, $start);
            $OrderData = $this->db->get();
            $pages = round($count / $limit);
            $pagination = $this->CreatePagination($page_index, $pages);
            //     print_r($pagination);
            //     die();
            // echo $pages;die(); 
            // if(!empty($para['search'])){
            // $this->db->like(20, $start);
            // }
            // $OrderData = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 1))->result();
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData->result() as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('main_id' => $order->id))->num_rows();
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
                            'product_name' => $order2->product_name_en ? $order2->product_name_en : '',
                            'image' => $image,
                            'qty' => $order2->qty,
                            'selling_price' => $order2->selling_price,
                            'total_amount' => $order2->total_amount,
                        );
                    }
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $order->name,
                        'farmer_phone' => $order->phone,
                        'farmer_address' => $order->address,
                        'farmer_city' => $order->city,
                        'farmer_state' => $order->state,
                        'farmer_district' => $order->district,
                        'farmer_pincode' => $order->pincode,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'pro_count' => $pro_count,
                        'date' => $newDate->format('d/m/Y'),
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'details' => $details
                    );
                }
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                    'pagination' => $pagination,
                    'last' => $pages,
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
    //================================= AcceptedOrders ================================//
    public function AcceptedOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $count = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 6))->num_rows();
            $limit = 20;
            if (!empty($page_index)) {
                $start = ($page_index - 1) * $limit;
            } else {
                $start = 0;
            }
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('is_admin', 0);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 2);
            $this->db->order_by('id', 'desc');
            $this->db->limit($limit, $start);
            $OrderData = $this->db->get();
            $pages = round($count / $limit);
            $pagination = $this->CreatePagination($page_index, $pages);
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData->result() as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();
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
                            'product_name' => $order2->product_name_en ? $order2->product_name_en : '',
                            'image' => $image,
                            'qty' => $order2->qty,
                            'selling_price' => $order2->selling_price,
                            'total_amount' => $order2->total_amount,
                        );
                    }
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'pro_count' => $pro_count,
                        'date' => $newDate->format('d/m/Y'),
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'details' => $details
                    );
                }
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                    'pagination' => $pagination,
                    'last' => $pages,
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
    //============================== DispatchedOrders =================================//
    public function DispatchedOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $count = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 6))->num_rows();
            $limit = 20;
            if (!empty($page_index)) {
                $start = ($page_index - 1) * $limit;
            } else {
                $start = 0;
            }
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('is_admin', 0);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 3);
            $this->db->order_by('id', 'desc');
            $this->db->limit($limit, $start);
            $OrderData = $this->db->get();
            $pages = round($count / $limit);
            $pagination = $this->CreatePagination($page_index, $pages);
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData->result() as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();
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
                            'product_name' => $order2->product_name_en ? $order2->product_name_en : '',
                            'image' => $image,
                            'qty' => $order2->qty,
                            'selling_price' => $order2->selling_price,
                            'total_amount' => $order2->total_amount,
                        );
                    }
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'pro_count' => $pro_count,
                        'date' => $newDate->format('d/m/Y'),
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'details' => $details
                    );
                }
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                    'pagination' => $pagination,
                    'last' => $pages,
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
    //========================= CompletedOrders ====================================//
    public function CompletedOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $count = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 6))->num_rows();
            $limit = 20;
            if (!empty($page_index)) {
                $start = ($page_index - 1) * $limit;
            } else {
                $start = 0;
            }
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('is_admin', 0);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 4);
            $this->db->order_by('id', 'desc');
            $this->db->limit($limit, $start);
            $OrderData = $this->db->get();
            $pages = round($count / $limit);
            $pagination = $this->CreatePagination($page_index, $pages);
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData->result() as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();
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
                            'product_name' => $order2->product_name_en ? $order2->product_name_en : '',
                            'image' => $image,
                            'qty' => $order2->qty,
                            'selling_price' => $order2->selling_price,
                            'total_amount' => $order2->total_amount,
                        );
                    }
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'pro_count' => $pro_count,
                        'date' => $newDate->format('d/m/Y'),
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'details' => $details
                    );
                }
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                    'pagination' => $pagination,
                    'last' => $pages,
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
    //============================== RejectedOrders ===============================//
    public function RejectedOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $count = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 6))->num_rows();
            $limit = 20;
            if (!empty($page_index)) {
                $start = ($page_index - 1) * $limit;
            } else {
                $start = 0;
            }
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('is_admin', 0);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 6);
            $this->db->order_by('id', 'desc');
            $this->db->limit($limit, $start);
            $OrderData = $this->db->get();
            $pages = round($count / $limit);
            $pagination = $this->CreatePagination($page_index, $pages);
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData->result() as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();
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
                            'product_name' => $order2->product_name_en ? $order2->product_name_en : '',
                            'image' => $image,
                            'qty' => $order2->qty,
                            'selling_price' => $order2->selling_price,
                            'total_amount' => $order2->total_amount,
                        );
                    }
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'pro_count' => $pro_count,
                        'final_amount' => $order->final_amount,
                        'date' => $newDate->format('d/m/Y'),
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'details' => $details
                    );
                }
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                    'pagination' => $pagination,
                    'last' => $pages,
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
    //========================== Update Order Status ===============================//
    public function UpdateOrderStatus()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('status', 'status', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $id = $this->input->post('id');
                $status = $this->input->post('status');
                $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                //----- Verify Auth --------
                if (!empty($vendor_data)) {
                    $zapak = '';
                    if ($status == "accept") {
                        $data_update = array(
                            'order_status' => 2
                        );
                        $this->db->where('vendor_id', $vendor_data[0]->id); //vendor orders
                        $this->db->where('is_admin', 0); //vendor orders
                        $this->db->where('id', $id);
                        $zapak = $this->db->update('tbl_order1', $data_update);
                    }
                    if ($status == "dispatch") {
                        $data_update = array(
                            'order_status' => 3
                        );
                        $this->db->where('vendor_id', $vendor_data[0]->id); //vendor orders
                        $this->db->where('is_admin', 0); //vendor orders
                        $this->db->where('id', $id);
                        $zapak = $this->db->update('tbl_order1', $data_update);
                    }
                    if ($status == "complete") {
                        $data_update = array(
                            'order_status' => 4
                        );
                        $this->db->where('vendor_id', $vendor_data[0]->id); //vendor orders
                        $this->db->where('is_admin', 0); //vendor orders
                        $this->db->where('id', $id);
                        $zapak = $this->db->update('tbl_order1', $data_update);
                    }
                    if ($status == "reject") {
                        $data_update = array('order_status' => 6);
                        $this->db->where('vendor_id', $vendor_data[0]->id); //vendor orders
                        $this->db->where('is_admin', 0); //vendor orders
                        $this->db->where('id', $id);
                        $zapak = $this->db->update('tbl_order1', $data_update);
                        //-------update inventory-------
                        $this->db->select('*');
                        $this->db->from('tbl_order2');
                        $this->db->where('main_id', $id);
                        $data_order2 = $this->db->get();
                        foreach ($data_order2->result() as $data) {
                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('id', $data->product_id);
                            $pro_data = $this->db->get()->row();
                            if (!empty($pro_data)) {
                                $update_inv = $pro_data->inventory + $data->qty;
                                $data_update = array('inventory' => $update_inv);
                                $this->db->where('id', $pro_data->id);
                                $this->db->where('added_by', $vendor_data[0]->id); //vendor orders
                                $this->db->where('is_admin', 0); //vendor orders
                                $zapak2 = $this->db->update('tbl_products', $data_update);
                            }
                        }
                    }
                    if (!empty($zapak)) {
                        $res = array(
                            'message' => "Status updated successfully!",
                            'status' => 200,
                        );
                        echo json_encode($res);
                    } else {
                        $res = array(
                            'message' => "Some error occurred!",
                            'status' => 201,
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
    //================================ Payments ==========================================
    //============================================= PaymentInfo ============================================//
    public function PaymentInfo()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $this->db->select('*');
            $this->db->from('tbl_payment_txn');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('req_id is NOT NULL', NULL, FALSE);
            $this->db->order_by('id', 'desc');
            $this->db->limit(20);
            $txn_data = $this->db->get();
            $data = [];
            foreach ($txn_data->result() as $txn) {
                $newDate = new DateTime($txn->date);
                $data[] = array(
                    'req_id' => $txn->req_id,
                    'cr' => $txn->cr,
                    'date' => $newDate->format('d/m/Y'),
                );
            }
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
                'account' => $vendor_data[0]->account,
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
    //============================= AdminPaymentInfo =====================================//
    public function AdminPaymentInfo()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $this->db->select('*');
            $this->db->from('tbl_payments_req');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->order_by('id', 'desc');
            $this->db->limit(20);
            $txn_data = $this->db->get();
            $data = [];
            foreach ($txn_data->result() as $txn) {
                $newDate = new DateTime($txn->date);
                if ($txn->status == 0) {
                    $status = 'Pending';
                    $bg_color = '#65bcd7';
                } elseif ($txn->status == 1) {
                    $status = 'Completed';
                    $bg_color = '#139c49';
                } elseif ($txn->status == 2) {
                    $status = 'Rejected';
                    $bg_color = '#dc4c64';
                }
                $data[] = array(
                    'req_id' => $txn->id,
                    'amount' => $txn->amount,
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
                'message' => 'Permission Denied!',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //============================= VenReqPayment =====================================//
    public function VenReqPayment()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('amount', 'amount', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $amount = $this->input->post('amount');
                $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($vendor_data)) {
                    if ($amount > $vendor_data[0]->account) {
                        $res = array(
                            'message' => 'Amount should be less than to your wallet amount!',
                            'status' => 201
                        );
                        echo json_encode($res);
                        die();
                    }
                    $reqData = $this->db->get_where('tbl_payments_req', array('status' => 0, 'vendor_id' => $vendor_data[0]->id,))->result();
                    if (empty($reqData)) {
                        date_default_timezone_set("Asia/Calcutta");
                        $cur_date = date("Y-m-d H:i:s");
                        $data_insert = array(
                            'vendor_id' => $vendor_data[0]->id,
                            'available' => $vendor_data[0]->account,
                            'amount' => $amount,
                            'status' => 0,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_payments_req", $data_insert, 1);
                        //--- send email to admin -----------------
                        $config = array(
                            'protocol' => 'smtp',
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
                            You have received new payment request from a vendor and below are the details<br/><br/>
                            <b>Vendor ID</b> - ' . $vendor_data[0]->id . '<br/>
                            <b>Vendor Name</b> - ' . $vendor_data[0]->name . '<br/>
                            <b>Shop Name</b> - ' . $vendor_data[0]->shop_name . '<br/>
                            <b>Request ID</b> - ' . $last_id . '<br/>
                            <b>Available Balance</b> - ₹' . $vendor_data[0]->account . '<br/>
                            <b>Requested Amount</b> - ₹' . $amount . '<br/>
                              ';
                        $this->load->library('email', $config);
                        $this->email->set_newline("");
                        $this->email->from(EMAIL); // change it to yours
                        $this->email->to(TO, 'Dairy Muneem'); // change it to yours
                        $this->email->subject('New payment request received from a vendor');
                        $this->email->message($message2);
                        if ($this->email->send()) {
                        } else {
                        }
                        $res = array(
                            'message' => "Success",
                            'status' => 200,
                        );
                        echo json_encode($res);
                    } else {
                        $res = array(
                            'message' => "Can not submit more than one request!",
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
    //================================ Products ==========================================
    //============================= VendorProducts =====================================//
    public function VendorProducts()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $page_index = $headers['Index'];
        $search = $this->input->get('search');
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            if (empty($search)) {
                $count = $this->db->get_where('tbl_products', array('added_by' => $vendor_data[0]->id, 'is_admin' => 0,))->num_rows();
            } else {
                $this->db->select('*');
                $this->db->from('tbl_products');
                $this->db->where('added_by',  $vendor_data[0]->id);
                $this->db->where('is_admin', 0);
                $this->db->where("(name_english LIKE '%" . $search . "%' OR name_hindi LIKE '%" . $search . "%' OR name_punjabi LIKE '%" . $search . "%')", NULL, FALSE);
                $count = $this->db->count_all_results();
            }
            $limit = 20;
            if (!empty($page_index)) {
                $start = ($page_index - 1) * $limit;
            } else {
                $start = 0;
            }
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('added_by', $vendor_data[0]->id);
            $this->db->where('is_admin', 0);
            $this->db->order_by('id', 'desc');
            $this->db->limit($limit, $start);
            if (!empty($search)) {
                $this->db->where("(name_english LIKE '%" . $search . "%' OR name_hindi LIKE '%" . $search . "%' OR name_punjabi LIKE '%" . $search . "%')", NULL, FALSE);
            }
            $ProData = $this->db->get();
            $pages = round($count / $limit);
            $pagination = $this->CreatePagination($page_index, $pages);
            $data = [];
            foreach ($ProData->result() as $pro) {
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
                if ($pro->is_active == 0) {
                    $status = 'Inactive';
                    $bg_color = '#ffc30e';
                } else {
                    $status = 'Active';
                    $bg_color = '#139c49';
                }
                $data[] = array(
                    'pro_id' => $pro->id,
                    'name_english' => $pro->name_english,
                    'name_hindi' => $pro->name_hindi,
                    'name_punjabi' => $pro->name_punjabi,
                    'description_english' => $pro->description_english,
                    'description_hindi' => $pro->description_hindi,
                    'description_punjabi' => $pro->description_punjabi,
                    'image' => $image,
                    'min_qty' => $pro->min_qty ? $pro->min_qty : 1,
                    'mrp' => $pro->mrp,
                    'selling_price' => $pro->selling_price,
                    'suffix' => $pro->suffix,
                    'stock' => $stock,
                    'percent' => $percent,
                    'inventory' => $pro->inventory,
                    'vendor_id' => $pro->added_by,
                    'is_active' => $pro->is_active,
                    'status' => $status,
                    'bg_color' => $bg_color,
                    'is_admin' => $pro->is_admin
                );
            }
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
                'pagination' => $pagination,
                'last' => $pages,
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
    //============================= AddVendorsProduct =====================================//
    public function AddVendorsProduct()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('description', 'description', 'required|xss_clean|trim');
            $this->form_validation->set_rules('mrp', 'mrp', 'xss_clean|trim');
            $this->form_validation->set_rules('pro_id', 'pro_id', 'xss_clean|trim');
            $this->form_validation->set_rules('selling_price', 'selling_price', 'required|xss_clean|trim');
            $this->form_validation->set_rules('inventory', 'Inventory', 'required|xss_clean|trim');
            $this->form_validation->set_rules('is_active', 'is active', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $description = $this->input->post('description');
                $mrp = $this->input->post('mrp');
                $selling_price = $this->input->post('selling_price');
                $inventory = $this->input->post('inventory');
                $pro_id = $this->input->post('pro_id');
                $is_active = $this->input->post('is_active');
                $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($vendor_data)) {
                    $this->load->library('upload');
                    $image = '';
                    $img1 = 'image';
                    if (!empty($_FILES['image'])) {
                        $file_check = ($_FILES['image']['error']);
                        if ($file_check != 4) {
                            $image_upload_folder = FCPATH . "assets/uploads/vendor_products/";
                            if (!file_exists($image_upload_folder)) {
                                mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                            }
                            $new_file_name = "vendor_products" . date("YmdHis");
                            $this->upload_config = array(
                                'upload_path'   => $image_upload_folder,
                                'file_name' => $new_file_name,
                                'allowed_types' => 'jpg|jpeg|png',
                                'max_size'      => 25000
                            );
                            $this->upload->initialize($this->upload_config);
                            if (!$this->upload->do_upload($img1)) {
                                $upload_error = $this->upload->display_errors();
                                $res = array(
                                    'message' => 'Image format is not supported!',
                                    'status' => 201
                                );
                                echo json_encode($res);
                                die();
                            } else {
                                $file_info = $this->upload->data();
                                $image = "assets/uploads/vendor_products/" . $file_info['file_name'];
                            }
                        }
                    }
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    if (empty($pro_id)) {
                        $data_insert = array(
                            'name_english' => $name,
                            'description_english' => $description,
                            'image' => $image,
                            'mrp' => $mrp,
                            'min_qty' => 1,
                            'selling_price' => $selling_price,
                            'added_by' => $vendor_data[0]->id,
                            'is_active' => $is_active,
                            'inventory' => $inventory,
                            'is_admin' => 0,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_products", $data_insert, 1);
                    } else {
                        $pro_data = $this->db->get_where('tbl_products', array('id' => $pro_id))->result();
                        $data_update = array(
                            'name_english' => $name,
                            'description_english' => $description,
                            'image' => $image ? $image : $pro_data[0]->image,
                            'mrp' => $mrp,
                            'min_qty' => 1,
                            'inventory' => $inventory,
                            'selling_price' => $selling_price,
                            'is_active' => $is_active,
                        );
                        $this->db->where('id', $pro_id);
                        $zapak = $this->db->update('tbl_products', $data_update);
                    }
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
    //============================= HomeData =====================================//
    public function HomeData()
    {
        $headers = $this->input->request_headers();
        if (array_key_exists("Fcm_token", $headers)) {
            $fcm_token = $headers['Fcm_token'];
        } else {
            $fcm_token = '';
        }
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //update fcm_token
        if (!empty($fcm_token) && $fcm_token != $vendor_data[0]->fcm_token) {
            $data_updatev = array(
                'fcm_token' => $fcm_token,
            );
            $this->db->where('id', $vendor_data[0]->id);
            $zapakv = $this->db->update('tbl_vendor', $data_updatev);
        }
        //----- Verify Auth --------
        $cur_date = date("Y-m-d");
        if (!empty($vendor_data)) {
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('payment_status', 1);
            $this->db->where('is_admin', 0);
            $this->db->like("date", $cur_date);
            $today_orders = $this->db->count_all_results();
            //-------------
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 1);
            $this->db->where('is_admin', 0);
            $new_orders = $this->db->count_all_results();
            //-------------
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 2);
            $this->db->where('is_admin', 0);
            $accepted_orders = $this->db->count_all_results();
            //-------------
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 3);
            $this->db->where('is_admin', 0);
            $dispatched_orders = $this->db->count_all_results();
            //-------------
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 4);
            $this->db->where('is_admin', 0);
            $completed_orders = $this->db->count_all_results();
            //-------------
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('payment_status', 1);
            $this->db->where('order_status', 6);
            $this->db->where('is_admin', 0);
            $rejected_orders = $this->db->count_all_results();
            //-------------
            $this->db->select_sum('cr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('req_id is NOT NULL', NULL, FALSE);
            $this->db->like("date", $cur_date);
            $query = $this->db->get();
            if (!empty($query->row()->cr)) {
                $today_income = $query->row()->cr;
            } else {
                $today_income = 0;
            }
            //-------------
            $this->db->select_sum('cr');
            $this->db->from('tbl_payment_txn');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $this->db->where('req_id is NOT NULL', NULL, FALSE);
            $query2 = $this->db->get();
            if (!empty($query2->row()->cr)) {
                $total_income = $query2->row()->cr;
            } else {
                $total_income = 0;
            }
            $vendorSlider_data = $this->db->get_where('tbl_vendorslider', array('is_active' => 1))->result();
            $data = [];
            $vendor_slider = [];
            foreach ($vendorSlider_data as $slider) {
                if (!empty($slider->image)) {
                    $image = base_url() . $slider->image;
                } else {
                    $image = '';
                }
                $vendor_slider[] = array('image' => $image);
            }
            //---- vendor notification data -------
            $vendor_nft = [];
            $vendornotification_datas = $this->db->get_where('tbl_vendor_notification', array('vendor_id' => $vendor_data[0]->id))->result();
            foreach ($vendornotification_datas as $vendornotification_data) {
                $newDate = new DateTime($vendornotification_data->date);
                $vendor_nft[] = array(
                    'id' => $vendornotification_data->id,
                    'name' => $vendornotification_data->name,
                    'image' => $vendornotification_data->image ? base_url() . $vendornotification_data->image : '',
                    'description' => $vendornotification_data->dsc,
                    'date' => $newDate->format('d-m-y, g:i a'),
                );
            }
            $this->db->select('*');
            $this->db->from('tbl_vendor_notification');
            $this->db->where('vendor_id', $vendor_data[0]->id);
            $count_vendor = $this->db->count_all_results();
            $data = array(
                'today_orders' => $today_orders,
                'new_orders' => $new_orders,
                'accepted_orders' => $accepted_orders,
                'dispatched_orders' => $dispatched_orders,
                'completed_orders' => $completed_orders,
                'rejected_orders' => $rejected_orders,
                'today_income' =>  round($today_income, 2),
                'total_income' => round($total_income, 2),
                'vendor_slider' => $vendor_slider,
                'notification_data' => $vendor_nft,
                'notification_count' => $count_vendor
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
    //============================================= GetProfile ============================================//
    public function GetProfile()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            if (!empty($vendor_data[0]->image)) {
                $image = base_url() . $vendor_data[0]->image;
            } else {
                $image = '';
            }
            $state_data = $this->db->get_where('all_states', array('id' => $vendor_data[0]->state,))->result();
            if (!empty($state_data)) {
                $state = $state_data[0]->state_name;
            } else {
                $state = '';
            }
            $data = array(
                'name' => $vendor_data[0]->name,
                'shop_name' => $vendor_data[0]->shop_name,
                'address' => $vendor_data[0]->address,
                'district' => $vendor_data[0]->district,
                'city' => $vendor_data[0]->city,
                'state' => $state,
                'state_id' => $vendor_data[0]->state,
                'pincode' => $vendor_data[0]->pincode,
                'commission' => $vendor_data[0]->comission,
                'gst_no' => $vendor_data[0]->gst_no,
                'aadhar_no' => $vendor_data[0]->aadhar_no,
                'image' => $image,
                'pan_number' => $vendor_data[0]->pan_number,
                'phone' => $vendor_data[0]->phone,
                'email' => $vendor_data[0]->email,
                'bank_name' => $vendor_data[0]->bank_name,
                'bank_phone' => $vendor_data[0]->bank_phone,
                'bank_ac' => $vendor_data[0]->bank_ac,
                'ifsc' => $vendor_data[0]->ifsc,
                'upi' => $vendor_data[0]->upi,
                'latitude' => $vendor_data[0]->latitude,
                'longitude' => $vendor_data[0]->longitude,
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
    //============================= updateBankInfo =====================================//
    public function updateBankInfo()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('bank_name', 'bank_name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('bank_phone', 'bank_phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('bank_ac', 'bank_ac', 'required|xss_clean|trim');
            $this->form_validation->set_rules('ifsc', 'ifsc', 'required|xss_clean|trim');
            $this->form_validation->set_rules('upi', 'upi', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $bank_name = $this->input->post('bank_name');
                $bank_phone = $this->input->post('bank_phone');
                $bank_ac = $this->input->post('bank_ac');
                $ifsc = $this->input->post('ifsc');
                $upi = $this->input->post('upi');
                $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($vendor_data)) {
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $data_update = array(
                        'bank_name' => $bank_name,
                        'bank_phone' => $bank_phone,
                        'bank_ac' => $bank_ac,
                        'ifsc' => $ifsc,
                        'upi' => $upi,
                    );
                    $this->db->where('id', $vendor_data[0]->id);
                    $zapak = $this->db->update('tbl_vendor', $data_update);
                    if (!empty($zapak)) {
                        $res = array(
                            'message' => "Success",
                            'status' => 200,
                        );
                        echo json_encode($res);
                    } else {
                        $res = array(
                            'message' => "Some error occurred!",
                            'status' => 201,
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
    //============================= updateBankInfo =====================================//
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
            $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
            $this->form_validation->set_rules('pincode', 'pincode', 'xss_clean|trim');
            $this->form_validation->set_rules('shop_name', 'shop_name', 'xss_clean|trim');
            $this->form_validation->set_rules('address', 'address', 'xss_clean|trim');
            $this->form_validation->set_rules('gst_no', 'gst_no', 'xss_clean|trim');
            $this->form_validation->set_rules('aadhar_no', 'aadhar_no', 'xss_clean|trim');
            $this->form_validation->set_rules('pan_no', 'pan_no', 'xss_clean|trim');
            $this->form_validation->set_rules('email', 'email', 'xss_clean|trim');
            $this->form_validation->set_rules('latitude', 'Latitude', 'xss_clean|trim');
            $this->form_validation->set_rules('longitude', 'Longitude', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $district = $this->input->post('district');
                $city = $this->input->post('city');
                $state = $this->input->post('state');
                $pincode = $this->input->post('pincode');
                $shop_name = $this->input->post('shop_name');
                $address = $this->input->post('address');
                $gst_no = $this->input->post('gst_no');
                $aadhar_no = $this->input->post('aadhar_no');
                $pan_no = $this->input->post('pan_no');
                $email = $this->input->post('email');
                $latitude = $this->input->post('latitude');
                $longitude = $this->input->post('longitude');
                $this->load->library('upload');
                $image = '';
                $img1 = 'image';
                if (!empty($_FILES['image'])) {
                    if ($_FILES['image']['size'] != 0 && $_FILES['image']['error'] == 0) {
                        $file_check = ($_FILES['image']['error']);
                        if ($file_check != 4) {
                            $image_upload_folder = FCPATH . "assets/uploads/UpdateProfile/";
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
                                $image = "assets/uploads/UpdateProfile/" . $file_info['file_name'];
                            }
                        }
                    }
                }
                $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
                if (!empty($vendor_data)) {
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $data_update = array(
                        'name' => $name,
                        'district' => $district,
                        'city' => $city,
                        'state' => $state,
                        'pincode' => $pincode,
                        'shop_name' => $shop_name,
                        'address' => $address,
                        'gst_no' => $gst_no,
                        'aadhar_no' => $aadhar_no,
                        'pan_number' => $pan_no,
                        'email' => $email,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'image' => $image ? $image : $vendor_data[0]->image,
                    );
                    $this->db->where('id', $vendor_data[0]->id);
                    $zapak = $this->db->update('tbl_vendor', $data_update);
                    if (!empty($zapak)) {
                        $res = array(
                            'message' => "Success",
                            'status' => 200,
                        );
                        echo json_encode($res);
                    } else {
                        $res = array(
                            'message' => "Some error occurred!",
                            'status' => 201,
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
    //------------------------------deleteAccount ---------------
    public function deleteAccount()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->row();
        if (!empty($vendor_data)) {
            $data_update = array('is_active' => 0);
            $this->db->where('id', $vendor_data->id);
            $zapak = $this->db->update('tbl_vendor', $data_update);
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
}
