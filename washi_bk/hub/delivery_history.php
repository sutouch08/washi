<div class="container">
	<table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="30%"><h4>Order No</h4></td><td width="20%"><h4>Target</h4></td><td width="20%"><h4>Time</h4></td><td width="20%"><h4>Car Plate</h4></td>
    </tr></thead>
     
<?php
$shop_id = $_COOKIE['shop_id'];
	$sql ="SELECT * FROM tbl_delivery_detail LEFT JOIN tbl_order ON tbl_delivery_detail.order_id = tbl_order.order_id LEFT JOIN tbl_delivery ON tbl_delivery_detail.delivery_id = tbl_delivery.delivery_id where tbl_delivery.shop_id = '$shop_id' and tbl_delivery.status IN (5,6,16,15)  ORDER BY tbl_delivery.delivery_id DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	$no = 1;
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$order_no = $result['order_no'];
		$delivery_date = $result['delivery_date'];
		$target_id = $result['target_id'];
		$car_id = $result['car_id'];
		$qr_c= dbQuery("select * from tbl_car where car_id = '$car_id'");
		$rs_c = dbFetchArray($qr_c);
		$car_plate =$rs_c['car_plate'];
		$qr_t= dbQuery("select * from tbl_target where target_id = '$target_id'");
		$rs_t = dbFetchArray($qr_t);
		$target_name = $rs_t['target_name'];
		echo "<tr><td>".$no."</td><td>".$order_no."</td><td>".$target_name."</td><td>".$delivery_date."</td><td>".$car_plate."</td></tr>";
		 $i++;
		 $no++;
		}

?>
</table>

</div>
