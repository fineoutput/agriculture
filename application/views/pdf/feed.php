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

                    .two {
                        color: #20b9aa;
                    }

                    .label tr td label {
                        display: block;
                    }

                    [data-toggle="toggle"] {
                        display: none;
                    }

                    .info {
                        color: #20b9aa;
                    }

                    .success {
                        background-color: #198754;
                        color: white;
                    }

                    .success1 {
                        color: #198754;
                    }

                    .primary {
                        background-color: #0d6efd;
                        color: white;
                    }

                    .primary1 {
                        color: #0d6efd;
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
                                <h3><span class="two">F</span><span class="three">eed </span> <span class="two">C</span><span class="four">alculation</span></h3>
                            </td>
                        </tr>
                        <tr>

                        </tr>
                    </tbody>
                    <tbody class="primary">
                        <tr>
                            <td colspan="2">Ingredient</td>
                            <td>Cost</td>
                            <td>Ratio</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <?
                        $ration = 0;
                        $prot = json_decode($result['ProteinData']);
                        foreach ($prot as $prt) {
                            if (!empty($prt[3])) { ?>
                                <tr>
                                    <td colspan="2"><?= $prt[1] ?></td>
                                    <td class="info"><?= $prt[2] ?></td>
                                    <td><?= $prt[3] ?></td>
                                </tr>
                        <?
                                $ration += $prt[3];
                            }
                        } ?>
                        <? $Energy = json_decode($result['EnergyData']);
                        foreach ($Energy as $enr) {
                            if (!empty($enr[3])) { ?>
                                <tr>
                                    <td colspan="2"><?= $enr[1] ?></td>
                                    <td class="info"><?= $enr[2] ?></td>
                                    <td><?= $enr[3] ?></td>
                                </tr>
                        <?
                                $ration += $enr[3];
                            }
                        } ?>
                        <? $Product = json_decode($result['ProductData']);
                        foreach ($Product as $pro) {
                            if (!empty($pro[3])) { ?>
                                <tr>
                                    <td colspan="2"><?= $pro[1] ?></td>
                                    <td class="info"><?= $pro[2] ?></td>
                                    <td><?= $pro[3] ?></td>
                                </tr>
                        <?
                                $ration += $pro[3];
                            }
                        } ?>
                        <? $Medicine = json_decode($result['MedicineData']);
                        foreach ($Medicine as $med) {
                            if (!empty($med[3])) { ?>
                                <tr>
                                    <td colspan="2"><?= $med[1] ?></td>
                                    <td class="info"><?= $med[2] ?></td>
                                    <td><?= $med[3] ?></td>
                                </tr>
                        <?
                                $ration += $med[3];
                            }
                        } ?>

                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td colspan="2"></td>
                            <td></td>
                            <td><?=$ration?></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <!-- <tr>
                            <td colspan="5">Fresh</td>
                        </tr> -->
                        <tr>
                            <td colspan="2">Value</td>
                            <td>Fresh</td>
                            <td>DMB</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td colspan="2">CP</td>
                            <td class="info"><?= $result['fresh']['CP'] ?></td>
                            <td class="success1"><?= $result['dmb']['CP'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">FAT</td>
                            <td class="info"><?= $result['fresh']['FAT'] ?></td>
                            <td class="success1"><?= $result['dmb']['FAT'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">FIBER</td>
                            <td class="info"><?= $result['fresh']['FIBER'] ?></td>
                            <td class="success1"><?= $result['dmb']['FIBER'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">TDN</td>
                            <td class="info"><?= $result['fresh']['TDN'] ?></td>
                            <td class="success1"><?= $result['dmb']['TDN'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">ENERGY</td>
                            <td class="info"><?= $result['fresh']['ENERGY'] ?></td>
                            <td class="success1"><?= $result['dmb']['ENERGY'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">CA</td>
                            <td class="info"><?= $result['fresh']['CA'] ?></td>
                            <td class="success1"><?= $result['dmb']['CA'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">P</td>
                            <td class="info"><?= $result['fresh']['P'] ?></td>
                            <td class="success1"><?= $result['dmb']['P'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">RUDP</td>
                            <td class="info"><?= $result['fresh']['RUDP'] ?></td>
                            <td class="success1"><?= $result['dmb']['RUDP'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">ADF</td>
                            <td class="info"><?= $result['fresh']['ADF'] ?></td>
                            <td class="success1"><?= $result['dmb']['ADF'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">NDF</td>
                            <td class="info"><?= $result['fresh']['NDF'] ?></td>
                            <td class="success1"><?= $result['dmb']['NDF'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">NEL</td>
                            <td class="info"><?= $result['fresh']['NEL'] ?></td>
                            <td class="success1"><?= $result['dmb']['NEL'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">ENDF</td>
                            <td class="info"><?= $result['fresh']['ENDF'] ?></td>
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