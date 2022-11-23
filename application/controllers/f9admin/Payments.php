<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Payments extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
			  $this->load->library('upload');
		}
//---------------------view Payments function---------------------------
public function view_payments(){
                 if(!empty($this->session->userdata('admin_data'))){

                   $data['user_name']=$this->load->get_var('user_name');
      			$this->db->select('*');
$this->db->from('tbl_payments');
//$this->db->where('id',$usr);
$data['Payments_data']= $this->db->get();

      			$this->db->select('*');
$this->db->from('tbl_doctor');
//$this->db->where('id',$usr);
$data['doctor_data']= $this->db->get();

                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/payments/view_payments');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

//---------------------add payments function---------------------------------
public function add_payments(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

      			$this->db->select('*');
$this->db->from('tbl_doctor');
//$this->db->where('id',$usr);
$data['doctor_data']= $this->db->get();
                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/payments/add_payments');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }
//------------------insert data in paymnets table-----------------------------
      			public function add_payments_data()

              {

                if(!empty($this->session->userdata('admin_data'))){


          	$this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {

              $this->form_validation->set_rules('vendor_doctor_colume', 'name', 'xss_clean');
              $this->form_validation->set_rules('type_colume', 'type', 'xss_clean');
              $this->form_validation->set_rules('amount_colume', 'Amount', 'xss_clean');

              if($this->form_validation->run()== TRUE)
              {
                $vendor_doctor=$this->input->post('vendor_doctor_colume');
								$type_colume=$this->input->post('type_colume');
								$amount_colume=$this->input->post('amount_colume');

                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');


          $data_insert = array(
						'Vendor_name'=>$vendor_doctor,
                    'type'=>$type_colume,
                    'amount'=>$amount_colume,
                    'ip' =>$ip,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );
          $last_id=$this->base_model->insert_table("tbl_payments",$data_insert,1) ;


                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/payments/view_payments","refresh");

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
//------------------delete function-----------------------------
public function delete_payments($idd){

       if(!empty($this->session->userdata('admin_data'))){


         $data['user_name']=$this->load->get_var('user_name');


                 									 $id=base64_decode($idd);

        if($this->load->get_var('position')=="Super Admin"){

                         									 $zapak=$this->db->delete('tbl_payments', array('id' => $id));
                         									 if($zapak!=0){
                         								 	redirect("dcadmin/payments/view_payments","refresh");
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




}
