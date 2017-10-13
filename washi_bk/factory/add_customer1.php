 <? //include('conn.php');
$shop_id = $_COOKIE['shop_id'];
$user_id = $_COOKIE['user_id'];
$customer_name = $_POST['customer_name'];
 if($customer_name != ""){ 
 $customer_name = $_POST['customer_name'];
 $customer_code = $_POST['customer_code'];
 $customer_address = $_POST['customer_address'];
 $customer_email = $_POST['customer_email'];
 $customer_phone = $_POST['customer_phone'];
 $sql11 = "insert into tbl_customer(customer_name,customer_code,customer_address,customer_email,customer_phone,user_id,shop_id) VALUES('$customer_name','$customer_code','$customer_address','$customer_email','$customer_phone','$user_id','$shop_id')";
	 $db_query11=@mysql_db_query($dbName,$sql11) or die ("$sql11"); 
	 $qr= dbQuery("select * from tbl_customer where customer_code = '$customer_code' and customer_name = '$customer_name' and customer_address = '$customer_address' and customer_phone = '$customer_phone' and user_id = '$user_id' and shop_id = '$shop_id'");
	$rs = dbFetchArray($qr);
	$customer_id = $rs['customer_id'];
	$sql2 = "insert into tbl_member(mem_code,cus_id) VALUES('$customer_code','$customer_id')";
	 $db_query2=@mysql_db_query($dbName,$sql2) or die ("$sql2"); 
	  $qr1= dbQuery("select * from tbl_member where cus_id = '$customer_id'");
	$rs1 = dbFetchArray($qr1);
	$mem_id = $rs1['mem_id'];
	 $sql = "UPDATE tbl_customer SET mem_id = '$mem_id' where customer_id = '$customer_id'";
	dbQuery($sql);
	$sql3= "insert into tbl_member_detail(mem_id,promo_id,detail_start,detail_end,detail_credit,credit_type) VALUES('$mem_id','1','0000-00-00','0000-00-00','0','1')";
	 $db_query3=@mysql_db_query($dbName,$sql3) or die ("$sql3");
	 ?>
	<script type="text/javascript">
	window.location="index.php?content=new&customer_code=<? echo $customer_code;?>";
</script>
<?
 }else{
	 ?>
     <script type="text/javascript">
	window.location="index.php?content=new";
</script>
<?
	 
 }
	  ?>