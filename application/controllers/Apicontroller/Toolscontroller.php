<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
if (! defined('BASEPATH')) {
exit('No direct script access allowed');
}
class Toolscontroller extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->model("admin/login_model");
$this->load->model("admin/base_model");
$this->load->library('pagination');
}
//================================= Post Data =================================//

//***********************************Silage_making Function************************************
public function Silage_making()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {

$this->form_validation->set_rules('number_of_cows', 'number_of_cows', 'required|xss_clean|trim');
$this->form_validation->set_rules('feeding', 'feeding', 'required|xss_clean|trim');
$this->form_validation->set_rules('total_feeding_days', 'total_feeding_days', 'required|xss_clean|trim');
$this->form_validation->set_rules('density', 'density', 'required|xss_clean|trim');
$this->form_validation->set_rules('breadth', 'breadth', 'required|xss_clean|trim');
$this->form_validation->set_rules('height', 'height', 'required|xss_clean|trim');
$this->form_validation->set_rules('number_of_pits', 'number_of_pits', 'required|xss_clean|trim');
$this->form_validation->set_rules('fodder_required', 'fodder_required', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$number_of_cows=$this->input->post('number_of_cows');
$feeding=$this->input->post('feeding');
$total_feeding_days=$this->input->post('total_feeding_days');
$density=$this->input->post('density');
$breadth=$this->input->post('breadth');
$height=$this->input->post('height');
$number_of_pits=$this->input->post('number_of_pits');
$fodder_required=$this->input->post('fodder_required');


$data=[];
$data=array('number_of_cows'=>$number_of_cows,
           'feeding'=>$feeding,
           'total_feeding_days'=>$total_feeding_days,
           'density'=>$density,
           'breadth'=>$breadth,
           'height'=>$height,
           'number_of_pits'=>$number_of_pits,
           'fodder_required'=>$fodder_required
         );

$last_id=$this->base_model->insert_table("tbl_silage_making",$data,1) ;

$res=array(
            'message'=>"success",
            'status'=>200,
            'data'=>[]
            );
echo json_encode($res);
} else {
$res=array(
'message'=>validation_errors(),
'status'=>201
);
echo json_encode($res);
}
} else {
$res=array(
'message'=>'please insert data',
'status'=>201
);
echo json_encode($res);
}
}
//***********************************Silage_making Function************************************
public function pregnancy_calculator()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {

$this->form_validation->set_rules('breeding_date', 'breeding_date', 'required|xss_clean|trim');
$this->form_validation->set_rules('estrous_cycle_heat_detection', 'estrous_cycle_heat_detection', 'required|xss_clean|trim');
$this->form_validation->set_rules('age_of_pregnancy', 'age_of_pregnancy', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$breeding_date=$this->input->post('breeding_date');
$estrous_cycle_heat_detection=$this->input->post('estrous_cycle_heat_detection');
$age_of_pregnancy=$this->input->post('age_of_pregnancy');


$data=[];
$data=array('breeding_date'=>$breeding_date,
           'estrous_cycle_heat_detection'=>$estrous_cycle_heat_detection,
           'age_of_pregnancy'=>$age_of_pregnancy
         );

$last_id=$this->base_model->insert_table("tbl_pregnancy_calculator",$data,1) ;

$res=array(
            'message'=>"success",
            'status'=>200,
            'data'=>[]
            );
echo json_encode($res);
} else {
$res=array(
'message'=>validation_errors(),
'status'=>201
);
echo json_encode($res);
}
} else {
$res=array(
'message'=>'please insert data',
'status'=>201
);
echo json_encode($res);
}
}




}?>
