<?
require_once '../library/config.php';
require_once '../library/functions.php';
checkUser();
$shop_id = $_COOKIE['shop_id'];
$user_id = $_COOKIE['user_id'];
$customer_code = $_POST['customer_code'];
$promo_id = $_POST['promo_id'];
$number = $_POST['number'];
$promo_price = $_POST['promo_price'];
$money = $_POST['money'];
$received = $_POST['received'];
$change = $_POST['change'];
$promo_pcs = $_POST['promo_pcs'];
$promo_money = $_POST['promo_money'];
$promo_duration = $_POST['promo_duration'];
$qr_c =dbQuery("SELECT * FROM tbl_customer LEFT JOIN tbl_member ON tbl_customer.customer_id = tbl_member.cus_id where customer_code = '$customer_code'");
$rs_c=dbFetchArray($qr_c);
$mem_id = $rs_c['mem_id'];
$customer_id = $rs_c['customer_id'];
if($promo_duration == "0"){
$start = $_POST['promo_start'];
$end = $_POST['promo_end'];
$promo_start = date('Y-m-d',strtotime("$start"));
$promo_end = date('Y-m-d',strtotime("$end"));
}else{
$promo_start = date('Y-m-d');
$promo_duration1 = $promo_duration*$number;
$promo_end =  date('Y-m-d', strtotime("+$promo_duration1 day"));
}
if($promo_pcs != "0"){
$detail_credit = $promo_pcs*$number;
$credit_type = "2";
}else if($promo_money != "0"){
$detail_credit = $promo_money*$number;
$credit_type = "1";
}else{
$detail_credit = "0";
$credit_type = "3";
}
//echo "$promo_start/$promo_end/$number/$promo_price/$money/$received/$change/$promo_id";
$sql_o = "insert into  tbl_member_detail(mem_id,promo_id,detail_start,detail_end,detail_credit,credit_type)VALUES('$mem_id','$promo_id','$promo_start','$promo_end','$detail_credit','$credit_type')";
$db_query=dbQuery($sql_o) or die ("$sql_o");
$sql = "insert into tbl_pament(shop_id,user_id,cus_id,order_id,order_amount,pament_deposit,pament_discount,promo_id,promo_amount,paymet_received,payment_change)VALUES('$shop_id','$user_id','$customer_id','0','$money','0','0','$promo_id','0','$received','$change')";
dbQuery($sql);
$qr =dbQuery("SELECT * FROM tbl_member_detail where mem_id = '$mem_id' ORDER BY  `tbl_member_detail`.`mem_detail_id` DESC");
$rs=dbFetchArray($qr);
$mem_detail_id = $rs['mem_detail_id'];
//echo $sql_o;
//echo $sql;
header("location:index.php?content=showPro&mem_detail_id=$mem_detail_id&customer_id=$customer_id");
?>