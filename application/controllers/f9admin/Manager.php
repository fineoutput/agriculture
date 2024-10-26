<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Manager extends CI_finecontrol
{
    public function add_manager()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->db->select('*');
            $this->db->from('tbl_admin_sidebar');
            // $this->db->where('student_shift',$cvf);
            $data['side'] = $this->db->get();




            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/manager/add_manager');
            $this->load->view('admin/common/footer_view');
        } else {
            $this->load->view('admin/login/index');
        }
    }
    public function add_manager_data()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url', 'security'));
            $this->load->library(array('form_validation', 'upload'));
    
            if ($this->input->post()) {
                $this->form_validation->set_rules('name', 'Name', 'required|xss_clean');
                $this->form_validation->set_rules('address', 'Address', 'required|xss_clean');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean|trim');
    
                // Note: 'images[]' and 'aadhar' are not required fields
                $this->form_validation->set_rules('images[]', 'Images', 'trim|callback_validate_image');
                $this->form_validation->set_rules('aadhar', 'Aadhar', 'trim|xss_clean');
    
                if ($this->form_validation->run() == TRUE) {
                    $name = $this->input->post('name');
                    $phone = $this->input->post('phone');
                    $address = $this->input->post('address');
                    $email = $this->input->post('email');
                    $aadhar = $this->input->post('aadhar');
                    $refer_code = $this->input->post('refer_code');
    
                    $uploaded_file_paths = [];
    
                    if (!empty($_FILES['images']['name'][0])) {
                        $image_upload_folder = FCPATH . "assets/uploads/manager/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
    
                        $files = $_FILES;
                        $file_count = count($_FILES['images']['name']);
    
                        for ($i = 0; $i < $file_count; $i++) {
                            $_FILES['images']['name'] = $files['images']['name'][$i];
                            $_FILES['images']['type'] = $files['images']['type'][$i];
                            $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
                            $_FILES['images']['error'] = $files['images']['error'][$i];
                            $_FILES['images']['size'] = $files['images']['size'][$i];
    
                            $new_file_name = "team" . date("YmdHis") . "_" . $i;
                            $this->upload_config = array(
                                'upload_path' => $image_upload_folder,
                                'file_name' => $new_file_name,
                                'allowed_types' => 'jpg|jpeg|png|gif|bmp',
                                'max_size' => 25000
                            );
                            $this->upload->initialize($this->upload_config);
    
                            if (!$this->upload->do_upload('images')) {
                                $upload_error = $this->upload->display_errors();
                                $this->session->set_flashdata('emessage', $upload_error);
                                redirect($_SERVER['HTTP_REFERER']);
                            } else {
                                $file_info = $this->upload->data();
                                $file_path = "assets/uploads/manager/" . $file_info['file_name'];
                                $uploaded_file_paths[] = $file_path;
                            }
                        }
                    }
    
                    $serialized_file_paths = serialize($uploaded_file_paths);
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
    
                    $data_insert = array(
                        'name' => $name,
                        'phone' => $phone,
                        'address' => $address,
                        'email' => $email,
                        'images' => $serialized_file_paths, // Store the serialized file paths
                        'aadhar' => $aadhar,
                        'refer_code' => $refer_code,
                        'ip' => $ip,
                        'is_active' => 1,
                        'added_by' => $addedby,
                        'date' => $cur_date
                    );
    
                    $last_id = $this->db->insert("tbl_manager", $data_insert, 1);
    
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Manager has been successfully added');
                        redirect("dcadmin/manager/view_manager", "refresh");
                    } else {
                        $this->session->set_flashdata('emessage', 'Error occurred in data insertion, please try again');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $errors = validation_errors();
                    $this->session->set_flashdata('emessage', $errors);
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    
    public function validate_image($str)
    {
        // Check if there are any files in the 'images' input
        if (empty($_FILES['images']['name'][0])) {
            return TRUE; // If no files are present, no validation is needed
        }
    
        // Allowed file types
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    
        // Validate each file
        foreach ($_FILES['images']['name'] as $key => $filename) {
            $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    
            if (!in_array(strtolower($file_ext), $allowed_types)) {
                $this->form_validation->set_message('validate_image', 'The {field} field can only contain image files.');
                return FALSE;
            }
        }
    
        return TRUE;
    }
    
    public function view_manager()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->db->select('*');
            $this->db->from('tbl_manager');
            // $this->db->where('student_shift',$cvf);
            $data['manager_data'] = $this->db->get();




            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/manager/view_manager');
            $this->load->view('admin/common/footer_view');
        } else {
            $this->load->view('admin/login/index');
        }
    }
    public function view_farmers($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {

            $id = base64_decode($idd);



            $this->db->select('*');
            $this->db->from('tbl_farmers');
            $this->db->where('refer_code', $id);
            $data['farmers_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/View_farmers');
            $this->load->view('admin/common/footer_view');
        } else {
            $this->load->view('admin/login/index');
        }
    }
    public function view_doctors($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {

            $id = base64_decode($idd);



            $this->db->select('*');
            $this->db->from('tbl_doctor');
            $this->db->where('refer_code', $id);
            $data['doctor_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/doctor/view_doctor');
            $this->load->view('admin/common/footer_view');
        } else {
            $this->load->view('admin/login/index');
        }
    }
    public function view_vendors($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {

            $id = base64_decode($idd);

           $data['heading'] = 'New';

            $this->db->select('*');
            $this->db->from('tbl_vendor');
            $this->db->where('refer_code', $id);
            $data['vendor_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendor/view_vendor');
            $this->load->view('admin/common/footer_view');
        } else {
            $this->load->view('admin/login/index');
        }
    }

    public function updatemanagerStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);

            $dww = $this->session->userdata('admin_id');

            if ($id == $dww) {
                $this->session->set_flashdata('emessage', "Sorry You can't change status of yourself");
                redirect($_SERVER['HTTP_REFERER']);
            }


            if ($this->load->get_var('position') == "Super Admin") {
                if ($t == "active") {
                    $data_update = array(
                        'is_active' => 1

                    );

                    $this->db->where('id', $id);
                    $zapak = $this->db->update('tbl_manager', $data_update);

                    if ($zapak != 0) {
                        $this->session->set_flashdata('smessage', 'Status successfully Updated');
                        redirect("dcadmin/manager/view_manager", "refresh");
                    } else {
                        $this->session->set_flashdata('emessage', 'Error Occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                if ($t == "inactive") {
                    $data_update = array(
                        'is_active' => 0

                    );

                    $this->db->where('id', $id);
                    $zapak = $this->db->update('tbl_manager', $data_update);

                    if ($zapak != 0) {
                        $this->session->set_flashdata('smessage', 'Status successfully Updated');

                        redirect("dcadmin/manager/view_manager", "refresh");
                    } else {
                        $this->session->set_flashdata('emessage', 'Error Occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            } else {
                $this->session->set_flashdata('emessage', 'Sorry you dont have Permission to change admin, Only Super admin can change status');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function delete_manager($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);

            $dww = $this->session->userdata('admin_id');

            // if ($id==$dww) {
            //     $this->session->set_flashdata('emessage', "Sorry You can't delete yourself");
            //     redirect($_SERVER['HTTP_REFERER']);
            // }

            if ($this->load->get_var('position') == "Super Admin") {
                $zapak = $this->db->delete('tbl_manager', array('id' => $id));
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Successfully deleted');
                    redirect("dcadmin/manager/view_manager", "refresh");
                } else {
                    $this->session->set_flashdata('emessage', 'Error Occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('emessage', "Sorry You Don't Have Permission To Delete Anything.");
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
}
