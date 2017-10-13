<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();
$action = $_GET['action'];
if($action == "qc")
	{	
	$product_code = $_POST['product_code'];
	$id_problem = $_POST['id_problem'];
		
		$sql="SELECT * FROM tbl_order_detail WHERE product_code = '$product_code' and status = '8'";
		$Qtotal = dbQuery($sql);
		$rs=dbFetchArray($Qtotal);
		$order_id = $rs['order_id'];
		$detail_id = $rs['detail_id'];
		$detail_price = $rs['detail_price'];
		if($order_id != ""){
			if($id_problem == "1"){
				$sql_s="UPDATE tbl_order_detail SET status = '9' WHERE detail_id = '$detail_id'";
				dbQuery($sql_s);
				
			}else{
				dbQuery("UPDATE tbl_order_detail SET status = '18' WHERE detail_id = '$detail_id'");
				dbQuery("INSERT INTO tbl_issue (id_order,id_order_detail,price,id_problem,qty) VALUES ('$order_id','$detail_id','$detail_price','$id_problem','1')");
				dbQuery("UPDATE tbl_order SET complete = '1' where order_id = '$order_id'");
			}
			header("location:index.php?content=QC&order_id=".$order_id);
		}else{
			
		$not_order = "FAIL !!";
		header("location:index.php?content=QC&not_order=$not_order");
		}
	}
if($action == "confirm")
	{
		$order_id1 = $_GET['order_id1'];
		$sql_s="UPDATE tbl_order SET status = '9' WHERE order_id = '$order_id1'";
		dbQuery($sql_s);
		header("location:index.php?content=QC");

	}
if($action == "end_forced"){
		$order_id = $_GET['order_id1'];
		list($order_no,$customer_id,$shipping_id,$user_id,$shop_id,$urgent_id,$order_date_time,$order_due,$tracking_no,$order_qty,$order_code,$note) = dbFetchArray(dbQuery("SELECT order_no,customer_id,shipping_id,user_id,shop_id,urgent_id,order_date_time,order_due,tracking_no,order_qty,order_code,note from tbl_order where order_id = '$order_id'"));
		$qr =dbQuery("SELECT * FROM tbl_order_detail where order_id = '$order_id' and (status = '18')");	
		$row =@mysql_num_rows($qr);
		$i=0;
		$sum="";
		while ($i<$row){
		$rs=mysql_fetch_array($qr);
		$detail_weight = $rs['detail_weight'];
		$sum = $sum + $detail_weight;		
		$i++;
		}	
		dbQuery("INSERT INTO tbl_order(order_no,customer_id,shipping_id,user_id,shop_id,urgent_id,order_date_time,order_due,tracking_no,order_qty,order_amount,status_amount,weight,order_code,status,note,complete) values ('$order_no','$customer_id','$shipping_id','$user_id','$shop_id','$urgent_id','$order_date_time','$order_due','$tracking_no','$row','0','2','$sum','$order_code','6','$note','2')");
		list($order_id1) = dbFetchArray(dbQuery("SELECT order_id from tbl_order where order_no = '$order_no' and complete = '2'"));
		dbQuery("UPDATE tbl_order_detail SET order_id = '$order_id1' , status = '6' where order_id = '$order_id' and status = '18'");
		$sql_s="UPDATE tbl_order SET status = '9' WHERE order_id = '$order_id'";
		dbQuery($sql_s);
		header("location:index.php?content=QC");
}
	?>