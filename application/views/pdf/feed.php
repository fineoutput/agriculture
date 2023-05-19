<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dairy Muneem Feed Calculation</title>
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
                    .two{
                        color: #20b9aa;
                    }

                    .label tr td label {
                        display: block;
                    }

                    [data-toggle="toggle"] {
                        display: none;
                    }
                    .info{
                        color:#20b9aa;
                    }
                    .success{
                        background-color: #198754;
                        color:white;
                    }
                    .success1{
                        color: #198754;
                    }
                    .primary{
                        background-color: #0d6efd;
                        color:white;
                    }
                    .primary1{
                        color:#0d6efd;
                    }
                </style>
                <table>
                    <thead>
                    </thead>
                    <!-- =========================================================================== -->
                    <tbody>
                        <tr>
                            <td colspan="3"  style="border-right:none">
                                <img src="<? echo base_url()?>/assets/logo2.png">
                                <h5>Agristar Animal Solution Private Limited</h5>
                                <h6>Dream City, Suratgarh, Ganganagar, Rajasthan, 335804</h6>
                            
                            </td>
                            <td  colspan="2" style="border-left:none">
                            <h6>Contact:</h6>
                                <p style="font-size:15px"> Call & Whatsapp- 7891029090</p>
                                <h6>Email:</h6>
                                <p style="font-size:15px">info@dairymuneem.com, dairymuneem@gmail.com</p>

                            </td> 
                        </tr>
                        <tr>
                            <td colspan="5" class="text-center"><h3><span class="two">F</span><span class="three">eed </span> <span class="two">C</span><span class="four">alculation</span></h3></td>
                        </tr>
                        <tr>
                          
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="5">Fresh</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>CP</td>
                            <td class="info"><?= $result['fresh']['CP'] ?></td>
                            <td>FAT</td>
                            <td class="info"><?= $result['fresh']['FAT'] ?></td>
                        </tr>
                        <tr>
                            <td>FIBER</td>
                            <td class="info"><?= $result['fresh']['FIBER'] ?></td>
                            <td>TDN</td>
                            <td class="info"><?= $result['fresh']['TDN'] ?></td>
                        </tr>
                        <tr>
                            <td>ENERGY</td>
                            <td class="info"><?= $result['fresh']['ENERGY'] ?></td>
                            <td>CA</td>
                            <td class="info"><?= $result['fresh']['CA'] ?></td>
                        </tr>
                        <tr>
                            <td>P</td>
                            <td class="info"><?= $result['fresh']['P'] ?></td>
                            <td>RUDP</td>
                            <td class="info"><?= $result['fresh']['RUDP'] ?></td>
                        </tr>
                        <tr>
                            <td>ADF</td>
                            <td class="info"><?= $result['fresh']['ADF'] ?></td>
                            <td>NDF</td>
                            <td class="info"><?= $result['fresh']['NDF'] ?></td>
                        </tr>
                        <tr>
                            <td>NEL</td>
                            <td class="info"><?= $result['fresh']['NEL'] ?></td>
                            <td>ENDF</td>
                            <td class="info"><?= $result['fresh']['ENDF'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="success">
                        <tr>
                            <td colspan="5">DMB</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>CP</td>
                            <td class="success1"><?= $result['dmb']['CP'] ?></td>
                            <td>FAT</td>
                            <td class="success1"><?= $result['dmb']['FAT'] ?></td>
                        </tr>
                        <tr>
                            <td>FIBER</td>
                            <td class="success1"><?= $result['dmb']['FIBER'] ?></td>
                            <td>TDN</td>
                            <td class="success1"><?= $result['dmb']['TDN'] ?></td>
                        </tr>
                        <tr>
                            <td>ENERGY</td>
                            <td class="success1"><?= $result['dmb']['ENERGY'] ?></td>
                            <td>CA</td>
                            <td class="success1"><?= $result['dmb']['CA'] ?></td>
                        </tr>
                        <tr>
                            <td>P</td>
                            <td class="success1"><?= $result['dmb']['P'] ?></td>
                            <td>RUDP</td>
                            <td class="success1"><?= $result['dmb']['RUDP'] ?></td>
                        </tr>
                        <tr>
                            <td>ADF</td>
                            <td class="success1"><?= $result['dmb']['ADF'] ?></td>
                            <td>NDF</td>
                            <td class="success1"><?= $result['dmb']['NDF'] ?></td>
                        </tr>
                        <tr>
                            <td>NEL</td>
                            <td class="success1"><?= $result['dmb']['NEL'] ?></td>
                            <td>ENDF</td>
                            <td class="success1"><?= $result['dmb']['ENDF'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="primary">
                        <tr>
                            <td colspan="5">Raw Cost</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>TON</td>
                            <td class="primary1"><?= $result['row_ton'] ?></td>
                            <td>Qtl</td>
                            <td class="primary1"><?= $result['row_qtl'] ?></td>
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