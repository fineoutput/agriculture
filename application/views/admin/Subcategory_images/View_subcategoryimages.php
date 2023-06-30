<div class="content-wrapper">
    <section class="content-header">
        <h1>
            SubCategory Images
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> All SubCategoryimages</a></li>
            <li class="active">View SubCategory_images</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <!-- <a class="btn btn-info cticket" href="<?php //echo base_url() 
                                                            ?>dcadmin/Category_images/add_Categoryimages" role="button" style="margin-bottom:12px;"> Add Category images </a> -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">View SubCategory images</h3>
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
                                           <th>S.no</th>
                                           <th>Category Name</th>
                                           <th>Name</th>
                                           <th>Image</th>
                                           <th>Image Hindi</th>
                                           <th>Image Punjabi</th>
                                           <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($subCategoryimages_data->result() as $data) { ?>
                                            <tr>
                                                <td><?php echo $i ?> </td>
                                                <td><?php $cid=$data->category_id; 
                                                        $this->db->select('*');
                                                                    $this->db->from('tbl_category_images');
                                                                    $this->db->where('id',$cid);
                                                                    $dsa_sub= $this->db->get()->row();
                                                                    if(!empty($dsa_sub)){
                                                                        echo $dsa_sub->name;
                                                                    }else{
                                                                        echo "No Category Found";
                                                                    }
                                                ?> </td>
                                                <td><?php echo $data->name; ?> </td>
                                                <td>
                                                    <?php if ($data->image != "") {  ?>
                                                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image ?>">
                                                    <?php } else {  ?>
                                                        Sorry No image Found
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($data->image_hindi != "") {  ?>
                                                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image_hindi ?>">
                                                    <?php } else {  ?>
                                                        Sorry No image Found
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($data->image_punjabi != "") {  ?>
                                                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() . $data->image_punjabi ?>">
                                                    <?php } else {  ?>
                                                        Sorry No image Found
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group" id="btns<?php echo $i ?>">
                                                        <div class="btn-group">
                                                            <a  class="btn btn-primary" href="<?php echo base_url() ?>dcadmin/Subcategory_images/update_subcategoryimages/<?php echo base64_encode($data->id) ?>">Edit</a>
                                                        </div>
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
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->