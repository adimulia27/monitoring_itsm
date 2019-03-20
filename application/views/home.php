<!DOCTYPE html>
<html clear="all">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" href="<?php echo base_url('assets/icon/favicon.ico');?>">
        
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url('assets/plugins/fontawesome/css/font-awesome.css');?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo base_url('assets/plugins/ionicons/css/ionicons.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <!-- <link href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" /> -->
        <!-- Theme style -->
        <link href="<?php echo base_url('assets/dist/css/AdminLTE.css');?>" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins 
             folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo base_url('assets/dist/css/skins/_all-skins.css');?>" rel="stylesheet" type="text/css" />
        <!-- <link href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" /> -->
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        <!-- jQuery 2.1.3 -->
        <script src="<?php echo base_url('assets/plugins/jQuery/jQuery-2.1.3.min.js');?>"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>" type="text/javascript"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="<?php echo base_url('assets/plugins/slimScroll/jquery.slimscroll.min.js');?>" type="text/javascript"></script>    
        <!-- FastClick -->
        <!-- <script src='<?php echo base_url('assets/plugins/fastclick/fastclick.min.js');?>'></script> -->
        <!-- AdminLTE App -->
        <script src="<?php echo base_url('assets/dist/js/app.js');?>" type="text/javascript"></script>
        <!-- highcharts -->
        <script src='<?php echo base_url('assets/plugins/highcharts/code/highcharts.js');?>'></script>
        <script src='<?php echo base_url('assets/plugins/highcharts/code/modules/exporting.js');?>'></script>
        <!-- DATA TABES SCRIPT -->
       
       

        <?php
        if ($konten=='vmonrcbadqa1') {
        ?>
        <style>
        .table th {
            text-align: center; 
            background-color: #99cc00;
            color: white;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 2px solid #f7f7f7;
            font-size: 10px;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        <link href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
        <link href="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.css');?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.js');?>" type="text/javascript"></script>
        <?php
        }
        elseif ($konten=='vmonqa1final'){
        ?>
        <style>
        .table th {
            text-align: center; 
            background-color: #99cc00;
            color: white;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 2px solid #f7f7f7;
            font-size: 10px;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <?php
        }
        elseif ($konten=='vdokumen'){
        ?>
        <style>
        .table th {
            text-align: center; 
            background-color: #99cc00;
            color: white;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 2px solid #f7f7f7;
            font-size: 10px;
        }
        .form-horizontal .control-label {
            text-align: left;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <link href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
        
        <?php
        }
        elseif ($konten=='vmontranspre'){
        ?>
        <style>
        .form-horizontal .control-label {
            text-align: left;
        }
        </style>
        <link href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        <?php
        }
        elseif ($konten=='vflag') {
        ?>
        <style>
        .form-horizontal .control-label {
            text-align: left;
        }
        </style>
        <link href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        <?php
        }
        elseif ($konten=='vmonhitungbil'){
        ?>
        <style>
        .form-horizontal .control-label {
            text-align: left;
        }
        </style>
        <link href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        <?php
        }
        elseif ($konten=='vcheckinganomali309') {
        ?>
        <style>
        .table th {
            text-align: center; 
            background-color: #D9D9D9;
            color: black;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 2px solid #f7f7f7;
            font-size: 10px;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <?php    
        }
        elseif (($konten=='vcheckingparentsdetail404') or ($konten=='vchecking406') or ($konten=='vcheckingsaldoawal404dan406')) {
        ?>
        <style>
        .table th {
            text-align: center; 
            background-color: #963634;
            color: white;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 2px solid #f7f7f7;
            font-size: 10px;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <?php
        }
        elseif (($konten=='vchecking404') or ($konten=='vchecking404pal') or ($konten=='vchecking404ppnr3') or ($konten=='vchecking404ppj') or ($konten=='vcheckingkontrol404bk') or ($konten=='vchecking404ujldanbpdicicil') or ($konten=='vchecking404ts') or ($konten=='vcheckingjumlah')) {
        ?>
        <style>
        .table th {
            text-align: center; 
            background-color: #c0c0c0;
            color: black;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 2px solid #f7f7f7;
            font-size: 10px;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <?php
        }
        elseif (($konten=='vchecking309kontrol') or ($konten=='vcheckingkontrol406')) {
        ?>
        <style>
        .table th {
            text-align: center; 
            background-color: #993366;
            color: white;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 2px solid #f7f7f7;
            font-size: 10px;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <?php
        }
        elseif (($konten=='vcheckinglaplpb') or ($konten=='vcheckingpendlklamp')) {
        ?>
        <style>
        .table th {
            text-align: center; 
            background-color: #fff;
            color: black;
        }
        .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
            border: 2px solid #000;
            font-size: 10px;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <?php
        }
        elseif ($konten=='vupdatepassword') {
        ?>
        <style>
        .form-horizontal .control-label {
            text-align: left;
        }
        </style>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        
        <?php
        }
        elseif ($konten=='statistik/index' or $konten=='statistik/harian') {
        ?>
        <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
        <link href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>" type="text/javascript"></script>
        <?php
        }elseif ($konten=='vUploadExcell'){
        ?>
            <style>
            .table th {
                text-align: center; 
                background-color: #99cc00;
                color: white;
            }
            .table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
                border: 2px solid #f7f7f7;
                font-size: 10px;
            }
            
            </style>
            <script src="<?php echo base_url('assets/plugins/jqueryform/jquery.form.js');?>"></script>
            <script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>" type="text/javascript"></script>
            <script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js');?>" type="text/javascript"></script>
        <?php
        }
        ?>
        
        
    </head>
    <body class="skin-blue fixed sidebar-collapse">
        <div class="wrapper">
            <header class="main-header">
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="" class="logo"> MONITORING INCIDENT</a>
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url('assets/icon/favicon.ico');?>" class="user-image" alt="User Image"/>
                                    <span class="hidden-xs"><?php echo $this->session->userdata('nama_user'); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header">
                                        <img src="<?php echo base_url('assets/icon/favicon.ico');?>" class="img-circle" alt="User Image" />
                                        <p><?php echo $this->session->userdata('nama_user'); ?> - <?php echo $this->session->userdata('unit_up'); ?><small>Member since <?php echo $this->session->userdata('tglinsert'); ?></small></p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo base_url('home/logout');?>" class="btn btn-default btn-flat btn-block">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
      
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo base_url('assets/icon/favicon.ico');?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $this->session->userdata('nama_user'); ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>                    
         
                    <ul class="sidebar-menu">
                        <li class="header">MAIN NAVIGATION</li>

                        <li <?php if ($konten=='statistik/index') {echo "class=active";} ?>>
                            <a href="<?php echo base_url('statistik');?>"><i class="fa fa-file-archive-o"></i><span> Dashboard</span></a>
                        </li>
                        <li <?php if ($konten=='vdokumen') {echo "class=active";} ?>>
                            <a href="<?php echo base_url('home/dokumen');?>"><i class="fa fa-file-archive-o"></i><span> Managemen Dokumen</span></a>
                        </li>
                        <li <?php if ($konten=='vuploadtiket') {echo "class=active";} ?>>
                            <a href="<?php echo base_url('cexcell');?>"><i class="fa fa-file-archive-o"></i><span> Upload Tiket ITSM</span></a>
                        </li>
                    </ul>
                </section>
            </aside>

            <div class="content-wrapper">
                <?php $this->load->view($konten); ?>
            </div>

            <footer class="main-footer">
                <strong>Copyright &copy; 2017 <a href="#">Operasional & Pemeliharaan Aplikasi</a>.</strong> All rights reserved.
            </footer>

        </div>
    </body>
</html>
