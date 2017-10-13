 <div class="container">
    <h1 style="margin-top:0px; margin-bottom:0px;">Finish Order</h1>
    <hr style="margin-top:10px; margin-bottom:10px;" />
    <table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="20%"><h4>Order No.</h4></td><td width="10%"><h4>Qty.</h4></td><td width="10%"><h4>Amount</h4></td><td width="20%"><h4>Customer</h4></td><td width="15%"><h4>Shipping</h4></td><td width="10%"><h4>Due Date</h4></td><td width="10%"><h4>Condition</h4></td></tr></thead>
    
      <?php 
	    $sql = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id  LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id LEFT JOIN tbl_shipping ON tbl_order.shipping_id = tbl_shipping.shipping_id where tbl_order.status = '9'  ORDER BY tbl_order.urgent_id DESC";
		$result = dbQuery($sql);
		$row = dbNumRows($result);
		if($row<1){
			echo "<tr><td colspan='8'><h3><div class='alert alert-success'>No more product to apply barcode in this order.</div></h3></td></tr>
				 <tr><td colspan='8'><button type='button' class='btn btn-default' onclick='backHome()' value='Go Back' />Go back</button></td></tr>";
} else{ 
		$i=0;
		$no=1;
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
		$shipping_name = $data['shipping_name'];
		$complete = $data['complete'];
		if($urgent_id >1) { echo "<tr style='color:red;'>";	}else{echo "<tr>";}
								echo "<td>".$no."</td><td>"; if($urgent_id >1) {echo"<a style='color:red;'";}else{ echo "<a";} echo" href=\"#\" onclick=\"showDetail(".$order_id.")\">".$order_no."</a>".more($complete)."</td><td>".$qty."</td><td>".$amount."</td><td align=\"left\">".$customer_name."</td><td>".$shipping_name."</td><td>".date('d-m-Y',strtotime("$order_due"))."</td><td>".$urgent_status."</td></tr>";
																											
$i++;
$no++;
}
}
		?>
        </table>
    </div><!-- /.container -->
