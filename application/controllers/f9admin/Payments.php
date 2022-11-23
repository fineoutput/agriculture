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


 public function View_payments(){

                  if(!empty($this->session->userdata('admin_data'))){


                    $data['user_name']=$this->load->get_var('user_name');

                    // echo SITE_NAME;
                    // echo $this->session->userdata('image');
                    // echo $this->session->userdata('position');
                    // exit;
              $this->db->select('*');
  $this->db->from('tbl_payments');

  $data['payments_data']= $this->db->get();




                    $this->load->view('admin/common/header_view',$data);
                    $this->load->view('admin/payments/View_payments');
                    $this->load->view('admin/common/footer_view');

                }
                else{

                   redirect("login/admin_login","refresh");
                }

                }

              }
