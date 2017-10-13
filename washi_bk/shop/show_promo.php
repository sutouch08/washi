    <div class="container">
    	<div class="col-md-12">
<? 
$mem_detail_id = $_GET['mem_detail_id'];
$customer_id = $_GET['customer_id'];
$qr =dbQuery("SELECT * FROM tbl_member_detail LEFT JOIN tbl_promo ON tbl_member_detail.promo_id = tbl_promo.promo_id LEFT JOIN tbl_credit_type ON tbl_member_detail.credit_type = tbl_credit_type.credit_type where mem_detail_id = '$mem_detail_id'");
$rs=dbFetchArray($qr);
$promo_name = $rs['promo_name'];
$detail_credit = $rs['detail_credit'];
$detail_start = $rs['detail_start'];
$detail_end = $rs['detail_end'];
$credit_unit = $rs['credit_unit'];
$qrc =dbQuery("SELECT * FROM tbl_customer where customer_id = '$customer_id'");
$rsc=dbFetchArray($qrc);
$customer_name = $rsc['customer_name'];
?>
<table border="0" width="600" align="center"><tr><td><table width="100%">
<tr>
<td width="100%" colspan="4"><h4><?=$customer_name;?></h4></td>
</tr>
<tr>
<td width="20%" align="right"><h4>โปรโมชั่น : </h4></td>
<td width="30%" align="left"><h4><?=$promo_name;?></h4></td>
<td width="20%" align="right"><h4>จำนวน :</h4></td>
<td width="30%" align="left"><h4><?=$detail_credit;?> <?=$credit_unit;?></h4></td>
</tr>
<tr>
<td align="right"><h4>วันเริ่ม : </h4></td>
<td align="left"><h4><?=$detail_start;?></h4></td>
<td align="right"><h4>วันหมดอายุ : </h4></td>
<td align="left"><h4><?=$detail_end;?></h4></td>
</tr>
</table>
</td>
</tr>
</table>
<br />
<button type='button' class='btn btn-default' onclick='backHome()' value='Go Back' />Go back</button>
</div>
</div>