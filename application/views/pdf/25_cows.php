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
                            <td><?= $C12 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>a) Owners Capital (Rs)</td>
                            <td><?= $C13 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>b) Loan Amount (Rs)</td>
                            <td><?= $C14 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2a) RETURN ON CAPITAL INVEST. (%) (Excluding gain in animals)</td>
                            <td><?= $C15 ?></td>
                            <td><?= $D15 ?></td>
                            <td><?= $E15 ?></td>
                            <td><?= $F15 ?></td>
                            <td><?= $G15 ?></td>
                            <td><?= $H15 ?></td>
                        </tr>
                        <tr>
                            <td>2b) RETURN ON CAPITAL INVEST. (%) (considering animal gain)</td>
                            <td><?= $C16 ?></td>
                            <td><?= $D16 ?></td>
                            <td><?= $E16 ?></td>
                            <td><?= $F16 ?></td>
                            <td><?= $G16 ?></td>
                            <td><?= $H16 ?></td>
                        </tr>
                        <?die();?>
                        <tr>
                            <td>3) BC RATIO</td>
                            <td><?= $C139 ?></td>
                            <td><?= $D139 ?></td>
                            <td><?= $E139 ?></td>
                            <td><?= $F139 ?></td>
                            <td><?= $G139 ?></td>
                            <td><?= $H17 ?></td>
                        </tr>
                        <tr>
                            <td>9) COST OF MILK PRODUCTION (Rs)with gained animal Nos</td>
                            <td><?= $C140 ?></td>
                            <td><?= $D140 ?></td>
                            <td><?= $E140 ?></td>
                            <td><?= $F140 ?></td>
                            <td><?= $G140 ?></td>
                            <td><?= $H18 ?></td>
                        </tr>
                        <tr>
                            <td>10) COST OF MILK PRODUCTION (Rs) </td>
                            <td><?= $C141 ?></td>
                            <td><?= $D141 ?></td>
                            <td><?= $E141 ?></td>
                            <td><?= $F141 ?></td>
                            <td><?= $G141 ?></td>
                            <td><?= $H19 ?></td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">A) Production Parameters Considered And Livestock
                                    Strength</label>
                                <input type="checkbox" name="accounting" id="accounting" <?= $D93 ?>-toggle="toggle">
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
                            <td><?= $D23 ?></td>
                            <td><?= $E23 ?></td>
                            <td><?= $F23  ?></td>
                            <td><?= $G23  ?></td>
                            <td><?= $H23 ?></td>
                        </tr>
                        <tr>
                            <td>Conception Rate%</td>
                            <td><?= $C24  ?>%</td>
                            <td><?= $D24  ?>%</td>
                            <td><?= $E24  ?>%</td>
                            <td><?= $F24 ?>%</td>
                            <td><?= $G24  ?>%</td>
                            <td><?= $H24 ?>%</td>
                        </tr>
                        <tr>
                            <td>Inter Calving Period Months</td>
                            <td><?= $C25 ?></td>
                            <td><?= $D25  ?></td>
                            <td><?= $E25 ?></td>
                            <td><?= $F25 ?></td>
                            <td><?= $G25  ?></td>
                            <td><?= $H25 ?></td>
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
                            <td><?= $C27  ?>%</td>
                            <td><?= $D27  ?>%</td>
                            <td><?= $E27  ?>%</td>
                            <td><?= $F27  ?>%</td>
                            <td><?= $G27  ?>%</td>
                            <td><?= $H27  ?>%</td>
                        </tr>
                        <tr>
                            <td>Mortality Heifer%</td>
                            <td><?= $C28 ?>%</td>
                            <td><?= $D28 ?>%</td>
                            <td><?= $E28  ?>%</td>
                            <td><?= $F28 ?>%</td>
                            <td><?= $G28  ?>%</td>
                            <td><?= $H28  ?>%</td>
                        </tr>
                        <tr>
                            <td>Mortality Growing Calf%(Above 1 Year)</td>
                            <td><?= $C29  ?>%</td>
                            <td><?= $D29  ?>%</td>
                            <td><?= $E29  ?>%</td>
                            <td><?= $F29  ?>%</td>
                            <td><?= $G29  ?>%</td>
                            <td><?= $H29  ?>%</td>
                        </tr>
                        <tr>
                            <td>Mortality Young Calf%</td>
                            <td><?= $C30  ?>%</td>
                            <td><?= $D30 ?>%</td>
                            <td><?= $E30  ?>%</td>
                            <td><?= $F30  ?>%</td>
                            <td><?= $G30  ?>%</td>
                            <td><?= $H30  ?>%</td>
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
                            <td><?= $C32  ?>%</td>
                            <td><?= $D32  ?>%</td>
                            <td><?= $E32  ?>%</td>
                            <td><?= $F32  ?>%</td>
                            <td><?= $G32  ?>%</td>
                            <td><?= $H32 ?>%</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Heifer</td>
                            <td><?= $C33  ?>%</td>
                            <td><?= $D33  ?>%</td>
                            <td><?= $E33  ?>%</td>
                            <td><?= $F33  ?>%</td>
                            <td><?= $G33  ?>%</td>
                            <td><?= $H33 ?>%</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Growing Calf (Above 1 Year)</td>
                            <td><?= $C34  ?>%</td>
                            <td><?= $D34  ?>%</td>
                            <td><?= $E34  ?>%</td>
                            <td><?= $F34  ?>%</td>
                            <td><?= $G34  ?>%</td>
                            <td><?= $H34 ?>%</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Calf</td>
                            <td><?= $C35  ?>%</td>
                            <td><?= $D35  ?>%</td>
                            <td><?= $E35  ?>%</td>
                            <td><?= $F35  ?>%</td>
                            <td><?= $G35  ?>%</td>
                            <td><?= $H35  ?>%</td>
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
                            <td><?= $C37  ?></td>
                            <td><?= $D37  ?></td>
                            <td><?= $E37 ?></td>
                            <td><?= $F37 ?></td>
                            <td><?= $G37  ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Growing Calf(Above 12 Month)</td>
                            <td><?= $C38  ?></td>
                            <td><?= $D38  ?></td>
                            <td><?= $E38  ?></td>
                            <td><?= $F38 ?></td>
                            <td><?= $G38  ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Heifer/Cow</td>
                            <td><?= $C39 ?></td>
                            <td><?= $D39  ?></td>
                            <td><?= $E39  ?></td>
                            <td><?= $F39  ?></td>
                            <td><?= $G39 ?></td>
                            <td></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Initial live stock</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Unitsat The Start</td>
                            <td><?= $C41 ?></td>
                            <td><?= $D41  ?></td>
                            <td><?= $E41  ?></td>
                            <td><?= $F41  ?></td>
                            <td><?= $G41  ?></td>
                            <td><?= $H41  ?></td>
                        </tr>
                        <tr>
                            <td>Total Heifer At The Start Of Year</td>
                            <td><?= $C42  ?></td>
                            <td><?= $D42  ?></td>
                            <td><?= $E42  ?></td>
                            <td><?= $F42  ?></td>
                            <td><?= $G42  ?></td>
                            <td><?= $H42  ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calf(Above 1 Year)</td>
                            <td><?= $C43  ?></td>
                            <td><?= $D43  ?></td>
                            <td><?= $E43 ?></td>
                            <td><?= $F43  ?></td>
                            <td><?= $G43  ?></td>
                            <td><?= $H43  ?></td>
                        </tr>
                        <tr>
                            <td>Total Female Young Calf Brought/Born Of Year</td>
                            <td><?= $C44  ?></td>
                            <td><?= $D44  ?></td>
                            <td><?= $E44  ?></td>
                            <td><?= $F44  ?></td>
                            <td><?= $G44  ?></td>
                            <td><?= $H44  ?></td>
                        </tr>
                        <tr>
                            <td>Initial Total Animal Units At Start (Including Calf Born)</td>
                            <td><?= $C45  ?></td>
                            <td><?= $D45  ?></td>
                            <td><?= $E45  ?></td>
                            <td><?= $F45  ?></td>
                            <td><?= $G45  ?></td>
                            <td><?= $H45 ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Mortality Detail</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Mortality(No)</td>
                            <td><?= $C48  ?></td>
                            <td><?= $D48  ?></td>
                            <td><?= $E48  ?></td>
                            <td><?= $F48  ?></td>
                            <td><?= $G48  ?></td>
                            <td><?= $H48  ?></td>
                        </tr>
                        <tr>
                            <td>Total Heifer Mortality(No)</td>
                            <td><?= $C49  ?></td>
                            <td><?= $D49  ?></td>
                            <td><?= $E49  ?></td>
                            <td><?= $F49  ?></td>
                            <td><?= $G49  ?></td>
                            <td><?= $H49  ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calf Mortality(No)</td>
                            <td><?= $C50  ?></td>
                            <td><?= $D50 ?></td>
                            <td><?= $E50  ?></td>
                            <td><?= $F50  ?></td>
                            <td><?= $G50  ?></td>
                            <td><?= $H50  ?></td>
                        </tr>
                        <tr>
                            <td>Total Young Calf Mortality(No)</td>
                            <td><?= $C51  ?></td>
                            <td><?= $D51  ?></td>
                            <td><?= $E51  ?></td>
                            <td><?= $F51  ?></td>
                            <td><?= $G51  ?></td>
                            <td><?= $H51  ?></td>
                        </tr>
                        <tr>
                            <td>Total Mortality(Adult Unit)</td>
                            <td><?= $C52 ?></td>
                            <td><?= $D52  ?></td>
                            <td><?= $E52  ?></td>
                            <td><?= $F52  ?></td>
                            <td><?= $G52 ?></td>
                            <td><?= $H52  ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Stock After Mortality</th>
                        </tr>
                        <tr>
                            <td>Total Lactating Cows Less Mortality</td>
                            <td><?= $C55  ?></td>
                            <td><?= $D55  ?></td>
                            <td><?= $E55  ?></td>
                            <td><?= $F55  ?></td>
                            <td><?= $G55 ?></td>
                            <td><?= $H55  ?></td>
                        </tr>
                        <tr>
                            <td>Total Lactating Heifers Less Mortality </td>
                            <td><?= $C56  ?></td>
                            <td><?= $D56  ?></td>
                            <td><?= $E56  ?></td>
                            <td><?= $F56 ?></td>
                            <td><?= $G56  ?></td>
                            <td><?= $H56  ?></td>
                        </tr>
                        <tr>
                            <td>Total Growing Calves(Above 1 Year) Mortality</td>
                            <td><?= $C57 ?></td>
                            <td><?= $D57  ?></td>
                            <td><?= $E57 ?></td>
                            <td><?= $F57  ?></td>
                            <td><?= $G57  ?></td>
                            <td><?= $H57  ?></td>
                        </tr>
                        <tr>
                            <td>Total Calves Less Mortality </td>
                            <td><?= $C58  ?></td>
                            <td><?= $D58  ?></td>
                            <td><?= $E58 ?></td>
                            <td><?= $F58  ?></td>
                            <td><?= $G58  ?></td>
                            <td><?= $H58  ?></td>
                        </tr>
                        <tr>
                            <td>Total Stock Less Mortality</td>
                            <td><?= $C59  ?></td>
                            <td><?= $D59  ?></td>
                            <td><?= $E59  ?></td>
                            <td><?= $F59  ?></td>
                            <td><?= $G59  ?></td>
                            <td><?= $H59  ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Stock Culled & Sold</th>
                        </tr>
                        <tr>
                            <td>Lactating Cow</td>
                            <td><?= $C62  ?></td>
                            <td><?= $D62  ?></td>
                            <td><?= $E62  ?></td>
                            <td><?= $F62 ?></td>
                            <td><?= $G62  ?></td>
                            <td><?= $H62  ?></td>
                        </tr>
                        <tr>
                            <td>Heifer</td>
                            <td><?= $C63  ?></td>
                            <td><?= $D63  ?></td>
                            <td><?= $E63  ?></td>
                            <td><?= $F63  ?></td>
                            <td><?= $G63  ?></td>
                            <td><?= $H63  ?></td>
                        </tr>
                        <tr>
                            <td>Growing Calves(Above 1 Year)</td>
                            <td><?= $C64  ?></td>
                            <td><?= $D64 ?></td>
                            <td><?= $E64 ?></td>
                            <td><?= $F64  ?></td>
                            <td><?= $G64  ?></td>
                            <td><?= $H64  ?></td>
                        </tr>
                        <tr>
                            <td>Calf</td>
                            <td><?= $C65  ?></td>
                            <td><?= $D65 ?></td>
                            <td><?= $E65  ?></td>
                            <td><?= $F65  ?></td>
                            <td><?= $G65  ?></td>
                            <td><?= $H65  ?></td>
                        </tr>
                        <tr>
                            <td>Total Unit Culled</td>
                            <td><?= $C66  ?></td>
                            <td><?= $D66  ?></td>
                            <td><?= $E66  ?></td>
                            <td><?= $F66  ?></td>
                            <td><?= $G66  ?></td>
                            <td><?= $H66  ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Final Stock At The End Of Year</th>
                        </tr>
                        <tr>
                            <td>Lactating Cow</td>
                            <td><?= $C69  ?></td>
                            <td><?= $D69  ?></td>
                            <td><?= $E69  ?></td>
                            <td><?= $F69  ?></td>
                            <td><?= $G69 ?></td>
                            <td><?= $H69  ?></td>
                        </tr>
                        <tr>
                            <td>Heifer </td>
                            <td><?= $C70  ?></td>
                            <td><?= $D70  ?></td>
                            <td><?= $E70  ?></td>
                            <td><?= $F70  ?></td>
                            <td><?= $G70  ?></td>
                            <td><?= $H70 ?></td>
                        </tr>
                        <tr>
                            <td>Growing Calf (Above 1 Year)</td>
                            <td><?= $C71 ?></td>
                            <td><?= $D71 ?></td>
                            <td><?= $E71  ?></td>
                            <td><?= $F71  ?></td>
                            <td><?= $G71  ?></td>
                            <td><?= $H71  ?></td>
                        </tr>
                        <tr>
                            <td>Calf</td>
                            <td><?= $C72 ?></td>
                            <td><?= $D72  ?></td>
                            <td><?= $E72  ?></td>
                            <td><?= $F72  ?></td>
                            <td><?= $G72 ?></td>
                            <td><?= $H72 ?></td>
                        </tr>
                        <tr>
                            <td>Total Animal Units At The End Of Year</td>
                            <td><?= $C73  ?></td>
                            <td><?= $D73  ?></td>
                            <td><?= $E73  ?></td>
                            <td><?= $F73  ?></td>
                            <td><?= $G73 ?></td>
                            <td><?= $H73  ?></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Gain In Animal Unit</th>
                        </tr>
                        <tr>
                            <td>Animal Unit At The End Of Year</td>
                            <td><?= $C76  ?></td>
                            <td><?= $D76  ?></td>
                            <td><?= $E76 ?></td>
                            <td><?= $F76  ?></td>
                            <td><?= $G76  ?></td>
                            <td><?= $H76  ?></td>
                        </tr>
                        <tr>
                            <td>Gain In Animal Unit </td>
                            <td><?= $C77  ?></td>
                            <td><?= $D77  ?></td>
                            <td><?= $E77  ?></td>
                            <td><?= $F77  ?></td>
                            <td><?= $G77  ?></td>
                            <td><?= $H77  ?></td>
                        </tr>
                        <tr>
                            <td>Value Of Gain Animal Unit</td>
                            <td><?= $C78  ?></td>
                            <td><?= $D78  ?></td>
                            <td><?= $E78  ?></td>
                            <td><?= $F78  ?></td>
                            <td><?= $G78  ?></td>
                            <td><?= $H78 ?></td>
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
                            <td><?= $C81  ?></td>
                            <td><?= $D81 ?></td>
                            <td><?= $E81  ?></td>
                            <td><?= $F81 ?></td>
                            <td><?= $G81  ?></td>
                            <td><?= $H81  ?></td>
                        </tr>
                        <tr>
                            <td>Expected Milk Yield/Lactation</td>
                            <td><?= $C82 ?></td>
                            <td><?= $D82 ?></td>
                            <td><?= $E82  ?></td>
                            <td><?= $F82  ?></td>
                            <td><?= $G82  ?></td>
                            <td><?= $H82  ?></td>
                        </tr>
                        <tr>
                            <td>Total Milk Production (lit)</td>
                            <td><?= $C83  ?></td>
                            <td><?= $D83  ?></td>
                            <td><?= $E83  ?></td>
                            <td><?= $F83 ?></td>
                            <td><?= $G83  ?></td>
                            <td><?= $H83 ?></td>
                        </tr>
                        <tr>
                            <td>Minus Milk For Feeding Calves (lit)(300Lt/Calf)</td>
                            <td><?= $C84  ?></td>
                            <td><?= $D84 ?></td>
                            <td><?= $E84  ?></td>
                            <td><?= $F84  ?></td>
                            <td><?= $G84  ?></td>
                            <td><?= $H84 ?></td>
                        </tr>
                        <tr>
                            <td>Milk Available For Sale (lit)</td>
                            <td><?= $C85 ?></td>
                            <td><?= $D85 ?></td>
                            <td><?= $E85  ?></td>
                            <td><?= $F85 ?></td>
                            <td><?= $G85  ?></td>
                            <td><?= $H85  ?></td>
                        </tr>
                        <tr>
                            <td>Daily Availability of Milk For Sale</td>
                            <td><?= $C86  ?></td>
                            <td><?= $D86  ?></td>
                            <td><?= $E86  ?></td>
                            <td><?= $F86  ?></td>
                            <td><?= $G86  ?></td>
                            <td><?= $H86 ?></td>
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
                            <td colspan="6"><?= $D89 ?></td>
                        </tr>
                        <tr>
                            <td>Estimated Cost/Cow (Rs)</td>
                            <td colspan="6"><?= $D90 ?></td>
                        </tr>
                        <tr>
                            <td>Estimated Housing + Equipments Cost (Rs),Detail Below At "L"</td>
                            <td colspan="6"><?= $D91 ?></td>
                        </tr>
                        <tr>
                            <td>Estimated Capital Investment /Cow Unit (Rs)</td>
                            <td colspan="6"><?= $D92 ?></td>
                        </tr>
                        <tr>
                            <td>Estimated Total Capital (Rs) Detail Given Below At L</td>
                            <td colspan="6"><?= $D92 ?></td>
                        </tr>
                        <tr>
                            <td>Rate Of Interest</td>
                            <td colspan="6"><?= $B94 ?></td>
                        </tr>
                        <tr>
                            <td>Margin Money (%)</td>
                            <td colspan="6"><?= $B95 ?></td>
                        </tr>
                        <tr>
                            <td>Owners Capital</td>
                            <td colspan="6"><?= $E96 ?></td>
                        </tr>
                        <tr>
                            <td>Loan (Rs)</td>
                            <td colspan="6"><?= $E97 ?></td>
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
                            <td>Annual Increase In Feed Cost, Milk Selling Prices & Wages %</td>
                            <td></td>
                            <td><?= $D99 ?></td>
                            <td><?= $E99 ?></td>
                            <td><?= $F99 ?></td>
                            <td><?= $G99  ?></td>
                            <td><?= $H99 ?></td>
                        </tr>
                        <tr>
                            <td>Milk Selling Price (Rs)/Lit. (av) :</td>
                            <td><?= $C100 ?></td>
                            <td><?= $D100 ?></td>
                            <td><?= $E100  ?></td>
                            <td><?= $F100 ?></td>
                            <td><?= $G100 ?></td>
                            <td><?= $H100 ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Green Fodder (Rs)/KG:</td>
                            <td><?= $C101 ?></td>
                            <td><?= $D101 ?></td>
                            <td><?= $E101 ?></td>
                            <td><?= $F101 ?></td>
                            <td><?= $G101  ?></td>
                            <td><?= $H101 ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Straw (Rs)/KG:</td>
                            <td><?= $C102 ?></td>
                            <td><?= $D102 ?></td>
                            <td><?= $E102  ?></td>
                            <td><?= $F102 ?></td>
                            <td><?= $G102 ?></td>
                            <td><?= $H102 ?></td>
                        </tr>
                        <tr>
                            <td>Purchase Price Of Concentrate (Rs)/KG:</td>
                            <td><?= $C103 ?></td>
                            <td><?= $D103 ?></td>
                            <td><?= $E103  ?></td>
                            <td><?= $F103 ?></td>
                            <td><?= $G103 ?></td>
                            <td><?= $H103 ?></td>
                        </tr>
                        <tr>
                            <td>Contractual Labor Wages /Cow Unit/Year</td>
                            <td><?= $C104 ?></td>
                            <td><?= $D104  ?></td>
                            <td><?= $E104 ?></td>
                            <td><?= $F104  ?></td>
                            <td><?= $G104 ?></td>
                            <td><?= $H104 ?></td>
                        </tr>
                        <tr>
                            <td>Number Of Manager/Supervisor Hired @1 per/100A.Unit</td>
                            <td><?= $C105 ?></td>
                            <td><?= $D105  ?></td>
                            <td><?= $E105  ?></td>
                            <td><?= $F105  ?></td>
                            <td><?= $G105  ?></td>
                            <td><?= $H105  ?></td>
                        </tr>
                        <tr>
                            <td>Supervisors Salary / Annum (10% Annual Increase) </td>
                            <td><?= $C106 ?></td>
                            <td><?= $D106 ?></td>
                            <td><?= $E106  ?></td>
                            <td><?= $F106  ?></td>
                            <td><?= $G106  ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Supervisors Salary / Annum </td>
                            <td><?= $C107 ?></td>
                            <td><?= $D107 ?></td>
                            <td><?= $E107  ?></td>
                            <td><?= $F107  ?></td>
                            <td><?= $G107  ?></td>
                            <td><?= $H107 ?></td>
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
                            <td><?= $C112 ?></td>
                            <td><?= $D112  ?></td>
                            <td><?= $E112  ?></td>
                            <td><?= $F112  ?></td>
                            <td><?= $G112  ?></td>
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
                            <td><?= $B113 ?></td>
                            <td><?= $C113 ?></td>
                            <td><?= $D113  ?></td>
                            <td><?= $E113  ?></td>
                            <td><?= $F113 ?></td>
                            <td><?= $G113  ?></td>
                        </tr>
                        <tr>
                            <td>Male Calf (Disposed Of Within 1-2 Months)</td>
                            <td><?= $B114 ?></td>
                            <td><?= $C114 ?></td>
                            <td><?= $D114  ?></td>
                            <td><?= $E114  ?></td>
                            <td><?= $F114 ?></td>
                            <td><?= $G114 ?></td>
                        </tr>
                        <tr>
                            <td>Insurance Claim Of Mortality </td>
                            <td><?= $B115 ?></td>
                            <td><?= $C115  ?></td>
                            <td><?= $D115 ?></td>
                            <td><?= $E115 ?></td>
                            <td><?= $F115 ?></td>
                            <td><?= $G115 ?></td>
                        </tr>
                        <tr>
                            <td>Cow Dung/Animal Unit</td>
                            <td><?= $B116 ?></td>
                            <td><?= $C116 ?></td>
                            <td><?= $D116  ?></td>
                            <td><?= $E116 ?></td>
                            <td><?= $F116   ?></td>
                            <td><?= $G116 ?></td>
                        </tr>
                        <tr>
                            <td>iii) Total Sales</td>
                            <td></td>
                            <td><?= $C117 ?></td>
                            <td><?= $D117 ?></td>
                            <td><?= $E117 ?></td>
                            <td><?= $F117   ?></td>
                            <td><?= $G117 ?></td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
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
                            <td><?= $B121 ?></td>
                            <td><?= $C121 ?></td>
                            <td><?= $D121  ?></td>
                            <td><?= $E121 ?></td>
                            <td><?= $F121  ?></td>
                            <td><?= $G121 ?></td>
                        </tr>
                        <tr>
                            <td>Straw @ 3Kg/Animal Unit</td>
                            <td><?= $B122  ?></td>
                            <td><?= $C122 ?></td>
                            <td><?= $D122  ?></td>
                            <td><?= $E122  ?></td>
                            <td><?= $F122  ?></td>
                            <td><?= $G122  ?></td>
                        </tr>
                        <tr>
                            <td>Concentrate For Milk Production @ 2.5Kg/Lit</td>
                            <td><?= $B123  ?></td>
                            <td><?= $C123  ?></td>
                            <td><?= $D123  ?></td>
                            <td><?= $E123  ?></td>
                            <td><?= $F123  ?></td>
                            <td><?= $G123  ?></td>
                        </tr>
                        <tr>
                            <td>Concentrate Maintenance @1.5Kg/Ani. Unit</td>
                            <td><?= $B124  ?></td>
                            <td><?= $C124  ?></td>
                            <td><?= $D124  ?></td>
                            <td><?= $E124 ?></td>
                            <td><?= $F124 ?></td>
                            <td><?= $G124 ?></td>
                        </tr>
                        <tr>
                            <td>Medicines & AI etc.</td>
                            <td><?= $B125 ?></td>
                            <td><?= $C125  ?></td>
                            <td><?= $D125 ?></td>
                            <td><?= $E125 ?></td>
                            <td><?= $F125 ?></td>
                            <td><?= $G125  ?></td>
                        </tr>
                        <tr>
                            <td>Rent/Leasing Cost For Land For Shed etc /A.Unit.</td>
                            <td><?= $B126 ?></td>
                            <td><?= $C126 ?></td>
                            <td><?= $D126  ?></td>
                            <td><?= $E126  ?></td>
                            <td><?= $F126  ?></td>
                            <td><?= $G126 ?></td>
                        </tr>
                        <tr>
                            <td>Contractual Labor Wages /Cow Unit/Year</td>
                            <td><?= $B127  ?></td>
                            <td><?= $C127  ?></td>
                            <td><?= $D127 ?></td>
                            <td><?= $E127  ?></td>
                            <td><?= $F127  ?></td>
                            <td><?= $G127 ?></td>
                        </tr>
                        <tr>
                            <td>Salary Of Supervisor/Annum </td>
                            <td></td>
                            <td><?= $C128  ?></td>
                            <td><?= $D128  ?></td>
                            <td><?= $E128 ?></td>
                            <td><?= $F128  ?></td>
                            <td><?= $G128 ?></td>
                        </tr>
                        <tr>
                            <td>Insurance Premium Cows Only</td>
                            <td><?= $B129  ?></td>
                            <td><?= $C129 ?></td>
                            <td><?= $D129  ?></td>
                            <td><?= $E129 ?></td>
                            <td><?= $F129 ?></td>
                            <td><?= $G129 ?></td>
                        </tr>
                        <tr>
                            <td>Electricity Charges@ 1200 /Animal Unit/Year</td>
                            <td><?= $B130 ?></td>
                            <td><?= $C130  ?></td>
                            <td><?= $D130  ?></td>
                            <td><?= $E130 ?></td>
                            <td><?= $F130  ?></td>
                            <td><?= $G130 ?></td>
                        </tr>
                        <tr>
                            <td>Other misc. charges@1200/animal unit</td>
                            <td><?= $B131 ?></td>
                            <td><?= $C131 ?></td>
                            <td><?= $D131  ?></td>
                            <td><?= $E131  ?></td>
                            <td><?= $F131 ?></td>
                            <td><?= $G131  ?></td>
                        </tr>
                        <tr>
                            <td>(a) Total operating cost </td>
                            <td><?= $B132 ?></td>
                            <td><?= $C132  ?></td>
                            <td><?= $D132  ?></td>
                            <td><?= $E132  ?></td>
                            <td><?= $F132  ?></td>
                            <td><?= $G132  ?></td>
                        </tr>
                        <tr>
                            <td>Operating Surplus (Total Sale - Operational Cost)</td>
                            <td></td>
                            <td><?= $C133  ?></td>
                            <td><?= $D133  ?></td>
                            <td><?= $E133 ?></td>
                            <td><?= $F133  ?></td>
                            <td><?= $G133  ?></td>
                        </tr>
                        <tr>
                            <td>(b) Dep. On Shed Machinery & Equipments</td>
                            <td><?= $B134  ?></td>
                            <td><?= $C134  ?></td>
                            <td><?= $D134 ?></td>
                            <td><?= $E134 ?></td>
                            <td><?= $F134  ?></td>
                            <td><?= $G134 ?></td>
                        </tr>
                        <tr>
                            <td>Total Exp. (a+b)</td>
                            <td></td>
                            <td><?= $C135 ?></td>
                            <td><?= $D135  ?></td>
                            <td><?= $E135  ?></td>
                            <td><?= $F135  ?></td>
                            <td><?= $G135 ?></td>
                        </tr>
                        <tr>
                            <td>F) Net Profit</td>
                            <td></td>
                            <td><?= $C136 ?></td>
                            <td><?= $D136  ?></td>
                            <td><?= $E136 ?></td>
                            <td><?= $F136 ?></td>
                            <td><?= $G136 ?></td>
                        </tr>
                        <tr>
                            <td>G) A)Return On Capital Invest.(%)</td>
                            <td></td>
                            <td><?= $C137 ?></td>
                            <td><?= $D137  ?></td>
                            <td><?= $E137  ?></td>
                            <td><?= $F137  ?></td>
                            <td><?= $G137  ?></td>
                        </tr>
                        <tr>
                            <td>G) B)Return On Capital Invest.( %)INCL ANI></td>
                            <td></td>
                            <td><?= $C138 ?></td>
                            <td><?= $D138  ?></td>
                            <td><?= $E138 ?></td>
                            <td><?= $F138  ?></td>
                            <td><?= $G138  ?></td>
                        </tr>
                        <tr>
                            <td>H) BC Ratio</td>
                            <td></td>
                            <td><?= $C139 ?></td>
                            <td><?= $D139 ?></td>
                            <td><?= $E139 ?></td>
                            <td><?= $F139  ?></td>
                            <td><?= $G139 ?></td>
                        </tr>
                        <tr>
                            <td>Ia) Cost Of Milk Production (Rs) With Animal Gain</td>
                            <td></td>
                            <td><?= $C140 ?></td>
                            <td><?= $D140 ?></td>
                            <td><?= $E140 ?></td>
                            <td><?= $F140 ?></td>
                            <td><?= $G140  ?></td>
                        </tr>
                        <tr>
                            <td>Ib) Cost Of Milk Production (Rs)</td>
                            <td></td>
                            <td><?= $C140  ?></td>
                            <td><?= $D140  ?></td>
                            <td><?= $E140  ?></td>
                            <td><?= $F140  ?></td>
                            <td><?= $G140 ?></td>
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
                            <th>Installment</th>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>1</td>
                            <td><?= $B144  ?></td>
                            <td><?= $C144 ?></td>
                            <td><?= $D144  ?></td>
                            <td><?= $E144 ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><?= $B145 ?></td>
                            <td><?= $C145  ?></td>
                            <td><?= $D145 ?></td>
                            <td><?= $E145 ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><?= $B146 ?></td>
                            <td><?= $C146 ?></td>
                            <td><?= $D146  ?></td>
                            <td><?= $E146 ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><?= $B147 ?></td>
                            <td><?= $C147  ?></td>
                            <td><?= $D147 ?></td>
                            <td><?= $E147 ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><?= $B148 ?></td>
                            <td><?= $C148 ?></td>
                            <td><?= $D148 ?></td>
                            <td><?= $E148  ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label>K) Cash Balance After Debt Service</label>
                            </td>
                        </tr>
                        <tr>
                            <th>Year</th>
                            <th>Open.Surplus</th>
                            <th>Payments</th>
                            <th>Cash balance</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>1</td>
                            <td><?= $B152 ?></td>
                            <td><?= $C152 ?></td>
                            <td><?= $D152 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><?= $B153 ?></td>
                            <td><?= $C153 ?></td>
                            <td><?= $D153 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><?= $B154 ?></td>
                            <td><?= $C154 ?></td>
                            <td><?= $D154 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><?= $B155 ?></td>
                            <td><?= $C155 ?></td>
                            <td><?= $D155 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><?= $B156  ?></td>
                            <td><?= $C156 ?></td>
                            <td><?= $D156 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="7" style="color:red">*Average no of full lactation = no of calving (No.cows X 12 months / inter-calving period in months )
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">K) Requirements Of Feed Fodder And Land Requirements For Fodder Cultivation</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Concentrate Required Annually (Ton)*</td>
                            <td><?= $B161 ?></td>
                            <td><?= $C161  ?></td>
                            <td><?= $D161 ?></td>
                            <td><?= $E161  ?></td>
                            <td><?= $F161 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Green Fodder Required Annually (Ton)</td>
                            <td><?= $B162 ?></td>
                            <td><?= $C162  ?></td>
                            <td><?= $D162 ?></td>
                            <td><?= $E162 ?></td>
                            <td><?= $F162 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Wheat Straw Required Annually (Tons)</td>
                            <td><?= $B163  ?></td>
                            <td><?= $C163 ?></td>
                            <td><?= $D163  ?></td>
                            <td><?= $E163  ?></td>
                            <td><?= $F163 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Average Concentrate(kg) /Animal Unit
                            </td>
                            <td><?= $B165 ?></td>
                            <td><?= $C165 ?></td>
                            <td><?= $D165 ?></td>
                            <td><?= $E165 ?></td>
                            <td><?= $F165 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Average Green Fodder(kg)/Animal/Unit
                            </td>
                            <td><?= $B166 ?></td>
                            <td><?= $C166 ?></td>
                            <td><?= $D166 ?></td>
                            <td><?= $E166 ?></td>
                            <td><?= $F166 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Average Straw(Kg) /Animal Unit
                            </td>
                            <td><?= $B167 ?></td>
                            <td><?= $C167 ?></td>
                            <td><?= $D167 ?></td>
                            <td><?= $E167 ?></td>
                            <td><?= $F167 ?></td>
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
                            <td>All Oil Cakes(Tons)</td>
                            <td><?= $B169 ?></td>
                            <td><?= $C169 ?></td>
                            <td><?= $D169 ?></td>
                            <td><?= $E169 ?></td>
                            <td><?= $F169 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Mustard Cake(3/4 Of All Cakes)Tons</td>
                            <td><?= $B170 ?></td>
                            <td><?= $C170 ?></td>
                            <td><?= $D170 ?></td>
                            <td><?= $E170 ?></td>
                            <td><?= $F170 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Mustard Cake For 3 Months(Tons)</td>
                            </td>
                            <td><?= $B171 ?></td>
                            <td><?= $C171 ?></td>
                            <td><?= $D171 ?></td>
                            <td><?= $E171 ?></td>
                            <td><?= $F171 ?></td>
                            <td></td>
                        </tr>
                        <td>Finance Required For Feeding</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        </tr>
                        <tr>
                            <td>Finance For Concentrate Required Annually (Rs)</td>
                            <td><?= $B174 ?></td>
                            <td><?= $C174 ?></td>
                            <td><?= $D174 ?></td>
                            <td><?= $E174 ?></td>
                            <td><?= $F174 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Finance For Green Fodder Required Annually(Rs)</td>
                            <td><?= $B175 ?></td>
                            <td><?= $C175 ?></td>
                            <td><?= $D175 ?></td>
                            <td><?= $E175 ?></td>
                            <td><?= $F175 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Finance For Wheat Straw Required Annually(Rs)</td>
                            </td>
                            <td><?= $B176 ?></td>
                            <td><?= $C176 ?></td>
                            <td><?= $D176 ?></td>
                            <td><?= $E176 ?></td>
                            <td><?= $F176 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            </td>
                            <td><?= $B178 ?></td>
                            <td><?= $C178 ?></td>
                            <td><?= $D178 ?></td>
                            <td><?= $E178 ?></td>
                            <td><?= $F178 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>% Of Total Operational Cost</td>
                            <td><?= $B179 ?></td>
                            <td><?= $C179 ?></td>
                            <td><?= $D179 ?></td>
                            <td><?= $E179 ?></td>
                            <td><?= $F179 ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label>Land Required For Fodder Growing(Acre)</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Land Productivity/Annum(qt) Considered
                            </td>
                            <td><?= $B181 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Accordingly Calculated Land Required For Fodder(Acres)</td>
                            <td><?= $B182 ?></td>
                            <td><?= $C182 ?></td>
                            <td><?= $D182 ?></td>
                            <td><?= $E182 ?></td>
                            <td><?= $F182 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>% Of Required Fodder Grown</td>
                            <td><?= $B183 ?></td>
                            <td><?= $C183 ?></td>
                            <td><?= $D183 ?></td>
                            <td><?= $E183 ?></td>
                            <td><?= $F183 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Accordingly Land Required For Fodder Growing(Acre)</td>
                            <td><?= $B184 ?></td>
                            <td><?= $C184 ?></td>
                            <td><?= $D184 ?></td>
                            <td><?= $E184 ?></td>
                            <td><?= $F184 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Fodder To Be Purchased (Ton)/Year</td>
                            <td><?= $B185 ?></td>
                            <td><?= $C185 ?></td>
                            <td><?= $D185 ?></td>
                            <td><?= $E185 ?></td>
                            <td><?= $F185 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Silage Feeding Of Purchased Fodder</td>
                            <td><?= $B186 ?></td>
                            <td><?= $C186 ?></td>
                            <td><?= $D186 ?></td>
                            <td><?= $E186 ?></td>
                            <td><?= $F186 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Green Fodder Replaced For Silage (Tons)</td>
                            <td><?= $B187 ?></td>
                            <td><?= $C187 ?></td>
                            <td><?= $D187 ?></td>
                            <td><?= $E187 ?></td>
                            <td><?= $F187 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Additional Fodder For Silage Making Loses (15%)</td>
                            <td><?= $B188 ?></td>
                            <td><?= $C188 ?></td>
                            <td><?= $D188 ?></td>
                            <td><?= $E188 ?></td>
                            <td><?= $F188 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Fodder To Be Purchased For Silage(Ton)/Year</td>
                            <td><?= $B189 ?></td>
                            <td><?= $C189 ?></td>
                            <td><?= $D189 ?></td>
                            <td><?= $E189 ?></td>
                            <td><?= $F189 ?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Fodder For Feeding (Purchased)(Ton)</td>
                            <td><?= $B190 ?></td>
                            <td><?= $C190 ?></td>
                            <td><?= $D190 ?></td>
                            <td><?= $E190 ?></td>
                            <td><?= $F190 ?></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">L) Project Cost Calculation</label>
                            </td>
                        </tr>
                        <tr>
                            <th>a)Sheds Area Calculations:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>Sheds Breadth Calculation</th>
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
                            <td>Feeding Manger(ft)</td>
                            <td><?= $E197 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Standing Place(ft) </td>
                            <td><?= $E198 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Feeding Tractor Trolley Space(ft)</td>
                            <td><?= $E199 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Backyard Breadth(ft)</td>
                            <td><?= $E200 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Height(ft)</td>
                            <td><?= $E201 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Height At Eves(ft)</td>
                            <td><?= $E202 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Open Space/Side(ft)</td>
                            <td><?= $E203 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Shed Breadth Excluding Open Space(ft) </td>
                            <td><?= $E204 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Shed Breadth Including Open Space(ft)
                            </td>
                            <td><?= $E205 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Length Calculation</th>
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
                            <td>Number Of Animals/Row</td>
                            <td><?= $E207 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Space Width/Animal (ft)</td>
                            <td><?= $E208 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>No Of Water Troughs/Side</td>
                            <td><?= $E209 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>T. Water Trough Length (@5ft)</td>
                            <td><?= $E210 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Space At Entry And End(ft)</td>
                            <td><?= $E211 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Length (ft)</td>
                            <td><?= $E212 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Area Of One Shed And Number Of Sheds And Their Cost Calculations:</th>
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
                            <td>Covered Area /Shed(sq.ft)
                            </td>
                            <td><?= $E214 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Area Open(sq.ft)</td>
                            <td><?= $E215 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Rate/Sq Ft Covered Area With Fittings</td>
                            <td><?= $E216 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Rate /Sq Feed Open Paved Area</td>
                            <td><?= $E217 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cost Covered Area(Rs)</td>
                            <td><?= $E218 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cost Open Area(Rs)</td>
                            <td><?= $E219 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Cost/Shed (Crore)</td>
                            <td><?= $E220 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td> Av.Total Number Of Animal Unit</td>
                            <td><?= $E221 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Number Of Sheds Required</th>
                            <th><?= $E222 ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>Total Cost Of Sheds And Paved Open Area(Crore Rs)</td>
                            <td><?= $E223 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cost Of Other Structures(Stores,Offices etc /Roads) @10%(Crore)</td>
                            <td><?= $E224 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Cost Of Structure And Roads</td>
                            <td><?= $E225 ?></td>
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
                            <td>Cost Of Machinery(Milking,Feeding,Cleaning etc)@20% Of Shed Cost</td>
                            <td><?= $E226 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cost Of Livestock(Crore)</td>
                            <td><?= $E227 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Other Costs(Consultancy,One Month Working Capital etc)</td>
                            <td><?= $E228 ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total Costs(Crore)</td>
                            <td><?= $E229 ?></td>
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