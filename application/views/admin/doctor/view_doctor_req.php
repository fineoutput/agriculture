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
                    <div class="panel-heading" style="display:flex;justify-content: space-between;">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> View Farmer To Doctor Requests</h3>
                        <h4>Total Admin Earning:
                            <?

                            echo "₹" . $count;
                            ?>
                        </h4>


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
                                            <th>Type</th>
                                            <th>Reason</th>
                                            <th>Description</th>
                                            <th>Fees</th>
                                            <th>Admin Earning </th>
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
                                                <td><?php echo $farmer_data ? $farmer_data->name : 'Farmer not found' ?></td>
                                                <td><?php echo $farmer_data ? $farmer_data->phone : 'Farmer not found' ?></td>
                                                <td><?php echo $doctor_data?$doctor_data->name:'Doctor not found' ?></td>
                                                <td><?php echo $doctor_data?$doctor_data->phone:'Doctor not found' ?></td>
                                                <td><?php if ($data->is_expert == 1) { ?>
                                                        <p class="label bg-green">Expert</p>
                                                    <?php } else { ?>
                                                        <p class="label bg-blue">Normal</p>
                                                    <?php    }   ?>
                                                </td>
                                                <td><?php echo $data->reason ?></td>
                                                <td><?php echo $data->description ?></td>
                                                <td><?php echo $data->fees ? '₹' . $data->fees : '₹0' ?></td>
                                                <td>
                                                    <?
                                                    $this->db->select('*');
                                                    $this->db->from('tbl_payment_txn');
                                                    $this->db->where('req_id', $data->id);
                                                    $this->db->where('doctor_id	', $data->doctor_id);
                                                    $dsa_ptx = $this->db->get()->row();
                                                    if (!empty($dsa_ptx->cr)) {
                                                        echo '₹' . ($data->fees - $dsa_ptx->cr);
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($data->image1 != "") {  ?>
                                                        <a href="<?php echo base_url() . $data->image1 ?>" target="_blank" rel="noopener noreferrer"><img style="border:solid #008000 1px;padding: 5px;" id="image1" height=50 width=80 src="<?php echo base_url() . $data->image1 ?>"></a>
                                                    <?php }  ?>
                                                    <?php if ($data->image2 != "") {  ?>
                                                        <a href="<?php echo base_url() . $data->image2 ?>" target="_blank" rel="noopener noreferrer"><img style="border:solid #008000 1px;padding: 5px;" id="image2" height=50 width=80 src="<?php echo base_url() . $data->image2 ?>"></a>
                                                    <?php }  ?>
                                                    <?php if ($data->image3 != "") {  ?>
                                                        <a href="<?php echo base_url() . $data->image3 ?>" target="_blank" rel="noopener noreferrer"> <img style="border:solid #008000 1px;padding: 5px;" id="image3" height=50 width=80 src="<?php echo base_url() . $data->image3 ?>"></a>
                                                    <?php }  ?>
                                                    <?php if ($data->image4 != "") {  ?>
                                                        <a href="<?php echo base_url() . $data->image4 ?>" target="_blank" rel="noopener noreferrer"> <img style="border:solid #008000 1px;padding: 5px;" id="image4" height=50 width=80 src="<?php echo base_url() . $data->image4 ?>"></a>
                                                    <?php }  ?>
                                                    <?php if ($data->image5 != "") {  ?>
                                                        <a href="<?php echo base_url() . $data->image5 ?>" target="_blank" rel="noopener noreferrer"><img style="border:solid #008000 1px;padding: 5px;" id="image5" height=50 width=80 src="<?php echo base_url() . $data->image5 ?>"></a>
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