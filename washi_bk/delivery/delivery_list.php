<div class="container">
	<table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="25%"><h4>Order No.</h4></td><td width="10%"><h4>Qty.</h4></td><td width="20%"><h4>Order Date</h4></td>
    <td width="20%"><h4>Due Date</h4></td><td width="10%"><h4>Condition</h4></td><td width="10%"><h4>Status</h4></td></tr></thead>
     
<?php

	$shop_id = $_COOKIE['shop_id'];
	$sql ="SELECT * FROM tbl_order LEFT JOIN tbl_status ON tbl_order.status = tbl_status.status_id  LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id WHERE tbl_order.shop_id =".$shop_id."  ORDER BY tbl_order.urgent_id DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	$no = 1;
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$order_no = $result['order_no'];
		$qty = $result['order_qty'];
		$order_date = $result['order_date_time'];
		$due_date = $result['order_due'];
		$condition = $result['urgent_name'];
		$urgent_id = $result['urgent_id'];
		$status = $result['status_name'];
		if($urgent_id>1){echo "<tr style='color:red;'>";}else{ echo "<tr>";}
				echo "<td>".$no."</td><td>".$order_no."</td><td>".$qty."</td><td>".$order_date."</td><td>".$due_date."</td><td>".$condition."</td><td>".$status."</td></tr>";
		 $i++;
		 $no++;
		}
		


?>
</table>
</div>