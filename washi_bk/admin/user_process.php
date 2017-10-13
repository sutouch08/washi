<?php
	require "../library/config.php";
	require "../library/functions.php";
	
	if(isset($_GET['user_name'])){
	$user_name = $_GET['user_name'];
	$sql = "select user_name from tbl_user where user_name = '$user_name'";
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
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$em_id = $_POST['em_id'];
		$shop_id = $_POST['shop_id'];
		$permission = $_POST['permission'];
		$date = date('Y-m-d');
		
		dbQuery("insert into tbl_user (user_name, password, em_id, shop_id, permission, user_last_login) values ('$user_name', '$password', '$em_id', '$shop_id', '$permission',now() )");
		header("location:index.php?content=user");
	}
	
	if(isset($_GET['edit']))
	{
		$user_id = $_POST['user_id'];		
		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$em_id = $_POST['em_id'];
		$shop_id = $_POST['shop_id'];
		$permission = $_POST['permission'];
		$sql = "UPDATE tbl_user  SET user_name='$user_name', password='$password', em_id='$em_id', shop_id='$shop_id', permission='$permission' WHERE user_id='$user_id'";
		$result = dbQuery($sql);
		header("location:index.php?content=user");		
}

	if(isset($_GET['delete']))
	{
		$user_id = $_GET['user_id'];
		dbQuery("delete from tbl_user where user_id = '$user_id'");
		header("location:index.php?content=user");
	}

?>