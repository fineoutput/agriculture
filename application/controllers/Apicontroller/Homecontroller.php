<?php
if (! defined('BASEPATH')) {
exit('No direct script access allowed');
}
class Homecontroller extends CI_Controller
{
public function __construct()
{
parent::__construct();
$this->load->model("admin/login_model");
$this->load->model("admin/base_model");
$this->load->library('pagination');
}

//================================= GET Data =================================//
//***********************************Groups Function************************************
public function Groups()
{
$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if ($this->input->post()) {

$this->form_validation->set_rules('create_group', 'create_group', 'required|xss_clean|trim');

if ($this->form_validation->run()== true) {
$create_group=$this->input->post('create_group');


$data=[];
$data=array('create_group'=>$create_group
         );

$last_id=$this->base_model->insert_table("tbl_group",$data,1) ;

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

//================================= GET Data =================================//
//***********************************GET SLIDER Function************************************
public function get_slider()

{
    $Get_data = $this->db->get_where('tbl_slider', array('is_active'=> 1))->result();
    $data=[];
    foreach ($Get_data as $GET) {
        if (!empty($GET->image)) {
            $image=base_url().$GET->image;
        } else {
            $image='';
        }
        $data[]=array('image'=>$GET->image
                 );
    }
    $res=array(
                'message'=>"success",
                'status'=>200,
                'data'=>$data
                );
    echo json_encode($res);
}



}?>
