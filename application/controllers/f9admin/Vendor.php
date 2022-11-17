<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Vendor extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}
//-----------------------view vendor function-----------------
public function view_vendor(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

                $this->db->select('*');
    $this->db->from('tbl_vendor');
    //$this->db->where('id',$usr);
    $data['vendor_data']= $this->db->get();

                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/vendor/view_vendor');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }
//---------------------add_vendor function-----------------------------------
public function add_vendor(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

      			$this->db->select('*');
$this->db->from('all_states');
//$this->db->where('id',$usr);
$data['state_data']= $this->db->get();

      			$this->db->select('*');
$this->db->from('all_cities');
//$this->db->where('id',$usr);
$data['city_data']= $this->db->get();

                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/vendor/add_vendor');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

//-----------------------------add_vendor_data------------------------------
            public function add_vendor_data($t,$iw="")

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




							$this->form_validation->set_rules('shop_name_english', 'shop_name name', 'xss_clean');
							$this->form_validation->set_rules('shop_name_hindi', 'shop_name name', 'xss_clean');
							$this->form_validation->set_rules('shop_name_punjabi', 'shop_name name', 'xss_clean');




							$this->form_validation->set_rules('address_english', 'address', 'xss_clean');
							$this->form_validation->set_rules('address_hindi', 'address', 'xss_clean');
								$this->form_validation->set_rules('address_punjabi', 'address', 'xss_clean');




							$this->form_validation->set_rules('district_english', 'name', 'required|xss_clean|trim');
							$this->form_validation->set_rules('district_hindi', 'name', 'required|xss_clean|trim');
							$this->form_validation->set_rules('district_punjabi', 'Village', 'required|xss_clean|trim');





							$this->form_validation->set_rules('city_colume', 'city', 'xss_clean');
							$this->form_validation->set_rules('state_colume', 'state', 'xss_clean');
							$this->form_validation->set_rules('pincode_colume', 'pincode', 'xss_clean');
							$this->form_validation->set_rules('gst_colume', 'gst no', 'xss_clean');
							$this->form_validation->set_rules('image', 'aadhar Upload', 'xss_clean');
							$this->form_validation->set_rules('pan_colume', 'pan number', 'xss_clean');
							$this->form_validation->set_rules('phone_colume', 'phone number', 'xss_clean');
							$this->form_validation->set_rules('email_colume', 'email address', 'xss_clean');


              if($this->form_validation->run()== TRUE)
              {
								$name_english=$this->input->post('name_english');
								$name_hindi=$this->input->post('name_hindi');
								$name_punjabi=$this->input->post('name_punjabi');


                $shop_name_english=$this->input->post('shop_name_english');
								$shop_name_hindi=$this->input->post('shop_name_hindi');
								$shop_name_punjabi=$this->input->post('shop_name_punjabi');




								$address_english=$this->input->post('address_english');
								$address_hindi=$this->input->post('address_hindi');
								$address_punjabi=$this->input->post('address_punjabi');




								$district_english=$this->input->post('district_english');
								$district_hindi=$this->input->post('district_hindi');

								$district_punjabi=$this->input->post('district_punjabi');




								$city_colume=$this->input->post('city_colume');
								$state_colume=$this->input->post('state_colume');
								$pincode_colume=$this->input->post('pincode_colume');
								$gst_colume=$this->input->post('gst_colume');
								// $image=$this->input->post('image');
								$pan_colume=$this->input->post('pan_colume');
								$phone_colume=$this->input->post('phone_colume');
								$email_colume=$this->input->post('email_colume');
//--------------image-----------------------------------
$this->load->library('upload');
$image="";
    $img1='image';

      $file_check=($_FILES['image']['error']);
      if($file_check!=4){
    	$image_upload_folder = FCPATH . "assets/uploads/team/";
  						if (!file_exists($image_upload_folder))
  						{
  							mkdir($image_upload_folder, DIR_WRITE_MODE, true);
  						}
  						$new_file_name="team".date("Ymdhms");
  						$this->upload_config = array(
  								'upload_path'   => $image_upload_folder,
  								'file_name' => $new_file_name,
  								'allowed_types' =>'jpg|jpeg|png',
  								'max_size'      => 25000
  						);
  						$this->upload->initialize($this->upload_config);
  						if (!$this->upload->do_upload($img1))
  						{
  							$upload_error = $this->upload->display_errors();
  							// echo json_encode($upload_error);
  							echo $upload_error;
  						}
  						else
  						{

  							$file_info = $this->upload->data();

  							$image = "assets/uploads/team/".$new_file_name.$file_info['file_ext'];
  							$file_info['new_name']=$image;
  							// $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
  							$nnnn=$file_info['file_name'];
  							// echo json_encode($file_info);
  						}
      }



                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);
          if($typ==1){

          $data_insert = array(
						'name_english'=>$name_english,
						'name_hindi'=>$name_hindi,
						'name_punjabi'=>$name_punjabi,


						'shop_name_english'=>$shop_name_english,
						'shop_name_hindi'=>$shop_name_hindi,
						'shop_name_punjabi'=>$shop_name_punjabi,


																'address_english'=>$address_english,
																'address_hindi'=>$address_hindi,
																'address_punjabi'=>$address_punjabi,



										'district_english'=>$district_english,
										'district_hindi'=>$district_hindi,
										'district_punjabi'=>$district_punjabi,


										'city'=>$city_colume,
                    'state'=>$state_colume,
                    'pincode'=>$pincode_colume,
                    'gst_no'=>$gst_colume,
										'image'=>$image,
										'pan_number'=>$pan_colume,
                    'phone_number'=>$phone_colume,
                    'email'=>$email_colume,
                    'ip' =>$ip,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );

          $last_id=$this->base_model->insert_table("tbl_vendor",$data_insert,1) ;

          }
          if($typ==2){

   $idw=base64_decode($iw);


          $data_insert = array(	'name_english'=>$name_english,
						'name_hindi'=>$name_hindi,
						'name_punjabi'=>$name_punjabi,


						'shop_name_english'=>$shop_name_english,
						'shop_name_hindi'=>$shop_name_hindi,
						'shop_name_punjabi'=>$shop_name_punjabi,


																'address_english'=>$address_english,
																'address_hindi'=>$address_hindi,
																'address_punjabi'=>$address_punjabi,



										'district_english'=>$district_english,
										'district_hindi'=>$district_hindi,
										'district_punjabi'=>$district_punjabi,
					'city'=>$city_colume,
					'state'=>$state_colume,
					'pincode'=>$pincode_colume,
					'gst_no'=>$gst_colume,
					'aadhar_upload'=>$aadhar_colume,
					'pan_number'=>$pan_colume,
					'phone_number'=>$phone_colume,
					'email'=>$email_colume

                    );




            $this->db->where('id', $idw);
            $last_id=$this->db->update('tbl_vendor', $data_insert);

          }


                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/vendor/view_vendor","refresh");

                                      }

                                      else

                                      {

                                   $this->session->set_flashdata('emessage','Sorry error occured');
                                     redirect($_SERVER['HTTP_REFERER']);


                                      }


              }
            else{

$this->session->set_flashdata('emessage',validation_errors());
     redirect($_SERVER['HTTP_REFERER']);

            }

            }
          else{

$this->session->set_flashdata('emessage','Please insert some data, No data available');
     redirect($_SERVER['HTTP_REFERER']);

          }
          }
          else{

      redirect("login/admin_login","refresh");


          }

          }
//--------------------------------delete_vendor function------------------------------

public function delete_vendor($idd){

       if(!empty($this->session->userdata('admin_data'))){


         $data['user_name']=$this->load->get_var('user_name');
							 $id=base64_decode($idd);

        if($this->load->get_var('position')=="Super Admin"){

                         									 $zapak=$this->db->delete('tbl_vendor', array('id' => $id));
                         									 if($zapak!=0){
                         								 	redirect("dcadmin/vendor/view_vendor","refresh");
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

//--------------------------updatevendorStatus function---------------------------
public function updatevendorStatus($idd,$t){

         if(!empty($this->session->userdata('admin_data'))){

           $data['user_name']=$this->load->get_var('user_name');

           $id=base64_decode($idd);

           if($t=="reject"){

             $data_update = array(
         'is_active'=>1

         );

         $this->db->where('id', $id);
        $zapak=$this->db->update('tbl_vendor', $data_update);

             if($zapak!=0){
             redirect("dcadmin/vendor/view_vendor","refresh");
                     }
                     else
                     {
                       echo "Error";
                       exit;
                     }
           }
           if($t=="approve"){
             $data_update = array(
          'is_active'=>0

          );

          $this->db->where('id', $id);
          $zapak=$this->db->update('tbl_vendor', $data_update);

              if($zapak!=0){
              redirect("dcadmin/vendor/view_vendor","refresh");
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
