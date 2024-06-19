<div class="content-wrapper">
    <section class="content-header">
        <h1>
            View Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">View Manager</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/Manager/add_manager/" role="button" style="margin-bottom:12px;"> Add Manager</a>
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
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-users"></i> View Manager</h3>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="">
                                <table class="table table-bordered table-hover table-striped" id="userTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Aadhar</th>
                                            <th>Refer Code</th>
                                            <th>Images</th>
                                            <!-- <th> Total No.Installs </th> -->
                                            <th> Install details </th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($manager_data->result() as $data) { ?>
                                            <tr>
                                                <td><?php echo $i ?> </td>
                                                <td><?php echo $data->name ?></td>
                                                <td><?php echo $data->email ?></td>
                                                <td><?php echo $data->phone ?></td>
                                                <td><?php echo $data->address ?></td>
                                                <td><?php echo $data->aadhar ?></td>
                                                <td><?php echo $data->refer_code ?></td>


                                                <td>
                                                    <?php
                                                    if (!empty($data->images)) {
                                                        $images = unserialize($data->images);
                                                        if (is_array($images)) {
                                                            foreach ($images as $image) {
                                                                if (!empty($image)) {
                                                    ?>
                                                                    <img id="slide_img_path" height="50" width="100" src="<?php echo base_url() . $image; ?>" alt="Image">
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    Sorry, no image found.
                                                            <?php
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            Sorry, no image found.
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        Sorry, no image found.
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <?php

                                                $this->db->select('*');
                                                $this->db->from('tbl_farmers');
                                                $this->db->where('refer_code', $data->refer_code);
                                                $query = $this->db->get();

                                                // Count the results
                                                $count = $query->num_rows();
                                                $this->db->select('*');
                                                $this->db->from('tbl_vendor');
                                                $this->db->where('refer_code', $data->refer_code);
                                                $query = $this->db->get();

                                                // Count the results
                                                $count2 = $query->num_rows();
                                                $this->db->select('*');
                                                $this->db->from('tbl_doctor');
                                                $this->db->where('refer_code', $data->refer_code);
                                                $query = $this->db->get();

                                                // Count the results
                                                $count3 = $query->num_rows();


                                                ?>
                                            
                                                <td style="display: flex;">

                                                    <a style="text-align:center;" href="<?php echo base_url('dcadmin/manager/view_farmers/' . base64_encode($data->refer_code)) ?>"> Farmder Installs <br> <br> <span> <?php if ($count > 0) {

                                                                                                                                                                                                                        echo $count;
                                                                                                                                                                                                                    } else
                                                                                                                                                                                                                        echo 0;

                                                                                                                                                                                                                    ?>
                                                        </span></a>
                                                    <a style="margin-left: 10px
                                                ;text-align:center;" href="<?php echo base_url('dcadmin/manager/view_vendors/' . base64_encode($data->refer_code)) ?>">Vendor Installs <br> <br>
                                                        <span> <?php if ($count2 > 0) {

                                                                    echo $count2;
                                                                } else
                                                                    echo 0;

                                                                ?>
                                                        </span></a>
                                                    <a style="margin-left: 10px
                                                ;text-align:center;" href="<?php echo base_url('dcadmin/manager/view_doctors/' . base64_encode($data->refer_code)) ?>">Doctor Installs
                                                      <br> <br> <span> <?php if ($count3 > 0) {

                                                                    echo $count3;
                                                                } else
                                                                    echo 0;

                                                                ?>
                                                        </span></a>

                                                </td>

                                                <td><?php if ($data->is_active == 1) { ?>
                                                        <p class="label pull-right bg-green">Active</p>
                                                    <?php } else { ?>
                                                        <p class="label pull-right bg-yellow">Inactive</p>
                                                    <?php    }   ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group" id="btns<?php echo $i ?>">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                                                            <ul class="dropdown-menu" role="menu">
                                                                <?php if ($data->is_active == 1) { ?>
                                                                    <li><a href="<?php echo base_url() ?>dcadmin/manager/updatemanagerStatus/<?php echo base64_encode($data->id) ?>/inactive">Inactive</a></li>
                                                                <?php } else { ?>
                                                                    <li><a href="<?php echo base_url() ?>dcadmin/manager/updatemanagerStatus/<?php echo base64_encode($data->id) ?>/active">Active</a></li>
                                                                <?php    }   ?>
                                                                <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete User</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div style="display:none" id="cnfbox<?php echo $i ?>">
                                                        <p> Are you sure delete this </p>
                                                        <a href="<?php echo base_url() ?>dcadmin/manager/delete_manager/<?php echo base64_encode($data->id); ?>" class="btn btn-danger">Yes</a>
                                                        <a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>">No</a>
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