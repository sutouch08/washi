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
<div style="width:52mm; padding:2px; margin-left:auto; margin-right:auto;">
<div class="hidden-print" style="margin-bottom:10px;">
<button type="button" class="btn btn-primary btn-xs btn-block" id="btn_print"><i class="fa fa-print"></i>&nbsp; พิมพ์</button>
</div>
<?php 
	if($payment != false){
		foreach($payment as $pd){
			$discount = $pd->discount_amount;
			$received = $pd->received;
			$pay = $pd->pay;
			$change = $pd->change;
			$id_promotion = $pd->id_promotion;
			$id_employee = $pd->id_employee;
			$date = thaiDate($pd->date_upd);
		}
	}else{
			setError("ไม่พบข้อมูลยอดค้างชำระ");
			redirect($this->home);
	}

?>
<?php
	if($head != false){
		foreach($head as $rs){
			$id_order = $rs->id_order;
			$order_no = $rs->order_no;
			$shop_name = getShopName($rs->id_shop);
			$shop_phone = getShopPhone($rs->id_shop);
			$customer_name = getCustomerName($rs->id_customer);
			$employee = getEmployeeName($id_employee);
		}
	}
	
?>  
    <center><img src="<?php echo base_url()."assets/barcode/barcode.php?text=".$order_no; ?>" style='width:80%;' /></center>
    <hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
  <center><?php echo $shop_name;?></center>
  <center style="font-size:10px">Tel. #<?php echo $shop_phone;?></center>
  <hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:9px;" >
   <tr>
    <td align="left">Customer Name :</td>
    <td align="left"><?php echo $customer_name;?></td>
    </tr>
   <tr>
    <td align="left">Date :</td>
    <td align="left"><?php echo $date;?></td>
    </tr>
    <tr>
    <td align="left">Staff :</td>
    <td align="left"><?php echo $employee;?></td>
    </tr>
</table>   
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:10px;">
                	
                     <tr height="20px">
                        <td width="65%">Balance payment<td width="35%" align="right"><?php echo number($pay,2); ?></td>
                    </tr>   
                    </tr>
                    <tr height="20px">
                        <td align="right">Promotion</td><td align="right"><?php echo "- ".number($discount,2); ?></td>
                    </tr> 
                   <tr height="20px">
                        <td align="right">Received</td><td align="right"><?php echo number($received,2); ?></td>
                    </tr>
                    <tr height="20px">
                        <td align="right">Change</td><td align="right"><?php echo number($change,2); ?></td>
                    </tr>
                    <tr height="20px">
                        <td colspan="2" align="center">** <?php echo getPromotionName($id_promotion); ?> **</td>
                    </tr>
                </table>
     <hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
   <center>  THANK YOU</center>
      <hr>  
      <div class="hidden-print" style="margin-bottom:10px;">
      <a href="<?php echo $this->home; ?>">
		<button class="btn btn-success btn-xs btn-block" type="button" id="btn_back" autofocus ><i class="fa fa-reply"></i>&nbsp; กลับ </button>
      </a>
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
$("#btn_back").click(function(){
	window.location.href = "<?php echo $this->home; ?>";
});
	
</script>
</body>
</html>