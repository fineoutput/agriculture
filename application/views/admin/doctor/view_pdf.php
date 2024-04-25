<!DOCTYPE html>
<html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- Css file include -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/frontend/css/style.css">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/rklogo.png" type="image/x-icon" />
    <title><?php echo SITE_NAME ?> | Admin <?php if (isset($headerTitle)) {
                                                echo "- " . $headerTitle;
                                            } ?></title>
</head>

<body style="padding-top:75px;">
    <div class="container main_container">
        <div class="row">
            <div class="col-sm-12 oswal_logo" style="text-align: center;">
                <img src="<?php echo base_url() ?>/assets/dairy-1.png" class="img-fluid" alt="Logo" width="160px" height="100px">
            </div>
        </div><br><br><br>
        <div class="container">
            <div class="row">
                <div class="col-sm-6"><span class="font-weight-bold ">Sold By</span><br>
                    <span class="seller_details">Agristar Animal Solution Private Limited <br>
                        Dream City, Suratgarh, Ganganagar, Rajasthan, 335804<br>India
                </div>
                <div class="col-sm-6" style="text-align: right;"><span class="font-weight-bold ">Email:</span><br>
                    <span class="seller_details">
                        info@dairymuneem.in <br>dairymuneem@gmail.com<br></span>
                </div>
            </div>
            <br><br><br>
            <div class="row">
                <div class="container">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>S no.</th>
                                <th>TItle</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;

                            $this->db->select('*');
                            $this->db->from('tbl_farmers');
                            $this->db->where('id', $data->farmer_id);
                            $farmer_data = $this->db->get()->row();
                            $this->db->select('*');
                            $this->db->from('tbl_doctor');
                            $this->db->where('id', $data->doctor_id);
                            $doctor_data = $this->db->get()->row();
                            ?>
                            <tr>
                                <td>1</td>
                                <td><b>Farmer Name</b></td>
                                <td><?php echo $farmer_data->name  ?></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><b>Farmer number</b></td>
                                <td><?php echo $farmer_data->phone  ?></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><b>Doctor Name</b></td>
                                <td><?php echo $doctor_data->name  ?></td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td><b>Doctor Number</b></td>
                                <td><?php echo $doctor_data->phone  ?></td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td><b>Reason</b></td>
                                <td><?php echo $data->reason  ?></td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td><b>Fees</b></td>
                                <td><?php echo $data->fees  ?></td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td><b>Description</b></td>
                                <td><?php echo $data->description  ?></td>
                            </tr>
                        </tbody>
                    </table><br><br>
                    <div class="images" style="text-align: center;">
                    <h5>Images</h5><br>
                        <?php if ($data->image1 != "") {  ?>
                            <a href="<?php echo base_url() . $data->image1 ?>" target="_blank" rel="noopener noreferrer"><img style="border:solid #008000 1px;padding: 5px;" id="image1" height=150 width=150 src="<?php echo base_url() . $data->image1 ?>"></a>
                        <?php }  ?>&nbsp;&nbsp;
                        <?php if ($data->image2 != "") {  ?>
                            <a href="<?php echo base_url() . $data->image2 ?>" target="_blank" rel="noopener noreferrer"><img style="border:solid #008000 1px;padding: 5px;" id="image2" height=150 width=150 src="<?php echo base_url() . $data->image2 ?>"></a>
                        <?php }  ?>&nbsp;&nbsp;
                        <?php if ($data->image3 != "") {  ?>
                            <a href="<?php echo base_url() . $data->image3 ?>" target="_blank" rel="noopener noreferrer"> <img style="border:solid #008000 1px;padding: 5px;" id="image3" height=150 width=150 src="<?php echo base_url() . $data->image3 ?>"></a>
                        <?php }  ?>&nbsp;&nbsp;
                        <?php if ($data->image4 != "") {  ?>
                            <a href="<?php echo base_url() . $data->image4 ?>" target="_blank" rel="noopener noreferrer"> <img style="border:solid #008000 1px;padding: 5px;" id="image4" height=150 width=150 src="<?php echo base_url() . $data->image4 ?>"></a>
                        <?php }  ?>&nbsp;&nbsp;
                        <?php if ($data->image5 != "") {  ?>
                            <a href="<?php echo base_url() . $data->image5 ?>" target="_blank" rel="noopener noreferrer"><img style="border:solid #008000 1px;padding: 5px;" id="image5" height=150 width=150 src="<?php echo base_url() . $data->image5 ?>"></a>
                        <?php }  ?>
                        </div><br><br><br><br>
                </div>
            </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    //alert('Changed!')
    $('#gst_percentage').keyup(function() {
        // alert("Key up detected");
        var total_price = $("#mrp").val();
        //var gst_percentage = $("#gst_percentage").val();$(this).val
        var gst_percentage = $(this).val();
        var gst_price = (total_price * gst_percentage) / 100;
        var total_gst_price = parseInt(total_price) + parseInt(gst_price);
        //alert(total_gst_price);
        $('#gst_percentage_price').val(gst_price);
        $('#selling_price').val(total_gst_price);
    });
</script>
<script>
    window.onload = function() {
        var unit_mrp = $(".unit_mrp").text();
        var unit_qty = $(".qty").text();
        //var gst_percentage = $("#gst_percentage").val();$(this).val
        var total_unit_mrp = parseInt(unit_mrp) * parseInt(unit_qty);
        //alert(total_gst_price);
        $('.net_unit_mrp').text(total_unit_mrp);
        var total_amount = document.getElementById("tot_amnt").value;
        // alert(total_amount);
        inWords(total_amount);
        window.print();
    };
    var a = ['', 'One ', 'Two ', 'Three ', 'Four ', 'Five ', 'Six ', 'Seven ', 'Eight ', 'Nine ', 'Ten ', 'Eleven ', 'Twelve ', 'Thirteen ', 'Fourteen ', 'Fifteen ', 'Sixteen ', 'Seventeen ', 'Eighteen ', 'Nineteen'];
    var b = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

    function inWords(num) {
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return;
        var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' + 'Only ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Lakh ' + 'Only ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' + 'Only ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' + 'Only ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'And ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'Only ' : '';
        //return str;
        // alert(str);
        $("#checks123").text(str);
    }
</script>

</html>