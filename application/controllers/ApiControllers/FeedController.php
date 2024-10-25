<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class FeedController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library('pagination');
    }
    //====================================================== CalculateWeight================================================//
    public function CalculateWeight()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
            $this->form_validation->set_rules('grith', 'grith', 'required|xss_clean|trim');
            $this->form_validation->set_rules('length', 'length', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $type = $this->input->post('type');
                $grith = $this->input->post('grith');
                $length = $this->input->post('length');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    if ($type == 'Inches') {
                        $weight = ($grith * $grith * $length) / 660 + 0.5;
                    } else {
                        $weight = ($grith * $grith * $length) / 10797 + 0.5;
                    }
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('weight_calculator' => $service_data[0]->weight_calculator + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $addedby = $this->session->userdata('admin_id');
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'weight_calculator',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $weight
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
    //====================================================== DMI CALCULATOR================================================//
    public function dmi_calculator()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('lactation', 'lactation', 'required|xss_clean|trim');
            $this->form_validation->set_rules('feed_percentage', 'feed_percentage', 'required|xss_clean|trim');
            $this->form_validation->set_rules('milk_yield', 'milk_yield', 'required|xss_clean|trim');
            $this->form_validation->set_rules('weight', 'weight', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $lactation = $this->input->post('lactation');
                $feed_percentage = $this->input->post('feed_percentage');
                $milk_yield = $this->input->post('milk_yield');
                $weight = $this->input->post('weight');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    $dry_matter_intake = 33 / 100 * $milk_yield + 2 / 100 * $weight;
                    $feed = $feed_percentage / 100 * $dry_matter_intake;
                    $fodder = $dry_matter_intake - $feed;
                    $feed_qty = 100 / 90 * $feed;
                    //---green fodder ------
                    $green_fodder = 60 / 100 * $fodder;
                    $maize = 100 / 22 * $green_fodder;
                    $barseem = 100 / 17 * $green_fodder;
                    //--- dry fodder ------
                    $dry_fodder = 40 / 100 * $fodder;
                    $hary = 100 / 95 * $dry_fodder;
                    //---silage ------
                    $silage_dm = $fodder;
                    $silage = 100 / 30 * $silage_dm;
                    $send = [];
                    $inputs = array(
                        'lactation' => $lactation,
                        'feed_percentage' => $feed_percentage,
                        'milk_yield' => $milk_yield,
                        'weight' => $weight,
                    );
                    $data['input'] = $inputs;
                    $data1 = array(
                        'dry_matter_intake' => round($dry_matter_intake, 2),
                        'feed' => round($feed, 2),
                        'fodder' => round($fodder, 2),
                        'feed_qty' => round($feed_qty, 2),
                        'green_fodder' => round($green_fodder, 2),
                        'maize' => round($maize, 2),
                        'barseem' => round($barseem, 2),
                        'dry_fodder' => round($dry_fodder, 2),
                        'hary' => round($hary, 2),
                        'silage_dm' => round($silage_dm, 2),
                        'silage' => round($silage, 2),
                    );
                    $data['result'] = $data1;
                    $message = $this->load->view('pdf/dmi', $data, TRUE);
                    $send = array(
                        'dry_matter_intake' => round($dry_matter_intake, 2),
                        'feed' => round($feed, 2),
                        'fodder' => round($fodder, 2),
                        'feed_qty' => round($feed_qty, 2),
                        'green_fodder' => round($green_fodder, 2),
                        'maize' => round($maize, 2),
                        'barseem' => round($barseem, 2),
                        'dry_fodder' => round($dry_fodder, 2),
                        'hary' => round($hary, 2),
                        'silage_dm' => round($silage_dm, 2),
                        'silage' => round($silage, 2),
                        'html' => $message,
                    );
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('dmi_calculator' => $service_data[0]->dmi_calculator + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $addedby = $this->session->userdata('admin_id');
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'dmi_calculator',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $send
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
    public function feed_test()
    {
        $feed_percentage = 45;
        $milk_yield = 12;
        $weight = 25;
        $dry_matter_intake = 33 / 100 * $milk_yield + 2 / 100 * $weight;
        $feed = $feed_percentage / 100 * $dry_matter_intake;
        $fodder = $dry_matter_intake - $feed;
        $feed_qty = 100 / 90 * $feed;
        //---green fodder ------
        $green_fodder = 60 / 100 * $fodder;
        $maize = 100 / 22 * $green_fodder;
        $barseem = 100 / 17 * $green_fodder;
        //--- dry fodder ------
        $dry_fodder = 40 / 100 * $fodder;
        $hary = 100 / 95 * $dry_fodder;
        //---silage ------
        $silage_dm = $fodder;
        $silage = 100 / 30 * $silage_dm;
        $data1 = [];
        $inputs = array(
            'phase' => 'Mid-lactation',
            'feed_percentage' => $feed_percentage,
            'milk_yield' => $milk_yield,
            'weight' => $weight,
        );
        $data['input'] = $inputs;
        $data1 = array(
            'dry_matter_intake' => round($dry_matter_intake, 2),
            'feed' => round($feed, 2),
            'fodder' => round($fodder, 2),
            'feed_qty' => round($feed_qty, 2),
            'green_fodder' => round($green_fodder, 2),
            'maize' => round($maize, 2),
            'barseem' => round($barseem, 2),
            'dry_fodder' => round($dry_fodder, 2),
            'hary' => round($hary, 2),
            'silage_dm' => round($silage_dm, 2),
            'silage' => round($silage, 2),
        );
        $data['result'] = $data1;
        $message = $this->load->view('pdf/dmi', $data, TRUE);
        // print_r($message);
        // die();
        $res = array(
            'message' => "Success!",
            'status' => 200,
            'data' => $data1
        );
        echo json_encode($res);
    }
    //====================================================== FEED CALCULATOR================================================//
    public function feed_calculator()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('ProteinData', 'ProteinData', 'xss_clean|trim');
            $this->form_validation->set_rules('EnergyData', 'EnergyData', 'xss_clean|trim');
            $this->form_validation->set_rules('ProductData', 'ProductData', 'xss_clean|trim');
            $this->form_validation->set_rules('MedicineData', 'MedicineData', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $ProteinData = $this->input->post('ProteinData');
                $EnergyData = $this->input->post('EnergyData');
                $ProductData = $this->input->post('ProductData');
                $MedicineData = $this->input->post('MedicineData');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    $send = [];
                    $cp = 0;
                    $ee = 0;
                    $cf = 0;
                    $tdn = 0;
                    $me = 0;
                    $ca = 0;
                    $p = 0;
                    $adf = 0;
                    $ndf = 0;
                    $nel = 0;
                    $rudp = 0;
                    $endf = 0;
                    $value = 0;
                    $prot = json_decode($ProteinData);
                    foreach ($prot as $prt) {
                        if (!empty($prt[3])) {
                            $cp += $prt[4] ? $prt[4] * $prt[3] / 1000 : 0;
                            $ee += $prt[5] ? $prt[5] * $prt[3] / 1000 : 0;
                            $cf +=  $prt[6] ? $prt[6] * $prt[3] / 1000 : 0;
                            $tdn +=  $prt[7] ? $prt[7] * $prt[3] / 1000 : 0;
                            $me +=  $prt[8] ? $prt[8] * $prt[3] / 1000 : 0;
                            $ca +=  $prt[9] ? $prt[9] * $prt[3] / 1000 : 0;
                            $p +=  $prt[10] ? $prt[10] * $prt[3] / 1000 : 0;
                            $adf += $prt[11] ? $prt[11] * $prt[3] / 1000 : 0;
                            $ndf +=  $prt[12] ? $prt[12] * $prt[3] / 1000 : 0;
                            $nel +=  $prt[13] ? $prt[13] * $prt[3] / 1000 : 0;
                            $rudp +=  $prt[14] ? $prt[14] * $prt[3] / 1000 : 0;
                            $endf +=  $prt[15] ? $prt[15] * $prt[3] / 1000 : 0;
                            $value +=  $prt[3] ? $prt[2] * $prt[3]  : 0;
                        }
                    }
                    $Energy = json_decode($EnergyData);
                    foreach ($Energy as $enr) {
                        if (!empty($enr[3])) {
                            $cp += $enr[4] ? $enr[4] * $enr[3] / 1000 : 0;
                            $ee += $enr[5] ? $enr[5] * $enr[3] / 1000 : 0;
                            $cf += $enr[6] ? $enr[6] * $enr[3] / 1000 : 0;
                            $tdn += $enr[7] ? $enr[7] * $enr[3] / 1000 : 0;
                            $me += $enr[8] ? $enr[8] * $enr[3] / 1000 : 0;
                            $ca += $enr[9] ? $enr[9] * $enr[3] / 1000 : 0;
                            $p += $enr[10] ? $enr[10] * $enr[3] / 1000 : 0;
                            $adf += $enr[11] ? $enr[11] * $enr[3] / 1000 : 0;
                            $ndf += $enr[12] ? $enr[12] * $enr[3] / 1000 : 0;
                            $nel += $enr[13] ? $enr[13] * $enr[3] / 1000 : 0;
                            $rudp += $enr[14] ? $enr[14] * $enr[3] / 1000 : 0;
                            $endf += $enr[15] ? $enr[15] * $enr[3] / 1000 : 0;
                            $value +=  $enr[3] ? $enr[2] * $enr[3]  : 0;
                        }
                    }
                    $Product = json_decode($ProductData);
                    foreach ($Product as $pro) {
                        if (!empty($pro[3])) {
                            $cp += $pro[4] ? $pro[4] * $pro[3] / 1000 : 0;
                            $ee += $pro[5] ? $pro[5] * $pro[3] / 1000 : 0;
                            $cf += $pro[6] ? $pro[6] * $pro[3] / 1000 : 0;
                            $tdn += $pro[7] ? $pro[7] * $pro[3] / 1000 : 0;
                            $me += $pro[8] ? $pro[8] * $pro[3] / 1000 : 0;
                            $ca += $pro[9] ? $pro[9] * $pro[3] / 1000 : 0;
                            $p += $pro[10] ? $pro[10] * $pro[3] / 1000 : 0;
                            $adf += $pro[11] ? $pro[11] * $pro[3] / 1000 : 0;
                            $ndf += $pro[12] ? $pro[12] * $pro[3] / 1000 : 0;
                            $nel += $pro[13] ? $pro[13] * $pro[3] / 1000 : 0;
                            $rudp += $pro[14] ? $pro[14] * $pro[3] / 1000 : 0;
                            $endf += $pro[15] ? $pro[15] * $pro[3] / 1000 : 0;
                            $value +=  $pro[3] ? $pro[2] * $pro[3] : 0;
                        }
                    }
                    $Medicine = json_decode($MedicineData);
                    foreach ($Medicine as $med) {
                        if (!empty($med[3])) {
                            $cp += $med[4] ? $med[4] * $med[3] / 1000 : 0;
                            $ee += $med[5] ? $med[5] * $med[3] / 1000 : 0;
                            $cf += $med[6] ? $med[6] * $med[3] / 1000 : 0;
                            $tdn += $med[7] ? $med[7] * $med[3] / 1000 : 0;
                            $me += $med[8] ? $med[8] * $med[3] / 1000 : 0;
                            $ca += $med[9] ? $med[9] * $med[3] / 1000 : 0;
                            $p += $med[10] ? $med[10] * $med[3] / 1000 : 0;
                            $adf += $med[11] ? $med[11] * $med[3] / 1000 : 0;
                            $ndf += $med[12] ? $med[12] * $med[3] / 1000 : 0;
                            $nel += $med[13] ? $med[13] * $med[3] / 1000 : 0;
                            $rudp += $med[14] ? $med[14] * $med[3] / 1000 : 0;
                            $endf += $med[15] ? $med[15] * $med[3] / 1000 : 0;
                            $value +=  $med[3] ? $med[2] * $med[3]  : 0;
                        }
                    }
                    $fresh =  array(
                        'CP' => round($cp, 2),
                        'FAT' => round($ee, 2),
                        'FIBER' => round($cf, 2),
                        'TDN' => round($tdn, 2),
                        'ENERGY' => round($me, 2),
                        'CA' => round($ca, 2),
                        'P' => round($p, 2),
                        'RUDP' => round($rudp, 2),
                        'ADF' => round($adf, 2),
                        'NDF' => round($ndf, 2),
                        'NEL' =>  round(((0.0245 * round($tdn, 2)) - (0.12 * 0.454)), 2),
                        'ENDF' => round($endf, 2),
                    );
                    $dmb_tdn = $tdn > 0 ? round(($tdn * 12 / 100 + $tdn), 2) : 0;
                    $dmb =  array(
                        'CP' => $cp > 0 ? round(($cp * 12 / 100 + $cp), 2) : 0,
                        'FAT' => $ee > 0 ? round(($ee * 12 / 100 + $ee), 2) : 0,
                        'FIBER' => $cf > 0 ? round(($cf * 12 / 100 + $cf), 2) : 0,
                        'TDN' => $dmb_tdn,
                        'ENERGY' => $me > 0 ? round(($me * 12 / 100 + $me), 2) : 0,
                        'CA' => $ca > 0 ? round(($ca * 12 / 100 + $ca), 2) : 0,
                        'P' => $p > 0 ? round(($p * 12 / 100 + $p), 2) : 0,
                        'RUDP' => $rudp > 0 ? round(($rudp * 12 / 100 + $rudp), 2) : 0,
                        'ADF' => $adf > 0 ? round(($adf * 12 / 100 + $adf), 2) : 0,
                        'NDF' => $ndf > 0 ? round(($ndf * 12 / 100 + $ndf), 2) : 0,
                        'NEL' =>  round(((0.0245 * $dmb_tdn) - (0.12 * 0.454)), 2),
                        'ENDF' => $endf > 0 ? round(($endf * 12 / 100 + $endf), 2) : 0,
                    );
                    $data1 = array(
                        'fresh' => $fresh,
                        'dmb' => $dmb,
                        'row_ton' => round(($value), 2),
                        'row_qtl' => round(($value / 10), 2),
                        'ProteinData' => $ProteinData,
                        'EnergyData' => $EnergyData,
                        'ProductData' => $ProductData,
                        'MedicineData' => $MedicineData,
                    );
                    $data['result'] = $data1;
                    $message = $this->load->view('pdf/feed', $data, TRUE);
                    $send = array(
                        'fresh' => $fresh,
                        'dmb' => $dmb,
                        'row_ton' => round(($value), 2),
                        'row_qtl' => round(($value / 10), 2),
                        'html' => $message,
                    );
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('feed_calculator' => $service_data[0]->feed_calculator + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'feed_calculator',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $send
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
    //====================================================== Animal Requirements ================================================//
    public function animalRequirements()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('group', 'group', 'required|xss_clean|trim');
            $this->form_validation->set_rules('feeding_system', 'feeding_system', 'required|xss_clean|trim');
            $this->form_validation->set_rules('weight', 'weight', 'required|xss_clean|trim');
            $this->form_validation->set_rules('milk_production', 'milk_production', 'required|xss_clean|trim');
            $this->form_validation->set_rules('days_milk', 'days_milk', 'required|xss_clean|trim');
            $this->form_validation->set_rules('milk_fat', 'milk_fat', 'required|xss_clean|trim');
            $this->form_validation->set_rules('milk_protein', 'milk_protein', 'required|xss_clean|trim');
            $this->form_validation->set_rules('milk_lactose', 'milk_lactose', 'required|xss_clean|trim');
            $this->form_validation->set_rules('weight_variation', 'weight_variation', 'required|xss_clean|trim');
            $this->form_validation->set_rules('bcs', 'bcs', 'required|xss_clean|trim');
            $this->form_validation->set_rules('gestation_days', 'gestation_days', 'required|xss_clean|trim');
            $this->form_validation->set_rules('temp', 'temp', 'required|xss_clean|trim');
            $this->form_validation->set_rules('humidity', 'humidity', 'required|xss_clean|trim');
            $this->form_validation->set_rules('thi', 'thi', 'required|xss_clean|trim');
            $this->form_validation->set_rules('fat_4', 'fat_4', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $group = $this->input->post('group');
                $feeding_system = $this->input->post('feeding_system');
                $weight = $this->input->post('weight');
                $milk_production = $this->input->post('milk_production');
                $days_milk = $this->input->post('days_milk');
                $milk_fat = $this->input->post('milk_fat');
                $milk_protein = $this->input->post('milk_protein');
                $milk_lactose = $this->input->post('milk_lactose');
                $weight_variation = $this->input->post('weight_variation');
                $bcs = $this->input->post('bcs');
                $gestation_days = $this->input->post('gestation_days');
                $temp = $this->input->post('temp');
                $humidity = $this->input->post('humidity');
                $thi = $this->input->post('thi');
                $fat_4 = $this->input->post('fat_4');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    $input = array(
                        'group' => $group,
                        'feeding_system' => $feeding_system,
                        'weight' => $weight,
                        'milk_production' => $milk_production,
                        'days_milk' => $days_milk,
                        'milk_fat' => $milk_fat,
                        'milk_protein' => $milk_protein,
                        'milk_lactose' => $milk_lactose,
                        'weight_variation' => $weight_variation,
                        'bcs' => $bcs,
                        'gestation_days' => $gestation_days,
                        'temp' => $temp,
                        'humidity' => $humidity,
                        'thi' => $thi,
                        'fat_4' => $fat_4,
                    );
                    $data['input'] = $input;
                    require_once APPPATH . "/third_party/PHPExcel.php"; //------ INCLUDE EXCEL
                    $inputFileName = 'assets/excel/animal_requirement.xlsx';
                    $inputFileName2 = 'assets/excel/animal_requirement.xls';
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel1 = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }
                    //  Get worksheet dimensions
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('F21', $group);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('F22', $feeding_system);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('F23', $weight);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('F24', $milk_production);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('F25', $days_milk);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('F26', $milk_fat);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('F27', $milk_protein);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('F28', $milk_lactose);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('I21', $weight_variation);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('I22', $bcs);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('I23', $gestation_days);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('I24', $temp);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('I25', $humidity);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('I26', $thi);
                    $objPHPExcel1->setActiveSheetIndex(0)->setCellValue('I27', $fat_4);
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel1, 'Excel2007');
                    $objWriter->setPreCalculateFormulas(true);
                    $objWriter->save('assets/excel/animal_requirement.xls');
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName2);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName2);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName2, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }
                    $data['objPHPExcel'] = $objPHPExcel;
                    $message = $this->load->view('pdf/animal_requirements', $data, TRUE);
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('animal_req' => $service_data[0]->animal_req + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'animal_req',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $message
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
    //====================================================== Check my Feed ================================================//
    public function check_my_feed()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $headers = apache_request_headers();
            $authentication = $headers['Authentication'];
            $this->form_validation->set_rules('lactation', 'feed lactation', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('feed_percentage', 'feed percentage', 'required|xss_clean|trim');
            $this->form_validation->set_rules('live_weight', 'live weight', 'xss_clean|trim');
            $this->form_validation->set_rules('pregnancy', 'pregnancy', 'xss_clean|trim');
            $this->form_validation->set_rules('milk_yield_volume', 'milk yield volume', 'xss_clean|trim');
            $this->form_validation->set_rules('milk_yield_fat', 'milk yield fat', 'xss_clean|trim');
            $this->form_validation->set_rules('milk_yield_protein', 'milk yield protein', 'xss_clean|trim');
            $this->form_validation->set_rules('live_weight_gain', 'live weight gain', 'xss_clean|trim');
            $this->form_validation->set_rules('milk_return', 'milk return', 'xss_clean|trim');
            $this->form_validation->set_rules('material', 'material', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $lactation = $this->input->post('lactation');
                // $feed_percentage = $this->input->post('feed_percentage');
                $live_weight = $this->input->post('live_weight');
                $pregnancy = $this->input->post('pregnancy');
                $milk_yield_volume = $this->input->post('milk_yield_volume');
                $milk_yield_fat = $this->input->post('milk_yield_fat');
                $milk_yield_protein = $this->input->post('milk_yield_protein');
                $live_weight_gain = $this->input->post('live_weight_gain');
                $milk_return = $this->input->post('milk_return');
                $material = json_decode($this->input->post('material'));
                // print_r($material);
                // die();
                // $arr = "[{\"label\":\"CHANA CHURI\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"GREEN FODDER (MAIZE)\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"SILAGE MAIZE\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"COTTON CAKE\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"COTTON SEED\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"MUSTARD CAKE\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"RICE POLISH\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"DORB\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"SOYA DOC\",\"value\":true,\"fresh\":\"58\",\"price\":\"3\"},{\"label\":\"MUSTARD DOC\",\"value\":true,\"fresh\":\"56\",\"price\":\"7\"},{\"label\":\"WHEAT\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"GUAR KORMA\",\"value\":true,\"fresh\":\"25\",\"price\":\"5\"},{\"label\":\"MAIZE GRAIN\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"CATTLE FEED\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"WHEAT BRAN\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"WHEAT STRAW\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"MOLASSES\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"MUNG CHURI\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"MAKKA KHAL\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"GREEN FODDER (BARSEEM)\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"GROUNDNUT CAKE\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"BARLEY\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"RICE BROKEN\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"UREA\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"MINERAL MIXTURE\",\"value\":false,\"fresh\":\"\",\"price\":\"\"},{\"label\":\"BY PASS FAT\",\"value\":false,\"fresh\":\"\",\"price\":\"\"}]";
                // $material = json_decode($arr);
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->row();
                if (!empty($farmer_data)) {
                    // $lactation = "Early lactation";
                    // $feed_percentage = $this->input->post('feed_percentage');
                    // $live_weight =600;
                    // $pregnancy = 0;
                    // $milk_yield_volume = 25;
                    // $milk_yield_fat = 3.5;
                    // $milk_yield_protein = 3;
                    // $live_weight_gain =10;
                    // $milk_return = 40;
                    $input = array(
                        'lactation' => $lactation,
                        // 'feed_percentage' => $feed_percentage,
                        'live_weight' => $live_weight,
                        'pregnancy' => $pregnancy,
                        'milk_yield_volume' => $milk_yield_volume,
                        'milk_yield_fat' => $milk_yield_fat,
                        'milk_yield_protein' => $milk_yield_protein,
                        'live_weight_gain' => $live_weight_gain,
                        'milk_return' => $milk_return,
                        'material' => $material,
                        // 'ca' => $ca,
                        // 'pa' => $pa,
                    );
                    $data['input'] = $input;
                    require_once APPPATH . "/third_party/PHPExcel.php"; //------ INCLUDE EXCEL
                    $inputFileName = 'assets/excel/check_my_feed.xlsm';
                    $inputFileName2 = 'assets/excel/check_my_feed.xlsm';
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel1 = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }
                    //  Get worksheet dimensions
                    $objPHPExcel1->setActiveSheetIndex(1)->setCellValue('B13', $lactation);
                    $objPHPExcel1->setActiveSheetIndex(1)->setCellValue('C4', $live_weight);
                    $objPHPExcel1->setActiveSheetIndex(1)->setCellValue('C5', $pregnancy);
                    $objPHPExcel1->setActiveSheetIndex(1)->setCellValue('C6', $milk_yield_volume);
                    $objPHPExcel1->setActiveSheetIndex(1)->setCellValue('C7', $milk_yield_fat);
                    $objPHPExcel1->setActiveSheetIndex(1)->setCellValue('C8', $milk_yield_protein);
                    $objPHPExcel1->setActiveSheetIndex(1)->setCellValue('C9', $live_weight_gain);
                    $objPHPExcel1->setActiveSheetIndex(3)->setCellValue('D12', $milk_return);
                    $i = 4;
                    $p = 7;
                    foreach ($material as $mat) {
                        if ($mat->value == true) {
                            $objPHPExcel1->setActiveSheetIndex(2)->setCellValue('D' . $i, $mat->fresh);
                            $objPHPExcel1->setActiveSheetIndex(4)->setCellValue('C' . $p, $mat->price);
                        } else {
                            $objPHPExcel1->setActiveSheetIndex(2)->setCellValue('D' . $i, 0);
                            $objPHPExcel1->setActiveSheetIndex(4)->setCellValue('C' . $p, 0);
                        }
                        $i++;
                        $p++;
                    }
                    // $objPHPExcel1->setActiveSheetIndex(3)->setCellValue('D19', $ca);
                    // $objPHPExcel1->setActiveSheetIndex(3)->setCellValue('D22', $pa);
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel1, 'Excel2007');
                    $objWriter->setPreCalculateFormulas(true);
                    $objWriter->save('assets/excel/check_my_feed.xlsm');
                    // die();
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName2);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName2);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName2, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }
                    $data['objPHPExcel'] = $objPHPExcel;
                    $data['farmername'] = $farmer_data->name;
                    // $data['farmername'] = 'Nitesh';
                    $message = $this->load->view('pdf/check_my_feed', $data, TRUE);
                    // print_r($message);
                    // die();
                    //------- update service record -----------
                    $service_data = $this->db->get_where('tbl_service_records')->result();
                    $data_update = array('check_my_feed' => $service_data[0]->check_my_feed + 1);
                    $this->db->where('id', $service_data[0]->id);
                    $zapak = $this->db->update('tbl_service_records', $data_update);
                    //---- create txn ------
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $only_date = date("Y-m-d");
                    $data_insert = array(
                        'farmer_id' => $farmer_data->id,
                        'service' => 'check_my_feed',
                        'ip' => $ip,
                        'date' => $cur_date,
                        'only_date' => $only_date,
                    );
                    $last_id = $this->base_model->insert_table("tbl_service_records_txn", $data_insert, 1);
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $message
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
    //====================================================== DAIRY MART ================================================//
    public function dairy_mart()
    {
        $City_data = $this->db->get_where('tbl_products', array('is_active' => 1))->result();
        $data = [];
        foreach ($City_data as $API) {
            if (!empty($API->image)) {
                $image = base_url() . $API->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name_english' => $API->name_english,
                'name_hindi' => $API->name_hindi,
                'name_punjabi' => $API->name_punjabi,
                'description_english' => $API->description_english,
                'description_hindi' => $API->description_hindi,
                'description_punjabi' => $API->description_punjabi,
                'min_qty' => $API->min_qty ? $API->min_qty : 1,
                'image1' => $API->image1,
                'image2' => $API->image2,
                'mrp' => $API->mrp,
                'selling_price' => $API->selling_price,
                'inventory' => $API->inventory
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== DOCTOR ON CALL================================================//
    public function doctor_on_call()
    {
        $City_data = $this->db->get_where('tbl_doctor', array('is_active2' => 0))->result();
        $data = [];
        foreach ($City_data as $DOCTOR) {
            if (!empty($DOCTOR->image)) {
                $image = base_url() . $DOCTOR->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name_english' => $DOCTOR->name_english,
                'name_hindi' => $DOCTOR->name_hindi,
                'name_punjabi' => $DOCTOR->name_punjabi,
                'email' => $DOCTOR->email,
                'degree_english' => $DOCTOR->degree_english,
                'degree_hindi' => $DOCTOR->degree_hindi,
                'degree_punjabi' => $DOCTOR->degree_punjabi,
                'image' => $DOCTOR->image
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== EXPERT ADVICE ================================================//
    public function expert_advice()
    {
        $Expert_data = $this->db->get_where('tbl_doctor', array('is_active2' => 1))->result();
        $data = [];
        foreach ($Expert_data as $Expert) {
            if (!empty($Expert->image)) {
                $image = base_url() . $Expert->image;
            } else {
                $image = '';
            }
            $data[] = array(
                'name_english' => $Expert->name_english,
                'name_hindi' => $Expert->name_hindi,
                'name_punjabi' => $Expert->name_punjabi,
                'email' => $Expert->email,
                'type' => $Expert->type,
                'degree_english' => $Expert->degree_english,
                'degree_hindi' => $Expert->degree_hindi,
                'degree_punjabi' => $Expert->degree_punjabi,
                'education_qualification' => $Expert->education_qualification,
                'city' => $Expert->city,
                'state' => $Expert->state,
                'phone_number' => $Expert->phone_number,
                'image' => $Expert->image
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== RADIUS VENDOR================================================//
    public function radius_vendor()
    {
        $Vendor_data = $this->db->get_where('tbl_vendor', array('is_active' => 0))->result();
        $data = [];
        foreach ($Vendor_data as $Vendor) {
            $data[] = array(
                'name_english' => $Vendor->name_english,
                'name_hindi' => $Vendor->name_hindi,
                'name_punjabi' => $Vendor->name_punjabi,
                'shop_name_english' => $Vendor->shop_name_english,
                'shop_name_hindi' => $Vendor->shop_name_hindi,
                'shop_name_punjabi' => $Vendor->shop_name_punjabi,
                'address_english' => $Vendor->address_english,
                'address_hindi' => $Vendor->address_hindi,
                'address_punjabi' => $Vendor->address_punjabi,
                'district_english' => $Vendor->district_english,
                'district_hindi' => $Vendor->district_hindi,
                'district_punjabi' => $Vendor->district_punjabi,
                'city' => $Vendor->city,
                'state' => $Vendor->state,
                'pincode' => $Vendor->pincode
            );
        }
        $res = array(
            'message' => "Success",
            'status' => 200,
            'data' => $data
        );
        echo json_encode($res);
    }
    //====================================================== buyFeed ================================================//
    public function buyFeed()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $data = [];
            $plan_data = $this->db->get_where('tbl_check_my_feed_buy', array('payment_status' => 1, 'farmer_id' => $farmer_data[0]->id))->result();
            if (empty($plan_data)) {
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $txn_id = mt_rand(999999, 999999999999);
                $data = array(
                    'farmer_id' => $farmer_data[0]->id,
                    'price' => FEED_AMOUNT,
                    'payment_status' => 0,
                    'txn_id' => $txn_id,
                    'date' => $cur_date,
                    'gateway' => 'CC Avenue',
                );
                $req_id = $this->base_model->insert_table("tbl_check_my_feed_buy", $data, 1);
                $success = base_url() . 'ApiControllers/HomeController/feed_payment_success';
                $fail = base_url() . 'ApiControllers/FarmerController/payment_failed';
                $post = array(
                    'txn_id' => '',
                    'merchant_id' => MERCHAND_ID,
                    'order_id' => $txn_id,
                    'amount' => FEED_AMOUNT,
                    'currency' => "INR",
                    'redirect_url' => $success,
                    'cancel_url' => $fail,
                    'billing_name' => $farmer_data[0]->name,
                    'billing_address' => $farmer_data[0]->village,
                    'billing_city' => $farmer_data[0]->city,
                    'billing_state' => $farmer_data[0]->state,
                    'billing_zip' => $farmer_data[0]->pincode,
                    'billing_country' => 'India',
                    'billing_tel' => $farmer_data[0]->phone,
                    'billing_email' => '',
                    'merchant_param1' => 'Feed Payment',
                );
                $merchant_data = '';
                $working_key = WORKING_KEY; //Shared by CCAVENUES
                $access_code = ACCESS_CODE; //Shared by CCAVENUES
                foreach ($post as $key => $value) {
                    $merchant_data .= $key . '=' . $value . '&';
                }
                $length = strlen(md5($working_key));
                $binString = "";
                $count = 0;
                while ($count < $length) {
                    $subString = substr(md5($working_key), $count, 2);
                    $packedString = pack("H*", $subString);
                    if ($count == 0) {
                        $binString = $packedString;
                    } else {
                        $binString .= $packedString;
                    }
                    $count += 2;
                }
                $key = $binString;
                $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
                $openMode = openssl_encrypt($merchant_data, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
                $encrypted_data = bin2hex($openMode);
                $send = array(
                    'order_id' => $req_id,
                    'access_code' => $access_code,
                    'redirect_url' => $success,
                    'cancel_url' => $fail,
                    'enc_val' => $encrypted_data,
                    'plain' => $merchant_data,
                    'merchant_param1' => 'Feed Payment',
                );
                $res = array(
                    'message' => "Success!",
                    'status' => 200,
                    'data' => $send,
                );
                echo json_encode($res);
            } else {
                $res = array(
                    'message' => 'Some error occurred!',
                    'status' => 201
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
    //====================================================== Phone_pe_buyFeed ================================================//
    public function Phone_pe_buyFeed()
    {
        $headers = apache_request_headers();
        $authentication = $headers['Authentication'];
        $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
        if (!empty($farmer_data)) {
            $data = [];
            $plan_data = $this->db->get_where('tbl_check_my_feed_buy', array('payment_status' => 1, 'farmer_id' => $farmer_data[0]->id))->result();
            if (empty($plan_data)) {
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $txn_id = bin2hex(random_bytes(12));
                $data = array(
                    'farmer_id' => $farmer_data[0]->id,
                    'price' => FEED_AMOUNT,
                    'payment_status' => 0,
                    'txn_id' => $txn_id,
                    'date' => $cur_date,
                    'gateway' => 'Phone Pe',
                );
                $req_id = $this->base_model->insert_table("tbl_check_my_feed_buy", $data, 1);
                $success = base_url() . 'ApiControllers/HomeController/phone_pe_feed_payment_success';
                $param1 = 'Feed Payment';
                $response = $this->initiate_phone_pe_payment($txn_id, FEED_AMOUNT, $farmer_data[0]->phone, $success, $param1);
                if ($response && $response->code == 'PAYMENT_INITIATED') {
                    $send = array(
                        'url' => $response->data->instrumentResponse->redirectInfo->url,
                        'redirect_url' => $success,
                        'merchant_param1' => $param1,
                        'order_id' => $req_id,
                    );
                    $res = array(
                        'message' => "Success!",
                        'status' => 200,
                        'data' => $send,
                    );
                    echo json_encode($res);
                } else {
                    $res = array(
                        'message' => 'Some error occurred!',
                        'status' => 201
                    );
                    echo json_encode($res);
                }
            } else {
                $res = array(
                    'message' => 'Some error occurred!',
                    'status' => 201
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
    // ====================== START PHONE PE INITIATE PAYMENT ==================================
    public function initiate_phone_pe_payment($txn_id, $amount, $phone, $redirect_url, $param1 = '')
    {
        $payload = array(
            "merchantId" => PHONE_PE_MERCHANT_ID,
            "merchantTransactionId" => $txn_id,
            "merchantUserId" => "MUID123",
            'amount' => $amount * 100,
            "redirectUrl" => $redirect_url,
            "callbackUrl" => $redirect_url,
            "mobileNumber" => $phone,
            "redirectMode" => "POST",
        );
        $url = PHONE_PE_URL . '/pg/v1/pay';
        $json = json_encode($payload);
        $payload = json_decode($json);
        $payload->paymentInstrument = new stdClass();
        $payload->paymentInstrument->type = "PAY_PAGE";

        // print_r($payload);die();
        $jsonPayload = json_encode($payload);
        $encode_jsonPayload = base64_encode($jsonPayload);
        $verifyHeader = hash('sha256', $encode_jsonPayload . '/pg/v1/pay' . PHONE_PE_SALT) . '###' . PHONE_PE_SALT_INDEX;
        $request_json = new stdClass();
        $request_json->request = $encode_jsonPayload;
        // Set up cURL
        $ch = curl_init();
        // Set the cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_json));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-VERIFY: ' . $verifyHeader,
        ]);

        // Execute the cURL request and store the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        // Close the cURL session
        curl_close($ch);

        // Print the response

        return json_decode($response);
    }
    // ====================== START PHONE PE INITIATE PAYMENT ==================================
    public function verify_phone_pe_payment($body)
    {

        if ($body['code'] == 'PAYMENT_SUCCESS') {
            $url = PHONE_PE_URL . '/pg/v1/status/' . PHONE_PE_MERCHANT_ID . '/' . $body['transactionId'] . '';
            $verifyHeader = hash('sha256', '/pg/v1/status/' . PHONE_PE_MERCHANT_ID . '/' . $body['transactionId'] . PHONE_PE_SALT) . '###' . PHONE_PE_SALT_INDEX;
            $ch = curl_init();
            // Set the cURL options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-VERIFY: ' . $verifyHeader,
                'X-MERCHANT-ID: ' . PHONE_PE_MERCHANT_ID,
            ]);

            // Execute the cURL request and store the response
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                echo 'cURL Error: ' . curl_error($ch);
            }

            // Close the cURL session
            curl_close($ch);

            // Print the response
            // echo $response;
            return json_decode($response);
            // $res = json_decode($response);
            // return $res->code;
            // if ($res->code == 'PAYMENT_SUCCESS') {
            //    return $res->code;
            // } else {
            //     // redirect('web/checkout');
            // }
        }
    }
}

  //====================================================== END FEEDCONTROLLER================================================//
