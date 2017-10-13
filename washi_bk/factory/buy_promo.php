
<form method="post" name="add_pro" >
<table width="100%">
<tr>
<td width="10%">รหัส</td>
<td width="50%"><input name="customer_code" type="text" id="customer_code" class="form-control"  required></td>
<td width="40%"><?=$promo_name;?></td>
</tr>
<tr>
<td>จำนวน</td>
<td><input name="number" type="text" id="number" class="form-control"  required></td>
<td></td>
</tr>
<tr>
<td>จำนวนเงิน</td>
<td><input name="money" type="text" id="money" class="form-control"  required></td>
<td></td>
</tr>
<tr>
<td>รับ</td>
<td><input name="received" type="text" id="received" class="form-control"  ></td>
<td></td>
</tr>
<tr>
<td>ทอน</td>
<td><input name="change" type="text" id="change" class="form-control" ></td>
<td></td>
</tr>
</table>
  	<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>