<?php if($this->session->userdata("id_user") == null){ redirect(base_url()."authentication"); } ?>
<!DOCTYPE HTML>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../favicon.ico" />
    <title><?php if(isset($page_title)) { echo $page_title; }else{ echo getShopName($this->session->userdata("id_shop")); } ?></title>

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
                <a class="navbar-brand" href="<?php echo base_url(); ?>"><i class="fa fa-random"></i></a>
            </div>
            <!-- /.navbar-header -->
            <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            <li><a href="<?php echo valid_menu(25, "factory/index"); ?>"><i class="fa fa-home"></i>&nbsp; Factory</a></li>
             <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-truck"></i>&nbsp; การจัดส่ง</a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo valid_menu(26, "factory/delivery"); ?>"><i class="fa fa-truck"></i>&nbsp;เพิ่ม/แก้ไข การจัดส่ง</a></li>
                    <li><a href="<?php echo valid_menu(27, "factory/receive"); ?>"><i class="fa fa-truck"></i>&nbsp; รับสินค้าเข้า</a></li>  
                  </ul>
            </li>
            <li><a href="<?php echo valid_menu(28, "factory/finish"); ?>"><i class="fa fa-home"></i>&nbsp; ซักเสร็จแล้ว</a></li>
            <!-- <li><a href="<?php echo valid_menu(29, "factory/finish"); ?>"><i class="fa fa-home"></i>&nbsp; รายงาน</a></li> -->
          </ul>
          <ul class='nav navbar-top-links navbar-right'>
            	<li><a style='color:#FFF; background-color:transparent;' href="<?php echo base_url(); ?>authentication/logout"><i class='fa fa-sign-out'></i> ออกจากระบบ</a></li>
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
<div id="loader" style="position:absolute; padding: 15px 25px 15px 25px; background-color:#fff; opacity:0.0; box-shadow: 0px 0px 25px #CCC; top:-20px; display:none;">
        <center><i class="fa fa-spinner fa-5x fa-spin blue"></i></center><center>กำลังทำงาน....</center>
</div> 
<script>
function load_in(){
	var x = ($(document).innerWidth()/2)-50;
	$("#loader").css("display","");
	$("#loader").css("left",x);
	$("#loader").animate({opacity:0.8, top:300},300);		
}
function load_out(){
	$("#loader").animate({opacity:0, top:-20},300, function(){ $("#loader").css("display","none");});
}   


</script>
</body>
</html>