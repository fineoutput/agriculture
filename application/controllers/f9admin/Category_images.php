<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Category_images extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }
    //****************************View _categoryimages Function**************************************
    public function View_categoryimages()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_category_images');
            $data['Categoryimages_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/Category_images/View_categoryimages');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************Insert _categoryimages Function**************************************
    public function add_Categoryimages_data($t, $iw = "")
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
                        $image_upload_folder = FCPATH . "assets/uploads/Category_images/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "Category_images" . date("Ymdhms");
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
                            $image = "assets/uploads/Category_images/" . $new_file_name . $file_info['file_ext'];
                        }
                    } else {
                        $image = '';
                    }
                    //-----------------------image tag end------------------------------------------

                    $idw = base64_decode($iw);
                    $cat_imag = $this->db->get_where('tbl_category_images', array('id' => $idw))->result();
                    if (empty($image)) {
                        $img = $cat_imag[0]->image;
                    } else {
                        $img = $image;
                    }
                    $data_insert = array(
                       
                        'image' => $img

                    );
                  
                    $this->db->where('id', $idw);
                    $last_id = $this->db->update('tbl_category_images', $data_insert);

                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data Updated successfully');
                        redirect("dcadmin/Category_images/view_categoryimages", "refresh");
                    } else {
                        $this->session->set_flashdata('emessage', 'Sorry error occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                
           
        }
    }
    //****************************Update _categoryimages Function**************************************
    public function update_Categoryimages($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_category_images');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['category_images'] = $dsa->row();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/Category_images/add_Categoryimages');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
  
   
    //****************************Upadte _categoryimages Status Function**************************************
    public function updateCategoryimagesStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            if ($t == "active") {
                $data_update = array(
                    'is_active' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_category_images', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/Category_images/View_categoryimages", "refresh");
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t == "inactive") {
                $data_update = array(
                    'is_active' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_category_images', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/Category_images/View_categoryimages", "refresh");
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
}
