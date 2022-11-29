<?php
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
// ****************************silage making*********************************************************
public function silage_making()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {
$this->form_validation->set_rules('no_of_cows', 'no_of_cows', 'required|xss_clean|trim');
$this->form_validation->set_rules('feeding', 'feeding', 'required|xss_clean|trim');
$this->form_validation->set_rules('total_feeding', 'total_feeding', 'required|xss_clean|trim');
$this->form_validation->set_rules('quantity', 'quantity', 'required|xss_clean|trim');
$this->form_validation->set_rules('density', 'density', 'required|xss_clean|trim');
$this->form_validation->set_rules('required_volume_of_pits', 'required_volume_of_pits', 'required|xss_clean|trim');
$this->form_validation->set_rules('breadth', 'breadth', 'required|xss_clean|trim');
$this->form_validation->set_rules('height', 'height', 'required|xss_clean|trim');
$this->form_validation->set_rules('no_of_pits', 'no_of_pits', 'required|xss_clean|trim');
  $this->form_validation->set_rules('length', 'length', 'required|xss_clean|trim');
  $this->form_validation->set_rules('fodder', 'fodder', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$no_of_cows=$this->input->post('no_of_cows');
$feeding=$this->input->post('feeding');
$total_feeding=$this->input->post('total_feeding');
$quantity=$this->input->post('quantity');
$density=$this->input->post('density');
$required_volume_of_pits=$this->input->post('required_volume_of_pits');
$breadth=$this->input->post('breadth');
$height=$this->input->post('height');
$no_of_pits=$this->input->post('no_of_pits');
$length=$this->input->post('length');
$fodder=$this->input->post('fodder');

$cows_data = $this->db->get_where('tbl_silage_making', array('is_active'=> 1))->result();
$data=[];
foreach ($cows_data as $cows) {
if (!empty($cows->photo)) {
    $photo=base_url().$cows->photo;
} else {
    $photo='';
}
$data[]=array('no_of_cows'=>$cows->no_of_cows,
           'feeding'=>$cows->feeding,
           'total_feeding'=>$cows->total_feeding,
           'quantity'=>$quantity,
           'density'=>$cows->density,
           'required_volume_of_pits'=>$cows->required_volume_of_pits,
           'breadth'=>$cows->breadth,
           'height'=>$cows->height,
           'no_of_pits'=>$cows->no_of_pits,
           'length'=>$cows->length,
           'fodder'=>$cows->fodder
         );
}
$res=array(
            'message'=>"success",
            'status'=>200,
            'data'=>$data
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

// ************************************Doctors On Call*************************************************
public function doctors_on_call()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {
$this->form_validation->set_rules('name_english', 'name_english', 'required|xss_clean|trim');
$this->form_validation->set_rules('email', 'email', 'required|xss_clean|trim');
$this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
$this->form_validation->set_rules('degree_english', 'degree_english', 'required|xss_clean|trim');
$this->form_validation->set_rules('education_qualification', 'education_qualification', 'required|xss_clean|trim');
// $this->form_validation->set_rules('qualification', 'qualification', 'required|xss_clean|trim');
$this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
$this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
$this->form_validation->set_rules('phone_number', 'phone_number', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$name_english=$this->input->post('name_english');
$email=$this->input->post('email');
$type=$this->input->post('type');
$degree_english=$this->input->post('degree_english');
$education_qualification=$this->input->post('education_qualification');
// $qualification=$this->input->post('qualification');
$city=$this->input->post('city');
$state=$this->input->post('state');
$phone_number=$this->input->post('phone_number');

$doctors_data = $this->db->get_where('tbl_doctor', array('is_active2'=> 0))->result();
$data=[];
foreach ($doctors_data as $doctors) {
if (!empty($doctors->photo)) {
    $photo=base_url().$doctors->photo;
} else {
    $photo='';
}
$data[]=array('name_english'=>$doctors->name_english,
           'email'=>$doctors->email,
           'type'=>$doctors->type,
           'degree_english'=>$doctors->degree_english,
           'education_qualification'=>$doctors->education_qualification,
           'city'=>$doctors->city,
           'state'=>$doctors->state,
           'phone_number'=>$doctors->phone_number
         );
}
$res=array(
            'message'=>"success",
            'status'=>200,
            'data'=>$data
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

// ************************************Expert Advice Funtion*************************************************
public function expert_advice()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {
  $this->form_validation->set_rules('name_english', 'name_english', 'required|xss_clean|trim');
  $this->form_validation->set_rules('email', 'email', 'required|xss_clean|trim');
  $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
  $this->form_validation->set_rules('degree_english', 'degree_english', 'required|xss_clean|trim');
  $this->form_validation->set_rules('education_qualification', 'education_qualification', 'required|xss_clean|trim');
  $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
  $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
  $name_english=$this->input->post('name_english');
  $email=$this->input->post('email');
  $type=$this->input->post('type');
  $degree_english=$this->input->post('degree_english');
  $education_qualification=$this->input->post('education_qualification');
  $city=$this->input->post('city');
  $state=$this->input->post('state');

$doctors_data = $this->db->get_where('tbl_doctor', array('is_active2'=> 1))->result();
$data=[];
foreach ($doctors_data as $doctors) {
    if (!empty($doctors->photo)) {
        $photo=base_url().$doctors->photo;
    } else {
        $photo='';
    }
    $data[]=array('name_english'=>$doctors->name_english,
               'email'=>$doctors->email,
               'type'=>$doctors->type,
               'degree_english'=>$doctors->degree_english,
               'education_qualification'=>$doctors->education_qualification,
               'city'=>$doctors->city,
               'state'=>$doctors->state
             );
}
$res=array(
                'message'=>"success",
                'status'=>200,
                'data'=>$data
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


// ****************************Pregnancy Calculator************************************************
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

$Calculator_data = $this->db->get_where('tbl_pregnancy_calculator', array('is_active'=> 1))->result();
$data=[];
foreach ($Calculator_data as $Calculator) {
if (!empty($Calculator->photo)) {
$photo=base_url().$Calculator->photo;
} else {
$photo='';
}
$data[]=array('breeding_date'=>$Calculator->breeding_date,
       'estrous_cycle_heat_detection'=>$Calculator->estrous_cycle_heat_detection,
       'age_of_pregnancy'=>$Calculator->age_of_pregnancy,
     );
}
$res=array(
        'message'=>"success",
        'status'=>200,
        'data'=>$data
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
// ************************************Doctors On Call*************************************************
    public function vendor()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('name_english', 'name_english', 'required|xss_clean|trim');
            $this->form_validation->set_rules('shop_name_english', 'shop_name_english', 'required|xss_clean|trim');
            $this->form_validation->set_rules('address_english', 'address_english', 'required|xss_clean|trim');
            $this->form_validation->set_rules('district_english', 'district_english', 'required|xss_clean|trim');
              $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
              $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
                  $this->form_validation->set_rules('email', 'email', 'required|xss_clean|trim');

            if ($this->form_validation->run()== true) {
                $name_english=$this->input->post('name_english');
                $shop_name_english=$this->input->post('shop_name_english');
                $address_english=$this->input->post('address_english');
                $district_english=$this->input->post('district_english');
                $city=$this->input->post('city');
                $state=$this->input->post('state');
                $pincode=$this->input->post('pincode');
                $email=$this->input->post('email');

                $doctors_data = $this->db->get_where('tbl_vendor', array('is_active'=> 0))->result();
                $data=[];
                foreach ($doctors_data as $doctors) {
                    if (!empty($doctors->photo)) {
                        $photo=base_url().$doctors->photo;
                    } else {
                        $photo='';
                    }
                    $data[]=array('name_english'=>$doctors->name_english,
                               'shop_name_english'=>$doctors->shop_name_english,
                               'address_english'=>$doctors->address_english,
                               'district_english'=>$doctors->district_english,
                               'city'=>$doctors->city,
                               'state'=>$doctors->state,
                               'pincode'=>$doctors->pincode,
                               'email'=>$doctors->email
                             );
                }
                $res=array(
                                'message'=>"success",
                                'status'=>200,
                                'data'=>$data
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








}
