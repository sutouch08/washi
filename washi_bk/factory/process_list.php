<div class="container">
	<table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="25%"><h4>No</h4></td><td width="10%"><h4>Name</h4></td><td width="20%"><h4>QTY</h4></td>
    <td width="20%"><h4>Time</h4></td><td width="10%"></td></tr></thead>
     
<?php
if(isset($_COOKIE['shop_id']) && $_COOKIE['shop_id'] !='')
{
	$shop_id = $_COOKIE['shop_id'];
	$sql ="SELECT * FROM fac_process LEFT JOIN tbl_employee ON fac_process.em_id = tbl_employee.em_id  WHERE status = '1' ORDER BY process_no DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	$no = 1;
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$process_id = $result['process_id'];
		$process_no = $result['process_no'];
		$em_name = $result['em_name'];
		$qty = $result['qty'];
		$datetime = $result['datetime'];
		 echo "<tr>";
		echo "<td>".$no."</td><td>".$process_no."</td><td>".$em_name."</td><td>".$qty."</td><td>".$datetime."</td><td><a href='process_finish.php?process_id=$process_id'><button type='button' class='btn btn-default btn-ss'>เสร็จสิ้น</button></a></td></tr>";
		 $i++;
		 $no++;
		}
}
?>
</table>
</div>