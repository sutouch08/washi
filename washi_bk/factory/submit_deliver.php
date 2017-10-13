<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
	case 'driver':
		add_driver();
		break;
	case 'driver_order':
		add_driver_order();
		break;
	case 'del_order':
		del_driver_order();
		break;
	default :
	header("location:index.php?content=newDelivery&delivery_id=$delivery_id");
}

function add_driver()
{
		$content = $_GET['content'];
		$shop_id = $_COOKIE['shop_id'];
		$driver_id = $_POST['driver_id'];
		$car_id = $_POST['car_id'];
		$status = $_POST['status'];
		$qr_s= dbQuery("select * from tbl_status where status_id = '$status'");
		$rs_s = dbFetchArray($qr_s);
		$target_id = $rs_s['target_id'];
		$sql11 = "insert into tbl_delivery(driver_id,car_id,target_id,status,shop_id) VALUES('$driver_id','$car_id','$target_id','$status','$shop_id')";
		dbQuery($sql11); 
		$qr_d= dbQuery("select delivery_id from tbl_delivery where driver_id = '$driver_id' and car_id = '$car_id' ORDER BY delivery_id DESC");
		$rs_d = dbFetchArray($qr_d); 
		$delivery_id = $rs_d['delivery_id'];
		header("location:index.php?content=$content&delivery_id=$delivery_id");

}

function add_driver_order()
{
	if(isset($_POST['delivery_id']))
	{
		$content = $_GET['content'];
		$delivery_id = $_POST['delivery_id'];
		$order_code = $_POST['order_code'];
		$status = $_POST['status'];
		$shipping_id = $_POST['shipping_id'];
		$qr_o= dbQuery("select * from tbl_order where order_code = '$order_code' and status = '9' and shipping_id IN ($shipping_id)");
		$rs_o = dbFetchArray($qr_o); 
		$order_id = $rs_o['order_id'];
		if($order_id != ""){
		$sql11 = "insert into tbl_delivery_detail(delivery_id,order_id,status) VALUES('$delivery_id','$order_id','$status')";
		dbQuery($sql11); 
		$sql = "UPDATE tbl_order SET status = '$status' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order_detail SET status = '$status' WHERE order_id = ".$order_id;
		dbQuery($sql);
		header("location:index.php?content=$content&delivery_id=$delivery_id");
		}else{
			$not_order = "FAIL !!";
		
		header("location:index.php?content=$content&delivery_id=$delivery_id&not_order=$not_order");
		}
	
		
	}
}
function del_driver_order()
{
	if(isset($_GET['delivery_id']))
	{	
		$content = $_GET['content'];
		$delivery_id = $_GET['delivery_id'];
		$delivery_detail_id = $_GET['delivery_detail_id'];
		$order_id = $_GET['order_id'];
		$status = $_GET['status'];
		$sql_del = "delete from tbl_delivery_detail where delivery_detail_id = '$delivery_detail_id'";
		dbQuery($sql_del);
		$sql = "UPDATE tbl_order SET status = '9' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order_detail SET status = '9' WHERE order_id = ".$order_id;
		dbQuery($sql);
		header("location:index.php?content=$content&delivery_id=$delivery_id");
	}
}
	
?>