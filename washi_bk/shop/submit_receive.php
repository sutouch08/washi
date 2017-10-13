<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
	case 'driver_order':
		receive_driver_order();
		break;
	case 'del_order':
		del_driver_order();
		break;
	case 'cus_delivery':
		cus_delivery();
		break;
	case 'cus_delivery_check':
		cus_check();
		break;
	default :
	header("location:index.php?content=$content&car_id=$car_id");
}

function receive_driver_order()
{
	
		$content = $_GET['content'];
		$car_id = $_POST['car_id'];
		$order_code = $_POST['order_code'];
		$status = $_POST['status'];
		$qr_o= dbQuery("select * from tbl_order where order_code = '$order_code' and status = '$status'");
		$rs_o = dbFetchArray($qr_o); 
		$order_id = $rs_o['order_id'];
		if($order_id != ""){
		$sql = "UPDATE tbl_order SET status = '$status'+1 WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order_detail SET status = '$status'+1 WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_delivery_detail SET status = '$status'+1 WHERE status = '$status' and order_id = ".$order_id;
		dbQuery($sql);
		$qr_dt= dbQuery("select * from tbl_delivery_detail where order_id = '$order_id' and status = '$status'+1");
		$rs_dt = dbFetchArray($qr_dt); 
		$delivery_id = $rs_dt['delivery_id'];
		$sql11 = "select * from tbl_delivery_detail where delivery_id = '$delivery_id' and status = '$status'";
		$qr_d= dbQuery($sql11);
		$rs_d = dbFetchArray($qr_d);
		$delivery_detail_id = $rs_d['delivery_detail_id'];
		if($delivery_detail_id == ""){
		$sql = "UPDATE tbl_delivery SET status = '$status'+1 WHERE delivery_id = ".$delivery_id;
		
		dbQuery($sql);
		}
		header("location:index.php?content=$content&car_id=$car_id");
		}else{
			$not_order = "FAIL !!";
		header("location:index.php?content=$content&car_id=$car_id&not_order=$not_order");
		}
	}
	function del_driver_order()
	{

		$order_id = $_GET['order_id'];
		$content = $_GET['content'];
		$car_id = $_GET['car_id'];
		$status = $_GET['status'];
		$sql = "UPDATE tbl_order SET status = '$status' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order_detail SET status = '$status' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_delivery_detail SET status = '$status' WHERE status = '$status'+1 and order_id = ".$order_id;
		dbQuery($sql);
		$qr_dt= dbQuery("select * from tbl_delivery_detail where order_id = '$order_id' and status = '$status'");
		$rs_dt = dbFetchArray($qr_dt); 
		$delivery_id = $rs_dt['delivery_id'];
		$qr_d= dbQuery("select * from tbl_delivery_detail where delivery_id = '$delivery_id' and status = '$status'");
		$rs_d = dbFetchArray($qr_d);
		$delivery_detail_id = $rs_d['delivery_detail_id'];
		if($delivery_detail_id != ""){
		$sql = "UPDATE tbl_delivery SET status = '$status' WHERE delivery_id = ".$delivery_id;
		
		dbQuery($sql);}
		header("location:index.php?content=$content&car_id=$car_id");
	}
	function cus_delivery()
	{
		$order_id = $_POST['order_id'];
		$sql = "UPDATE tbl_order SET status = '17' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order_detail SET status = '17' WHERE order_id = ".$order_id;
		dbQuery($sql);
		header("location:index.php?content=receivecus");
	}
	function cus_check()
	{
		$order_id = $_POST['order_id'];
		$money = $_POST['money'];
		$qr_p =dbQuery("SELECT *  FROM tbl_pament where order_id = '$order_id'");	
		$rs_p=mysql_fetch_array($qr_p);
		$paymet_received = $rs_p['paymet_received'];
		$order_amount = $rs_p['order_amount'];
		$sum_received = ($money + $paymet_received);
		$payment_change = $sum_received - $order_amount;
		//echo "$sum_received/$payment_change";
		$sql = "UPDATE tbl_pament SET paymet_received = '$sum_received' , payment_change = '$payment_change' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order SET status_amount = '2' WHERE order_id = ".$order_id;
		dbQuery($sql);
		header("location:index.php?content=check&order_id=$order_id");
	}
	

	
?>