
<div class="content-wrapper">
                                    <section class="content-header">
                                       <h1>
                                       BREEDING RECORDS
                                      </h1>
                                      <ol class="breadcrumb">
                                       <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
                                        <li><a href="<?php echo base_url() ?>dcadmin/Farmers/viewrecords/<?echo $farmer_id; ?>"><i class="fa fa-dashboard"></i>view Page</a></li>
                                        <li class="active">View BREEDING RECORDS</li>
                                      </ol>
                                    </section>
<section class="content">
<div class="row">
                                         <div class="col-lg-12">

                                                          <div class="panel panel-default">
                                                              <div class="panel-heading">
                                                                  <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View BREEDING RECORDS</h3>
                                                              </div>
                                                                 <div class="panel panel-default">

<? if(!empty($this->session->flashdata('smessage'))){ ?>
<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-check"></i> Alert!</h4>
<? echo $this->session->flashdata('smessage'); ?>
</div>
<? }
if(!empty($this->session->flashdata('emessage'))){ ?>
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
                                                                              <th>Group</th>
                                                                              <th>Cattle Type</th>
                                                                              <th>Tag No</th>
                                                                              <th>Update BullSemen</th>
                                                                              <th>Semen BullId</th>
                                                                              <th>Breeding Date</th>
                                                                              <th>Weight</th>
                                                                              <th>Date Of Ai</th>
                                                                              <th>Farm Bull</th>
                                                                              <th>Bull Tag No</th>
                                                                              <th>Bull Name</th>
                                                                              <th>Expenses</th>
                                                                              <th>Vet Name</th>
                                                                              <th>Other5</th>
                                                                              <th>Is Pregnant</th>
                                                                              <th>Pregnancy Test Date</th>
                                                                              <th>Date</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
<?php $i=1; foreach($data_breeding_record->result() as $data) { ?>
                                                    <tr>
                                                    <td><?php echo $i; ?> </td>
                                                        <td><?php $group_id= $data->group_id; 
                                                        $this->db->select('*');
                                                        $this->db->from('tbl_group');
                                                        $this->db->where('id',$group_id);
                                                        $dsa_group= $this->db->get()->row();
                                                        if(!empty($dsa_group)){
                                                            echo $dsa_group->name;
                                                        }
                                                        
                                                        
                                                        ?></td>
                                                        <td><?php echo $data->cattle_type; ?> </td>
                                                        <td><?php echo $data->tag_no; ?> </td>
                                                        <td><?php echo $data->update_bull_semen; ?> </td>
                                                        <td><?php echo $data->semen_bull_id; ?> </td>
                                                        <td><?php echo $data->breeding_date; ?> </td>
                                                        <td><?php echo $data->weight; ?> </td>
                                                        <td><?php echo $data->date_of_ai; ?> </td>
                                                        <td><?php echo $data->farm_bull; ?> </td>
                                                        <td><?php echo $data->bull_tag_no; ?> </td>
                                                        <td><?php echo $data->bull_name; ?> </td>
                                                        <td><?php echo "₹".$data->expenses; ?> </td>
                                                        <td><?php echo $data->vet_name; ?> </td>
                                                        <td><?php echo $data->is_pregnant; ?> </td>
                                                        <td><?php echo $data->pregnancy_test_date; ?> </td>
                                                        <td><?php echo $data->date; ?> </td>
                                                        
                                                         
                                               
                                            </tr>
<?php $i++; } ?>
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
                                  label{
margin:5px;
                                  }
                                  </style>
                                  <script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
                                  <script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
                                  <script type="text/javascript">

                                   $$(document).ready(function(){
                                  $$('#userTable').DataTable({
                                           responsive: true,
                                           // bSort: true
                                   });

                                  $$(document.body).on('click', '.dCnf', function() {
                                   var i=$$(this).attr("mydata");
                                   console.log(i);

                                   $$("#btns"+i).hide();
                                   $$("#cnfbox"+i).show();

                                  });

                                   $$(document.body).on('click', '.cans', function() {
                                   var i=$$(this).attr("mydatas");
                                   console.log(i);

                                   $$("#btns"+i).show();
                                   $$("#cnfbox"+i).hide();
                                  })

                                   });

                                   </script>
                                  <!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>-->