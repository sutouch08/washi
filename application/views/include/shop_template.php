<?php if($this->session->userdata("id_user") == null){ redirect(base_url()."authentication"); } ?>
<?php if(must_check_in()){ $check_in = "<span class='badge badge-danger'><i class='fa fa-exclamation-triangle'></i></span>"; }else{ $check_in = ""; } ?>
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

<body style='padding-top:0px;' onLoad="isCheckIn();">
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
            <li><a href="<?php echo valid_menu(18, "shop/order"); ?>"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;ออเดอร์</a></li>
             <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>&nbsp;ลูกค้า</a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo valid_menu(19, "shop/customer"); ?>"><i class="fa fa-users"></i>&nbsp;เพิ่ม/แก้ไข ลูกค้า</a></li>
                    <li><a href="<?php echo valid_menu(20, "shop/package"); ?>"><i class="fa fa-tag"></i>&nbsp;ซื้อแพ็คเกจ</a></li>  
                  </ul>
            </li>
             <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-truck"></i>&nbsp; การจัดส่ง</a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo valid_menu(21, "shop/delivery"); ?>"><i class="fa fa-truck"></i>&nbsp;เพิ่ม/แก้ไข การจัดส่ง</a></li>
                    <li><a href="<?php echo valid_menu(22, "shop/receive"); ?>"><i class="fa fa-truck"></i>&nbsp; รับสินค้าคืน</a></li>  
                  </ul>
            </li>
            <li><a href="<?php echo valid_menu(23, "shop/finished"); ?>"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp; เสร็จสิ้น</a></li>
       <!--     <li><a href="<?php echo valid_menu(24, "shop/report"); ?>"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp; รายงาน</a></li> -->
          </ul>
          <ul class='nav navbar-top-links navbar-right'>
          		<li><a style='color:#FFF; background-color:transparent;' href="<?php echo base_url(); ?>doc/index.php" target="_blank"><i class='fa fa-book'></i> Userguide</a></li>
          		<li><a style='color:#FFF; background-color:transparent;' href="<?php echo base_url(); ?>shop/check_in/index/<?php echo $this->session->userdata("id_employee"); ?>/<?php echo $this->session->userdata("id_shop"); ?>">
                <i class='fa fa-clock-o'></i>&nbsp; ลงเวลา <span class='badge badge-danger' id="alert_badge" style="display:none"><i class='fa fa-exclamation-triangle'></i></span></a></li>
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
 <div class="row" id="alert" style="display:none;">
 <div class="col-lg-12" style="background:#FFCE54; padding-top:5px; padding-bottom:5px; margin-bottom:15px; margin-top:-20px; text-align:center"> 
 <span style="color:red; font-size:16px;">ได้เวลาบันทึกเวลาแล้ว</span>
 </div>
 </div>
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

function isCheckIn(){
	$.ajax({
		url: "<?php echo base_url()."shop/check_in/isCheckIn"; ?>",
		type:"POST",cache:false,
		success: function(i){
			if(i ==1){
				$("#alert").css("display","");
				$("#alert_badge").css("display","");
			}else{
				$("#alert").css("display","none");
				$("#alert_badge").css("display","none");
			}
		}
	})
}


setInterval(function(){ isCheckIn() }, 300000); // เช็คทุ 5 นาที

</script>
</body>
</html>