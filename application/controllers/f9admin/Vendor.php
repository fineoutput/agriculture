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
            $this->db->order_by('id', 'desc');
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
            $this->db->order_by('id', 'desc');
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
            $this->db->where('is_approved', 2);
            $this->db->order_by('id', 'desc');
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
    // ****************************Insert Vendor Function**************************************
    public function add_vendor_data($t, $iw = "")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('hi_name', 'hi_name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pn_name', 'pn_name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('shop_name', 'shop_name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('shop_hi_name', 'shop_hi_name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('shop_pn_name', 'shop_pn_name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('address', 'address', 'required|xss_clean');
                $this->form_validation->set_rules('hi_address', 'hi_address', 'required|xss_clean');
                $this->form_validation->set_rules('pn_address', 'pn_address', 'required|xss_clean');
                $this->form_validation->set_rules('district', 'district', 'required|xss_clean|trim');
                $this->form_validation->set_rules('hi_district', 'hi_district', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pn_district', 'pn_district', 'required|xss_clean|trim');
                $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
                $this->form_validation->set_rules('hi_city', 'hi_city', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pn_city', 'pn_city', 'required|xss_clean|trim');
                $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
                $this->form_validation->set_rules('gst_no', 'gst_no', 'xss_clean|trim');
                $this->form_validation->set_rules('aadhar_no', 'aadhar_no', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pan_number', 'pan_number', 'required|xss_clean|trim');
                $this->form_validation->set_rules('phone', 'phone number', 'required|xss_clean|trim');
                $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');
                if ($this->form_validation->run() == TRUE) {
                    $name = $this->input->post('name');
                    $hi_name = $this->input->post('hi_name');
                    $pn_name = $this->input->post('pn_name');
                    $shop_name = $this->input->post('shop_name');
                    $shop_hi_name = $this->input->post('shop_hi_name');
                    $shop_pn_name = $this->input->post('shop_pn_name');
                    $address = $this->input->post('address');
                    $hi_address = $this->input->post('hi_address');
                    $pn_address = $this->input->post('pn_address');
                    $district = $this->input->post('district');
                    $hi_district = $this->input->post('hi_district');
                    $pn_district = $this->input->post('pn_district');
                    $city = $this->input->post('city');
                    $hi_city = $this->input->post('hi_city');
                    $pn_city = $this->input->post('pn_city');
                    $state = $this->input->post('state');
                    $pincode = $this->input->post('pincode');
                    $gst_no = $this->input->post('gst_no');
                    $aadhar_no = $this->input->post('aadhar_no');
                    $pan_number = $this->input->post('pan_number');
                    $phone = $this->input->post('phone');
                    $email = $this->input->post('email');
                    //--------------image-----------------------------------
                    $this->load->library('upload');
                    $image = "";
                    $img1 = 'image';
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/vendor/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "vendor" . date("YmdHis");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1)) {
                            $upload_error = $this->upload->display_errors();
                            // echo json_encode($upload_error);
                            echo $upload_error;
                        } else {
                            $file_info = $this->upload->data();
                            $image = "assets/uploads/vendor/" . $file_info['file_name'];
                            $file_info['new_name'] = $image;
                            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                            $nnnn = $file_info['file_name'];
                            // echo json_encode($file_info);
                        }
                    }
                    //--------------------image tag end------------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $typ = base64_decode($t);
                    if ($typ == 1) {
                        $data_insert = array(
                            'name_english' => $name_english,
                            'name_hindi' => $name_hindi,
                            'name_punjabi' => $name_punjabi,
                            'shop_name_english' => $shop_name_english,
                            'shop_name_hindi' => $shop_name_hindi,
                            'shop_name_punjabi' => $shop_name_punjabi,
                            'address_english' => $address_english,
                            'address_hindi' => $address_hindi,
                            'address_punjabi' => $address_punjabi,
                            'district_english' => $district_english,
                            'district_hindi' => $district_hindi,
                            'district_punjabi' => $district_punjabi,
                            'city' => $city_colume,
                            'state' => $state_colume,
                            'pincode' => $pincode_colume,
                            'gst_no' => $gst_colume,
                            'image' => $image,
                            'pan_number' => $pan_colume,
                            'phone_number' => $phone_colume,
                            'email' => $email,
                            'ip' => $ip,
                            'added_by' => $addedby,
                            'is_active' => 1,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_vendor", $data_insert, 1);
                    }
                    if ($typ == 2) {
                        $idw = base64_decode($iw);
                        $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $idw,))->result();
                        if (empty($image)) {
                            $image = $vendor_data[0]->image;
                        }
                        $data_insert = array(
                            'name' => $name,
                            'hi_name' => $hi_name,
                            'pn_name' => $pn_name,
                            'shop_name' => $shop_name,
                            'shop_hi_name' => $shop_hi_name,
                            'shop_pn_name' => $shop_pn_name,
                            'address' => $address,
                            'hi_address' => $hi_address,
                            'pn_address' => $pn_address,
                            'district' => $district,
                            'hi_district' => $hi_district,
                            'pn_district' => $pn_district,
                            'city' => $city,
                            'hi_city' => $hi_city,
                            'pn_city' => $pn_city,
                            'state' => $state,
                            'pincode' => $pincode,
                            'gst_no' => $gst_no,
                            'aadhar_no' => $aadhar_no,
                            'pan_number' => $pan_number,
                            'phone' => $phone,
                            'email' => $email,
                            'image' => $image,
                        );
                        $this->db->where('id', $idw);
                        $last_id = $this->db->update('tbl_vendor', $data_insert);
                    }
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data updated successfully');
                        redirect("dcadmin/Vendor/accepted_vendors", "refresh");
                    } else {
                        $this->session->set_flashdata('emessage', 'Sorry error occurred');
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
    //****************************Delete Vendor Function**************************************
    public function delete_vendor($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($this->load->get_var('position') == "Super Admin") {
                $zapak = $this->db->delete('tbl_vendor', array('id' => $id));
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Data deleted successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            } else {
                $data['e'] = "Sorry You Don't Have Permission To Delete Anything.";
                // exit;
                $this->load->view('errors/error500admin', $data);
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
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
