 <div class="content-wrapper">
     <section class="content-header">
         <h1>
             Farmer <?=$heading;  ?>
         </h1>
         <ol class="breadcrumb">
             <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
             <!-- <li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Team </a></li> -->
             <li class="active">View Farmer   <?=$heading;  ?></li>
         </ol>
     </section>
     <section class="content">
         <div class="row">
             <div class="col-lg-12">
                 <!-- <a class="btn btn-info cticket" href="<?php echo base_url() ?>admin/home/add_team" role="button" style="margin-bottom:12px;"> Add Team</a> -->
                 <div class="panel panel-default">
                     <div class="panel-heading">
                         <!-- <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View team</h3> -->
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
                                             <th>Pastorate Pregnant</th>
                                             <th>Expected Price</th>
                                             <th>Animal Type</th>
                                             <th>Description</th>
                                             <th>Remarks</th>
                                             <th>Image1</th>
                                             <th>Action</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php $i = 1;
                                            foreach ($sale_purchase->result() as $data) { ?>
                                             <tr>
                                                 <td><?php echo $i ?> </td>
                                                 <td><?php echo $data->information_type ?></td>
                                                 <td><?php echo $data->animal_name ?></td>
                                                 <td><?php echo $data->milk_production ?></td>
                                                 <td><?php echo $data->lactation ?></td>
                                                 <td><?php echo $data->location ?></td>
                                                 <td><?php echo $data->pastorate_pregnant ?></td>
                                                 <td><?php echo "₹" . $data->expected_price ?></td>
                                                 <td><?php echo  $data->animal_type ?></td>
                                                 <td><?php echo $data->description ?></td>
                                                 <td><?php echo $data->remarks ?></td>
                                                 <td>
                                                     <?php if ($data->image1 != "") {  ?>
                                                         <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image1 ?>">
                                                     <?php } else {  ?>
                                                         Sorry No image Found
                                                     <?php } ?>
                                                 </td>
                                                 <td>
                                                     <div class="btn-group" id="btns<?php echo $i ?>">
                                                         <div class="btn-group">
                                                             <?php if ($data->status <= 1) { ?>
                                                                 <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                                                                 <ul class="dropdown-menu" role="menu">

                                                                     <?php if ($data->status == 0) { ?>
                                                                         <li><a href="<?php echo base_url() ?>dcadmin/sale_purchase/updatesalepurchaseStatus/<?php echo base64_encode($data->id) ?>/accept">Accept</a></li>
                                                                         <li><a href="<?php echo base_url() ?>dcadmin/sale_purchase/updatesalepurchaseStatus/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li>
                                                                     <?php } else if ($data->status == 1) {  ?>
                                                                         <li><a href="<?php echo base_url() ?>dcadmin/sale_purchase/updatesalepurchaseStatus/<?php echo base64_encode($data->id) ?>/complete">Complete</a></li>
                                                                     <?php }   ?>
                                                                 </ul>
                                                             <?php } else {
                                                                    echo "NA";
                                                                }  ?>
                                                         </div>
                                                     </div>

                                                     <div style="display:none" id="cnfbox<?php echo $i ?>">
                                                         <p> Are you sure delete this </p>
                                                         <a href="<?php echo base_url() ?>admin/home/delete_team/<?php echo base64_encode($data->id); ?>" class="btn btn-danger">Yes</a>
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