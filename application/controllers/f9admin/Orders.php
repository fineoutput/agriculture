<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Orders extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }

    public function view_new_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where("order_status", 1);
            $this->db->order_by("id", "desc");
            $data['orders_data']= $this->db->get();

            $data['heading'] = "New Orders";

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/orders/view_orders');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }


    public function view_accept_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 2);
            $this->db->order_by("id", "desc");
            $data['orders_data']= $this->db->get();

            $data['heading'] = "Accepted Orders";

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/orders/view_orders');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }



    public function view_dispatched_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 3);
            $this->db->order_by("id", "desc");
            $data['orders_data']= $this->db->get();

            $data['heading'] = "Dispatched Orders";
            $data['status'] = 3;


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/orders/view_orders');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //-------update trackung ----------
    public function update_tracking_view($id)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['id'] = $id;

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/orders/update_tracking');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //------------- update tracking data -- ----------
    public function update_tracking_data()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('id', 'id', 'required|xss_clean|trim');
                $this->form_validation->set_rules('tracking_url', 'tracking_url', 'required|xss_clean|trim');
                $this->form_validation->set_rules('tracking_no', 'tracking_no', 'required|xss_clean|trim');


                if ($this->form_validation->run()== true) {
                    $id=base64_decode($this->input->post('id'));
                    $tracking_url=$this->input->post('tracking_url');
                    $tracking_no=$this->input->post('tracking_no');

                    $data_update = array(
                      'tracking_url'=>$tracking_url,
                      'tracking_no'=>$tracking_no,
                                );
                    $this->db->where('id', $id);
                    $zapak=$this->db->update('tbl_order1', $data_update);
                    if (!empty($zapak)) {
                        $this->session->set_flashdata('smessage', 'Order status successfully Updated');

                        redirect("dcadmin/Orders/view_dispatched_orders");
                    } else {
                        $this->session->set_flashdata('emessage', 'Some error occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $this->session->set_flashdata('emessage', validation_errors());
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
                redirect($_SERVER['HTTP_REFERER']);
            }


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/dash');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function view_completed_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 4);
            $this->db->order_by("id", "desc");
            $data['orders_data']= $this->db->get();

            $data['heading'] = "Completed Orders";


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/orders/view_orders');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function view_rejected_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');


            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 5);
            $this->db->order_by("id", "desc");
            $data['orders_data']= $this->db->get();

            $data['heading'] = "Rejected Orders";


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/orders/view_orders');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function view_cancelled_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');


            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 6);
            $this->db->order_by("id", "desc");
            $data['orders_data']= $this->db->get();

            $data['heading'] = "Rejected Orders";


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/orders/view_orders');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }


    public function update_order_status($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            $id=base64_decode($idd);

            //-----accept------

            if ($t=="accept") {
                $data_update = array(
'order_status'=>2

);
                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_order1', $data_update);

                if ($zapak!=0) {
                    $this->db->select('*');
                    $this->db->from('tbl_order1');
                    $this->db->where('id', $id);
                    $user_details= $this->db->get()->row();

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
                    $to=$user_details->email;
                    $data['name']= $user_details->name;
                    $data['email']= $user_details->email;
                    $data['phone']= $user_details->phone;
                    $data['order1_id']= $id;
                    $data['date']= $user_details->date;



                    $message =$this->load->view('email/orderaccept', $data, true);
                    // print_r($message);
                    // exit;

                    $this->load->library('email', $config);
                    $this->email->set_newline("");
                    $this->email->from(EMAIL); // change it to yours
                  $this->email->to($to);// change it to yours
                  $this->email->subject('Order Placed');
                    $this->email->message($message);
                    if ($this->email->send()) {
                        // echo 'Email sent.';
                    } else {
                        show_error($this->email->print_debugger());
                    }

                    $this->session->set_flashdata('smessage', 'Order status successfully Updated');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }

            //-----dispatch------

            if ($t=="dispatch") {
                $data_update = array(
            'order_status'=>3

            );

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_order1', $data_update);

                if ($zapak!=0) {
                    $this->db->select('*');
                    $this->db->from('tbl_order1');
                    $this->db->where('id', $id);
                    $user_details= $this->db->get()->row();

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
                    $to=$user_details->email;
                    $data['name']= $user_details->name;
                    $data['email']= $user_details->email;
                    $data['phone']= $user_details->phone;
                    $data['order1_id']= $id;
                    $data['date']= $user_details->date;



                    $message =$this->load->view('email/orderdispatch', $data, true);
                    // print_r($message);
                    // exit;

                    $this->load->library('email', $config);
                    $this->email->set_newline("");
                    $this->email->from(EMAIL); // change it to yours
                  $this->email->to($to);// change it to yours
                  $this->email->subject('Order Placed');
                    $this->email->message($message);
                    if ($this->email->send()) {
                        // echo 'Email sent.';
                    } else {
                        show_error($this->email->print_debugger());
                    }
                    $this->session->set_flashdata('smessage', 'Order status successfully Updated');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }

            //--------delivered---------
            if ($t=="delivered") {
                $data_update = array(
'order_status'=>4

);

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_order1', $data_update);

                if ($zapak!=0) {
                    $this->db->select('*');
                    $this->db->from('tbl_order1');
                    $this->db->where('id', $id);
                    $user_details= $this->db->get()->row();

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
                    $to=$user_details->email;
                    $data['name']= $user_details->name;
                    $data['email']= $user_details->email;
                    $data['phone']= $user_details->phone;
                    $data['order1_id']= $id;
                    $data['date']= $user_details->date;



                    $message =$this->load->view('email/orderdelivered', $data, true);
                    // print_r($message);
                    // exit;

                    $this->load->library('email', $config);
                    $this->email->set_newline("");
                    $this->email->from(EMAIL); // change it to yours
                  $this->email->to($to);// change it to yours
                  $this->email->subject('Order Placed');
                    $this->email->message($message);
                    if ($this->email->send()) {
                        // echo 'Email sent.';
                    } else {
                        show_error($this->email->print_debugger());
                    }
                    $this->session->set_flashdata('smessage', 'Order status successfully Updated');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }

            //-----cancel----------
            if ($t=="reject") {
                $data_update = array(
'order_status'=>5
);

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_order1', $data_update);



                if ($zapak!=0) {
                    $this->session->set_flashdata('smessage', 'Order status successfully Updated');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }



    public function view_product_details($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            $id=base64_decode($idd);

            $this->db->select('*');
            $this->db->from('tbl_order2');
            $this->db->where('main_id', $id);
            $data['order2_data']= $this->db->get();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/orders/order_details');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function view_order_bill($main_id)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('id', base64_decode($main_id));
            $data['order1_data']= $this->db->get()->row();

            $this->db->select('*');
            $this->db->from('tbl_order2');
            $this->db->where('main_id', base64_decode($main_id));
            $data['order2_data']= $this->db->get();

            //$this->load->view('admin/common/header_view',$data);
            $this->load->view('admin/orders/order_bill', $data);
        //$this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
}
