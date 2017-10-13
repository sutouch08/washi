<?
require_once '../library/config.php';
require_once '../library/functions.php';
checkUser();
$detail_id = $_GET['detail_id'];
$order_id = $_GET['order_id'];
$qr_d =dbQuery("SELECT * FROM tbl_order_detail where detail_id = '$detail_id'");	
$rs_d=mysql_fetch_array($qr_d);
$product_id = $rs_d['product_id'];
$sql_del = "delete from tbl_order_detail where detail_id = '$detail_id'";
dbQuery($sql_del);
$qr_p =dbQuery("SELECT * FROM tbl_product where product_id = '$product_id'");	
$rs_p=mysql_fetch_array($qr_p);
$price = $rs_p['price'];
$qr =dbQuery("SELECT * FROM tbl_order where order_id = '$order_id'");	
$rs=mysql_fetch_array($qr);
$order_qty = $rs['order_qty']-1;
$order_amount = $rs['order_amount']-$price;
$sql = "UPDATE tbl_order SET order_qty = '$order_qty' , order_amount = '$order_amount' WHERE order_id = ".$order_id;
dbQuery($sql);
//echo $sql;
header("location:index.php?content=Edit&order_id=".$order_id);
?>



