<?
	$qr_urgent =dbQuery("SELECT * FROM tbl_order  where status_amount = '0' and shop_id = '$shop_id'");	
	$row =mysql_num_rows($qr_urgent);
	if($row > "0"){
		echo "<div class='alert alert-danger'>
 		 <a href='index.php?content=CheckBillList' class='alert-link'>มี $row ออร์เดอร์ที่ยังไม่ได้ชำระเงิน</a>
		</div>";
	}
?>