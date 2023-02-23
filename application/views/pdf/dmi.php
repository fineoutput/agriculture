<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dairy Muneem Dmi Calculation</title>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid p-5  text-center" style="width:440px;height:120px; color:blue;">
        <h1>Dairy Muneem </h1>
        <p>Dmi Calculation</p>
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
                    <tbody>
                        <!-- =========================================================================== -->
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
                            <td><?= $input['lactation'] ?></td>
                            <td>Feed In Percentage:</td>
                            <td><?= $input['feed_percentage'] ?></td>
                        </tr>
                        <tr>
                            <td>Milk Yield of Animal (Lts.)</td>
                            <td><?= $input['milk_yield'] ?></td>
                            <td>Body Wight of Animal (Kg.)</td>
                            <td><?= $input['weight'] ?></td>
                        </tr>
                    </tbody>
                    <!-- =========================================================================== -->
                    <tbody class="labels">
                        <tr>
                            <td colspan="2">Dry Matter Intake</td>
                            <td colspan="2"><?= $result['dry_matter_intake'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Feed(DM)</td>
                            <td><?= $result['feed'] ?></td>
                            <td>Fodder(DM)</td>
                            <td><?= $result['fodder'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="2">Feed(Qty)</td>
                            <td colspan="2"><?= $result['feed_qty'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
                        <tr>
                            <td colspan="2">Green Fodder</td>
                            <td colspan="2"><?= $result['green_fodder'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="hide">
                        <tr>
                            <td>Maize,Chari & Javi (Qty)</td>
                            <td><?= $result['maize'] ?></td>
                            <td>Barseem (Qty)</td>
                            <td><?= $result['barseem'] ?></td>
                        </tr>
                    </tbody>
                    <tbody class="labels">
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
                    <tbody class="labels">
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
</body>
</html>
</body>
</html>