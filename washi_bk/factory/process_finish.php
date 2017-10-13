<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();
	$process_id = $_GET['process_id'];
	$sql = "UPDATE fac_process SET status = '2' WHERE process_id = ".$process_id;
	dbQuery($sql);
	$sql = "UPDATE fac_process_detail SET status = '2' WHERE process_id = ".$process_id;
	dbQuery($sql);
	$sql ="SELECT * FROM fac_process_detail WHERE process_id = '$process_id'";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	while($i<$row)
	{
	$result = dbFetchArray($query);
	$process_detail_id = $result['process_detail_id'];
	$detail_id = $result['detail_id'];
	$sql = "UPDATE tbl_order_detail SET status = '8' WHERE detail_id = ".$detail_id;
	dbQuery($sql);
	$sql1="SELECT * FROM tbl_order_detail WHERE detail_id = '$detail_id'";
		$Qtotal1 = dbQuery($sql1);
		$rs1=dbFetchArray($Qtotal1);
		$order_id = $rs1['order_id'];
	$sql2 = "UPDATE tbl_order SET status = '8' WHERE order_id = ".$order_id;
	dbQuery($sql2);
	$i++;	
	}
	header("location:index.php?content=processlist");
	?>