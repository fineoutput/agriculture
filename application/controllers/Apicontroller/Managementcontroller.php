<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
if (! defined('BASEPATH')) {
exit('No direct script access allowed');
}
class Managementcontroller extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->model("admin/login_model");
$this->load->model("admin/base_model");
$this->load->library('pagination');
}
//================================= Post Data =================================//

//***********************************medical expenses Function************************************
public function medical_expenses()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {

$this->form_validation->set_rules('date', 'date', 'required|xss_clean|trim');
$this->form_validation->set_rules('doctor_visit_fees', 'doctor_visit_fees', 'required|xss_clean|trim');
$this->form_validation->set_rules('treatment_expenses', 'treatment_expenses', 'required|xss_clean|trim');
$this->form_validation->set_rules('vaccination_expenses', 'vaccination_expenses', 'required|xss_clean|trim');
$this->form_validation->set_rules('deworming_expenses', 'deworming_expenses', 'required|xss_clean|trim');
$this->form_validation->set_rules('other1', 'other1', 'required|xss_clean|trim');
$this->form_validation->set_rules('other2', 'other2', 'required|xss_clean|trim');
$this->form_validation->set_rules('other3', 'other3', 'required|xss_clean|trim');
$this->form_validation->set_rules('other4', 'other4', 'required|xss_clean|trim');
$this->form_validation->set_rules('other5', 'other5', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$date=$this->input->post('date');
$doctor_visit_fees=$this->input->post('doctor_visit_fees');
$treatment_expenses=$this->input->post('treatment_expenses');
$vaccination_expenses=$this->input->post('vaccination_expenses');
$deworming_expenses=$this->input->post('deworming_expenses');
$other1=$this->input->post('other1');
$other2=$this->input->post('other2');
$other3=$this->input->post('other3');
$other4=$this->input->post('other4');
$other5=$this->input->post('other5');


$data=[];
$data=array('date'=>$date,
           'doctor_visit_fees'=>$doctor_visit_fees,
           'treatment_expenses'=>$treatment_expenses,
           'vaccination_expenses'=>$vaccination_expenses,
           'deworming_expenses'=>$deworming_expenses,
           'other1'=>$other1,
           'other2'=>$other2,
           'other3'=>$other3,
           'other4'=>$other4,
           'other5'=>$other5
         );

$last_id=$this->base_model->insert_table("tbl_medical_expenses",$data,1) ;

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

//***********************************Reports Function************************************
public function Reports()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {

$this->form_validation->set_rules('filter_reports_by_calendar', 'filter_reports_by_calendar', 'required|xss_clean|trim');
$this->form_validation->set_rules('sale', 'sale', 'required|xss_clean|trim');
$this->form_validation->set_rules('purchase', 'purchase', 'required|xss_clean|trim');
$this->form_validation->set_rules('profit_loss', 'profit_loss', 'required|xss_clean|trim');
$this->form_validation->set_rules('feed_expenses', 'feed_expenses', 'required|xss_clean|trim');
$this->form_validation->set_rules('milk_income', 'milk_income', 'required|xss_clean|trim');
$this->form_validation->set_rules('breeding_income', 'breeding_income', 'required|xss_clean|trim');
$this->form_validation->set_rules('animal_expenses', 'animal_expenses', 'required|xss_clean|trim');
$this->form_validation->set_rules('animal_income', 'animal_income', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$filter_reports_by_calendar=$this->input->post('filter_reports_by_calendar');
$sale=$this->input->post('sale');
$purchase=$this->input->post('purchase');
$profit_loss=$this->input->post('profit_loss');
$feed_expenses=$this->input->post('feed_expenses');
$milk_income=$this->input->post('milk_income');
$breeding_income=$this->input->post('breeding_income');
$animal_expenses=$this->input->post('animal_expenses');
$animal_income=$this->input->post('animal_income');

$data=[];
$data=array('filter_reports_by_calendar'=>$filter_reports_by_calendar,
           'sale'=>$sale,
           'purchase'=>$purchase,
           'profit_loss'=>$profit_loss,
             'feed_expenses'=>$feed_expenses,
           'milk_income'=>$milk_income,
           'breeding_income'=>$breeding_income,
           'animal_expenses'=>$animal_expenses,
           'animal_income'=>$animal_income
         );

$last_id=$this->base_model->insert_table("tbl_reports",$data,1) ;

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
//*************************************Disease Info FUNCTION*********************************************
public function disease_info()

{
    $Disease_data = $this->db->get_where('tbl_disease', array('is_active'=> 1))->result();
    $data=[];
    foreach ($Disease_data as $Disease) {
        if (!empty($Disease->image)) {
            $image=base_url().$Disease->image;
        } else {
            $image='';
        }
        $data[]=array('title'=>$Disease->title,
                   'content'=>$Disease->content
                 );
    }
    $res=array(
                'message'=>"success",
                'status'=>200,
                'data'=>$data
                );
    echo json_encode($res);
}
//***********************************Reports Function************************************
public function select_tank()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {

$this->form_validation->set_rules('tank_name', 'tank_name', 'required|xss_clean|trim');
$this->form_validation->set_rules('number_of_conisters', 'number_of_conisters', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$tank_name=$this->input->post('tank_name');
$number_of_conisters=$this->input->post('number_of_conisters');

$data=[];
$data=array('tank_name'=>$tank_name,
           'number_of_conisters'=>$number_of_conisters
         );

$last_id=$this->base_model->insert_table("tbl_select_tank",$data,1) ;

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
//================================= Post Data =================================//

//***********************************Stock Handling Function************************************
public function stock_handling()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {

$this->form_validation->set_rules('date', 'date', 'required|xss_clean|trim');
$this->form_validation->set_rules('green_forage', 'green_forage', 'required|xss_clean|trim');
$this->form_validation->set_rules('dry_fodder', 'dry_fodder', 'required|xss_clean|trim');
$this->form_validation->set_rules('silage', 'silage', 'required|xss_clean|trim');
$this->form_validation->set_rules('cake', 'cake', 'required|xss_clean|trim');
$this->form_validation->set_rules('grains', 'grains', 'required|xss_clean|trim');
$this->form_validation->set_rules('biproducts', 'biproducts', 'required|xss_clean|trim');
$this->form_validation->set_rules('churi', 'churi', 'required|xss_clean|trim');
$this->form_validation->set_rules('oil_seeds', 'oil_seeds', 'required|xss_clean|trim');
$this->form_validation->set_rules('minerals', 'minerals', 'required|xss_clean|trim');
$this->form_validation->set_rules('bypass_fat', 'bypass_fat', 'required|xss_clean|trim');
$this->form_validation->set_rules('toxins', 'toxins', 'required|xss_clean|trim');
$this->form_validation->set_rules('buffer', 'buffer', 'required|xss_clean|trim');
$this->form_validation->set_rules('yeast', 'yeast', 'required|xss_clean|trim');
$this->form_validation->set_rules('calcium', 'calcium', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$date=$this->input->post('date');
$green_forage=$this->input->post('green_forage');
$dry_fodder=$this->input->post('dry_fodder');
$silage=$this->input->post('silage');
$cake=$this->input->post('cake');
$grains=$this->input->post('grains');
$biproducts=$this->input->post('biproducts');
$churi=$this->input->post('churi');
$oil_seeds=$this->input->post('oil_seeds');
$minerals=$this->input->post('minerals');
$bypass_fat=$this->input->post('bypass_fat');
$toxins=$this->input->post('toxins');
$buffer=$this->input->post('buffer');
$yeast=$this->input->post('yeast');
$calcium=$this->input->post('calcium');


$data=[];
$data=array('date'=>$date,
           'green_forage'=>$green_forage,
           'dry_fodder'=>$dry_fodder,
           'silage'=>$silage,
           'cake'=>$cake,
           'grains'=>$grains,
           'biproducts'=>$biproducts,
           'churi'=>$churi,
           'oil_seeds'=>$oil_seeds,
           'minerals'=>$minerals,
           'bypass_fat'=>$bypass_fat,
           'toxins'=>$toxins,
           'buffer'=>$buffer,
           'yeast'=>$yeast,
           'calcium'=>$calcium
         );

$last_id=$this->base_model->insert_table("tbl_stock_handling",$data,1) ;

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
