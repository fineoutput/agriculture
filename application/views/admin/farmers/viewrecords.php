      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                 <?
                    $farmer_ids=base64_decode($farmer_id);

                    $this->db->select('*');
                                $this->db->from('tbl_farmers');
                                $this->db->where('id',$farmer_ids);
                                $dsa_farmer= $this->db->get()->row();
                                if(!empty($dsa_farmer)){
                                    echo $dsa_farmer->name;
                                }
                               
                 ?>
                 
              </h1>
              <ol class="breadcrumb">
                  <li><a href="<? echo base_url() ?>dcadmin/Farmers/View_farmers"><i class="fa fa-dashboard"></i>Home</a></li>
                  <!-- <li class="active">Dashboard</li> -->
              </ol>
          </section>
          <!-- Main content -->
          <section class="content">
              <!-- Info boxes -->
              <div class="row">
                  <a href="<?php echo base_url() ?>dcadmin/Farmers/view_healthinfo/<?php echo $farmer_id; ?>">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="info-box">
                              <span class="info-box-icon bg-aqua"><i class="	fa fa-user-md"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">HEALTH INFO</span>
                                  <span class="info-box-number"><?= $health_info ?></span>
                              </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                      </div><!-- /.col -->
                  </a>
                  <a href="<?php echo base_url() ?>dcadmin/Farmers/view_breedingrecord/<?php echo $farmer_id; ?>">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="info-box">
                              <span class="info-box-icon bg-red"><i class="fa fa-medkit"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">BREEDING RECORD</span>
                                  <span class="info-box-number"><?= $breeding_record; ?></span>
                              </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                      </div><!-- /.col -->
                  </a>
                  <!-- fix for small devices only -->
                  <div class="clearfix visible-sm-block"></div>
                  <a href="<?php echo base_url() ?>dcadmin/Farmers/view_dailyrecords/<?php echo $farmer_id; ?>">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="info-box">
                              <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">DAILY RECORDS</span>
                                  <span class="info-box-number">
                                      <? echo $daily_records; ?>
                                      <!-- ************************************************** -->
                              </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                      </div><!-- /.col -->
                  </a>
                  <a href="<?php echo base_url() ?>dcadmin/Farmers/view_milkrecords/<?php echo $farmer_id; ?>">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="info-box">
                              <span class="info-box-icon bg-yellow"><i class="fa fa-cube"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">MILK RECORD</span>
                                  <span class="info-box-number"><?= $milk_records; ?></span>
                              </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                      </div><!-- /.col -->
                  </a>
              </div><!-- /.row -->
              <div class="row">
                  <a href="<?php echo base_url() ?>dcadmin/Farmers/view_medicalexpenses/<?php echo $farmer_id; ?>">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="info-box">
                              <span class="info-box-icon bg-black"><i class="fas fa-syringe"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">MEDICAL EXPENSES</span>
                                  <span class="info-box-number"><?= $medical_expenses ?></span>
                              </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                      </div><!-- /.col -->
                  </a>
                  <a href="<?php echo base_url() ?>dcadmin/Farmers/view_salepurchase/<?php echo $farmer_id; ?>">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="info-box">
                              <span class="info-box-icon bg-blue"><i class="fa fa-credit-card"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">VIEW SALE PURCHSE LIST</span>
                                  <span class="info-box-number"><?= $sale_purchase ?></span>
                              </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                      </div><!-- /.col -->
                  </a>
                  <a href="<?php echo base_url() ?>dcadmin/Farmers/view_stockhandling/<?php echo $farmer_id; ?>">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="info-box">
                              <span class="info-box-icon bg-blue"><i class="fas fa-calculator"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">STOCK LIST</span>
                                  <span class="info-box-number"><?= $stock_handling ?></span>
                              </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                      </div><!-- /.col -->
                  </a>
                  <a href="<?php echo base_url() ?>dcadmin/Farmers/view_tank/<?php echo $farmer_id; ?>">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                          <div class="info-box">
                              <span class="info-box-icon bg-blue"><i class="fas fa-prescription-bottle"></i></span>
                              <div class="info-box-content">
                                  <span class="info-box-text">SEMAN TANK</span>
                                  <span class="info-box-number"><?= $tank ?></span>
                              </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                      </div><!-- /.col -->
                  </a>
              </div>
          </section><!-- /.content -->


      </div><!-- /.content-wrapper -->
      </div><!-- ./wrapper -->