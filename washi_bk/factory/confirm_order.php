   <?
    $sum_price1 = "0";
    $sum_num = "0";
	$sum_weight  = "0";
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
	$order_id =  placeOrder($sum_price1, $sum_num, $sum_weight);
	//echo $order_id;
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
	//echo $detail_weight;
	}
	}
	}
?>    
<script type="text/javascript">
	window.location="index.php?content=checkbill&order_id=<? echo $order_id;?>";
</script>