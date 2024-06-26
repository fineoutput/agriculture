<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

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
        <a href="<? echo base_url() ?>dcadmin/Doctor/normel_doctors">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="	fa fa-user-md"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Normal Doctors</span>
              <span class="info-box-number"><?= $normal ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Doctor/accepted_doctors">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="	fa fa-plus-square"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Expert Doctors</span>
              <span class="info-box-number"><?= $expert; ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Farmers/View_farmers">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Farmers</span>
              <span class="info-box-number">
                <? echo $farmer; ?>
                <!-- ************************************************** -->
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Vendor/accepted_vendors">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Vendors</span>
              <span class="info-box-number"><?= $vendor; ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Products/View_products">
          <div class="info-box">
            <span class="info-box-icon bg-black"><i class="fa fa-cube"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Admin Products</span>
              <span class="info-box-number"><?= $admin_product ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Products/vendor_accepted_products">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-caret-square-o-up"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Vendor Products</span>
              <span class="info-box-number"><?= $vendor_product ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Doctor/new_doctors">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-user-md"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"> NEW DOCTOR REQUESTS</span>
              <span class="info-box-number"><?= $total_doctor_requests ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Vendor/new_vendors">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-caret-square-o-up"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"> NEW VENDOR REQUESTS</span>
              <span class="info-box-number"><?= $new ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
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
        <a href="<? echo base_url() ?>dcadmin/Home/view_service_report?type=weight_calculator">
          <div class="info-box">
            <span class="info-box-icon " style="background-color: #8d8671 !important; color: white;"><i class="fa fa-calculator"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">  Weight Calculator </span>
              <span class="info-box-number"><?= $service_report->weight_calculator ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Home/view_service_report?type=dmi_calculator">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="bi bi-arrows-move"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">DMI Calculator</span>
              <span class="info-box-number"><?= $service_report->dmi_calculator; ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Home/view_service_report?type=feed_calculator">
          <div class="info-box">
            <span class="info-box-icon   style=" background-color: #414556 !important; color: white;"><i class="bi bi-border-style"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Feed Calculator</span>
              <span class="info-box-number">
                <? echo $service_report->feed_calculator; ?>
                <!-- ************************************************** -->
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Home/view_service_report?type=preg_calculator">
          <div class="info-box">
            <span class="info-box-icon " style="background-color: #680000 !important; color: white;"><i class="bi bi-calendar2-event-fill"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Pregnancy Calculator</span>
              <span class="info-box-number"><?= $service_report->preg_calculator; ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Home/view_service_report?type=silage_making">
          <div class="info-box">
            <span class="info-box-icon " style="background-color: #680000 !important; color: white;"><i class="bi bi-shop"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Silage Making</span>
              <span class="info-box-number"><?= $service_report->silage_making ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Home/view_service_report?type=animal_req">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="bi bi-meta"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Animal Requirement</span>
              <span class="info-box-number"><?= $service_report->animal_req ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Home/view_service_report?type=pro_req">
          <div class="info-box">
            <span class="info-box-icon " style="background-color: #35bf8a !important; color: white;"><i class="bi bi-pie-chart-fill"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Project Requirement</span>
              <span class="info-box-number"><?= $service_report->pro_req ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
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
        <a href="<? echo base_url() ?>dcadmin/Admin_orders/all_order">
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
        <a href="<? echo base_url() ?>dcadmin/Admin_orders/today_order">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="bi bi-amd"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Todays Orders</span>
              <span class="info-box-number"><?= $today ?></span>
            </div><!-- /.info-box-content -->
          </div>
        </a><!-- /.info-box -->
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Admin_orders/new_order">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="bi bi-node-plus"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">New Orders</span>
              <span class="info-box-number"><? echo $new_orders; ?></span>
            </div><!-- /.info-box-content -->
          </div>
        </a><!-- /.info-box -->
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Admin_orders/accepted_order">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="bi bi-bezier"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Accepted Orders</span>
              <span class="info-box-number"><? echo $accepted_orders; ?></span>
            </div><!-- /.info-box-content -->
          </div>
        </a><!-- /.info-box -->
      </div><!-- /.col -->

      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Admin_orders/dispatched_order">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="bi bi-boxes"></i></span>
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
        <a href="<? echo base_url() ?>dcadmin/Admin_orders/completed_order">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="bi bi-brilliance"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Completed Orders</span>
              <span class="info-box-number"><? echo $delivered_orders; ?></span>
            </div><!-- /.info-box-content -->
          </div>
        </a><!-- /.info-box -->
      </div><!-- /.col -->

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Admin_orders/completed_order">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="bi bi-bullseye"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">TOTAL SALES</span>
              <span class="info-box-number"><?= '₹' . $total_earning; ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Admin_orders/completed_order">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="bi bi-bullseye"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">TOTAL COD SALES</span>
              <span class="info-box-number"><?= '₹' . $total_cod_earning; ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div>

    </div><!-- /.row -->
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Doctor/doctor_request">
          <div class="info-box">
            <span class="info-box-icon bg-black"><i class="bi bi-capsule"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Doctors Earning</span>
              <span class="info-box-number"><?= '₹' . ($total_d_orders - $doctors_earning) ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Vendor_order/completed_order">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="bi bi-cassette-fill"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Vendors Earning</span>
              <span class="info-box-number"><?= '₹' . ($total_v_orders - $vendor_earning) ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Doctor/accepted_doctors">
          <div class="info-box">
            <span class="info-box-icon" style="background-color: #5f9d69 !important; color: white;"><i class="bi bi-clipboard-data"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Payments Processed To Doctors</span>
              <span class="info-box-number"><?= '₹' . $total_payments_processed_to_doctor ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Vendor/accepted_vendors">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="bi bi-columns-gap"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Payments Processed To Vendors</span>
              <span class="info-box-number"><?= '₹' . $total_payments_processed_to_vendor ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
      <a href="<? echo base_url() ?>dcadmin/Doctor/total_doctors">
        <div class="info-box">
          <span class="info-box-icon bg-black"><i class="bi bi-diamond-half"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Doctor Requests</span>
            <span class="info-box-number"><?= $total_doctor_requests ?></span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Vendor_order/completed_order">
          <div class="info-box">
            <span class="info-box-icon " style="background-color: #663259 !important; color: white;"><i class="bi bi-discord"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Vendor Orders</span>
              <span class="info-box-number"><?= $total_vendor_orders ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
          </>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Subscription/View_subscribed_data">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="bi bi-droplet-half"></i></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Subscriptions Purchased</span>
              <span class="info-box-number"><?= '₹' . $subscriptions_purchased ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<? echo base_url() ?>dcadmin/Subscription/view_check_feed">
          <div class="info-box">
            <span class="info-box-icon " style="background-color: #4b47a3 !important; color: white;"><i class="bi bi-feather"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Check My Feed Purchased</span>
              <span class="info-box-number"><?= '₹' . $check_my_feed ?></span>
            </div><!-- /.info-box-content -->
          </div><!-- /.info-box -->
        </a>
      </div><!-- /.col -->

    </div>
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
</div><!-- ./wrapper -->