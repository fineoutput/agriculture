<div class="content-wrapper">
    <section class="content-header">
        <h1>
            STOCK LIST
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
                                            <th>Stock Date</th>
                                            <th>Animal Name</th>
                                            <th>Green Forage</th>
                                            <th>Dry Fodder</th>
                                            <th>Silage</th>
                                            <th>Cake </th>
                                            <th>Grains</th>
                                            <th>Bioproducts</th>
                                            <th>Churi</th>
                                            <th>Oil Seeds</th>
                                            <th>Minerals</th>
                                            <th>Bypass Fat</th>
                                            <th>Toxins</th>
                                            <th>Buffer</th>
                                            <th>Yeast</th>
                                            <th>Calcium</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($data_stock_handling->result() as $data) { ?>
                                            <tr>
                                                <td><?php echo $i; ?> </td>
                                                <td><?php echo $data->stock_date; ?> </td>
                                                <td><?php echo $data->green_forage; ?> </td>
                                                <td><?php echo $data->dry_fodder; ?> </td>
                                                <td><?php echo $data->silage; ?> </td>
                                                <td><?php echo $data->cake; ?> </td>
                                                <td><?php echo $data->grains; ?> </td>
                                                <td><?php echo $data->bioproducts; ?> </td>
                                                <td><?php echo $data->churi; ?> </td>
                                                <td><?php echo $data->oil_seeds; ?> </td>
                                                <td><?php echo $data->minerals; ?> </td>
                                                <td><?php echo $data->bypass_fat; ?> </td>
                                                <td><?php echo $data->toxins; ?> </td>
                                                <td><?php echo $data->buffer; ?> </td>
                                                <td><?php echo $data->yeast; ?> </td>
                                                <td><?php echo $data->calcium; ?> </td>
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