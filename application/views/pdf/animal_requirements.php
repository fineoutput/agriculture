<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dairy Muneem Animal Requirements</title>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-2">
        <div class="row">
            <table class="table table-bordered">
                <style>
                    table {
                        width: 750px;
                        border-collapse: collapse;
                        margin: 50px auto;
                    }
                    th {
                        background: #3498db;
                        color: white;
                        font-weight: bold;
                    }
                    td,
                    th {
                        padding: 10px;
                        border: 1px solid #ccc;
                        text-align: left;
                        font-size: 18px;
                    }
                    .labels tr td {
                        background-color: #20b9aa;
                        font-weight: bold;
                        color: #fff;
                    }
                    .two {
                        color: #20b9aa;
                    }
                    .label tr td label {
                        display: block;
                    }
                    [data-toggle="toggle"] {
                        display: none;
                    }
                    .three {
                        color: #3c5772;
                    }
                    .four {
                        color: #507186;
                    }
                    .info {
                        background-color: #0dcaf0;
                    }
                    .info2 {
                        color: #3498db;
                    }
                    .success {
                        color: #198754;
                    }
                    .primary {
                        color: #0d6efd;
                    }
                    .warning {
                        color: #ffc107;
                    }
                </style>
                <table>
                    <thead>
                    </thead>
                    <!-- =========================================================================== -->
                    <tbody>
                        <tr>
                            <td colspan="3" style="border-right:none">
                                <img src="<? echo base_url() ?>/assets/logo2.png">
                                <h5>Agristar Animal Solution Private Limited</h5>
                                <h6>Dream City, Suratgarh, Ganganagar, Rajasthan, 335804</h6>
                            </td>
                            <td colspan="2" style="border-left:none">
                                <h6>Contact:</h6>
                                <p style="font-size:15px"> Call & Whatsapp- 7891029090</p>
                                <h6>Email:</h6>
                                <p style="font-size:15px">info@dairymuneem.in, dairymuneem@gmail.com</p>
                                <h6>Website:</h6>
                                <p style="font-size:15px">www.dairymuneem.com/</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-center">
                                <h3><span class="two">The </span><span class="three">Nutrition System For</span> <span class="two">Dairy</span><span class="four"> Cattle</span></h3>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="5">
                                <label>1.) Inputs</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Genetic Group:</td>
                            <td class="two"><?= $input['group']=='Bos taurus'?'Cow':'Buffalo' ?></td>
                            <td>Body Weight Variation</td>
                            <td class="two"><?= $input['weight_variation'] ?> Kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>Feeding system</td>
                            <td class="two"><?= $input['feeding_system'] ?></td>
                            <td>BCS</td>
                            <td class="two"><?= $input['bcs'] ?> (1 to 5)</td>
                        </tr>
                        <tr>
                            <td>Body Weight (BW)</td>
                            <td class="two"><?= $input['weight'] ?> Kg/cow/day</td>
                            <td>Days Of Gestation</td>
                            <td class="two"><?= $input['gestation_days'] ?> days</td>
                        </tr>
                        <tr>
                            <td>Milk Production</td>
                            <td class="two"><?= $input['milk_production'] ?> Kg/cow/day</td>
                            <td>Air Temperature</td>
                            <td class="two"><?= $input['temp'] ?> C</td>
                        </tr>
                        <tr>
                            <td>Days In Milk</td>
                            <td class="two"><?= $input['days_milk'] ?> days</td>
                            <td>Air Humidity</td>
                            <td class="two"><?= $input['humidity'] ?> %</td>
                        </tr>
                        <tr>
                            <td>Milk Fat</td>
                            <td class="two"><?= $input['milk_fat'] ?> %</td>
                            <td>Temperature-Humidity Index (THI)</td>
                            <td class="two"><?= $input['thi'] ?></td>
                        </tr>
                        <tr>
                            <td>Milk Protein</td>
                            <td class="two"><?= $input['milk_protein'] ?> %</td>
                            <td>Fat 4% Corrected Milk</td>
                            <td class="two"><?= $input['fat_4'] ?> Kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>Milk Lactose</td>
                            <td class="two"><?= $input['milk_lactose'] ?> %</td>
                            <td></td>
                            <td class="two"></td>
                        </tr>
                    </tbody>
                    <!-- =========================================================================== -->
                    <tbody class="info">
                        <tr>
                            <td colspan="5">
                                <label>2.) Predicted Intake</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td colspan="2">1.Dry Intake(DMI):</td>
                            <td class="text-info" colspan="1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F32')->getFormattedValue() ?> kg/cow/day</td>
                            <td class="text-info" colspan="1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F33')->getFormattedValue() ?> % BW/day</td>
                        </tr>
                        <tr>
                            <td colspan="2">2.Drinking Water Intake:</td>
                            <td class="text-info" colspan="1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I32')->getFormattedValue() ?> L/cow/day</td>
                            <td class="text-info" colspan="1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I33')->getFormattedValue() ?> % BW/day</td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="5">
                                <label>3.) Predicted Energy And Nutrient Requirements </label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color: #3498db;">
                                <label>3.1) Energy Requirements: </label>
                            </td>
                            <td colspan="2" style="background-color: #3498db;">
                                <label>3.2)Protein And Amino Acids Requirements:</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Total Net Energy (NE) Intake:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F38')->getFormattedValue() ?> Mcal/cow/day</td>
                            <td>Crude Protein (CP) Intake:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I38')->getFormattedValue() ?> kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>NE Diet: </td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F39')->getFormattedValue() ?> Mcal/kg DM Diet</td>
                            <td>CP Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I39')->getFormattedValue() ?>% DM</td>
                        </tr>
                        <tr>
                            <td>Total Metabolizable Energy (ME) Intake:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F40')->getFormattedValue() ?> Mcal/cow/day</td>
                            <td>Rumen Degradable Protein (RDP) Intake:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I40')->getFormattedValue() ?> kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>ME Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F41')->getFormattedValue() ?> Mcal/kg DM Diet</td>
                            <td>RDP Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I41')->getFormattedValue() ?> % DM</td>
                        </tr>
                        <tr>
                            <td>Total Digestible Energy (DE) Intake:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F42')->getFormattedValue() ?> Mcal/cow/day</td>
                            <td>Rumen Undegradable Protein (RUP) Intake:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I42')->getFormattedValue() ?> kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>DE Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F43')->getFormattedValue() ?> Mcal/kg DM diet</td>
                            <td>RUP Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I43')->getFormattedValue() ?> % DM</td>
                        </tr>
                        <tr>
                            <td>Total Digestible Energy (DE) Intake:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F44')->getFormattedValue() ?> kg/cow/day</td>
                            <td>Metabolizable Protein (MP) Intake:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I44')->getFormattedValue() ?> kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>TDN Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F45')->getFormattedValue() ?> % DM</td>
                            <td>MP Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I45')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="info2"></td>
                            <td>MP From Microbial Rumen Protein</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I46')->getFormattedValue() ?>% MP</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="info2"></td>
                            <td>Digestible Lysine Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I47')->getFormattedValue() ?>% MP</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="info2"></td>
                            <td>Digestible Methionine Diet:</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I48')->getFormattedValue() ?>% MP</td>
                        </tr>
                    <tbody class="labels">
                        <tr>
                            <td colspan="2" style="background-color: #198754;">
                                <label>3. Macro Minerals Requirements:</label>
                            </td>
                            <td colspan="2" style="background-color: #198754;">
                                <label>4. Trace Minerals Requirements:</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Ca Intake:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F51')->getFormattedValue() ?> g/cow/day</td>
                            <td>Zn Intake:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I51')->getFormattedValue() ?> mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>Ca Diet:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F52')->getFormattedValue() ?> % DM</td>
                            <td>Zn Diet:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I52')->getFormattedValue() ?> mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>P Intake:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F53')->getFormattedValue() ?> g/cow/day</td>
                            <td>Cu Intake:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I53')->getFormattedValue() ?> mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>P Diet:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F54')->getFormattedValue() ?> % DM</td>
                            <td>Cu Diet</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I54')->getFormattedValue() ?> mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>Na Intake:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F55')->getFormattedValue() ?> g/cow/day</td>
                            <td>Fe Intake</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I55')->getFormattedValue() ?> mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>Na Diet:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F56')->getFormattedValue() ?> % DM</td>
                            <td>Fe Diet</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I56')->getFormattedValue() ?> mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>K Intake:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F57')->getFormattedValue() ?> g/cow/day</td>
                            <td>Mn Intake</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I57')->getFormattedValue() ?> mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>K Diet:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F58')->getFormattedValue() ?> % DM</td>
                            <td>Mn Diet</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I58')->getFormattedValue() ?> mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>S Intake:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F59')->getFormattedValue() ?> g/cow/day</td>
                            <td>Co Intake</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I59')->getFormattedValue() ?> mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>S Diet:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F60')->getFormattedValue() ?> % DM</td>
                            <td>Co Diet</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I60')->getFormattedValue() ?> mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>Mg Intake:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F61')->getFormattedValue() ?> g/cow/day</td>
                            <td>I Intake</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I61')->getFormattedValue() ?> g/cow/day</td>
                        </tr>
                        <tr>
                            <td>Mg Diet:</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F62')->getFormattedValue() ?> % DM</td>
                            <td>I Diet</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I62')->getFormattedValue() ?> mg/kg DM</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="success"></td>
                            <td>Se Intake</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I63')->getFormattedValue() ?> mg/cow/day</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="success"></td>
                            <td>Se Diet</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I64')->getFormattedValue() ?> mg/kg DM</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="success"></td>
                            <td>Cr Intake</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I65')->getFormattedValue() ?> mg/cow/day</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="success"></td>
                            <td>Cr Diet</td>
                            <td class="success"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('I66')->getFormattedValue() ?> mg/kg DM</td>
                        </tr>
                    <tbody class="labels">
                        <tr>
                            <td colspan="2" style="background-color: #0d6efd;">
                                <label>5. Vitamins Recommendations:</label>
                            </td>
                            <td colspan="2" style="background-color: #0d6efd;">
                                <label for="management">6. Others Recommendations:</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Vitamin A Diet</td>
                            <td class="primary"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F69')->getFormattedValue() ?> IU/kg DM</td>
                            <td>peNDF Diet:</td>
                            <td class="primary">≥21% DM</td>
                        </tr>
                        <tr>
                            <td>Vitamin D Diet</td>
                            <td class="primary"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F70')->getFormattedValue() ?> IU/kg DM</td>
                            <td>Fat Acid Diet:</td>
                            <td class="primary">≥6% DM</td>
                        </tr>
                        <tr>
                            <td>Vitamin E Diet</td>
                            <td class="primary"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F71')->getFormattedValue() ?> IU/kg DM</td>
                            <td></td>
                            <td class="primary"></td>
                        </tr>
                    <tbody class="labels">
                        <td colspan="6" style="background-color: #ffc107;">
                            <label>7.Methane Enteric Emission:</label>
                        </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Methane</td>
                            <td class="warning"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F73')->getFormattedValue() ?> g/cow/day</td>
                            <td></td>
                            <td class="warning"></td>
                        </tr>
                    </tbody>
                </table>
            </table>
        </div>
    </div>
</body>
</html>
</body>
</html>