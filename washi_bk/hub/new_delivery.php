<?		$content = $_GET['content'];
		if($content == "new_factory"){$status = "4";}
		else if($content == "new_shop"){$status = "14";} 
	if(isset($_GET['delivery_id'])){
		$delivery_id =  $_GET['delivery_id'];
		$qr_d= dbQuery("select  * from tbl_delivery where delivery_id = '$delivery_id'");
		$rs_d = dbFetchArray($qr_d); 
		$driver_id = $rs_d['driver_id'];
		$car_id = $rs_d['car_id'];
		$target_id = $rs_d['target_id'];
		$qr_dri= dbQuery("select  * from tbl_driver where driver_id = '$driver_id'");
		$rs_dri = dbFetchArray($qr_dri); 
		$driver_name = $rs_dri['driver_name'];
		$driver_phone = $rs_dri['driver_phone'];
		$qr_c= dbQuery("select  * from tbl_car where car_id = '$car_id'");
		$rs_c = dbFetchArray($qr_c); 
		$car_plate = $rs_c['car_plate'];
		$car_brand = $rs_c['car_brand'];
		$capacity = $rs_c['capacity'];
		$qr_t= dbQuery("select  * from tbl_target where target_id = '$target_id'");
		$rs_t = dbFetchArray($qr_t);
		$target_name = $rs_t['target_name'];
	}else{
		$delivery_id = "";
	}
	?>

<div class="container">
<? if($delivery_id == ""){?>
<script language="javascript">
function fncSubmit()
{
	if(document.add_delivery.driver_id.value == "")
	{
		alert('Select driver');
		document.add_delivery.driver_id.focus();
		return false;
	}
	if(document.add_delivery.car_id.value == "")
	{
		alert('Select car');
		document.add_delivery.car_id.focus();
		return false;
	}
	document.add_delivery.submit();
}
</script>
  <form name="add_delivery" method="post" action="submit_deliver.php?action=driver&content=<?=$content;?>" onSubmit="JavaScript:return fncSubmit();">
    <table border="0" width="100%">
    	<tr>
        <td width="5%" align="right">Driver : </td>
        
        	<td width="20%">  
            <input type="hidden" name="status" value="<?=$status;?>" />
            <select name="driver_id"  class="form-control" id="driver_id" >
            <option  value=""> select driver </option>
            <?
           	$qr_dri= dbQuery("select  * from tbl_driver ORDER BY driver_name ASC ");
	$row = mysql_num_rows($qr_dri);
	$i=0;												
	while($i<$row){
	$rs_dri = dbFetchArray($qr_dri); 
	$driver_id1 = $rs_dri['driver_id'];
	$driver_name1 = $rs_dri['driver_name'];
	 echo "<option value='$driver_id1'>$driver_name1</option>";
	 $i++;
	}
    ?>        
   </select>      
            </td>    
            <td width="5%" align="right">Car : 
            </td>
            <td width="20%">
            <select name="car_id" id="car_id"  class="form-control" >
            <option value=""> select car </option>
            <?
    $qr_c= dbQuery("select  * from tbl_car ORDER BY car_plate ASC ");
	$row = mysql_num_rows($qr_c);
	$i=0;												
	while($i<$row){
	$rs_c = dbFetchArray($qr_c); 
	$car_id1 = $rs_c['car_id'];
	$car_plate1 = $rs_c['car_plate'];
	 echo "<option value='$car_id1'>$car_plate1</option>";
	 $i++;
	}
    ?>        
   </select> 
    </td>
    <td width="3%"  align="right">
    </td>
<td width="5%"><input type="submit" class="form-control"  value="Save">
</td>
<td width="3%"></td>
        	<td width="20%"></td>
            <td width="24%"> 
    </td>
        </tr>
        </table>
        <? }else{?>
      <table border="0" width="100%">
      <tr>
    	  <td align="right">DRIVER NAME : </td>
    	  <td><h4><input type="text" name="" value="<?=$driver_name;?>" class="input-label" disabled="disabled"  /></h4></td>
    	  <td>CAR PLATE : </td>
    	  <td><h4><input type="text" name="" value="<?=$car_plate;?>" class="input-label" disabled="disabled"  /></h4></td>
    	  <td>TARGET : </td>
    	  <td><h4><input type="text" name="" value="<?=$target_name;?>" class="input-label" disabled="disabled"  /></h4></td>
    	  <td></td>
    	  <td>&nbsp;</td>
    	  <td></td>
  	  </tr>
      <tr>
        <td align="right">DRIVER PHONE</td>
        <td><h4><input type="text" name="" value="<?=$driver_phone;?>" class="input-label" disabled="disabled"  /></h4></td>
        <td>Car Brand</td>
        <td><h4><input type="text" name="" value="<?=$car_brand;?>" class="input-label" disabled="disabled"  /></h4></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td></td>
        <td>&nbsp;</td>
        <td></td>
      </tr>
        
        
     </table>
     <? }?>
  </form>
     <hr style="margin-top:5px; margin-bottom:5px;" />
<? if($delivery_id != ""){
	@$not_order = $_GET['not_order'];
	?>
    <form method="post" action="submit_deliver.php?action=driver_order&content=<?=$content;?>" id="submit_order_code" >
        <table border="0" width="100%">
        <tr >
        <td width="10%"  align="right">Order code : </td>
        <td width="20%"><input type="text" name="order_code" class="form-control" required autofocus /> </td>
        <td width="2%"><input type="hidden" name="delivery_id" id="delivery_id" value="<?=$delivery_id;?>" /><input type="hidden" name="content" value="<?=$content;?>"  /><input type="hidden" name="status" value="<?=$status;?>"  /></td>
        <td width="10%"><input type="submit" class="form-control" value="Add" /></td>
        <td width="10"></td>
        <td width="43%"><? if($not_order != "" ){echo "<div class='alert h4 alert-danger'><center>$not_order</center></div>";}?></td>
        </tr>
        </table>
        </form>
        
         <hr style="margin-top:6px; margin-bottom:0px;" />
    <div class="row"> 
  <?php
	
	$sql ="SELECT * FROM tbl_order LEFT JOIN tbl_status ON tbl_order.status = tbl_status.status_id  LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id LEFT JOIN tbl_delivery_detail ON tbl_order.order_id = tbl_delivery_detail.order_id WHERE tbl_order.status = '$status'+1 and delivery_id = '$delivery_id' ORDER BY tbl_order.urgent_id DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
		$i=0;
	$no = 1;
	$content1 = "";
	$sum_weight1 = "0";
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
		 $weight1 = $result['weight']; //น้ำหนัก
		 $complete = $result['complete'];
                $sum_weight1 = $sum_weight1 + $weight1; //น้ำหนักรวม
				$sum_weight2 = $capacity-$sum_weight1;
		$status_name = $result['status_name'];
		$delivery_detail_id = $result['delivery_detail_id'];
		if($urgent_id>1){$content1.= "<tr style='color:red;'>";}else{ $content1.= "<tr>";}
				$content1.= "<td>".$no."</td><td>".$order_no."".more($complete)."</td><td>".$qty."</td><td>".$weight1."</td><td>".$order_date."</td><td>".$due_date."</td><td>".$condition."</td><td>".$status_name."</td><td><a href='submit_deliver.php?action=del_order&delivery_id=$delivery_id&delivery_detail_id=$delivery_detail_id&order_id=$order_id&content=$content&status=$status'><input type='button' class='btn btn-default btn-xs' value='DEL'/></td></tr>";
		 $i++;
		 $no++;
		}
		if($row < 1 ){
		$content1.= "<tr><td colspan='8'><div class='alert alert-success'><center>Not order</center></div></td></tr>";	
		$sum_weight2 = "0";
		}

?>
      <table class="table table-hover">
       <thead>
          <tr><td colspan="4"><h4>รถ</h4></td><td align="right"><h4>บรรทุกได้ : </h4></td><td align="left"><h4><?php echo $capacity;?> กก.</h4></td><td align="right"><h4><? if($capacity < "$sum_weight1"){ echo "<FONT COLOR=red>น้ำหนักเกิน</FONT>";}else{echo "เหลือ";}?> : </h4></td><td align="left"><h4><?php if($capacity < "$sum_weight1"){ $over = $sum_weight1 - $capacity; echo "<FONT COLOR=red>$over กก.</FONT>";}else{echo "$sum_weight2 กก.";}?> </h4></td></tr>
    <tr ><td width="5%">#</td><td width="20%">Order No.</td><td width="5%">Qty.</td><td width="5%">หนัก</td><td width="15%">Order Date</td>
    <td width="15%">Due Date</td><td width="10%">Condition</td><td width="20%">Status</td><td width="5%"></td></tr>	</thead>
     
<? echo $content1;?>
</table>
    </div>
   <?  
    
}else{
	echo "<div class='col-sm-12'><h3><div class='alert alert-success'><center>Select car</center></div></h3></div>";
}
	
?>
        <hr style="margin-top:0px; margin-bottom:0px;" />
   
    <div class="row"> <?php
	$sql ="SELECT * FROM tbl_order LEFT JOIN tbl_status ON tbl_order.status = tbl_status.status_id  LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id WHERE tbl_order.status = '$status' ORDER BY tbl_order.urgent_id DESC";
	$query=dbQuery($sql);
	$row = dbNumRows($query);
	$i=0;
	$no = 1;
	$content1 = "";
	$sum_weight = "0";
	while($i<$row)
	{
		$result = dbFetchArray($query);
		$order_no = $result['order_no'];
		$qty = $result['order_qty'];
		$order_date = $result['order_date_time'];
		$due_date = $result['order_due'];
		$condition = $result['urgent_name'];
		$urgent_id = $result['urgent_id'];
		$weight = $result['weight'];
		 $complete = $result['complete'];
		$sum_weight = $sum_weight + $weight;
		$status_name = $result['status_name'];
		if($urgent_id>1){$content1.= "<tr style='color:red;'>";}else{ $content1.= "<tr>";}
				$content1.= "<td>".$no."</td><td>".$order_no."".more($complete)."</td><td>".$qty."</td><td>".$weight."</td><td>".$order_date."</td><td>".$due_date."</td><td>".$condition."</td><td>".$status_name."</td><td></td></tr>";
		 $i++;
		 $no++;
		}
		if($row < 1 ){
		$content1.= "<tr><td colspan='8'><div class='alert alert-success'><center>Not order</center></div></td></tr>";	
		}

?>
   <table class="table table-hover">
     <thead>
          <tr><td colspan="4"><h4>CAR</h4></td><td align="right"><h4>จำนวน ORDER : </h4></td><td align="left"><h4><?php echo $row;?> ORDER</h4></td><td align="right"><h4>หนัก : </h4></td><td align="left"><h4><?php echo $sum_weight;?> กก.</h4></td></tr>
    <tr ><td width="5%">#</td><td width="20%">Order No.</td><td width="5%">Qty.</td><td width="5%">หนัก</td><td width="15%">Order Date</td>
    <td width="15%">Due Date</td><td width="10%">Condition</td><td width="20%">Status</td><td width="5%"></td></tr>	</thead>
    <? echo $content1;?> 

</table>

  </div>
 
</div>
    </div>                                        
                                      
   </div>

    </div><!-- /.container -->