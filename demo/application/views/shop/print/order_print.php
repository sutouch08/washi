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
<button type="button" class="btn btn-primary btn-block" id="btn_print"><i class="fa fa-print"></i>&nbsp; พิมพ์</button>
</div>
<?php 
	if($payment != false){
		foreach($payment as $pd){
			$discount = $pd->discount_amount;
			$received = $pd->received;
			$deposit = $pd->deposit;
			$pay = $pd->pay;
			$change = $pd->change;
			$balance = $pd->balance;
			$id_promotion = $pd->id_promotion;
			$id_employee = $pd->id_employee;
			$date = thaidate($pd->date_upd);
		}
	}else{
			$discount = 0.00;
			$received = 0.00;
			$deposit = 0.00;
			$pay = 0.00;
			$change = 0.00;
			$balance = 0.00;
			$id_promotion = 0;
			$id_employee = $this->session->userdata("id_employee");
			$date = thaidate(NOW());
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
			$order_date = thaiDate($rs->order_date);
			$due_date = thaiDate($rs->due_date);
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
    <td align="left">Due Date :</td>
    <td align="left"><?php echo $due_date; ?></td>
    </tr> 
    <tr>
    <td align="left">Staff :</td>
    <td align="left"><?php echo $employee;?></td>
    </tr>
</table>   
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-size:10px;">
                	
                    <tr>
                        <td width="50%">Items</td><td width="15%" align="right">Price</td><td width="10%" align="right">Qty</td><td width="25%" align="right">Total</td>
                    </tr>
                    <?php $total_qty = 0; $total_amount = 0; ?>
                   <?php foreach($item as $ro) : ?>
                     <tr height="20px">
                        <td><?php echo $ro->product_name; ?></td>
                        <td align="right"><?php echo number($ro->price); ?></td>
                        <td align="right"><?php echo number($ro->qty); ?></td>
                        <td align="right"><?php $amount = $ro->qty*$ro->price;  echo number($amount,1); ?></td>
                    </tr>
                     <?php $total_qty += $ro->qty;  $total_amount += $amount; ?>
					<?php endforeach; ?>
                     <tr height="20px">
                        <td colspan="2" align="right">Sub Total</td><td align="right"><?php echo number($total_qty); ?></td><td align="right"><?php echo number($total_amount,1); ?></td>
                    </tr>
                     <trheight="20px"><?php $charge_up = chargUp($id_order); ?>
                        <td colspan="2" align="right">Charge</td><td colspan="2" align="right"><?php echo number($charge_up,1); ?></td>
                    </tr>
                     <tr height="20px">
                        <td colspan="2" align="right">Grand Total</td><td colspan="2" align="right"><?php echo number($total_amount+$charge_up,1); ?></td>
                    </tr>
                    <tr height="20px">
                        <td colspan="2" align="right">Promotion</td><td colspan="2" align="right"><?php echo "- ".number($discount,1); ?></td>
                    </tr>
                    <tr height="20px">
                        <td colspan="2" align="right">Deposit</td><td colspan="2" align="right"><?php echo number($deposit,1); ?></td>
                    </tr>
                   <tr height="20px">
                        <td colspan="2" align="right">Received</td><td colspan="2" align="right"><?php echo number($received,1); ?></td>
                    </tr>
                    <tr height="20px">
                        <td colspan="2" align="right">Change</td><td colspan="2" align="right"><?php echo number($change,1); ?></td>
                    </tr>
                    <tr height="20px">
                        <td colspan="2" align="right">Balance payment</td><td colspan="2" align="right"><?php if($received == 0.00 && $deposit == 0.00){ echo number($total_amount+$charge_up,1); }else{echo number($balance,1);} ?></td>
                    </tr>
                    <tr height="20px">
                        <td colspan="4" align="center">** <?php echo getPromotionName($id_promotion); ?> **</td>
                    </tr>
                </table>
 <hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div id='seller_copy'>
    <center>&nbsp;</center>
    <center>&nbsp;</center>
    <center>&nbsp;</center>
    <center>--------------------------------------</center>
    <center>Customer Sign</center>
    <center>&nbsp;</center>
    <center> *******  Seller Copy *******</center>
</div>
<div id='customer_copy' style="display:none;">
    <center>&nbsp;</center>
    <center> *******  Customer Copy *******</center>
</div>

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
   <center>  THANK YOU</center>
 <hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
      <div class="hidden-print" style="margin-bottom:10px;">
      <a href="<?php echo $this->home; ?>">
		<button class="btn btn-success  btn-block" type="button" id="btn_back" ><i class="fa fa-reply"></i>&nbsp; กลับ </button>
      </a>
</div>
</div>
<script>
$("#btn_print").click(function(){
	window.print();
	$("#seller_copy").css("display", "none");
	$("#customer_copy").css("display", "");
});

$(document).bind("keyup", function(e){
	if(e.which ==27){ /* esc key */
		$("#btn_back").click();
	}
	if(e.which == 32){ /* space bar */
		$("#btn_print").click();
	}
});	

$("#btn_back").click(function(){
	window.location.href = "<?php echo $this->home; ?>";
});
	
</script>
</body>
</html>