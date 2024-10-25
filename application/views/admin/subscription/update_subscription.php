<div class="content-wrapper">
<section class="content-header">
<h1>
Update new subscription
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>dcadmin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> All subscription </a></li>

</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New subscription</h3>
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
<form action="<?php echo base_url() ?>dcadmin/subscription/add_subscription_data/<? echo base64_encode(2); ?>/<?=$id?>" method="POST" id="slide_frm" enctype="multipart/form-data">
<div class="table-responsive">
<table class="table table-hover">

  <tr>
  <td> <strong>Name </strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="service_name"  class="form-control" placeholder="" required value="<?=$subscription->service_name?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>Monthly Price</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="monthly_price"  class="form-control" placeholder="" required value="<?=$subscription->monthly_price?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Monthly Description</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="monthly_description"  class="form-control" placeholder="" required value="<?=$subscription->monthly_description?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Monthly Service</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="monthly_service"  class="form-control" placeholder="" required value="<?=$subscription->monthly_service?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Quarterly Price</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="quaterly_price"  class="form-control" placeholder="" required value="<?=$subscription->quarterly_price?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Quarterly Description</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="quaterly_description"  class="form-control" placeholder="" required value="<?=$subscription->quarterly_description?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Quarterly Service</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="quaterly_service"  class="form-control" placeholder="" required value="<?=$subscription->quarterly_service?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Half Yealy Price</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="halfyearly_price"  class="form-control" placeholder="" required value="<?=$subscription->halfyearly_price?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Half Yealy Description</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="halfyearly_description"  class="form-control" placeholder="" required value="<?=$subscription->halfyearly_description?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Half Yealy Service</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="halfyearly_service"  class="form-control" placeholder="" required value="<?=$subscription->halfyearly_service?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Yealy Price</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="yearly_price"  class="form-control" placeholder="" required value="<?=$subscription->yearly_price?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Yealy Description</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="yearly_description"  class="form-control" placeholder="" required value="<?=$subscription->yearly_description?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Yealy Service</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="yearly_service"  class="form-control" placeholder="" required value="<?=$subscription->yearly_service?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Aninal</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="animals"  class="form-control" placeholder="" required value="<?=$subscription->animals?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Doctor</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="doctor"  class="form-control" placeholder="" required value="<?=$subscription->doctor_calls?>" />
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
