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
            $this->load->helper(array('form', 'url'));

           
            $this->load->library('form_validation');

            $this->load->helper('security');
            $this->load->library('upload');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('name', 'name', 'required|customAlpha|xss_clean');
                $this->form_validation->set_rules('address', 'address', 'required|customAlpha|xss_clean');
                $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');

                $this->form_validation->set_rules('phone', 'phone', 'xss_clean|min_length[10]|max_length[10]');
             
                $this->form_validation->set_rules('aadhar', 'aadhar', 'xss_clean|trim');


                if ($this->form_validation->run() == true) {
                    $name = $this->input->post('name');
                    $phone = $this->input->post('phone');
                    $address = $this->input->post('address');
                    $email = $this->input->post('email');
                    $aadhar = $this->input->post('aadhar');
                    $refer_code = $this->input->post('refer_code');
                
                    if (!empty($_FILES['images']['name'][0])) {
                        $image_upload_folder = FCPATH . "assets/uploads/manager/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                
                        $files = $_FILES;
                        $file_count = count($_FILES['images']['name']);
                        $uploaded_file_paths = [];
                
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
                                'allowed_types' => '*', // Allow all types of files
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
                
                        // Serialize the uploaded file paths array
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
                            redirect("dcadmin/manager/view_manager", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Error Occurred in data insert, Please try again');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    } else {
                        $this->session->set_flashdata('emessage', validation_errors());
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                 // POST DATA ENDS
                else {
                    $this->session->set_flashdata('emessage', 'No data found, Please insert some data');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } // LOGIN CHECK ENDS HERE

            else {
                redirect("login/admin_login", "refresh");
            }
        }
    }
    public function view_manager()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->db->select('*');
            $this->db->from('tbl_manager');
            // $this->db->where('student_shift',$cvf);
            $data['manager_data']= $this->db->get();




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

            $id=base64_decode($idd);
       


            $this->db->select('*');
            $this->db->from('tbl_farmers');
            $this->db->where('refer_code',$id);
            $data['farmers_data']= $this->db->get();
 
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/View_farmers');
            $this->load->view('admin/common/footer_view');
        } else {
            $this->load->view('admin/login/index');
        }
    }

    public function updatemanagerStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);

            $dww=$this->session->userdata('admin_id');

            if ($id==$dww) {
                $this->session->set_flashdata('emessage', "Sorry You can't change status of yourself");
                redirect($_SERVER['HTTP_REFERER']);
            }


            if ($this->load->get_var('position')=="Super Admin") {
                if ($t=="active") {
                    $data_update = array(
                 'is_active'=>1

         );

                    $this->db->where('id', $id);
                    $zapak=$this->db->update('tbl_manager', $data_update);

                    if ($zapak!=0) {
                        $this->session->set_flashdata('smessage', 'Status successfully Updated');
                        redirect("dcadmin/manager/view_manager", "refresh");
                    } else {
                        $this->session->set_flashdata('emessage', 'Error Occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                }
                if ($t=="inactive") {
                    $data_update = array(
          'is_active'=>0

          );

                    $this->db->where('id', $id);
                    $zapak=$this->db->update('tbl_manager', $data_update);

                    if ($zapak!=0) {
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
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);

            $dww=$this->session->userdata('admin_id');

            // if ($id==$dww) {
            //     $this->session->set_flashdata('emessage', "Sorry You can't delete yourself");
            //     redirect($_SERVER['HTTP_REFERER']);
            // }

            if ($this->load->get_var('position')=="Super Admin") {
                $zapak=$this->db->delete('tbl_manager', array('id' => $id));
                if ($zapak!=0) {
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
