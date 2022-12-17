        <div class="content-wrapper">
          <section class="content-header">
            <h1>
              Order Details
            </h1>
            <ol class="breadcrumb">
              <li><a href="<?php echo base_url() ?>dcadmin/Home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <?php if ($status==1){?>
              <li><a href="<?php echo base_url() ?>dcadmin/Order/view_order"><i class="fa fa-undo" aria-hidden="true"></i> View New Orders </a></li>
              <?}?>
              <?php if ($status==2){?>
              <li><a href="<?php echo base_url() ?>dcadmin/Order/accepted_order"><i class="fa fa-undo" aria-hidden="true"></i> View Accepted Orders</a></li>
              <?}?>
              <?php if ($status==3){?>
              <li><a href="<?php echo base_url() ?>dcadmin/Order/dispatched_order"><i class="fa fa-undo" aria-hidden="true"></i> View Dispatched Orders </a></li>
              <?}?>
              <?php if ($status==4){?>
              <li><a href="<?php echo base_url() ?>dcadmin/Order/completed_order"><i class="fa fa-undo" aria-hidden="true"></i> View Completed Orders </a></li>
              <?}?>
              <?php if ($status==5){?>
              <li><a href="<?php echo base_url() ?>dcadmin/Order/cancelled_order"><i class="fa fa-undo" aria-hidden="true"></i> View Rejected Orders </a></li>
              <?}?>
              <li class="active"></li>
            </ol>
          </section>
          <section class="content">
            <div class="row">
              <div class="col-lg-12">
                <!-- <a class="btn custom_btn" href="<?php echo base_url() ?>dcadmin/order/add_order" role="button" style="margin-bottom:12px;"></a> -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View order</h3>
                  </div>
                  <div class="panel panel-default">

                    <?php if (!empty($this->session->flashdata('smessage'))) { ?>
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-check"></i> Alert!</h4>
                      <?php echo $this->session->flashdata('smessage'); ?>
                    </div>
                    <?php }
                                                              if (!empty($this->session->flashdata('emessage'))) { ?>
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                      <?php echo $this->session->flashdata('emessage'); ?>
                    </div>
                    <?php } ?>


                    <div class="panel-body">
                      <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover table-striped" id="userTable">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Product Name</th>
                              <th>Size</th>
                              <th>Color</th>
                              <?if ($order_type==1) {?>
                              <th>Model Name</th>
                              <?}?>
                              <th>Quantity</th>
                              <th>Selling Price</th>
                              <th>Total Amount</th>
                              <?if ($order_type==1) {?>
                              <th>Reference Code</th>
                              <?}?>

                            </tr>
                          </thead>
                          <tbody>
                            <?php $i=1; foreach ($order2_data->result() as $data) {
                              // $type_data = $this->db->get_where('tbl_type', array('id = ' => $data->type_id))->result();
                                   if(!empty($type_data)){
                                    $sizeOfType = $this->db->get_where('tbl_size', array('id = ' => $type_data[0]->size_id))->result();
                                    $colorOfType = $this->db->get_where('tbl_colour', array('id = ' => $type_data[0]->colour_id))->result();
                                  }else{
                                    $sizeOfType = [];
                                    $colorOfType = [];
                                  }
                              ?>
                            <tr>
                              <td><?=$i?> </td>
                              <td><?php   $this->db->select('*');
                                                $this->db->from('tbl_product');
                                                $this->db->where('id', $data->product_id);
                                                $product_data= $this->db->get()->
                                                row();
                                                if (!empty($product_data)) {
                                                    echo $product_data->name;
                                                }
                                                 ?></td>
                                                 <td>  <?if(!empty($sizeOfType)){echo $sizeOfType[0]->name;}else{echo "NA";}?> </td>
                                                 <td>  <?if(!empty($colorOfType)){?><span style="background-color:<?php echo $colorOfType[0]->name ?>;border-radius:50%">&nbsp&nbsp&nbsp&nbsp</span>
                                                   <?echo $colorOfType[0]->colour_name;}else{echo "NA";}?> </td>
                              <?if ($order_type==1) {?>

                              <td><?php if (!empty($data->user_id)) {
                                                     $this->db->select('*');
                                                     $this->db->from('tbl_users');
                                                     $this->db->where('id', $data->user_id);
                                                     $users_data= $this->db->get()->row();
                                                     echo $users_data->f_name; ?><?=$users_data->l_name;
                                                 } else {
                                                     echo 'NA';
                                                 }?></td>
                              <?}?>


                              <td><?php echo $data->quantity ?></td>
                              <td><?php echo "₹".$data->selling_price ?></td>
                              <td><?php echo "₹".$data->total_amount ?></td>
                              <?if ($order_type==1) {?>

                              <td><?php   if (!empty($data->reference_code)) {
                                                     echo $data->reference_code;
                                                 } else {
                                                     echo 'NA';
                                                 }
                                                 ?></td>
                              <?}?>

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
          label {
            margin: 5px;
          }
        </style>
        <script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
        <script type="text/javascript">
          $(document).ready(function() {


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
