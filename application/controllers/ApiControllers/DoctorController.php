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
            $RequestData = $this->db->order_by('id', 'desc')->get_where('tbl_doctor_req', array('doctor_id' => $doctor_data[0]->id, 'is_expert' => $doctor_data[0]->is_expert, 'payment_status' => 1))->result();
            $data = [];
            if (!empty($RequestData)) {
                foreach ($RequestData as $request) {
                    $farData = $this->db->get_where('tbl_farmers', array('id' => $request->farmer_id))->result();
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
                    $data[] = array(
                        'id' => $request->id,
                        'farmer_name' => $farData[0]->name,
                        'farmer_phone' => $farData[0]->phone,
                        'farmer_village' => $farData[0]->village,
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
    //============================================= ReqMarkComplete ============================================//
    public function ReqMarkComplete($id)
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($doctor_data)) {
            $data_update = array(
                'status' => 1,
            );
            $this->db->where('doctor_id', $doctor_data[0]->id);
            $this->db->where('is_expert', $doctor_data[0]->is_expert);
            $this->db->where('id', $id);
            $zapak = $this->db->update('tbl_doctor_req', $data_update);
            if (!empty($zapak)) {
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => "Some error occurred!",
                    'status' => 201,
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
    //============================================= GetProfile ============================================//
    public function GetProfile()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'auth' => $authentication))->result();
        //----- Verify Auth --------
        if (!empty($doctor_data)) {
            if (!empty($doctor_data[0]->aadhar_image)) {
                $image = base_url() . $doctor_data[0]->aadhar_image;
            } else {
                $image = '';
            }
            $data = array(
                'name' => $doctor_data[0]->name,
                'district' => $doctor_data[0]->district,
                'city' => $doctor_data[0]->city,
                'state' => $doctor_data[0]->state,
                'phone' => $doctor_data[0]->phone,
                'email' => $doctor_data[0]->email,
                'type' => $doctor_data[0]->type,
                'degree' => $doctor_data[0]->degree,
                'experience' => $doctor_data[0]->experience,
                'qualification' => $doctor_data[0]->qualification,
                'aadhar_image' => $image,
                'is_expert' => $doctor_data[0]->is_expert,
                'expertise' => $doctor_data[0]->expertise,
            );
            $res = array(
                'message' => "Success!",
                'status' => 200,
                'data' => $data,
            );
            echo json_encode($res);
        } else {
            $res = array(
                'message' => 'Permission Denied!',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //====================================================== UpdateProfile ================================================//
    public function UpdateProfile()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('expertise', 'expertise', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $expertise = $this->input->post('expertise');
                $doctor_data = $this->db->get_where('tbl_doctor', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($doctor_data)) {
                    $data_update = array('expertise' => $expertise,);
                    $this->db->where('id', $doctor_data[0]->id);
                    $zapak = $this->db->update('tbl_doctor', $data_update);
                    $res = array(
                        'message' => "Success",
                        'status' => 200,
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Permission Denied!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => validation_errors(),
                    'status' => 201
                );
                echo json_encode($res);
            }
        } else {
            $res = array(
                'message' => 'Please Insert Data',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
}
  //=========================================END DoctorController======================================//
