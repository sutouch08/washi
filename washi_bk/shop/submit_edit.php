<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
	case 'driver':
		edit_driver();
		break;
	case 'driver_order':
		add_driver_order();
		break;
	case 'del_order':
		del_driver_order();
		break;
	default :
	header("location:index.php?content=Edit&delivery_id=$delivery_id");
}

function edit_driver()
{
		$delivery_id = $_POST['delivery_id'];
		$driver_id = $_POST['driver_id'];
		$car_id = $_POST['car_id'];
		$target_id = $_POST['target_id'];
		$qr_s= dbQuery("select * from tbl_status where target_id = '$target_id'");
		$rs_s = dbFetchArray($qr_s); 
		$status_id = $rs_s['status_id'];
		$sql = "UPDATE tbl_delivery SET driver_id = '$driver_id', car_id = '$car_id', target_id = '$target_id', status = '$status_id' WHERE delivery_id = ".$delivery_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_delivery_detail SET status = '$status_id' WHERE delivery_id = ".$delivery_id;
		dbQuery($sql);
		$sql ="SELECT * FROM tbl_delivery_detail where delivery_id = '$delivery_id'";
		$query=dbQuery($sql);
		$row = dbNumRows($query);
		$i=0;
		while($i<$row)
		{
		$result = dbFetchArray($query);
		$order_id = $result['order_id'];
		$sql = "UPDATE tbl_order SET status = '$status_id' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$i++;
		}
		$Y = "Y";
		header("location:index.php?content=EDIT&delivery_id=$delivery_id&Y=$Y");
}

function add_driver_order()
{
	if(isset($_POST['delivery_id']))
	{
		
		$delivery_id = $_POST['delivery_id'];
		$order_code = $_POST['order_code'];
		$status_id = $_POST['status_id'];
		$qr_o= dbQuery("select * from tbl_order where order_code = '$order_code' and status = '2'");
		$rs_o = dbFetchArray($qr_o); 
		$order_id = $rs_o['order_id'];
		if($order_id != ""){
		$sql11 = "insert into tbl_delivery_detail(delivery_id,order_id,status) VALUES('$delivery_id','$order_id','$status_id')";
		dbQuery($sql11); 
		$sql = "UPDATE tbl_order SET status = '$status_id' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order_detail SET status = '$status_id' WHERE order_id = ".$order_id;
		dbQuery($sql);
		header("location:index.php?content=EDIT&delivery_id=$delivery_id");
		}else{
			$not_order = "FAIL !!";
		
		header("location:index.php?content=EDIT&delivery_id=$delivery_id&not_order=$not_order");
		}
	
		
	}
}
function del_driver_order()
{
	if(isset($_GET['delivery_id']))
	{	
		$delivery_id = $_GET['delivery_id'];
		$delivery_detail_id = $_GET['delivery_detail_id'];
		$order_id = $_GET['order_id'];
		$sql_del = "delete from tbl_delivery_detail where delivery_detail_id = '$delivery_detail_id'";
		dbQuery($sql_del);
		$sql = "UPDATE tbl_order SET status = '2' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order_detail SET status = '2' WHERE order_id = ".$order_id;
		dbQuery($sql);
		header("location:index.php?content=EDIT&delivery_id=$delivery_id");
	}
}
	
?>