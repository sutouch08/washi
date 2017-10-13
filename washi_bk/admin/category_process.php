<?php
	require "../library/config.php";
	require "../library/functions.php";
	
	if(isset($_GET['category_name'])){
	$category_name = $_GET['category_name'];
	$sql = "select process_category_name from tbl_process_category where process_category_name = '$category_name'";
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
		$category_name = $_POST['category_name'];
		
		dbQuery("insert into tbl_process_category (process_category_name, process_category_no) values ('$category_name', '' )");
		header("location:index.php?content=category");
	}
	
	if(isset($_GET['edit']))	{
		
		$user_id = $_POST['user_id'];		
		$user_name = $_POST['category_name'];
		$sql = "UPDATE tbl_process_category  SET process_category_name='$user_name' WHERE process_category_id = $user_id ";
		$result = dbQuery($sql);
		header("location:index.php?content=category");		
}
	if(isset($_GET['delete'])){
		$category_id = $_GET['category_id'];
		$sql = "delete from tbl_process_category  where process_category_id = '$category_id'";
		dbQuery($sql);
		header("location:index.php?content=category");
	}
		
?>