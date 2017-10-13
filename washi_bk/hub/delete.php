<?
require_once '../library/config.php';
require_once '../library/functions.php';
checkUser();
$status_id = $_GET['status_id'];
$delivery_id = $_GET['delivery_id'];
$sql ="SELECT * FROM tbl_delivery_detail where delivery_id = '$delivery_id' ";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$order_id = $result['order_id'];
		$sql = "UPDATE tbl_order SET status = '$status_id'-1 WHERE order_id = ".$order_id;
		dbQuery($sql);
		$sql = "UPDATE tbl_order_detail SET status = '$status_id'-1 WHERE order_id = ".$order_id;
		dbQuery($sql);
		 $i++;
		}

$sql_del_o = "delete from tbl_delivery where delivery_id = '$delivery_id'";
dbQuery($sql_del_o);
$sql_del_d = "delete from tbl_delivery_detail where delivery_id = '$delivery_id'";
dbQuery($sql_del_d);

header("location:index.php?content=delete");
?>