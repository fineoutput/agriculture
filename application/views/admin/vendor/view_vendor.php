  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        All <?= $heading ?> Vendors
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dcadmin/Home"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="<?php echo base_url() ?>dcadmin/Vendor/View_vendor"><i class="fa fa-dashboard"></i> All Vendor </a></li> -->
        <li class="active">View <?= $heading ?> Vendors</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/vendor/add_vendor" role="button" style="margin-bottom:12px;"> Add Vendor</a> -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-users"></i> View <?= $heading ?> Vendor</h3>
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
                  <table class="table table-bordered table-hover table-striped" id="dataTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Shop Name</th>
                        <th>Address</th>
                        <th>State</th>
                        <th>City</th>
                        <th>District</th>
                        <th>Pin Code</th>
                        <th>Commission(%)</th>
                        <th>GST No</th>
                        <th>Aadhar No</th>
                        <th>Image</th>
                        <th>Phone</th>
                        <th>PAN Number</th>
                        <th>Email</th>
                        <th>Account</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1;
                      foreach ($vendor_data->result() as $data) { ?>
                        <tr>
                          <td><?php echo $i ?> </td>
                          <td><?php echo $data->name ?></td>
                          <td><?php echo $data->shop_name ?></td>
                          <td><?php echo $data->address ?></td>
                          <td><?php $st = $data->state;
                              $this->db->select('*');
                              $this->db->from('all_states');
                              $this->db->where('id', $st);
                              $dsa = $this->db->get();
                              $da = $dsa->row();
                              if (!empty($da)) {
                                echo $da->state_name;
                              }
                              // echo $st;
                              ?></td>
                          <td><?php echo $data->district ?></td>
                          <td><?php $ct = $data->city;
                              // $this->db->select('*');
                              // $this->db->from('all_cities');
                              // $this->db->where('id', $ct);
                              // $dsa = $this->db->get();
                              // $da = $dsa->row();
                              // if (!empty($da)) {
                              //   echo $da->city_name;
                              // }
                              echo $ct;
                              ?></td>
                          <td><?php echo $data->pincode ?></td>
                          <td><?php if ($data->comission) {
                                echo $data->comission . "%";
                              } ?></td>
                          <td><?php echo $data->gst_no ?></td>
                          <td><?php echo $data->aadhar_no ?></td>
                          <td>
                            <?php if ($data->image != "") {  ?>
                              <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image ?>">
                            <?php } else {  ?>
                              Sorry No image Found
                            <?php } ?>
                          </td>
                          <td><?php echo $data->phone ?></td>
                          <td><?php echo $data->pan_number ?></td>
                          <td><?php echo $data->email ?></td>
                          <td><?php echo $data->account ? '₹'.$data->account : '₹0'?></td>
                          <td><?php if ($data->is_active == 1) { ?>
                              <p class="label bg-green">Unblocked</p>
                            <?php } else { ?>
                              <p class="label bg-yellow">Blocked</p>
                            <?php    }   ?>
                          </td>
                          <td>
                            <? if ($data->is_approved != 2) { ?>
                              <div class="btn-group" id="btns<?php echo $i ?>">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                                  <ul class="dropdown-menu" role="menu">
                                    <? if ($data->is_approved == 0) { ?>
                                      <li><a href="<?php echo base_url() ?>dcadmin/Vendor/updateVendorStatus/<?php echo base64_encode($data->id) ?>/approve">Approve</a></li>
                                      <li><a href="<?php echo base_url() ?>dcadmin/Vendor/updateVendorStatus/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li>
                                    <? } else if ($data->is_approved == 1) { ?>
                                      <?php if ($data->is_active == 1) { ?>
                                        <li><a href="<?php echo base_url() ?>dcadmin/Vendor/updateVendorStatus/<?php echo base64_encode($data->id) ?>/inactive">Blocked</a></li>
                                      <?php } else { ?>
                                        <li><a href="<?php echo base_url() ?>dcadmin/Vendor/updatevendorStatus/<?php echo base64_encode($data->id) ?>/active">Unblocked</a></li>
                                      <?php    }   ?>
                                      <li><a href="<?php echo base_url() ?>dcadmin/Vendor/set_comission_vendor/<?php echo base64_encode($data->id) ?>">Update Commission(%)</a></li>
                                      <li><a href="<?php echo base_url() ?>dcadmin/Payments/vendor_txn/<?php echo base64_encode($data->id) ?>">Payment Transactions</a></li>
                                      <li><a href="<?php echo base_url() ?>dcadmin/vendor/update_Vendor/<?php echo base64_encode($data->id) ?>">Edit</a></li>
                                      <!-- <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li> -->
                                    <? } else {
                                      echo "NA";
                                    } ?>
                                  </ul>
                                </div>
                              </div>
                            <? } else {
                              echo "NA";
                            } ?>
                            <div style="display:none" id="cnfbox<?php echo $i ?>">
                              <p> Are you sure delete this </p>
                              <a href="<?php echo base_url() ?>dcadmin/Vendor/delete_vendor/<?php echo base64_encode($data->id); ?>" class="btn btn-danger">Yes</a>
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
  <!-- //===========================order excel====================================\\ -->
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<!-- <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
  // buttons: [
  //     'copy', 'csv', 'excel', 'pdf', 'print'
  // ]
  $(document).ready(function() {
    $('#dataTable').DataTable({
      responsive: true,
      "bStateSave": true,
      "fnStateSave": function(oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function(oSettings) {
        return JSON.parse(localStorage.getItem('offersDataTables'));
      },
      dom: 'Bfrtip',
      buttons: [{
          extend: 'copyHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16] //number of columns, excluding # column
          }
        },
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16]
          }
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16]
          }
        },
        {
          extend: 'pdfHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16]
          }
        },
        {
          extend: 'print',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10,11,12,13,14,15,16]
          }
        },
      ]
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