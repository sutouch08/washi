  <?  if(isset($_POST['customer_code'])){
	$customer_code = $_POST['customer_code'];
}else if(isset($_GET['customer_code'])){
	$customer_code = $_GET['customer_code'];
}else{
	$customer_code = "";
}
?>
<div class="container">
<?
if(isset($_GET['customer_code'])){
	echo "<div class='alert alert-success'>เติมเงินเรียบร้อยเเล้ว</div>";
}
?>
    	<div class="col-md-6" style="background-color: #E2E2E2">
        <br>
        <table width="100%" >
        <tr>
        <td>
        <?

if($customer_code != ""){
$qr =dbQuery("SELECT * FROM tbl_member LEFT JOIN tbl_customer ON tbl_member.mem_code = tbl_customer.customer_code LEFT JOIN tbl_member_detail ON tbl_member.mem_id = tbl_member_detail.mem_id where customer_code = '$customer_code' and promo_id = '1' and mem_active = '1' and detail_active = '1'");
$rs=dbFetchArray($qr);
$customer_id = $rs['customer_id'];	
$customer_name = $rs['customer_name'];	
$customer_address = $rs['customer_address'];
$customer_phone = $rs['customer_phone'];
$customer_email = $rs['customer_email'];
$promo_id = $rs['promo_id'];
$detail_credit = $rs['detail_credit'];
$mem_detail_id = $rs['mem_detail_id'];

if($customer_id != ""){
?>

<table width="100%">
<tr>
<td width="15%" align="right">ชื่อ : </td>
<td width="35%" align="left"><?=$customer_name;?></td>
<td width="50%"  colspan="2"></td>
</tr>
<tr>
<td align="right">Email : </td>
<td align="left"><?=$customer_email;?></td>
<td align="right">Phone</td>
<td align="left"><?=$customer_phone;?></td>
</tr>
<tr>
<td align="right" valign="top">Address : </td>
<td align="left" colspan="3" valign="top"><?=$customer_address;?></td>
</tr>
</table>
<?
}else{?>
<form method="post" name="cus" action="">
<table width="100%">
<tr>
<td width="20%" align="right">CODE : </td>
<td width="50%"><input type="text" name="customer_code" class="form-control" autocomplete="off"  required autofocus ></td>
<td width="30%"><input type="submit" class="form-control" value="ตกลง" /></td>
</tr>
</table>
</form>
<?
}}else{?>
<form method="post" name="cus" action="">
<table width="100%">
<tr>
<td width="20%" align="right">CODE : </td>
<td width="50%"><input type="text" name="customer_code" class="form-control" autocomplete="off"  required autofocus ></td>
<td width="30%"><input type="submit" class="form-control" value="ตกลง" /></td>
</tr>
</table>
</form>
<? }
?>
</td>
</tr>
</table>
<br>
        </div>
        <div class="col-md-6">
        <?
		if($customer_code != ""){
			if($customer_id != ""){
		?>
        <SCRIPT Language="JavaScript">
function startCalc(){ 
interval = setInterval("calc()",1); 
} 
function calc(){ 
var amount = document.credit_buy.amount.value; 
var paymet_received = document.credit_buy.paymet_received.value;
document.credit_buy.payment_change.value = (paymet_received) - (amount);

} 
function stopCalc(){ 
clearInterval(interval); 
} 
</SCRIPT>
<script>
function check(){
var amount = document.credit_buy.amount.value; 
var paymet_received = document.credit_buy.paymet_received.value;
	//alert('Y' + money);
	if(parseInt(amount)>parseInt(paymet_received)){
	alert('คุณรับเงินไม่ครบ');
	return false;
	}
}
</script>

        <form method="post" name="credit_buy" action="submit_credit_buy"  onSubmit="return check()"  >
        <input type="hidden" name="mem_detail_id" value="<?=$mem_detail_id;?>" >
        <input type="hidden" name="cus_id" value="<?=$customer_id;?>" >
        <input type="hidden" name="promo_id" value="<?=$promo_id;?>">
        <input type="hidden" name="customer_code" value="<?=$customer_code;?>">
        <table width="100%">
        <tr height="50">
        <td width="20%" align="right">ยอดเงิน : </td>
        <td width="50%" ><input type="text" name="amount" id="amount" class="form-control" onfocus="startCalc()" onblur="stopCalc()" required autofocus autocomplete="off" ></td>
        <td width="30%"><div class="col-md-6">คงเหลือ : </div><div class="col-md-3"><input type="text" name="detail_credit" id="detail_credit" class="input-label"  value="<?=$detail_credit;?>" readonly="true" ></div> <div class="col-md-1">บาท</div></td>
        </tr>
        <tr height="50">
        <td align="right">รับเงิน : </td>
        <td><input type="text" name="paymet_received" id="paymet_received" class="form-control" onfocus="startCalc()" onblur="stopCalc()" required autocomplete="off" ></td>
        <td></td>
        </tr>
        <tr height="50">
        <td align="right">เงินทอน : </td>
        <td><h4><input type="text" name="payment_change" id="payment_change" class="input-label" onfocus="startCalc()" onblur="stopCalc()" readonly="true" ></h4></td>
        <td><button type="submit" class="btn btn-primary">ตกลง</button></td>
        </tr>
        </table>
        </form>
        <?
		}}?>
        </div>
      </div><hr>
        <?
if(isset($_GET['customer_code'])){
	echo "<button type='button' class='btn btn-primary' onclick='backHome()' value='Go Back' />Go Back";
}
?>
  