<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Vendor_pay_req extends CI_finecontrol{
function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
}
//****************************View vendor_pay_req Function**************************************

public function View_vendor_pay_req(){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

$this->db->select('*');
$this->db->from('tbl_vendor_pay_req');
//$this->db->where('id',$usr);
$data['vendor_pay_req_data']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/vendor_pay_req/View_vendor_pay_req');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}
//****************************Add vendor_pay_req Function**************************************
public function add_vendor_pay_req(){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/vendor_pay_req/add_vendor_pay_req');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}
//****************************Insert vendor_pay_req Function**************************************
public function add_vendor_pay_req_data($t,$iw="")

{

if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
// print_r($this->input->post());
// exit;


$this->form_validation->set_rules('vendor_id', 'vendor_id', 'xss_clean|trim');
$this->form_validation->set_rules('credit', 'credit', 'xss_clean|trim');
$this->form_validation->set_rules('debit', 'debit', 'xss_clean|trim');


if($this->form_validation->run()== TRUE)
{


$vendor_id=$this->input->post('vendor_id');
$credit=$this->input->post('credit');
$debit=$this->input->post('debit');





$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

$addedby=$this->session->userdata('admin_id');

$typ=base64_decode($t);
if($typ==1){

$data_insert = array(
    'vendor_id'=>$vendor_id,
    'credit'=>$credit,
    'debit'=>$debit,
'ip' =>$ip,
'added_by' =>$addedby,
'is_active' =>1,
'date'=>$cur_date

);

$last_id=$this->base_model->insert_table("tbl_vendor_pay_req",$data_insert,1) ;

}
if($typ==2){

$idw=base64_decode($iw);


$data_insert = array(	

'vendor_id'=>$vendor_id,
'credit'=>$credit,
'debit'=>$debit

);




$this->db->where('id', $idw);
$last_id=$this->db->update('tbl_vendor_pay_req', $data_insert);

}


if($last_id!=0){

$this->session->set_flashdata('smessage','Data inserted successfully');

redirect("dcadmin/Vendor_pay_req/View_vendor_pay_req","refresh");

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
//****************************Delete vendor_pay_req Function**************************************
public function delete_vendor_pay_req($idd){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');
$id=base64_decode($idd);

if($this->load->get_var('position')=="Super Admin"){

$zapak=$this->db->delete('tbl_vendor_pay_req', array('id' => $id));
if($zapak!=0){
redirect("dcadmin/Vendor_pay_req/View_vendor_pay_req","refresh");
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
//****************************Update vendor_pay_req Status Function**************************************
public function updatevendor_pay_reqStatus($idd,$t){

if(!empty($this->session->userdata('admin_data'))){

$data['user_name']=$this->load->get_var('user_name');

$id=base64_decode($idd);

if($t=="active"){

$data_update = array(
'is_active'=>1

);

$this->db->where('id', $id);
$zapak=$this->db->update('tbl_vendor_pay_req', $data_update);

if($zapak!=0){
redirect("dcadmin/Vendor_pay_req/View_vendor_pay_req","refresh");
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
$zapak=$this->db->update('tbl_vendor_pay_req', $data_update);

if($zapak!=0){
redirect("dcadmin/Vendor_pay_req/View_vendor_pay_req","refresh");
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
//****************************Update vendor_pay_req Function**************************************
public function update_vendor_pay_req($idd){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

// echo SITE_NAME;
// echo $this->session->userdata('image');
// echo $this->session->userdata('position');
// exit;
$id=base64_decode($idd);
$data['id']=$idd;


$this->db->select('*');
$this->db->from('tbl_vendor_pay_req');
$this->db->where('id',$id);
$dsa= $this->db->get();
$data['vendor_pay_req']=$dsa->row();



$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/vendor_pay_req/update_vendor_pay_req');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}



}
