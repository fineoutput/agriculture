<div class="content-wrapper">
    <section class="content-header">
        <h1>
            DAILY RECORDS
        </h1>
        <ol class="breadcrumb">

            <li><a href="<?php echo base_url() ?>dcadmin/Farmers/viewrecords/<? echo $farmer_id; ?>"><i class="fa fa-dashboard"></i>View Page</a></li>

        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">



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
                    <div class="panel panel-default">
                        <div class="panel-body">


                            <form action="<?php echo base_url() ?>dcadmin/Farmers/view_dailyrecords/<?= $farmer_id; ?>" method="get" id="slide_frm" enctype="multipart/form-data">

                                <div style="display:flex;justify-content: space-between;">
                                    <div>
                                        <a class="btn btn-sm btn-primary" href="<?php echo base_url() ?>dcadmin/Farmers/view_dailyrecords/<? echo $farmer_id; ?>">Clear</a>

                                    </div>

                                    <div style="display:flex;">
                                        <div style="display:flex">

                                            <label>Start Date</label>
                                            <input type="date" name="start_date" class="form-control" placeholder="" required style="width:60%" value="<? if (!empty($_GET['start_date'])) {
                                                                                                                                                            echo $_GET['start_date'];
                                                                                                                                                        } ?>" />
                                        </div>
                                        <div style="display:flex">
                                            <label>End Date</label>
                                            <input type="date" name="end_date" class="form-control" placeholder="" required value="<? if (!empty($_GET['end_date'])) {
                                                                                                                                        echo $_GET['end_date'];
                                                                                                                                    } ?>" style="width:60%" />
                                        </div>
                                        <input type="submit" class="btn btn-success" value="save">
                                    </div>
                                </div>
                            </form>
                            <hr />

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

                                                <th>Entry Id</th>
                                                <th>Record Date</th>

                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?
                                            foreach ($data_daily_records->result() as $data) {

                                            ?>
                                                <tr>


                                                    <td><?php echo $data->entry_id; ?> </td>

                                                    <td><? if (!empty($data->entry_id)) {

                                                            $this->db->select('*');
                                                            $this->db->from('tbl_daily_records');
                                                            $this->db->where('entry_id', $data->entry_id);
                                                            $dsa_dr = $this->db->get()->row();
                                                            if (!empty($dsa_dr)) {
                                                                echo $dsa_dr->record_date;
                                                            }
                                                        } ?></td>


                                                    <td><? if (!empty($data->entry_id)) {

                                                            $this->db->select('*');
                                                            $this->db->from('tbl_daily_records');
                                                            $this->db->where('entry_id', $data->entry_id);
                                                            $dsa_dr = $this->db->get()->row();
                                                            if (!empty($dsa_dr)) {
                                                                echo $dsa_dr->date;
                                                            }
                                                        } ?></td>


                                                    <td>

                                                        <div class="btn-group">



                                                            <a class="btn btn-primary btn-sm" href="<?php echo base_url() ?>dcadmin/Farmers/view_detailsdr/<?php echo $farmer_id ?>/<?= $data->entry_id; ?>">View Details</a>


                                                        </div>



                                                    </td>



                                                </tr>
                                            <?
                                            }
                                            ?>

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