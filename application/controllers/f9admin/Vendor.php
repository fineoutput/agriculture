<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Vendor extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }
    //****************************View Vendor Function**************************************
    public function new_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_vendor');
            $this->db->where('is_approved', 0);
            $data['vendor_data'] = $this->db->get();
            $data['heading'] = "New";
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendor/view_vendor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //================================accepted_vendors=======================\\
    public function accepted_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_vendor');
            $this->db->where('is_approved', 1);
            $data['vendor_data'] = $this->db->get();
            $data['heading'] = "Accepted";
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendor/view_vendor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function rejected_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_vendor');
            $this->db->where('is_approved',2);
            $data['vendor_data'] = $this->db->get();
            $data['heading'] = "Rejected";
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendor/view_vendor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Add Vendor Function**************************************
    // public function add_vendor()
    // {
    //     if (!empty($this->session->userdata('admin_data'))) {
    //         $data['user_name'] = $this->load->get_var('user_name');
    //         $this->db->select('*');
    //         $this->db->from('all_states');
    //         //$this->db->where('id',$usr);
    //         $data['state_data'] = $this->db->get();
    //         $this->db->select('*');
    //         $this->db->from('all_cities');
    //         //$this->db->where('id',$usr);
    //         $data['city_data'] = $this->db->get();
    //         $this->load->view('admin/common/header_view', $data);
    //         $this->load->view('admin/vendor/add_vendor');
    //         $this->load->view('admin/common/footer_view');
    //     } else {
    //         redirect("login/admin_login", "refresh");
    //     }
    // }
    //****************************Insert Vendor Function**************************************
    // public function add_vendor_data($t, $iw = "")
    // {
    //     if (!empty($this->session->userdata('admin_data'))) {
    //         $this->load->helper(array('form', 'url'));
    //         $this->load->library('form_validation');
    //         $this->load->helper('security');
    //         if ($this->input->post()) {
    //             // print_r($this->input->post());
    //             // exit;
    //             $this->form_validation->set_rules('name_english', 'name', 'xss_clean|trim');
    //             $this->form_validation->set_rules('name_hindi', 'name', 'xss_clean|trim');
    //             $this->form_validation->set_rules('name_punjabi', 'name', 'xss_clean|trim');
    //             $this->form_validation->set_rules('shop_name_english', 'name', 'xss_clean|trim');
    //             $this->form_validation->set_rules('shop_name_hindi', 'name', 'xss_clean|trim');
    //             $this->form_validation->set_rules('shop_name_punjabi', 'name', 'xss_clean|trim');
    //             $this->form_validation->set_rules('address_english', 'address', 'required|xss_clean');
    //             $this->form_validation->set_rules('address_hindi', 'address', 'required|xss_clean');
    //             $this->form_validation->set_rules('address_punjabi', 'address', 'required|xss_clean');
    //             $this->form_validation->set_rules('district_english', 'name', 'required|xss_clean|trim');
    //             $this->form_validation->set_rules('district_hindi', 'name', 'required|xss_clean|trim');
    //             $this->form_validation->set_rules('district_punjabi', 'Village', 'required|xss_clean|trim');
    //             $this->form_validation->set_rules('city_colume', 'city', 'required|xss_clean');
    //             $this->form_validation->set_rules('state_colume', 'state', 'required|xss_clean');
    //             $this->form_validation->set_rules('pincode_colume', 'pincode', 'required|xss_clean');
    //             $this->form_validation->set_rules('gst_colume', 'gst no', 'required|xss_clean');
    //             $this->form_validation->set_rules('pan_colume', 'pan number', 'required|xss_clean');
    //             $this->form_validation->set_rules('phone_colume', 'phone number', 'required|xss_clean');
    //             $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');
    //             if ($this->form_validation->run() == TRUE) {
    //                 $name_english = $this->input->post('name_english');
    //                 $name_hindi = $this->input->post('name_hindi');
    //                 $name_punjabi = $this->input->post('name_punjabi');
    //                 $shop_name_english = $this->input->post('shop_name_english');
    //                 $shop_name_hindi = $this->input->post('shop_name_hindi');
    //                 $shop_name_punjabi = $this->input->post('shop_name_punjabi');
    //                 $address_english = $this->input->post('address_english');
    //                 $address_hindi = $this->input->post('address_hindi');
    //                 $address_punjabi = $this->input->post('address_punjabi');
    //                 $district_english = $this->input->post('district_english');
    //                 $district_hindi = $this->input->post('district_hindi');
    //                 $district_punjabi = $this->input->post('district_punjabi');
    //                 $city_colume = $this->input->post('city_colume');
    //                 $state_colume = $this->input->post('state_colume');
    //                 $pincode_colume = $this->input->post('pincode_colume');
    //                 $gst_colume = $this->input->post('gst_colume');
    //                 // $image=$this->input->post('image');
    //                 $pan_colume = $this->input->post('pan_colume');
    //                 $phone_colume = $this->input->post('phone_colume');
    //                 $email = $this->input->post('email');
    //                 //--------------image-----------------------------------
    //                 $this->load->library('upload');
    //                 $image = "";
    //                 $img1 = 'image';
    //                 $file_check = ($_FILES['image']['error']);
    //                 if ($file_check != 4) {
    //                     $image_upload_folder = FCPATH . "assets/uploads/team/";
    //                     if (!file_exists($image_upload_folder)) {
    //                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
    //                     }
    //                     $new_file_name = "team" . date("Ymdhms");
    //                     $this->upload_config = array(
    //                         'upload_path'   => $image_upload_folder,
    //                         'file_name' => $new_file_name,
    //                         'allowed_types' => 'jpg|jpeg|png',
    //                         'max_size'      => 25000
    //                     );
    //                     $this->upload->initialize($this->upload_config);
    //                     if (!$this->upload->do_upload($img1)) {
    //                         $upload_error = $this->upload->display_errors();
    //                         // echo json_encode($upload_error);
    //                         echo $upload_error;
    //                     } else {
    //                         $file_info = $this->upload->data();
    //                         $image = "assets/uploads/team/" . $new_file_name . $file_info['file_ext'];
    //                         $file_info['new_name'] = $image;
    //                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
    //                         $nnnn = $file_info['file_name'];
    //                         // echo json_encode($file_info);
    //                     }
    //                 }
    //                 //--------------------image tag end------------
    //                 $ip = $this->input->ip_address();
    //                 date_default_timezone_set("Asia/Calcutta");
    //                 $cur_date = date("Y-m-d H:i:s");
    //                 $addedby = $this->session->userdata('admin_id');
    //                 $typ = base64_decode($t);
    //                 if ($typ == 1) {
    //                     $data_insert = array(
    //                         'name_english' => $name_english,
    //                         'name_hindi' => $name_hindi,
    //                         'name_punjabi' => $name_punjabi,
    //                         'shop_name_english' => $shop_name_english,
    //                         'shop_name_hindi' => $shop_name_hindi,
    //                         'shop_name_punjabi' => $shop_name_punjabi,
    //                         'address_english' => $address_english,
    //                         'address_hindi' => $address_hindi,
    //                         'address_punjabi' => $address_punjabi,
    //                         'district_english' => $district_english,
    //                         'district_hindi' => $district_hindi,
    //                         'district_punjabi' => $district_punjabi,
    //                         'city' => $city_colume,
    //                         'state' => $state_colume,
    //                         'pincode' => $pincode_colume,
    //                         'gst_no' => $gst_colume,
    //                         'image' => $image,
    //                         'pan_number' => $pan_colume,
    //                         'phone_number' => $phone_colume,
    //                         'email' => $email,
    //                         'ip' => $ip,
    //                         'added_by' => $addedby,
    //                         'is_active' => 1,
    //                         'date' => $cur_date
    //                     );
    //                     $last_id = $this->base_model->insert_table("tbl_vendor", $data_insert, 1);
    //                 }
    //                 if ($typ == 2) {
    //                     $idw = base64_decode($iw);
    //                     $data_insert = array(
    //                         'name_english' => $name_english,
    //                         'name_hindi' => $name_hindi,
    //                         'name_punjabi' => $name_punjabi,
    //                         'shop_name_english' => $shop_name_english,
    //                         'shop_name_hindi' => $shop_name_hindi,
    //                         'shop_name_punjabi' => $shop_name_punjabi,
    //                         'address_english' => $address_english,
    //                         'address_hindi' => $address_hindi,
    //                         'address_punjabi' => $address_punjabi,
    //                         'district_english' => $district_english,
    //                         'district_hindi' => $district_hindi,
    //                         'district_punjabi' => $district_punjabi,
    //                         'city' => $city_colume,
    //                         'state' => $state_colume,
    //                         'pincode' => $pincode_colume,
    //                         'gst_no' => $gst_colume,
    //                         'image' => $image,
    //                         'pan_number' => $pan_colume,
    //                         'phone_number' => $phone_colume,
    //                         'email' => $email
    //                     );
    //                     $this->db->where('id', $idw);
    //                     $last_id = $this->db->update('tbl_vendor', $data_insert);
    //                 }
    //                 if ($last_id != 0) {
    //                     $this->session->set_flashdata('smessage', 'Data inserted successfully');
    //                     redirect("dcadmin/vendor/view_vendor", "refresh");
    //                 } else {
    //                     $this->session->set_flashdata('emessage', 'Sorry error occured');
    //                     redirect($_SERVER['HTTP_REFERER']);
    //                 }
    //             } else {
    //                 $this->session->set_flashdata('emessage', validation_errors());
    //                 redirect($_SERVER['HTTP_REFERER']);
    //             }
    //         } else {
    //             $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
    //             redirect($_SERVER['HTTP_REFERER']);
    //         }
    //     } else {
    //         redirect("login/admin_login", "refresh");
    //     }
    // }
    //****************************Delete Vendor Function**************************************
    // public function delete_vendor($idd)
    // {
    //     if (!empty($this->session->userdata('admin_data'))) {
    //         $data['user_name'] = $this->load->get_var('user_name');
    //         $id = base64_decode($idd);
    //         if ($this->load->get_var('position') == "Super Admin") {
    //             $zapak = $this->db->delete('tbl_vendor', array('id' => $id));
    //             if ($zapak != 0) {
    //                 redirect("dcadmin/vendor/view_vendor", "refresh");
    //             } else {
    //                 echo "Error";
    //                 exit;
    //             }
    //         } else {
    //             $data['e'] = "Sorry You Don't Have Permission To Delete Anything.";
    //             // exit;
    //             $this->load->view('errors/error500admin', $data);
    //         }
    //     } else {
    //         $this->load->view('admin/login/index');
    //     }
    // }
    //****************************Update Vendor Status Function**************************************
    public function updateVendorStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($t == "reject") {
                $data_update = array(
                    'is_approved' => 2
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_vendor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t == "approve") {
                $data_update = array(
                    'is_approved' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_vendor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
            if ($t == "inactive") {
                $data_update = array(
                    'is_active' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_vendor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
            if ($t == "active") {
                $data_update = array(
                    'is_active' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_vendor', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    //****************************Update Vendor Function**************************************
    public function update_vendor($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_vendor');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['vendor'] = $dsa->row();
            $this->db->select('*');
            $this->db->from('all_cities');
            //$this->db->where('id',$usr);
            $data['city_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('all_states');
            //$this->db->where('id',$usr);
            $data['state_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendor/update_vendor');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Set comission Vendor Function**************************************
    public function set_comission_vendor($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_vendor');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['vendor'] = $dsa->row();
            $data['user_name'] = $this->load->get_var('user_name');
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendor/set_comission');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Insert comission Vendor Function**************************************
    public function add_vendor_data2($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('set_comission', 'set_comission', 'xss_clean');
                if ($this->form_validation->run() == TRUE) {
                    $set_comission = $this->input->post('set_comission');
                    $id = base64_decode($idd);
                    $data['id'] = $idd;
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $data_update = array(
                        'comission' => $set_comission,
                    );
                    $this->db->where('id', $id);
                    $last_id = $this->db->update('tbl_vendor', $data_update);
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data updated successfully');
                        redirect("dcadmin/vendor/accepted_vendors", "refresh");
                    } else {
                        $this->session->set_flashdata('emessage', 'Sorry error occured');
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
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
}
