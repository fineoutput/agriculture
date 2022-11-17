  <div class="content-wrapper">
  <section class="content-header">
  <h1>
  Add New Team
  </h1>
  <ol class="breadcrumb">
  <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Team </a></li>

  </ol>
  </section>
  <section class="content">
  <div class="row">
  <div class="col-lg-12">

  <div class="panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Team</h3>
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
  <form action="<?php echo base_url() ?>dcadmin/doctor/add_doctor_data/" method="POST" id="slide_frm" enctype="multipart/form-data">
  <div class="table-responsive">
  <table class="table table-hover">

    <tr>
    <td> <strong>Name</strong>  <span style="color:red;">*</span></strong> </td>
    <td>
    <input type="text" name="name_colume"  class="form-control" placeholder="" required value="" />
    </td>
    </tr>
    <tr>

      <tr>
      <td> <strong>Email</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="email_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>


      <tr>
      <td> <strong>Aadhar Upload</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="file" name="image"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>Type</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="type_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>Vet</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="vet_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>Degree</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="degree_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>


      <tr>
      <td> <strong>Experiance</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="experiance_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>


      <tr>
      <td> <strong>Assistant</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="assistant_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>
      <tr>
      <td> <strong>Private Practitioner</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="private_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>Education Qualification</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="education_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>District</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="district_colume"  class="form-control" placeholder="" required value="" />
      </td>
      </tr>

      <tr>
      <td> <strong>State</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <!-- <input type="text" name="state_colume"  class="form-control" placeholder="" required value="" /> -->
      <select class="form-control" name="state_colume">
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
      <select class="form-control" name="city_colume">
        <option value="">---City---</option>
        <?php foreach ($city_data->result() as $a){?>
          <option value="<?=$a->id?>"><?=$a->city_name?></option>
        <?php } ?>
      </td>
      </tr>

      <tr>
      <td> <strong>Phone Number</strong>  <span style="color:red;">*</span></strong> </td>
      <td>
      <input type="text" name="phone_colume"  class="form-control" placeholder="" required value="" />
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
