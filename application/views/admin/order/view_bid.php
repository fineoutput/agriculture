<div class="content-wrapper">
<section class="content-header">
<h1>
Bid
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>dcadmin/Auction/view_auction"><i class="fa fa-dashboard"></i> All Bid </a></li>

</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">
<!-- <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcvadmin/Deals/add_deals" role="button" style="margin-bottom:12px;"> Add Auction</a> -->
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Bid </h3>
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
<table class="table table-bordered table-hover table-striped" id="userTable">
<thead>
<tr>
<th>#</th>
<th>Vendor name</th>


<!-- <th>Bid Price</th> -->

<th>Bid Price</th>
<th>Date</th>
<th>Status</th>
<!-- <th>Action</th> -->
</tr>
</thead>
<tbody>
<?php $i=1; foreach($bid_data->result() as $data) {
$vendor_data = $this->db->get_where('tbl_vendor', array('id'=> $data->vendor_id))->result();
// $brand_data = $this->db->get_where('tbl_brand', array('id'=> $data->brand_id))->result();
// $type_data = $this->db->get_where('tbl_brandtype', array('id'=> $data->brand_type))->result();
// $product_data = $this->db->get_where('tbl_product', array('hsn_code'=> $data->hsn_code))->result();

?>
<tr>
<td><?php echo $i ?> </td>
<!-- <td><?php echo $users_data[0]->f_name ." ".$users_data[0]->l_name?></td> -->
 <td><?php echo $vendor_data[0]->name ?></td>


<!-- <td>₹<?php echo $data->u_price + $data->commission?></td> -->

<td>₹<?php
      $this->db->select('*');
      $this->db->from('tbl_auction_bid');
      $bid_data= $this->db->get()->row();
      echo $bid_data->v_price?></td>
      <td><?php echo $data->date ?></td>

<td><?php if ($data->status==1) { ?>
<p class="label bg-green">Active</p>
<?php } else { ?>
<p class="label bg-yellow">Inactive</p>
<?php		} ?>
</td>
<td>
<div class="btn-group" id="btns<?php echo $i ?>">
<div class="btn-group">
<!-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button> -->
<ul class="dropdown-menu" role="menu">
  <?php if ($data->user_request==1) { ?>
  <!-- <li><a href="<?php echo base_url() ?>admin/home/updateteamStatus/<?php echo base64_encode($data->id) ?>/inactive">Inactive</a></li> -->
  <?php } else { ?>
  <!-- <li><a href="<?php echo base_url() ?>admin/course/updateteamStatus/<?php echo base64_encode($data->id) ?>/active">Active</a></li> -->
  <?php		} ?>
<?php if ($data->user_request==1) { ?>
<!-- <li><a href="<?php echo base_url() ?>admin/home/updateteamStatus/<?php echo base64_encode($data->id) ?>/inactive">Inactive</a></li> -->
<?php } else { ?>
<!-- <li><a href="<?php echo base_url() ?>admin/course/updateteamStatus/<?php echo base64_encode($data->id) ?>/active">Active</a></li> -->
<?php		} ?>
<!-- <li><a href="<?php echo base_url() ?>dcvadmin/Auction/update_bid/<?php echo base64_encode($data->id) ?>">Bid</a></li> -->
<!-- <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li> -->
</ul>
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
