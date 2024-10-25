<div class="content-wrapper">
    <section class="content-header">
        <h1>
            SALE/PURCHASE
        </h1>
        <ol class="breadcrumb">

            <li><a href="<?php echo base_url() ?>dcadmin/Farmers/viewrecords/<? echo $farmer_id; ?>"><i class="fa fa-dashboard"></i>View Page</a></li>

        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>
                            <?
                            $farmer_ids = base64_decode($farmer_id);

                            $this->db->select('*');
                            $this->db->from('tbl_farmers');
                            $this->db->where('id', $farmer_ids);
                            $dsa_farmer = $this->db->get()->row();
                            if (!empty($dsa_farmer)) {
                                echo $dsa_farmer->name;
                            }

                            ?>

                        </h3>
                    </div>
                    <div class="panel panel-default">

                        <? if (!empty($this->session->flashdata('smessage'))) { ?>
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                                <? echo $this->session->flashdata('smessage'); ?>
                            </div>
                        <? }
                        if (!empty($this->session->flashdata('emessage'))) { ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                <? echo $this->session->flashdata('emessage'); ?>
                            </div>
                        <? } ?>


                        <div class="panel-body">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-bordered table-hover table-striped" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Information Type</th>
                                            <th>Animal Name</th>
                                            <th>Milk Production</th>
                                            <th>Lactation</th>
                                            <th>Location</th>
                                            <th>Pastorate Pregnant </th>
                                            <th>Expected Price</th>
                                            <th>Animal Type</th>
                                            <th>Description</th>
                                            <th>Remarks</th>
                                            <th>Image1</th>
                                            <th>Image2</th>
                                            <th>Image3</th>
                                            <th>Image4</th>

                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($data_sale_purchase->result() as $data) { ?>
                                            <tr>
                                                <td><?php echo $i; ?> </td>
                                                <td><?php echo $data->information_type; ?> </td>


                                                <td><?php echo $data->animal_name; ?> </td>
                                                <td><?php echo $data->milk_production; ?> </td>
                                                <td><?php echo $data->lactation; ?> </td>
                                                <td><?php echo $data->location; ?> </td>
                                                <td><?php echo $data->pastorate_pregnant; ?> </td>
                                                <td><?php echo "₹" . $data->expected_price; ?> </td>
                                                <td><?php echo  $data->animal_type; ?> </td>
                                                <td><?php echo  $data->description; ?> </td>
                                                <td><?php echo  $data->remarks; ?> </td>
                                                <td>
                                                    <?php if ($data->image1 != "") {  ?>
                                                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image1 ?>">
                                                    <?php } else {  ?>
                                                        Sorry No image Found
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php if ($data->image2 != "") {  ?>
                                                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image2 ?>">
                                                    <?php } else {  ?>
                                                        Sorry No image Found
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($data->image3 != "") {  ?>
                                                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image3 ?>">
                                                    <?php } else {  ?>
                                                        Sorry No image Found
                                                    <?php } ?>
                                                </td>

                                                <td>
                                                    <?php if ($data->image4 != "") {  ?>
                                                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image4 ?>">
                                                    <?php } else {  ?>
                                                        Sorry No image Found
                                                    <?php } ?>
                                                </td>

                                                <td><?php echo $data->date; ?> </td>



                                            </tr>
                                        <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>






                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>


<style>
    label {
        margin: 5px;
    }
</style>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    $$(document).ready(function() {
        $$('#userTable').DataTable({
            responsive: true,
            // bSort: true
        });

        $$(document.body).on('click', '.dCnf', function() {
            var i = $$(this).attr("mydata");
            console.log(i);

            $$("#btns" + i).hide();
            $$("#cnfbox" + i).show();

        });

        $$(document.body).on('click', '.cans', function() {
            var i = $$(this).attr("mydatas");
            console.log(i);

            $$("#btns" + i).show();
            $$("#cnfbox" + i).hide();
        })

    });
</script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>-->