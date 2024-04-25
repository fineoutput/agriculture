<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Vendor Slider Requests
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> All Vendor Slider</a></li>
      <li class="active">View VendorSlider req</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">View vendor Slider Req</h3>
          </div>
          <div class="panel panel-default">
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
              <div class="box-body table-responsive no-padding">
                <table class="table table-bordered table-hover table-striped" id="userTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Image</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;
                    foreach ($vendorslider_data->result() as $data) { ?>
                      <tr>
                        <td><?php echo $i ?> </td>
                        <td>
                          <?php if ($data->image1 != "") {  ?>
                            <img id="slide_img_path" height="70" width="120" src="<?php echo base_url() . $data->image1 ?>" onclick="openFullImage(this.src)">
                          <?php } else {  ?>
                            Sorry No image Found
                          <?php } ?>
                        </td>
                        <td><?php if ($data->is_active == 2) { ?>
                            <p class="label bg-green">Active</p>
                          <?php } else { ?>
                            <p class="label bg-yellow">Inactive</p>
                          <?php    }   ?>
                        </td>
                        <td>
                          <div class="btn-group" id="btns<?php echo $i ?>">
                            <div class="btn-group">
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                              <ul class="dropdown-menu" role="menu">
                                <?php if ($data->is_active == 2) { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/vendor_slider/updatevendorslider_req/<?php echo base64_encode($data->id) ?>/inactive">Inactive</a></li>
                                <?php } else { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/vendor_slider/updatevendorslider_req/<?php echo base64_encode($data->id) ?>/active">Active</a></li>
                                <?php    }   ?>
                              </ul>
                            </div>
                          </div>
                          <div style="display:none" id="cnfbox<?php echo $i ?>">
                            <p> Are you sure delete this </p>
                            <a href="<?php echo base_url() ?>dcadmin/vendor_slider/delete_vendorslider/<?php echo base64_encode($data->id); ?>" class="btn btn-danger">Yes</a>
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
    // $('#userTable').DataTable({
    // responsive: true,
    // // bSort: true
    // });
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
<script>
function openFullImage(imageSrc) {
    // Create a modal container
    var modal = document.createElement('div');
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
    modal.style.zIndex = '9999';
    
    // Create an image element for the full-size image
    var fullImage = document.createElement('img');
    fullImage.src = imageSrc;
    fullImage.style.maxWidth = '90%';
    fullImage.style.maxHeight = '90%';
    
    // Append the full image to the modal
    modal.appendChild(fullImage);
    
    // Append the modal to the body
    document.body.appendChild(modal);
    
    // Close the modal when clicked anywhere outside the image
    modal.onclick = function() {
        modal.remove();
    };
}
</script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->