<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();

  $sum_price1 = "0";
  $sum_num = "0";
  $sum_weight = "0";
	for($loop=1;$loop<=$_POST["Line"];$loop++)
	{
	$product_weight = $_POST["product_weight$loop"];
	$sum_price = $_POST["sum_price$loop"];
	$sum_price1 = $sum_price1 + $sum_price;
	$number = $_POST["number$loop"];
	$sum_num = $sum_num + $number;
        
	$weight = $product_weight * $number;
	$sum_weight = $sum_weight + $weight;
	}
	$user_id = $_COOKIE['user_id'];
	$shop_id = $_COOKIE['shop_id'];		
			$urgent_id = $_POST['urgent_id'];
			$qr_u =dbQuery("SELECT * FROM tbl_urgent where urgent_id = '$urgent_id'");
			$rs_u=dbFetchArray($qr_u);	
			$urgent_date = $rs_u['urgent_date'];
			$charge_up = $rs_u['charge_up'];
			$sumproductprice = $_POST['sumproductprice'];
			$order_amount = (1+($charge_up/100))*($sum_price1+$sumproductprice);
			$customer_id = $_POST['customer_id'];
            $sum_weight1 = $_POST['sum_weight1']+$sum_weight;
			$shipping_id = $_POST['shipping_id'];
			$dateInput = $_POST['dateInput'];
			$loopdt = $_POST['loopdt'];
			$order_id = $_POST['order_id'];
			$order_qty = $sum_num + $loopdt;
			$order_code = $_POST['order_code'];
			$note = $_POST['note'];
				$sql = "UPDATE tbl_order SET customer_id = '$customer_id' , shipping_id = '$shipping_id' , urgent_id = '$urgent_id' ,order_due = '$dateInput' ,order_qty = '$order_qty' ,order_amount = '$order_amount' ,order_code = '$order_code' ,note = '$note' ,weight = '$sum_weight1' , status_amount = '1' WHERE order_id = '$order_id'";
			dbQuery($sql);

	for($loop=1;$loop<=$_POST["Line"];$loop++)
	{
	$product_id = $_POST["product_id$loop"];
	$number = $_POST["number$loop"];
	$price = $_POST["price$loop"];
        $product_weight = $_POST["product_weight$loop"];
        $detail_weight = $product_weight * $number;
	if($number >= "1"){
	for($loopnumber=1;$loopnumber<=$number;$loopnumber++)
	{
	$sql_o = "insert into tbl_order_detail(order_id,product_id,status,qty,detail_price,detail_weight)VALUES('$order_id','$product_id','1','1','$price','$detail_weight')";
	$db_query=dbQuery($sql_o) or die ("$sql_o");
	$sql1 = "UPDATE tbl_order SET status = '1' WHERE order_id = '$order_id'";
	dbQuery($sql1);
	}
	}
	}
	check_product_code($order_id);
?>    <script type="text/javascript">
	window.location="index.php?content=checkbilledit&order_id=<? echo $order_id;?>";
</script>