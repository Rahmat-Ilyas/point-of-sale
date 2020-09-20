<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
  <meta name="author" content="Coderthemes">

  <link rel="shortcut icon" href="assets/images/favicon_1.ico">

  <title>Point of Sale</title>

  <!--Morris Chart CSS -->
  <link rel="stylesheet" href="assets/plugins/morris/morris.css">
  <link href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
  <link href="assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />

  <!-- Form Select -->
  <link href="assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
  <link href="assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
  <link href="assets/plugins/multiselect/css/multi-select.css"  rel="stylesheet" type="text/css" />
  <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

  <!-- DataTables -->
  <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
  <link href="assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css"/>
  <link href="assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css"/>
  <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
  <link href="assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css"/>
  <link href="assets/plugins/datatables/dataTables.colVis.css" rel="stylesheet" type="text/css"/>
  <link href="assets/plugins/datatables/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
  <link href="assets/plugins/datatables/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css"/>

  <!-- Template -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
  <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

  <script src="assets/js/modernizr.min.js"></script>
  <script src="assets/js/jquery.min.js"></script>

</head>


<body class="fixed-left">

  <!-- Begin page -->
  <div id="wrapper">

    <!-- Top Bar Start -->
    <div class="topbar">

      <!-- LOGO -->
      <div class="topbar-left">
        <div class="text-center">
          <a href="index.html" class="logo"><i class="icon-magnet icon-c-logo"></i><span>Ub<i class="md md-album"></i>ld</span></a>
        </div>
      </div>

      <!-- Button mobile view to collapse sidebar menu -->
      <div class="navbar navbar-default" role="navigation">
        <div class="container">
          <div class="">
            <div class="pull-left">
              <button class="button-menu-mobile open-left waves-effect waves-light">
                <i class="md md-menu"></i>
              </button>
              <span class="clearfix"></span>
            </div>

            <form role="search" class="navbar-left app-search pull-left hidden-xs">
              <input type="text" placeholder="Search..." class="form-control">
              <a href=""><i class="fa fa-search"></i></a>
            </form>


            <ul class="nav navbar-nav navbar-right pull-right">
              <li class="dropdown top-menu-item-xs">
                <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><img src="assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>
                  <li><a href="javascript:void(0)"><i class="ti-settings m-r-10 text-custom"></i> Settings</a></li>
                  <li><a id="link-lock" href="#"><i class="ti-lock m-r-10 text-custom"></i> Lock screen</a></li>
                  <li class="divider"></li>
                  <li><a href="config.php?logout=true"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->

    <div class="left side-menu">
      <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
          <ul>

           <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect items" id="home">
              <i class="ti-home"></i> <span> Home </span>
            </a>
          </li>

          <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect items" id="transaksi">
              <i class="ti-shopping-cart "></i> <span> Transaksi </span> 
            </a>
          </li>

          <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="ti-harddrive"></i><span> Master Data </span> <span class="menu-arrow"></span></a>
            <ul class="list-unstyled">
              <li class="items" id="data_barang"><a href="javascript:void(0);"> Data Barang</a></li>
              <li class="items" id="barang_masuk"><a href="javascript:void(0);"> Barang Masuk</a></li>
              <li class="items" id="supplier"><a href="javascript:void(0);"> Supllier</a></li>
            </ul>
          </li>

          <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="ti-share-alt"></i><span>  Return Barang  <span class="menu-arrow"></span> </a>
            <ul class="list-unstyled">
              <li class="items" id="return_beli"><a href="javascript:void(0);"> Return Pembelian</a></li>
              <li class="items" id="return_jual"><a href="javascript:void(0);"> Return Penjualan</a></li>
            </ul>
          </li>

          <li class="has_sub">
            <a href="javascript:void(0);" class="waves-effect"><i class="ti-clipboard"></i><span> Laporan </span> <span class="menu-arrow"></span></a>
            <ul class="list-unstyled">
              <li class="items" id="laporan_transaksi"><a href="javascript:void(0);"> Laporan Transaksi</a></li>
              <li class="items" id="laporan_pembelian"><a href="javascript:void(0);"> Laporan Pembelian</a></li>
            </ul>
          </li>

        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
  <!-- Left Sidebar End -->



  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="content-page">
    <!-- Start content -->
    <div class="content">
      <div class="container" id="content">