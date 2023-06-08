<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title ?> <?= $type ?> Payments Requests
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>dcadmin"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= $title ?> <?= $type ?> Payments Requests</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <!-- <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/payments/add_payments" role="button" style="margin-bottom:12px;"> Add Payments</a> -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= $title ?> <?= $type ?> Payments Requests</h3>
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
                                            <? if ($title == 'Vendor') { ?>
                                                <th>Vendor Name</th>
                                                <th>Vendor Number</th>
                                                <th>Vendor Bank Name</th>
                                                <th>Vendor Account No</th>
                                                <th>Vendor Ifsc</th>
                                                <th>Vendor Bank Phone</th>
                                            <? } else { ?>
                                                <th>Doctor Name</th>
                                                <th>Doctor Number</th>
                                                <th>Doctor Bank Name</th>
                                                <th>Doctor Account No</th>
                                                <th>Doctor Ifsc</th>
                                                <th>Doctor Bank Phone</th>
                                            <? } ?>
                                            <th>Available</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($Payments_data->result() as $data) {
                                            if ($title == 'Vendor') {
                                                $UData = $this->db->get_where('tbl_vendor', array('id' => $data->vendor_id))->result();
                                            } else {
                                                $UData = $this->db->get_where('tbl_doctor', array('id' => $data->doctor_id))->result();
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo $i ?> </td>
                                                <td><?php echo $UData[0]->name ?> </td>
                                                <td><?php echo $UData[0]->phone ?> </td>
                                                <td><?php echo $UData[0]->bank_name ?> </td>
                                                <td><?php echo $UData[0]->bank_ac ?> </td>
                                                <td><?php echo $UData[0]->ifsc ?> </td>
                                                <td><?php echo $UData[0]->bank_phone ?> </td>
                                                <td>₹<?php echo $data->available ?></td>
                                                <td>₹<?php echo $data->amount ?></td>
                                                <td><?php echo $data->date ?></td>
                                                <td>
                                                    <div class="btn-group" id="btns<?php echo $i ?>">
                                                        <div class="btn-group">
                                                            <?php if ($data->status == 0) { ?>
                                                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                                                                <ul class="dropdown-menu" role="menu">
                                                                    <li><a href="<?php echo base_url() ?>dcadmin/payments/updatePaymentsStatus/<?php echo base64_encode($data->id) ?>/accept">Accept</a></li>
                                                                    <li><a href="<?php echo base_url() ?>dcadmin/payments/updatePaymentsStatus/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li>
                                                                </ul>
                                                            <?php } else {
                                                                echo "NA";
                                                            } ?>
                                                        </div>
                                                    </div>
                                                    <div style="display:none" id="cnfbox<?php echo $i ?>">
                                                        <p> Are you sure delete this </p>
                                                        <a href="<?php echo base_url() ?>dcadmin/payments/delete_payments/<?php echo base64_encode($data->id); ?>" class="btn btn-danger">Yes</a>
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
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10] //number of columns, excluding # column
          }
        },
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10]
          }
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10]
          }
        },
        {
          extend: 'pdfHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10]
          }
        },
        {
          extend: 'print',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8,9,10]
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