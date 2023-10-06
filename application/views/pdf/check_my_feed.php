<!DOCTYPE html>
<html lang="en">
<head>
    <title>Feed Protien Energy Ratio</title>
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
                    .info3 {
                        <?php
                        if ($objPHPExcel->setActiveSheetIndex(6)->getCell('G16')->getFormattedValue() < 173 || $objPHPExcel->setActiveSheetIndex(6)->getCell('G16')->getFormattedValue() > 193) {
                        ?>color: red;
                        <?php
                        } else {
                        ?>color: #009252;
                        <?php
                        }
                        ?>
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
                    .ht {
                        margin-left: 30px;
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
                            </td>
                            <td colspan="2" style="border-left:none">
                                <p><b>Date</b>
                                    <?
                                    date_default_timezone_set("Asia/Calcutta");
                                    $cur_date = date("Y-m-d");
                                    ?>
                                    <span class="ht"><? echo $cur_date; ?></span>
                                </p>
                                <p><b>Technician </b><span class="ht">VIPIN SHARMA </span></p>
                                <p><b>Farmer</b><span class="ht"><?= $farmername; ?></span>
                                <p>
                                <p><b>Cow</b><span class="ht">MILKING</span>
                                <p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-center">
                                <h3><span class="two">Feed</span><span class="three"> Protien </span> <span class="two">Energy </span><span class="four">Ratio</span></h3>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="2" style="background-color: #3498db;">
                                <label>Cow Characteristics </label>
                            </td>
                            <td colspan="3" style="background-color: #3498db;">
                                <label>Ration Nutritional Analysis</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Live Weight (kg)</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('C15')->getFormattedValue() ?></td>
                            <td></td>
                            <td>Needs</td>
                            <td>Intake</td>
                        </tr>
                        <tr>
                            <td>Pregnancy (mth)</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('C16')->getFormattedValue() ?></td>
                            <td>Metabolisable Energy (MJ/d)</td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('G16')->getFormattedValue() ?></td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H16')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Milk Volume (kg)</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('C17')->getFormattedValue() ?></td>
                            <td>Crude protein (kg/d)</td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('G17')->getFormattedValue() ?></td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H17')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Milk fat (%)</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('C18')->getFormattedValue() ?></td>
                            <td>Calcium (g/d)</td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('G18')->getFormattedValue() ?></td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H18')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Milk protein (%)</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('C19')->getFormattedValue() ?></td>
                            <td>Phosphorus (g/d)</td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('G19')->getFormattedValue() ?></td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H19')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Live weight gain/loss (kg/d)</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('C20')->getFormattedValue() ?></td>
                            <td>NDF</td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('G20')->getFormattedValue() ?></td>
                            <td class="info3"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H20')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Stage of lactation</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('C21')->getFormattedValue() ?></td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>Max</td>
                            <td>Intake</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td class="info2">Dry matter (kg/d)</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('G23')->getFormattedValue() ?></td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H23')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td class="info2">Concentrate</td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('G24')->getFormattedValue() ?></td>
                            <td class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H24')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <th colspan="5">Milk income less feed cost (MIFC)</th>
                        </tr>
                        <tr>
                            <td colspan="2">Milk Return (Rs./kg)</td>
                            <td class="info2" colspan="5">₹<?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H29')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Milk Return (Rs./d)</td>
                            <td class="info2" colspan="5">₹<?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H30')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Feed Cost (Rs./d) </td>
                            <td class="info2" colspan="5">₹<?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H31')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">MIFC ROI(Rs./d)</td>
                            <td class="info2" colspan="5">₹<?= $objPHPExcel->setActiveSheetIndex(6)->getCell('H32')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <th colspan="5">Composition of the ration</th>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Ration ingredients</b></td>
                            <td colspan="5"><b>Fresh feed intake (kg/d)</b></td>
                        </tr>
                        <? $a=28; for ($i = 28; $i <= 53; $i++) {
                            if ($objPHPExcel->setActiveSheetIndex(6)->getCell('D' . $i)->getFormattedValue() !== '0') {
                                $a++;
                        ?>
                    <tbody>
                        <tr>
                            <td colspan="2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('B' . $i)->getFormattedValue() ?></td>
                            <td class="info2"  colspan="5"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('D' . $i)->getFormattedValue() ?></td>
                        </tr>
                    </tbody>
            <? }
                        } ?>
            <tbody>
                <tr>
                    <td colspan="5"></td>
                </tr>
                <tr>
                    <td colspan="2" >Total intake per head:</td>
                    <td colspan="5" class="info2"><?= $objPHPExcel->setActiveSheetIndex(6)->getCell('D57')->getFormattedValue() ?></td>
                </tr>
                <!-- <tr>
                    <td colspan="5" class="text-center">If you have any question please contact for help
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-center"><b>Vipin Sharma</b><span class="m-2">7297963456</span></td>
                </tr> -->
                </table>
            </table>
        </div>
    </div>
</body>
</html>
</body>
</html>