<div class="content-wrapper">
    <section class="content-header">
        <h1>
            View Farmer To Doctor Requests
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>dcadmin/Home"><i class="fa fa-dashboard"></i> Home</a></li>
            <!-- <li><a href="<?php echo base_url() ?>dcadmin/Doctor/View_doctor"><i class="fa fa-dashboard"></i> All Doctors</a></li> -->
            <li class="active"> View Farmer To Doctor Requests</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <!-- <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/doctor/add_doctor" role="button" style="margin-bottom:12px;"> Add Doctor</a> -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> View Farmer To Doctor Requests</h3>
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
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Farmer Name</th>
                                            <th>Farmer Number</th>
                                            <th>Doctor Name</th>
                                            <th>Doctor Number</th>
                                            <th>Reason</th>
                                            <th>Description</th>
                                            <th>Fees</th>
                                            <th>Images</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($request_data->result() as $data) {
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
                                                <td><?php echo $i ?> </td>
                                                <td><?php echo $farmer_data->name ?></td>
                                                <td><?php echo $farmer_data->phone ?></td>
                                                <td><?php echo $doctor_data->name ?></td>
                                                <td><?php echo $doctor_data->phone ?></td>
                                                <td><?php echo $data->reason ?></td>
                                                <td><?php echo $data->description ?></td>
                                                <td><?php echo $data->fees ?></td>
                                                <td>
                                                    <?php if ($data->image1 != "") {  ?>
                                                        <img style="border:solid #008000 1px;padding: 5px;" id="image1" height=50 width=80 src="<?php echo base_url() . $data->image ?>">
                                                    <?php }  ?>
                                                    <?php if ($data->image2 != "") {  ?>
                                                        <img style="border:solid #008000 1px;padding: 5px;" id="image2" height=50 width=80 src="<?php echo base_url() . $data->image2 ?>">
                                                    <?php }  ?>
                                                    <?php if ($data->image3 != "") {  ?>
                                                        <img style="border:solid #008000 1px;padding: 5px;" id="image3" height=50 width=80 src="<?php echo base_url() . $data->image3 ?>">
                                                    <?php }  ?>
                                                    <?php if ($data->image4 != "") {  ?>
                                                        <img style="border:solid #008000 1px;padding: 5px;" id="image4" height=50 width=80 src="<?php echo base_url() . $data->image4 ?>">
                                                    <?php }  ?>
                                                    <?php if ($data->image5 != "") {  ?>
                                                        <img style="border:solid #008000 1px;padding: 5px;" id="image5" height=50 width=80 src="<?php echo base_url() . $data->image5 ?>">
                                                    <?php }  ?>
                                                </td>
                                                <td><?php if ($data->status == 0) { ?>
                                                        <p class="label bg-yellow">Pending</p>
                                                    <?php } else { ?>
                                                        <p class="label bg-green">Completed</p>
                                                    <?php    }   ?>
                                                </td>
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
    $(document).ready(function() {
        $('#userTable').DataTable({
            responsive: true,
            // bSort: true
        });
        $(document.body).on('click', '.dCnf', function() {
            var i = $(this).attr("mydata");
            console.log(i);
            $("#btns" + i).hide();
            $("#cnfbox" + i).show();
        });
        $(document.body).on('click', '.cans', function() {
            var i = $(this).attr("mydatas");
            console.log(i);
            $("#btns" + i).show();
            $("#cnfbox" + i).hide();
        })
    });
</script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->