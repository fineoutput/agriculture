<div class="content-wrapper">
  <section class="content-header">
    <h1>
      All <?= $heading ?> Products
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View All <?= $heading ?> Products</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <? if ($is_admin == 1) { ?><a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/Products/add_products" role="button" style="margin-bottom:12px;"> Add Product</a>
        <? } ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-box-open "></i> View All <?= $heading ?> Products</h3>
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
                      <? if ($is_admin == 0) { ?>
                        <th>Vendor Name</th>
                        <th>Vendor Phone</th>
                      <? } ?>
                      <th>Name (English)</th>
                      <th>Name (Hindi)</th>
                      <th>Name (Punjabi)</th>
                      <th>Description(English)</th>
                      <th>Description(Hindi)</th>
                      <th>Description(Punjabi)</th>
                      <th>Image</th>
                      <th>Mrp</th>
                      <th>Selling Price</th>
                      <th>GST%</th>
                      <th>GST Price</th>
                      <th>Selling Price(without GST)</th>
                      <th>Inventory</th>
                      <th>Suffix</th>
                      <th>Minimum Qty</th>
                      <th>Offer</th>
                      <th>Status</th>
                      <th>COD</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;
                    foreach ($products_data->result() as $data) {
                      if ($data->is_admin == 0) {
                        $vendor_data = $this->db->get_where('tbl_vendor', array('id' => $data->added_by))->result();
                      }
                    ?>
                      <tr>
                        <td><?php echo $i ?> </td>
                        <? if ($data->is_admin == 0) { ?>
                          <td><?php echo $vendor_data ? $vendor_data[0]->name : 'Not Found!' ?></td>
                          <td><?php echo $vendor_data ? $vendor_data[0]->phone : 'Not Found!' ?></td>
                        <? } ?>
                        <td><?php echo $data->name_english ?></td>
                        <td><?php echo $data->name_hindi ?></td>
                        <td><?php echo $data->name_punjabi ?></td>
                        <td><?php echo $data->description_english ?></td>
                        <td><?php echo $data->description_hindi ?></td>
                        <td><?php echo $data->description_punjabi ?></td>
                        <td>
                          <?php if ($data->image != "") {  ?>
                            <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image ?>">
                          <?php } else {  ?>
                            Sorry No image Found
                          <?php } ?>
                        </td>
                        <td><?php echo $data->mrp ? '₹' . $data->mrp : '' ?></td>
                        <td><?php echo $data->selling_price ? '₹' . $data->selling_price : '' ?></td>
                        <td><?php echo $data->gst ? $data->gst . '%' : '' ?></td>
                        <td><?php echo $data->gst_price ?  '₹' . $data->gst_price : '' ?></td>
                        <td><?php echo $data->selling_price_wo_gst ? '₹' . $data->selling_price_wo_gst : '' ?></td>
                        <td><?php echo $data->inventory ?></td>
                        <td><?php echo $data->suffix ?></td>
                        <td><?php echo $data->min_qty ?></td>
                        <td><?php echo $data->offer ?></td>
                        <td><?php if ($data->is_active == 1) { ?>
                            <p class="label bg-green">Active</p>
                          <?php } else { ?>
                            <p class="label bg-yellow">Inactive</p>
                          <?php    }   ?>
                        </td>
                        <td>
                          <input type="checkbox" class="mycheckbox" id="myCheckbox" data-id="<?php echo $data->id ?>"  name="checkbox" <?php echo ($data->cod == 1) ? 'checked' : ''; ?>>
                        </td>
                        <td>
                          <div class="btn-group" id="btns<?php echo $i ?>">
                            <div class="btn-group">
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                              <ul class="dropdown-menu" role="menu">
                                <?php if ($data->is_admin == 0 && $data->is_approved == 0) { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/Products/approvedProduct/<?php echo base64_encode($data->id) ?>">Approved</a></li>
                                <?php    }   ?>
                                <?php if ($data->is_active == 1) { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/Products/updateProductsStatus/<?php echo base64_encode($data->id) ?>/inactive">Inactive</a></li>
                                <?php } else { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/Products/updateProductsStatus/<?php echo base64_encode($data->id) ?>/active">Active</a></li>
                                <?php    }   ?>
                                <li><a href="<?php echo base_url() ?>dcadmin/Products/update_products/<?php echo base64_encode($data->id) ?>">Edit</a></li>
                                <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li>
                              </ul>
                            </div>
                          </div>
                          <div style="display:none" id="cnfbox<?php echo $i ?>">
                            <p> Are you sure delete this </p>
                            <a href="<?php echo base_url() ?>dcadmin/Products/delete_products/<?php echo base64_encode($data->id); ?>" class="btn btn-danger">Yes</a>
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
    $(document).ready(function(){
        // Check if the checkbox exists and bind the change event
        if ($('.mycheckbox').length) {
            $('.mycheckbox').on('change', function(){
                // Check if the checkbox is checked
                var isChecked = $(this).prop('checked');

                // Get the value of data-id attribute
                var userId = $(this).data('id'); 

                alert('successfully update');

                // Your AJAX call
                var data = {
                    userId: userId,
                    isChecked: isChecked
                };

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('dcadmin/Products/product_cod_data'); ?>',
                    data: data,
                    success: function(response){
                        console.log(response); // Handle the response from the server
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText); // Log any errors
                    }
                });
            });
        } else {
            console.error('Checkbox element not found.');
        }
    });
</script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->