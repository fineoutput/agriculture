<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New Products
    </h1>
    <ol class="breadcrumb">
      <!-- <li><a href="<?php echo base_url() ?>dcadmin"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/View_products"><i class="fa fa-dashboard"></i> All Products </a></li> -->
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Products</h3>
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
              <form action="<?php echo base_url() ?>dcadmin/Products/add_products_data/<? echo base64_encode(2); ?>/<?= $id ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Name (English)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="name_english" class="form-control" placeholder="" required value="<?= $products->name_english ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Name (Hindi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="name_hindi" class="form-control" placeholder="" required value="<?= $products->name_hindi ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Name (Punjabi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="name_punjabi" class="form-control" placeholder="" required value="<?= $products->name_punjabi ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Description(English)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="description_english" class="form-control" placeholder="" required value="<?= $products->description_english ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Description(Hindi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="description_hindi" class="form-control" placeholder="" required value="<?= $products->description_hindi ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Description (Punjabi)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="description_punjabi" class="form-control" placeholder="" required value="<?= $products->description_punjabi ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Image</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="file" name="images[]" class="form-control" placeholder="" multiple value="<?= $products->image ?>" />
                      </td>
                      <td>
                        <?php
                        if (!empty($products->image)) {
                          // Check if the images field is a JSON string
                          $imageArray = json_decode($products->image, true);
                          if (json_last_error() == JSON_ERROR_NONE) {
                            // It's a JSON string, so iterate over the array
                            if (is_array($imageArray) && !empty($imageArray)) {
                              foreach ($imageArray as $imagePath) { ?>
                                <img id="slide_img_path" height="50" width="100" src="<?php echo base_url() . $imagePath; ?>" alt="Product Image">
                              <?php }
                            } else { ?>
                              Sorry, no images found.
                            <?php }
                          } else {
                            // It's not a JSON string, treat it as a single image URL
                            ?>
                            <img id="slide_img_path" height="50" width="100" src="<?php echo base_url() . $products->image; ?>" alt="Product Image">
                          <?php
                          }
                        } else { ?>
                          Sorry, no images found.
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Video</strong></td>
                      <td>
                        <input type="file" name="video" class="form-control" />
                      </td>
                      <td>
                        <?php if (!empty($products->video)) { ?>
                          <video height="50" width="100" controls>
                            <source src="<?php echo base_url() . $data->video; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                          </video>
                        <?php } else { ?>
                          Sorry, no video found.
                        <?php } ?>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong id="mp">MRP</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="mrp" class="form-control" onkeypress="return isNumberKey(event)" placeholder="" required value="<?= $products->mrp ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong id="spp">Selling Price</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="selling_price" class="form-control" onkeypress="return isNumberKey(event)" placeholder="" id="sellingprice" required value="<?= $products->selling_price ?>" />
                      </td>
                    </tr>
                    <td> <strong>GST%</strong> <span style="color:red;">*</span></strong> </td>
                    <td>
                      <input type="text" name="gst" class="form-control" onkeypress="return isNumberKey(event)" placeholder="" required value="<?= $products->gst ?>" id="gst" />
                    </td>
                    </tr>
                    <tr>
                      <td> <strong>GST Price</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="gst_price" class="form-control" placeholder="" onkeypress="return isNumberKey(event)" required value="<?= $products->gst_price ?>" id="gstprice" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Selling Price(without GST)</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="selling_price_wo_gst" class="form-control" placeholder="" onkeypress="return isNumberKey(event)" required value="<?= $products->selling_price_wo_gst ?>" id="sp" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Inventory</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="inventory" class="form-control" placeholder="" required value="<?= $products->inventory ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Suffix</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="suffix" class="form-control" placeholder="" required value="<?= $products->suffix ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Tranding Products</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" name="tranding_products">
                          <option>---select---</option>
                          <option value="1" <? if ($products->tranding_products == 1) {
                                              echo "selected";
                                            } ?>>Yes</option>
                          <option value="0" <? if ($products->tranding_products == 0) {
                                              echo "selected";
                                            } ?>>No</option>

                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Minimum Qty</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="min_qty" class="form-control" onkeypress="return isNumberKey(event)" placeholder="" required value="<?= $products->min_qty ?>" id="min_qty" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Offer</strong> </strong> </td>
                      <td>
                        <input type="text" name="offer" class="form-control" placeholder="" required value="<? echo $products->offer; ?>" />
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
  function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
      return false;
    return true;
  }
  $(document).ready(function() {
    $('#gst, #sellingprice').keyup(function() {
      var price = $('#sellingprice').val();
      var gst = $('#gst').val();
      var n = 100 + parseInt(gst);
      var gst_price = price / n * 100;
      var wgst = (price - gst_price).toFixed(2);
      $('#gstprice').val(wgst);
      var sprice = $('#gstprice').val();
      $('#sp').val(gst_price.toFixed(2));
    });
  });
</script>