<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Subcategory_images extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }
    //****************************View SibCategoey Function**************************************
    public function View_subcategoryimages()
    {
       
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_subcategory_images');
            $data['subCategoryimages_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/Subcategory_images/View_subcategoryimages');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************Insert slider Function**************************************
    public function add_subcategoryimages_data($t, $iw = "")
    {
       
        if (!empty($this->session->userdata('admin_data'))) {
           
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
           
            
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    //------------------------------------image insert-----------------------------------------
                    $image = "";
                    $img1 = 'image';
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/Subcategory_images/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "Subcategory_images" . date("YmdHis");
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
                            // echo $upload_error;
                            $this->session->set_flashdata('emessage', $upload_error);
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $file_info = $this->upload->data();
                            $image = "assets/uploads/Subcategory_images/" . $file_info['file_name'];
                        }
                    } else {
                        $image = '';
                    }
                    //-----------------------image tag end------------------------------------------
                    //------------------------------------image Hindi insert-----------------------------------------
                    $image_hindi = "";
                    $img1_hindi = 'image_hindi';
                    $file_check = ($_FILES['image_hindi']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/Subcategory_images/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "Subcategory_images2" . date("YmdHis");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1_hindi)) {
                            $upload_error = $this->upload->display_errors();
                            // echo json_encode($upload_error);
                            // echo $upload_error;
                            $this->session->set_flashdata('emessage', $upload_error);
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $file_info = $this->upload->data();
                            $image_hindi = "assets/uploads/Subcategory_images/" . $file_info['file_name'];
                        }
                    } else {
                        $image_hindi = '';
                    }
                    //-----------------------image Hindi  tag end------------------------------------------
                    //------------------------------------image Punjabi insert-----------------------------------------
                    $image_punjabi = "";
                    $img1_punjabi = 'image_punjabi';
                    $file_check = ($_FILES['image_punjabi']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/Subcategory_images/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "Subcategory_images3" . date("YmdHis");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1_punjabi)) {
                            $upload_error = $this->upload->display_errors();
                            // echo json_encode($upload_error);
                            // echo $upload_error;
                            $this->session->set_flashdata('emessage', $upload_error);
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $file_info = $this->upload->data();
                            $image_punjabi = "assets/uploads/Subcategory_images/" . $file_info['file_name'];
                        }
                    } else {
                        $image_punjabi = '';
                    }
                    //-----------------------image Punjani  tag end------------------------------------------
                    

                    $idw = base64_decode($iw);
                    $cat_imag = $this->db->get_where('tbl_subcategory_images', array('id' => $idw))->result();
                    if (empty($image)) {
                        $img = $cat_imag[0]->image;
                    } else {
                        $img = $image;
                    }
                    if (empty($image_punjabi)) {
                        $img_punjabi = $cat_imag[0]->image_punjabi;
                    } else {
                        $img_punjabi = $image_punjabi;
                    }
                    if (empty($image_hindi)) {
                        $img_hindi = $cat_imag[0]->image_hindi;
                    } else {
                        $img_hindi = $image_hindi;
                    }
                    $data_insert = array(
                       
                        'image' => $img,
                        'image_hindi' => $img_hindi,
                        'image_punjabi' => $img_punjabi

                    );
                  
                    $this->db->where('id', $idw);
                    $last_id = $this->db->update('tbl_subcategory_images', $data_insert);

                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data Updated successfully');
                        redirect("dcadmin/Subcategory_images/view_subcategoryimages", "refresh");
                    } else {
                        $this->session->set_flashdata('emessage', 'Sorry error occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                
           
        }
    }
    //****************************Update slider Function**************************************
    public function update_subcategoryimages($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_subcategory_images');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['subcategory_images'] = $dsa->row();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/Subcategory_images/update_subcategoryimages');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
  
   
   
}
