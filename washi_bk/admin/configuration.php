<?
	checkPermission();
	
		//ดึงค่าระยะเวลาการทำงาน
		$result = dbQuery("SELECT * FROM  tbl_urgent ");
		$row = dbNumRows($result);
		$i=0;
		while($row>$i){
			$data = dbFetchArray($result);
			$day[$i] = $data['urgent_date'];
			$chargup[$i] = $data['charge_up'];
			$i++;
		}
		//ดึงรายการหมายเหตุมาแสดง
		$res1 = dbFetchAssoc(dbQuery("SELECT * FROM tbl_config WHERE config_name ='remark1' "));
		$res2 = dbFetchAssoc(dbQuery("SELECT * FROM tbl_config WHERE config_name ='remark2' "));
		$remark1 = $res1['config_value'];
		$remark2 = $res2['config_value'];	
		$result1 = dbQuery("SELECT * FROM  tbl_promo WHERE promo_id = '1' ");
		$data1 = dbFetchArray($result1);
	
?>
<div class="container">
<? if(isset($_GET['update'])){
		$status = $_GET['update'];
		if($status == "success"){
			echo " <div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden=\"true\">&times;</button>อัพเดตการตั้งค่าเรียบร้อยแล้ว</div>";
		}else if($status =="fail"){
			echo "<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden=\"true\">&times;</button>เกิดข้อผิดพลาด</div>";
		}
}?>
<form action="config_process.php?update_config=y" method="post">
<table width="100%" border="0">
	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
	<tr>
		<td width="20%"><hr /></td><td><h4>ระยะเวลา</h4></td><td colspan="5"><hr /></td>
	</tr>
	<tr>
		<td width="20%" align="right">ปกติ : &nbsp;</td>
		<td width="10%"><input  name="urgent1" class="form-control" value="<?=$day[0]; ?>" required="required" /></td>
		<td width="5%">วัน</td>
		<td width="10%" align="right">ชาร์จเพิ่ม :</td>
		<td width="10%" align="left"><input name="charge_up1" class="form-control" value="<?=$chargup[0];?>"  required="required"/></td>
		<td width="5%" align="left">%</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td align="right">ด่วน : &nbsp;</td>
		<td><input  name="urgent2" class="form-control" value="<?=$day[1];?>" required="required" /></td>
		<td>วัน</td>
		<td align="right">ชาร์จเพิ่ม :</td>
		<td><input name="charge_up2" class="form-control" value="<?=$chargup[1];?>"  required="required"/></td>
		<td align="left">%</td>
		<td></td>
	</tr>
	<tr>
		<td align="right">ด่วนมาก : &nbsp;</td><td width="10%"><input  name="urgent3" class="form-control" value="<?=$day[2];?>" required="required"/></td>
		<td>วัน</td>
		<td align="right">ชาร์จเพิ่ม :</td>
		<td><input name="charge_up3" class="form-control" value="<?=$chargup[2];?>" required="required" /></td>
		<td align="left">%</td>
		<td></td>
	</tr>
</table>
<table width="100%" border="0">
<tr>
	<td width="20%"><hr /></td><td width="10%"><h4>หมายเหตุ</h4></td><td colspan="2"><hr /></td>
</tr>
<tr>
	<td width="20%" align="right">หมายเหตุ 1 :&nbsp;</td><td colspan="2"><input name="remark1" class="form-control" value="<?=$remark1;?>" /></td><td width="25%"></td>
</tr>
<tr>
	<td width="20%" align="right">หมายเหตุ 2 :&nbsp;</td><td colspan="2"><input name="remark2" class="form-control" value="<?=$remark2;?>" /></td><td width="25%"></td>
</tr>
</table>
<table width="40%">
<tr>
<td width="100%" colspan="3"  align="center"><h4>Credit</h4></td>
</tr>
<tr><td width="50%" align="right">ส่วนลด : </td>
<td width="40%"><input type="text" name="promo_discount" class="form-control" value="<?=$data1['promo_discount'];?>"  /></td>
<td width="10%" align="right">%</td>
</tr>
</table>
<hr />
<div class="col-sm-12"><button type="submit" class="btn btn-default">Update</button></div>
<hr />
</form>
</div>