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
    <div class="container-fluid p-5  text-center" style="width:440px;height:120px; color:blue;">
        <h1>Dairy Muneem </h1>
        <p>Feed Calculation</p>
    </div>
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
                    <!-- =========================================================================== -->
                    <tbody class="labels">
                        <tr>
                            <td colspan="5">Fresh</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>CP</td>
                            <td><?= $result['fresh']['CP'] ?></td>
                            <td>FAT</td>
                            <td><?= $result['fresh']['FAT'] ?></td>
                        </tr>
                        <tr>
                            <td>FIBER</td>
                            <td><?= $result['fresh']['FIBER'] ?></td>
                            <td>TDN</td>
                            <td><?= $result['fresh']['TDN'] ?></td>
                        </tr>
                        <tr>
                            <td>ENERGY</td>
                            <td><?= $result['fresh']['ENERGY'] ?></td>
                            <td>CA</td>
                            <td><?= $result['fresh']['CA'] ?></td>
                        </tr>
                        <tr>
                            <td>P</td>
                            <td><?= $result['fresh']['P'] ?></td>
                            <td>RUDP</td>
                            <td><?= $result['fresh']['RUDP'] ?></td>
                        </tr>
                        <tr>
                            <td>ADF</td>
                            <td><?= $result['fresh']['ADF'] ?></td>
                            <td>NDF</td>
                            <td><?= $result['fresh']['NDF'] ?></td>
                        </tr>
                        <tr>
                            <td>NEL</td>
                            <td><?= $result['fresh']['NEL'] ?></td>
                            <td>ENDF</td>
                            <td><?= $result['fresh']['ENDF'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="5">DMB</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>CP</td>
                            <td><?= $result['dmb']['CP'] ?></td>
                            <td>FAT</td>
                            <td><?= $result['dmb']['FAT'] ?></td>
                        </tr>
                        <tr>
                            <td>FIBER</td>
                            <td><?= $result['dmb']['FIBER'] ?></td>
                            <td>TDN</td>
                            <td><?= $result['dmb']['TDN'] ?></td>
                        </tr>
                        <tr>
                            <td>ENERGY</td>
                            <td><?= $result['dmb']['ENERGY'] ?></td>
                            <td>CA</td>
                            <td><?= $result['dmb']['CA'] ?></td>
                        </tr>
                        <tr>
                            <td>P</td>
                            <td><?= $result['dmb']['P'] ?></td>
                            <td>RUDP</td>
                            <td><?= $result['dmb']['RUDP'] ?></td>
                        </tr>
                        <tr>
                            <td>ADF</td>
                            <td><?= $result['dmb']['ADF'] ?></td>
                            <td>NDF</td>
                            <td><?= $result['dmb']['NDF'] ?></td>
                        </tr>
                        <tr>
                            <td>NEL</td>
                            <td><?= $result['dmb']['NEL'] ?></td>
                            <td>ENDF</td>
                            <td><?= $result['dmb']['ENDF'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="5">Raw Cost</td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>TON</td>
                            <td><?= $result['row_ton'] ?></td>
                            <td>Qtl</td>
                            <td><?= $result['row_qtl'] ?></td>
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