<?php
	require "../library/config.php";
	require "../library/functions.php";
	
	if(isset($_GET['driver_name'])){
	$driver_name = $_GET['driver_name'];
	$sql = "select driver_name from tbl_driver where driver_name = '$driver_name'";
	$result = dbQuery($sql);
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
		$driver_name = $_POST['driver_name'];
		$driver_phone = $_POST['driver_phone'];
		$driver_address = $_POST['driver_address'];
		
		dbQuery("insert into tbl_driver (driver_name,driver_phone,driver_address) values ('$driver_name', '$driver_phone', '$driver_address' )");
		header("location:index.php?content=transport");
	}
	
	if(isset($_GET['edit']))	{
		
		$user_id = $_POST['user_id'];		
		$driver_name = $_POST['driver_name'];
		$driver_phone = $_POST['driver_phone'];
		$driver_address = $_POST['driver_address'];
		$sql = "UPDATE tbl_driver  SET driver_name='$driver_name',driver_phone='$driver_phone',driver_address='$driver_address' WHERE driver_id = '$user_id' ";
		$result = dbQuery($sql);
		header("location:index.php?content=transport");		
}
	if(isset($_GET['delete'])){
		$driver_id = $_GET['driver_id'];
		$sql = "delete from tbl_driver  where driver_id = '$driver_id'";
		dbQuery($sql);
		header("location:index.php?content=transport");
	}
		
	if(isset($_GET['car_plate'])){
	$car_plate = $_GET['car_plate'];
	$sql = "select car_plate from tbl_car where car_plate = '$car_plate'";
	$result = dbQuery($sql);
	$row = dbNumRows($result);
	if($row >0){
		$message ="1";
		echo $message;
	}else{
		$message ="0";
		echo $message;
	}
}
	if(isset($_GET['caradd'])){
		$car_plate = $_POST['car_plate'];
		$car_brand = $_POST['car_brand'];
		$capacity = $_POST['capacity'];
		
		dbQuery("insert into tbl_car (car_plate,car_brand,capacity) values ('$car_plate', '$car_brand','$capacity')");
		header("location:index.php?content=transport");
		
	}
	
	if(isset($_GET['editcar']))	{
		$user_id = $_POST['user_idc'];		
		$car_plate = $_POST['car_plate'];
		$car_brand = $_POST['car_brand'];
		$capacity = $_POST['capacity'];
		$sql = "UPDATE tbl_car  SET car_plate='$car_plate',car_brand='$car_brand',capacity = '$capacity' WHERE car_id = '$user_id' ";
		$result = dbQuery($sql);
		header("location:index.php?content=transport");		
	}
	if(isset($_GET['deletecar'])){
		$car_id = $_GET['car_id'];
		$sql = "delete from tbl_car  where car_id = '$car_id'";
		dbQuery($sql);
		header("location:index.php?content=transport");
	}
?>