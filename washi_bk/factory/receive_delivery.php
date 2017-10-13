<?

		if(isset($_GET['car_id']))
		{ $car_id = $_GET['car_id'];
		}else{
		@$car_id = $_POST['car_id'];
		}
		$qr_c= dbQuery("select  * from tbl_car where car_id = '$car_id'");
		$rs_c = dbFetchArray($qr_c); 
		$car_plate = $rs_c['car_plate'];
		$car_brand = $rs_c['car_brand'];
		?>
		<div class="container"> 
        <? if($car_id == ""){
			?>
            <form name="add_delivery" method="post" action="index.php?content=Receive" >
            <table border="0" width="100%">
          <tr>
          <td width="10%" align="right">Car : </td>
          <td width="20%">
       
            <select name="car_id" class="form-control" >

              <option selected="selected">Select Car</option>
               <?
           	$qr_c= dbQuery("select  * from tbl_car ORDER BY car_plate ASC ");
	$row = mysql_num_rows($qr_c);
	$i=0;												
	while($i<$row){
	$rs_c = dbFetchArray($qr_c); 
	$car_id = $rs_c['car_id'];
	$car_plate = $rs_c['car_plate'];
	 echo "<option value='$car_id'>$car_plate</option>";
	 $i++;
	}
	?>
            </select>
          
          </td>
          <td width="5%"></td>
          <td width="10%"><input type="submit" value="OK" class="form-control"  /></td>
          <td width="55%"></td>
          </tr>
          </table>
          </form>
 <? }else{ ?>

	 <table border="0" width="100%">
     <tr>
     <td width="20%" align="right">Car plate : </td>
     <td width="10%" align="left"> <h4><?=$car_plate;?>  </h4></td>
     <td width="10%" align="right">Brand Car : </td>
     <td width="20%" align="left"><h4><?=$car_brand;?></h4></td>
     <td width="40%"></td>
     </tr>
     </table>
   
      <hr style="margin-top:6px; margin-bottom:0px;" />
     <form method="post" action="submit_receive.php?action=driver_order&content=Receive" id="submit_order_code" >
        <table border="0" width="100%">
        <tr >
        <td width="10%"  align="right">Order code : </td>
        <td width="20%"><input type="text" name="order_code" class="form-control" required autofocus /> </td>
        <td width="2%"><input type="hidden" name="car_id" id="car_id" value="<?=$car_id;?>" /><input type="hidden" name="status" value="<?=$status;?>"/></td>
        <td width="10%"><input type="submit" class="form-control" value="Add" /></td>
        <td width="10"></td>
        <td width="43%"><? @$not_order = $_GET['not_order'];if($not_order != "" ){echo "<div class='alert h4 alert-danger'><center>$not_order</center></div>";}?></td>
        </tr>
        </table>
        </form>
      <hr style="margin-top:6px; margin-bottom:0px;" />
    <div class="row"> 
       
<?php
	$date1 = date('Y-m-d');
	$sql ="SELECT * FROM tbl_delivery_detail  LEFT JOIN tbl_delivery ON tbl_delivery_detail.delivery_id = tbl_delivery.delivery_id LEFT JOIN tbl_order ON tbl_delivery_detail.order_id = tbl_order.order_id where tbl_delivery.car_id = '$car_id' and tbl_delivery_detail.status = '6' and tbl_delivery.delivery_date LIKE  '%$date1%' ORDER BY urgent_id DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
		$i=0;
	$no = 1;
	$content = "";
	$sum_weight = "0";
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$delivery_id = $result['delivery_id'];
		$order_id = $result['order_id'];
		$order_no = $result['order_no'];
		$qty = $result['order_qty'];
		$order_date = $result['order_date_time'];
		$due_date = $result['order_due'];
		$shop_id = $result['shop_id'];
		$qr_s= dbQuery("select  * from tbl_shop where shop_id = '$shop_id'");
		$rs_s = dbFetchArray($qr_s);
		$shop_name = $rs_s['shop_name']; 
		$status1 = $result['status'];
		$weight = $result['weight'];
		$sum_weight = $sum_weight + $weight;
		$qr_s= dbQuery("select  * from tbl_status where status_id = '$status1'");
		$rs_s = dbFetchArray($qr_s);
		$status_name = $rs_s['status_name'];
		//$urgent_name = $result['urgent_name'];
		$urgent_id = $result['urgent_id'];
		//$status = $result['status_name'];
		$delivery_detail_id = $result['delivery_detail_id'];
		if($urgent_id>1){$content.= "<tr style='color:red;'>";}else{ $content.= "<tr>";}
				$content.= "<td>".$no."</td><td>".$order_no."</td><td>".$qty."</td><td>".$weight."</td><td>".$order_date."</td><td>".$due_date."</td><td>".$shop_name."</td><td>".$status_name."</td><td><a href='submit_receive.php?action=del_order&order_id=$order_id&content=Receive&car_id=$car_id'><input type='button' class='btn btn-default btn-xs' value='DEL'/></td></tr>";
		 $i++;
		 $no++;
		}
		if($row < 1 ){
		$content.= "<tr><td colspan='8'><div class='alert alert-success'><center>Not order</center></div></td></tr>";	
		}
?>
      <table class="table table-hover">
 <thead>
          <tr><td colspan="4"><h4>FACTORY</h4></td><td align="right"><h4>จำนวน ORDER : </h4></td><td align="left"><h4><?php echo $row;?> ORDER</h4></td><td align="right"><h4>หนัก : </h4></td><td align="left"><h4><?php echo $sum_weight;?> กก.</h4></td></tr>
    <tr ><td width="5%">#</td><td width="20%">Order No.</td><td width="5%">Qty.</td><td width="5%">หนัก</td><td width="15%">Order Date</td>
    <td width="15%">Due Date</td><td width="10%">Condition</td><td width="20%">Status</td><td width="5%"></td></tr>	</thead>
<? echo $content;?>
</table>
    </div>
     <hr style="margin-top:0px; margin-bottom:0px;" />
   
    <div class="row"> <?php

	$sql ="SELECT * FROM tbl_delivery_detail LEFT JOIN tbl_delivery ON tbl_delivery_detail.delivery_id = tbl_delivery.delivery_id LEFT JOIN tbl_order ON tbl_delivery_detail.order_id = tbl_order.order_id where tbl_delivery.car_id = '$car_id'  and tbl_delivery_detail.status = '5' ORDER BY urgent_id DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	$no = 1;
	$content = "";
	$sum_weight = "0";
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$order_no = $result['order_no'];
		$qty = $result['order_qty'];
		$order_date = $result['order_date_time'];
		$due_date = $result['order_due'];
		$shop_id = $result['shop_id'];
		$qr_s= dbQuery("select  * from tbl_shop where shop_id = '$shop_id'");
		$rs_s = dbFetchArray($qr_s);
		$shop_name = $rs_s['shop_name']; 
		$status1 = $result['status'];
		$weight = $result['weight'];
		$sum_weight = $sum_weight + $weight;
		$qr_s= dbQuery("select  * from tbl_status where status_id = '$status1'");
		$rs_s = dbFetchArray($qr_s);
		$status_name = $rs_s['status_name'];
		//$condition = $result['urgent_name'];
		$urgent_id = $result['urgent_id'];
		//$status = $result['status_name'];
		if($urgent_id>1){$content.= "<tr style='color:red;'>";}else{ $content.= "<tr>";}
				$content.= "<td>".$no."</td><td>".$order_no."</td><td>".$qty."</td><td>".$weight."</td><td>".$order_date."</td><td>".$due_date."</td><td>".$shop_name."</td><td>".$status_name."</td><td></td></tr>";
		 $i++;
		 $no++;
		}
		if($row < 1 ){
		$content.= "<tr><td colspan='8'><div class='alert alert-success'><center>Not order</center></div></td></tr>";	
		}

?>
   <table class="table table-hover">
       <thead>
          <tr><td colspan="4"><h4>CAR</h4></td><td align="right"><h4>จำนวน ORDER : </h4></td><td align="left"><h4><?php echo $row;?> ORDER</h4></td><td align="right"><h4>หนัก : </h4></td><td align="left"><h4><?php echo $sum_weight;?> กก.</h4></td></tr>
    <tr ><td width="5%">#</td><td width="20%">Order No.</td><td width="5%">Qty.</td><td width="5%">หนัก</td><td width="15%">Order Date</td>
    <td width="15%">Due Date</td><td width="10%">Condition</td><td width="20%">Status</td><td width="5%"></td></tr>	</thead>
     <? echo $content;?>

</table>
</table>
  </div>
 
</div> 
	 
          
  <? }?>      
		</div>