
<div class="container">

<?
if(isset($_GET['process_id'])!='')
	{	
		$process_id = $_GET['process_id'];
		$sql="SELECT * FROM fac_process WHERE process_id = '$process_id'";
		$Qtotal = dbQuery($sql);
		$rs=dbFetchArray($Qtotal);
		$em_id = $rs['em_id'];
		$process_no = $rs['process_no'];
		$qty = $rs['qty'];
		$Qtotale = dbQuery("SELECT * FROM tbl_employee WHERE em_id = '$em_id'");
		$rse=dbFetchArray($Qtotale);
		$em_name = $rse['em_name'];
		
		
?>
<table width="100%" border="0" />
<tr>
<td width="10%" align="right"></td>
<td width="20%" align="left" ><h4><div class="alert alert-success" >No : <?=$process_no;?></div></h4></td>
<td width="5%" align="right"></td>
<td width="20%" align="left"><h4><div class="alert alert-success" >ชื่อ : <?=$em_name;?></div></h4></td>
<td width="5%"></td>
<td width="10%" align="left"><h4><div class="alert alert-success" >จำนวน : <?=$qty;?></div></h4></td>
<td width="20%"></td>
</tr>
</table>
 <hr style="margin-top:5px; margin-bottom:5px;" />

 <form method="post" name="addproduct" action="submit_process.php?action=addproduct" >
 <input type="hidden" name="process_id" value="<?=$process_id;?>"  />
 <table width="100%" border="0" />
 <tr>
 <td width="10%" align="right">บาร์โค้ดสินค้า : </td>
 <td width="20%" align="left"><input type="text" name="product_code" class="form-control" required autofocus /></td>
 <td width="3%"></td>
 <td width="10%" ><input type="submit" value="ADD" class="form-control" /></td>
 <td width="57%"><? @$not_order = $_GET['not_order'];if($not_order != "" ){echo "<div class='alert h4 alert-danger'><center>$not_order</center></div>";}?></td>
 </tr>
 </table>
 </form>     
  <hr style="margin-top:5px; margin-bottom:5px;" />
<div class="row">
<div class="col-sm-6">
<table width="100%"  border="0" >
<tr>
<td width="100"><h4>รอซัก</h4></td>
</tr>
</table>
<hr style="margin-top:5px; margin-bottom:5px;" />
<table width="100%" border="0" >
<tr>
<td width="10%">#</td>
<td width="30%" align="left">รหัสสินค้า</td>
<td width="30%" align="left">ชื่อสินค้า</td>
</tr>
</table>
<hr style="margin-top:5px; margin-bottom:5px;" />
<table width="100%" border="0" >
<?php  
				$qr =dbQuery("SELECT * FROM tbl_order_detail LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id where status = '6' ORDER BY product_name ASC");	
				$row =@mysql_num_rows($qr);
				 $i=0;
				while ($i<$row){
				$rs=mysql_fetch_array($qr);
				$detail_id = $rs['detail_id'];
				$product_name = $rs['product_name'];
				$product_code = $rs['product_code'];	
				
?> 
<tr>
<td width="10%"><?=$i+1;?></td>
<td width="30%" align="left"><?=$product_code;?></td>
<td width="30%" align="left"><?=$product_name;?></td>
</tr>
<? 	$i++;
	}
?>
</table>
</div>
<div class="col-sm-6">
<table width="100%"  border="0" >
<tr>
<td width="100"><h4>เครื่อง</h4></td>
</tr>
</table>
<hr style="margin-top:5px; margin-bottom:5px;" />
<table width="100%" border="0" >
<tr>
<td width="10%">#</td>
<td width="20%" align="left">รหัสสินค้า</td>
<td width="30%" align="left">ชื่อสินค้า</td>
<td width="10%"></td>
</tr>
</table><hr style="margin-top:5px; margin-bottom:5px;" />
<table width="100%" border="0" >
<?php  
				$qr =dbQuery("SELECT * FROM tbl_order_detail LEFT JOIN fac_process_detail ON tbl_order_detail.detail_id = fac_process_detail.detail_id LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id where tbl_order_detail.status = '7' and process_id = '$process_id' ORDER BY product_name ASC");	
				$row =@mysql_num_rows($qr);
				 $i=0;
				while ($i<$row){
				$rs=mysql_fetch_array($qr);
				$detail_id = $rs['detail_id'];
				$process_detail_id = $rs['process_detail_id'];
				$product_name = $rs['product_name'];
				$product_code = $rs['product_code'];	
			
?> 
<tr>
<td width="10%"><?=$i+1;?></td>
<td width="20%" align="left"><?=$product_code;?></td>
<td width="30%" align="left"><?=$product_name;?></td>
<td width="10%"><a href="submit_process.php?action=delproduct&process_id=<?=$process_id;?>&detail_id=<?=$detail_id;?>&process_detail_id=<?=$process_detail_id;?>"><button type='button' class='btn btn-default btn-xs'>ลบ</button></a></td>
</tr>
<? 	$i++;
	}
?>
</table>
</div>
</div>
  <hr style="margin-top:5px; margin-bottom:5px;" />
<? }else{?>
<form method="post" name="addprocess" action="submit_process.php?action=add_process" />
<table width="100%" border="0" >
<tr>
<td width="10%" align="right">บาร์โค้ดพนักงาน : </td>
<td width="30%"><input name="em_code" type="text"  class="form-control" required autofocus /></td>
<td width="3%"></td>
<td width="10%"><input type="submit" value="OK"  class="form-control" /></td>
<td width="42%"></td>
</tr>
</table>
</form>
<? }?>
</div>