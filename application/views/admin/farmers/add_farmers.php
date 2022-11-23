<div class="content-wrapper">
<section class="content-header">
<h1>
Add Farmer
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
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Farmers</h3>
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
<form action="<?php echo base_url() ?>dcadmin/Farmers/add_farmers_data/<? echo base64_encode(1); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
<div class="table-responsive">
<table class="table table-hover">

<tr>
<td> <strong>Name (English)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="name_english"  class="form-control" placeholder=""  required value="" />
</td>
</tr>

<tr>
<td> <strong>Name (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="name_hindi"  class="form-control" placeholder="" required value="" />
</td>
</tr>

<tr>
<td> <strong>Name (Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="name_punjabi"  class="form-control" placeholder=""  required value="" />
</td>
</tr>


<tr>
<td> <strong>Village (English)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="village_english"  class="form-control" placeholder=""  required value="" />
</td>
</tr>

<tr>
<td> <strong>Village (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="village_hindi"  class="form-control" placeholder=""  required value="" />
</td>
</tr>

<tr>
<td> <strong>Village Punjabi</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="village_punjabi"  class="form-control" placeholder="" required value="" />
</td>
</tr>


<tr>
<td> <strong>Distrct (English)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="district_english"  class="form-control" placeholder="" required value="" />
</td>
</tr>


<tr>
<td> <strong>District (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="district_hindi"  class="form-control" placeholder="" required value="" />
</td>
</tr>


<tr>
<td> <strong>Disctrict (Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" name="district_punjabi"  class="form-control" placeholder="" required value="" />
</td>
</tr>




<tr>

 <td> <strong>State name</strong>  <span style="color:red;">*</span></strong> </td>

 <td>

   <select name="name" class="form-control" id="states" required>

     <option value="">-----select state-----</option>

   <?php $i=1; foreach($state_data->result() as $cat) { ?>

   <option value="<?=$cat->id?>"><?=$cat->state_name?></option>

 <?php } ?>

 </select>

 </td>

 </tr>
  <tr>
  <td> <strong>City</strong>  <span style="color:red;">*</span></strong> </td>
  <td>
  <!-- <input type="text" name="city_colume"  class="form-control" placeholder="" required value="" /> -->
  <select class="form-control" name="city" id="cities">
    <option value="">---City---</option>
    <?php foreach ($city_data->result() as $a){?>
      <option value="<?=$a->id?>"><?=$a->city_name?></option>
    <?php } ?>
  </td>
  </tr>

<tr>
<td> <strong>Pincode</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text" onkeypress="return isNumberKey(event)"
name="Pincode"  class="form-control" placeholder=""   maxlength="6" minlength="6"    required value="" />
</td>
</tr>


<tr>
<td> <strong>Phone Number</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<input type="text"    onkeypress="return isNumberKey(event)"
 name="phone_number"  class="form-control" placeholder="" maxlength="10" minlength="10"  required value="" />
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

<script>
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
