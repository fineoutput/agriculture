  <div class="content-wrapper">
  <section class="content-header">
    <style>
        input[type=radio]#Yellow {
            accent-color: pink;
        }

        input[type=radio]#Green {
            accent-color: rgb(0, 255, 0);
        }

        input[type=radio]#Red {
            accent-color: #FF0000;
        }
    </style>
  <h1>
  Add New doctor
  </h1>
  <ol class="breadcrumb">
  <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All doctor </a></li>

  </ol>
  </section>
  <section class="content">
  <div class="row">
  <div class="col-lg-12">

  <div class="panel panel-default">
  <div class="panel-heading">

  <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New doctor</h3>
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
    <form action="<?php echo base_url() ?>dcadmin/Doctor/add_doctor_data/<? echo base64_encode(1); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
  <div class="table-responsive">
  <table class="table table-hover">

    <tr>
    <td> <strong>Name (English)</strong>  <span style="color:red;">*</span></strong> </td>
    <td>
    <input type="text" name="name_english"  class="form-control" placeholder="" required value="" />
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
    <input type="text" name="name_punjabi"  class="form-control" placeholder="" required value="" />
    </td>
    </tr>

      <tr>
      <td> <strong>Email</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="email"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>


      <tr>
      <td> <strong>Aadhar Upload</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="file" name="image"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

<!-- *****************************************type radio button***************************************************** -->
                <tr>
                <td> <strong>Type</strong>  <span style="color:red;">*</span></strong> </td>

                <td><input type="radio" id="Red" onclick="change(1)">
                <label for="Red">Vet</label>
                <br>
                <input type="radio" id="Green" name="type_colume" value="Assistant"onclick="change(2)">
                <label for="Green">Assistant</label>
                <br>
                <input type="radio"  id="Yellow" name="type_colume" value="Private Practitioner">
                <label for="Yellow">Private Practitioner
                </label>
                </td>
                </tr>
                <tr  id="change2">

                </tr>
  <!-- *******************************************************************************************************************  -->

      <tr>
      <td> <strong>Degree (English)</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="degree_english"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>Degree (Hindi)</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="degree_hindi"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>Degree (Punjabi)</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="degree_punjabi"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>


      <tr>
      <td> <strong>Experiance</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="experiance_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
        <td> <strong>Vet</strong>  <span style="color:red;">*</span></strong> </td>
        <td>
          <input type="checkbox" name="vet"   placeholder=""  value="1"  />
        </td>
      </tr>

      <tr>
      <td> <strong>Private Practitioner</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="checkbox" name="private_colume"   placeholder="" value="1" />
      </td>
      </tr>
      <tr>
      <td> <strong>Assistant</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="assistant_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>Education Qualification</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="education_colume"  class="form-control" placeholder="" required value="" />
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
      <td> <strong>State</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <!-- <input type="text" name="state_colume"  class="form-control" placeholder="" required value="" /> -->
      <select class="form-control" name="state_colume" id="states">
        <option value="">---state---</option>
        <?php foreach ($state_data->result() as $a){?>
          <option value="<?=$a->id?>"><?=$a->state_name?></option>
        <?php } ?>

      </td>
    </tr>
      <tr>
      <td> <strong>City</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <!-- <input type="text" name="city_colume"  class="form-control" placeholder="" required value="" /> -->
      <select class="form-control" name="city_colume" id="cities">
        <option value="">---City---</option>
        <?php foreach ($city_data->result() as $a){?>
          <option value="<?=$a->id?>"><?=$a->city_name?></option>
        <?php } ?>
      </td>
      </tr>

      <tr>
      <td> <strong>Phone Number</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" onkeypress="return isNumberKey(event)"
       name="phone_colume"  class="form-control" maxlength="10" minlength="10"  placeholder="" required value="" />
      </td>
      </tr>



  <tr>
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

  <!-- ----------------------------------  vet radio button function ------------------------------------------- -->
  <script>
    function change(x) {
      if (x == 1) {
        $('#change2').html('<td><strong>Degree</strong> <span style="color:red;">*</span></strong> </td><td><input type="text" name="type_colume" value="Vet" class="form-control" placeholder="Degree" onkeypress="return isNumberKey(event)"/></td><br><td><strong>Experiance</strong> <span style="color:red;">*</span></strong> </td><td><input type="text" name="type_colume2" value="Experiance" class="form-control" placeholder="Experiance " onkeypress="return isNumberKey(event)"/></td');
      } else {
        $('#change2').html('');
      }
    }
  </script>

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
