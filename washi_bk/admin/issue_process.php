<?php
	require "../library/config.php";
	require "../library/functions.php";
	
	if(isset($_GET['problem_name'])){
	$problem_name = $_GET['problem_name'];
	$sql = "select problem_name from tbl_problem where problem_name = '$problem_name'";
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
		$problem_name = $_POST['problem_name'];
		
		dbQuery("insert into tbl_problem (problem_name) values ('$problem_name')");
		header("location:index.php?content=Issue");
	}
	
	if(isset($_GET['edit']))	{
		
		$id_problem = $_POST['id_problem'];		
		$problem_name = $_POST['problem_name'];
		$sql = "UPDATE tbl_problem  SET problem_name='$problem_name' WHERE id_problem = $id_problem ";
		$result = dbQuery($sql);
		header("location:index.php?content=Issue");		
}
	if(isset($_GET['delete'])){
		$id_problem = $_GET['id_problem'];
		$sql = "delete from tbl_problem  where id_problem = '$id_problem'";
		dbQuery($sql);
		header("location:index.php?content=Issue");
	}
		
?>