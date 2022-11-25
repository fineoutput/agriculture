<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Disease extends CI_finecontrol{
function __construct()
{
 parent::__construct();
 $this->load->model("login_model");
 $this->load->model("admin/base_model");
 $this->load->library('user_agent');
 $this->load->library('upload');
}
// ******************view Disease Function**************************************
public function view_disease(){

if(!empty($this->session->userdata('admin_data'))){


  $data['user_name']=$this->load->get_var('user_name');

  // echo SITE_NAME;
  // echo $this->session->userdata('image');
  // echo $this->session->userdata('position');
  // exit;

               $this->db->select('*');
   $this->db->from('tbl_disease');
   //$this->db->where('id',$usr);
   $data['disease_data']= $this->db->get();

  $this->load->view('admin/common/header_view',$data);
  $this->load->view('admin/disease/View_disease');
  $this->load->view('admin/common/footer_view');

}
else{

 redirect("login/admin_login","refresh");
}

}

  public function add_disease(){

     if(!empty($this->session->userdata('admin_data'))){

       $this->load->view('admin/common/header_view');
       $this->load->view('admin/disease/add_disease');
       $this->load->view('admin/common/footer_view');

   }
   else{

      redirect("login/admin_login","refresh");
   }

   }

   public function update_disease($idd){

       if(!empty($this->session->userdata('admin_data'))){


         $data['user_name']=$this->load->get_var('user_name');

         // echo SITE_NAME;
         // echo $this->session->userdata('image');
         // echo $this->session->userdata('position');
         // exit;

          $id=base64_decode($idd);
         $data['id']=$idd;

                $this->db->select('*');
                $this->db->from('tbl_disease');
                $this->db->where('id',$id);
                $data['disease_data']= $this->db->get()->row();


         $this->load->view('admin/common/header_view',$data);
         $this->load->view('admin/disease/update_disease');
         $this->load->view('admin/common/footer_view');

     }
     else{

        redirect("login/admin_login","refresh");
     }

     }



//----------------------------------------------------------------------------------------------
            public function add_disease_data($t,$iw="")

              {

                if(!empty($this->session->userdata('admin_data'))){


            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
              // print_r($this->input->post());
              // exit;
              $this->form_validation->set_rules('name', 'name', 'required');
              $this->form_validation->set_rules('title', 'title', '');
              $this->form_validation->set_rules('content', 'content', '');

              if($this->form_validation->run()== TRUE)
              {

                $name=$this->input->post('name');
                $title=$this->input->post('title');
                $content=$this->input->post('content');
  //------------------------------------image insert-----------------------------------------
  $this->load->library('upload');
      $img1='image1';
      $image1="";

        $file_check=($_FILES['image1']['error']);
        if($file_check!=4){
      	$image_upload_folder = FCPATH . "assets/uploads/team/";
    						if (!file_exists($image_upload_folder))
    						{
    							mkdir($image_upload_folder, DIR_WRITE_MODE, true);
    						}
    						$new_file_name="image1".date("Ymdhms");
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

    							$image1 = "assets/uploads/team/".$new_file_name.$file_info['file_ext'];
    							$file_info['new_name']=$image1;
    							// $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
    							$nnnn=$file_info['file_name'];
    							// echo json_encode($file_info);
    						}
        }
//-----------------------image tag end------------------------------------------
//------------------------------------image insert-----------------------------------------
$this->load->library('upload');
    $img1='image2';
    $image2="";

      $file_check=($_FILES['image2']['error']);
      if($file_check!=4){
      $image_upload_folder = FCPATH . "assets/uploads/team/";
              if (!file_exists($image_upload_folder))
              {
                mkdir($image_upload_folder, DIR_WRITE_MODE, true);
              }
              $new_file_name="image2".date("Ymdhms");
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

                $image2 = "assets/uploads/team/".$new_file_name.$file_info['file_ext'];
                $file_info['new_name']=$image2;
                // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                $nnnn=$file_info['file_name'];
                // echo json_encode($file_info);
              }
      }
//-----------------------image tag end------------------------------------------
//------------------------------------image insert-----------------------------------------
$this->load->library('upload');
    $img1='image3';
    $image3="";

      $file_check=($_FILES['image3']['error']);
      if($file_check!=4){
      $image_upload_folder = FCPATH . "assets/uploads/team/";
              if (!file_exists($image_upload_folder))
              {
                mkdir($image_upload_folder, DIR_WRITE_MODE, true);
              }
              $new_file_name="image3".date("Ymdhms");
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

                $image3 = "assets/uploads/team/".$new_file_name.$file_info['file_ext'];
                $file_info['new_name']=$image3;
                // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                $nnnn=$file_info['file_name'];
                // echo json_encode($file_info);
              }
      }
//-----------------------image tag end------------------------------------------
//------------------------------------image insert-----------------------------------------
$this->load->library('upload');
    $img1='image4';
    $image4="";

      $file_check=($_FILES['image4']['error']);
      if($file_check!=4){
      $image_upload_folder = FCPATH . "assets/uploads/team/";
              if (!file_exists($image_upload_folder))
              {
                mkdir($image_upload_folder, DIR_WRITE_MODE, true);
              }
              $new_file_name="image4".date("Ymdhms");
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

                $image4 = "assets/uploads/team/".$new_file_name.$file_info['file_ext'];
                $file_info['new_name']=$image4;
                // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                $nnnn=$file_info['file_name'];
                // echo json_encode($file_info);
              }
      }
//-----------------------image tag end------------------------------------------
                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);
          if($typ==1){

          $data_insert = array('name'=>$name,
                    'title'=>$title,
                    'content'=>$content,
                    'image1'=>$image1,
                    'image2'=>$image2,
                    'image3'=>$image3,
                    'image4'=>$image4,
                    'ip' =>$ip,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );


$last_id=$this->base_model->insert_table("tbl_disease",$data_insert,1) ;

          }
          if($typ==2){

   $idw=base64_decode($iw);


          $data_insert = array(
                      'name'=>$name,
                      'title'=>$title,
                      'content'=>$content,
                      'image1'=>$image1,
                      'image2'=>$image2,
                      'image3'=>$image3,
                      'image4'=>$image4
                    );




            $this->db->where('id', $idw);
            $last_id=$this->db->update('tbl_disease', $data_insert);

          }


                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/disease/view_disease","refresh");

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

//--------------------------------------------------------------------------------------------------------------------------------------------------
   public function updatediseaseStatus($idd,$t){

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
           $zapak=$this->db->update('tbl_disease', $data_update);

                if($zapak!=0){
                redirect("dcadmin/disease/view_disease","refresh");
                        }
                        else
                        {
$this->session->set_flashdata('emessage','Sorry error occured');
redirect($_SERVER['HTTP_REFERER']);
                        }
              }
              if($t=="inactive"){
                $data_update = array(
             'is_active'=>0

             );

             $this->db->where('id', $id);
             $zapak=$this->db->update('tbl_disease', $data_update);

                 if($zapak!=0){
                 redirect("dcadmin/disease/view_disease","refresh");
                         }
                         else
                         {

    $this->session->set_flashdata('emessage','Sorry error occured');
      redirect($_SERVER['HTTP_REFERER']);
                         }
              }



          }
          else{

             redirect("login/admin_login","refresh");

          }

          }

//--------------------------------------------------------------------------------------------------------------------------------------------------


   public function delete_disease($idd){

          if(!empty($this->session->userdata('admin_data'))){

            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);

           if($this->load->get_var('position')=="Super Admin"){


$zapak=$this->db->delete('tbl_disease', array('id' => $id));
if($zapak!=0){
redirect("dcadmin/disease/view_disease","refresh");
    }
    else
    {
       $this->session->set_flashdata('emessage','Sorry error occured');
       redirect($_SERVER['HTTP_REFERER']);
    }
}
else{
 $this->session->set_flashdata('emessage','Sorry you not a super admin you dont have permission to delete anything');
   redirect($_SERVER['HTTP_REFERER']);
}


                }
                else{

            redirect("login/admin_login","refresh");

                }

                }
          }

?>
