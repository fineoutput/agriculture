<div class="content-wrapper">
<section class="content-header">
<h1>
Add New Farmers
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Farmers </a></li>

</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New  Farmers</h3>
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
<form action="<?php echo base_url() ?>dcadmin/Farmers/add_farmers_data/<? echo base64_encode(2); ?>/<?=$id?>" method="POST" id="slide_frm" enctype="multipart/form-data">
<div class="table-responsive">
<table class="table table-hover">
<tr>
<td> <strong>Name (English)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="name_english"  class="form-control" placeholder="" required value="<?=$farmers->name_english?>"/>

</td>
</tr>

<tr>
<td> <strong>Name (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="name_hindi"  class="form-control" placeholder="" required value="<?=$farmers->name_hindi?>" />
</td>
</tr>

<tr>
<td> <strong>Name (Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="name_punjabi"  class="form-control" placeholder="" required value="<?=$farmers->name_punjabi?>" />
</td>
</tr>


<tr>
<td> <strong>Village (English)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="village_english"  class="form-control" placeholder="" required value="<?=$farmers->village_english?>" />
</td>
</tr>

<tr>
<td> <strong>Village (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="village_hindi"  class="form-control" placeholder="" required value="<?=$farmers->village_hindi?>" />
</td>
</tr>

<tr>
<td> <strong>Village Punjabi</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="village_punjabi"  class="form-control" placeholder="" required value="<?=$farmers->village_punjabi?>" />
</td>
</tr>


<tr>
<td> <strong>Distrct (English)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="district_english"  class="form-control" placeholder="" required value="<?=$farmers->district_english?>" />
</td>
</tr>


<tr>
<td> <strong>District (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="district_hindi"  class="form-control" placeholder="" required value="<?=$farmers->district_hindi?>" />
</td>
</tr>


<tr>
<td> <strong>Disctrict (Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="district_punjabi"  class="form-control" placeholder="" required value="<?=$farmers->district_punjabi?>" />
</td>
</tr>

<tr>
<td> <strong>state</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<select class="form-control" name="state" id="states">   
   <option value="">---state---</option>   
   <?php foreach ($state_data->result() as $a){​​?>   
    <option value="<?=$a->id?>" <?if($a->id==$farmers->state){echo 'selected';}?>><?=$a->state_name?></option>


     <?php }​​ ?>


</td>
</tr>

<tr>
<td> <strong>city</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<select class="form-control" name="city" id="cities">   
   <option value="">---city---</option>   
   <?php foreach ($city_data->result() as $a){​​?>   
    <option value="<?=$a->id?>" <?if($a->id==$farmers->city){echo 'selected';}?>><?=$a->city_name?></option>
     <?php }​​ ?>

</td>
</tr>

<tr>
<td> <strong>Pincode</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="Pincode"  class="form-control" placeholder="" required value="<?=$farmers->pincode?>" />
</td>
</tr>


<tr>
<td> <strong>phone_number</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="phone_number"  class="form-control" placeholder="" required value="<?=$farmers->phone_number?>" />
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
							alert('No subcategory Found');
							return false;
						}

					}

				})
		}


	})
  });
</script>
