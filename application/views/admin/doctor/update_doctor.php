<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Update Doctor
    </h1>
    <ol class="breadcrumb">
      <!-- <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Team </a></li> -->
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update Doctor</h3>
          </div>
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
            <div class="col-lg-10">
              <form action="<?php echo base_url() ?>dcadmin/Doctor/update_doctor_data/<?= $id ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Name </strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="name" class="form-control" placeholder="" required value="<?= $doctor->name ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Name (Hindi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="hi_name" class="form-control" placeholder="" required value="<?= $doctor->hi_name ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Name (Punjabi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="pn_name" class="form-control" placeholder="" required value="<?= $doctor->pn_name ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Email</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="email" class="form-control" placeholder="" required value="<?= $doctor->email ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Doctor/Clinic</strong> <span style="color:red;"></span></strong> </td>
                      <td>
                        <input type="file" name="image" class="form-control" placeholder="" value="<?= $doctor->image ?>" />
                      </td>
                      <td>
                        <?php if ($doctor->image != "") {  ?>
                          <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $doctor->image ?>">
                        <?php } else {  ?>
                          Sorry No image Found
                        <?php } ?>
                      </td>
                    </tr>
                    <!-- *****************************************type radio button***************************************************** -->
                    <tr>
                      <td> <strong>Type</strong> <span style="color:red;">*</span></strong> </td>
                      <td><input type="radio" id="Red" name="type" <?= $doctor->type == 'Vet' ? 'checked' : '' ?> value="Vet">
                        <label for="Red">Vet</label>
                        <br>
                        <input type="radio" id="Green" name="type" <?= $doctor->type == 'Assistant' ? 'checked' : '' ?> value="Assistant">
                        <label for="Green">Livestock Assistant</label>
                        <br>
                        <input type="radio" id="Yellow" name="type" <?= $doctor->type == 'Private Practitioner' ? 'checked' : '' ?> value="Private Practitioner">
                        <label for="Yellow">Private Practitioner
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Expertise Category</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple data-live-search="true" name="expert_category[]" required>
                          <? foreach ($expert_data as $value) {
                          ?>
                            <option value="<?= $value->id; ?>" <?php
                                                                $expert_category = json_decode($doctor->expert_category);
                                                                if (is_array($expert_category)) {
                                                                  foreach ($expert_category as $vv) {
                                                                    if ($vv == $value->id) {
                                                                      echo "selected";
                                                                    }
                                                                  }
                                                                } ?>><?= $value->name ?></option>
                          <?
                          } ?>
                        </select>
                    </tr>
                    <!-- ********************************************************************************************************************* -->
                    <tr>
                      <td> <strong>Degree </strong> <span style="color:red;"></span></strong> </td>
                      <td>
                        <input type="text" name="degree" class="form-control" placeholder="" value="<?= $doctor->degree ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Experience</strong> <span style="color:red;"></span></strong> </td>
                      <td>
                        <input type="text" name="experience" class="form-control" placeholder="" value="<?= $doctor->experience ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>District(English)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="district" class="form-control" placeholder="" required value="<?= $doctor->district ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>District(Hindi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="hi_district" class="form-control" placeholder="" required value="<?= $doctor->hi_district ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>District(Punjabi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="pn_district" class="form-control" placeholder="" required value="<?= $doctor->pn_district ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>State</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" name="state" id="states">
                          <option value="">---state---</option>
                          <?php foreach ($state_data->result() as $a) { ?>
                            <option value="<?= $a->id ?>" <? if ($a->id == $doctor->state) {
                                                            echo 'selected';
                                                          } ?>><?= $a->state_name ?></option>
                          <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>City(English)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="city" class="form-control" placeholder="" required value="<?= $doctor->city ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>City(Hindi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="hi_city" class="form-control" placeholder="" required value="<?= $doctor->hi_city ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>City(Punjabi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="pn_city" class="form-control" placeholder="" required value="<?= $doctor->pn_city ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Pincode</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="pincode" class="form-control" placeholder="" required value="<?= $doctor->pincode ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Aadhar Number</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="aadhar_no" class="form-control" placeholder="" required value="<?= $doctor->aadhar_no ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Phone Number</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" onkeypress="return isNumberKey(event)" name="phone" readonly class="form-control" placeholder="" maxlength="10" minlength="10" required value="<?= $doctor->phone ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
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
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />3
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
  $('select').selectpicker();
</script>
<!-- ----------------------------------  vet radio button function ------------------------------------------- -->
<script>
  function change(x) {
    if (x == 1) {
      $('#change2').html('<td><strong>Degree</strong> <span style="color:red;">*</span></strong> </td><td><input type="text" name="type_colume" value="Vet" class="form-control" placeholder="Degree" onkeypress="return isNumberKey(event)"/></td><br><td><strong>Experiance</strong> <span style="color:red;">*</span></strong> </td><td><input type="text" name="" value="Experiance" class="form-control" placeholder="Experiance " onkeypress="return isNumberKey(event)"/></td');
    } else {
      $('#change2').html('');
    }
  }
</script>
<script>
  $(document).ready(function() {
    $("#states").change(function() {
      // alert('hii');
      var vf = $(this).val();
      // alert(vf);
      if (vf == "") {
        return false;
      } else {
        $('#cities option').remove();
        var opton = "<option value=''>----Please Select-----</option>";
        $.ajax({
          url: base_url + "dcadmin/farmers/getfarmers/" + vf,
          data: '',
          type: "get",
          success: function(html) {
            if (html != "NA") {
              var s = jQuery.parseJSON(html);
              $.each(s, function(i) {
                opton += '<option value="' + s[i]['cities_id'] + '">' + s[i]['city_name'] + '</option>';
              });
              $('#cities').append(opton);
              //$('#city').append("<option value=''>Please Select State</option>");
              //var json = $.parseJSON(html);
              //var ayy = json[0].name;
              //var ayys = json[0].pincode;
            } else {
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
  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }
</script>