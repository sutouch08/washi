<?php
include "tool.php";
/////**** รายงานยอดขายแยกตามร้าน******//////

function saleOrderByShop($shop_id,$from_date,$to_date){
	return dbQuery("SELECT tbl_shop.shop_name AS shop, SUM(tbl_order.order_amount)AS amount FROM (tbl_order LEFT JOIN tbl_shop ON tbl_order.shop_id = tbl_shop.shop_id ) WHERE ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date')) ORDER BY tbl_shop.shop_name ASC");
}
function saleOrderRecieved($shop_id,$from_date,$to_date){
	return dbQuery("SELECT SUM(detail_price) AS amount FROM (tbl_order LEFT JOIN tbl_order_detail ON tbl_order.order_id = tbl_order_detail.order_id) WHERE tbl_order.shop_id='$shop_id' AND tbl_order_detail.status ='17' AND (tbl_order.order_date_time OR tbl_order.order_due BETWEEN '$from_date' AND '$to_date')");
}
function weekAmountByShop($today){
	$week = getWeek($today);
	$from_date = $week["from"];
	$to_date = $week["to"];
	return dbQuery("SELECT tbl_shop.shop_name AS shop, SUM(tbl_order.order_amount)AS amount FROM (tbl_order LEFT JOIN tbl_shop ON tbl_order.shop_id = tbl_shop.shop_id ) WHERE tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' GROUP BY tbl_order.shop_id ORDER BY tbl_shop.shop_name ASC");
}

function saleOrderByWeek($today){
	$week = getWeek($today);
	$from_date = $week["from"];
	$to_date = $week["to"];
	return dbQuery("SELECT sum(order_amount) AS total FROM tbl_order WHERE order_date_time BETWEEN '$from_date' AND '$to_date'");
} 

function getTotalAmountByShop($shop_id, $view, $from, $to)
{
	$report="";
	$today = date('Y-m-d');
	if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND ((order_date_time = '$today') OR (order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);
}

function getShopName($shop_id){
	$sql = dbQuery("select shop_name from tbl_shop where shop_id = '$shop_id'");
	$result = dbFetchArray($sql);
	$shop_name = $result['shop_name'];
	return $shop_name;
}

function getOrderRecievedByShop($shop_id, $view, $from, $to)
{
	$today = date('Y-m-d');
	if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status = 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status = 17 AND ((order_date_time = '$today') OR (order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status = 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status = 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status = 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);
	}
	
	function getOrderNotRecievedByShop($shop_id, $view, $from, $to)
{
	$today = date('Y-m-d');
	if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status != 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status != 17 AND ((order_date_time = '$today') OR (order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status != 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status != 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT SUM(order_amount) AS amount  FROM tbl_order WHERE  shop_id = '$shop_id' AND status != 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);
	}
	/// แสดงรายละเอียด การขาย แยกตาม ร้านค้า ตามช่วงวันที่///
	function getDetailByShop($shop_id, $view, $from, $to)
	{
		$today = date('Y-m-d');
		if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND ((order_date_time = '$today') OR (order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id'  AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);	
	}
	
	/// แสดงรายละเอียด รายการที่ส่งสินค้าแล้ว แยกตาม ร้านค้า ตามช่วงวันที่///
	function getReceivedDetailByShop($shop_id, $view, $from, $to)
	{
		$today = date('Y-m-d');
		if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_order.status = 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_order.status = 17 AND ((order_date_time = '$today') OR (order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_order.status = 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id'  AND tbl_order.status = 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_order.status = 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);	
	}
	
	/// แสดงรายละเอียด รายการที่ค้างส่งสินค้า แยกตาม ร้านค้า ตามช่วงวันที่///
	function getNotReceivedDetailByShop($shop_id, $view, $from, $to)
	{
		$today = date('Y-m-d');
		if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_order.status != 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_order.status != 17 AND ((order_date_time = '$today') OR (order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_order.status != 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id'  AND tbl_order.status != 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_order.status != 17 AND ((order_date_time  BETWEEN '$from_date' AND '$to_date') OR (order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);	
	}
	
	/// แสดงยอดขายรวมทุกร้าน ตามช่วงวันที่///
	function getTotalOrder($view, $from, $to)
	{
		$today = date('Y-m-d');
		if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){	

		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE ((tbl_order.order_date_time = '$today' ) OR (tbl_order.order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);	
	}
	
	/// แสดงยอดที่ส่งสินค้าแล้วรวมทุกร้าน ตามช่วงวันที่///
	function getTotalRecieved($view, $from, $to)
	{
		$today = date('Y-m-d');
		if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status = 17 AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status = 17 AND ((tbl_order.order_date_time ='$today' ) OR (tbl_order.order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status = 17 AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status = 17 AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status = 17 AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);	
	}
	
	/// แสดงยอดที่ค้างส่งสินค้ารวมทุกร้าน ตามช่วงวันที่///
	function getTotalNotRecieved($view, $from, $to)
	{
		$today = date('Y-m-d');
		if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status != 17 AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	}else if($view =="day"){
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status != 17 AND ((tbl_order.order_date_time ='$today' ) OR (tbl_order.order_due = '$today'))";
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status != 17 AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status != 17 AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT SUM(order_amount) AS amount FROM tbl_order WHERE status != 17 AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date' ) OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);	
	}
 function getQtyByShop($shop_id, $type_id,$view, $from, $to)
	{
		$today = date('Y-m-d');
		if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT SUM(tbl_order_detail.qty) AS qty FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_type ON tbl_type.type_id = tbl_product.type_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_product.type_id = '$type_id' AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date') OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT SUM(tbl_order_detail.qty) AS qty FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_type ON tbl_type.type_id = tbl_product.type_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_product.type_id = '$type_id' AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date') OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT SUM(tbl_order_detail.qty) AS qty FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_type ON tbl_type.type_id = tbl_product.type_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_product.type_id = '$type_id' AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date') OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT SUM(tbl_order_detail.qty) AS qty FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_type ON tbl_type.type_id = tbl_product.type_id WHERE  tbl_order.shop_id = '$shop_id' AND tbl_product.type_id = '$type_id' AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date') OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);	
	}
	
	
function getTotalQty($type_id,$view, $from, $to)
	{
		$today = date('Y-m-d');
		if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$from_date = date('Y-m-d',strtotime("$from"));
			$to_date = date('Y-m-d',strtotime("$to"));
			$report = "SELECT SUM(tbl_order_detail.qty) AS qty FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_type ON tbl_type.type_id = tbl_product.type_id WHERE tbl_product.type_id = '$type_id' AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date') OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
		}
	
	}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		$report = "SELECT SUM(tbl_order_detail.qty) AS qty FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_type ON tbl_type.type_id = tbl_product.type_id WHERE tbl_product.type_id = '$type_id' AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date') OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="month"){
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$report = "SELECT SUM(tbl_order_detail.qty) AS qty FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_type ON tbl_type.type_id = tbl_product.type_id WHERE tbl_product.type_id = '$type_id' AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date') OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}else if($view =="year"){
		$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		$report = "SELECT SUM(tbl_order_detail.qty) AS qty FROM tbl_order_detail LEFT JOIN tbl_order ON tbl_order_detail.order_id = tbl_order.order_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_type ON tbl_type.type_id = tbl_product.type_id WHERE tbl_product.type_id = '$type_id' AND ((tbl_order.order_date_time BETWEEN '$from_date' AND '$to_date') OR (tbl_order.order_due BETWEEN '$from_date' AND '$to_date'))";
	}
	return dbQuery($report);	
	}
	
function ReportChart($view,$from,$to){
		if($from !="เลือกวัน")
		{
			if($to !="เลือกวัน")
			{	
			$no = DateDiff($from,$to)+1;
			$date =$from;
				for($i=1; $i<=$no;$i++)
				{
					echo "{ xtime : '".date('d/m',strtotime("$date"))."', ".saleReportChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
				}
				
			}
		}else{
			
		switch($view){
			case "year" :
				for ($i = 1; $i<=12; $i++)
				{
					$month = monthname($i);
					echo "{ xtime : 'เดือน ".$i."', ".saleReportChart(date('Y-m-01',strtotime("$month this year")),date('Y-m-t',strtotime("$month this year")))." },";
				}
				break;
			case "month" :
				$rang = getMonth();
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = date('Y-m-01',strtotime("this month"));
				$day = date('Y-m-01',strtotime("this month"));
				for ($i=1; $i<= $no; $i++){
					echo "{ xtime : '".date('d/m',strtotime("$day"))."', ".saleReportChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
					$day = date('Y-m-d',strtotime("$day +1 day"));
				}
				break;
			case "week" :
				$rang = getWeek(date('Y-m-d'));
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = $rang['from'];
				for($i=1; $i<=$no;$i++){
					echo "{ xtime : '".date('d/m',strtotime("$date"))."', ".saleReportChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
				}
				break;
			default :
			$rang = getMonth();
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = date('Y-m-01',strtotime("this month"));
				$day = date('Y-m-01',strtotime("this month"));
				for ($i=1; $i<= $no; $i++){
					echo "{ xtime : '".date('d/m',strtotime("$day"))."', ".saleReportChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
					$day = date('Y-m-d',strtotime("$day +1 day"));
				}
				break;
		}
	}
}	
	
function RecievedChart($view,$from,$to){
	if($from !="เลือกวัน")
		{
			if($to !="เลือกวัน")
			{	
			$no = DateDiff($from,$to)+1;
			$date =$from;
				for($i=1; $i<=$no;$i++)
				{
					echo "{ xtime : '".date('d/m',strtotime("$date"))."', ".saleRecievedChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
				}
				
			}
		}else{
		switch($view){
			case "year" :
				for ($i = 1; $i<=12; $i++)
				{
					$month = monthname($i);
					echo "{ xtime : 'เดือน ".$i."', ".saleRecievedChart(date('Y-m-01',strtotime("$month this year")),date('Y-m-t',strtotime("$month this year")))." },";
				}
				break;
			case "month" :
				$rang = getMonth();
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = date('Y-m-01',strtotime("this month"));
				$day = date('Y-m-01',strtotime("this month"));
				for ($i=1; $i<= $no; $i++){
					echo "{ xtime : '".date('d/m',strtotime("$day"))."', ".saleRecievedChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
					$day = date('Y-m-d',strtotime("$day +1 day"));
				}
				break;
			case "week" :
				$rang = getWeek(date('Y-m-d'));
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = $rang['from'];
				for($i=1; $i<=$no;$i++){
					echo "{ xtime : '".date('d/m',strtotime("$date"))."', ".saleRecievedChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
				}
				break;
			default :
			$rang = getMonth();
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = date('Y-m-01',strtotime("this month"));
				$day = date('Y-m-01',strtotime("this month"));
				for ($i=1; $i<= $no; $i++){
					echo "{ xtime : '".date('d/m',strtotime("$day"))."', ".saleRecievedChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
					$day = date('Y-m-d',strtotime("$day +1 day"));
				}
				break;
		}
	}
}
	
function NotRecievedChart($view,$from,$to){
	if($from !="เลือกวัน")
		{
			if($to !="เลือกวัน")
			{	
			$no = DateDiff($from,$to)+1;
			$date =$from;
				for($i=1; $i<=$no;$i++)
				{
					echo "{ xtime : '".date('d/m',strtotime("$date"))."', ".saleNotRecievedChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
				}
				
			}
		}else{
		switch($view){
			case "year" :
				for ($i = 1; $i<=12; $i++)
				{
					$month = monthname($i);
					echo "{ xtime : 'เดือน ".$i."', ".saleNotRecievedChart(date('Y-m-01',strtotime("$month this year")),date('Y-m-t',strtotime("$month this year")))." },";
				}
				break;
			case "month" :
				$rang = getMonth();
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = date('Y-m-01',strtotime("this month"));
				$day = date('Y-m-01',strtotime("this month"));
				for ($i=1; $i<= $no; $i++){
					echo "{ xtime : '".date('d/m',strtotime("$day"))."', ".saleNotRecievedChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
					$day = date('Y-m-d',strtotime("$day +1 day"));
				}
				break;
			case "week" :
				$rang = getWeek(date('Y-m-d'));
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = $rang['from'];
				for($i=1; $i<=$no;$i++){
					echo "{ xtime : '".date('d/m',strtotime("$date"))."', ".saleNotRecievedChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
				}
				break;
			default :
			$rang = getMonth();
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = date('Y-m-01',strtotime("this month"));
				$day = date('Y-m-01',strtotime("this month"));
				for ($i=1; $i<= $no; $i++){
					echo "{ xtime : '".date('d/m',strtotime("$day"))."', ".saleNotRecievedChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
					$day = date('Y-m-d',strtotime("$day +1 day"));
				}
				break;
		}
	}
}
		
?>