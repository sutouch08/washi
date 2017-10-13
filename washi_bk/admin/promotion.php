<?
checkPermission();
?>
<script src="../library/js/bootstrap.js"></script>
<script src="<?php echo WEB_ROOT;?>library/js/jquery-1.9.1.js"></script> 
<script src="<?php echo WEB_ROOT;?>library/js/jquery-ui-1.10.2.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo WEB_ROOT;?>library/css/jquery-ui-1.10.2.custom.css" />
 <script type="text/javascript">  
						$(function() {
    $( "#promo_start" ).datepicker({
      dateFormat: 'yy-mm-dd',
      onClose: function( selectedDate ) {
        $( "#promo_end" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#promo_end" ).datepicker({
      dateFormat: 'yy-mm-dd',
      onClose: function( selectedDate ) {
        $( "#promo_start" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
      </script>

<div class="container">

<div class="col-sm-12">

<h4>เพิ่มโปรโมชั่น</h4>
<form method="post" name="promo" action="promo_process.php" >
<input type="hidden" name="add_pro" value="add" />
<table width="100%">
<tr height="50">
<td width="10%" align="right">ชื่อโปรโมชั่น : </td>
<td width="50%" colspan="3"><input type="text" name="promo_name" value="" class="form-control"></td>
<td width="20%"></td>
<td width="10%"></td>
<td width="10%"></td>
</tr>
<tr height="50">
<td align="right">วันเริ่ม : </td>
<td><input type="text" class="form-control"  name="promo_start" id="promo_start" /></td>
<td align="right">วันหมดเขต : </td>
<td><input type="text" class="form-control"  name="promo_end" id="promo_end"  /></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หรือ</td>
<td align="right">ระยะเวลา : </td>
<td><input type="text" name="promo_duration" value=""  class="form-control"></td>
</tr>
</table>
<table width="100%">
<tr height="50">
<td width="10%" align="right">พิเศษ : </td>
<td width="10%"><input type="text" class="form-control"  name="promo" value=""/></td>
<td width="15%" align="left">
<select name="unit" class="form-control" >
<option value="">เลือกหน่วย</option>
  <option value="1">บาท</option>
  <option value="2">ชิ้น</option>
  <option value="3">%</option>
</select></td>
<td width="10%" align="right">ราคา : </td>
<td width="20%"><input type="text" class="form-control"  name="promo_price"  /></td>
<td align="left" width="35%">บาท</td>
</tr>
<tr height="70">
<td colspan="6"><button type="submit" class="btn btn-primary">Save</button></td>
</tr>
</table>
</form>
<?
if(isset($_GET['credit_type_id'])){
?>

<?

}
?>   
 <table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="25%"><h4>โปรโมชั่น</h4></td><td width="10%"><h4>เริ่ม</h4></td><td width="10%"><h4>หมด</h4></td><td width="10%"><h4>ระยะเวลา</h4></td><td width="10%"><h4>จำนวน(ชิ้น)</h4></td><td width="5%"><h4>จำนวน(บาท)</h4></td><td width="5%"><h4>ส่วนลด</h4></td><td width="10%"><h4>ราคา</h4></td><td width="10%"></td></tr></thead>
    
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
		if($promo_pcs != "0"){
			$promo = $promo_pcs;
			$unit_status = "2";
			$unit = "ชิ้น";
		}else if($promo_money != "0"){
			$promo = $promo_money;
			$unit_status = "1";
			$unit = "บาท";
		}else if($promo_discount != "0"){
			$promo = $promo_discount;
			$unit_status = "3";
			$unit = "%";
		} 
				echo  "<tr><td>";
		?>
 <script type="text/javascript">  
						$(function() {
    $( "#promo_start<?=$no?>" ).datepicker({
      dateFormat: 'yy-mm-dd',
      onClose: function( selectedDate ) {
        $( "#promo_end<?=$no?>" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#promo_end<?=$no?>" ).datepicker({
      dateFormat: 'yy-mm-dd',
      onClose: function( selectedDate ) {
        $( "#promo_start<?=$no?>" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
      </script>
    <div class="modal fade bs-modal-lg" id="myModal<?=$no?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"  >
  <div class="modal-dialog modal-lg" style='width:1000px;'>
    <div class="modal-content" style='width:1000px;'>
      <div class="modal-header" style='width:1000px;'>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขโปรโมชั่น</h4>
      </div>
      <div class="modal-body" style='width:1000px;' >
<form method="post" name="promo_edit" action="promo_process.php" >
<input type="hidden" name="edit_pro" value="edit" />
<input type="hidden" name="promo_id" value="<?=$promo_id;?>" />
<table width="100%">
<tr height="50">
<td width="10%" align="right">ชื่อโปรโมชั่น : </td>
<td width="50%" colspan="3"><input type="text" name="promo_name" value="<?=$promo_name;?>" class="form-control"></td>

<td width="20%"></td>
<td width="10%"></td>
<td width="10%"></td>
</tr>
<tr height="50">
<td align="right">วันเริ่ม : </td>
<td><input type="text" class="form-control"  name="promo_start" id="promo_start<?=$no?>" value="<?=$promo_start;?>" /></td>
<td align="right">วันหมดเขต : </td>
<td><input type="text" class="form-control"  name="promo_end" id="promo_end<?=$no?>" value="<?=$promo_end;?>"  /></td>
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หรือ</td>
<td align="right">ระยะเวลา : </td>
<td><input type="text" name="promo_duration"  class="form-control" value="<?=$promo_duration;?>"></td>
</tr>
</table>
<table width="100%">
<tr height="50">
<td width="10%" align="right">พิเศษ : </td>
<td width="10%"><input type="text" class="form-control"  name="promo" value="<?=$promo;?>"/></td>
<td width="15%" align="left">
<select name="unit" class="form-control" >
<option value="<?=$unit_status;?>"><?=$unit;?></option>
  <option value="1">บาท</option>
  <option value="2">ชิ้น</option>
  <option value="3">%</option>
</select></td>
<td width="10%" align="right">ราคา : </td>
<td width="20%"><input type="text" class="form-control"  name="promo_price" value="<?=$promo_price;?>"  /></td>
<td align="left" width="35%">บาท</td>
</tr>
</table>

        	<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
   </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        
        
  
        <?
		echo "".$no."</td><td  align=left>".$promo_name."</td><td>".$promo_start."</td><td>".$promo_end."</td><td>".$promo_duration."</td><td>".$promo_pcs."</td><td>".$promo_money."</td><td>".$promo_discount."</td><td>".$promo_price."</td><td><a style='color:red;' href='' ><button type=\"button\" name=\"button\" id=\"button\"  class=\"btn btn-default btn-xs\" data-toggle=\"modal\" data-target=\"#myModal".$no."\" >EDIT</button></a> &nbsp;<a style='color:red;' href='promo_process.php?del=del&promo_id=$promo_id' ><button type=\"button\" name=\"button\" id=\"button\"  class=\"btn btn-default btn-xs\" onclick=\"return confirm('ต้องการลบ $promo_name หรือไม่');\" >DEL</button></a></td></tr>";
																											
	$i++;
	$no++;
}
}																								
		?>
        </table>
  </div>
  </div>