<script language="JavaScript">
	function ClickCheckAll(vol)
	{
	
		var i=1;
		for(i=1;i<=document.c_order.hdnCount.value;i++)
		{
			if(vol.checked == true)
			{
				eval("document.c_order.order"+i+".checked=true");
			}
			else
			{
				eval("document.c_order.order"+i+".checked=false");
			}
		}
	}
	
	</script>
<div class="container">
<form name="c_order" action="close_order.php" method="post" >
	<table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="25%"><h4>Order No.</h4></td><td width="5%"><h4>Qty.</h4></td><td width="20%"><h4>Order Date</h4></td>
    <td width="20%"><h4>Due Date</h4></td><td width="10%"><h4>Condition</h4></td><td width="10%"><h4>Status</h4></td><td width="5%"><h4><input name="CheckAll" type="checkbox" id="CheckAll" value="Y"  onClick="ClickCheckAll(this);"></h4></td></tr></thead>
     
<?php
	$sql ="SELECT * FROM tbl_order LEFT JOIN tbl_status ON tbl_order.status = tbl_status.status_id  LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id WHERE tbl_order.status IN (10,11,12) ORDER BY tbl_order.urgent_id DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	$no = 1;
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$order_id = $result['order_id'];
		$order_no = $result['order_no'];
		$qty = $result['order_qty'];
		$order_date = $result['order_date_time'];
		$due_date = $result['order_due'];
		$condition = $result['urgent_name'];
		$urgent_id = $result['urgent_id'];
		$status = $result['status_name'];
		$complete = $result['complete'];
		if($urgent_id>1){echo "<tr style='color:red;'>";}else{ echo "<tr>";}
				echo "<td>".$no."</td><td>".$order_no."".more($complete)."</td><td>".$qty."</td><td>".$order_date."</td><td>".$due_date."</td><td>".$condition."</td><td>".$status."</td><td><input name='order[]' type='checkbox' id='order".$no."' value=".$order_id." /></td></tr>";
		 $i++;
		 $no++;
		}


?>
</table>
<table width="10%" align="center">
<tr>
<td>
 <input type="submit" name="button" id="button" class="form-control" value="ส่งแล้ว" />
 <input type="hidden" name="hdnCount" value="<?=$i;?>">
 </td>
 </tr>
 </table>
</form>
</div>