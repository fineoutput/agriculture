<div class="content-wrapper">
  <section class="content-header">
    <h1>
      View All Farmers
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View All Farmers</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <!-- <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/Farmers/add_farmers" role="button"style="margin-bottom:12px;"> Add Farmers</a> -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-users"></i> View Farmers</h3>
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
                <table class="table table-bordered table-hover table-striped" id="dataTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name </th>
                      <th>Village </th>
                      <th>State</th>
                      <th>District </th>
                      <th>City</th>
                      <th>Pincode</th>
                      <th>No. of Animals</th>
                      <th>Phone</th>
                      <th>Status</th>
                      <th>COD</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1;
                    foreach ($farmers_data->result() as $data) { ?>
                      <tr>
                        <td><?php echo $i ?> </td>
                        <td><?php echo $data->name ?></td>
                        <td><?php echo $data->village ?></td>
                        <td><?php $st = $data->state;
                            $this->db->select('*');
                            $this->db->from('all_states');
                            $this->db->where('id', $st);
                            $dsa = $this->db->get();
                            $da = $dsa->row();
                            if (!empty($da)) {
                              echo $da->state_name;
                            }
                            // echo $st;
                            ?></td>
                        <td><?php echo $data->district ?></td>
                        <td><?php $ct = $data->city;
                            // $this->db->select('*');
                            // $this->db->from('all_cities');
                            // $this->db->where('id', $ct);
                            // $dsa = $this->db->get();
                            // $da = $dsa->row();
                            // if (!empty($da)) {
                            //   echo $da->city_name;
                            // }
                            echo $ct;
                            ?></td>
                        </td>
                        <td><?php echo $data->pincode ?></td>
                        <td><?php echo $data->no_animals ?></td>
                        <td><?php echo $data->phone ?></td>
                        <td><?php if ($data->is_active == 1) { ?>
                            <p class="label bg-green">Unblocked</p>
                          <?php } else { ?>
                            <p class="label bg-yellow">Blocked</p>
                          <?php    }   ?>
                        </td>
                        <td><?php $gf_id = $data->giftcard_id;
                        $this->db->select('*');
                        $this->db->from('gift_card');
                        $this->db->where('id',$gf_id);
                        $dsa= $this->db->get()->row();
                        if(!empty($dsa)){
                        ?>
                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() .'assets/uploads/gift_card/' .$dsa->image ?>"> 
                        <?
                        }
                        ?></td>
                        <td>
                          <input type="checkbox" class="mycheckbox" id="myCheckbox" data-id="<?php echo $data->id ?>"  name="checkbox" <?php echo ($data->cod == 1) ? 'checked' : ''; ?>>
                        </td>
                        <td>
                          <div class="btn-group" id="btns<?php echo $i ?>">
                            <div class="btn-group">
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
                              <ul class="dropdown-menu" role="menu">
                                <?php if ($data->is_active == 1) { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/Farmers/updateFarmersStatus/<?php echo base64_encode($data->id) ?>/inactive">Block</a></li>
                                <?php } else { ?>
                                  <li><a href="<?php echo base_url() ?>dcadmin/Farmers/updateFarmersStatus/<?php echo base64_encode($data->id) ?>/active">Unblock</a></li>
                                <?php    }   ?>
                                <!-- <li><a href="<?php echo base_url() ?>dcadmin/Farmers/update_farmers/<?php echo base64_encode($data->id) ?>">Edit</a></li> -->
                                <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li>
                                <li><a href="<?php echo base_url() ?>dcadmin/Farmers/viewrecords/<?php echo base64_encode($data->id) ?>">View Records</a></li>
                              </ul>
                            </div>
                          </div>
                          <div style="display:none" id="cnfbox<?php echo $i ?>">
                            <p> Are you sure delete this </p>
                            <a href="<?php echo base_url() ?>dcadmin/Farmers/delete_farmers/<?php echo base64_encode($data->id); ?>" class="btn btn-danger">Yes</a>
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
<!-- //===========================order excel====================================\\ -->
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<!-- <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script type="text/javascript">
  // buttons: [
  //     'copy', 'csv', 'excel', 'pdf', 'print'
  // ]
  $(document).ready(function() {
    $('#dataTable').DataTable({
      responsive: true,
      "bStateSave": true,
      "fnStateSave": function(oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function(oSettings) {
        return JSON.parse(localStorage.getItem('offersDataTables'));
      },
      dom: 'Bfrtip',
      buttons: [{
          extend: 'copyHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8] //number of columns, excluding # column
          }
        },
        {
          extend: 'csvHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8]
          }
        },
        {
          extend: 'excelHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8]
          }
        },
        {
          extend: 'pdfHtml5',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8]
          }
        },
        {
          extend: 'print',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7, 8]
          }
        },
      ]
    });
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
                    url: '<?php echo base_url('dcadmin/Farmers/store_cod_data'); ?>',
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