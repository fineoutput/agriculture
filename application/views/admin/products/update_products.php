<div class="content-wrapper">
<section class="content-header">
<h1>
Add New Products
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Products </a></li>

</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Products</h3>
</div>

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
<div class="col-lg-10">
<form action="<?php echo base_url() ?>dcadmin/Products/add_products_data/<? echo base64_encode(2); ?>/<?=$id?>" method="POST" id="slide_frm" enctype="multipart/form-data">
<div class="table-responsive">
<table class="table table-hover">

  <tr>
  <td> <strong>Name (English)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="name_english"  class="form-control" placeholder="" required value="<?=$products->name_english?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>Name (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="name_hindi"  class="form-control" placeholder="" required value="<?=$products->name_hindi?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>Name (Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="name_punjabi"  class="form-control" placeholder="" required value="<?=$products->name_punjabi?>" />
  </td>
  </tr>




  <tr>
  <td> <strong>description(English)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="description_english"  class="form-control" placeholder="" required value="<?=$products->description_english?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>description(Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="description_hindi"  class="form-control" placeholder="" required value="<?=$products->description_hindi?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>description (Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="description_punjabi"  class="form-control" placeholder="" required value="<?=$products->description_punjabi?>" />
  </td>
  </tr>




<tr>
<td> <strong>image1</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="file" name="image1"  class="form-control" placeholder="" required value="<?=$products->image1?>" />
</td>

<td>
<?php if ($products->image1!="") {  ?>
<img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$products->image1 ?>">
<?php } else {  ?>
Sorry No image Found
<?php } ?>
</td>
</tr>

<tr>
<td> <strong>image2</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="file" name="image2"  class="form-control" placeholder="" required value="<?=$products->image2?>" />
</td>

<td>
<?php if ($products->image2!="") {  ?>
<img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$products->image2 ?>">
<?php } else {  ?>
Sorry No image Found
<?php } ?>
</td>
</tr>





<tr>
<td> <strong>mrp</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="mrp"  class="form-control" placeholder="" required value="<?=$products->mrp?>" />
</td>
</tr>


<tr>
<td> <strong>selling_price</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="selling_price"  class="form-control" placeholder="" required value="<?=$products->selling_price?>" />
</td>
</tr>




<tr>
<td> <strong>inventory</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="inventory"  class="form-control" placeholder="" required value="<?=$products->inventory?>" />
</td>
</tr>



<td colspan="2" >
<input type="submit" class="btn btn-success" value="save">
</td>
</tr>
</table>
</div>

</form>

</div>



</div>

</div>

</div>
</div>
</section>
</div>


<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
