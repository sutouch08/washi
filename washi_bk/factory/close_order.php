<?
require_once '../library/config.php';
require_once '../library/functions.php';
checkUser();
	if(isset($_POST['order']))
	{
 for($i=0;$i<count($_POST["order"]);$i++)
 {
	
	
  if($_POST["order"][$i] != "")
  {
	
 $sql1 = "UPDATE tbl_order SET status = '17' WHERE order_id = '".$_POST['order'][$i]."' ";
dbQuery($sql1);
 $sql = "UPDATE tbl_order_detail SET status = '17' WHERE order_id = '".$_POST['order'][$i]."' ";
dbQuery($sql);
$sql2 = "UPDATE tbl_delivery_detail SET status = '17' WHERE status IN (10,11,12)  and order_id = '".$_POST['order'][$i]."' ";
dbQuery($sql2);
$sql4 = "select * from tbl_delivery_detail where status = '17' and  order_id = '".$_POST['order'][$i]."'";
$qr_d= dbQuery($sql4) or die("error $sql4");
		$rs_d = dbFetchArray($qr_d) ; 
		$delivery_id = $rs_d['delivery_id'];

		$sql11 = "select * from tbl_delivery_detail where status IN (10,11,12) and delivery_id = '$delivery_id'";
		$qr_1= dbQuery($sql11) or die("error $sql11");
		$rs_1 = dbFetchArray($qr_1);
		$delivery_detail_id = $rs_1['delivery_detail_id'];
		if($delivery_detail_id == ""){
			
		$sql3 = "UPDATE tbl_delivery SET status = '17' WHERE delivery_id = '$delivery_id'";
		dbQuery($sql3);
		
		}
// echo $sql3;
  }
 }

 }
header("location:index.php?content=deliveryEnd");
?>