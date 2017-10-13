<?php 
		if(isset($_GET['order_id'])){		
		$order_id = $_GET['order_id'];
		$sql = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id LEFT JOIN tbl_shipping ON tbl_order.shipping_id = tbl_shipping.shipping_id  LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id WHERE tbl_order.order_id=".$order_id;
		$result = dbQuery($sql);
		$data = dbFetchArray($result);
		$customer_name = $data['customer_name'];
		$address = $data['customer_address'];
		$phone = $data['customer_phone'];
		$email = $data['customer_email'];
		$order_no = $data['order_no'];
		$tracking_no = $data['tracking_no'];
		$shipping = $data['shipping_name'];
		$urgent = $data['urgent_name'];
		$qty = $data['order_qty'];
		$amount =$data['order_amount'];
		$due = $data['order_due'];
		$order_date = $data['order_date_time'];
		$note = $data['note'];
	}
		
?>
<div class="container">
<div class="row">
	<div class="col-sm-6">
	<table border="0"  width="100%" >
    	<tr><td width="20%" align="right">Name :</td><td colspan="3" align="left">&nbsp;<? echo $customer_name ; ?></td></tr>
        <tr><td width="20%" align="right" valign="top">Address :</td><td colspan="3" align="left">&nbsp;<? echo $address ; ?></td></tr>
        <tr><td width="20%" align="right">Phone :</td><td width="30%" align="left"><? echo $phone ; ?>&nbsp;</td><td width="20%" align="right">Email :</td><td width="30%" align="left">&nbsp;<? echo $email ; ?></td></tr>
     </table>
     </div>
     <div class="col-sm-6">
     <table border="0" width="100%">
    	<tr><td width="20%" align="right">Order No :</td><td width="30%" align="left">&nbsp;<? echo $order_no ; ?></td><td width="20%" align="right">Tracking no :</td><td width="30%" align="left">&nbsp;<? echo $tracking_no; ?></td></tr>
        <tr><td width="20%" align="right">Delivery :</td><td width="30%" align="left">&nbsp;<? echo $shipping; ?></td><td width="20%" align="right">Condition :</td><td width="30%" align="left">&nbsp;<? echo $urgent; ?></td></tr>
        <tr><td width="20%" align="right">Quantity :</td><td width="30%" align="left">&nbsp;<? echo $qty ; ?>   Item.</td><td width="20%" align="right">Amount :</td><td width="30%" align="left">&nbsp;<? echo $amount ; ?>   THB.</td></tr>
        <tr><td width="20%" align="right">Order Date :</td><td width="30%" align="left">&nbsp;<? echo date('d-m-Y',strtotime("$order_date")) ; ?></td><td width="20%" align="right">Order Due :</td><td width="30%" align="left">&nbsp;<? echo date('d-m-Y',strtotime("$due")); ?></td></tr>
     </table>
     </div>
 </div><hr />
 <table class="table table-hover">
 	<thead><td width="5%"><h4>#</h4></td><td width="45%"><h4>Description</h4></td><td width="10%"><h4>Quantity</h4></td><td width="10%"><h4>Price</h4></td><td width="30%"><h4>Status</h4></td></thead>
 <?php 
 			$qr="SELECT * FROM tbl_order_detail LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_status ON tbl_order_detail.status=tbl_status.status_id  WHERE  tbl_order_detail.order_id =".$order_id;
			$query = dbQuery($qr);			
			$row = dbNumRows($query);
			$i = 0;
			$no = 1;
			while($row>$i){
				$detail = dbFetchArray($query);
				$product = $detail['product_name'];
				$detail_qty = $detail['qty'];
				$price = $detail['detail_price'];
				$status = $detail['status_name'];
				echo  "<tr><td>".$no."</td><td align='left'>".$product."</td><td>".$detail_qty."</td><td>".$price."</td><td>".$status."</td></tr>";
				$i++;
				$no++;
			}
			
				?>
                </table>
                <table width="50%">
                <tr>
                <td width="10%" align="right">หมายเหตุ : </td>
                <td width="40%" align="left"><?=$note;?></td>
                </tr>
                </table>
                <br />
                <br />
                <br />
                
                <div class="col-sm-12"><button type="button" class="btn btn-default "  onclick="orderList()">Goback</button></div>
			
 </div>
     
     