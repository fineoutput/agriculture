<!DOCTYPE html>
<html lang="en">
<head>
    <title>25 Cows Excel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
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
        .C_label {
            background-color: #2cc16a;
            font-weight: bold;
            color: #fff;
        }
        .label tr td label {
            display: block;
        }
        [data-toggle="toggle"] {
            display: none;
        }
        .tr1 {
            color: #20b9aa;
        }
        .secondary {
            background-color: #6c757d;
            color: white;
        }
        .secondary1 {
            color: #6c757d;
        }
        .primary {
            background-color: #0d6efd;
            color: white;
        }
        .primary1 {
            color: #0d6efd;
        }
        .success {
            background-color: #198754;
            color: white;
        }
        .success1 {
            color: #198754;
        }
        .warning {
            background-color: #ffc107;
            color: white;
        }
        .warning1 {
            color: #ffc107;
        }
        .info {
            background-color: #0dcaf0;
            color: white;
        }
        .info1 {
            color: #0dcaf0;
        }
        .dark {
            background-color: #212529;
            color: white;
        }
        .dark1 {
            color: #212529;
        }
    </style>
    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <table>
                    <thead>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" style="border-right:none">
                                <img src="<? echo base_url() ?>/assets/logo2.png">
                                <h5>Agristar Animal Solution Private Limited</h5>
                                <h6>Dream City, Suratgarh, Ganganagar, Rajasthan, 335804</h6>
                            </td>
                            <td colspan="1" style="border-left:none">
                                <h6>Contact:</h6>
                                <p style="font-size:15px"> Call & Whatsapp- 7891029090</p>
                                <h6>Email:</h6>
                                <p style="font-size:15px">info@dairymuneem.in, dairymuneem@gmail.com</p>
                                <h6>Website:</h6>
                                <p style="font-size:15px">www.dairymuneem.com/</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-center">
                                <h3><span class="two">A</span><span class="three">NIMAL </span> <span class="two">R</span><span class="four">EQUIREMENTS</span></h3>
                                <h5>Input (Cows) : <?= $number_of_cows ?></h5>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label>RESULTS AT GLANCE:</label>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Year-1</th>
                            <th>Year-2</th>
                            <th>Year-3</th>
                            <th>Year-4</th>
                            <th>Year-5</th>
                            <th>Av.</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>1)ESTIMATED CAPITAL REQUIRED (Rs)</td>
                            <td class="tr1"><?= number_format($objPHPExcel->setActiveSheetIndex(0)->getCell('C12')->getOldCalculatedValue()) ?></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                        </tr>
                        <tr>
                            <td>a) Owners Capital (Rs)</td>
                            <td class="tr1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C13')->getFormattedValue() ?></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                        </tr>
                        <tr>
                            <td>b) Loan Amount (Rs)</td>
                            <td class="tr1"><?= number_format($objPHPExcel->setActiveSheetIndex(0)->getCell('C14')->getOldCalculatedValue()) ?></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                            <td class="tr1"></td>
                        </tr>
                        <tr>
                            <td>2a) RETURN ON CAPITAL INVEST. (%) (Excluding gain in animals)</td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('C15')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('D15')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('E15')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('F15')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('G15')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('H15')->getFormattedValue(), 2) ?></td>
                        </tr>
                        <tr>
                            <td>2b) RETURN ON CAPITAL INVEST. (%) (considering animal gain)</td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('C16')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('D16')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('E16')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('F16')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('G16')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('H16')->getFormattedValue(), 2) ?></td>
                        </tr>
                        <tr>
                            <td>3) BC RATIO</td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('C17')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('D17')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('E17')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('F17')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('G17')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('H17')->getFormattedValue(), 2) ?></td>
                        </tr>
                        <tr>
                            <td>9) COST OF MILK PRODUCTION (Rs)with gained animal Nos</td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('C18')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('D18')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('E18')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('F18')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('G18')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('H18')->getFormattedValue(), 2) ?></td>
                        </tr>
                        <tr>
                            <td>10) COST OF MILK PRODUCTION (Rs) </td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('C19')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('D19')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('E19')->getOldCalculatedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('F19')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('G19')->getFormattedValue(), 2) ?></td>
                            <td class="tr1"><?= round($objPHPExcel->setActiveSheetIndex(0)->getCell('H19')->getFormattedValue(), 2) ?></td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="secondary">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">A) Production Parameters Considered And Livestock
                                    Strength</label>
                                <input type="checkbox" name="accounting" id="accounting" data-toggle="toggle">
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Year-1</th>
                            <th>Year-2</th>
                            <th>Year-3</th>
                            <th>Year-4</th>
                            <th>Year-5</th>
                            <th>Av.</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Average Daily Milk Yield Of Cow Purchased</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C22')->getValue() ?></td>
                            <td class="secondary1"></td>
                            <td class="secondary1"></td>
                            <td class="secondary1"></td>
                            <td class="secondary1"></td>
                            <td class="secondary1"></td>
                        </tr>
                        <tr>
                            <td>Increase In Milk Production Over Previous Year in %</td>
                            <td class="secondary1"></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D23')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E23')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F23')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G23')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H23')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Conception Rate%</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C24')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D24')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E24')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F24')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G24')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H24')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Inter Calving Period Months</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C25')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D25')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E25')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F25')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G25')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H25')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <td>Mortality Adult</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C27')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D27')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E27')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F27')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G27')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H27')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Mortality Heifer%</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C28')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D28')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E28')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F28')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G28')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H28')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Mortality Growing Calf%(Above 1 Year)</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C29')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D29')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E29')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F29')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G29')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H29')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Mortality Young Calf%</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C30')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D30')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E30')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F30')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G30')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H30')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <td>Culling Rate Adult Cow</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C32')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D32')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E32')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F32')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G32')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H32')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Culling Rate Heifer</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C33')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D33')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E33')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F33')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G33')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H33')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Culling Rate Growing Calf (Above 1 Year)</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C34')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D34')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E34')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F34')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G34')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H34')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Culling Rate Calf</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C35')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D35')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E35')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F35')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G35')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H35')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <td>One Young Calf Equal To Adult</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C37')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D37')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E37')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F37')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G37')->getFormattedValue() ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Growing Calf(Above 12 Month)</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C38')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D38')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E38')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F38')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G38')->getFormattedValue() ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Heifer/Cow</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C39')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D39')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E39')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F39')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G39')->getFormattedValue() ?></td>
                            <td></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th class="primary" colspan="7">Initial live stock</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Unitsat The Start</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C41')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D41')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E41')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F41')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G41')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H41')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Heifer At The Start Of Year</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C42')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D42')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E42')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F42')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G42')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H42')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calf(Above 1 Year)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C43')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D43')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E43')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F43')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G43')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H43')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Female Young Calf Brought/Born Of Year</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C44')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D44')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E44')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F44')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G44')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H44')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Initial Total Animal Units At Start (Including Calf Born)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C45')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D45')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E45')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F45')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G45')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H45')->getFormattedValue() ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th class="success" colspan="7">Mortality Detail</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Mortality(No)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C48')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D48')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E48')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F48')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G48')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H48')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Heifer Mortality(No)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C49')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D49')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E49')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F49')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G49')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H49')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calf Mortality(No)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C50')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D50')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E50')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F50')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G50')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H50')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Young Calf Mortality(No)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C51')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D51')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E51')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F51')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G51')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H51')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Mortality(Adult Unit)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C52')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D52')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E52')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F52')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G52')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H52')->getFormattedValue() ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th class="warning" colspan="7">Stock After Mortality</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Less Mortality</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C55')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D55')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E55')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F55')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G55')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H55')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Lactating Heifers Less Mortality </td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C56')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D56')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E56')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F56')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G56')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H56')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calves(Above 1 Year) Mortality</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C57')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D57')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E57')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F57')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G57')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H57')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Calves Less Mortality </td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C58')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D58')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E58')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F58')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G58')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H58')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Stock Less Mortality</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C59')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D59')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E59')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F59')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G59')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H59')->getFormattedValue() ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th class="info" colspan="7">Stock Culled & Sold</th>
                        </tr>
                        <tr>
                            <td>Lactating Cow</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C62')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D62')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E62')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F62')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G62')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H62')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Heifer</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C63')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D63')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E63')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F63')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G63')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H63')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Growing Calves(Above 1 Year)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C64')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D64')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E64')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F64')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G64')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H64')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Calf</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C65')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D65')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E65')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F65')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G65')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H65')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Unit Culled</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C66')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D66')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E66')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F66')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G66')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H66')->getFormattedValue() ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th class="dark" colspan="7">Final Stock At The End Of Year</th>
                        </tr>
                        <tr>
                            <td>Lactating Cow</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C69')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D69')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E69')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F69')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G69')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H69')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Heifer </td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C70')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D70')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E70')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F70')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G70')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H70')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Growing Calf (Above 1 Year)</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C71')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D71')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E71')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F71')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G71')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H71')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Calf</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C72')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D72')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E72')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F72')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G72')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H72')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Animal Units At The End Of Year</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C73')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D73')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E73')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F73')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G73')->getFormattedValue() ?></td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H73')->getFormattedValue() ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th class="primary" colspan="7">Gain In Animal Unit</th>
                        </tr>
                        <tr>
                            <td>Animal Unit At The End Of Year</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C76')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D76')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E76')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F76')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G76')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H76')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Gain In Animal Unit </td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C77')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D77')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E77')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F77')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G77')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H77')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Value Of Gain Animal Unit</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C78')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D78')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E78')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F78')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G78')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H78')->getFormattedValue() ?></td>
                        </tr>
                    </tbody>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="secondary">
                        <tr>
                            <td>
                                <label>B) MILK PRODUCTION PROJECTIONS</label>
                            </td>
                            <td>Year-1</td>
                            <td>Year-2</td>
                            <td>Year-3</td>
                            <td>Year-4</td>
                            <td>Year-5</td>
                            <td>Av.</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Total Number Of Expected Lactations/Year*</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C81')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D81')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E81')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F81')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G81')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H81')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Expected Milk Yield/Lactation</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C82')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D82')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E82')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F82')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G82')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H82')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Milk Production (lit)</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C83')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D83')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E83')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F83')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G83')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H83')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Minus Milk For Feeding Calves (lit)(300Lt/Calf)</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C84')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D84')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E84')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F84')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G84')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H84')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Milk Available For Sale (lit)</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C85')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D85')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E85')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F85')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G85')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H85')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Daily Availability of Milk For Sale</td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C86')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D86')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E86')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F86')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G86')->getFormattedValue() ?></td>
                            <td class="secondary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H86')->getFormattedValue() ?></td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody>
                        <tr>
                            <td class="success" colspan="7" class="C_label">
                                <label>C) Technical Parameters And Cost Of Purchased Material & Sale Prices Considered:</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">Market Price Of Cow Considered On Per Liter Average Daily Yield (Rs)</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D89')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Estimated Cost/Cow (Rs)</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D90')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Estimated Housing + Equipments Cost (Rs),Detail Below At "L"</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D91')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Estimated Capital Investment /Cow Unit (Rs)</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D92')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Estimated Total Capital (Rs) Detail Given Below At L</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D93')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Rate Of Interest</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B94')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Margin Money (%)</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B95')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Owners Capital</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E96')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="4">Loan (Rs)</td>
                            <td class="success1" colspan="3"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E97')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <th class="warning"></th>
                            <th class="warning">Year-1</th>
                            <th class="warning">Year-2</th>
                            <th class="warning">Year-3</th>
                            <th class="warning">Year-4</th>
                            <th class="warning">Year-5</th>
                            <th class="warning">Av.</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Annual Increase In Feed Cost, Milk Selling Prices & Wages %</td>
                            <td class="warning1"></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D99')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E99')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F99')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G99')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H99')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Milk Selling Price (Rs)/Lit. (av) :</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C100')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D100')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E100')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F100')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G100')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H100')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Green Fodder (Rs)/KG:</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C101')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D101')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E101')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F101')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G101')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H101')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Straw (Rs)/KG:</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C102')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D102')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E102')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F102')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G102')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H102')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Concentrate (Rs)/KG:</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C103')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D103')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E103')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F103')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G103')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H103')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Contractual Labor Wages /Cow Unit/Year</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C104')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D104')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E104')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F104')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G104')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H104')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Number Of Manager/Supervisor Hired @1 per/100A.Unit</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C105')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D105')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E105')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F105')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G105')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H105')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Supervisors Salary / Annum (10% Annual Increase) </td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C106')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D106')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E106')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F106')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G106')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H106')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Supervisors Salary / Annum </td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C107')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D107')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E107')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F107')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G107')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('H107')->getFormattedValue() ?></td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="info">
                        <tr>
                            <td>
                                <label>D) Executed Sale Proceeds</label>
                            </td>
                            <td>Unit Cost (Rs.)</td>
                            <td>Year-1</td>
                            <td>Year-2</td>
                            <td>Year-3</td>
                            <td>Year-4</td>
                            <td>Year-5</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>I) Milk Sale(Rs)</td>
                            <td class="info1"></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C111')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D111')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E111')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F111')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G111')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>ii) Misc. Sales</td>
                            <td class="info1"></td>
                            <td class="info1"></td>
                            <td class="info1"></td>
                            <td class="info1"></td>
                            <td class="info1"></td>
                            <td class="info1"></td>
                        </tr>
                        <tr>
                            <td>Animal Unit Sold (Culled) </td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B113')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C113')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D113')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E113')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F113')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G113')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Male Calf (Disposed Of Within 1-2 Months)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B114')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C114')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D114')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E114')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F114')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G114')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Insurance Claim Of Mortality </td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B115')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C115')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D115')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E115')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F115')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G115')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Cow Dung/Animal Unit</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B116')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C116')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D116')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E116')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F116')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G116')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>iii) Total Sales</td>
                            <td class="info1"></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C117')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D117')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E117')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F117')->getFormattedValue() ?></td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G117')->getFormattedValue() ?></td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody>
                        <tr>
                            <td class="dark" colspan="7">
                                <label>E) Expected Operational Expenditure</label>
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Ist year Unit Cost (Rs.)</th>
                            <th>Year-1</th>
                            <th>Year-2</th>
                            <th>Year-3</th>
                            <th>Year-4</th>
                            <th>Year-5</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>G. Fodder Cost @ 40kg/Animal Unit</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B121')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C121')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D121')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E121')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F121')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G121')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Straw @ 3Kg/Animal Unit</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B122')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C122')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D122')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E122')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F122')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G122')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Concentrate For Milk Production @ 2.5Kg/Lit</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B123')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C123')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D123')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E123')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F123')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G123')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Concentrate Maintenance @1.5Kg/Ani. Unit</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B124')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C124')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D124')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E124')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F124')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G124')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Medicines & AI etc.</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B125')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C125')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D125')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E125')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F125')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G125')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Rent/Leasing Cost For Land For Shed etc /A.Unit.</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B126')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C126')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D126')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E126')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F126')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G126')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Contractual Labor Wages /Cow Unit/Year</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B127')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C127')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D127')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E127')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F127')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G127')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Salary Of Supervisor/Annum </td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C128')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D128')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E128')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F128')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G128')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Insurance Premium Cows Only</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B129')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C129')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D129')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E129')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F129')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G129')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Electricity Charges@ 1200 /Animal Unit/Year</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B130')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C130')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D130')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E130')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F130')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G130')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Other misc. charges@1200/animal unit</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B131')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C131')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D131')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E131')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F131')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G131')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td><b>(a) Total Operating Cost</b> </td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C132')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D132')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E132')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F132')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G132')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Operating Surplus (Total Sale - Operational Cost)</td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C133')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D133')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E133')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F133')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G133')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>(b) Dep. On Shed Machinery & Equipments</td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B134')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C134')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D134')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E134')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F134')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G134')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Total Exp. (a+b)</td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C135')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D135')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E135')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F135')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G135')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <td>F) Net Profit</td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C136')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D136')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E136')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F136')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G136')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>G) A)Return On Capital Invest.(%)</td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C137')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D137')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E137')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F137')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G137')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>G) B)Return On Capital Invest.( %)INCL ANI></td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C138')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D138')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E138')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F138')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G138')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>H) BC Ratio</td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C139')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D139')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E139')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F139')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G139')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Ia) Cost Of Milk Production (Rs) With Animal Gain</td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C140')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D140')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E140')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F140')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G140')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>Ib) Cost Of Milk Production (Rs)</td>
                            <td></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C141')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D141')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E141')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F141')->getFormattedValue() ?></td>
                            <td><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('G141')->getFormattedValue() ?></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label>J) Loan Disbursement And Payment Schedule</label>
                            </td>
                        </tr>
                        <tr>
                            <th>Year</th>
                            <th>Loan</th>
                            <th>Interest</th>
                            <th colspan="2">Installment</th>
                            <th colspan="2">Total</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>1</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B144')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C144')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D144')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E144')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B145')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C145')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D145')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E145')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B146')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C146')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D146')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E146')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B147')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C147')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D147')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E147')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B148')->getFormattedValue() ?></td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C148')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D148')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E148')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td class="secondary" colspan="7">
                                <label>K) Cash Balance After Debt Service</label>
                            </td>
                        </tr>
                        <tr>
                            <th>Year</th>
                            <th colspan="2">Open.Surplus</th>
                            <th colspan="2">Payments</th>
                            <th colspan="2">Cash Balance</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>1</td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B152')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C152')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D152')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B153')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C153')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D153')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B154')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C154')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D154')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B155')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C155')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D155')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B156')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C156')->getFormattedValue() ?></td>
                            <td class="primary1" colspan="2"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D156')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="color:red">*Average no of full lactation = no of calving (No.cows X 12 months / inter-calving period in months )
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td class="success" colspan="7">
                                <label for="accounting">K) Requirements Of Feed Fodder And Land Requirements For Fodder Cultivation</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Concentrate Required Annually (Ton)*</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B161')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C161')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D161')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E161')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F161')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Green Fodder Required Annually (Ton)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B162')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C162')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D162')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E162')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F162')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Wheat Straw Required Annually (Tons)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B163')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C163')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D163')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E163')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F163')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <td>Average Concentrate(kg) /Animal Unit
                            </td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B165')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C165')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D165')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E165')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F165')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Average Green Fodder(kg)/Animal/Unit
                            </td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B166')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C166')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D166')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E166')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F166')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Average Straw(Kg) /Animal Unit
                            </td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B167')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C167')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D167')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E167')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F167')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <td colspan="7"><b>*Normally concentrate formulae has 1/3 grains,1/3 oil cakes and 1/3 industrial by products</b></td>
                        </tr>
                        <tr>
                            <td>All Oil Cakes(Tons)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B169')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C169')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D169')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E169')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F169')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Mustard Cake(3/4 Of All Cakes)Tons</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B170')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C170')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D170')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E170')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F170')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Mustard Cake For 3 Months(Tons)</td>
                            </td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B171')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C171')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D171')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E171')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F171')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <td><b>Finance Required For Feeding</b></td>
                        <td><b>Year - 1</b></td>
                        <td><b>Year - 2</b></td>
                        <td><b>Year - 3</b></td>
                        <td><b>Year - 4 </b></td>
                        <td><b>Year - 5 </b></td>
                        <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Finance For Concentrate Required Annually (Rs)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B174')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C174')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D174')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E174')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F174')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Finance For Green Fodder Required Annually(Rs)</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B175')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C175')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D175')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E175')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F175')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>Finance For Wheat Straw Required Annually(Rs)</td>
                            </td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B176')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C176')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D176')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E176')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F176')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <td><b>Total</b></td>
                            </td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B178')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C178')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D178')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E178')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F178')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                        <tr>
                            <td>% Of Total Operational Cost</td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B179')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C179')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D179')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E179')->getFormattedValue() ?></td>
                            <td class="success1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F179')->getFormattedValue() ?></td>
                            <td class="success1"></td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td class="warning" colspan="7">
                                <label>Land Required For Fodder Growing(Acre)</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Land Productivity/Annum(qt) Considered
                            </td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B181')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                            <td class="warning1"></td>
                            <td class="warning1"></td>
                            <td class="warning1"></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>Accordingly Calculated Land Required For Fodder(Acres)</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B182')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C182')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D182')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E182')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F182')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>% Of Required Fodder Grown</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B183')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C183')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D183')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E183')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F183')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>Accordingly Land Required For Fodder Growing(Acre)</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B184')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C184')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D184')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E184')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F184')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>Total Fodder To Be Purchased (Ton)/Year</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B185')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C185')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D185')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E185')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F185')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>Silage Feeding Of Purchased Fodder</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B186')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C186')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D186')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E186')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F186')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>Green Fodder Replaced For Silage (Tons)</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B187')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C187')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D187')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E187')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F187')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>Additional Fodder For Silage Making Loses (15%)</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B188')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C188')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D188')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E188')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F188')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>Total Fodder To Be Purchased For Silage(Ton)/Year</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B189')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C189')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D189')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E189')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F189')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                        <tr>
                            <td>Total Fodder For Feeding (Purchased)(Ton)</td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('B190')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('C190')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('D190')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E190')->getFormattedValue() ?></td>
                            <td class="warning1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('F190')->getFormattedValue() ?></td>
                            <td class="warning1"></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label>L) Project Cost Calculation</label>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="7">a)Sheds Area Calculations:</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td class="info" colspan="7"><b>Sheds Breadth Calculation</b></td>
                        </tr>
                        <tr>
                            <td colspan="6">Feeding Manger(ft)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E197')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Standing Place(ft) </td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E198')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Feeding Tractor Trolley Space(ft)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E199')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Backyard Breadth(ft)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E200')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Height(ft)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E201')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Height At Eves(ft)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E202')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Open Space/Side(ft)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E203')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Shed Breadth Excluding Open Space(ft) </td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E204')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Shed Breadth Including Open Space(ft)</td>
                            <td class="info1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E205')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <th class="dark" colspan="7">Length Calculation</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td colspan="6">Number Of Animals/Row</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E207')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Space Width/Animal (ft)</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E208')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">No Of Water Troughs/Side</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E209')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">T. Water Trough Length (@5ft)</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E210')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Total Space At Entry And End(ft)</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E211')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Total Length (ft)</td>
                            <td class="dark1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E212')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <th class="primary" colspan="7">Area Of One Shed And Number Of Sheds And Their Cost Calculations:</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td colspan="6">Covered Area /Shed(sq.ft)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E214')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Area Open(sq.ft)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E215')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Rate/Sq Ft Covered Area With Fittings</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E216')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Rate /Sq Feed Open Paved Area</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E217')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Cost Covered Area(Rs)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E218')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Cost Open Area(Rs)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E219')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Total Cost/Shed (Crore)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E220')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6"> Av.Total Number Of Animal Unit</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E221')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6"><b>Number Of Sheds Required</b></td>
                            <td class="primary1"><b><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E222')->getFormattedValue() ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="6">Total Cost Of Sheds And Paved Open Area(Crore Rs)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E223')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Cost Of Other Structures(Stores,Offices etc /Roads) @10%(Crore)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E224')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Total Cost Of Structure And Roads</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E225')->getFormattedValue() ?></td>
                        </tr>
                    </tbody>
                    <tr>
                        <th colspan="7"></th>
                    </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td colspan="6">Cost Of Machinery(Milking,Feeding,Cleaning etc)@20% Of Shed Cost</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E226')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Cost Of Livestock(Crore)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E227')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Other Costs(Consultancy,One Month Working Capital etc)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E228')->getFormattedValue() ?></td>
                        </tr>
                        <tr>
                            <td colspan="6">Total Costs(Crore)</td>
                            <td class="primary1"><?= $objPHPExcel->setActiveSheetIndex(0)->getCell('E229')->getFormattedValue() ?></td>
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