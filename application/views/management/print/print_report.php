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

<!-- <body style='padding-top:0px;' onLoad="javascript:window.print();setFocus()"> -->
<body style='padding-top:0px;'>
<style>
.table tbody tr td { border-top:0px; }
.content tr td { border-left:1px solid #AAA; border-right:1px solid #AAA; border-top:0px; border-bottom:0px;}
.content tr td:last-child { border-left:1px solid #AAA; border-right:1px solid #AAA;}
.content thead tr { border: 1px solid #AAA; }
.content thead tr th { border: 1px solid #AAA; }

.content tr:last-child { border:1px solid #AAA; }
</style>
<div style="width:180mm; padding-left:10px; padding-right:10px; padding-top:10px; margin-left:auto; margin-right:auto;">
    <div class="hidden-print" style="margin-bottom:10px; text-align:right">
    <button  class='btn btn-warning' type='button' id="btn_back" style='margin-right:20px;' onClick="history.back();" /><i class="fa fa-arrow-left"></i>&nbsp; กลับ</button>
    <button type="button" class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i>&nbsp; พิมพ์</button>
    </div>
<div class="row" >
<div class="col-lg-12" style="font-size:14px;" >
<center><strong><?php echo $title; ?></strong></center>
</div>
<div class="col-lg-12">
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
</div>

<div class="col-lg-12" style="font-size:10px;" >
<?php echo $data; ?>
</div>
 </div>
</div>
<script>
$("#btn_print").click(function(){
	window.print();
});

$(document).bind("keyup", function(e){
	if(e.which ==27){ /* esc key */
		$("#btn_back").click();
	}
});	

$("#btn_print").bind("enterKey",function(){
	if($(this).val() != ""){
		$("#btn_print").click();
	}
});
$("#btn_print").keyup(function(e){
	if(e.keyCode == 13)
	{
		$(this).trigger("enterKey");
	}
});	

	
</script>
</body>
</html>