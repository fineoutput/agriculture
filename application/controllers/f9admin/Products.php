<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Products extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }
    //****************************View Products Function**************************************
    public function View_products()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('is_admin', 1);
            $data['products_data'] = $this->db->get();
            $data['is_admin'] = 1;
            $data['heading'] = 'Admin';
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/View_products');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************View Products Function**************************************
    public function vendor_pending_products()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('is_admin', 0);
            $this->db->where('is_approved', 0);
            $data['products_data'] = $this->db->get();
            $data['is_admin'] = 0;
            $data['heading'] = 'Vendor Pending';
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/View_products');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************View Products Function**************************************
    public function vendor_accepted_products()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('is_admin', 0);
            $this->db->where('is_approved', 1);
            $data['products_data'] = $this->db->get();
            $data['is_admin'] = 0;
            $data['heading'] = 'Vendor Accepted';
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/View_products');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Add Products Function**************************************
    public function add_products()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/add_products');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Insert Products Function**************************************
    public function add_products_data($t, $iw = "")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->library('upload');

            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('name_english', 'name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('name_hindi', 'name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('name_punjabi', 'name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('description_english', 'description', 'required|xss_clean|trim');
                $this->form_validation->set_rules('description_hindi', 'description', 'required|xss_clean|trim');
                $this->form_validation->set_rules('description_punjabi', 'description', 'required|xss_clean|trim');
                $this->form_validation->set_rules('mrp', 'mrp', 'required|xss_clean|trim');
                $this->form_validation->set_rules('selling_price', 'selling_price', 'required|xss_clean|trim');
                $this->form_validation->set_rules('gst', 'gst', 'required|xss_clean|trim');
                $this->form_validation->set_rules('gst_price', 'gst_price', 'required|xss_clean|trim');
                $this->form_validation->set_rules('selling_price_wo_gst', 'selling_price_wo_gst', 'required|xss_clean|trim');
                $this->form_validation->set_rules('inventory', 'inventory', 'required|xss_clean|trim');
                $this->form_validation->set_rules('suffix', 'suffix', 'required|xss_clean|trim');
                $this->form_validation->set_rules('tranding_products', 'Tranding products', 'required|xss_clean|trim');
                $this->form_validation->set_rules('min_qty', 'min_qty', 'required|xss_clean|trim');
                $this->form_validation->set_rules('offer', 'Offer', 'xss_clean|trim');
                if ($this->form_validation->run() == TRUE) {
                    $name_english = $this->input->post('name_english');
                    $name_hindi = $this->input->post('name_hindi');
                    $name_punjabi = $this->input->post('name_punjabi');
                    $description_english = $this->input->post('description_english');
                    $description_hindi = $this->input->post('description_hindi');
                    $description_punjabi = $this->input->post('description_punjabi');
                    $mrp = $this->input->post('mrp');
                    $selling_price = $this->input->post('selling_price');
                    $gst = $this->input->post('gst');
                    $gst_price = $this->input->post('gst_price');
                    $selling_price_wo_gst = $this->input->post('selling_price_wo_gst');
                    $inventory = $this->input->post('inventory');
                    $suffix = $this->input->post('suffix');
                    $min_qty = $this->input->post('min_qty');
                    $tranding_products = $this->input->post('tranding_products');
                    $offer = $this->input->post('offer');
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    //------------------------------------image insert-----------------------------------------
                    // $this->load->library('upload');
                    // $img1 = 'image';
                    // $image = "";
                    // $file_check = ($_FILES['image']['error']);
                    // if ($file_check != 4) {
                    //     $image_upload_folder = FCPATH . "assets/uploads/admin_products/";
                    //     if (!file_exists($image_upload_folder)) {
                    //         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                    //     }
                    //     $new_file_name = "image" . date("YmdHis");
                    //     $this->upload_config = array(
                    //         'upload_path'   => $image_upload_folder,
                    //         'file_name' => $new_file_name,
                    //         'allowed_types' => 'jpg|jpeg|png',
                    //         'max_size'      => 25000
                    //     );
                    //     $this->upload->initialize($this->upload_config);
                    //     if (!$this->upload->do_upload($img1)) {
                    //         $upload_error = $this->upload->display_errors();
                    //         // echo json_encode($upload_error);
                    //         echo $upload_error;
                    //     } else {
                    //         $file_info = $this->upload->data();
                    //         $image = "assets/uploads/admin_products/" . $file_info['file_name'];
                    //         $file_info['new_name'] = $image;
                    //         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                    //         $nnnn = $file_info['file_name'];
                    //         // echo json_encode($file_info);
                    //     }
                    // }
                    $images = [];
                    $files = $_FILES['images'];
                    $file_count = count($files['name']);
                    
                    for ($i = 0; $i < $file_count; $i++) {
                        if ($files['error'][$i] != 4) { // Check if the file is actually uploaded
                            $image_upload_folder = FCPATH . "assets/uploads/admin_products/";
                            if (!file_exists($image_upload_folder)) {
                                mkdir($image_upload_folder, 0755, true);
                            }
                
                            $new_file_name = "image_" . date("YmdHis") . "_{$i}";
                            $_FILES['image']['name'] = $files['name'][$i];
                            $_FILES['image']['type'] = $files['type'][$i];
                            $_FILES['image']['tmp_name'] = $files['tmp_name'][$i];
                            $_FILES['image']['error'] = $files['error'][$i];
                            $_FILES['image']['size'] = $files['size'][$i];
                
                            $this->upload_config = [
                                'upload_path'   => $image_upload_folder,
                                'file_name'     => $new_file_name,
                                'allowed_types' => 'jpg|jpeg|png|gif|bmp|tiff|webp|web',
                                'max_size'      => 2500000
                            ];
                
                            $this->upload->initialize($this->upload_config);
                
                            if (!$this->upload->do_upload('image')) {
                                $upload_error = $this->upload->display_errors();
                                echo $upload_error; // Handle the error appropriately in your application
                            } else {
                                $file_info = $this->upload->data();
                                $image_path = "assets/uploads/admin_products/" . $file_info['file_name'];
                                $images[] = $image_path;
                            }
                        }
                    }

                    $video = '';
                    if ($_FILES['video']['error'] != 4) {
                        $video_upload_folder = FCPATH . "assets/uploads/admin_products/";
                        if (!file_exists($video_upload_folder)) {
                            mkdir($video_upload_folder, 0755, true);
                        }
                
                        $new_file_name = "video_" . date("YmdHis");
                        $this->upload_config = [
                            'upload_path'   => $video_upload_folder,
                            'file_name'     => $new_file_name,
                            'allowed_types' => 'mp4|avi|mov|wmv|mkv|flv|webm',
                            'max_size'      => 102400 // 100MB
                        ];
                
                        $this->upload->initialize($this->upload_config);
                
                        if (!$this->upload->do_upload('video')) {
                            $upload_error = $this->upload->display_errors();
                            echo $upload_error; // Handle the error appropriately in your application
                        } else {
                            $file_info = $this->upload->data();
                            $video = "assets/uploads/admin_products/" . $file_info['file_name'];
                        }
                    }
                    //-----------------------image tag end------------------------------------------
                    $typ = base64_decode($t);
                    $image_paths = json_encode($images);
                    if ($typ == 1) {
                        $data_insert = array(
                            'name_english' => $name_english,
                            'name_hindi' => $name_hindi,
                            'name_punjabi' => $name_punjabi,
                            'description_english' => $description_english,
                            'description_hindi' => $description_hindi,
                            'description_punjabi' => $description_punjabi,
                            'images' => $image_paths,
                            'video' => $video,
                            'mrp' => $mrp,
                            'selling_price' => $selling_price,
                            'gst' => $gst,
                            'min_qty' => $min_qty,
                            'gst_price' => $gst_price,
                            'selling_price_wo_gst' => $selling_price_wo_gst,
                            'inventory' => $inventory,
                            'suffix' => $suffix,
                            'tranding_products' => $tranding_products,
                            'offer' => $offer,
                            'ip' => $ip,
                            'added_by' => $addedby,
                            'is_active' => 1,
                            'is_admin' => 1,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_products", $data_insert, 1);
                    }
                    if ($typ == 2) {
                        $idw = base64_decode($iw);
                        $pro_data = $this->db->get_where('tbl_products', array('id' => $idw))->result();
                        if (empty($image_paths)) {
                            $image_paths = $pro_data[0]->images;
                        }
                        $data_insert = array(
                            'name_english' => $name_english,
                            'name_hindi' => $name_hindi,
                            'name_punjabi' => $name_punjabi,
                            'description_english' => $description_english,
                            'description_hindi' => $description_hindi,
                            'description_punjabi' => $description_punjabi,
                            'images' => $image_paths,
                            'video' => $video,
                            'mrp' => $mrp,
                            'selling_price' => $selling_price,
                            'gst' => $gst,
                            'gst_price' => $gst_price,
                            'min_qty' => $min_qty,
                            'selling_price_wo_gst' => $selling_price_wo_gst,
                            'inventory' => $inventory,
                            'suffix' => $suffix,
                            'tranding_products' => $tranding_products,
                            'offer' => $offer
                        );
                        $this->db->where('id', $idw);
                        $last_id = $this->db->update('tbl_products', $data_insert);
                    }
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data inserted successfully');
                        redirect("dcadmin/Products/View_products", "refresh");
                    } else {
                        $this->session->set_flashdata('smessage', 'Sorry error occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $this->session->set_flashdata('smessage', validation_errors());
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('smessage', 'Please insert some data, No data available');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Update Products Function**************************************
    public function update_products($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['products'] = $dsa->row();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/update_products');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Delete Products Function**************************************
    public function delete_products($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($this->load->get_var('position') == "Super Admin") {
                $zapak = $this->db->delete('tbl_products', array('id' => $id));
                if ($zapak != 0) {
                    redirect("dcadmin/Products/View_products", "refresh");
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
    //****************************Upadte Products Status Function**************************************
    public function updateproductsStatus($idd, $t)
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
                $zapak = $this->db->update('tbl_products', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/Products/View_products", "refresh");
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
                $zapak = $this->db->update('tbl_products', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/Products/View_products", "refresh");
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
    public function approvedProduct($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            $data_update = array(
                'is_approved' => 1
            );
            $this->db->where('id', $id);
            $zapak = $this->db->update('tbl_products', $data_update);
            if ($zapak != 0) {
                $this->session->set_flashdata('smessage', 'Product approved successfully');
                redirect("dcadmin/Products/View_products", "refresh");
            } else {
                $data['e'] = "Error Occured";
                // exit;
                $this->load->view('errors/error500admin', $data);
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    public function product_cod_data()
    {
        // Check if it's an AJAX request
        if ($this->input->is_ajax_request()) {


            $user_id =  $this->input->post('userId');
            $is_chacked = $this->input->post('isChecked');

            if ($is_chacked == "false") {
                $data_update = array(
                    'cod' => 0,
                );
            } else {
                $data_update = array(
                    'cod' => 1,
                );
            }
            $this->db->where('id', $user_id);
            $zapak = $this->db->update('tbl_products', $data_update);
        } else {
            // If it's not an AJAX request, show an error or redirect
            show_error('Invalid request', 400);
        }
    }
}
