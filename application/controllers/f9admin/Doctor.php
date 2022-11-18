<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Doctor extends CI_finecontrol{
function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
}
//-----------------------view Doctor function-----------------
public function view_doctor(){

 if(!empty($this->session->userdata('admin_data'))){


   $data['user_name']=$this->load->get_var('user_name');

$this->db->select('*');
$this->db->from('tbl_doctor');
//$this->db->where('id',$usr);
$data['doctor_data']= $this->db->get();

$this->db->select('*');
$this->db->from('all_states');
//$this->db->where('id',$usr);
$data['state_data']= $this->db->get();


$this->db->select('*');
$this->db->from('all_cities');
//$this->db->where('id',$usr);
$data['city_data']= $this->db->get();



   $this->load->view('admin/common/header_view',$data);
   $this->load->view('admin/doctor/view_doctor');
   $this->load->view('admin/common/footer_view');

}
else{

  redirect("login/admin_login","refresh");
}

}

//---------------------add_Doctor function-----------------------------------
public function add_doctor(){

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
$this->load->view('admin/doctor/add_doctor');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

//-----------------------------add_doctor_data------------------------------
  public function add_doctor_data()

              {

                if(!empty($this->session->userdata('admin_data'))){


            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
              $this->form_validation->set_rules('name_english', 'name', 'xss_clean');
              $this->form_validation->set_rules('name_hindi', 'name', 'xss_clean');
              $this->form_validation->set_rules('name_punjabi', 'name', 'xss_clean');


              $this->form_validation->set_rules('email_colume', 'shop name', 'xss_clean');
              $this->form_validation->set_rules('image', 'image', 'xss_clean');
              $this->form_validation->set_rules('type_colume', 'district', 'xss_clean');

              $this->form_validation->set_rules('vet_english', 'city', 'xss_clean');
              $this->form_validation->set_rules('vet_hindi', 'city', 'xss_clean');
              $this->form_validation->set_rules('vet_punjabi', 'city', 'xss_clean');

              $this->form_validation->set_rules('degree_english', 'state', 'xss_clean');
              $this->form_validation->set_rules('degree_hindi', 'state', 'xss_clean');
              $this->form_validation->set_rules('degree_punjabi', 'state', 'xss_clean');

              $this->form_validation->set_rules('experiance_colume', 'pincode', 'xss_clean');
              $this->form_validation->set_rules('assistant_colume', 'gst no', 'xss_clean');
              $this->form_validation->set_rules('private_colume', 'aadhar number', 'xss_clean');
              $this->form_validation->set_rules('education_colume', 'pan number', 'xss_clean');

              $this->form_validation->set_rules('district_english', 'phone number', 'xss_clean');
              $this->form_validation->set_rules('district_hindi', 'phone number', 'xss_clean');
              $this->form_validation->set_rules('district_punjabi', 'phone number', 'xss_clean');

              $this->form_validation->set_rules('state_colume', 'email address', 'xss_clean');
              $this->form_validation->set_rules('city_colume', 'email address', 'xss_clean');
              $this->form_validation->set_rules('phone_colume', 'email address', 'xss_clean');

              if($this->form_validation->run()== TRUE)
              {

                $name_english=$this->input->post('name_english');
                $name_hindi=$this->input->post('name_hindi');
                $name_punjabi=$this->input->post('name_punjabi');
                $email_colume=$this->input->post('email_colume');
                $type_colume=$this->input->post('type_colume');
                $vet_english=$this->input->post('vet_english');
                $vet_hindi=$this->input->post('vet_hindi');
                $vet_punjabi=$this->input->post('vet_punjabi');
                $degree_english=$this->input->post('degree_english');
                $degree_hindi=$this->input->post('degree_hindi');
                $degree_punjabi=$this->input->post('degree_punjabi');
                $experiance_colume=$this->input->post('experiance_colume');
                $assistant_colume=$this->input->post('assistant_colume');
                $private_colume=$this->input->post('private_colume');
                $education_colume=$this->input->post('education_colume');
                $district_english=$this->input->post('district_english');
                $district_hindi=$this->input->post('district_hindi');
                $district_punjabi=$this->input->post('district_punjabi');
                $state_colume=$this->input->post('state_colume');
                $city_colume=$this->input->post('city_colume');
                $phone_colume=$this->input->post('phone_colume');
//------------------image----------------------------
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


          $data_insert = array(
            'name_english'=>$name_english,
            'name_hindi'=>$name_hindi,
            'name_punjabi'=>$name_punjabi,
            'email'=>$email_colume,
            'image'=>$image,
            'type'=>$type_colume,
            'vet_english'=>$vet_english,
            'vet_hindi'=>$vet_hindi,
            'vet_punjabi'=>$vet_punjabi,
            'degree_english'=>$degree_english,
            'degree_hindi'=>$degree_hindi,
            'degree_punjabi'=>$degree_punjabi,
            'experience'=>$experiance_colume,
            'assistant'=>$assistant_colume,
        		'private_practitioner'=>$private_colume,
        		'education_qualification'=>$education_colume,
            'district_english'=>$district_english,
            'district_hindi'=>$district_hindi,
            'district_punjabi'=>$district_punjabi,

            'state'=>$state_colume,
            'city'=>$city_colume,
            'phone_number'=>$phone_colume,
            'ip' =>$ip,
            'added_by' =>$addedby,
            'is_active' =>1,
            'date'=>$cur_date


                    );

          $last_id=$this->base_model->insert_table("tbl_doctor",$data_insert,1) ;



                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/doctor/view_doctor","refresh");

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
//-----------------------------delete_doctor function--------------------------------
public function delete_doctor($idd){

       if(!empty($this->session->userdata('admin_data'))){


         $data['user_name']=$this->load->get_var('user_name');


                 									 $id=base64_decode($idd);

        if($this->load->get_var('position')=="Super Admin"){


                         									 $zapak=$this->db->delete('tbl_doctor', array('id' => $id));
                         									 if($zapak!=0){
                         								 	redirect("dcadmin/doctor/view_doctor","refresh");
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

//---------------------update status function--------------------------------------
public function updatedoctorStatus($idd,$t){

         if(!empty($this->session->userdata('admin_data'))){


           $data['user_name']=$this->load->get_var('user_name');

           $id=base64_decode($idd);

           if($t=="active"){

             $data_update = array(
         'is_active'=>1

         );

         $this->db->where('id', $id);
        $zapak=$this->db->update('tbl_doctor', $data_update);

             if($zapak!=0){
             redirect("dcadmin/doctor/view_doctor","refresh");
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
          $zapak=$this->db->update('tbl_doctor', $data_update);

              if($zapak!=0){
              redirect("dcadmin/doctor/view_doctor","refresh");
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
