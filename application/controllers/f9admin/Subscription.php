<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Subscription extends CI_finecontrol
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }

    //****************************view subscription Function**************************************

    public function View_subscription()
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $this->db->select('*');
            $this->db->from('tbl_subscription');

            $data['subscription_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/subscription/View_subscription');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Add subscription Function**************************************
    public function add_subscription()
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');




            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/subscription/add_subscription');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }
    //****************************Insert subscription Function**************************************
    public function add_subscription_data($t, $iw = "")

    {

        if (!empty($this->session->userdata('admin_data'))) {


            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('service_name', 'service name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('monthly_price', 'monthly price', 'required|xss_clean|trim');
                $this->form_validation->set_rules('monthly_description', 'monthly description', 'required|xss_clean|trim');
                $this->form_validation->set_rules('monthly_service', 'monthly service', 'required|xss_clean|trim');
                $this->form_validation->set_rules('quaterly_price', 'quarterly price', 'required|xss_clean|trim');
                $this->form_validation->set_rules('quaterly_description', 'quarterly description', 'required|xss_clean|trim');
                $this->form_validation->set_rules('quaterly_service', 'quarterly service', 'required|xss_clean|trim');
                $this->form_validation->set_rules('halfyearly_price', 'halfyearly price', 'required|xss_clean|trim');
                $this->form_validation->set_rules('halfyearly_description', 'halfyearly description', 'required|xss_clean|trim');
                $this->form_validation->set_rules('halfyearly_service', 'halfyearly service', 'required|xss_clean|trim');
                $this->form_validation->set_rules('yearly_price', 'yearly price', 'required|xss_clean|trim');
                $this->form_validation->set_rules('yearly_description', 'yearly description', 'required|xss_clean|trim');
                $this->form_validation->set_rules('yearly_service', 'yearly service', 'required|xss_clean|trim');
                $this->form_validation->set_rules('doctor', 'Doctor', 'required|xss_clean|trim');
                $this->form_validation->set_rules('animals', 'Animal', 'required|xss_clean|trim');





                if ($this->form_validation->run() == TRUE) {
                    $service_name = $this->input->post('service_name');
                    $monthly_price = $this->input->post('monthly_price');
                    $monthly_description = $this->input->post('monthly_description');
                    $monthly_service = $this->input->post('monthly_service');
                    $quaterly_price = $this->input->post('quaterly_price');
                    $quaterly_description = $this->input->post('quaterly_description');
                    $quaterly_service = $this->input->post('quaterly_service');
                    $halfyearly_price = $this->input->post('halfyearly_price');
                    $halfyearly_description    = $this->input->post('halfyearly_description');
                    $halfyearly_service = $this->input->post('halfyearly_service');
                    $yearly_price = $this->input->post('yearly_price');
                    $yearly_description = $this->input->post('yearly_description');
                    $yearly_service = $this->input->post('yearly_service');
                    $doctor = $this->input->post('doctor');
                    $animals = $this->input->post('animals');


                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');

                    $idw = base64_decode($iw);

                    $data_insert = array(
                        'service_name' => $service_name,
                        'monthly_price' => $monthly_price,
                        'monthly_description' => $monthly_description,
                        'monthly_service' => $monthly_service,
                        'quarterly_price' => $quaterly_price,
                        'quarterly_description' => $quaterly_description,
                        'quarterly_service' => $quaterly_service,
                        'halfyearly_price' => $halfyearly_price,
                        'halfyearly_description' => $halfyearly_description,
                        'halfyearly_service' => $halfyearly_service,
                        'yearly_price' => $yearly_price,
                        'yearly_description' => $yearly_description,
                        'yearly_service' => $yearly_service,
                        'animals' => $animals,
                        'doctor_calls' => $doctor
                    );

                    $this->db->where('id', $idw);
                    $last_id = $this->db->update('tbl_subscription', $data_insert);
                    if ($last_id != 0) {

                        $this->session->set_flashdata('smessage', 'Data Updated successfully');

                        redirect("dcadmin/subscription/View_subscription", "refresh");
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

    //****************************Update subscription Function**************************************
    public function update_subscription($idd)
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');


            $id = base64_decode($idd);
            $data['id'] = $idd;


            $this->db->select('*');
            $this->db->from('tbl_subscription');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['subscription'] = $dsa->row();



          
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/subscription/update_subscription');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }

    //****************************Delete subscription Function**************************************


    public function delete_subscription($idd)
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');


            $id = base64_decode($idd);

            if ($this->load->get_var('position') == "Super Admin") {


                $zapak = $this->db->delete('tbl_subscription', array('id' => $id));
                if ($zapak != 0) {

                    redirect("dcadmin/subscription/View_subscription", "refresh");
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
    //****************************Update subscription Status Function**************************************
    public function updatesubscriptionStatus($idd, $t)
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $id = base64_decode($idd);

            if ($t == "active") {

                $data_update = array(
                    'is_active' => 1

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_subscription', $data_update);

                if ($zapak != 0) {
                    redirect("dcadmin/subscription/View_subscription", "refresh");
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
                $zapak = $this->db->update('tbl_subscription', $data_update);

                if ($zapak != 0) {
                    redirect("dcadmin/subscription/View_subscription", "refresh");
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
    //****************************Get subscription Function**************************************
    public function getsubscription($a)
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
    public function View_subscribed_data()
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $this->db->select('*');
            $this->db->from('tbl_subscription_buy');
            $this->db->where('payment_status',1);
            $data['subscription_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/subscription/view_subscribed');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }
    public function view_check_feed()
    {

        if (!empty($this->session->userdata('admin_data'))) {


            $data['user_name'] = $this->load->get_var('user_name');

            $this->db->select('*');
            $this->db->from('tbl_subscription_buy');
            $this->db->where('payment_status',1);
            $data['subscription_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/subscription/view_check_feed');
            $this->load->view('admin/common/footer_view');
        } else {

            redirect("login/admin_login", "refresh");
        }
    }
}
