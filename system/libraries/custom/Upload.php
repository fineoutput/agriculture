<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class CI_Upload
{
    protected $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('form');
        $this->CI->load->model("admin/base_model");
        $this->CI->load->library('upload');
    }

    // ===================== UPLOAD IMAGE =================
    public function UploadImage($image)
    {
        $imagePath = '';
        $file_check=($_FILES[$image]['error']);
        if ($file_check!=4) {
            $image_upload_folder = FCPATH . "assets/uploads/images/";
            if (!file_exists($image_upload_folder)) {
                mkdir($image_upload_folder, DIR_WRITE_MODE, true);
            }
            $new_file_name="image".date("Ymdhms");
            $this->upload_config = array(
                  'upload_path'   => $image_upload_folder,
                  'file_name' => $new_file_name,
                  'allowed_types' =>'jpg|jpeg|png',
                  'max_size'      => 25000
          );
            $this->CI->upload->initialize($this->upload_config);
            if (!$this->CI->upload->do_upload($image)) {
                $upload_error = $this->CI->upload->display_errors();
                $this->CI->session->set_flashdata('emessage', $upload_error);
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $file_info = $this->CI->upload->data();
                $imagePath = "assets/uploads/images/".$new_file_name.$file_info['file_ext'];
            }
        }
        return $imagePath;
    }
}
