<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-credit-card'></i>&nbsp; รายงานการรับเงิน (เฉพาะแพ็คเกจ)</h3>
    </div>
     <div class='col-lg-6'>
    	<p class="pull-right" style="margin-bottom:0px; margin-top:0px;"><button type="button" class="btn btn-success" onclick="print_report();"><i class="fa fa-print"></i>&nbsp; พิมพ์</button></p>
    </div>
    
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-3"><div class="input-group"><span class="input-group-addon">สาขา</span><select name="id_shop" id="id_shop" class="form-control"><?php echo selectShop($id_shop); ?></select></div></div>
<div class="col-lg-2">&nbsp;</div>
<div class="col-lg-3"><div class="input-group"><span class="input-group-addon">จากวันที่</span><input type="text" id="from" name="from" class="form-control" value="<?php echo thaiShortDate($from); ?>" /></div></div>
<div class="col-lg-3"><div class="input-group"><span class="input-group-addon">ถึงวันที่</span><input type="text" id="to" name="to" class="form-control" value="<?php echo thaiShortDate($to); ?>" /></div></div>
<div class="col-lg-1"><button class="btn btn-default" onclick="get_report()">ตกลง</button></div>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-2"><button class="btn btn-info btn-block" onclick="payment_report(0);">วันนี้</button></div>
<div class="col-lg-2"><button class="btn btn-primary btn-block" onclick="payment_report(7);">7 วันล่าสุด</button></div>
<div class="col-lg-2"><button class="btn btn-success btn-block" onclick="payment_report(15);" >15 วันล่าสุด</button></div>
<div class="col-lg-2"><button class="btn btn-warning btn-block" onclick="payment_report(30);" >30 วันล่าสุด</button></div>
<div class="col-lg-2"><button class="btn btn-danger btn-block" onclick="payment_report('x');" >เดือนนี้</button></div>

</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row"><div class="col-lg-12"><h4 style="text-align:center" id="title">รายงานการรับเงิน วันที่ &nbsp; <?php echo thaiShortDate($from); ?>&nbsp; ถึงวันที่ &nbsp;<?php echo thaiShortDate($to); ?> สาขา <?php echo getShopName($id_shop); ?></h4></div></div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
<div class="col-lg-12" id="report">
<table class="table table-striped">
<thead>
<th style="width:10%; text-align:center">วันที่</th>
<th style="width:10%">สาขา</th>
<th style="width:20%;">ออเดอร์</th>
<th style="width:10%; text-align:right">ยอดเงิน</th>
<th style="width:10%; text-align:right">มัดจำ</th>
<th style="width:10%; text-align:right">รับเงิน</th>
<th style="width:10%; text-align:right">ทอน</th>
<th style="width:10%; text-align:right">ค้างรับ</th>
<th style="width:10%; text-align:right">พนักงาน</th>
</thead>
<?php if($data != false) : ?>
<?php foreach($data as $rs) :?>
<tr>
<td align="center"><?php echo thaiShortDate($rs->date_upd); ?></td>
<td><?php echo getShopName($rs->id_shop); ?></td>
<td><?php echo getPromotionName($rs->id_promotion);  ?></td>
<td align="right"><?php if($rs->repay ==1) { echo number(getPaymentBalance($rs->id_order),2); }else{ echo number($rs->final_amount,2);} ?></td>
<td align="right"><?php echo number($rs->deposit,2); ?></td>
<td align="right"><?php echo number($rs->received,2); ?></td>
<td align="right"><?php echo number($rs->change,2); ?></td>
<td align="right"><?php echo number($rs->balance,2); ?></td>
<td align="right"><?php echo getEmployeeFirstName($rs->id_employee); ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="9" align="center"><h4>------------- ไม่มีรายการ --------------</h4></td></tr>
<?php endif; ?>
</table>
</div>
<form id="payment_form" action="<?php echo $this->home."/print_report/"; ?>" method="post">
 <input type="hidden" name="data" id="data" value="" />
  <input type="hidden" name="heading" id="heading" value="" />
 </form>
</div><!-- End Row -->
<script>
$("#from").datepicker({
	'dateFormat' : 'dd-mm-yy', onClose: function(selectedDate){
		$("#to").datepicker("option", 'minDate', selectedDate)
	}
});

$("#to").datepicker({
	"dateFormat" : "dd-mm-yy", onClose: function(selectedDate){
		$("#from").datepicker("option", "maxDate", selectedDate)
	}
});

function get_report(){
	var from = $("#from").val();
	var to = $("#to").val()
	var shop = $("#id_shop").val();
	if(shop == 0){
		alert("คุณยังไม่ได้เลือกสาขา");
	}else if(from ==""){
		alert("คุณยังไม่ได้เลือวัน");
	}else if(to == ""){
		alert("คุณยังไม่ได้เลือกวัน");
	}else{
		window.location.href="<?php echo $this->home."/payment_package/rank/"; ?>"+shop+"/"+from+"/"+to;
	}
}

function payment_report(i){
	var shop = $("#id_shop").val();
	if(shop == 0){
		alert("คุณยังไม่ได้เลือกสาขา");
	}else{
		if(i =="x"){
			window.location.href="<?php echo $this->home."/payment_package/this_month/"; ?>"+shop;
		}else{
			window.location.href="<?php echo $this->home."/payment_package/day/"; ?>"+shop+"/"+i;
		}
	}
}
function print_report(){
	var data = $("#report").html();
	var title = $("#title").html();
	$("#data").val(data);
	$("#heading").val(title);
	if(data ==""){
		alert("no data");
	}else{
	$("#payment_form").submit();
	}
}
</script>
<?php endif; ?>
</div>