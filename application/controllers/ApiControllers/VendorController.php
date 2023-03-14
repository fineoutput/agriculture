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
    //================================ Orders ==========================================
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
                            'product_name' => $order2->product_name,
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
                            'product_name' => $order2->product_name,
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
                            'product_name' => $order2->product_name,
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
                            'product_name' => $order2->product_name,
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
                            'product_name' => $order2->product_name,
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
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $count = $this->db->get_where('tbl_products', array('added_by' => $vendor_data[0]->id, 'is_admin' => 0,))->num_rows();
            $limit = 1;
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
                $data[] = array(
                    'pro_id' => $pro->id,
                    'name_english' => $pro->name_english,
                    'name_hindi' => $pro->name_hindi,
                    'name_punjabi' => $pro->name_punjabi,
                    'description_english' => $pro->description_english,
                    'description_hindi' => $pro->description_hindi,
                    'description_punjabi' => $pro->description_punjabi,
                    'image' => $image,
                    'mrp' => $pro->mrp,
                    'selling_price' => $pro->selling_price,
                    'suffix' => $pro->suffix,
                    'stock' => $stock,
                    'vendor_id' => $pro->added_by,
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
            $this->form_validation->set_rules('selling_price', 'selling_price', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $description = $this->input->post('description');
                $mrp = $this->input->post('mrp');
                $selling_price = $this->input->post('selling_price');
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
                            $new_file_name = "vendor_products" . date("Ymdhms");
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
                                $image = "assets/uploads/vendor_products/" . $new_file_name . $file_info['file_ext'];
                            }
                        }
                    }
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $data_insert = array(
                        'name_english' => $name,
                        'description_english' => $description,
                        'image' => $image,
                        'mrp' => $mrp,
                        'selling_price' => $selling_price,
                        'added_by' => $vendor_data[0]->id,
                        'is_active' => 0,
                        'is_admin' => 0,
                        'date' => $cur_date
                    );
                    $last_id = $this->base_model->insert_table("tbl_products", $data_insert, 1);
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
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
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
            $data = [];
            $data = array(
                'today_orders' => $today_orders,
                'new_orders' => $new_orders,
                'accepted_orders' => $accepted_orders,
                'dispatched_orders' => $dispatched_orders,
                'completed_orders' => $completed_orders,
                'rejected_orders' => $rejected_orders,
                'today_income' =>  round($today_income, 2),
                'total_income' => round($total_income, 2),
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
            if (!empty($vendor_data[0]->aadhar_image)) {
                $image = base_url() . $vendor_data[0]->aadhar_image;
            } else {
                $image = '';
            }
            $data = array(
                'name' => $vendor_data[0]->name,
                'shop_name' => $vendor_data[0]->shop_name,
                'address' => $vendor_data[0]->address,
                'district' => $vendor_data[0]->district,
                'city' => $vendor_data[0]->city,
                'state' => $vendor_data[0]->state,
                'pincode' => $vendor_data[0]->pincode,
                'commission' => $vendor_data[0]->comission,
                'gst_no' => $vendor_data[0]->gst_no,
                'aadhar_image' => $image,
                'pan_number' => $vendor_data[0]->pan_number,
                'phone' => $vendor_data[0]->phone,
                'email' => $vendor_data[0]->email,
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
}
