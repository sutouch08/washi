<?php
	require "../library/config.php";
	require "../library/functions.php";
	
if(isset($_GET['add'])){
		$type_name = $_POST['type_name'];
		dbQuery("INSERT INTO tbl_type  VALUES ('$type_name')");
		header("location:index.php?content=type");
	}
	
	if(isset($_GET['edit']))	{	
		$type_id = $_POST['type_id'];	
		$type_name = $_POST['type_name'];
		$result = dbQuery("UPDATE tbl_type SET type_name='$type_name' WHERE type_id = $type_id");
		header("location:index.php?content=type");		
}
	if(isset($_GET['delete'])){
		$type_id = $_GET['type_id'];
		dbQuery("DELETE FROM tbl_type WHERE type_id = $type_id");
		header("location:index.php?content=type");
	}
		
?>