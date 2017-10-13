<?php
	require "../library/config.php";
	require "../library/functions.php";
	
	if(isset($_GET['em_name'])){
	$em_name = $_GET['em_name'];
	$result = dbQuery("select em_name from tbl_employee where em_name = '$em_name'");
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
		$em_name = $_POST['em_name'];
		$profile_id = $_POST['profile_id'];
		$shop_id = $_POST['shop_id'];
		$em_code = $_POST['em_code'];		
		dbQuery("insert into tbl_employee (em_name, shop_id, profile_id, em_code) values ('$em_name', '$shop_id', '$profile_id','$em_code')");
		header("location:index.php?content=employee");
	}
	
	if(isset($_GET['edit']))
	{
		$em_id = $_POST['em_id'];		
		$em_name = $_POST['em_name'];
		$profile_id = $_POST['profile_id'];
		$shop_id = $_POST['shop_id'];
		$em_code = $_POST['em_code'];	
		$sql = "UPDATE tbl_employee SET em_name='$em_name', shop_id='$shop_id', profile_id='$profile_id',em_code='$em_code' WHERE em_id='$em_id'";
		$result = dbQuery($sql);
		header("location:index.php?content=employee");		
}

	if(isset($_GET['delete']))
	{
		$em_id = $_GET['em_id'];
		dbQuery("delete from tbl_employee where em_id = '$em_id'");
		header("location:index.php?content=employee");
	}

?>