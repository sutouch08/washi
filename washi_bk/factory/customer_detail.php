<div class="container">
<div class="col-sm-12">
<?
if(isset($_GET['check_code'])){
$check_code = $_GET['check_code'];
if($check_code == "N"){
echo "<div class='alert h4 alert-danger'><center>Code ซ้ำ</center></div>";
}else if($check_code == "Y"){
echo "<div class='alert alert-success'>บันทึกเรียบร้อยแล้ว</div>";	
}
}else{
}
?>
<form method="post" name="edit" action="submit_customer.php">
<?
$shop_id = $_COOKIE['shop_id'];
$customer_id = $_GET['customer_id'];
$sql = "SELECT * FROM tbl_customer where shop_id = '$shop_id' and customer_id = '$customer_id' ORDER BY customer_name ASC";
		$result = dbQuery($sql);
        $data = dbFetchArray($result);
		$customer_id = $data['customer_id'];
		$customer_code = $data['customer_code'];
		$customer_name = $data['customer_name'];
		$customer_phone = $data['customer_phone'];
		$customer_address = $data['customer_address'];
		$customer_email = $data['customer_email'];
		$sql1 = "SELECT * FROM tbl_member where mem_code = '$customer_code'";
		$result1 = dbQuery($sql1);
        $data1 = dbFetchArray($result1);
		$mem_id = $data1['mem_id'];
        ?>
        <input type="hidden" name="customer_id" value="<?=$customer_id;?>" />
<table width="100%">
<tr height="50">
<td width="10%" align="right">ชื่อ : </td>
<td width="40%" ><input type="text" name="customer_name" value="<?=$customer_name;?>" class="form-control"></td>
<td width="10%" align="right">Code : </td>
<td width="40%"><input type="text" name="customer_code" value="<?=$customer_code;?>" class="form-control"></td>
</tr>
<tr height="50">
<td align="right">Email : </td>
<td align="right"><input type="text" name="customer_email" value="<?=$customer_email;?>" class="form-control"></td>
<td align="right">Tel. : </td>
<td><input type="text" name="customer_phone" value="<?=$customer_phone;?>" class="form-control"></td>
</tr>
<tr height="50">
<td align="right">Address : </td> 
<td colspan="2"><input type="text" name="customer_address" value="<?=$customer_address;?>" class="form-control"></td>
<td align="right"><button type="submit" class='btn btn-default' />ตกลง</td>
</tr>
</table>
</form>
<br>
<hr>
<br>
  <table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="30%"><h4>โปรโมชั่น</h4></td><td width="10%"><h4>เริ่ม</h4></td><td width="10%"><h4>หมด</h4></td><td width="10%"><h4>ระยะเวลา</h4></td><td width="10%"><h4>จำนวน(ชิ้น)</h4></td><td width="5%"><h4>จำนวน(บาท)</h4></td><td width="5%"><h4>ส่วนลด</h4></td><td width="10%"><h4>ราคา</h4></td><td width="5%"></td></tr></thead>
    
      <?php 
	    $sql = "SELECT tbl_promo.promo_id,promo_name,promo_duration,promo_pcs,promo_money,promo_discount,promo_price,DATE_FORMAT(promo_start, '%d-%m-%Y') AS promo_start,DATE_FORMAT(promo_end, '%d-%m-%Y') AS promo_end FROM tbl_promo LEFT JOIN tbl_member_detail ON tbl_promo.promo_id = tbl_member_detail.promo_id where promo_price != '0' and mem_id = '$mem_id' ORDER BY tbl_promo.promo_id ASC";
		$result = dbQuery($sql);
		$row = dbNumRows($result);
		if($row<1){
							echo "<tr><td colspan='9'><h3><div class='alert alert-success'>ยังไม่มีโปรโมชัน</div></h3></td></tr>
									 <tr><td colspan='9'><button type='button' class='btn btn-default' onclick='backHome()' value='Go Back' />Go back</td></tr>";
} else{ 
		$i=0;
		$no=1;
		while($i<$row){
		$data = dbFetchArray($result);
		$promo_id = $data['promo_id'];
		$promo_name = $data['promo_name'];
		$promo_start = $data['promo_start'];
		$promo_end = $data['promo_end'];
		$promo_duration = $data['promo_duration'];
		$promo_pcs = $data['promo_pcs'];
		$promo_money = $data['promo_money'];
		$promo_discount = $data['promo_discount'];
		$promo_price = $data['promo_price'];
		
		echo  "<tr><td>";
							?>
<?	echo "".$no."</td><td  align=left>".$promo_name."</td><td>".$promo_start."</td><td>".$promo_end."</td><td>".$promo_duration."</td><td>".$promo_pcs."</td><td>".$promo_money."</td><td>".$promo_discount."</td><td>".$promo_price."</td><td></td></tr>";
																											
	$i++;
	$no++;
																		}
}																											
		?>
        </table>
</div>
</div>