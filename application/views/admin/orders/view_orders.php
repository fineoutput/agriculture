<div class="content-wrapper">
  <section class="content-header">
    <h1>
      <?=$heading;?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/Home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li class="active">View <?=$heading;?></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <!-- <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/users/add_users" role="button" style="margin-bottom:12px;"> Add Users</a> -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View <?=$heading;?></h3>
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
                <table class="table table-bordered table-hover table-striped" id="printTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Order ID</th>
                      <th>User</th>
                      <th>Phone</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Pincode</th>
                      <th>Shipping Charge</th>
                      <th>Final Amount</th>
                      <th>Date</th>
                      <th>Orders Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=1; foreach($orders_data->result() as $data) { ?>
                    <tr>
                      <td><?php echo $i ?> </td>
                      <td><? if(!empty($data->id)){ echo $data->id;} else { echo "No Data"; }?></td>
                      <td><? if(!empty($data->name)){ echo $data->name;} else { echo "No Data"; }?></td>
                      <td><? if(!empty($data->phone)){ echo $data->phone;} else { echo "No Data"; }?></td>
                      <td><? if(!empty($data->email)){ echo $data->email;} else { echo "No Data"; }?></td>
                      <td><? if(!empty($data->address)){ echo $data->address;} else { echo "No Data"; }?></td>
                      <td><? if(!empty($data->pincode)){ echo $data->pincode;} else { echo "No Data"; }?></td>


                      <td><? if(!empty($data->delivery_charge)){ echo "₹".$data->delivery_charge;} else { echo "NA"; }?></td>
                      <td><? if(!empty($data->final_amount)){ echo "₹".$data->final_amount;} else { echo "No Data"; }?></td>
                      <td>
                        <?
    $newdate = new DateTime($data->date);
    echo $newdate->format('F j, Y, g:i a');   #d-m-Y  // March 10, 2001, 5:16 pm
    ?>
                      </td>

                      <td><?php if($data->order_status==1){ ?>
                        <p class="label bg-yellow">Pending</p>
                        <?php } elseif ($data->order_status==2){ ?>
                        <p class="label bg-aqua">Accepted</p>
                        <?php		}elseif ($data->order_status==3){ ?>
                        <p class="label bg-blue">Dispatched</p>
                        <?php		} elseif ($data->order_status==4){ ?>
                        <p class="label bg-green">Delivered</p>
                        <?}elseif ($data->order_status==5){ ?>
                        <p class="label bg-red">Rejected</p>
                        <?php		}elseif ($data->order_status==6){   ?>
                        <p class="label bg-red">Cancelled By User</p>
                        <?}?>
                      </td>
                      <td>
                        <div class="btn-group" id="btns<?php echo $i ?>">
                          <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">

                              <?php if($data->order_status==1){ ?>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/update_order_status/<?php echo base64_encode($data->id) ?>/accept">Accept</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/update_order_status/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_product_details/<?php echo base64_encode($data->id) ?>">View details</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_order_bill/<?php echo base64_encode($data->id) ?>">View Bill</a></li>
                              <?php } elseif($data->order_status==2) { ?>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/update_order_status/<?php echo base64_encode($data->id) ?>/dispatch">Dispatch</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_product_details/<?php echo base64_encode($data->id) ?>">View details</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_order_bill/<?php echo base64_encode($data->id) ?>">View Bill</a></li>
                              <?php		} elseif($data->order_status==3) { ?>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/update_order_status/<?php echo base64_encode($data->id) ?>/delivered">Delivered</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_product_details/<?php echo base64_encode($data->id) ?>">View details</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_order_bill/<?php echo base64_encode($data->id) ?>">View Bill</a></li>
                              <?php		}  elseif($data->order_status==4) { ?>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_product_details/<?php echo base64_encode($data->id) ?>">View details</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_order_bill/<?php echo base64_encode($data->id) ?>">View Bill</a></li>
                              <?php		}  elseif($data->order_status==5) { ?>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_product_details/<?php echo base64_encode($data->id) ?>">View details</a></li>
                              <li><a href="<?php echo base_url() ?>dcadmin/Orders/view_order_bill/<?php echo base64_encode($data->id) ?>">View Bill</a></li>
                              <?php		}   ?>

                            </ul>
                          </div>
                        </div>
              </div>
              </td>
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
  label {
    margin: 5px;
  }
</style>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>


<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

<script type="text/javascript">
  // buttons: [
  //     'copy', 'csv', 'excel', 'pdf', 'print'
  // ]
  $(document).ready(function() {
    $('#printTable').DataTable({
      responsive: true,
      "bStateSave": true,
      "fnStateSave": function (oSettings, oData) {
          localStorage.setItem('offersDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function (oSettings) {
          return JSON.parse(localStorage.getItem('offersDataTables'));
      },
      dom: 'Bfrtip',
      buttons: [{
          extend: 'copyHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10] //number of columns, excluding # column
          }
        },
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
          }
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
          }
        },
        {
          extend: 'pdfHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
          }
        },
        {
          extend: 'print',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/£js"></script>	  -->
