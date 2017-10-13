<script src="<?php echo WEB_ROOT;?>library/js/jquery-1.9.1.js"></script> 
<script src="<?php echo WEB_ROOT;?>library/js/jquery-ui-1.10.2.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo WEB_ROOT;?>library/css/jquery-ui-1.10.2.custom.css" />
</script>
<?php 
			$shop_id = $_COOKIE['shop_id'];
			$user_id = $_COOKIE['user_id'];
			$today = date('Y-m-d');
			$qrs= dbQuery("select * from tbl_shop where shop_id = '$shop_id'");
			$rss = dbFetchArray($qrs); 
			$shop_name = $rss['shop_name'];
			$qru= dbQuery("select * from tbl_user LEFT JOIN tbl_employee ON tbl_user.em_id = tbl_employee.em_id where user_id = '$user_id'");
			$rsu = dbFetchArray($qru);
			$em_name = $rsu['em_name'];
			if(isset($_POST['from_date'])&& $_POST['to_date']){
			$to_date= $_POST['to_date'];
			$from_date = $_POST['from_date']; 
			}else{
				$to_date= '';
				$from_date = '';
			}
			 ?>
 <div class="container">
   
    <script type="text/javascript">  
						$(function() {
    $( "#from_date" ).datepicker({
      dateFormat: 'dd-mm-yy',
      onClose: function( selectedDate ) {
        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to_date" ).datepicker({
      dateFormat: 'dd-mm-yy',
      onClose: function( selectedDate ) {
        $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
      </script><div class="hidden-print">
    <form method="post">
    <table border="0" width="100%"><tr><td width="15%">Select  duration from :</td><td width="15%"><input type="text" class="form-control"  name="from_date" id="from_date"   value="<?  if(isset($_POST['from_date'])&& $_POST['to_date']){ echo date('d-m-Y',strtotime($from_date));} else { echo date('d-m-Y',strtotime($today));} ?>"/></td>
    														 <td width="5%">&nbsp;&nbsp; to : </td><td width="15%"><input type="test" class="form-control"  name="to_date" id="to_date" value="<?  if(isset($_POST['from_date'])&& $_POST['to_date']){ echo date('d-m-Y',strtotime($to_date));} else { echo date('d-m-Y',strtotime($today)); } ?>" /></td><td width="3%"></td><td width="10%"><input type="submit" class="form-control"  value="View"/></td><td></td></tr></table></form></div><hr />
<div class="container">

<div class="col-md-12">

<?php
if(isset($_POST['from_date'])&& $_POST['to_date']){
		  $from_date1 = date('Y-m-d',strtotime($_POST['from_date']));
		  $from_date = "$from_date1 00:00:00";
		  $to_date1 = date('Y-m-d',strtotime($_POST['to_date']));
		  $to_date = "$to_date1 23:59:59";
		  $sql ="SELECT tbl_order.order_id,order_no,tbl_pament.order_amount,pament_deposit,promo_id,promo_amount,payment_time,paymet_received,payment_change FROM tbl_pament LEFT JOIN tbl_order ON tbl_pament.order_id = tbl_order.order_id  WHERE payment_time BETWEEN  '$from_date' AND '$to_date' and tbl_pament.shop_id = '$shop_id' ORDER BY tbl_pament.payment_id DESC";
}else{
	$sql ="SELECT tbl_order.order_id,order_no,tbl_pament.order_amount,pament_deposit,promo_id,promo_amount,payment_time,paymet_received,payment_change FROM  tbl_pament LEFT JOIN tbl_order ON tbl_pament.order_id = tbl_order.order_id  WHERE tbl_pament.shop_id = '$shop_id' and payment_time LIKE '%$today%' ORDER BY tbl_pament.payment_id DESC";
}
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	$no = 1;
	$content1 = "";
	$sum_amount1 = "";
	$sum_received1 = "";
	$sum_balance1 = "";
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$order_id = $result['order_id'];
		$order_amount = $result['order_amount'];
		$pament_deposit = $result['pament_deposit'];
		$promo_id = $result['promo_id'];
		$promo_amount = $result['promo_amount'];
		$payment_time = $result['payment_time'];
		$paymet_received = $result['paymet_received'];
		$payment_change = $result['payment_change'];
		$sum_amount = $order_amount+$promo_amount;
		$sum_received = $paymet_received-$payment_change;
		$sum_balance = $order_amount-($paymet_received-$payment_change);
		$sum_amount1 = $sum_amount1 + $sum_amount;
		$sum_received1 = $sum_received1 + $sum_received;
		$sum_balance1 = $sum_balance1 + $sum_balance;
		if($order_id != ""){
			$order_no = $result['order_no'];
		}else{
			$qr_p =dbQuery("SELECT *  FROM tbl_promo where promo_id = '$promo_id'");	
					$rs_p=mysql_fetch_array($qr_p);
			$order_no = $rs_p['promo_name'];
		}
		$content1.= "<tr><td>".$no."</td><td>".$order_no."</td><td>".$sum_amount."</td><td>".$promo_amount."</td><td>".$order_amount."</td><td>".$sum_received."</td><td>".$sum_balance."</td><td>".$payment_time."</td></tr>";
		 $i++;
		 $no++;
		}
		if($row < 1 ){
		$content1.= "<tr><td colspan='8'><div class='alert alert-success'><center>Not order</center></div></td></tr>";	
		}
?>
<table width="100%">
<tr>
<td width="30%" colspan="2"></td>
<td width="40%" colspan="4">รายงานส่งยอด</td>
<td width="30%" colspan="2">วันที่ <? if(isset($_POST['from_date'])&& $_POST['to_date']){ echo "$from_date1 ถึง$to_date1";}else{ echo $today;}?></td>
</tr>

<tr>
<td width="30%" colspan="2"></td>
<td width="40%" colspan="4">ร้าน <?=$shop_name;?></td>
<td width="30%" colspan="2">พนักงาน <?=$em_name;?></td>
</tr>
</table>
<hr />
<table width="100%">
<tr>
<td colspan="8">สรุปยอด</td>
</tr>
<tr>
<td width="20%" align="right">ยอดทั้งหมด : </td>
<td width="10%"  align="left"> <? echo $sum_amount1;?> บาท</td>
<td width="10%" align="right"></td>
<td width="10%"  align="right">ชำระเเล้ว : </td>
<td width="10%" align="left"><? echo $sum_received1;?> บาท</td>
<td width="10%"  align="left"></td>
<td width="10%" align="right">คงเหลือ : </td>
<td width="20%"  align="left"><? echo $sum_balance1;?> บาท</td>
</tr>
</table><hr />
<table width="100%">
<tr>
<td colspan="8">รายละเอียด</td>
<tr>
<tr>
<td width="10%">#</td>
<td width="10%">Order No.</td>
<td width="10%">จำนวนรวม</td>
<td width="10%">ลดไป</td>
<td width="10%">คงเหลือ</td>
<td width="10%">รับแล้ว</td>
<td width="10%">คงค้าง</td>
<td width="30%">วันที่</td>
</tr>
  <? echo $content1;?>
</table><hr />
<div class="hidden-print">

<input name="button" id="button"  class="btn btn-default btn-lg" value="Print" onclick="print();" type="button"   />&nbsp;&nbsp;
   &nbsp;&nbsp; <button type="button" class="btn btn-default btn-lg"  onclick="Shop()">Goback</button>
</div>

</div>
</div>