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
            <li><a href="<?php echo valid_menu(30,"management/index"); ?>"><i class="fa fa-dashboard"></i>&nbsp;Dash Board</a></li>   
           <!-- <li><a href="<?php echo valid_menu(31,"management/report/moniter"); ?>"><i class="fa fa-heartbeat"></i>&nbsp;moniter</a></li> -->
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tags"></i>&nbsp; ยอดขาย</a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo valid_menu(31,"management/report"); ?>"><i class="fa fa-tags"></i>&nbsp;รายงานยอดขายรวม</a></li>
                <li><a href="<?php echo valid_menu(31,"management/sale_by_shop"); ?>"><i class="fa fa-tags"></i>&nbsp;รายงานยอดขายแยกตามสาขา</a></li>   
              </ul>
            </li> 
             <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-usd"></i>&nbsp; บัญชี</a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo valid_menu(31,"management/payment"); ?>"><i class="fa fa-usd"></i>&nbsp;รายงานการรับเงิน</a></li>
                <li><a href="<?php echo valid_menu(31,"management/payment/payment_by_shop"); ?>"><i class="fa fa-usd"></i>&nbsp;รายงานการรับเงิน แยกตามสาขา</a></li> 
                <li><a href="<?php echo valid_menu(31,"management/payment/payment_order"); ?>"><i class="fa fa-usd"></i>&nbsp;รายงานการรับเงิน (เฉพาะออเดอร์)</a></li>
                <li><a href="<?php echo valid_menu(31,"management/payment/payment_package"); ?>"><i class="fa fa-usd"></i>&nbsp;รายงานการรับเงิน (เฉพาะแพ็คเกจ)</a></li>
                <li><a href="<?php echo valid_menu(31,"management/payment/payment_balance"); ?>"><i class="fa fa-usd"></i>&nbsp;รายงานยอดเงินค้างรับ</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo valid_menu(31,"management/package/package_balance"); ?>"><i class="fa fa-usd"></i>&nbsp;รายงานแพ็คเกจคงเหลือ</a></li>
                <li><a href="<?php echo valid_menu(31,"management/package/package_used"); ?>"><i class="fa fa-usd"></i>&nbsp;รายงานแพ็คเกจใช้ไป</a></li>  
              </ul>
            </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tasks"></i>&nbsp; ปริมาณชิ้นงาน</a>
              <ul class="dropdown-menu">
               	<li><a href="<?php echo valid_menu(31,"management/report/qty_report"); ?>"><i class="fa fa-tasks"></i>&nbsp;ปริมาณชิ้นงาน แยกตามประเภทการซัก</a></li>
                <li><a href="<?php echo valid_menu(31,"management/report/qty_by_shop"); ?>"><i class="fa fa-tasks"></i>&nbsp;ปริมาณชิ้นงาน แยกตามสาขา(ส่วนของโรงงาน)</a></li> 
                <li><a href="<?php echo valid_menu(31,"management/report/qty_shop_report"); ?>"><i class="fa fa-tasks"></i>&nbsp;ปริมาณชิ้นงาน แยกตามสาขา(ส่วนของสาขา)</a></li> 
              </ul>
            </li> 
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-users"></i>&nbsp; พนักงาน</a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo valid_menu(31,"management/user"); ?>"><i class="fa fa-users"></i>&nbsp;ตารางบันทึกเวลา</a></li>
                <li><a href="<?php echo valid_menu(31,"management/user/time_recorded_report"); ?>"><i class="fa fa-users"></i>&nbsp;รายงานการบันทึกเวลาของพนักงาน</a></li>   
              </ul>
            </li> 
           </ul>
          <ul class='nav navbar-top-links navbar-right'>
          		<li><a style='color:#FFF; background-color:transparent;' href="<?php echo base_url(); ?>userguide/index" target="_blank"><i class='fa fa-book'></i> Userguide</a></li>
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