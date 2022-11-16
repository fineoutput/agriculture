<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Products extends CI_finecontrol
       {
           public function __construct()
           {
               parent::__construct();
               $this->load->model("login_model");
               $this->load->model("admin/base_model");
               $this->load->library('user_agent');
               $this->load->library('upload');
           }

           public function view_products($idd)
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
                   //  $id=base64_decode($idd);

                   $id=base64_decode($idd);
                   $data['id']=$idd;

                   $this->db->select('*');
                   $this->db->from('tbl_products');
                   $this->db->where('category_id', $id);
                   $data['products_data']= $this->db->get();

                   //             $this->db->select('*');
                   // $this->db->from('tbl_inventory');
                   // // $this->db->where('',$usr);
                   // $data['inventory_data']= $this->db->get();

                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/products/view_products');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }
           public function view_product_categories()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->db->select('*');
                   $this->db->from('tbl_category');
                   $this->db->where('is_active', 1);
                   $data['category_data']= $this->db->get();


                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/products/view_product_categories');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_products($idd)
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $id=base64_decode($idd);
                   $data['id']=$idd;



                   $this->db->select('*');
                   $this->db->from('tbl_subcategory');
                   $this->db->where('category_id', $id);
                   $this->db->where('is_active', 1);
                   $data['subcategory_data']= $this->db->get();


                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/products/add_products');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function getSubcategory()
           {
               $id=$_GET['isl'];
               $this->db->select('*');
               $this->db->from('tbl_subcategory');
               $this->db->where('category_id', $id);
               $this->db->where('is_active', 1);

               $dat= $this->db->get();

               $i=1;
               foreach ($dat->result() as $data) {
                   $igt[] = array('sub_id' =>$data->id ,'sub_name'=>$data->subcategory);
               }


               echo json_encode($igt);
           }

           public function update_products($idd, $idd1)
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;

                   $id=base64_decode($idd);
                   $data['id']=$idd;

                   $id1=base64_decode($idd1);
                   $data['id1']=$idd1;
                   // echo $id1;die();
                   $this->db->select('*');
                   $this->db->from('tbl_products');
                   $this->db->where('id', $id);
                   $data['products_data']= $this->db->get()->row();

                   $this->db->select('*');
                   $this->db->from('tbl_subcategory');
                   $this->db->where('category_id', $id1);
                   $this->db->where('is_active', 1);
                   $data['subcategory_data']= $this->db->get();

                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/products/update_products');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_products_data($t, $iw="")
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->load->helper(array('form', 'url'));
                   $this->load->library('form_validation');
                   $this->load->helper('security');
                   if ($this->input->post()) {
                       // print_r($this->input->post());
                       // exit;
                       $this->form_validation->set_rules('productname', 'productname', 'required|trim');
                       $this->form_validation->set_rules('category_id', 'category_id', 'required|trim');
                       $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|trim');
                       $this->form_validation->set_rules('mrp', 'mrp', 'trim|integer');
                       $this->form_validation->set_rules('sellingprice', 'sellingprice', 'trim');
                       // $this->form_validation->set_rules('gst', 'gst', 'trim');
                       // $this->form_validation->set_rules('gstprice', 'gstprice', 'trim');
                       // $this->form_validation->set_rules('sp', 'sp', 'required|trim');

                       $this->form_validation->set_rules('productdescription', 'productdescription', 'required|trim');
                       $this->form_validation->set_rules('inventory', 'inventory', 'required|trim|integer');
                       $this->form_validation->set_rules('feature_product', 'feature_product', 'required|trim');
                       $this->form_validation->set_rules('popular_product', 'popular_product', 'required|trim');


                       if ($this->form_validation->run()== true) {
                           $productname=$this->input->post('productname');
                           $category_id=$this->input->post('category_id');
                           $subcategory_id=$this->input->post('subcategory_id');
                           $mrp=$this->input->post('mrp');
                           $sellingprice=$this->input->post('sellingprice');
                           // $gst=$this->input->post('gst');
                           // $gstprice=$this->input->post('gstprice');
                           // $sp=$this->input->post('sp');
                           $productdescription=$this->input->post('productdescription');
                           $inventory=$this->input->post('inventory');
                           $feature_product=$this->input->post('feature_product');
                           $popular_product=$this->input->post('popular_product');


                           if ($feature_product == 'yes') {
                               $feature_product=1;
                           } else {
                               $feature_product=0;
                           }

                           if ($popular_product == 'yes') {
                               $popular_product=1;
                           } else {
                               $popular_product=0;
                           }





                           $img2='image';




                           $image_upload_folder = FCPATH . "assets/uploads/products/";
                           if (!file_exists($image_upload_folder)) {
                               mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                           }
                           $new_file_name="products".date("Ymdhms");
                           $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                           $this->upload->initialize($this->upload_config);

                           if (!$this->upload->do_upload($img2)) {
                               $nnnn2="";
                           } else {
                               $file_info = $this->upload->data();

                               $videoNAmePath2 = "assets/uploads/products/".$new_file_name.$file_info['file_ext'];
                               $nnnn2=$videoNAmePath2;

                               // echo json_encode($file_info);
                           }


                           $typ=base64_decode($t);
                           // $last_id = 0;



                           $ip = $this->input->ip_address();
                           date_default_timezone_set("Asia/Calcutta");
                           $cur_date=date("Y-m-d H:i:s");
                           $addedby=$this->session->userdata('admin_id');
                           // echo $nnnn2."<br />".$nnnn3."<br />".$nnnn4."<br />".$nnnn5;die();
                           if ($typ==1) {
                               $data_insert = array(
                  'productname'=>$productname,
                  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'image'=>$nnnn2,
  'mrp'=>$mrp,
  'sellingprice'=>$sellingprice,
  // 'gstrate'=>$gst,
  // 'gstprice'=>$gstprice,
  // 'sellingpricegst'=>$sp,
  'inventory'=>$inventory,
  'productdescription'=>$productdescription,
                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


                               $last_id=$this->base_model->insert_table("tbl_products", $data_insert, 1) ;
                               if ($last_id!=0) {
                                   $this->session->set_flashdata('smessage', 'Products inserted successfully');
                                   redirect("dcadmin/Products/view_products/".base64_encode($category_id), "refresh");
                               } else {
                                   $this->session->set_flashdata('emessage', 'Sorry error occured');
                                   redirect($_SERVER['HTTP_REFERER']);
                               }
                           }
                           if ($typ==2) {
                               $idw=base64_decode($iw);


                               $this->db->select('*');
                               $this->db->from('tbl_products');
                               $this->db->where('id', $idw);
                               $dsa=$this->db->get();
                               $da=$dsa->row();

                               if (!empty($nnnn2)) {
                                   $n1=$nnnn2;
                               } else {
                                   $n1=$da->image;
                               }


                               $data_insert = array(
                                 'productname'=>$productname,
                          'subcategory_id'=>$subcategory_id,
                          'image'=>$n1,
                          'mrp'=>$mrp,
                          'sellingprice'=>$sellingprice,
                          // 'gstrate'=>$gst,
                          // 'gstprice'=>$gstprice,
                          // 'sellingpricegst'=>$sp,
                          'inventory'=>$inventory,
                          'productdescription'=>$productdescription,
                          'feature_product'=>$feature_product,
                          'popular_product'=>$popular_product,
                     );

                               $this->db->where('id', $idw);
                               $last_id=$this->db->update('tbl_products', $data_insert);
                               if ($last_id!=0) {
                                   $this->session->set_flashdata('smessage', 'Products updated successfully');
                                   redirect("dcadmin/Products/view_products/".base64_encode($category_id), "refresh");
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

           public function updateproductsStatus($idd, $t)
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
                   $id=base64_decode($idd);

                   if ($t=="active") {
                       $data_update = array(
                        'is_active'=>1

                        );

                       $this->db->where('id', $id);
                       $zapak=$this->db->update('tbl_products', $data_update);

                       if ($zapak!=0) {
                           $this->session->set_flashdata('smessage', 'Product status updated successfully');
                           redirect($_SERVER['HTTP_REFERER']);
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }
                   if ($t=="inactive") {
                       $data_update = array(
                         'is_active'=>0

                         );

                       $this->db->where('id', $id);
                       $zapak=$this->db->update('tbl_products', $data_update);
                       $zapak1=$this->db->delete('tbl_cart', array('product_id' => $id));
                       $zapak1=$this->db->delete('tbl_wishlist', array('product_id' => $id));

                       if ($zapak!=0) {
                           $this->session->set_flashdata('smessage', 'Product status updated successfully');
                           redirect($_SERVER['HTTP_REFERER']);
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }



           public function delete_products($idd)
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
                   $id=base64_decode($idd);

                   if ($this->load->get_var('position')=="Super Admin") {
                       $this->db->select('*');
                       $this->db->from('tbl_products');
                       $this->db->where('id', $id);
                       $dsa= $this->db->get();
                       $da=$dsa->row();
                       // $img=$da->image;
                       $zapak1=$this->db->delete('tbl_cart', array('product_id' => $id));
                       $zapak1=$this->db->delete('tbl_wishlist', array('product_id' => $id));
                       $zapak=$this->db->delete('tbl_products', array('id' => $id));
                       if ($zapak!=0) {
                           // $path = FCPATH .$img;
                           //   unlink($path);
                           $this->session->set_flashdata('smessage', 'Product deleted successfully');
                           redirect($_SERVER['HTTP_REFERER']);
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   } else {
                       $this->session->set_flashdata('emessage', 'Sorry you not a super admin you dont have permission to delete anything');
                       redirect($_SERVER['HTTP_REFERER']);
                   }
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }
       }
