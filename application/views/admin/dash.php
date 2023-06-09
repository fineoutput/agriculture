      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Version 2.0</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="	fa fa-user-md"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Normal Doctor</span>
                  <span class="info-box-number"><?= $normal ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="	fa fa-user-md"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Expert Doctor</span>
                  <span class="info-box-number"><?= $expert; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Farmers</span>
                  <span class="info-box-number">
                    <? echo $farmer; ?>
                    <!-- ************************************************** -->
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Vendor</span>
                  <span class="info-box-number"><?= $vendor; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-black"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Admin Products</span>
                  <span class="info-box-number"><?= $admin_product ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Vendor Products</span>
                  <span class="info-box-number"><?= $vendor_product ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div>
        </section><!-- /.content -->
        <section class="content-header">
          <h1>
            Service Reports
          </h1>
        </section>
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Weight Calculator</span>
                  <span class="info-box-number"><?= $service_report->weight_calculator ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="	fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">DMI Calculator</span>
                  <span class="info-box-number"><?= $service_report->dmi_calculator; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Feed Calculator</span>
                  <span class="info-box-number">
                    <? echo $service_report->feed_calculator; ?>
                    <!-- ************************************************** -->
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Pregnancy Calculator</span>
                  <span class="info-box-number"><?= $service_report->preg_calculator; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-black"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Silage Making</span>
                  <span class="info-box-number"><?= $service_report->silage_making ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Animal Requirement</span>
                  <span class="info-box-number"><?= $service_report->animal_req ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Project Requirement</span>
                  <span class="info-box-number"><?= $service_report->pro_req ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div>
        </section><!-- /.content -->



        <section class="content-header">
          <h1>
            Admin Orders
          </h1>
        </section>
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<? echo base_url()?>dcadmin/Admin_orders/all_order">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Orders</span>
                  <span class="info-box-number"><?= $total_orders ?></span>
                </div><!-- /.info-box-content -->
              </div>
    </a><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<? echo base_url()?>dcadmin/Admin_orders/new_order">
              <div class="info-box">
                <span class="info-box-icon bg-red"><i class="	fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">New Orders</span>
                  <span class="info-box-number"><? echo $new_orders; ?></span>
                </div><!-- /.info-box-content -->
              </div>
              </a><!-- /.info-box -->
            </div><!-- /.col -->
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="<? echo base_url()?>dcadmin/Admin_orders/dispatched_order">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Dispatched Orders</span>
                  <span class="info-box-number">
                    <? echo $dispatched_orders; ?>
                    <!-- ************************************************** -->
                </div><!-- /.info-box-content -->
              </div>
    </a><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-calculator"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Earnings</span>
                  <span class="info-box-number"><?= '₹'.$total_earning; ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col --> 
          </div><!-- /.row -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-black"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Doctors Earning</span>
                  <span class="info-box-number"><?= '₹'.$doctors_earning ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Vendor Earning</span>
                  <span class="info-box-number"><?= '₹'. $vendor_earning ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Payments Processed To Doctor</span>
                  <span class="info-box-number"><?= '₹'.$total_payments_processed_to_doctor ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Payments Processed To Vendor</span>
                  <span class="info-box-number"><?= '₹'.$total_payments_processed_to_vendor ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
          </div>
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-black"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Doctor Requests</span>
                  <span class="info-box-number"><?= $total_doctor_requests ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Vendor Orders</span>
                  <span class="info-box-number"><?= $total_vendor_orders ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Subscriptions Purchased</span>
                  <span class="info-box-number"><?= '₹'.$subscriptions_purchased ?></span>
                </div><!-- /.info-box-content -->
              </div><!-- /.info-box -->
            </div><!-- /.col -->
           
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      </div><!-- ./wrapper -->