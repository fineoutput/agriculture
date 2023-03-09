<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class DoctorController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }
    //============================================= GetRequests ============================================//
    public function GetRequests()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($doctor_data)) {
            $RequestData = $this->db->order_by('id', 'desc')->get_where('tbl_expert_doctor_req', array('doctor_id' => $doctor_data[0]->id, 'payment_status' => 1))->result();
            $data = [];
            if (!empty($RequestData)) {
                foreach ($RequestData as $request) {
                    $DocData = $this->db->get_where('tbl_doctor', array('id' => $request->doctor_id))->result();
                    $newDate = new DateTime($request->date);
                    if ($request->status == 0) {
                        $status = 'Pending';
                        $bg_color = '#e4a11b';
                    } elseif ($request->status == 1) {
                        $status = 'Completed';
                        $bg_color = '#139c49';
                    }
                    if (!empty($request->image1)) {
                        $image1 = base_url() . $request->image1;
                    } else {
                        $image1 = '';
                    }
                    if (!empty($request->image2)) {
                        $image2 = base_url() . $request->image2;
                    } else {
                        $image2 = '';
                    }
                    if (!empty($request->image3)) {
                        $image3 = base_url() . $request->image3;
                    } else {
                        $image3 = '';
                    }
                    if (!empty($request->image4)) {
                        $image4 = base_url() . $request->image4;
                    } else {
                        $image4 = '';
                    }
                    if (!empty($request->image5)) {
                        $image5 = base_url() . $request->image5;
                    } else {
                        $image5 = '';
                    }
                    if (!empty($DocData[0]->image)) {
                        $doctor_image = base_url() . $DocData[0]->image;
                    } else {
                        $doctor_image = '';
                    }
                    $data[] = array(
                        'id' => $request->id,
                        'doctor_name' => $DocData[0]->name,
                        'doctor_image' => $doctor_image,
                        'reason' => $request->reason,
                        'description' => $request->description,
                        'fees' => $request->fees,
                        'image1' => $image1,
                        'image2' => $image2,
                        'image3' => $image3,
                        'image4' => $image4,
                        'image5' => $image5,
                        'status' => $status,
                        'bg_color' => $bg_color,
                        'date' => $newDate->format('d/m/Y'),
                    );
                }
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $data,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => "No Orders Found!",
                    'status' => 201,
                    'data' => [],
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Permission Denied!',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
}
  //=========================================END DoctorController======================================//
