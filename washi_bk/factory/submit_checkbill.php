<?
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();

$date = date('Y-m-d');
$shop_id = $_COOKIE['shop_id'];
$user_id = $_COOKIE['user_id'];
if(isset($_GET['order_id'])){
				$order_id = $_GET['order_id'];
}
if(isset($_POST['order_id'])){
				$order_id = $_POST['order_id'];
if(isset($_POST['deposit'])){
				$deposit = $_POST['deposit'];
}else{ $deposit = "";}
}
				$qr =dbQuery("SELECT * FROM tbl_order where order_id = '$order_id'");	
				$rs=dbFetchArray($qr);
				$cus_id = 
				$customer_id = $rs['customer_id'];
				$urgent_id = $rs['urgent_id'];
				$qr_u =dbQuery("SELECT * FROM tbl_urgent where urgent_id = '$urgent_id'");
				$rs_u=dbFetchArray($qr_u);	
				$charge_up = $rs_u['charge_up'];
				$qr_c =dbQuery("SELECT * FROM tbl_customer where customer_id = '$customer_id'");	
				$rs_c=dbFetchArray($qr_c);
				$mem_id = $rs_c['mem_id'];
				$qr_mem =dbQuery("SELECT * FROM tbl_member_detail LEFT JOIN tbl_promo ON tbl_member_detail.promo_id = tbl_promo.promo_id where mem_id = '$mem_id' and credit_type = '3' and ((detail_start <= '$date' and detail_end >= '$date') or detail_start = '0000-00-00') ");	
				$rs_mem=dbFetchArray($qr_mem);
				$promo_id = $rs_mem['promo_id'];
				$promo_discount = $rs_mem['promo_discount'];
				$credit_type = $rs_mem['credit_type'];
				$qr_d =dbQuery("SELECT SUM(qty),product_id,detail_price  FROM tbl_order_detail where order_id = '$order_id' GROUP BY  product_id ORDER BY product_id ASC");	
							$row =@mysql_num_rows($qr_d);
							 $i=0;
							while ($i<$row){
							$rs_d=mysql_fetch_array($qr_d);
							$product_id = $rs_d['product_id'];
							$qty = $rs_d['SUM(qty)'];
							$detail_price = $rs_d['detail_price'];
							$qr_u =dbQuery("SELECT * FROM tbl_product where product_id = '$product_id'");	
							$rs_u=dbFetchArray($qr_u);
							$product_name = $rs_u['product_name'];
							$sumprice = $qty * $detail_price;
							@$sum_qty = $sum_qty + $qty;
							@$sum_amount = $sum_amount + $sumprice;
							$i++;
							}
							$sum_price = (1+($charge_up/100))*$sum_amount;
							$sum_discount = ($sum_price*$promo_discount)/100; 
							$sum_discount1 = $sum_price - $sum_discount; 

				
				
if(isset($_GET['mem_detail_id'])){

$mem_detail_id = $_GET['mem_detail_id'];
$qr_m =dbQuery("SELECT * FROM tbl_member_detail LEFT JOIN tbl_member ON tbl_member_detail.mem_id = tbl_member.mem_id LEFT JOIN tbl_promo ON tbl_member_detail.promo_id = tbl_promo.promo_id LEFT JOIN tbl_credit_type ON tbl_member_detail.credit_type = tbl_credit_type.credit_type where mem_detail_id = '$mem_detail_id' and ((detail_start <= '$date' and detail_end >= '$date') or detail_start = '0000-00-00')  ");
$rs_m=mysql_fetch_array($qr_m);
	$detail_credit = $rs_m['detail_credit'];
	$promo_discount = $rs_m['promo_discount'];
	$promo_id1 = $rs_m['promo_id'];
	$credit_type = $rs_m['credit_type'];
	
if($credit_type == "1"){
	$sum_discount2 = ($sum_discount1 * $promo_discount)/100;
	$sum_discount3 = $sum_discount1 - $sum_discount2;
	$payment = $detail_credit - $sum_discount3;

	if($promo_id == ""){
		$promo_id2 = $promo_id1;
		
	}else{
		$promo_id2 = "$promo_id,$promo_id1";
	}
 	$sql = "UPDATE tbl_member_detail SET detail_credit = '$payment' WHERE mem_detail_id = '$mem_detail_id'";
	dbQuery($sql);
	$sql_o = "insert into tbl_promo_log(promo_id,mem_id,qty,amount,shop_id,user_id,order_id)VALUES('$promo_id2','$mem_id','0','$sum_discount3','$shop_id','$user_id','$order_id')";
	$db_query=dbQuery($sql_o) or die ("$sql_o");
	$sql = "UPDATE tbl_order SET status_amount = '2' WHERE order_id = '$order_id'";
	dbQuery($sql);
	header("location:index.php?content=show&order_id=$order_id&mem_detail_id=$mem_detail_id");
//	echo "$promo_id2 / ";
//echo "$payment/$detail_credit/$sum_discount3";
	
}else if($credit_type == "2"){	

	$payment = $detail_credit - $sum_qty;
	$sql = "UPDATE tbl_member_detail SET detail_credit = '$payment' WHERE mem_detail_id = '$mem_detail_id'";
	dbQuery($sql);
	$sql_o = "insert into  tbl_promo_log(promo_id,mem_id,qty,amount,shop_id,user_id,order_id)VALUES('$promo_id1','$mem_id','$sum_qty','0','$shop_id','$user_id','$order_id')";
	$db_query=dbQuery($sql_o) or die ("$sql_o");
	$sql = "UPDATE tbl_order SET status_amount = '2' WHERE order_id = '$order_id'";
	dbQuery($sql);
	header("location:index.php?content=show&order_id=$order_id&mem_detail_id=$mem_detail_id");
	//echo "$promo_id1 / ";
	//echo "$payment/$detail_credit/$sum_qty";
//$sql = "UPDATE tbl_member_detail SET detail_credit = '$payment' WHERE mem_detail_id = '$mem_detail_id'";
//dbQuery($sql);
}
}else{
$money = $_POST['money'];
$order_id = $_POST['order_id'];
$payment = $money - $sum_discount1;
if($deposit == ""){
$sql_o = "insert into  tbl_pament(shop_id,user_id,cus_id,order_id,order_amount,pament_deposit,pament_discount,promo_id,promo_amount,paymet_received,payment_change)VALUES('$shop_id','$user_id','$cus_id','$order_id','$sum_discount1','0','$promo_discount','$promo_id','$sum_discount','$money','$payment')";
$db_query=dbQuery($sql_o) or die ("$sql_o");
	$sql = "UPDATE tbl_order SET status_amount = '2' WHERE order_id = '$order_id'";
	dbQuery($sql);
	//echo "0";
}else{
	$sql_o = "insert into  tbl_pament(shop_id,user_id,cus_id,order_id,order_amount,pament_deposit,pament_discount,promo_id,promo_amount,paymet_received,payment_change)VALUES('$shop_id','$user_id','$cus_id','$order_id','$sum_discount1','$money','$promo_discount','$promo_id','$sum_discount','$money','0')";
	$db_query=dbQuery($sql_o) or die ("$sql_o");
	$sql = "UPDATE tbl_order SET status_amount = '1' WHERE order_id = '$order_id'";
	dbQuery($sql);
	
	//echo "$sql_o";
}
header("location:index.php?content=show&order_id=$order_id");
//echo "$payment/$money/$sum_discount1";
}
?>