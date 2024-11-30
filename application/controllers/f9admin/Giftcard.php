<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Giftcard extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }

    public function index()
    {
    
        if(!empty($this->session->userdata('admin_data'))){

            
            $this->db->select('*');
            $this->db->from('gift_card');
            $this->db->order_by('amount','ASC');
            $data['gift_card']= $this->db->get();

            $this->load->view('admin/common/header_view',$data);
            $this->load->view('admin/giftcard/view_giftcard');
            $this->load->view('admin/common/footer_view');
            }
            else{
                redirect("login/admin_login","refresh");
            }
    
   }

   public function add_giftcard()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/giftcard/add_giftcard');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }


    public function update_giftcard($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {

            $id=base64_decode($idd);
                     $data['id']=$id;

                $this->db->select('*');
                            $this->db->from('gift_card');
                            $this->db->where('id',$id);
                            $dsa= $this->db->get();
                            $data['gift']=$dsa->row();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/giftcard/update_giftcard');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

public function add_giftcard_data($t,$iw="")

              {

                if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
              // print_r($this->input->post());
              // exit;
              $this->form_validation->set_rules('amount', 'amount', 'required|xss_clean|trim');
              $this->form_validation->set_rules('count', 'count', 'required|xss_clean|trim');
        
              if($this->form_validation->run()== TRUE)
              {
                $amount=$this->input->post('amount');
                $count=$this->input->post('count');

                $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);
          if($typ==1){

            $this->load->library('upload');
                      $img1='image1';
            
                        $file_check=($_FILES['image1']['error']);
                        if($file_check!=4){
            $image_upload_folder = FCPATH . "assets/uploads/gift_card/";
            if (!file_exists($image_upload_folder))
            {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
            }
            $new_file_name="gift_card".date("Ymdhms");
            $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'file_name' => $new_file_name,
            'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
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
            
            $videoNAmePath = "assets/uploads/gift_card/".$new_file_name.$file_info['file_ext'];
            $file_info['new_name']=$videoNAmePath;
            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
            $nnnn=$file_info['file_name'];
            // echo json_encode($file_info);
            }
                        }

          $data_insert = array('amount'=>$amount,
                    'gift_count'=>$count,
                    'image'=>$nnnn,
                    'ip' =>$ip,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );





          $last_id=$this->base_model->insert_table("gift_card",$data_insert,1) ;

          }
          if($typ==2){

   $idw=base64_decode($iw);

   $this->load->library('upload');
                      $img1='image1';
            
                        $file_check=($_FILES['image1']['error']);
                        if($file_check!=4){
            $image_upload_folder = FCPATH . "assets/uploads/gift_card/";
            if (!file_exists($image_upload_folder))
            {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
            }
            $new_file_name="gift_card".date("Ymdhms");
            $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'file_name' => $new_file_name,
            'allowed_types' =>'xlsx|csv|xls|pdf|doc|docx|txt|jpg|jpeg|png',
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
            
            $videoNAmePath = "assets/uploads/gift_card/".$new_file_name.$file_info['file_ext'];
            $file_info['new_name']=$videoNAmePath;
            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
            $nnnn=$file_info['file_name'];
            // echo json_encode($file_info);
            }
                        }

            if(!empty($nnnn)){
                $nnn = $nnnn;
            }      
            else{
                $this->db->select('*');
            $this->db->from('gift_card');
            $this->db->where('id',$idw);
            $dsa= $this->db->get();
            $da=$dsa->row();
            if(!empty($da)){
              $nnn = $da->image;
            }
          else{
            $nnn = "";
          }
            }      

      $data_insert = array('amount'=>$amount,
                    'gift_count'=>$count,
                    'image'=>$nnn
                  

                    );


            $this->db->where('id', $idw);
            $last_id=$this->db->update('gift_card', $data_insert);

          }


                              if($last_id!=0){

$this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/Giftcard","refresh");

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

       
              
    
}