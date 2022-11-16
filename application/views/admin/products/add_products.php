<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New Products
    </h1>

  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Products</h3>
          </div>

          <? if(!empty($this->session->flashdata('smessage'))){  ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <? echo $this->session->flashdata('smessage');  ?>
          </div>
          <? }
                                              if(!empty($this->session->flashdata('emessage'))){  ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <? echo $this->session->flashdata('emessage');  ?>
          </div>
          <? }  ?>


          <div class="panel-body">
            <div class="col-lg-10">
              <form action=" <?php echo base_url()  ?>dcadmin/Products/add_products_data/<? echo base64_encode(1);  ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <input type="hidden" name="category_id" value="<?=base64_decode($id)?>">


                    <tr>
                      <td> <strong>Product Name</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="text" name="productname" class="form-control" placeholder="" required value="" /> </td>
                    </tr>


                    <tr>
                      <td> <strong>Subcategory </strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" id="sid" name="subcategory_id" required>
                          <option value="">Please select subcategory</option>
                          <?

       foreach($subcategory_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->subcategory;?></option>
                          <? }?>
                        </select>
                      </td>
                    </tr>
                      <td> <strong>image</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="image" class="form-control" required placeholder="" value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>MRP</strong> <span style="color:red;"></span>*</strong> </td>
                      <td> <input type="number" name="mrp" required class="form-control" id="mrp" placeholder="" value="" /> </td>
                    </tr>
                    <!-- <tr> -->
                    <tr>
                      <td> <strong>Selling Price</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="number" name="sellingprice" required class="form-control" id="sellingprice" placeholder="" value="" /> </td>
                    </tr>
                    <!-- <tr>
                      <td> <strong>Gst %</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="number" name="gst" id="gst" required class="form-control" placeholder="" value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Gst Price</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="text" name="gstprice" id="gstprice" required class="form-control" placeholder="" value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Selling price</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="number" name="sp" id="sp" class="form-control" placeholder="" required value="" /> </td>
                    </tr> -->
                    <tr>
                      <td> <strong>Product Description</strong> </td>
                      <td> <textarea name="productdescription" id="editor1" rows="3" cols="80"></textarea> </td>
                    </tr>
                    <tr>
                      <td> <strong>Inventory</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="number" name="inventory" class="form-control" placeholder="" required value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Feature Product</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="featurepid" name="feature_product"> />
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Most selling Product</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="popular_product"> />
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </td>
                    </tr>                    
                    <tr>
                      <td colspan="2">
                        <input type="submit" class="btn custom_btn" value="save">
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

<script type="text/javascript">
  function valide_weight(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
      (charCode < 48 || charCode > 57))
      return false;

    return true;

  }
</script>


<script type="text/javascript" src=" <?php echo base_url()  ?>assets/slider/ajaxupload.3.5.js"></script>
<link href=" <? echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
<script src="<?php echo base_url() ?>assets/admin/plugins/ckeditor/ckeditor.js"></script>

<script>
  $(document).ready(function() {
    $("#sid").change(function() {
      var vf = $(this).val();
      // var yr = $("#year_id option:selected").val();
      if (vf == "") {
        return false;

      } else {
        $('#mid option').remove();
        var opton = "<option value=''>Please Select </option>";
        $.ajax({
          url: base_url + "dcadmin/Products/getMinorcategory?isl=" + vf,
          // url:base_url+"dcadmin/Products/getMinorcategory?isl="+vf,
          data: '',
          type: "get",
          success: function(html) {
            if (html != "NA") {
              var s = jQuery.parseJSON(html);
              $.each(s, function(i) {
                opton += '<option value="' + s[i]['min_id'] + '">' + s[i]['min_name'] + '</option>';
              });
              $('#mid').append(opton);
              //$('#city').append("<option value=''>Please Select State</option>");

              //var json = $.parseJSON(html);
              //var ayy = json[0].name;
              //var ayys = json[0].pincode;
            } else {
              alert('No Minor category Found');
              return false;
            }

          }

        })
      }


    })
  });
</script>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor

  // instance, using default configuration.

  CKEDITOR.replace('editor1');
  // CKEDITOR.replace( 'editor2' );
  // CKEDITOR.replace( 'editor3' );
  //
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#gst').keyup(function() {

      var price = $('#sellingprice').val();
      // alert("hello" + price);
      var gst = $('#gst').val();
      //alert('hello '+ price +"gst"+gst);

      $('#gstprice').val(price * gst / 100);

      // var sprice=$('#gstprice').val();
      var v1 = parseInt($('#sellingprice').val());
      var v2 = parseInt($('#gstprice').val());
      var v3 = v1 + v2;
      $('#sp').val(v3);

    });

  });
</script>
<script>
  $(document).ready(function() {
    $("#brand_id").change(function() {

      var vf = $(this).val();
      // alert(vf);
      // var yr = $("#year_id option:selected").val();
      if (vf == "") {
        return false;

      } else {
        $('#car_model_id option').remove();
        var opton = "<option value=''>Please Select Car Model</option>";
        $.ajax({
          url: base_url + "dcadmin/Products/getcarmodel?isf=" + vf,
          // url:base_url+"dcadmin/Products/getMinorcategory?isl="+vf,
          data: '',
          type: "get",
          success: function(html) {
            if (html != "NA") {
              var s = jQuery.parseJSON(html);
              $.each(s, function(i) {
                opton += '<option value="' + s[i]['brand_id'] + '">' + s[i]['name'] + '</option>';
              });
              $('#car_model_id').append(opton);
              //$('#city').append("<option value=''>Please Select State</option>");

              //var json = $.parseJSON(html);
              //var ayy = json[0].name;
              //var ayys = json[0].pincode;
            } else {
              alert('No Model Found');
              return false;
            }

          }

        })
      }


    })
  });
</script>
