<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Slider extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }
    //****************************View slider Function**************************************
    public function View_slider()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_slider');
            $data['slider_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/slider/View_slider');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Add slider Function**************************************
    public function add_slider()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/slider/add_slider');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Insert slider Function**************************************
    public function add_slider_data($t, $iw = "")
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
                $image_upload_folder = FCPATH . "assets/uploads/slider/";
                if (!file_exists($image_upload_folder)) {
                    mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                }
                $new_file_name = "category" . date("Ymdhms");
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
                    $image = "assets/uploads/slider/" . $new_file_name . $file_info['file_ext'];
                }
            }
            //-----------------------image tag end------------------------------------------
            $typ = base64_decode($t);
            if ($typ == 1) {
                $data_insert = array(
                    'image' => $image,
                    'ip' => $ip,
                    'added_by' => $addedby,
                    'is_active' => 1,
                    'date' => $cur_date
                );
                $last_id = $this->base_model->insert_table("tbl_slider", $data_insert, 1);
            }
            if ($typ == 2) {
                $idw = base64_decode($iw);
                $slide = $this->db->get_where('tbl_slider', array('id' => $idw))->result();
                if (empty($image)) {
                    $image = $slide[0]->image;
                }
                $data_insert = array(
                    'image' => $image
                );
                $this->db->where('id', $idw);
                $last_id = $this->db->update('tbl_slider', $data_insert);
            }
            if ($last_id != 0) {
                $this->session->set_flashdata('smessage', 'Data inserted successfully');
                redirect("dcadmin/Slider/View_slider", "refresh");
            } else {
                $this->session->set_flashdata('smessage', 'Sorry error occured');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->set_flashdata('smessage', validation_errors());
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //****************************Update slider Function**************************************
    public function update_slider($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_slider');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['slider'] = $dsa->row();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/slider/update_slider');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Delete slider Function**************************************
    public function delete_slider($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($this->load->get_var('position') == "Super Admin") {
                $zapak = $this->db->delete('tbl_slider', array('id' => $id));
                if ($zapak != 0) {
                    redirect("dcadmin/Slider/View_slider", "refresh");
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
    //****************************Upadte slider Status Function**************************************
    public function updatesliderStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            if ($t == "active") {
                $data_update = array(
                    'is_active' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_slider', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/Slider/View_slider", "refresh");
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
                $zapak = $this->db->update('tbl_slider', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/Slider/View_slider", "refresh");
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
