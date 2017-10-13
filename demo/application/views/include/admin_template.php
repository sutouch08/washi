<?php if($this->session->userdata("id_user") == null){ redirect(base_url()."authentication"); } ?>
<!DOCTYPE HTML>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../favicon.ico" />
    <title>Admin Dashboard</title>

    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/paginator.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/bootflat.min.css" rel="stylesheet">
     <link rel="stylesheet" href="<?php  echo base_url();?>assets/css/jquery-ui-1.10.4.custom.min.css" />
     <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
    
  	<script src="<?php  echo base_url();?>assets/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/iCheck/icheck.js"></script>
     
    
    
    <!-- SB Admin CSS - Include with every page -->
    <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/template.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/js/iCheck/skins/all.css?v=1.0.2" rel="stylesheet">
   

</head>

<body style='padding-top:0px;'>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style='position:relative;'>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url();?>"><i class="fa fa-random"></i></a>
            </div>
            <!-- /.navbar-header -->
            <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-folder-open"></span>&nbsp; สินค้า</a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo valid_menu(2,"admin/product"); ?>"><span class="glyphicon glyphicon-tasks"></span>&nbsp;เพิ่ม/แก้ไข สินค้า</a></li>
                <li><a href="<?php echo valid_menu(3,"admin/category"); ?>"><span class="glyphicon glyphicon-bookmark"></span>&nbsp;เพิ่ม/แก้ไข ประเภทการซัก</a></li>
                <li><a href="<?php echo valid_menu(4,"admin/type"); ?>"><span class="glyphicon glyphicon-tint"></span>&nbsp;เพิ่ม/แก้ไข หมวดหมู่สินค้า</a></li>   
              </ul>
            </li> 
             
			<li><a href="<?php echo valid_menu(5,"admin/customer"); ?>"><i class="fa fa-users"></i>&nbsp;เพิ่ม/แก้ไข ลูกค้า</a></li>                    
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gears"></i>&nbsp;กำหนดค่า</a>
              <ul class="dropdown-menu">
              	<li><a href="<?php echo valid_menu(6,"admin/config"); ?>"><i class="fa fa-gear"></i>&nbsp;กำหนดค่าทั่วไป</a></li>
                <li><a href="<?php echo valid_menu(7,"admin/promotion"); ?>"><i class="fa fa-flash"></i>&nbsp;เพิ่ม/แก้ไข โปรโมชั่น</a></li>
                <li><a href="<?php echo valid_menu(8,"admin/shop"); ?>"><i class="fa fa-home"></i>&nbsp;เพิ่ม/แก้ไข สำนักงาน</a></li>
                <li><a href="<?php echo valid_menu(9,"admin/employee"); ?>"><i class="fa fa-users"></i>&nbsp;เพิ่ม/แก้ไข พนักงาน</a></li>
                <li><a href="<?php echo valid_menu(10,"admin/set_time"); ?>"><i class="fa fa-clock-o"></i>&nbsp;เพิ่ม/แก้ไข ตารางเวลา</a></li>
                <li><a href="<?php echo valid_menu(11,"admin/user"); ?>"><i class="fa fa-user"></i>&nbsp;เพิ่ม/แก้ไข ผู้ใช้งาน</a></li> 
                <li><a href="<?php echo valid_menu(12,"admin/profile"); ?>"><i class="fa fa-leaf"></i>&nbsp;เพิ่ม/แก้ไข โปรไฟล์</a></li>
                <li><a href="<?php echo valid_menu(13,"admin/permission"); ?>"><i class="fa fa-lock"></i>&nbsp;กำหนดสิทธิ์</a></li>
              </ul>
            </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-truck"></i>&nbsp;ขนส่ง</a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo valid_menu(14,"admin/car"); ?>"><i class="fa fa-truck"></i>&nbsp;เพิ่ม/แก้ไขรถ</a></li>
                <li><a href="<?php echo valid_menu(15,"admin/driver"); ?>"><i class="fa fa-user"></i>&nbsp;เพิ่ม/แก้ไข พนักงานขับรถ</a></li>                
              </ul>
            </li>
             
           <!--  <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-stats"></span>&nbsp;รายงาน</a>
              <ul class="dropdown-menu">
                 <li><a href="<?php echo valid_menu(16,"admin/driver"); ?>"><i class='fa fa-th'></i>&nbsp;รายงานสินค้าคงเหลือปัจจุบัน</a></li>          -->   
              </ul>
            </li>
          </ul>
          <ul class='nav navbar-top-links navbar-right'>
            	<li><a style='color:#FFF; background-color:transparent;' href="<?php echo base_url(); ?>authentication/logout"><i class='fa fa-sign-out'></i> Sign out</a></li>
			</ul>
           </div> 
        </nav>
   </div>

 <?php if($this->session->flashdata("error") != null) : ?>
 <div class="container">
 <div class="row">
 <div class="col-lg-12"> 
 <div class="alert alert-danger alert-dismissiblle" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo $this->session->flashdata("error"); ?>
 </div></div></div></div>
 <?php endif; ?>
<div class="starter-template">
  <?php   $this->load->view($view); ?>
</div>

</body>
</html>