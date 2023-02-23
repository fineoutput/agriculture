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
            background-color: #2cc16a;
            font-weight: bold;
            color: #fff;
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
    </style>
    <div class="container-fluid p-5  text-center">
        <h1>Dairy Muneem</h1>
        <p>TECHNO-ECONOMIC FEASIBILITY REPORT OF DAIRY FARMING UNIT </p>
        <h4>Size of the Dairy Unit (Cows) : 50</h4>
    </div>
    <div class="container">
        <div class="row">
            <table class="table table-bordered">
                <table>
                    <thead>
                    </thead>
                    <tbody>
                        <?
                        $D90 = 0;
                        $D93 = 0;
                        $E225 = 0;
                        $E226 = 0;
                        $E229 = 0;
                        $E96 = 0;
                        $E97 = 0;
                        $B144 = 0;
                        ?>
                        <!------------------------------------------------------------------------->
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">RESULTS AT GLANCE:</label>
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
                            <td>1)ESTIMATED CAPITAL REQUIRED (Rs)</td>
                            <td><?= $D93 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>a) Owners Capital (Rs)</td>
                            <td><?= $E96 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>b) Loan Amount (Rs)</td>
                            <td><?= $E97 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2a) RETURN ON CAPITAL INVEST. (%) (Excluding gain in animals)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>2b) RETURN ON CAPITAL INVEST. (%) (considering animal gain)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>3) BC RATIO</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>9) COST OF MILK PRODUCTION (Rs)with gained animal Nos</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>10) COST OF MILK PRODUCTION (Rs) </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="labels">
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
                            <td><?= $C22 = 15 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Increase In Milk Production Over Previous Year in %</td>
                            <td></td>
                            <td><?= $D23 = 5 ?></td>
                            <td><?= $E23 = 5 ?></td>
                            <td><?= $F23 = 5 ?></td>
                            <td><?= $G23 = 5 ?></td>
                            <td><?= $H23 = ($D23 + $E23 + $F23 + $G23) / 4 ?></td>
                        </tr>
                        <tr>
                            <td>Conception Rate%</td>
                            <td><?= $C24 = 90 ?>%</td>
                            <td><?= $D24 = 90 ?>%</td>
                            <td><?= $E24 = 90 ?>%</td>
                            <td><?= $F24 = 90 ?>%</td>
                            <td><?= $G24 = 90 ?>%</td>
                            <td><?= $H24 = ($C24 + $D24 + $E24 + $F24 + $G24) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td>Inter Calving Period Months</td>
                            <td><?= $C25 = 13 ?></td>
                            <td><?= $D25 = 13 ?></td>
                            <td><?= $E25 = 13 ?></td>
                            <td><?= $F25 = 13 ?></td>
                            <td><?= $G25 = 13 ?></td>
                            <td><?= $H25 = ($C25 + $D25 + $E25 + $F25 + $G25) / 5 ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Mortality Adult</td>
                            <td><?= $C27 = 0.5 ?>%</td>
                            <td><?= $D27 = 0.5 ?>%</td>
                            <td><?= $E27 = 0.5 ?>%</td>
                            <td><?= $F27 = 0.5 ?>%</td>
                            <td><?= $G27 = 0.5 ?>%</td>
                            <td><?= $H27 = ($C27 + $D27 + $E27 + $F27 + $G27) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td>Mortality Heifer%</td>
                            <td><?= $C28 = 0.5 ?>%</td>
                            <td><?= $D28 = 0.5 ?>%</td>
                            <td><?= $E28 = 0.5 ?>%</td>
                            <td><?= $F28 = 0.5 ?>%</td>
                            <td><?= $G28 = 0.5 ?>%</td>
                            <td><?= $H28 = ($C28 + $D28 + $E28 + $F28 + $G28) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td>Mortality Growing Calf%(Above 1 Year)</td>
                            <td><?= $C29 = 0.5 ?>%</td>
                            <td><?= $D29 = 0.5 ?>%</td>
                            <td><?= $E29 = 0.5 ?>%</td>
                            <td><?= $F29 = 0.5 ?>%</td>
                            <td><?= $G29 = 0.5 ?>%</td>
                            <td><?= $H29 = ($C29 + $D29 + $E29 + $F29 + $G29) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td>Mortality Young Calf%</td>
                            <td><?= $C30 = 5 ?>%</td>
                            <td><?= $D30 = 5 ?>%</td>
                            <td><?= $E30 = 5 ?>%</td>
                            <td><?= $F30 = 5 ?>%</td>
                            <td><?= $G30 = 5 ?>%</td>
                            <td><?= $H30 = ($C30 + $D30 + $E30 + $F30 + $G30) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Culling Rate Adult Cow</td>
                            <td><?= $C32 = 1 ?>%</td>
                            <td><?= $D32 = 1 ?>%</td>
                            <td><?= $E32 = 25 ?>%</td>
                            <td><?= $F32 = 25 ?>%</td>
                            <td><?= $G32 = 25 ?>%</td>
                            <td><?= $H32 = ($C32 + $D32 + $E32 + $F32 + $G32) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Heifer</td>
                            <td><?= $C33 = 0 ?>%</td>
                            <td><?= $D33 = 2.5 ?>%</td>
                            <td><?= $E33 = 25 ?>%</td>
                            <td><?= $F33 = 30 ?>%</td>
                            <td><?= $G33 = 30 ?>%</td>
                            <td><?= $H33 = ($C33 + $D33 + $E33 + $F33 + $G33) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Growing Calf (Above 1 Year)</td>
                            <td><?= $C34 = 12 ?>%</td>
                            <td><?= $D34 = 12 ?>%</td>
                            <td><?= $E34 = 12 ?>%</td>
                            <td><?= $F34 = 12 ?>%</td>
                            <td><?= $G34 = 12 ?>%</td>
                            <td><?= $H34 = ($C34 + $D34 + $E34 + $F34 + $G34) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Calf</td>
                            <td><?= $C35 = 2 ?>%</td>
                            <td><?= $D35 = 2 ?>%</td>
                            <td><?= $E35 = 2 ?>%</td>
                            <td><?= $F35 = 2 ?>%</td>
                            <td><?= $G35 = 2 ?>%</td>
                            <td><?= $H35 = ($C35 + $D35 + $E35 + $F35 + $G35) / 5 ?>%</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Young Calf Equal To Adult</td>
                            <td><?= $C37 = 0.3 ?></td>
                            <td><?= $D37 = 0.3 ?></td>
                            <td><?= $E37 = 0.3 ?></td>
                            <td><?= $F37 = 0.3 ?></td>
                            <td><?= $G37 = 0.3 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Growing Calf(Above 12 Month)</td>
                            <td><?= $C38 = 0.5 ?></td>
                            <td><?= $D38 = 0.5 ?></td>
                            <td><?= $E38 = 0.5 ?></td>
                            <td><?= $F38 = 0.5 ?></td>
                            <td><?= $G38 = 0.5 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Heifer/Cow</td>
                            <td><?= $C39 = 1 ?></td>
                            <td><?= $D39 = 1 ?></td>
                            <td><?= $E39 = 1 ?></td>
                            <td><?= $F39 = 1 ?></td>
                            <td><?= $G39 = 1 ?></td>
                            <td></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Initial live stock</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Unitsat The Start</td>
                            <td><?= $C41 = $number_of_cows ?></td>
                            <td><?= $D41 = 0 ?></td>
                            <td><?= $E41 = 0 ?></td>
                            <td><?= $F41 = 0 ?></td>
                            <td><?= $G41 = 0 ?></td>
                            <td><?= $H41 = ($C41 + $D41 + $E41 + $F41 + $G41) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Heifer At The Start Of Year</td>
                            <td><?= $C42 = 0 ?></td>
                            <td><?= $D42 = 0 ?></td>
                            <td><?= $E42 = 0 ?></td>
                            <td><?= $F42 = 0 ?></td>
                            <td><?= $G42 = 0 ?></td>
                            <td><?= $H42 = ($C42 + $D42 + $E42 + $F42 + $G42) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calf(Above 1 Year)</td>
                            <td><?= $C43 = 0 ?></td>
                            <td><?= $D43 = 0 ?></td>
                            <td><?= $E43 = 0 ?></td>
                            <td><?= $F43 = 0 ?></td>
                            <td><?= $G43 = 0 ?></td>
                            <td><?= $H43 = ($C43 + $D43 + $E43 + $F43 + $G43) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Female Young Calf Brought/Born Of Year</td>
                            <td><?= $C44 = $C41 / 2 ?></td>
                            <td><?= $D44 = ($C41 * $C24 / 100) / 2 ?></td>
                            <td><?= $E44 = ($D41 * $D24 / 100) / 2 ?></td>
                            <td><?= $F44 = ($E41 * $E24 / 100) / 2 ?></td>
                            <td><?= $G44 = ($F41 * $F24 / 100) / 2 ?></td>
                            <td><?= $H44 = ($C44 + $D44 + $E44 + $F44 + $G44) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Initial Total Animal Units At Start (Including Calf Born)</td>
                            <td><?= $C45 = $C41 + ($C44 * $C37) ?></td>
                            <td><?= $D45 = $D41 + $D42 + ($D43 * $D38) + ($D44 * $D37) ?></td>
                            <td><?= $E45 = $E41 + $E42 + ($E43 * $E38) + ($E44 * $E37) ?></td>
                            <td><?= $F45 = $F41 + $F42 + ($F43 * $F38) + ($F44 * $F37) ?></td>
                            <td><?= $G45 = $G41 + $G42 + ($G43 * $G38) + ($G44 * $G37) ?></td>
                            <td><?= $H45 = ($C45 + $D45 + $E45 + $F45 + $G45) / 5 ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Mortality Detail</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Mortality(No)</td>
                            <td><?= $C48 = $C41 * $C27 / 100 ?></td>
                            <td><?= $D48 = $D41 * $D27 / 100 ?></td>
                            <td><?= $E48 = $E41 * $E27 / 100 ?></td>
                            <td><?= $F48 = $F41 * $F27 / 100 ?></td>
                            <td><?= $G48 = $G41 * $G27 / 100 ?></td>
                            <td><?= $H48 = ($C48 + $D48 + $E48 + $F48 + $G48) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Heifer Mortality(No)</td>
                            <td><?= $C49 = $C42 * $C28 / 100 ?></td>
                            <td><?= $D49 = $D42 * $D28 / 100 ?></td>
                            <td><?= $E49 = $E42 * $E28 / 100 ?></td>
                            <td><?= $F49 = $F42 * $F28 / 100 ?></td>
                            <td><?= $G49 = $G42 * $G28 / 100 ?></td>
                            <td><?= $H49 = ($C49 + $D49 + $E49 + $F49 + $G49) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calf Mortality(No)</td>
                            <td><?= $C50 = $C43 * $C29 / 100 ?></td>
                            <td><?= $D50 = $D43 * $D29 / 100 ?></td>
                            <td><?= $E50 = $E43 * $E29 / 100 ?></td>
                            <td><?= $F50 = $F43 * $F29 / 100 ?></td>
                            <td><?= $G50 = $G43 * $G29 / 100 ?></td>
                            <td><?= $H50 = ($C50 + $D50 + $E50 + $F50 + $G50) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Young Calf Mortality(No)</td>
                            <td><?= $C51 = $C44 * $C30 / 100 ?></td>
                            <td><?= $D51 = $D44 * $D30 / 100 ?></td>
                            <td><?= $E51 = $E44 * $E30 / 100 ?></td>
                            <td><?= $F51 = $F44 * $F30 / 100 ?></td>
                            <td><?= $G51 = $G44 * $G30 / 100 ?></td>
                            <td><?= $H51 = ($C51 + $D51 + $E51 + $F51 + $G51) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Mortality(Adult Unit)</td>
                            <td><?= $C52 = $C48 + $C49 + ($C50 * $C38) + ($C51 * $C37) ?></td>
                            <td><?= $D52 = $D48 + $D49 + ($D50 * $D38) + ($D51 * $D37) ?></td>
                            <td><?= $E52 = $E48 + $E49 + ($E50 * $E38) + ($E51 * $E37) ?></td>
                            <td><?= $F52 = $F48 + $F49 + ($F50 * $F38) + ($F51 * $F37) ?></td>
                            <td><?= $G52 = $G48 + $G49 + ($G50 * $G38) + ($G51 * $G37) ?></td>
                            <td><?= $H52 = ($C52 + $D52 + $E52 + $F52 + $G52) / 5 ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Stock After Mortality</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Less Mortality</td>
                            <td><?= $C55 = $C41 - $C48 ?></td>
                            <td><?= $D55 = $D41 - $D48 ?></td>
                            <td><?= $E55 = $E41 - $E48 ?></td>
                            <td><?= $F55 = $F41 - $F48 ?></td>
                            <td><?= $G55 = $G41 - $G48 ?></td>
                            <td><?= $H55 = ($C55 + $D55 + $E55 + $F55 + $G55) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Lactating Heifers Less Mortality </td>
                            <td><?= $C56 = $C42 - $C49 ?></td>
                            <td><?= $D56 = $D42 - $D49 ?></td>
                            <td><?= $E56 = $E42 - $E49 ?></td>
                            <td><?= $F56 = $F42 - $F49 ?></td>
                            <td><?= $G56 = $G42 - $G49 ?></td>
                            <td><?= $H56 = ($C56 + $D56 + $E56 + $F56 + $G56) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calves(Above 1 Year) Mortality</td>
                            <td><?= $C57 = $C43 - $C50 ?></td>
                            <td><?= $D57 = $D43 - $D50 ?></td>
                            <td><?= $E57 = $E43 - $E50 ?></td>
                            <td><?= $F57 = $F43 - $F50 ?></td>
                            <td><?= $G57 = $G43 - $G50 ?></td>
                            <td><?= $H57 = ($C57 + $D57 + $E57 + $F57 + $G57) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Calves Less Mortality </td>
                            <td><?= $C58 = $C44 - $C51 ?></td>
                            <td><?= $D58 = $D44 - $D51 ?></td>
                            <td><?= $E58 = $E44 - $E51 ?></td>
                            <td><?= $F58 = $F44 - $F51 ?></td>
                            <td><?= $G58 = $G44 - $G51 ?></td>
                            <td><?= $H58 = ($C58 + $D58 + $E58 + $F58 + $G58) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Stock Less Mortality</td>
                            <td><?= $C59 = $C55 + $C56 + ($C57 * $C38) + ($C58 * $C37) ?></td>
                            <td><?= $D59 = $D55 + $D56 + ($D57 * $D38) + ($D58 * $D37) ?></td>
                            <td><?= $E59 = $E55 + $E56 + ($E57 * $E38) + ($E58 * $E37) ?></td>
                            <td><?= $F59 = $F55 + $F56 + ($F57 * $F38) + ($F58 * $F37) ?></td>
                            <td><?= $G59 = $G55 + $G56 + ($G57 * $G38) + ($G58 * $G37) ?></td>
                            <td><?= $H59 = ($C59 + $D59 + $E59 + $F59 + $G59) / 5 ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Stock Culled & Sold</th>
                        </tr>
                        <tr>
                            <td>Lactating Cow</td>
                            <td><?= $C62 = $C55 - $C32 / 100 ?></td>
                            <td><?= $D62 = $D55 - $D32 / 100 ?></td>
                            <td><?= $E62 = $E55 - $E32 / 100 ?></td>
                            <td><?= $F62 = $F55 - $F32 / 100 ?></td>
                            <td><?= $G62 = $G55 - $G32 / 100 ?></td>
                            <td><?= $H62 = ($C62 + $D62 + $E62 + $F62 + $G62) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Heifer</td>
                            <td><?= $C63 = $C56 - $C33 / 100 ?></td>
                            <td><?= $D63 = $D56 - $D33 / 100 ?></td>
                            <td><?= $E63 = $E56 - $E33 / 100 ?></td>
                            <td><?= $F63 = $F56 - $F33 / 100 ?></td>
                            <td><?= $G63 = $G56 - $G33 / 100 ?></td>
                            <td><?= $H63 = ($C63 + $D63 + $E63 + $F63 + $G63) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Growing Calves(Above 1 Year)</td>
                            <td><?= $C64 = $C57 - $C34 / 100 ?></td>
                            <td><?= $D64 = $D57 - $D34 / 100 ?></td>
                            <td><?= $E64 = $E57 - $E34 / 100 ?></td>
                            <td><?= $F64 = $F57 - $F34 / 100 ?></td>
                            <td><?= $G64 = $G57 - $G34 / 100 ?></td>
                            <td><?= $H64 = ($C64 + $D64 + $E64 + $F64 + $G64) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Calf</td>
                            <td><?= $C65 = $C58 - $C35 / 100 ?></td>
                            <td><?= $D65 = $D58 - $D35 / 100 ?></td>
                            <td><?= $E65 = $E58 - $E35 / 100 ?></td>
                            <td><?= $F65 = $F58 - $F35 / 100 ?></td>
                            <td><?= $G65 = $G58 - $G35 / 100 ?></td>
                            <td><?= $H65 = ($C65 + $D65 + $E65 + $F65 + $G65) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Unit Culled</td>
                            <td><?= $C66 = $C62 + $C63 + ($C64 * $C38) + ($C65 * $C37) ?></td>
                            <td><?= $D66 = $D62 + $D63 + ($D64 * $D38) + ($D65 * $D37) ?></td>
                            <td><?= $E66 = $E62 + $E63 + ($E64 * $E38) + ($E65 * $E37) ?></td>
                            <td><?= $F66 = $F62 + $F63 + ($F64 * $F38) + ($F65 * $F37) ?></td>
                            <td><?= $G66 = $G62 + $G63 + ($G64 * $G38) + ($G65 * $G37) ?></td>
                            <td><?= $H66 = ($C66 + $D66 + $E66 + $F66 + $G66) / 5 ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Final Stock At The End Of Year</th>
                        </tr>
                        <tr>
                            <td>Lactating Cow</td>
                            <td><?= $C69 = $C55 - $C62 ?></td>
                            <td><?= $D69 = $D55 - $D62 ?></td>
                            <td><?= $E69 = $E55 - $E62 ?></td>
                            <td><?= $F69 = $F55 - $F62 ?></td>
                            <td><?= $G69 = $G55 - $G62 ?></td>
                            <td><?= $H69 = ($C69 + $D69 + $E69 + $F69 + $G69) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Heifer </td>
                            <td><?= $C70 = $C56 - $C63 ?></td>
                            <td><?= $D70 = $D56 - $D63 ?></td>
                            <td><?= $E70 = $E56 - $E63 ?></td>
                            <td><?= $F70 = $F56 - $F63 ?></td>
                            <td><?= $G70 = $G56 - $G63 ?></td>
                            <td><?= $H70 = ($C70 + $D70 + $E70 + $F70 + $G70) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Growing Calf (Above 1 Year)</td>
                            <td><?= $C71 = $C57 - $C64 ?></td>
                            <td><?= $D71 = $D57 - $D64 ?></td>
                            <td><?= $E71 = $E57 - $E64 ?></td>
                            <td><?= $F71 = $F57 - $F64 ?></td>
                            <td><?= $G71 = $G57 - $G64 ?></td>
                            <td><?= $H71 = ($C71 + $D71 + $E71 + $F71 + $G71) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Calf</td>
                            <td><?= $C72 = $C58 - $C65 ?></td>
                            <td><?= $D72 = $D58 - $D65 ?></td>
                            <td><?= $E72 = $E58 - $E65 ?></td>
                            <td><?= $F72 = $F58 - $F65 ?></td>
                            <td><?= $G72 = $G58 - $G65 ?></td>
                            <td><?= $H72 = ($C72 + $D72 + $E72 + $F72 + $G72) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Animal Units At The End Of Year</td>
                            <td><?= $C73 = $C69 + $C70 + ($C71 * $C38) + ($C72 * $C37) ?></td>
                            <td><?= $D73 = $D69 + $D70 + ($D71 * $D38) + ($D72 * $D37) ?></td>
                            <td><?= $E73 = $E69 + $E70 + ($E71 * $E38) + ($E72 * $E37) ?></td>
                            <td><?= $F73 = $F69 + $F70 + ($F71 * $F38) + ($F72 * $F37) ?></td>
                            <td><?= $G73 = $G69 + $G70 + ($G71 * $G38) + ($G72 * $G37) ?></td>
                            <td><?= $H73 = ($C73 + $D73 + $E73 + $F73 + $G73) / 5 ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Gain In Animal Unit</th>
                        </tr>
                        <tr>
                            <td>Animal Unit At The End Of Year</td>
                            <td><?= $C76 = $C73 ?></td>
                            <td><?= $D76 = $D73 ?></td>
                            <td><?= $E76 = $E73 ?></td>
                            <td><?= $F76 = $F73 ?></td>
                            <td><?= $G76 = $G73 ?></td>
                            <td><?= $H76 = ($C76 + $D76 + $E76 + $F76 + $G76) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Gain In Animal Unit </td>
                            <td><?= $C77 = $C45 - $C76 ?></td>
                            <td><?= $D77 = $D45 - $D76 ?></td>
                            <td><?= $E77 = $E45 - $E76 ?></td>
                            <td><?= $F77 = $F45 - $F76 ?></td>
                            <td><?= $G77 = $G45 - $G76 ?></td>
                            <td><?= $H77 = ($C77 + $D77 + $E77 + $F77 + $G77) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Value Of Gain Animal Unit</td>
                            <td><?= $C78 = $C77 * $D90 ?></td>
                            <td><?= $D78 = $D77 * $D90 ?></td>
                            <td><?= $E78 = $E77 * $D90 ?></td>
                            <td><?= $F78 = $F77 * $D90 ?></td>
                            <td><?= $G78 = $G77 * $D90 ?></td>
                            <td><?= $H78 = ($C78 + $D78 + $E78 + $F78 + $G78) / 5 ?></td>
                        </tr>
                    </tbody>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label>B) MILK PRODUCTION PROJECTIONS</label>
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
                            <td>Total Number Of Expected Lactations/Year*</td>
                            <td><?= $C81 = ($C41 * (12 / $C25)) ?></td>
                            <td><?= $D81 = ($D41 * (12 / $D25)) * $C24 / 100 ?></td>
                            <td><?= $E81 = ($E41 * (12 / $E25)) * $D24 / 100 ?></td>
                            <td><?= $F81 = ($F41 * (12 / $F25)) * $E24 / 100 ?></td>
                            <td><?= $G81 = ($G41 * (12 / $G25)) * $F24 / 100 ?></td>
                            <td><?= $H81 = $H41 * (12 / $H25) ?></td>
                        </tr>
                        <tr>
                            <td>Expected Milk Yield/Lactation</td>
                            <td><?= $C82 = $C22 * 300 ?></td>
                            <td><?= $D82 = $C82 + ($C82 * $D23 / 100) ?></td>
                            <td><?= $E82 = $D82 + ($D82 * $E23 / 100) ?></td>
                            <td><?= $F82 = $E82 + ($E82 * $F23 / 100) ?></td>
                            <td><?= $G82 = $F82 + ($F82 * $G23 / 100) ?></td>
                            <td><?= $H82 = ($C82 + $D82 + $E82 + $F82 + $G82) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Total Milk Production (lit)</td>
                            <td><?= $C83 = $C81 * $C82 ?></td>
                            <td><?= $D83 = $D81 * $D82 ?></td>
                            <td><?= $E83 = $E81 * $E82 ?></td>
                            <td><?= $F83 = $F81 * $F82 ?></td>
                            <td><?= $G83 = $G81 * $G82 ?></td>
                            <td><?= $H83 = ($C83 + $D83 + $E83 + $F83 + $G83) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Minus Milk For Feeding Calves (lit)(300Lt/Calf)</td>
                            <td><?= $C84 = 300 * $C81 ?></td>
                            <td><?= $D84 = 300 * $D81 ?></td>
                            <td><?= $E84 = 300 * $E81 ?></td>
                            <td><?= $F84 = 300 * $F81 ?></td>
                            <td><?= $G84 = 300 * $G81 ?></td>
                            <td><?= $H84 = ($C84 + $D84 + $E84 + $F84 + $G84) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Milk Available For Sale (lit)</td>
                            <td><?= $C85 = $C83 - $C84 ?></td>
                            <td><?= $D85 = $D83 - $D84 ?></td>
                            <td><?= $E85 = $E83 - $E84 ?></td>
                            <td><?= $F85 = $F83 - $F84 ?></td>
                            <td><?= $G85 = $G83 - $G84 ?></td>
                            <td><?= $H85 = ($C85 + $D85 + $E85 + $F85 + $G85) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Daily Availability of Milk For Sale</td>
                            <td><?= $C86 = $C85 / 365 ?></td>
                            <td><?= $D86 = $D85 / 365 ?></td>
                            <td><?= $E86 = $E85 / 365 ?></td>
                            <td><?= $F86 = $F85 / 365 ?></td>
                            <td><?= $G86 = $G85 / 365 ?></td>
                            <td><?= $H86 = ($C86 + $D86 + $E86 + $F86 + $G86) / 5 ?></td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="hide">
                        <tr>
                            <td colspan="7" class="C_label">
                                <label>C) Technical Parameters And Cost Of Purchased Material & Sale Prices Considered:</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Market Price Of Cow Considered On Per Liter Average Daily Yield (Rs)</td>
                            <td colspan="6"><?= $D89 = 3800 ?></td>
                        </tr>
                        <tr>
                            <td>Estimated Cost/Cow (Rs)</td>
                            <td colspan="6"><?= $D90 = $C22 * $D89 ?></td>
                        </tr>
                        <tr>
                            <td>Estimated Housing + Equipments Cost (Rs),Detail Below At "L"</td>
                            <td colspan="6"><?= $D91 = ($E226 + $E225) * 10000000 ?></td>
                        </tr>
                        <tr>
                            <td>Estimated Capital Investment /Cow Unit (Rs)</td>
                            <td colspan="6"><?= $D92 = $D93 / $number_of_cows ?></td>
                        </tr>
                        <tr>
                            <td>Estimated Total Capital (Rs) Detail Given Below At L</td>
                            <td colspan="6"><?= $D92 = $E229 * 10000000 ?></td>
                        </tr>
                        <tr>
                            <td>Rate Of Interest</td>
                            <td colspan="6"><?= $B94 = 12 ?></td>
                        </tr>
                        <tr>
                            <td>Margin Money (%)</td>
                            <td colspan="6"><?= $B95 = 75 ?></td>
                        </tr>
                        <tr>
                            <td>Owners Capital</td>
                            <td colspan="6"><?= $E96 = $D93 - $E97 ?></td>
                        </tr>
                        <tr>
                            <td>Loan (Rs)</td>
                            <td colspan="6"><?= $E97 = $B144 ?></td>
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
                        <?
                        $B100 = 22;
                        $B106 = 120000;
                        $B121 = 0.6;
                        $B122 = 3;
                        $B123 = 13;
                        ?>
                        <tr>
                            <td>Annual Increase In Feed Cost, Milk Selling Prices & Wages %</td>
                            <td></td>
                            <td><?= $D99 = 3 ?></td>
                            <td><?= $E99 = 3 ?></td>
                            <td><?= $F99 = 3 ?></td>
                            <td><?= $G99 = 3 ?></td>
                            <td><?= $H99 = ($D99 + $E99 + $F99 + $G99) / 4 ?></td>
                        </tr>
                        <tr>
                            <td>Milk Selling Price (Rs)/Lit. (av) :</td>
                            <td><?= $C100 = $B100 ?></td>
                            <td><?= $D100 = $C100 + $C100 * $D99 / 100 ?></td>
                            <td><?= $E100 = $D100 + $D100 * $E99 / 100 ?></td>
                            <td><?= $F100 = $E100 + $E100 * $F99 / 100 ?></td>
                            <td><?= $G100 = $F100 + $F100 * $G99 / 100 ?></td>
                            <td><?= $H100 = ($C100 + $D100 + $E100 + $F100 + $G100) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Green Fodder (Rs)/KG:</td>
                            <td><?= $C101 = $B121 ?></td>
                            <td><?= $D101 = $C101 + $C101 * $D99 / 100 ?></td>
                            <td><?= $E101 = $D101 + $D101 * $E99 / 100 ?></td>
                            <td><?= $F101 = $E101 + $E101 * $F99 / 100 ?></td>
                            <td><?= $G101 = $F101 + $F101 * $G99 / 100 ?></td>
                            <td><?= $H101 = ($C101 + $D101 + $E101 + $F101 + $G101) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Straw (Rs)/KG:</td>
                            <td><?= $C102 = $B122 ?></td>
                            <td><?= $D102 = $C102 + $C102 * $D99 / 100 ?></td>
                            <td><?= $E102 = $D102 + $D102 * $E99 / 100 ?></td>
                            <td><?= $F102 = $E102 + $E102 * $F99 / 100 ?></td>
                            <td><?= $G102 = $F102 + $F102 * $G99 / 100 ?></td>
                            <td><?= $H102 = ($C102 + $D102 + $E102 + $F102 + $G102) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Concentrate (Rs)/KG:</td>
                            <td><?= $C103 = $B123 ?></td>
                            <td><?= $D103 = $C103 + $C103 * $D99 / 100 ?></td>
                            <td><?= $E103 = $D103 + $D103 * $E99 / 100 ?></td>
                            <td><?= $F103 = $E103 + $E103 * $F99 / 100 ?></td>
                            <td><?= $G103 = $F103 + $F103 * $G99 / 100 ?></td>
                            <td><?= $H103 = ($C103 + $D103 + $E103 + $F103 + $G103) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Contractual Labor Wages /Cow Unit/Year</td>
                            <td><?= $C104 = 4000 ?></td>
                            <td><?= $D104 = $C104 + $C104 * $D99 / 100 ?></td>
                            <td><?= $E104 = $D104 + $D104 * $E99 / 100 ?></td>
                            <td><?= $F104 = $E104 + $E104 * $F99 / 100 ?></td>
                            <td><?= $G104 = $F104 + $F104 * $G99 / 100 ?></td>
                            <td><?= $H104 = ($C104 + $D104 + $E104 + $F104 + $G104) / 5 ?></td>
                        </tr>
                        <tr>
                            <td>Number Of Manager/Supervisor Hired @1 per/100A.Unit</td>
                            <td><?= $C105 = ($C73 / 100 < 1) ? 0 : $C73 / 100 ?></td>
                            <td><?= $D105 = ($D73 / 100 < 1) ? 0 : $D73 / 100 ?></td>
                            <td><?= $E105 = ($E73 / 100 < 1) ? 0 : $E73 / 100 ?></td>
                            <td><?= $F105 = ($F73 / 100 < 1) ? 0 : $F73 / 100 ?></td>
                            <td><?= $G105 = ($G73 / 100 < 1) ? 0 : $G73 / 100 ?></td>
                            <td><?= $H105 = ($H73 / 100 < 1) ? 0 : $H73 / 100 ?></td>
                        </tr>
                        <tr>
                            <td>Supervisors Salary / Annum (10% Annual Increase) </td>
                            <td><?= $C106 = $B106 ?></td>
                            <td><?= $D106 = $C106 + $C106 / 10 ?></td>
                            <td><?= $E106 = $D106 + $D106 / 10 ?></td>
                            <td><?= $F106 = $E106 + $E106 / 10 ?></td>
                            <td><?= $G106 = $F106 + $F106 / 10 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Supervisors Salary / Annum </td>
                            <td><?= $C107 = $C105 * $C106 ?></td>
                            <td><?= $D107 = $D105 * $D106 ?></td>
                            <td><?= $E107 = $E105 * $E106 ?></td>
                            <td><?= $F107 = $F105 * $F106 ?></td>
                            <td><?= $G107 = $G105 * $G106 ?></td>
                            <td><?= $H107 = $G107 + $G107 * $D99 / 100 ?></td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label>D) Executed Sale Proceeds</label>
                            </td>
                        </tr>
                        <tr>
                            <th>Unit Cost (Rs.)</th>
                            <th>Year-1</th>
                            <th>Year-2</th>
                            <th>Year-3</th>
                            <th>Year-4</th>
                            <th>Year-5</th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>I) Milk Sale(Rs)</td>
                            <td></td>
                            <td><?= $C112 = $C100 * $C85 ?></td>
                            <td><?= $D112 = $D100 * $D85 ?></td>
                            <td><?= $E112 = $E100 * $E85 ?></td>
                            <td><?= $F112 = $F100 * $F85 ?></td>
                            <td><?= $G112 = $G100 * $G85 ?></td>
                        </tr>
                        <tr>
                            <td>ii) Misc. Sales</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Animal Unit Sold (Culled) </td>
                            <td><?= $B113 = $D90 ?></td>
                            <td><?= $C113 = $C66 * $B113 ?></td>
                            <td><?= $D113 = $D66 * $B113 ?></td>
                            <td><?= $E113 = $E66 * $B113 ?></td>
                            <td><?= $F113 = $F66 * $B113 ?></td>
                            <td><?= $G113 = $G66 * $B113 ?></td>
                        </tr>
                        <tr>
                            <td>Male Calf (Disposed Of Within 1-2 Months)</td>
                            <td><?= $B114 = 50 ?></td>
                            <td><?= $C114 = ($C81 / 2) * $B114 ?></td>
                            <td><?= $D114 = ($D81 / 2) * $B114 ?></td>
                            <td><?= $E114 = ($E81 / 2) * $B114  ?></td>
                            <td><?= $F114 = ($F81 / 2) * $B114  ?></td>
                            <td><?= $G114 = ($G81 / 2) * $B114  ?></td>
                        </tr>
                        <tr>
                            <td>Insurance Claim Of Mortality </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Cow dung/animal unit</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>iii) Total Sales</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">E) EXPECTED OPERATIONAL EXPENDITURE</label>
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
                            <td>G. Fodder cost @ 40kg/animal unit</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Straw @ 3Kg/animal unit</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Concentrate for milk production @ 2.5Kg/Lit</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Concentrate maintenance @1.5Kg/ani. unit</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Medicines & AI etc.</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Rent/leasing cost for land for Shed etc /A.unit.</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Contractual labor Wages /cow unit/year</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Salary of supervisor/annum </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Insurance premium cows only</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Electricity charges@ 1200 /animal unit/year</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Other misc. charges@1200/animal unit</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>(a) Total operating cost </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Operating surplus (Total sale - Operational cost)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>(b) Dep. On shed machinery & Equipments </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total Exp. (a+b)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>F) NET PROFIT
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>G) A)RETURN ON CAPITAL INVEST.( %)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <td>G) B)RETURN ON CAPITAL INVEST.( %)INCL ANI>
                        </td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        </tr>
                        <td>H) BC RATIO
                        </td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        </tr>
                        <td>H) BC RATIO
                        </td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        </tr>
                        <td>Ia) COST OF MILK PRODUCTION (Rs)with animal gain
                        </td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        </tr>
                        <td>Ib) COST OF MILK PRODUCTION (Rs)
                        </td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        <td>data</td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">J) LOAN DISBURSEMENT AND PAYMENT SCHEDULE
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>YEAR
                            </th>
                            <th>Loan
                            </th>
                            <th>Interest
                            </th>
                            <th>Installment
                            </th>
                            <th>Total
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>1</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">K) CASH BALANCE AFTER DEBT SERVICE
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>YEAR
                            </th>
                            <th>Open.Surplus
                            </th>
                            <th>Payments
                            </th>
                            <th>Cash balance
                            </th>
                            <th>
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>1</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>*Average no of full lactation = no of calving (No.cows X 12 months / inter-calving period in months )
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">K)REQUIREMENTS OF FEED FODDER AND LAND REQUIREMENTS FOR FODDER
                                    CULTIVATION
                                </label>
                            </td>
                        </tr>
                        <tr>
                        <tr>
                            <th> </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>concentrate required annualy(ton)*
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>green fodder required annualy(ton)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>wheat straw required annualy(tons)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>average concentrate(kg) /animal unit
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>average green fodder(kg)/animal/unit
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>average straw(Kg) /animal unit
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <td>*Normally concentrateformulae has 1/3 grains,1/3 oilcakes and 1/3 industrial by products
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <tr>
                            <td>all oil cakes(tons)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>mustard cake(3/4 of all cakes)tons
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>mustard cake for 3 months(Tons)
                            </td>
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <td>FINANCE REQUIRED FOR FEEDING
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <tr>
                            <td>Finance for concentrate required annualy(Rs)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Finance for green fodder required annualy(Rs)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Finance for wheat straw required annualy(Rs)
                            </td>
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total
                            </td>
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>% of total operational cost
                            </td>
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">J) LOAN DISBURSEMENT AND PAYMENT SCHEDULE
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>YEAR
                            </th>
                            <th>Loan
                            </th>
                            <th>Interest
                            </th>
                            <th>Installment
                            </th>
                            <th>Total
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>1</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">land required for fodder growing(acre)
                                </label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Land productivity/annum(qt) considered
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Accordingly calculated land required for fodder(acres)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>%of required fodder grown
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Accordingly land required for fodder growing(acre)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total fodder to be purcased(ton)/year
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> silage feeding of purchased fodder
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> Green fodder replaced for silage (tons)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Additional fodder for silage making loses (15%)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> Total fodder to be purcased for silage(ton)/year
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> Total fodder for feeding (purchased)(ton)
                            </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">L)PROJECT COST CALCULATION
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>a)Sheds area calculations:
                            </th>
                            <th>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Sheds breadth calculation
                            </th>
                            <th>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Feeding manger(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Standing place(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Feeding tractor trolley space(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>backyard breadth(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>height(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> height at eves(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> open space/side(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Shed breadth Exclding openspace(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> shed breadth inclding openspace(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>length calculation
                            </th>
                            <th>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>number of animals/row
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Space width/animal (ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No of water troughs/side
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>T. water trough length (@5ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>total space at entry and end(ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total length (ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>number of animals/row
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Area of one shed and Number of sheds and thire cost calculations:
                            </th>
                            <th>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>CoveredArea /shed(sq.ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Area open(sq.ft)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Rate/Sq ft covered area with fittings
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Rate /sq feed open paved area
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cost covered area(Rs)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cost Open area(Rs)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total cost/shed (crore)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> Av.Total number of animal unit
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Number of sheds required
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>Total Cost of sheds and paved open area(Crore Rs)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cost of other structures(stores,offices etc /roads) @10%(crore)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Cost of structure and roads
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tr>
                        <th>
                        </th>
                        <th>
                        </th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Cost of machinary(milking,feeding,cleaning etc)@20%of shed cost
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cost of livestock(crore)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Other costs(consultancy,one month working capital etc)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total costs(crore)
                            </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
</body>
</html>
</body>
</html>