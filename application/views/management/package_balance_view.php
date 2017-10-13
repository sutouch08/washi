<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-credit-card'></i>&nbsp; แพ็คเกจคงเหลือ</h3>
    </div>
     <div class='col-lg-6'>
    	<p class="pull-right" style="margin-bottom:0px; margin-top:0px;"><button type="button" class="btn btn-success" onclick="print_report();"><i class="fa fa-print"></i>&nbsp; พิมพ์</button></p>
    </div>
    
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-3"><div class="input-group"><span class="input-group-addon">สาขา</span><select name="id_shop" id="id_shop" class="form-control"><?php echo selectShop($id_shop); ?></select></div></div>
<div class="col-lg-2"><button type="button" class="btn btn-success btn-block" onclick="get_report()"><i class="fa fa-tasks"></i>&nbsp; รายงาน</button></div>
</div>

<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row"><div class="col-lg-12"><h4 style="text-align:center" id="title">รายงานแพ็คเกจคงเหลือ สาขา <?php echo getShopName($id_shop); ?>  วันที่ &nbsp; <?php echo date("d-m-Y"); ?></h4></div></div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
<div class="col-lg-12" id="report">
<table class="table table-striped">
<thead style="font-size:12px;">
<th style="width:5%; text-align:center">ลำดับ</th>
<th style="width:15%;">ลูกค้า</th>
<th style="width:10%;">สาขา</th>
<th style="width:20%;">แพ็คเกจ</th>
<th style="width:10%; text-align:center">เริ่มต้น</th>
<th style="width:10%; text-align:center">สิ้นสุด</th>
<th style="width:5%; text-align:center">เวลา</th>
<th style="width:10%; text-align:right">คงเหลือ</th>
<th style="width:5%; text-align:center">หน่วย</th>
<th style="width:10%; text-align:center">วันที่ซื้อ</th>
</thead>
<?php if($data != false) : ?>
<?php $n = 1; ?>
<?php foreach($data as $rs) :?>
<tr>
<td align="center"><?php echo $n; ?></td>
<td><?php echo getCustomerName($rs->id_customer); ?></td>
<td><?php echo getShopName(getIdShopByCustomer($rs->id_customer)); ?></td>
<td><?php echo getPromotionName($rs->id_promotion);  ?></td>
<td align="center"><?php if($rs->start == "0000-00-00"){ echo "-"; }else{ echo thaiShortDate($rs->start); }  ?></td>
<td align="center"><?php if($rs->end == "0000-00-00"){ echo "-"; }else{ echo thaiShortDate($rs->end); } ?></td>
<td align="center"><?php if($rs->duration == 0){ echo "-"; }else{ echo $rs->duration; } ?></td>
<td align="right"><?php echo number($rs->credit,2); ?></td>
<td align="center"><?php echo getUnit($rs->id_credit_type); ?></td>
<td align="center"><?php echo thaiShortDate($rs->date_add); ?></td>
</tr>
<?php $n++; ?>
<?php endforeach; ?>
<?php else: ?>
<tr><td colspan="9" align="center"><h4>------------- ไม่มีรายการ --------------</h4></td></tr>
<?php endif; ?>
</table>
</div>
<form id="payment_form" action="<?php echo base_url()."management/payment/print_report/"; ?>" method="post">
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
	var shop = $("#id_shop").val();
	window.location.href="<?php echo $this->home."/package_balance/"; ?>"+shop;
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