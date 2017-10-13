<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h4 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-tasks'></i>&nbsp; ปริมาณชิ้นงาน แยกตามสาขา(ส่วนของสาขา)</h4>
    </div>
   <div class='col-lg-6'>
    	<p class="pull-right" style="margin-bottom:0px; margin-top:0px;"><button type="button" class="btn btn-success" onclick="print_report();"><i class="fa fa-print"></i>&nbsp; พิมพ์</button></p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-3 col-lg-offset-5"><div class="input-group"><span class="input-group-addon">จากวันที่</span><input type="text" id="from" name="from" class="form-control" value="<?php echo thaiShortDate($from); ?>" /></div></div>
<div class="col-lg-3"><div class="input-group"><span class="input-group-addon">ถึงวันที่</span><input type="text" id="to" name="to" class="form-control" value="<?php echo thaiShortDate($to); ?>" /></div></div>
<div class="col-lg-1"><button class="btn btn-default" onclick="get_report()">ตกลง</button></div>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-2"><button class="btn btn-info btn-block" onclick="report(0);">วันนี้</button></div>
<div class="col-lg-2"><button class="btn btn-primary btn-block" onclick="report(7);">7 วันล่าสุด</button></div>
<div class="col-lg-2"><button class="btn btn-success btn-block" onclick="report(15);" >15 วันล่าสุด</button></div>
<div class="col-lg-2"><button class="btn btn-warning btn-block" onclick="report(30);" >30 วันล่าสุด</button></div>
<div class="col-lg-2"><button class="btn btn-danger btn-block" onclick="report('x');" >เดือนนี้</button></div>

</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row"><div class="col-lg-12"><h4 style="text-align:center" id="title">รายงานปริมาณชิ้นงาน วันที่ &nbsp; <?php echo thaiShortDate($from); ?>&nbsp; ถึงวันที่ &nbsp;<?php echo thaiShortDate($to); ?> </h4></div></div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
<div class="col-lg-12" id="report">
<table class="table table-striped">
<thead>
<th style="width:20%">สาขา</th>
<th style="width:12%; text-align:right">รับมา</th>
<th style="width:12%; text-align:right">รอส่งโรงงาน</th>
<th style="width:12%; text-align:right">อยู่ที่โรงงาน</th>
<th style="width:12%; text-align:right">ระหว่างทาง</th>
<th style="width:12%; text-align:right">รอส่งคืน</th>
<th style="width:12%; text-align:right">ส่งคืนแล้ว</th>
</thead>
<?php if($shop_list != false) : ?>
<?php
	$total_order = 0;
	$total_prepare = 0;
	$total_process = 0;
	$total_on_the_way = 0;
	$total_ready = 0;
	$total_sent = 0;
?>
<?php foreach($shop_list as $rs) : ?>
<tr>
<td><?php echo getShopName($rs->id_shop); ?></td>
<?php 
	$order_qty = $this->report_model->get_total_qty_by_shop($rs->id_shop, $from, $to);  // ยอดรับออเดอร์
	$prepare_qty = $this->report_model->get_qty_in_state($rs->id_shop, $from, $to, array(1,2)); // รอส่งโรงงาน
	$on_process_qty = $this->report_model->get_qty_in_state($rs->id_shop, $from, $to, array(4,5));  // อยู่ที่โรงงาน
	$on_the_way_qty = $this->report_model->get_qty_in_state($rs->id_shop, $from, $to, array(3,6)); //ระหว่างทาง
	$ready_qty = $this->report_model->get_qty_in_state($rs->id_shop, $from, $to, array(7)); // รอลูกค้ามารับ
	$sent_qty = $this->report_model->get_qty_in_state($rs->id_shop, $from, $to, array(8)); // ลูกค้ามารับแล้ว
	$total_order += $order_qty;
	$total_prepare += $prepare_qty;
	$total_process += $on_process_qty;
	$total_on_the_way += $on_the_way_qty;
	$total_ready += $ready_qty;
	$total_sent += $sent_qty;
	?>
<td align="right"><?php if($order_qty == 0){ echo "-"; }else{ echo number($order_qty); } ?></td>
<td align="right"><?php if($prepare_qty == 0){ echo "-"; }else{ echo number($prepare_qty); } ?></td>
<td align="right"><?php if($on_process_qty == 0){ echo "-"; }else{ echo number($on_process_qty); } ?></td>
<td align="right"><?php if($on_the_way_qty == 0){ echo "-"; }else{ echo number($on_the_way_qty); } ?></td>
<td align="right"><?php if($ready_qty == 0){ echo "-"; }else{ echo number($ready_qty); } ?></td>
<td align="right"><?php if($sent_qty == 0){ echo "-"; }else{ echo number($sent_qty); } ?></td>
</tr>
<?php endforeach; ?>
<tr>
<td align="right"><strong>รวม</strong></td>
<td align="right"><strong><?php if($total_order == 0){ echo "-"; }else{ echo number($total_order); } ?></strong></td>
<td align="right"><strong><?php if($total_prepare == 0){ echo "-"; }else{ echo number($total_prepare); } ?></strong></td>
<td align="right"><strong><?php if($total_on_the_way == 0){ echo "-"; }else{ echo number($total_on_the_way); } ?></strong></td>
<td align="right"><strong><?php if($total_process == 0){ echo "-"; }else{ echo number($total_process); } ?></strong></td>
<td align="right"><strong><?php if($total_ready == 0){ echo "-"; }else{ echo number($total_ready); } ?></strong></td>
<td align="right"><strong><?php if($total_sent == 0){ echo "-"; }else{ echo number($total_sent); } ?></strong></td>
</tr>
<?php else: ?>
<tr><td colspan="9" align="center"><h4>------------- ไม่มีรายการ --------------</h4></td></tr>
<?php endif; ?>
</table>
</div>
<form id="payment_form" action="<?php echo base_url()."management/index/print_report/"; ?>" method="post">
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
	if(from ==""){
		alert("คุณยังไม่ได้เลือวัน");
	}else if(to == ""){
		alert("คุณยังไม่ได้เลือกวัน");
	}else{
		window.location.href="<?php echo $this->home."/qty_shop_report/rank/"; ?>"+from+"/"+to;
	}
}

function report(i){
	if(i =="x"){
		window.location.href="<?php echo $this->home."/qty_shop_report/this_month/"; ?>";
	}else{
		window.location.href="<?php echo $this->home."/qty_shop_report/day/"; ?>"+i+"/";
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