<div class="content-wrapper">
<section class="content-header">
<h1>
Add New vendor
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Vendor </a></li>

</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Vendor</h3>
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
  <form action="<?php echo base_url() ?>dcadmin/Vendor/add_vendor_data/<? echo base64_encode(2); ?>/<?=$id?>" method="POST" id="slide_frm" enctype="multipart/form-data">
<div class="table-responsive">
<table class="table table-hover">




  <tr>
  <td> <strong>Name (English)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="name_english"  class="form-control" placeholder="" required value="<?=$vendor->name_english?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>Name (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="name_hindi"  class="form-control" placeholder="" required value="<?=$vendor->name_hindi?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>Name (Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="name_punjabi"  class="form-control" placeholder="" required value="<?=$vendor->name_punjabi?>" />
  </td>
  </tr>


  <tr>
  <td> <strong>Shop Name(English)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="shop_name_english"  class="form-control" placeholder="" required value="<?=$vendor->shop_name_english?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>Shop Name(Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="shop_name_hindi"  class="form-control" placeholder="" required value="<?=$vendor->shop_name_hindi?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>Shop Name(Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="shop_name_punjabi"  class="form-control" placeholder="" required value="<?=$vendor->shop_name_punjabi?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>Address(English)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="address_english"  class="form-control" placeholder="" required value="<?=$vendor->address_english?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Address(Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="address_hindi"  class="form-control" placeholder="" required value="<?=$vendor->address_hindi?>" />
  </td>
  </tr>
  <tr>
  <td> <strong>Address(Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="address_punjabi"  class="form-control" placeholder="" required value="<?=$vendor->address_punjabi?>" />
  </td>
  </tr>


  <tr>
  <td> <strong>District(English)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="district_english"  class="form-control" placeholder="" required value="<?=$vendor->district_english?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>District(Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="district_hindi"  class="form-control" placeholder="" required value="<?=$vendor->district_hindi?>" />
  </td>
  </tr>

  <tr>
  <td> <strong>District(Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <input type="text" name="district_punjabi"  class="form-control" placeholder="" required value="<?=$vendor->district_punjabi?>" />
  </td>
  </tr>


  <tr>
  <td> <strong>State</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <select class="form-control" name="state_colume" id="states">
    <option value="">---state---</option>
    <?php foreach ($state_data->result() as $a){?>
      <option value="<?=$a->id?>" <?if($a->id==$vendor->state){echo 'selected';}?>><?=$a->state_name?></option>
    <?php } ?>

  </td>
</tr>
  <tr>
  <td> <strong>City</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <select class="form-control" name="city_colume" id="cities">
    <option value="">---City---</option>
    <?php foreach ($city_data->result() as $a){?>
      <option value="<?=$a->id?>" <?if($a->id==$vendor->city){echo 'selected';}?>><?=$a->city_name?></option>
    <?php } ?>
  </td>
  </tr>
<tr>
<td> <strong>Pin Code</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="pincode_colume"  class="form-control" placeholder="" required value="<?=$vendor->pincode?>" />
</td>
</tr>


<tr>
<td> <strong>GST no (optional)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="gst_colume"  class="form-control" placeholder="" required value="<?=$vendor->gst_no?>" />
</td>
</tr>


<tr>
<td> <strong>Aadhar Upload</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="file" name="image"  class="form-control" placeholder="" required value="<?=$vendor->image?>" />
</td>

<td>
<?php if ($vendor->image!="") {  ?>
<img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$vendor->image ?>">
<?php } else {  ?>
Sorry No image Found
<?php } ?>
</td>

</tr>


<tr>
<td> <strong>Pan Number</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="pan_colume"  class="form-control" placeholder="" required value="<?=$vendor->pan_number?>" />
</td>
</tr>

<tr>
<td> <strong>Phone Number</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="phone_colume"  class="form-control" placeholder="" required value="<?=$vendor->phone_number?>" />
</td>
</tr>

<tr>
<td> <strong>Email</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="email"  class="form-control" placeholder="" required value="<?=$vendor->email?>" />
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



<script >
$(document).ready(function(){
  	$("#states").change(function(){
      // alert('hii');
		var vf=$(this).val();
    // alert(vf);
		if(vf==""){
			return false;

		}else{
			$('#cities option').remove();
			  var opton="<option value=''>----Please Select-----</option>";
			$.ajax({
				url:base_url+"dcadmin/farmers/getfarmers/"+vf,
				data : '',
				type: "get",
				success : function(html){
						if(html!="NA")
						{
							var s = jQuery.parseJSON(html);
							$.each(s, function(i) {
							opton +='<option value="'+s[i]['cities_id']+'">'+s[i]['city_name']+'</option>';
							});
							$('#cities').append(opton);
							//$('#city').append("<option value=''>Please Select State</option>");

                      //var json = $.parseJSON(html);
                      //var ayy = json[0].name;
                      //var ayys = json[0].pincode;
						}
						else
						{
							alert('No city Found');
							return false;
						}

					}

				})
		}


	})
  });
</script>