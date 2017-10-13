<?
require_once '../library/config.php';
require_once '../library/functions.php';
checkUser();
$shop_id = $_COOKIE['shop_id'];
$user_id = $_COOKIE['user_id'];

$mem_detail_id = $_POST['mem_detail_id'];
$amount = $_POST['amount'];
$paymet_received = $_POST['paymet_received'];
$payment_change =$_POST['payment_change'];
$cus_id = $_POST['cus_id'];
$promo_id = $_POST['promo_id'];
$customer_code = $_POST['customer_code'];
$detail_credit = $_POST['detail_credit']+$amount;

$sql1 = "UPDATE tbl_member_detail SET detail_credit = '$detail_credit' WHERE mem_detail_id = ".$mem_detail_id;
dbQuery($sql1);
$sql = "insert into tbl_pament(shop_id,user_id,cus_id,order_id,order_amount,pament_deposit,pament_discount,promo_id,promo_amount,paymet_received,payment_change)VALUES('$shop_id','$user_id','$cus_id','0','$amount','0','0','$promo_id','0','$paymet_received','$payment_change')";
dbQuery($sql);
header("location:index.php?content=credit&customer_code=$customer_code");
?>