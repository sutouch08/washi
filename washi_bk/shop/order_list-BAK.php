<script>
function setMindate(){
	var Mindate = document.getElementById('from_date').value;
	document.getElementById('to_date').setAttribute('min',document.getElementById('from_date').value);
}
</script>
<?php $today = date('Y-m-d');  ?>
 <div class="container">
    <h1 style="margin-top:0px; margin-bottom:0px;">Order List</h1>
    <hr style="margin-top:10px; margin-bottom:10px;" />
    <form method="post">
    <table border="0" width="100%"><tr><td width="15%">Select  duration from :</td><td width="15%"><input type="date" class="form-control"  name="from_date" id="from_date"  onchange="setMindate()" value="<?  if(isset($_POST['from_date'])&& $_POST['to_date']){ echo $from_date;} else { echo $today;} ?>"/></td>
    														 <td width="5%">&nbsp;&nbsp; to : </td><td width="15%"><input type="date" class="form-control"  name="to_date" id="to_date" value="<?  if(isset($_POST['from_date'])&& $_POST['to_date']){ echo $to_date;} else { echo $today; } ?>" /></td><td width="3%"></td><td width="10%"><input type="submit" class="form-control"  value="View"/></td><td></td></tr></table></form><hr />
    <table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="20%"><h4>Order No.</h4></td><td width="5%"><h4>Qty.</h4></td><td width="5%"><h4>Amount</h4></td><td width="20%"><h4>Order Date</h4></td>
    <td width="20%"><h4>Due Date</h4></td><td width="10%"><h4>Condition</h4></td><td width="15%"><h4>Status</h4></td></tr></thead>
   
    
      <?php
	  if(isset($_POST['from_date'])&& $_POST['to_date']){
		  $from_date = $_POST['from_date'];
		  $to_date = $_POST['to_date'];
	    $sql = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id  LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id LEFT JOIN tbl_status ON tbl_order.status = tbl_status.status_id WHERE order_date_time >='$from_date' AND order_date_time <= '$to_date' AND tbl_order.shop_id = '$shop_id' ORDER BY  tbl_order.order_date_time ASC";
	  }else{
		  $sql = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id  LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id LEFT JOIN tbl_status ON tbl_order.status = tbl_status.status_id WHERE order_date_time ='$today' AND  tbl_order.shop_id = '$shop_id' ORDER BY  tbl_order.order_date_time ASC";
	  }
		 
		$result = dbQuery($sql);
		$row = dbNumRows($result);
		if($row<1){
							echo "<tr><td colspan='8'><h3><div class='alert alert-success'>No Order for today or selected day.</div></h3></tr>";
		} else{ 
		$i=0;
		$no = 1;
		while($i<$row){
		$data = dbFetchArray($result);
		$order_id = $data['order_id'];
		$order_no = $data['order_no'];
		$qty = $data['order_qty'];
		$amount = $data['order_amount'];
		$order_date =$data['order_date_time'];
		$order_due = $data['order_due'];
		$customer_name = $data['customer_name'];
		$urgent_id = $data['urgent_id'];
		$urgent_status = $data['urgent_name'];
		$status = $data['status_name'];
		if($urgent_id>1){echo "<tr style='color:red;'>";}else{ echo "<tr>";}
		echo "<td><h4>".$no."</h4></td><td><h4>"; if($urgent_id>1){echo "<a style='color:red;'";}else{ echo "<a ";} echo "href=\"#\" onclick=\"showDetail(".$order_id.")\">".$order_no."</a></h4></td>
				<td><h4>".$qty."</h4></td><td><h4>".$amount."</h4></td>
				<td><h4>".date('d-m-Y',strtotime("$order_date"))."</h4></td>
				<td><h4>".date('d-m-Y',strtotime("$order_due"))."</h4></td>
				<td><h4>".$urgent_status."</h4></td>
				<td><h4>".$status."</h4></td></tr>";
																			$i++;
																			$no++;
																		}
}
																																	
		?>
        </table>
    
    </div><!-- /.container -->
