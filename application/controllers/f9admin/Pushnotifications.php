<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Pushnotifications extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }
    //===============================VIEW PUSHNOTIFICATIONS=========================//
    public function view_pushnotifications()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_pushnotifications');
            $this->db->order_by('id', 'desc');
            $data['pushnotifications_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/pushnotifications/view_pushnotifications');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //===============================ADD PUSHNOTIFICATIONS=========================//
    public function add_pushnotifications()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->view('admin/common/header_view');
            $this->load->view('admin/pushnotifications/add_pushnotifications');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //=============================ADD PUSHNOTIFICATIONS DATA=========================//
    public function add_pushnotifications_data($t, $iw = "")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('title', 'title', 'required');
                $this->form_validation->set_rules('App', 'App', 'required');
                $this->form_validation->set_rules('content', 'content', 'trim');
                if ($this->form_validation->run() == true) {
                    $title = $this->input->post('title');
                    $content = $this->input->post('content');
                    $App = $this->input->post('App');
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $typ = base64_decode($t);
                    $last_id = 0;
                    if ($typ == 1) {
                        $img0 = 'image';
                        $nnnn0 = '';
                        $image_upload_folder = FCPATH . "assets/uploads/pushnotifications/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "Pushnotifications" . date("Ymdhms");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img0)) {
                            $upload_error = $this->upload->display_errors();
                        } else {
                            $file_info = $this->upload->data();
                            $videoNAmePath = "assets/uploads/pushnotifications/" . $new_file_name . $file_info['file_ext'];
                            $file_info['new_name'] = $videoNAmePath;
                            $nnnn = $file_info['file_name'];
                            $nnnn0 = $videoNAmePath;
                        }
                        $data_insert = array(
                            'title' => $title,
                            'App' => $App,
                            'image' => $nnnn0,
                            'content' => $content,
                            'ip' => $ip,
                            'added_by' => $addedby,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_pushnotifications", $data_insert, 1);
                        if ($App == 1) {
                            $to = "/topics/DairyMuneemVendor";
                        } else {
                            $to = "/topics/DairyMuneemFarmer";
                        }
                        if ($last_id != 0) {
                            // ----sent push notification to user---------
                            $url = 'https://fcm.googleapis.com/fcm/send';
                            $msg2 = array(
                                'title' => $title,
                                'body' => $content,
                                'image' => base_url() . $nnnn0,
                                "sound" => "default"
                            );
                            $fields = array(
                                'to' => $to,
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
                            curl_close($ch);
                            $this->session->set_flashdata('smessage', 'Push notification inserted successfully');
                            redirect("dcadmin/Pushnotifications/view_pushnotifications", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occured');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                } else {
                    $this->session->set_flashdata('emessage', validation_errors());
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
}
