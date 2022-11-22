<div class="content-wrapper">
<section class="content-header">
<h1>
Doctor
</h1>
<ol class="breadcrumb">
<li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
<li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Doctor </a></li>
<li class="active">View Doctor</li>
</ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">
<a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/doctor/add_doctor" role="button" style="margin-bottom:12px;"> Add Doctor</a>
<div class="panel panel-default">
<div class="panel-heading">
<h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Doctor</h3>
</div>
<div class="panel panel-default">

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
<div class="box-body table-responsive no-padding">
<table class="table table-bordered table-hover table-striped">
<thead>
<tr>
<th>#</th>
<th>Name (English)</th>
<th>Name (Hindi)</th>
<th>Name (Punjabi)</th>
<th>Email</th>
<th>Aadhar Upload</th>
<th>Type</th>
<th>Vet </th>
<th>Private Practitioner</th>


<th>Degree (English</th>
<th>Degree (Hindi)</th>
<th>Degree (Punjabi)</th>
<th>Experiance</th>
<th>Assistant</th>

<th>Fees</th>

<th>Comission</th>

<th>Education Qualification</th>
<th>District (English)</th>
<th>District (Hindi)</th>
<th>District (Punjabi)</th>
<th>State</th>
<th>City</th>
<th>Phone Number</th>
<th>Status</th>
<th>Status</th>

<th>Action</th>
</tr>
</thead>
<tbody>
<?php $i=1; foreach($doctor_data->result() as $data) { ?>
<tr>
<td><?php echo $i ?> </td>
<td><?php echo $data->name_english ?></td>
<td><?php echo $data->name_hindi ?></td>
<td><?php echo $data->name_punjabi ?></td>

<td><?php echo $data->email ?></td>
<td>
    <?php if($data->image!=""){  ?>
<img id="slide_img_path" height=50 width=100  src="<?php echo base_url().$data->image ?>" >
<?php }else {  ?>
Sorry No image Found
<?php } ?>
  </td>
<td><?php echo $data->type ?></td>
<td><?php $vet = $data->vet;

if($vet == 1){
  echo "Yes";
}
else{
  echo "No";
}



?></td>


<!-- <td><?php echo $data->private_practitioner ?></td> -->
<td><?php $da = $data->private_practitioner;

if($da == 1){
  echo "Yes";
}
else{
  echo "No";
}



?></td>



<td><?php echo $data->degree_english ?></td>
<td><?php echo $data->degree_hindi ?></td>
<td><?php echo $data->degree_punjabi ?></td>

<td><?php echo $data->experience ?></td>
<td><?php echo $data->assistant ?></td>
<td><?php echo $data->fees ?></td>

<td><?php echo $data->comission ?></td>

<td><?php echo $data->education_qualification	 ?></td>
<td><?php echo $data->district_english ?></td>
<td><?php echo $data->district_hindi ?></td>
<td><?php echo $data->district_punjabi ?></td>

<td><?php $cid = $data->state;
$this->db->select('*');
            $this->db->from('all_states');
            $this->db->where('id',$cid);
            $dsa= $this->db->get();
            $da=$dsa->row();
            if(!empty($da))
            {
                echo $da->state_name;
            }

 ?></td>

<td><?php $cid = $data->city;
$this->db->select('*');
            $this->db->from('all_cities');
            $this->db->where('id',$cid);
            $dsa= $this->db->get();
            $da=$dsa->row();
            if(!empty($da))
            {
                echo $da->city_name;
            }

 ?></td>
<td><?php echo $data->phone_number ?></td>

<td><?php if($data->is_active2==1){ ?>
<p class="label bg-yellow" >Normal</p>

<?php } else { ?>
<p class="label bg-green" >expert</p>


<?php		}   ?>
</td>

<td><?php if($data->is_active==1){ ?>
<p class="label bg-yellow" >pending</p>

<?php } else { ?>
<p class="label bg-green" >Approve</p>


<?php		}   ?>
</td>
<td>
<div class="btn-group" id="btns<?php echo $i ?>">
<div class="btn-group">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
<ul class="dropdown-menu" role="menu">

<?php if($data->is_active==1){ ?>
<li><a href="<?php echo base_url() ?>dcadmin/doctor/updatedoctorStatus/<?php echo base64_encode($data->id) ?>/inactive">Approve</a></li>
<?php } else { ?>
<?php		}   ?>


<?php if($data->is_active2==1){ ?>
<li><a href="<?php echo base_url() ?>dcadmin/Doctor/add_fees_doctor/<?php echo base64_encode($data->id) ?>/inactive">Convert into expert doctor</a></li>
<?php } else { ?>
<!-- <li><a href="<?php echo base_url() ?>dcadmin/Doctor/updateDoctorStatus2/<?php echo base64_encode($data->id) ?>/active">Active</a></li> -->
<?php		}   ?>





<li><a href="<?php echo base_url() ?>dcadmin/doctor/update_doctor/<?php echo base64_encode($data->id) ?>">Edit</a></li>
<li><a href="<?php echo base_url() ?>dcadmin/doctor/set_comission_doctor/<?php echo base64_encode($data->id) ?>">Set Comission percentage</a></li>
<!-- <li><a href="<?php echo base_url() ?>dcadmin/doctor/add_fees_doctor/<?php echo base64_encode($data->id) ?>">	Convert into expert doctor</a></li> -->
<li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li>
</ul>
</div>
</div>

<div style="display:none" id="cnfbox<?php echo $i ?>">
<p> Are you sure delete this </p>
<a href="<?php echo base_url() ?>dcadmin/doctor/delete_doctor/<?php echo base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
<a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
</div>
</td>
</tr>
<?php $i++; } ?>
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
label{
margin:5px;
}
</style>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
<script type="text/javascript">

$(document).ready(function(){
$('#userTable').DataTable({
responsive: true,
// bSort: true
});

$(document.body).on('click', '.dCnf', function() {
var i=$(this).attr("mydata");
console.log(i);

$("#btns"+i).hide();
$("#cnfbox"+i).show();

});

$(document.body).on('click', '.cans', function() {
var i=$(this).attr("mydatas");
console.log(i);

$("#btns"+i).show();
$("#cnfbox"+i).hide();
})

});

</script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->
