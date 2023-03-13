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
        $this->load->library('pagination');
    }
    //============================================= NewOrders ============================================//
    public function NewOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $OrderData = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 1))->result();
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();
                    $newDate = new DateTime($order->date);
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'pro_count' => $pro_count,
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
    //============================================= AcceptedOrders ============================================//
    public function AcceptedOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $OrderData = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 2))->result();
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();

                    $newDate = new DateTime($order->date);
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'pro_count' => $pro_count,
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
    //============================================= AcceptedOrders ============================================//
    public function DispatchedOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $OrderData = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 3))->result();
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();

                    $newDate = new DateTime($order->date);
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'pro_count' => $pro_count,
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
    //============================================= completedOrders ============================================//
    public function completedOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $OrderData = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 4))->result();
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();

                    $newDate = new DateTime($order->date);
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'final_amount' => $order->final_amount,
                        'pro_count' => $pro_count,
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
    //============================================= RejectedOrders ============================================//
    public function RejectedOrders()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 1, 'is_approved' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($vendor_data)) {
            $OrderData = $this->db->order_by('id', 'desc')->get_where('tbl_order1', array('vendor_id' => $vendor_data[0]->id, 'is_admin' => 0, 'payment_status' => 1, 'order_status' => 6))->result();
            $data = [];
            if (!empty($OrderData)) {
                foreach ($OrderData as $order) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $order->farmer_id))->result();
                    $pro_count = $this->db->get_where('tbl_order2', array('id' => $order->id))->num_rows();

                    $newDate = new DateTime($order->date);
                    $data[] = array(
                        'id' => $order->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'charges' => $order->charges,
                        'total_amount' => $order->total_amount,
                        'pro_count' => $pro_count,
                        'final_amount' => $order->final_amount,
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
}
