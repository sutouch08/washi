<?php
require_once '../library/config.php';
require_once '../library/functions.php';
checkUser();
$customer_id = $_POST['customer_id'];
$customer_name = $_POST['customer_name'];
$customer_code = $_POST['customer_code'];
$customer_phone = $_POST['customer_phone'];
$customer_address = $_POST['customer_address'];
$customer_email = $_POST['customer_email'];

$qr= dbQuery("select * from tbl_customer where customer_code = '$customer_code' and customer_id != '$customer_id'");
$rs = dbFetchArray($qr); 
$customer_id1 = $rs['customer_id'];

if($customer_id1 == ""){
	$sql = "UPDATE tbl_customer SET customer_name = '$customer_name' , customer_code = '$customer_code' , customer_phone = '$customer_phone' , customer_address = '$customer_address' , customer_email = '$customer_email' WHERE customer_id = ".$customer_id;
	dbQuery($sql);
	$sql = "UPDATE tbl_member SET mem_code = '$customer_code' where cus_id = '$customer_id'";
	dbQuery($sql);
	$check_code = "Y";
header("location:index.php?content=customer_detail&check_code=$check_code&customer_id=$customer_id");
}else{
	$check_code = "N";
header("location:index.php?content=customer_detail&check_code=$check_code&customer_id=$customer_id");
}
?>