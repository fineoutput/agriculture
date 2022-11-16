<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Update Image
    </h1>
    <ol class="breadcrumb">
     <li><a href="<?php echo base_url() ?>dcadmin/Home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="<?php echo base_url() ?>dcadmin/Slider/view_slider"><i class="fa fa-dashboard"></i> View Slider images</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update Image </h3>
          </div>

          <?php if (!empty($this->session->flashdata('smessage'))) {  ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('smessage');  ?>
          </div>
          <?php }
                               if (!empty($this->session->flashdata('emessage'))) {  ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <?php echo $this->session->flashdata('emessage');  ?>
          </div>
          <?php }  ?>


          <div class="panel-body">
            <div class="col-lg-10">
              <form action=" <?php echo base_url(); ?>dcadmin/Slider/add_slider_data/<?php echo base64_encode(2); ?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Image</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="image" class="form-control" placeholder="" />
                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$image_data->image ?>">
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
  $(document).ready(function() {
    $("#category").change(function() {
      // alert("hello");
      var vf = $(this).val();
      if (vf == "") {
        return false;
      } else {
        $('#subcategory option').remove();
        var opton = "<option value='0'>No Sub Category</option>";
        $.ajax({
          url: base_url + "dcadmin/Products/getSubcategory?isl=" + vf,
          data: '',
          type: "get",
          success: function(html) {
            if (html != "NA") {
              var s = jQuery.parseJSON(html);
              $.each(s, function(i) {

                opton += '<option value="' + s[i]['id'] + '">' + s[i]['name'] + '</option>';
              });
              $('#subcategory').append(opton);
            } else {
              alert('No Sub Category Found');
              return false;
            }

          }

        })
      }


    })
  });
</script>
<script type="text/javascript" src=" <?php echo base_url()  ?>assets/slider/ajaxupload.3.5.js"></script>
<link href=" <?php echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
