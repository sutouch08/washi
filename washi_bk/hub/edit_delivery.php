<div class="container">
	<table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="30%"><h4>Name Driver.</h4></td><td width="10%"><h4>Car Plate.</h4></td><td width="20%"><h4>Target</h4></td><td width="20%"><h4>Time</h4></td><td width="10%"></td>
    </tr></thead>
     
<?php
	
	$sql ="SELECT * FROM tbl_delivery LEFT JOIN tbl_driver ON tbl_delivery.driver_id = tbl_driver.driver_id LEFT JOIN tbl_car ON tbl_delivery.car_id = tbl_car.car_id LEFT JOIN tbl_target ON tbl_delivery.target_id = tbl_target.target_id where tbl_delivery.shop_id = '$shop_id' and tbl_delivery.status IN (5,15) ORDER BY tbl_delivery.delivery_id DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	$no = 1;
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$delivery_id = $result['delivery_id'];
		$driver_name = $result['driver_name'];
		$car_plate = $result['car_plate'];
		$delivery_date = $result['delivery_date'];
		$target_name = $result['target_name'];
				echo "<tr><td>".$no."</td><td>".$driver_name."</td><td>".$car_plate."</td><td>".$target_name."</td><td>".$delivery_date."</td><td><a href='index.php?content=Edit&delivery_id=$delivery_id'><input type='button' class='btn btn-default btn-xs' value='EDIT'/></a></td></tr>";
		 $i++;
		 $no++;
		}

?>
</table>

</div>
