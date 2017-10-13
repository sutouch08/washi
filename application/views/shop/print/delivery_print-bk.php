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
<div style="width:180mm; padding-left:10px; padding-right:10px; padding-top:0px; margin-left:auto; margin-right:auto;">
    <div class="hidden-print" style="margin-bottom:10px; text-align:right">
    <button  class='btn btn-warning' type='button' id="btn_back" style='margin-right:20px;' /><i class="fa fa-remove"></i>&nbsp; ยกเลิก</button>
    <button type="button" class="btn btn-primary" id="btn_print"><i class="fa fa-print"></i>&nbsp; พิมพ์</button>
    </div>

<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>

<?php endforeach; ?>
<?php endif; ?>

<?php 
		$row = 18;
		$count = 1;
		$total_rows = count($detail, COUNT_RECURSIVE); 
		$total_page = ceil($total_rows/$row);
		$page = 1;
		?>
<?php 
$header = "
<h4>เอกสารขนส่งสินค้า</h4>
<table align='center' style='width:100%; table-layout:fixed;'>
<tr>
<td style='width:50%; border:1px solid #AAA; padding-top:10px; padding-bottom:10px;'>
<div class='col-lg-12' style='margin-bottom:10px;'>เลขที่อ้างอิง : ". $rs->reference."</div>    
<div class='col-lg-12' style='margin-bottom:10px;'>วันที่ : ".thaiDate($rs->date_add)."</div>
<div class='col-lg-12' style='margin-bottom:10px;'>ต้นทาง : ".getShopName($rs->id_shop)."</div>
</td>
<td style='width:50%; border:1px solid #AAA; padding-top:10px; padding-bottom:10px;'>
<div class='col-lg-12' style='margin-bottom:10px;'>ปลายทาง : ".getShopName($rs->id_target)."</div> 
<div class='col-lg-12' style='margin-bottom:10px;'>ทะเบียนรถ : ".getCarPlate($rs->id_car)."</div> 
<div class='col-lg-12' style='margin-bottom:10px;'>พนักงานขับ : ".getDriverName($rs->id_driver)."</div> 
</td></tr>
</table>

<table class='table table-striped content' style='margin-top:10px; '>
<thead>
<tr><th style='width:5%; text-align:center'>ลำดับ</th><th style='width:15%;'>เลขที่อ้างอิง</th><th style='width:35%'>ลูกค้า</th><th style='width:10%; text-align:right'>จำนวน</th><th style='width:10%; text-align:right'>ยอดเงิน</th><th style='width:10%; text-align:right'>น้ำหนัก</th><th style='width:10%; text-align:center'>เงื่อนไข</th></tr>
</thead>";

function footer($total_qty="", $total_amount="", $total_weight =""){
	if($total_qty !=""){ $total_qty = number($total_qty); }
	if($total_amount !=""){ $total_amount = number($total_amount,2); }
	if($total_weight !=""){ $total_weight = number($total_weight,2); }
	$result = "<tr style='height:9mm;'><td colspan='3' align='right'>รวม</td><td align='right'> $total_qty </td><td align='right'> $total_amount</td><td align='right'>$total_weight</td><td></td></tr></table>
				<div style='page-break-after:always'>
				<table style='width:100%; border:0px;'>
				<tr><td>	<div class='col-lg-12' style='text-align:center;'>ผู้รับของ</div></td>
					<td><div class='col-lg-12' style='text-align:center;'>ผู้ส่งของ</div></td>
					<td><div class='col-lg-12' style='text-align:center;'>ผู้ตรวจสอบ</div></td>
					<td><div class='col-lg-12' style='text-align:center;'>ผู้อนุมัติ</div></td>
				</tr>
				<tr><td><div class='col-lg-12' style='border: solid 1px #AAA; font-size: 8px; border-radius:10px;'><p style='text-align:center;'>ได้รับสินค้าถูกต้องแล้ว</p><p>&nbsp;</p><p><hr style='margin:0px; border-style:dotted; border-color:#CCC;'/></p><p >วันที่...............................</p></div></td>
					<td><div class='col-lg-12' style='border: solid 1px #AAA; font-size: 8px; border-radius:10px;'><p style='text-align:center;'>&nbsp;</p><p>&nbsp;</p><p><hr style='margin:0px; border-style:dotted; border-color:#CCC;'/></p><p >วันที่...............................</p></div></td>
					<td><div class='col-lg-12' style='border: solid 1px #AAA; font-size: 8px; border-radius:10px;'><p style='text-align:center;'>&nbsp;</p><p>&nbsp;</p><p><hr style='margin:0px; border-style:dotted; border-color:#CCC;'/></p><p >วันที่...............................</p></div></td>
					<td><div class='col-lg-12' style='border: solid 1px #AAA; font-size: 8px; border-radius:10px;'><p style='text-align:center;'>&nbsp;</p><p>&nbsp;</p><p><hr style='margin:0px; border-style:dotted; border-color:#CCC;'/></p><p >วันที่...............................</p></div>
				</td></tr></table></div>
				"; return $result; }
?>        
<?php if($detail != false) : ?>
<?php $total_weight = 0; $total_amount = 0; $total_qty = 0; $n = 1;?>
<?php echo $header; ?>
<?php foreach($detail as $or) : ?>
<?php 
		$customer_name 	= getCustomerName($or->id_customer);
		$order_no 			=  $or->order_no;
		$order_qty			= orderQty($or->id_order);
		$order_amount 	= orderAmount($or->id_order);
		$order_weight		= orderWeight($or->id_order);
		$urgent				= getUrgent($or->id_urgent);
?>
<tr style="font-size:12px; height:9mm">
	<td align="center"><?php echo $n; ?></td>
	<td ><?php echo $order_no;  ?></td><td><?php echo $customer_name; ?></td>
    <td align="right"><?php echo $order_qty ?></td><td align="right"><?php echo $order_amount; ?></td>
    <td align="right" ><?php echo $order_weight; ?></td><td align="center"><?php echo $urgent; ?></td>
</tr>     
<?php $total_amount += $order_amount; $total_weight += $order_weight; $total_qty += $order_qty;  $count++; ?>
<?php if($n == $total_rows) : ?>
	<?php $ba_row = $row - $count;  	?>
	<?php $ba = 0; ?>
	<?php if($ba_row >0) : ?>
		<?php while($ba <= $ba_row) : ?>
                        <tr style="font-size:12px; height:9mm">
                            <td align="center"></td>
                            <td></td><td></td>
                            <td align="right"></td><td align="right"></td>
                            <td align="right"></td><td align="center"></td>
                        </tr>
                       <?php $ba++; $count++; ?>
           <?php endwhile; ?>
     <?php endif; ?>
      <?php echo footer($total_qty, $total_amount, $total_weight); ?>
 <?php else : ?>
      <?php if($count>$row){  $page++; echo footer().$header; $count = 1; } ?>
<?php endif; ?>         
           <?php $n++; ?>
			
<?php endforeach; ?>

<?php endif; ?>    

</table>

 
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