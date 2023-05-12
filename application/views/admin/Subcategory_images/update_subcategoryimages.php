<div class="content-wrapper">
  <section class="content-header">
    <h1>
        <?
    echo $subcategory_images->name;
    ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/"><i class="fa fa-dashboard"></i> Home</a></li>
       <li><a href="<?php echo base_url() ?>dcadmin/Category_images/view_Categoryimages"><i class="fa fa-dashboard"></i> All Category images </a></li> 
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
           
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
              <form action="<?php echo base_url() ?>dcadmin/subcategory_images/add_subcategoryimages_data/<? echo base64_encode(2); ?>/<? echo $id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                  
                    <tr>
                      <td> <strong>Image</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="file" name="image" class="form-control" placeholder=""  value="" />
                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $subcategory_images->image ?>">
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