<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Category Images
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> All Categoryimages</a></li>
            <li class="active">View Category_images</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <!-- <a class="btn btn-info cticket" href="<?php //echo base_url() 
                                                            ?>dcadmin/Category_images/add_Categoryimages" role="button" style="margin-bottom:12px;"> Add Category images </a> -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">View Category images</h3>
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
                                            <th>Name</th>
                                            <th>Image</th>
                                           
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($Categoryimages_data->result() as $data) { ?>
                                            <tr>
                                                <td><?php echo $i ?> </td>
                                                <td><?php echo $data->name; ?> </td>
                                                <td>
                                                    <?php if ($data->image != "") {  ?>
                                                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image ?>">
                                                    <?php } else {  ?>
                                                        Sorry No image Found
                                                    <?php } ?>
                                                </td>
                                                
                                                <td>
                                                    <div class="btn-group" id="btns<?php echo $i ?>">
                                                        <div class="btn-group">
                                                            <a  class="btn btn-primary" href="<?php echo base_url() ?>dcadmin/Category_images/update_Categoryimages/<?php echo base64_encode($data->id) ?>">Edit</a>

                                                        </div>
                                                    </div>

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
        // $('#userTable').DataTable({
        // responsive: true,
        // // bSort: true
        // });
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