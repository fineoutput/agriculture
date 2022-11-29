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

    //================================= GET CITY =================================//
    public function notification()

    {
        $City_data = $this->db->get_where('tbl_notification', array('is_active'=> 1))->result();
        $data=[];
        foreach ($City_data as $cities) {
            if (!empty($cities->image)) {
                $image=base_url().$cities->image;
            } else {
                $image='';
            }
            $data[]=array('name'=>$cities->name,
                        'dsc'=>$cities->dsc,
                       'image'=>$image
                     );
        }
        $res=array(
                    'message'=>"success",
                    'status'=>200,
                    'data'=>$data
                    );
        echo json_encode($res);
    }

}
