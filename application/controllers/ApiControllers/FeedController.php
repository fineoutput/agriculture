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
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
                if (!empty($farmer_data)) {
                    if ($type == 'Inches') {
                        $weight = ($grith * $grith * $length) / 660 + 0.5;
                    } else {
                        $weight = ($grith * $grith * $length) / 10797 + 0.5;
                    }
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
            $this->form_validation->set_rules('weight', 'weight', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $lactation = $this->input->post('lactation');
                $feed_percentage = $this->input->post('feed_percentage');
                $milk_yield = $this->input->post('milk_yield');
                $weight = $this->input->post('weight');
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
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
        print_r($message);
        die();
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
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
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
                        if (!empty($prt[15])) {
                            $cp += $prt[3] ? $prt[3] * $prt[15] / 1000 : 0;
                            $ee += $prt[4] ? $prt[4] * $prt[15] / 1000 : 0;
                            $cf +=  $prt[5] ? $prt[5] * $prt[15] / 1000 : 0;
                            $tdn +=  $prt[6] ? $prt[6] * $prt[15] / 1000 : 0;
                            $me +=  $prt[7] ? $prt[7] * $prt[15] / 1000 : 0;
                            $ca +=  $prt[8] ? $prt[8] * $prt[15] / 1000 : 0;
                            $p +=  $prt[9] ? $prt[9] * $prt[15] / 1000 : 0;
                            $adf += $prt[10] ? $prt[10] * $prt[15] / 1000 : 0;
                            $ndf +=  $prt[11] ? $prt[11] * $prt[15] / 1000 : 0;
                            $nel +=  $prt[12] ? $prt[12] * $prt[15] / 1000 : 0;
                            $rudp +=  $prt[13] ? $prt[13] * $prt[15] / 1000 : 0;
                            $endf +=  $prt[14] ? $prt[14] * $prt[15] / 1000 : 0;
                            $value +=  $prt[15] ? $prt[2] * $prt[15]  : 0;
                        }
                    }
                    $Energy = json_decode($EnergyData);
                    foreach ($Energy as $enr) {
                        if (!empty($enr[15])) {
                            $cp += $enr[3] ? $enr[3] * $enr[15] / 1000 : 0;
                            $ee += $enr[4] ? $enr[4] * $enr[15] / 1000 : 0;
                            $cf += $enr[5] ? $enr[5] * $enr[15] / 1000 : 0;
                            $tdn += $enr[6] ? $enr[6] * $enr[15] / 1000 : 0;
                            $me += $enr[7] ? $enr[7] * $enr[15] / 1000 : 0;
                            $ca += $enr[8] ? $enr[8] * $enr[15] / 1000 : 0;
                            $p += $enr[9] ? $enr[9] * $enr[15] / 1000 : 0;
                            $adf += $enr[10] ? $enr[10] * $enr[15] / 1000 : 0;
                            $ndf += $enr[11] ? $enr[11] * $enr[15] / 1000 : 0;
                            $nel += $enr[12] ? $enr[12] * $enr[15] / 1000 : 0;
                            $rudp += $enr[13] ? $enr[13] * $enr[15] / 1000 : 0;
                            $endf += $enr[14] ? $enr[14] * $enr[15] / 1000 : 0;
                            $value +=  $enr[15] ? $enr[2] * $enr[15]  : 0;
                        }
                    }
                    $Product = json_decode($ProductData);
                    foreach ($Product as $pro) {
                        if (!empty($pro[15])) {
                            $cp += $pro[3] ? $pro[3] * $pro[15] / 1000 : 0;
                            $ee += $pro[4] ? $pro[4] * $pro[15] / 1000 : 0;
                            $cf += $pro[5] ? $pro[5] * $pro[15] / 1000 : 0;
                            $tdn += $pro[6] ? $pro[6] * $pro[15] / 1000 : 0;
                            $me += $pro[7] ? $pro[7] * $pro[15] / 1000 : 0;
                            $ca += $pro[8] ? $pro[8] * $pro[15] / 1000 : 0;
                            $p += $pro[9] ? $pro[9] * $pro[15] / 1000 : 0;
                            $adf += $pro[10] ? $pro[10] * $pro[15] / 1000 : 0;
                            $ndf += $pro[11] ? $pro[11] * $pro[15] / 1000 : 0;
                            $nel += $pro[12] ? $pro[12] * $pro[15] / 1000 : 0;
                            $rudp += $pro[13] ? $pro[13] * $pro[15] / 1000 : 0;
                            $endf += $pro[14] ? $pro[14] * $pro[15] / 1000 : 0;
                            $value +=  $pro[15] ? $pro[2] * $pro[15] : 0;
                        }
                    }
                    $Medicine = json_decode($MedicineData);
                    foreach ($Medicine as $med) {
                        if (!empty($med[15])) {
                            $cp += $med[3] ? $med[3] * $med[15] / 1000 : 0;
                            $ee += $med[4] ? $med[4] * $med[15] / 1000 : 0;
                            $cf += $med[5] ? $med[5] * $med[15] / 1000 : 0;
                            $tdn += $med[6] ? $med[6] * $med[15] / 1000 : 0;
                            $me += $med[7] ? $med[7] * $med[15] / 1000 : 0;
                            $ca += $med[8] ? $med[8] * $med[15] / 1000 : 0;
                            $p += $med[9] ? $med[9] * $med[15] / 1000 : 0;
                            $adf += $med[10] ? $med[10] * $med[15] / 1000 : 0;
                            $ndf += $med[11] ? $med[11] * $med[15] / 1000 : 0;
                            $nel += $med[12] ? $med[12] * $med[15] / 1000 : 0;
                            $rudp += $med[13] ? $med[13] * $med[15] / 1000 : 0;
                            $endf += $med[14] ? $med[14] * $med[15] / 1000 : 0;
                            $value +=  $med[15] ? $med[2] * $med[15]  : 0;
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
                        'NEL' => round($nel, 2),
                        'ENDF' => round($endf, 2),
                    );
                    $dmb =  array(
                        'CP' => $cp > 0 ? round(($cp * 12 / 100 + $cp), 2) : 0,
                        'FAT' => $ee > 0 ? round(($ee * 12 / 100 + $ee), 2) : 0,
                        'FIBER' => $cf > 0 ? round(($cf * 12 / 100 + $cf), 2) : 0,
                        'TDN' => $tdn > 0 ? round(($tdn * 12 / 100 + $tdn), 2) : 0,
                        'ENERGY' => $me > 0 ? round(($me * 12 / 100 + $me), 2) : 0,
                        'CA' => $ca > 0 ? round(($ca * 12 / 100 + $ca), 2) : 0,
                        'P' => $p > 0 ? round(($p * 12 / 100 + $p), 2) : 0,
                        'RUDP' => $rudp > 0 ? round(($rudp * 12 / 100 + $rudp), 2) : 0,
                        'ADF' => $adf > 0 ? round(($adf * 12 / 100 + $adf), 2) : 0,
                        'NDF' => $ndf > 0 ? round(($ndf * 12 / 100 + $ndf), 2) : 0,
                        'NEL' => round((0.0245 * $tdn - 0.12), 2),
                        'ENDF' => $endf > 0 ? round(($endf * 12 / 100 + $endf), 2) : 0,
                    );
                    $data1 = array(
                        'fresh' => $fresh,
                        'dmb' => $dmb,
                        'row_ton' => round(($value), 2),
                        'row_qtl' => round(($value / 10), 2),
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
                $farmer_data = $this->db->get_where('tbl_farmers', array('is_active' => 1, 'auth' => $authentication))->result();
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
                    $dmi_1 = round((0.4385 * $fat_4 + 0.07506 * pow($weight, 0.75)) * (1 - exp(-0.03202 * (24.9576 + $days_milk))) * ($group == "Bos taurus" ? 1 : 1), 1);
                    $dmi_2 = round(($dmi_1 / $weight) * 100, 2);
                    $dwi_1 = round(1.82 * $milk_production + 0.69 * $dmi_1 + 0.53 * $temp, 2);
                    $dwi_2 = round($dwi_1 / $weight * 100, 2);
                    $result = array(
                        'dmi_1' => $dmi_1,
                        'dmi_2' => $dmi_2,
                        'dwi_1' => $dwi_1,
                        'dwi_2' => $dwi_2,
                    );
                    $data['result'] = $result;
                    $message = $this->load->view('pdf/animal_requirements', $data, TRUE);
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
    //====================================================== Animal Requirements ================================================//
    public function test()
    {
        $input = array(
            'group' => 'Bos taurus',
            'feeding_system' => 'Pasture',
            'weight' => 500,
            'milk_production' => 30,
            'days_milk' => 10,
            'milk_fat' => 3.8,
            'milk_protein' => 3,
            'milk_lactose' => 4.6,
            'weight_variation' => 0,
            'bcs' => 2.5,
            'gestation_days' => 5,
            'temp' => 22,
            'humidity' => 65,
            'thi' => 69.1,
            'fat_4' => 29.1,
        );
        $data['input'] = $input;
        $dmi_1 = round((0.4385 * $input['fat_4'] + 0.07506 * pow($input['weight'], 0.75)) * (1 - exp(-0.03202 * (24.9576 + $input['days_milk']))) * ($input['group'] == "Bos taurus" ? 1 : 1), 1);
        $dmi_2 = round(($dmi_1 / $input['weight']) * 100, 2);
        $dwi_1 = round(1.82 * $input['milk_production'] + 0.69 * $dmi_1 + 0.53 * $input['temp'], 2);
        $dwi_2 = round($dwi_1 / $input['weight'] * 100, 2);
        $result = array(
            'dmi_1' => $dmi_1,
            'dmi_2' => $dmi_2,
            'dwi_1' => $dwi_1,
            'dwi_2' => $dwi_2,
        );
        $data['result'] = $result;
        //  echo $result;die();
        // $data = array(
        //     'dry_matter_intake' => round($dry_matter_intake, 2),
        //     'feed' => round($feed, 2),
        //     'fodder' => round($fodder, 2),
        //     'feed_qty' => round($feed_qty, 2),
        //     'green_fodder' => round($green_fodder, 2),
        //     'maize' => round($maize, 2),
        //     'barseem' => round($barseem, 2),
        //     'dry_fodder' => round($dry_fodder, 2),
        //     'hary' => round($hary, 2),
        //     'silage_dm' => round($silage_dm, 2),
        //     'silage' => round($silage, 2),
        // );
        $message = $this->load->view('pdf/animal_requirements', $data, TRUE);
        print_r($message);
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
}
  //====================================================== END FEEDCONTROLLER================================================//
