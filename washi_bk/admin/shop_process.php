<?php
	require "../library/config.php";
	require "../library/functions.php";
	
	if(isset($_GET['shop_name'])){
	$shop_name = $_GET['shop_name'];
	$result = dbQuery("SELECT shop_name FROM tbl_shop WHERE shop_name='$shop_name'");
	$row = dbNumRows($result);
	if($row >0){
		$message ="1";
		echo $message;
	}else{
		$message ="0";
		echo $message;
	}
}

if(isset($_GET['add'])){
		$shop_name = $_POST['shop_name'];
		$shop_address = $_POST['shop_address'];
		$shop_phone =  $_POST['shop_phone'];
		$shop_code =  $_POST['shop_code'];
		dbQuery("INSERT INTO tbl_shop (shop_name, shop_address, shop_phone, shop_code) VALUES ('$shop_name','$shop_address','$shop_phone','$shop_code')");
		header("location:index.php?content=shop");
	}
	
	if(isset($_GET['edit']))	{	
		$shop_id = $_POST['shop_id'];	
		$shop_name = $_POST['shop_name'];
		$shop_address = $_POST['shop_address'];
		$shop_phone =  $_POST['shop_phone'];
		$shop_code =  $_POST['shop_code'];
		$result = dbQuery("UPDATE tbl_shop SET shop_name='$shop_name', shop_address ='$shop_address', shop_phone='$shop_phone', shop_code='$shop_code' WHERE shop_id = $shop_id");
		header("location:index.php?content=shop");		
}
	if(isset($_GET['delete'])){
		$shop_id = $_GET['shop_id'];
		dbQuery("DELETE FROM tbl_shop WHERE shop_id = $shop_id");
		header("location:index.php?content=shop");
	}
		
?>