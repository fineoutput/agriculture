<div class="content-wrapper">
<section class="content-header">
<h1>
<?=$heading?> Order
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>dcadmin/Home"><i class="fa fa-dashboard"></i> Dashboard</a></li>


<li class="active"></li>

</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">
<!-- <a class="btn custom_btn" href="<?php echo base_url() ?>dcadmin/order/Add_order" role="button" style="margin-bottom:12px;"></a> -->
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i><?=$heading?> Orders</h3>
</div>
<div class="panel panel-default">

<?php if (!empty($this->session->flashdata('smessage'))) { ?>
<div class="alert alert-success alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-check"></i> Alert!</h4>
<?php echo $this->session->flashdata('smessage'); ?>
</div>
<?php }
                          if (!empty($this->session->flashdata('emessage'))) { ?>
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-ban"></i> Alert!</h4>
<?php echo $this->session->flashdata('emessage'); ?>
</div>
<?php } ?>


<div class="panel-body">
<div class="box-body table-responsive no-padding">
<table class="table table-bordered table-hover table-striped" id="orderTable">
<thead>
<tr>
<th>#</th>
<th>Order Id</th>
<!-- <th>Vendor Name</th>
<th>Vendor Company name</th>
<th>Vendor Phone</th>

<th>Vendor Email</th>
<th>Vendor Gst</th>
<th>Vendor Address</th> -->
<th>Vendor Name </th>

<th>Farmer Name </th>

<!-- <th>Promocode</th> -->
<th>Total Amount</th>
<th>Promocode Discount</th>
<!-- <th>Shippping Charges</th> -->
<th>Final Amount</th>
<th>Payment Type</th>
<!-- <th>Address Name</th> -->
<th>Phone</th>
<th>Village </th>
<th>District </th>
<th>Vendor Shop Name </th>
<th><th>Vendor Address</th>
 </th>



<th>State</th>
<th>City</th>
<th>Email</th>
<th>Address</th>

<th>Date</th>
<?if($order_type==1){?>
<th>Status</th>
<?}?>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php $i=1;
if($order_type==1){
  $order_typee=1;
}else{
  $order_typee=2;
}
 foreach ($vendor_order1_data->result() as $data) 
 {
$this->db->select('*');
$this->db->from('tbl_farmers');

// $this->db->where('id', $data->farmers_id);
$farmers_data= $this->db->get()->row();?>




<tr>
<td><?=$i?></td>
<td><?=$data->id?></td>
<td><?=$farmers_data->name?></td>

<td><?php echo "₹".$data->total_amount ?></td>
<td><?php if(!empty($data->promocode)){ echo "₹".$data->promo_discount;}else{ echo "NA";} ?></td>
<!-- <td><? if(!empty($data->shipping)){ echo "₹".$data->shipping;} else { echo "NA"; }?></td> -->
<td><?php echo "₹".$data->final_amount ?></td>
<td>
<?php if ($data->payment_type== 1) {
                                  echo "COD";
                              } else {
echo "online payment";
}  ?></td>

<!-- <td><?php echo $data->name ?></td> -->
<td><?php echo $data->phone ?></td>
<td><?=$farmers_data->village?></td>
<td><?=$farmers_data->district?>

<td><?php echo $data->state;?></td>
<td><?php echo $data->city?></td>
<!-- <td><?php echo $data->vendor_code ?></td> -->
<td><?php echo $data->email ?></td>
<td><?php echo $data->address ?></td>


    <!-- <td><?php echo $data->ref_points ?></td> -->
    <td>
<?
  $newdate = new DateTime($data->date);
  echo $newdate->format('F j, Y, g:i a');   #d-m-Y  // March 10, 2001, 5:16 pm
  ?>
</td>
<td><?php if ($data->order_status==1) {?>
<p class="label bg-yellow">Pending</p>
<?} elseif ($data->order_status==2) {?>
<p class="label bg-green">Accepted</p>

<?} elseif ($data->order_status==3) {?>
<p class="label bg-orange">Dispatched</p>

<?} elseif ($data->order_status==4) {?>
<p class="label bg-purple">Completed</p>

<?} elseif ($data->order_status==5) {?>
<p class="label bg-red">Rejected</p>

<?} elseif ($data->order_status==6) {?>
<p class="label bg-red">Cancelled</p>
<?}
else {
echo("rejected");
}

 ?>
</td>
<td>
<div class="btn-group" id="btns<?php echo $i ?>">
<div class="btn-group">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
<ul class="dropdown-menu" role="menu">
  <?php
  if($data->order_type==1){
   if ($data->order_status==1) { ?>
  <li><a href="<?php echo base_url() ?>dcadmin/order/updateorderStatus/<?php echo base64_encode($data->id) ?>/confirmed">Accepted</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/order/updateorderStatus/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/order/order_detail/<?php echo base64_encode($data->id) ?>">order detail</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/order/view_bill/<?php echo base64_encode($data->id) ?>">view bill</a></li>

  <?php } elseif ($data->order_status==2) {?>
  <li><a href="<?php echo base_url() ?>dcadmin/order/updateorderStatus/<?php echo base64_encode($data->id) ?>/dispatched">Dispatched</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/order/updateorderStatus/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/order/order_detail/<?php echo base64_encode($data->id) ?>">order detail</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/order/view_bill/<?php echo base64_encode($data->id) ?>">view bill</a></li>

  <?php } elseif ($data->order_status==3) {?>
  <li><a href="<?php echo base_url() ?>dcadmin/Order/updateorderStatus/<?php echo base64_encode($data->id) ?>/completed">Completed</a></li>
  <!-- <li><a href="<?php echo base_url() ?>dcadmin/Order/updateorderStatus/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li> -->
  <li><a href="<?php echo base_url() ?>dcadmin/Order/order_detail/<?php echo base64_encode($data->id) ?>">order detail</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/Order/view_bill/<?php echo base64_encode($data->id) ?>">view bill</a></li>

  <?php } elseif ($data->order_status==4) {?>
    <!-- <li><a href="<?php echo base_url() ?>dcadmin/Order/updateorderStatus/<?php echo base64_encode($data->id) ?>/delievered">Accepted</a></li>
    <li><a href="<?php echo base_url() ?>dcadmin/Order/updateorderStatus/<?php echo base64_encode($data->id) ?>/reject">Rejected</a></li> -->
  <li><a href="<?php echo base_url() ?>dcadmin/Order/order_detail/<?php echo base64_encode($data->id) ?>">order detail</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/Order/view_bill/<?php echo base64_encode($data->id) ?>">order bill</a></li>
  <?php } elseif ($data->order_status==5) {?>
  <li><a href="<?php echo base_url() ?>dcadmin/Order/order_detail/<?php echo base64_encode($data->id) ?>">order detail</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/Order/view_bill/<?php echo base64_encode($data->id) ?>">view bill</a></li>
  <?}}else{?>
  <li><a href="<?php echo base_url() ?>dcadmin/order/order_detail/<?php echo base64_encode($data->id) ?><?if($order_type=2){echo "/".base64_encode($data->id);}?>">order detail</a></li>
  <li><a href="<?php echo base_url() ?>dcadmin/order/view_bill/<?php echo base64_encode($data->id) ?>">view bill</a></li>
    <!-- <li><a href="<?php echo base_url() ?>dcadmin/order/view_bid/<?php echo base64_encode($data->id) ?>">view bid</a></li> -->
<?}?>
  </ul>
</div>

</div>


</td>
</tr>
<?php $i++;
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
$('#orderTable').DataTable({
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
columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19] //number of columns, excluding # column
}
},
{
extend: 'csvHtml5',
exportOptions: {
columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
}
},
{
extend: 'excelHtml5',
exportOptions: {
columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
}
},
{
extend: 'pdfHtml5',
exportOptions: {
columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
}
},
{
extend: 'print',
exportOptions: {
columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]
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
