<div class="container">
<form method="post" action="">
<table width="50%" align="center">
<tr>
<td width="20%" align="right">CODE :</td>
<td width="65%"><input type="text" name="code" class="form-control" required autofocus /></td>
<td width="5%"></td>
<td width="10%"><input type="submit" class="form-control" value="OK" /></td>
</tr>
</table> 
</form>
 <table class="table table-hover" width="100%">
 <thead>
 <tr><td colspan="5" align="center"><h3>ตรวจสอบบาร์โค้ด</h3></td></tr>
 <tr><td width="20%" align="center">CODE</td><td width="20%">ชนิด</td><td width="20%">ชื่อ</td><td width="20%">เลขที่ออร์เดอร์</td><td width="20%" align="center">ร้าน</td></tr>
 </thead>

<?php 
	if(isset($_POST['code'])){
		$code = $_POST['code'];
	$sql ="SELECT * FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id where product_code = '$code' and tbl_order_detail.status != '17'";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	while($i<$row){
	$result = dbFetchArray($query);
	$product_id = $result['product_id'];
	$product_code = $result['product_code'];
	$customer_id = $result['customer_id'];
	$shop_id = $result['shop_id'];
	$order_no = $result['order_no'];
	list($customer_name) = dbFetchArray(dbQuery("SELECT customer_name FROM tbl_customer WHERE customer_id = '$customer_id'"));
	list($shop_name) = dbFetchArray(dbQuery("SELECT shop_name FROM tbl_shop where shop_id = '$shop_id'"));
	list($product_name) = dbFetchArray(dbQuery("SELECT product_name FROM tbl_product where product_id = '$product_id'"));
	echo "<td>$product_code</td><td>$product_name</td><td>$customer_name</td><td>$order_no</td><td>$shop_name</a>";
	$i++;
	}
	if($row == "0"){
		echo "<td colspan='5'><div class='alert alert-info'  align='center'>ไม่มีชิ้นงานที่ใช้โค้ดนี้</div></td>";
	}
	}else{
		echo "<td colspan='5'><div class='alert alert-info'  align='center'>กรุณาใส่โค้ด</div></td>";
	}
?>
</table>
</div>