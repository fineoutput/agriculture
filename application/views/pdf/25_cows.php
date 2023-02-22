<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Example</title>
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
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>a) Owners Capital (Rs)</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>b) Loan Amount (Rs)</td>
                            <td>data</td>
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
                            <td>15</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Increase In Milk Production Over Previous Year in %</td>
                            <td></td>
                            <td>5</td>
                            <td>5</td>
                            <td>5</td>
                            <td>5</td>
                            <td>(5+5+5+5)/4</td>
                        </tr>
                        <tr>
                            <td>Conception Rate%</td>
                            <td>90%</td>
                            <td>90%</td>
                            <td>90%</td>
                            <td>90%</td>
                            <td>90%</td>
                            <td>(90+90+90+90+90)/5</td>
                        </tr>
                        <tr>
                            <td>Inter Calving Period Months</td>
                            <td>13</td>
                            <td>13</td>
                            <td>13</td>
                            <td>13</td>
                            <td>13</td>
                            <td>(13+13+13+13+13)/5</td>
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
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>(0.5+0.5+0.5+0.5+0.5)/5</td>
                        </tr>
                        <tr>
                            <td>Mortality Heifer%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>(0.5+0.5+0.5+0.5+0.5)/5</td>
                        </tr>
                        <tr>
                            <td>Mortality Growing Calf%(Above 1 Year)</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>0.5%</td>
                            <td>(0.5+0.5+0.5+0.5+0.5)/5</td>
                        </tr>
                        <tr>
                            <td>Mortality Young Calf%</td>
                            <td>5%</td>
                            <td>5%</td>
                            <td>5%</td>
                            <td>5%</td>
                            <td>5%</td>
                            <td>(5+5+5+5+5)/5</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Adult Cow</td>
                            <td>1%</td>
                            <td>1%</td>
                            <td>25%</td>
                            <td>25%</td>
                            <td>25%</td>
                            <td>(1+1+25+25+25)/5</td>
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
                            <td>Culling Rate Heifer</td>
                            <td>0%</td>
                            <td>2.5%</td>
                            <td>25%</td>
                            <td>30%</td>
                            <td>30%</td>
                            <td>(0+2.5+25+30+30)/5</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Growing Calf (Above 1 Year)</td>
                            <td>12%</td>
                            <td>12%</td>
                            <td>12%</td>
                            <td>12%</td>
                            <td>12%</td>
                            <td>(12+12+12+12+12)/5</td>
                        </tr>
                        <tr>
                            <td>Culling Rate Calf</td>
                            <td>2%</td>
                            <td>2%</td>
                            <td>2%</td>
                            <td>2%</td>
                            <td>2%</td>
                            <td>(2+2+2+2+2)/5</td>
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
                            <td>0.3</td>
                            <td>0.3</td>
                            <td>0.3</td>
                            <td>0.3</td>
                            <td>0.3</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Growing Calf(Above 12 Month)</td>
                            <td>0.5</td>
                            <td>0.5</td>
                            <td>0.5</td>
                            <td>0.5</td>
                            <td>0.5</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>One Heifer/Cow</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td></td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Initial Live Stock</th>
                        </tr>
                        <tr>
                            <td>Total lactating cows unitsat the start</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total heifer at the start of year</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total Growing calf(above 1Year)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total female young calf brought/born of year</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>initial Total animal units at start (including calf born)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">mortality detail</th>
                        </tr>
                        <tr>
                            <td>Total lactating cows mortality(No)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total heifer mortality(No)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total Growing calfmortality(No)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total young calf mortality(No)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total mortality(adult unit)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">stock after mortality</th>
                        </tr>
                        <tr>
                            <td>Total lactating cows less mortality</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total lactating heifers less mortality </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total growing calves(above 1 year) mortality</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Totalcalves less mortality </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>total stock less mortality</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">stock culled & Sold</th>
                        </tr>
                        <tr>
                            <td>lactating cow</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>heifer </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Growing calves(above1 year)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>calf</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total unit culled</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">final stock at the end of year</th>
                        </tr>
                        <tr>
                            <td>lactating cow</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>heifer </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Growing calf (above1 year)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>calf</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total animal units at the end of year</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <!------------------------------------------------------------------------->
                        <tr>
                            <th colspan="7">Gain in animal unit</th>
                        </tr>
                        <tr>
                            <td>animal unit at the end of year</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Gain in animal unit </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>value of gain animal unit</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                    </tbody>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">B) MILK PRODUCTION PROJECTIONS</label>
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
                            <td>Total number of expected lactations/year*</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Expected Milk yield/Lactation</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total milk production (lit)</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Minus milk for feeding calves (lit)(300Lt/calf)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Milk available for sale (lit)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Daily availability of milk for sale</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                    </tbody>
                    <!------------------------------------------------------------------------->
                    <tbody class="hide">
                        <tr>
                            <td colspan="7" class="C_label">
                                <label for="accounting">C) TECHNICAL PARAMETERS AND COST OF PURCHASED MATERIAL & SALE PRICES CONSIDERED:</label>
                            </td>
                        </tr>
                        <tr>
                            <td>Market price of cow considered on per liter average daily yield (Rs)</td>
                            <td colspan="6">3800</td>
                        </tr>
                        <tr>
                            <td>Estimated cost/cow (Rs)</td>
                            <td colspan="6">3800</td>
                        </tr>
                        <tr>
                            <td>Estimated Housing +Equipments cost (Rs),Detail below at "L"</td>
                            <td colspan="6">3800</td>
                        </tr>
                        <tr>
                            <td>Estimated capital Investment /cow unit (Rs)</td>
                            <td colspan="6">3800</td>
                        </tr>
                        <tr>
                            <td>Estimated total capital (Rs)Detai given belowAt L</td>
                            <td colspan="6">3800</td>
                        </tr>
                        <tr>
                            <td>Rate Of Interest</td>
                            <td colspan="6">3800</td>
                        </tr>
                        <tr>
                            <td>Margin money (%)</td>
                            <td colspan="6">3800</td>
                        </tr>
                        <tr>
                            <td>Owners Capital</td>
                            <td colspan="6">3800</td>
                        </tr>
                        <tr>
                            <td>Loan (Rs) =</td>
                            <td colspan="6">3800</td>
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
                            <td>Annual Increase in Feed Cost, Milk Selling prices & wages %</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Milk Selling Price (Rs)/Lit. (av) :</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Purchase price of Green Fodder (Rs)/KG:</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Purchase price of Straw (Rs)/KG:</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Purchase price of Concentrate (Rs)/KG:</td>
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
                            <td>Number of manager/supervisor hired@1 per/100A.unit</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Supervisors salary / annum (10% annual increase) </td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Total Supervisors salary / annum </td>
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
                                <label for="accounting">D) EXECTED SALE PROCEEDS</label>
                                <input type="checkbox" name="accounting" id="accounting" data-toggle="toggle">
                            </td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Unit Cost (Rs.)</th>
                            <th>Year-1</th>
                            <th>Year-2</th>
                            <th>Year-3</th>
                            <th>Year-4</th>
                            <th>Year-5</th>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>I) Milk sale(rs)</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>ii) Misc. Sales</td>
                            <td>data</td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Animal unit sold (culled) </td>
                            <td>data</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Male calf (disposed of within 1-2 months)</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                        </tr>
                        <tr>
                            <td>Insurance Claim of mortality </td>
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
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="7">
                                <label for="accounting">K)REQUIREMENTS OF FEED FODDER AND LAND REQUIREMENTS FOR FODDER CULTIVATION
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
                    </tbody>
                </table>
</body>

</html>
</body>

</html>