  <script src="<?php echo WEB_ROOT;?>library/js/jquery-1.9.1.js"></script> 
  	<script src="<?php echo WEB_ROOT;?>library/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="<?php echo WEB_ROOT;?>dist/js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="<?php echo WEB_ROOT;?>library/css/jquery-ui-1.10.2.custom.css" />
<div class="container">

<div class="col-sm-12">
    <table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="30%"><h4>โปรโมชั่น</h4></td><td width="10%"><h4>เริ่ม</h4></td><td width="10%"><h4>หมด</h4></td><td width="10%"><h4>ระยะเวลา</h4></td><td width="10%"><h4>จำนวน(ชิ้น)</h4></td><td width="5%"><h4>จำนวน(บาท)</h4></td><td width="5%"><h4>ส่วนลด</h4></td><td width="10%"><h4>ราคา</h4></td><td width="5%"></td></tr></thead>
    
      <?php 
	    $sql = "SELECT promo_id,promo_name,promo_duration,promo_pcs,promo_money,promo_discount,promo_price,DATE_FORMAT(promo_start, '%d-%m-%Y') AS promo_start,DATE_FORMAT(promo_end, '%d-%m-%Y') AS promo_end FROM tbl_promo where promo_price != '0' ORDER BY promo_id ASC";
		$result = dbQuery($sql);
		$row = dbNumRows($result);
		if($row<1){
							echo "<tr><td colspan='9'><h3><div class='alert alert-success'>No more product to apply barcode in this order.</div></h3></td></tr>
									 <tr><td colspan='9'><button type='button' class='btn btn-default' onclick='backHome()' value='Go Back' />Go back</td></tr>";
} else{ 
		$i=0;
		$no=1;
		while($i<$row){
		$data = dbFetchArray($result);
		$promo_id = $data['promo_id'];
		$promo_name = $data['promo_name'];
		$promo_start = $data['promo_start'];
		$promo_end = $data['promo_end'];
		$promo_duration = $data['promo_duration'];
		$promo_pcs = $data['promo_pcs'];
		$promo_money = $data['promo_money'];
		$promo_discount = $data['promo_discount'];
		$promo_price = $data['promo_price'];
		
		echo  "<tr><td>";
							?>
	
<div class="modal fade" id="myModal<?=$no?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?=$promo_name;?></h4>
      </div>
      <div class="modal-body">
<form method="post" name="add_pro<?=$no?>" action="submit_buy_promo.php" onSubmit="return check<?=$no;?>()" >
<input type="hidden" name="promo_price" id="promo_price<?=$no?>" value="<?=$promo_price;?>" />
<input type="hidden" name="promo_id" value="<?=$promo_id;?>" />
<input type="hidden" name="promo_start" value="<?=$promo_start;?>" />
<input type="hidden" name="promo_end" value="<?=$promo_end;?>" />
<input type="hidden" name="promo_duration" value="<?=$promo_duration;?>" />
<input type="hidden" name="promo_pcs" value="<?=$promo_pcs;?>" />
<input type="hidden" name="promo_money" value="<?=$promo_money?>" />

<table width="100%">
<tr height="50">
<td width="30%" align="right">รหัส : </td>
<td width="40%"><input name="customer_code" type="text" id="customer_code" class="form-control" autocomplete="off"  required ></td>
<td width="30%"></td>
</tr>
<tr height="50">
<td align="right">จำนวน : </td>
<td align="left"><input name="number" type="text" id="number<?=$no;?>" size="5" onfocus="startCalc<?=$no?>()" onblur="stopCalc<?=$no?>()" autocomplete="off" required></td>
<td></td>
</tr>
<tr height="50">
<td align="right">จำนวนเงิน : </td>
<td align="left"><input name="money" type="text" id="money<?=$no;?>" class="input-label" onfocus="startCalc<?=$no?>()" onblur="stopCalc<?=$no?>()"  readonly="true"></td>
<td></td>
</tr>
<tr height="50">
<td align="right">รับ : </td>
<td align="left"><input name="received" type="text" id="received<?=$no;?>" class="form-control" onfocus="startCalc<?=$no?>()" onblur="stopCalc<?=$no?>()" autocomplete="off" required  ></td>
<td></td>
</tr>
<tr height="50">
<td  align="right">ทอน : </td>
<td align="left"><input name="change" type="text" id="change<?=$no;?>" class="input-label" onfocus="startCalc<?=$no?>()" onblur="stopCalc<?=$no?>()" readonly="true" ></td>
<td></td>
</tr>
</table>  
<SCRIPT Language="JavaScript">
function startCalc<?=$no?>(){ 
interval = setInterval("calc<?=$no?>()",1); 
} 
function calc<?=$no?>(){ 
number<?=$no?> = document.add_pro<?=$no?>.number<?=$no?>.value; 
promo_price<?=$no?> = document.add_pro<?=$no?>.promo_price<?=$no?>.value; 
document.add_pro<?=$no?>.money<?=$no?>.value = (number<?=$no?>) * (promo_price<?=$no?>);
money<?=$no?> = document.add_pro<?=$no?>.money<?=$no?>.value;
received<?=$no?> = document.add_pro<?=$no?>.received<?=$no?>.value;
document.add_pro<?=$no?>.change<?=$no?>.value = (received<?=$no?>) - (money<?=$no?>);
} 
function stopCalc<?=$no?>(){ 
clearInterval(interval); 
} 
</SCRIPT>
<script>
function check<?=$no?>(){
var money=document.add_pro<?=$no?>.money<?=$no?>.value;
var received=document.add_pro<?=$no?>.received<?=$no?>.value;
	//alert('Y' + money);
	if(parseInt(money)>parseInt(received)){ 
	alert('คุณรับเงินไม่ครบ');
	return false;
	}
}
</script>
<script>
 $("#number<?=$no;?>").spinner({numberFormat:"n", min:0 });
</script>
  	<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
   </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
     
<?	echo "".$no."</td><td  align=left>".$promo_name."</td><td>".$promo_start."</td><td>".$promo_end."</td><td>".$promo_duration."</td><td>".$promo_pcs."</td><td>".$promo_money."</td><td>".$promo_discount."</td><td>".$promo_price."</td><td><a style='color:red;' href='' ><button type=\"button\" name=\"button\" id=\"button\"  class=\"btn btn-default btn-xs\" data-toggle=\"modal\" data-target=\"#myModal".$no."\" ><img src=\"../images/UI/add.png\" width=\"20\" height=\"20\"></button></a></td></tr>";
																											
	$i++;
	$no++;
																		}
}
																																	
		?>
        </table>
     
</div>
</div>
