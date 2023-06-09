<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Farmers extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }
    //****************************view Farmers Function**************************************
    public function View_farmers()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('tbl_farmers');
            $data['farmers_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/View_farmers');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Add Farmers Function**************************************
    public function add_farmers()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('all_cities');
            //$this->db->where('id',$usr);
            $data['city_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('all_states');
            //$this->db->where('id',$usr);
            $data['state_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/add_farmers');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Insert Farmers Function**************************************
    public function add_farmers_data($t, $iw = "")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('village', 'village', 'required|xss_clean|trim');
                $this->form_validation->set_rules('district', 'district', 'required|xss_clean|trim');
                // $this->form_validation->set_rules('village_english', 'name', 'required|xss_clean|trim');
                // $this->form_validation->set_rules('village_hindi', 'name', 'required|xss_clean|trim');
                // $this->form_validation->set_rules('village_punjabi', 'name', 'required|xss_clean|trim');
                // $this->form_validation->set_rules('district_english', 'name', 'required|xss_clean|trim');
                // $this->form_validation->set_rules('district_hindi', 'name', 'required|xss_clean|trim');
                // $this->form_validation->set_rules('district_punjabi', 'Village', 'required|xss_clean|trim');
                $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
                $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
                $this->form_validation->set_rules('Pincode', 'Pincode', 'required|xss_clean|trim');
                $this->form_validation->set_rules('phone_number', 'phone_number', 'required|xss_clean|trim');
                if ($this->form_validation->run() == TRUE) {
                    $name = $this->input->post('name');
                    $village = $this->input->post('village');
                    $district = $this->input->post('district');
                    // $village_english=$this->input->post('village_english');
                    // $village_hindi=$this->input->post('village_hindi');
                    // $village_punjabi=$this->input->post('village_punjabi');
                    // $district_english=$this->input->post('district_english');
                    // $district_hindi=$this->input->post('district_hindi');
                    // $district_punjabi=$this->input->post('district_punjabi');
                    $city = $this->input->post('city');
                    $state = $this->input->post('state');
                    $Pincode = $this->input->post('Pincode');
                    $phone_number = $this->input->post('phone_number');
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $typ = base64_decode($t);
                    if ($typ == 1) {
                        $data_insert = array(
                            'name' => $name,
                            'village' => $village,
                            'district' => $district,
                            // 'village_english'=>$village_english,
                            // 'village_hindi'=>$village_hindi,
                            // 'village_punjabi'=>$village_punjabi,
                            // 'district_english'=>$district_english,
                            // 'district_hindi'=>$district_hindi,
                            // 'district_punjabi'=>$district_punjabi,
                            'city' => $city,
                            'state' => $state,
                            'Pincode' => $Pincode,
                            'phone_number' => $phone_number,
                            'ip' => $ip,
                            'added_by' => $addedby,
                            'is_active' => 1,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_farmers", $data_insert, 1);
                    }
                    if ($typ == 2) {
                        $idw = base64_decode($iw);
                        $data_insert = array(
                            'name' => $name,
                            'village' => $village,
                            'district' => $district,
                            // 'village_english'=>$village_english,
                            // 'village_hindi'=>$village_hindi,
                            // 'village_punjabi'=>$village_punjabi,
                            // 'district_english'=>$district_english,
                            // 'district_hindi'=>$district_hindi,
                            // 'district_punjabi'=>$district_punjabi,
                            'city' => $city,
                            'state' => $state,
                            'Pincode' => $Pincode,
                            'phone_number' => $phone_number
                        );
                        $this->db->where('id', $idw);
                        $last_id = $this->db->update('tbl_farmers', $data_insert);
                    }
                    if ($last_id != 0) {
                        $this->session->set_flashdata('smessage', 'Data inserted successfully');
                        redirect("dcadmin/Farmers/View_farmers", "refresh");
                    } else {
                        $this->session->set_flashdata('smessage', 'Sorry error occured');
                        redirect($_SERVER['HTTP_REFERER']);
                    }
                } else {
                    $this->session->set_flashdata('smessage', validation_errors());
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('smessage', 'Please insert some data, No data available');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Update Farmers Function**************************************
    public function update_farmers($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_farmers');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['farmers'] = $dsa->row();
            $this->db->select('*');
            $this->db->from('all_states');
            //$this->db->where('id',$usr);
            $data['state_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('all_cities');
            //$this->db->where('id',$usr);
            $data['city_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/update_farmers');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Delete Farmers Function**************************************
    public function delete_farmers($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($this->load->get_var('position') == "Super Admin") {
                $zapak = $this->db->delete('tbl_farmers', array('id' => $id));
                if ($zapak != 0) {
                    redirect("dcadmin/Farmers/View_farmers", "refresh");
                } else {
                    echo "Error";
                    exit;
                }
            } else {
                $data['e'] = "Sorry You Don't Have Permission To Delete Anything.";
                // exit;
                $this->load->view('errors/error500admin', $data);
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    //****************************Update Farmers Status Function**************************************
    public function updatefarmersStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($t == "active") {
                $data_update = array(
                    'is_active' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_farmers', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/Farmers/View_farmers", "refresh");
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t == "inactive") {
                $data_update = array(
                    'is_active' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_farmers', $data_update);
                if ($zapak != 0) {
                    redirect("dcadmin/Farmers/View_farmers", "refresh");
                } else {
                    $data['e'] = "Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    //****************************Get Farmers Function**************************************
    public function getfarmers($a)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->db->select('*');
            $this->db->from('all_cities');
            $this->db->where('state_id', $a);
            $cities = $this->db->get();
            $check = $cities->row();
            if (!empty($check)) {
                foreach ($cities->result() as  $c1) {
                    $arr[] = array(
                        'cities_id' => $c1->id,
                        'city_name' => $c1->city_name,
                    );
                }
                echo json_encode($arr);
                exit;
            } else {
                echo "NA";
                exit;
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers records Function**************************************
    public function viewrecords($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            //HEALTH INFO
            $this->db->select('*');
            $this->db->from('tbl_health_info');
            $this->db->where('farmer_id', $id);
            $data['health_info'] = $this->db->count_all_results();

            //BREEDING RECORDS
            $this->db->select('*');
            $this->db->from('tbl_breeding_record');
            $this->db->where('farmer_id', $id);
            $data['breeding_record'] = $this->db->count_all_results();

            //DAILY RECORDS
            $this->db->select('*');
            $this->db->from('tbl_daily_records');
            $this->db->where('farmer_id', $id);
            $data['daily_records'] = $this->db->count_all_results();

            //MILK RECORDS
            $this->db->select('*');
            $this->db->from('tbl_milk_records');
            $this->db->where('farmer_id', $id);
            $data['milk_records'] = $this->db->count_all_results();

            //MEDICAL EXPENSES
            $this->db->select('*');
            $this->db->from('tbl_medical_expenses');
            $this->db->where('farmer_id', $id);
            $data['medical_expenses'] = $this->db->count_all_results();


            //VIEW/SALE PURCHASE LIST
            $this->db->select('*');
            $this->db->from('tbl_sale_purchase');
            $this->db->where('farmer_id', $id);
            $data['sale_purchase'] = $this->db->count_all_results();

            //STOCK LIST
            $this->db->select('*');
            $this->db->from('tbl_stock_handling');
            $this->db->where('farmer_id', $id);
            $data['stock_handling'] = $this->db->count_all_results();


            //SEMAN TANK
            $this->db->select('*');
            $this->db->from('tbl_tank');
            $this->db->where('farmer_id', $id);
            $data['tank'] = $this->db->count_all_results();




            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/viewrecords');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers HEALTH INFO Function**************************************
    public function view_healthinfo($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            $this->db->select('*');
            $this->db->from('tbl_health_info');
            $this->db->where('farmer_id', $id);
            $data['data_health_info'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_healthinfo');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers BREEDING RECORDS Function**************************************
    public function view_breedingrecord($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            $this->db->select('*');
            $this->db->from('tbl_breeding_record');
            $this->db->where('farmer_id', $id);
            $data['data_breeding_record'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_breedingrecord');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers Daily RECORDS Function**************************************
    public function view_dailyrecords($idd)
    {

        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            $para = $this->input->get(); // get parameters



            if (!empty($para)) {

                $start_date = $para['start_date'];
                $end_date = $para['end_date'];
              

                $this->db->select('DISTINCT(entry_id)');
                $this->db->from('tbl_daily_records');
              
                $this->db->where('record_date BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');


             
                $this->db->where('farmer_id', $id);
                $this->db->where('entry_id !=', 0);

              
              $data['data_daily_records'] = $this->db->get();
            } else {
                $this->db->select('DISTINCT(entry_id)');
                $this->db->from('tbl_daily_records');
                $this->db->where('farmer_id', $id);
                $this->db->where('entry_id !=', 0);
                $data['data_daily_records'] = $this->db->get();
            }






            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_dailyrecords');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //****************************view Farmers Daily RECORDS Details Function**************************************
    public function view_detailsdr($idd, $eid)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);

            $data['farmer_id'] = $idd;

            $eids = base64_decode($eid);



            $this->db->select('*');
            $this->db->from('tbl_daily_records');
            $this->db->where('entry_id', $eids);


            $data['data_daily_records'] = $this->db->get();



            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_detailsdr');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers Milk RECORDS Function**************************************
    public function view_milkrecords($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            $this->db->select('*');
            $this->db->from('tbl_milk_records');
            $this->db->where('farmer_id', $id);
            $data['data_milk_records'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_milkrecords');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers Medical Expenses Function**************************************
    public function view_medicalexpenses($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            $this->db->select('*');
            $this->db->from('tbl_medical_expenses');
            $this->db->where('farmer_id', $id);
            $data['data_medical_expenses'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_medicalexpenses');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers Sale Purchase Function**************************************
    public function view_salepurchase($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            $this->db->select('*');
            $this->db->from('tbl_sale_purchase');
            $this->db->where('farmer_id', $id);
            $data['data_sale_purchase'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_salepurchase');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers stock list Function**************************************
    public function view_stockhandling($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            $this->db->select('*');
            $this->db->from('tbl_stock_handling');
            $this->db->where('farmer_id', $id);
            $data['data_stock_handling'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_stockhandling');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //****************************view Farmers Seman Tank  Function**************************************
    public function view_tank($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);
            $data['farmer_id'] = $idd;

            $this->db->select('*');
            $this->db->from('tbl_tank');
            $this->db->where('farmer_id', $id);
            $data['data_tank'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/farmers/view_tank');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
}
