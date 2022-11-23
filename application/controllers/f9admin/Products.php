<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Products extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
			  $this->load->library('upload');
		}


 public function View_products(){

                  if(!empty($this->session->userdata('admin_data'))){


                    $data['user_name']=$this->load->get_var('user_name');

                    // echo SITE_NAME;
                    // echo $this->session->userdata('image');
                    // echo $this->session->userdata('position');
                    // exit;
              $this->db->select('*');
  $this->db->from('tbl_products');

  $data['products_data']= $this->db->get();




                    $this->load->view('admin/common/header_view',$data);
                    $this->load->view('admin/products/View_products');
                    $this->load->view('admin/common/footer_view');

                }
                else{

                   redirect("login/admin_login","refresh");
                }

                }



public function add_products(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');



                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/products/add_products');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

             }

            public function add_products_data($t,$iw="")

              {

                if(!empty($this->session->userdata('admin_data'))){


            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
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
              $this->form_validation->set_rules('inventory', 'inventory', 'required|xss_clean|trim');





              if($this->form_validation->run()== TRUE)
              {
								$name_english=$this->input->post('name_english');
								$name_hindi=$this->input->post('name_hindi');
								$name_punjabi=$this->input->post('name_punjabi');


								                    $description_english=$this->input->post('description_english');
																		$description_hindi=$this->input->post('description_hindi');
																		$description_punjabi=$this->input->post('description_punjabi');



				                           $mrp=$this->input->post('mrp');

                               $selling_price=$this->input->post('selling_price');
                                   $inventory=$this->input->post('inventory');


                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

                  $image1="";
                                  $image2="";
                                      $img1='image1';
                                      $file_check=($_FILES['image1']['error']);
                                      if ($file_check!=4) {
                                          $image_upload_folder = FCPATH . "assets/uploads/product/";
                                          if (!file_exists($image_upload_folder)) {
                                              mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                          }
                                          $new_file_name="category".date("Ymdhms");
                                          $this->upload_config = array(
                                                    'upload_path'   => $image_upload_folder,
                                                    'file_name' => $new_file_name,
                                                    'allowed_types' =>'jpg|jpeg|png',
                                                    'max_size'      => 25000
                                            );
                                          $this->upload->initialize($this->upload_config);
                                          if (!$this->upload->do_upload($img1)) {
                                              $upload_error = $this->upload->display_errors();
                                              // echo json_encode($upload_error);
                                              echo $upload_error;
                                          } else {
                                              $file_info = $this->upload->data();
                                              $image1 = "assets/uploads/product/".$new_file_name.$file_info['file_ext'];
                                          }
                                      }
                                      $image2="";
                                          $img2='image2';
                                          $file_check=($_FILES['image2']['error']);
                                          if ($file_check!=4) {
                                              $image_upload_folder = FCPATH . "assets/uploads/product/";
                                              if (!file_exists($image_upload_folder)) {
                                                  mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                                              }
                                              $new_file_name="category".date("Ymdhms");
                                              $this->upload_config = array(
                                                        'upload_path'   => $image_upload_folder,
                                                        'file_name' => $new_file_name,
                                                        'allowed_types' =>'jpg|jpeg|png',
                                                        'max_size'      => 25000
                                                );
                                              $this->upload->initialize($this->upload_config);
                                              if (!$this->upload->do_upload($img2)) {
                                                  $upload_error = $this->upload->display_errors();
                                                  // echo json_encode($upload_error);
                                                  echo $upload_error;
                                              } else {
                                                  $file_info = $this->upload->data();
                                                  $image2 = "assets/uploads/product/".$new_file_name.$file_info['file_ext'];
                                              }
                                          }



          $typ=base64_decode($t);
          if($typ==1){

          $data_insert = array(	'name_english'=>$name_english,
						'name_hindi'=>$name_hindi,
						'name_punjabi'=>$name_punjabi,

          'description_english'=>$description_english,
					'description_hindi'=>$description_hindi,
					'description_punjabi'=>$description_punjabi,

          'image1'=>$image1,
          'image2'=>$image2,
          'mrp'=>$mrp,
          'selling_price'=>$selling_price,
          'inventory'=>$inventory,



										'ip' =>$ip,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );





          $last_id=$this->base_model->insert_table("tbl_products",$data_insert,1) ;

          }
          if($typ==2){

   $idw=base64_decode($iw);



          $data_insert = array(	'name_english'=>$name_english,
						'name_hindi'=>$name_hindi,
						'name_punjabi'=>$name_punjabi,

						'description_english'=>$description_english,
						'description_hindi'=>$description_hindi,
						'description_punjabi'=>$description_punjabi,


          'image1'=>$image1,
          'image2'=>$image2,
          'mrp'=>$mrp,
          'selling_price'=>$selling_price,
          'inventory'=>$inventory





                    );




            $this->db->where('id', $idw);
            $last_id=$this->db->update('tbl_products', $data_insert);

          }


                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/Products/View_products","refresh");

                                      }

                                      else

                                      {

                                   $this->session->set_flashdata('smessage','Sorry error occured');
                                     redirect($_SERVER['HTTP_REFERER']);


                                      }


              }
            else{

$this->session->set_flashdata('smessage',validation_errors());
     redirect($_SERVER['HTTP_REFERER']);

            }

            }
          else{

$this->session->set_flashdata('smessage','Please insert some data, No data available');
     redirect($_SERVER['HTTP_REFERER']);

          }
          }
          else{

      redirect("login/admin_login","refresh");


          }
				}


        public function update_products($idd){

                         if(!empty($this->session->userdata('admin_data'))){


                           $data['user_name']=$this->load->get_var('user_name');

                           // echo SITE_NAME;
                           // echo $this->session->userdata('image');
                           // echo $this->session->userdata('position');
                           // exit;
         $id=base64_decode($idd);
        $data['id']=$idd;


        $this->db->select('*');
                    $this->db->from('tbl_products');
                    $this->db->where('id',$id);
                    $dsa= $this->db->get();
                    $data['products']=$dsa->row();



                           $this->load->view('admin/common/header_view',$data);
                           $this->load->view('admin/products/update_products');
                           $this->load->view('admin/common/footer_view');

                       }
                       else{

                          redirect("login/admin_login","refresh");
                       }

                       }




    public function delete_products($idd){

     if(!empty($this->session->userdata('admin_data'))){


       $data['user_name']=$this->load->get_var('user_name');

       // echo SITE_NAME;
       // echo $this->session->userdata('image');
       // echo $this->session->userdata('position');
       // exit;
                                 $id=base64_decode($idd);

      if($this->load->get_var('position')=="Super Admin"){


                                         $zapak=$this->db->delete('tbl_products', array('id' => $id));
                                         if($zapak!=0){

                                        redirect("dcadmin/Products/View_products","refresh");
                                                }
                                                else
                                                {
                                                  echo "Error";
                                                  exit;
                                                }
                     }
                     else{
                     $data['e']="Sorry You Don't Have Permission To Delete Anything.";
                      // exit;
                      $this->load->view('errors/error500admin',$data);
                     }


           }
           else{

               $this->load->view('admin/login/index');
           }

           }

           public function updateproductsStatus($idd,$t){

                    if(!empty($this->session->userdata('admin_data'))){


                      $data['user_name']=$this->load->get_var('user_name');

                      // echo SITE_NAME;
                      // echo $this->session->userdata('image');
                      // echo $this->session->userdata('position');
                      // exit;
                      $id=base64_decode($idd);

                      if($t=="active"){

                        $data_update = array(
                    'is_active'=>1

                    );

                    $this->db->where('id', $id);
                   $zapak=$this->db->update('tbl_products', $data_update);

                        if($zapak!=0){
                        redirect("dcadmin/Products/View_products","refresh");
                                }
                                else
                                {
                                  echo "Error";
                                  exit;
                                }
                      }
                      if($t=="inactive"){
                        $data_update = array(
                     'is_active'=>0

                     );

                     $this->db->where('id', $id);
                     $zapak=$this->db->update('tbl_products', $data_update);

                         if($zapak!=0){
                         redirect("dcadmin/Products/View_products","refresh");
                                 }
                                 else
                                 {

                     $data['e']="Error Occured";
                                      // exit;
                    $this->load->view('errors/error500admin',$data);
                                 }
                      }



                  }
                  else{

                      $this->load->view('admin/login/index');
                  }

                  }



        }
