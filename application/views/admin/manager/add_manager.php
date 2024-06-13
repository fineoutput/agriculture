<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New Manager
    </h1>
    <ol class="breadcrumb">
      <!-- <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Products </a></li> -->
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Add New Manager</h3>
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
              <form action="<?php echo base_url() ?>dcadmin/Manager/add_manager_data/<? echo base64_encode(1); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Full Name </strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="name"  id="name" class="form-control" placeholder="" required value="" />
                      </td>
                    </tr>
                 
                  
                    
                    <tr>
                      <td> <strong>Address </strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="address" class="form-control" placeholder="" required value="" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Phone Number</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="phone" class="form-control" placeholder="" required value="" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Email </strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="email" name="email" class="form-control" placeholder="" required value="" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Aadhar Number </strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="aadhar" class="form-control" placeholder="" required />
                      </td>
                    </tr>
                    <tr>
                    <tr>
                      <td> <strong>Your refer Code  </strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="refer_code" id="refer" class="form-control" placeholder="" required value="" />
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Aadhar Upload</strong></td>
                      <td>
                        <input type="file" name="images[]" value="1"  class="form-control" multiple />
                      </td>
                    </tr>
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
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
<script>
//   function isNumberKey(evt) {
//     var charCode = (evt.which) ? evt.which : evt.keyCode
//     if (charCode > 31 && (charCode < 48 || charCode > 57))
//       return false;
//     return true;
//   }
 
        $(document).ready(function(){
            $('#images').on('change', function(){
                if(this.files.length > 2){
                    alert('You can only upload a maximum of 2 files');
                    this.value = ''; // Clear the input value
                }
            });
        });
        document.getElementById('name').addEventListener('input', function() {
            const name = this.value.trim().replace(/\s+/g, '');
            const id = name.slice(0, 4).padEnd(4, 'X').toUpperCase(); // Take first 4 characters, pad if less, and uppercase
            const randomString = Math.random().toString(36).substring(2, 8).toUpperCase(); // Generate 6 random alphanumeric characters
            const referralCode = id + randomString;
            document.getElementById('refer').value = referralCode;
        });
 
</script>