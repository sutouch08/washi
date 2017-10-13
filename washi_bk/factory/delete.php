<?
require_once '../library/config.php';
require_once '../library/functions.php';
checkUser();
$order_id = $_GET['order_id'];
$sql_del_o = "delete from tbl_order where order_id = '$order_id'";
dbQuery($sql_del_o);
$sql_del_d = "delete from tbl_order_detail where order_id = '$order_id'";
dbQuery($sql_del_d);
$sql_del_d = "delete from tbl_pament where order_id = '$order_id'";
dbQuery($sql_del_d);
header("location:index.php?content=delete");
?>