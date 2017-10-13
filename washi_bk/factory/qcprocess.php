<div class="container">
<? $shop_id = $_COOKIE['shop_id'];?>
<form method="post" name="qc" action="submit_qc.php?action=qc">
<table width="100%" border="0">
<tr>
<td width="10%">Code</td>
<td width="25%"><input type="text" name="product_code" class="form-control" required autofocus ></td>
<td width="3%"></td>
<td width="20%"><select name="id_problem" class="form-control" >
<?
$sql = dbQuery("SELECT * FROM tbl_problem ORDER BY id_problem ASC");
	$row = dbNumRows($sql);
	$i=0;
	while($i<$row){
		$list = dbFetchArray($sql);
		$id_problem = $list['id_problem'];
		$problem_name = $list['problem_name'];
		echo"<option value='$id_problem'>$problem_name </option>";
		$i++;
	}?></select></td>
<td width="3%"></td>
<td width="10%"><input type="submit" value="QC" class="form-control" /></td>
<td width="29%"><? @$not_order = $_GET['not_order'];if($not_order != "" ){echo "<div class='alert h4 alert-danger'><center>$not_order</center></div>";}?></td>
</tr>
</table>
</form>
 <hr style="margin-top:5px; margin-bottom:5px;" />
 <div class="row">
<div class="col-sm-6">

<table width="100%" border="0">
<tr>
<td><h4>ORDER</h4></td>
</tr>
</table>
 <hr style="margin-top:5px; margin-bottom:5px;" />
 <? 
if(isset($_GET['order_id'])!='')
	{	
		$order_id = $_GET['order_id'];
		$sql="SELECT * FROM tbl_order WHERE order_id = '$order_id'";
		$Qtotal = dbQuery($sql);
		$rs=dbFetchArray($Qtotal);
		$order_no = $rs['order_no'];
		$order_qty = $rs['order_qty'];
		$shop_id =$rs['shop_id'];
		$qr =dbQuery("SELECT * FROM tbl_order_detail LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id where order_id = '$order_id' and status = '9' ORDER BY product_code ASC");	
		$row =@mysql_num_rows($qr);
		?>

<table width="100%" border="0">
<tr>
<td width="15%" align="right">Order No : </td> 
<td width="30%" align="left"><h4><?=$order_no;?></h4></td>
<td width="10%" align="right">QTY : </td>
<td width="10%" align="left"><h4><?=$order_qty;?></h4></td>
<td width="15%" align="right">เสร็จแล้ว : </td>
<td width="20%" align="left"><h4><?=$row;?></h4></td>
<td width="20%" align="left"><? if($order_qty == "$row"){echo "<img src='../images/Approve_icon.jpg' width='30' height='30'>";}?></td>
</tr>
</table>
<hr style="margin-top:5px; margin-bottom:5px;" />	
 <div style="width: 100%; height: 270px; overflow-y: scroll;background: #EBEBEB "> 
 <table width="100%" border="0">
<tr>
<td width="5%">#</td>
<td width="20%" align="left">Code</td>
<td width="30%" align="left">Name</td>
<td width="5%"></td>
<td width="5%"></td>
</tr>
<?
				
				 $i=0;
				while ($i<$row){
				$rs=mysql_fetch_array($qr);
?>
  <tr>
<td ><?=$i+1;?></td>
<td align="left"><?=$rs['product_code'];?></td>
<td align="left"><?=$rs['product_name'];?></td>
<td></td>
<td></td>
</tr>
<? $i++;
				}
				?>
</table>
 </div>
 <hr style="margin-top:5px; margin-bottom:5px;" />
 <?
}
?>
</div>
<div class="col-sm-6">

<table width="100%" border="0">
<tr>
<td><h4>LIST ORDER</h4></td>
</tr>
</table>
 <hr style="margin-top:5px; margin-bottom:5px;" />
 <div style="width: 100%; height: 320px; overflow-y: scroll;background: #EBEBEB ">  
<table width="100%" border="0">
<tr>
<td width="5%">#</td>
<td width="20%">Order No</td>
<td width="10%">QTY</td>
<td width="10%">ตรวจแล้ว</td>
<td width="10%"></td>
</tr>
<?
				$qr =dbQuery("SELECT * FROM tbl_order where status = '8' ORDER BY order_no ASC");	
				$row =@mysql_num_rows($qr);
				 $i=0;
				while ($i<$row){
				$rs=mysql_fetch_array($qr);
				$order_id1 = $rs['order_id'];
				$order_qty1 = $rs['order_qty'];
				$complete = $rs['complete'];
				$qrd =dbQuery("SELECT * FROM tbl_order_detail where order_id = '$order_id1' and (status = '9' or status = '18')");	
				$rowd =@mysql_num_rows($qrd);
				
?>
<tr>
<td><?=$i+1;?></td>
<td ><?=$rs['order_no'];?></td>
<td><?=$rs['order_qty'];?></td>
<td><?=$rowd;?></td>
<td><? if($order_qty1 == "$rowd"){if($complete == "0"){echo "<a href='submit_qc.php?action=confirm&order_id1=$order_id1'><button type='button' class='btn btn-default btn-xs'>confirm</button></a>";}else if($complete == "2"){echo "<a href='submit_qc.php?action=confirm&order_id1=$order_id1'><button type='button' class='btn btn-default btn-xs'>confirm</button></a>";}else{echo "<a href='submit_qc.php?action=end_forced&order_id1=$order_id1'><button type='button' class='btn btn-default btn-xs'>บังคับจบ</button></a>";}}else{}?></td>
</tr>
<? $i++;
	}
?>
</table>

</div>
 <hr style="margin-top:5px; margin-bottom:5px;" />
</div>
</div>
<hr style="margin-top:5px; margin-bottom:5px;" />
 <div class="row">
 <div class="col-sm-6">
 <table width="100%" border="0">
 <thead>
 <td colspan="4">รอQC</td>
 </thead> <tr>
 <td width="10%">#</td>
 <td width="30%" align="left">Code</td>
 <td width="60%" align="left">Name</td>
 </tr>
 </table>
  <hr style="margin-top:5px; margin-bottom:5px;" />
   <div style="width: 100%; height: 300px; overflow-y: scroll; background: #EBEBEB  ">  
   <table width="100%" border="0">
   <?
				$qr =dbQuery("SELECT * FROM tbl_order_detail LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id where  status = '8' ORDER BY product_code ASC");	
				$row =@mysql_num_rows($qr);
				 $i=0;
				while ($i<$row){
				$rs1=mysql_fetch_array($qr);
?>
 <tr>
 <td width="10%"><?=$i+1;?></td>
 <td width="30%" align="left"><?=$rs1['product_code'];?></td>
 <td width="60%" align="left"><?=$rs1['product_name'];?></td>
 </tr>
 
 <?
 $i++;
				}
				?>
 </table>
 </div>
 </div>
 <div class="col-sm-6">
  <table width="100%" border="0">
  <thead>
 <td colspan="4">QC ไม่ผ่าน</td>
 </thead>
 <tr>
 <td width="10%">#</td>
 <td width="30%" align="left">Code</td>
 <td width="60%" align="left">Name</td>
 </tr>
 </table>
  <hr style="margin-top:5px; margin-bottom:5px;" />
   <div style="width: 100%; height: 300px; overflow-y: scroll; background: #EBEBEB  ">  
   <table width="100%" border="0">
   <?
				$qr =dbQuery("SELECT * FROM tbl_order_detail LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN  tbl_issue ON tbl_order_detail.detail_id =  tbl_issue.id_order_detail LEFT JOIN tbl_problem ON tbl_issue.id_problem = tbl_problem.id_problem where  status = '18' ORDER BY product_code ASC");	
				$row =@mysql_num_rows($qr);
				 $i=0;
				while ($i<$row){
				$rs1=mysql_fetch_array($qr);
?>
 <tr>
 <td width="10%"><?=$i+1;?></td>
 <td width="30%" align="left"><?=$rs1['product_code'];?></td>
 <td width="40%" align="left"><?=$rs1['product_name'];?></td>
  <td width="20%" align="left"><?=$rs1['problem_name'];?></td>

 </tr>
 
 <?
 $i++;
				}
				?>
 </table>
 </div>
 </div>
 </div>



</div>