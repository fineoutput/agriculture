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
    <div class="container-fluid p-5  text-center" style="width:440px;height:120px; color:blue;">
        <h1>Dairy Muneem </h1>
        <p>The Nutraion System For Dairy Cattle </p>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-4">
                <div class="col-sm-3 p-3  text-black text-center" style="width:1100px;height:80px;">
                    <h4>The Nutraion System For Dairy Cattle:Dairy Muneem</h4>
                    <p>A Model Of Energy and Nutrient Requirements and Diet Evaluation For Dairy Cattle</p>
                </div>
                <div class="col-sm-3 p-3  text-center text-black" style="width:1000px;height:10px;">
                    <p>1st Edittion-2019</p>
                </div>
                <div class="col-sm-3 p-3 text-center text-black" style="width:1000px;height:170px;">
                    <h5>Andore Soares De Oliveira,Phd</h5>
                    <p>Professor Animal science</p>
                    <p>Dairy Cattle Research Lab</p>
                    <p>Universidade Federal de Mato Grosso, Sinop, Brazil</p>
                </div>
                <div class="col-sm-3 p-3  text-center " style="width:1200px;height:100px;color:blue;">
                    <h2>Nutrients Requirements of Lactating Dairy Cows </h2>
                </div>
            </div>
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
                <table>
                    <thead>
                    </thead>
                    <tbody>
                        <!-- =========================================================================== -->
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
                            <td><?= $input['group'] ?></td>
                            <td>Body Weight Variation</td>
                            <td><?= $input['weight_variation'] ?></td>
                        </tr>
                        <tr>
                            <td>Feeding system</td>
                            <td><?= $input['feeding_system'] ?></td>
                            <td>BCS</td>
                            <td><?= $input['bcs'] ?></td>
                        </tr>
                        <tr>
                            <td>Body Weight (BW)</td>
                            <td><?= $input['weight'] ?></td>
                            <td>Days Of Gestation</td>
                            <td><?= $input['gestation_days'] ?></td>
                        </tr>
                        <tr>
                            <td>Milk Production</td>
                            <td><?= $input['milk_production'] ?></td>
                            <td>Air Temperature</td>
                            <td><?= $input['temp'] ?></td>
                        </tr>
                        <tr>
                            <td>Days In Milk</td>
                            <td><?= $input['days_milk'] ?></td>
                            <td>Air Humidity</td>
                            <td><?= $input['humidity'] ?></td>
                        </tr>
                        <tr>
                            <td>Milk Fat</td>
                            <td><?= $input['milk_fat'] ?></td>
                            <td>Temperature-Humidity Index (THI)</td>
                            <td><?= $input['thi'] ?></td>
                        </tr>
                        <tr>
                            <td>Milk Protein</td>
                            <td><?= $input['milk_protein'] ?></td>
                            <td>Fat 4% Corrected Milk</td>
                            <td><?= $input['fat_4'] ?></td>
                        </tr>
                        <tr>
                            <td>Milk Lactose</td>
                            <td><?= $input['milk_lactose'] ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <!-- =========================================================================== -->
                    <tbody class="labels">
                        <tr>
                            <td colspan="5">
                                <label>2.) Predicted Intake</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td  colspan="2">1.Dry intake(DMI):</td>
                            <td colspan="1"><?=$result['dmi_1']?> kg/cow/day</td>
                            <td colspan="1"><?=$result['dmi_2']?> % BW/day</td>
                        </tr>
                        <tr>
                            <td colspan="2">2.Drinking Water Intake:</td>
                            <td colspan="1"><?=$result['dwi_1']?> L/cow/day</td>
                            <td colspan="1"><?=$result['dwi_2']?> % BW/day</td>
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
                                <label for="management">3.1) Energy Requirements: </label>
                                <input type="checkbox" name="management" id="management" data-toggle="toggle">
                            </td>
                            <td colspan="2" style="background-color: #3498db;">
                                <label for="management">3.2)Protein And Amino Acids Requirements:</label>
                                <input type="checkbox" name="management" id="management" data-toggle="toggle">
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Total Net Energy (NE) intake:</td>
                            <td>35.09Mcal/cow/day</td>
                            <td>Crude protein (CP) intake:</td>
                            <td>3.00kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>NE diet: </td>
                            <td>2.52Mcal/kg DM diet</td>
                            <td>CP diet:</td>
                            <td>21.56% DM</td>
                        </tr>
                        <tr>
                            <td>Total Metabolizable Energy (ME) intake:</td>
                            <td>53.15Mcal/cow/day</td>
                            <td>Rumen degradable protein (RDP) intake:</td>
                            <td>1.91kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>ME diet:</td>
                            <td>3.81Mcal/kg DM diet</td>
                            <td>RDP diet:</td>
                            <td>13.67% DM</td>
                        </tr>
                        <tr>
                            <td>Total Digestible Energy (DE) intake:</td>
                            <td>59.59Mcal/cow/day</td>
                            <td>Rumen undegradable protein (RUP) intake:</td>
                            <td>1.10kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>DE diet:</td>
                            <td>4.27Mcal/kg DM diet</td>
                            <td>RUP diet:</td>
                            <td>7.88% DM</td>
                        </tr>
                        <tr>
                            <td>Total Digestible Energy (DE) intake:</td>
                            <td>13.51kg/cow/day</td>
                            <td>Metabolizable protein (MP) intake:</td>
                            <td>2.03kg/cow/day</td>
                        </tr>
                        <tr>
                            <td>TDN diet:</td>
                            <td>96.95% DM</td>
                            <td>MP diet:</td>
                            <td>14.54</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>MP from microbial rumen protein</td>
                            <td>59.33% MP</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Digestible Lysine diet:</td>
                            <td>6.8% MP</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Digestible Methionine Diet:</td>
                            <td>2.3% MP</td>
                        </tr>
                    <tbody class="labels">
                        <tr>
                            <td colspan="2" style="background-color: #3498db;">
                                <label for="management">3 Macro minerals requirements:</label>
                                <input type="checkbox" name="management" id="management" data-toggle="toggle">
                            </td>
                            <td colspan="2" style="background-color: #3498db;">
                                <label for="management">4 Trace minerals requirements:</label>
                                <input type="checkbox" name="management" id="management" data-toggle="toggle">
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Ca intake:</td>
                            <td>84g/cow/day</td>
                            <td>Zn intake:</td>
                            <td>663mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>Ca diet:</td>
                            <td>0.60% DM</td>
                            <td>Zn diet:</td>
                            <td>48mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>P intake:</td>
                            <td>54g/cow/day</td>
                            <td>Cu intake:</td>
                            <td>333mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>P diet:</td>
                            <td>0.39% DM</td>
                            <td>Cu diet</td>
                            <td>24mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>Na intake:</td>
                            <td>43g/cow/day</td>
                            <td>Fe intake</td>
                            <td>139mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>Na diet:</td>
                            <td>0.31% DM</td>
                            <td>Fe diet</td>
                            <td>10mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>K intake:</td>
                            <td>124g/cow/day</td>
                            <td>Mn intale</td>
                            <td>418mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>K diet:</td>
                            <td>0.89% DM</td>
                            <td>Mn diet</td>
                            <td>30mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>S intake:</td>
                            <td>28g/cow/day</td>
                            <td>Co intake</td>
                            <td>13.9mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>S diet:</td>
                            <td>0.20% DM</td>
                            <td>Co diet</td>
                            <td>1 mg/kg DM</td>
                        </tr>
                        <tr>
                            <td>Mg intake:</td>
                            <td>48.8g/cow/day</td>
                            <td>I intake</td>
                            <td> 10.8mg/cow/day</td>
                        </tr>
                        <tr>
                            <td>Mg diet:</td>
                            <td>0.35% DM</td>
                            <td>I diet</td>
                            <td>0.78mg/kg DM</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Se intake</td>
                            <td>4.2 mg/cow/day</td>
                        </tr>
                        <td></td>
                        <td></td>
                        <td>Se diet</td>
                        <td>0.30mg/kg DM</td>
                        </tr>
                        <td></td>
                        <td></td>
                        <td>Cr intake</td>
                        <td>7.0mg/cow/day</td>
                        </tr>
                    <tbody class="labels">
                        <tr>
                            <td colspan="2" style="background-color: #3498db;">
                                <label for="management">5. Vitamins recomendations:</label>
                                <input type="checkbox" name="management" id="management" data-toggle="toggle">
                            </td>
                            <td colspan="2" style="background-color: #3498db;">
                                <label for="management">6.Others recomendations:</label>
                                <input type="checkbox" name="management" id="management" data-toggle="toggle">
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Vitamin A diet</td>
                            <td>1,291IU/kg DM</td>
                            <td>peNDF diet:</td>
                            <td>≥21% DM</td>
                        </tr>
                        <tr>
                            <td>Vitamin D diet</td>
                            <td>323IU/kg DM</td>
                            <td>Fat acid diet:</td>
                            <td>≥6% DM</td>
                        </tr>
                        <tr>
                            <td>Vitamin E diet</td>
                            <td>22IU/kg DM</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <tbody class="labels">
                        <td colspan="6" style="background-color: #3498db;">
                            <label for="management">
                                7.Methane enteric emission:
                            </label>
                            <input type="checkbox" name="management" id="management" data-toggle="toggle">
                        </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Methane</td>
                            <td>340g/cow/day</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-sm-3 p-3  text-center text-black" style="width:100px;height:10px;">
                    <p>Citation:</p>
                    <div class="col-sm-3 p-3  text-center text-black" style="width:1100px;height:10px;">
                        <p>Oliveira, Andre Soares de (2019). The Nutrition System for Dairy Cows (NS-Dairy Cattle): A
                            Model of Energy and Nutrients Requirements and Diet Evaluation for Dairy Cattle. 1th
                            edition. Mendeley Data, V3. Sinop, MT. Updated: April 17, 2019. DOI: 10.17632/hvc7smjjb7.1
                            Avaliable <a href="http://dx.doi.org/10.17632/hvc7smjjb7.1">http://dx.doi.org/10.17632/hvc7smjjb7.1</a>
                        </p>
                    </div>
</body>
</html>
</body>
</html>