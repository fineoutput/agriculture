<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dairy Muneem Dmi Calculator</title>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <table class="table table-bordered">
                <style>
                    table {
                        width: 750px;
                        border-collapse: collapse;
                        margin: 0px auto 50px auto;
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
                </style>
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
                                <p style="font-size:15px">info@dairymuneem.com, dairymuneem@gmail.com</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" class="text-center">
                                <h3><span class="two">D</span><span class="three">mi</span> <span class="two">C</span><span class="four">alculator</span></h3>
                            </td>
                        </tr>
                        <tr>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="5">
                                <label>Inputs</label>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Lactation Phase</td>
                            <td class="two"><?= $input['lactation'] ?></td>
                            <td>Feed In Percentage:</td>
                            <td class="two"><?= $input['feed_percentage'] ?></td>
                        </tr>
                        <tr>
                            <td>Milk Yield of Animal (Lts.)</td>
                            <td class="two"><?= $input['milk_yield'] ?></td>
                            <td>Body Wight of Animal (Kg.)</td>
                            <td class="two"><?= $input['weight'] ?></td>
                        </tr>
                    </tbody>
                    <!-- =========================================================================== -->
                    <tbody class="bg-primary text-white">
                        <tr>
                            <td colspan="2">Dry Matter Intake</td>
                            <td colspan="2"><?= $result['dry_matter_intake'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Feed(DM)</td>
                            <td class="text-primary"><?= $result['feed'] ?></td>
                            <td>Fodder(DM)</td>
                            <td class="text-primary"><?= $result['fodder'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="bg-info text-white">
                        <tr>
                            <td colspan="2">Feed(Qty)</td>
                            <td colspan="2"><?= $result['feed_qty'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="bg-success text-white">
                        <tr>
                            <td colspan="2">Green Fodder</td>
                            <td colspan="2"><?= $result['green_fodder'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Maize,Chari & Javi (Qty)</td>
                            <td class="text-success"><?= $result['maize'] ?></td>
                            <td>Barseem (Qty)</td>
                            <td class="text-success"><?= $result['barseem'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="bg-light">
                        <tr>
                            <td colspan="2">Dry Fodder</td>
                            <td colspan="2"><?= $result['dry_fodder'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td colspan="2">Hay & Thudi</td>
                            <td colspan="2"><?= $result['hary'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="bg-warning text-white">
                        <tr>
                            <td colspan="2">Silage (DM)</td>
                            <td colspan="2"><?= $result['silage_dm'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td colspan="2">Silage</td>
                            <td colspan="2"><?= $result['silage'] ?></td>
                        </tr>
                    </tbody>
            </table>
        </div>
    </div>
</body>
</html>