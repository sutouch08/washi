<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h4 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-tasks'></i>&nbsp; ปริมาณชิ้นงาน แยกตามสาขา(ส่วนของโรงงาน)</h4>
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
<div class="row"><div class="col-lg-12"><h4 style="text-align:center">รายงานปริมาณชิ้นงาน วันที่ &nbsp; <?php echo thaiShortDate($from); ?>&nbsp; ถึงวันที่ &nbsp;<?php echo thaiShortDate($to); ?> </h4></div></div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
<div class="col-lg-12">
<table class="table table-striped">
<thead>
<th style="width:40%">สาขา</th>
<th style="width:10%; text-align:right">รับมา</th>
<th style="width:10%; text-align:right">ส่งกลับ</th>
<th style="width:10%; text-align:right">ระหว่างทาง</th>
<th style="width:10%; text-align:right">ค้างอยู่</th>
</thead>
<?php if($shop_list != false) : ?>
<?php
	$total_received = 0;
	$total_received_back = 0;
	$total_process = 0;
	$total_on_the_way = 0;
?>
<?php foreach($shop_list as $rs) : ?>
<tr>
<td><?php echo getShopName($rs->id_shop); ?></td>
<?php 
	$received_qty = $this->report_model->received_qty($rs->id_shop, $from, $to); 
	$received_back_qty = $this->report_model->received_back_qty($rs->id_shop, $from, $to); 
	$on_process_qty = $this->report_model->on_process_qty($rs->id_shop, $from, $to); 
	$on_the_way_qty = $this->report_model->on_the_way_qty($rs->id_shop, $from, $to);
	$total_received += $received_qty;
	$total_received_back += $received_back_qty;
	$total_process += $on_process_qty;
	$total_on_the_way += $on_the_way_qty;
	?>
<td align="right"><?php if($received_qty == 0){ echo "-"; }else{ echo number($received_qty); } ?></td>
<td align="right"><?php if($received_back_qty == 0){ echo "-"; }else{ echo number($received_back_qty); } ?></td>
<td align="right"><?php if($on_the_way_qty == 0){ echo "-"; }else{ echo number($on_the_way_qty); } ?></td>
<td align="right"><?php if($on_process_qty == 0){ echo "-"; }else{ echo number($on_process_qty); } ?></td>
</tr>
<?php endforeach; ?>
<tr>
<td align="right"><strong>รวม</strong></td>
<td align="right"><strong><?php if($total_received == 0){ echo "-"; }else{ echo number($total_received); } ?></strong></td>
<td align="right"><strong><?php if($total_received_back == 0){ echo "-"; }else{ echo number($total_received_back); } ?></strong></td>
<td align="right"><strong><?php if($total_on_the_way == 0){ echo "-"; }else{ echo number($total_on_the_way); } ?></strong></td>
<td align="right"><strong><?php if($total_process == 0){ echo "-"; }else{ echo number($total_process); } ?></strong></td>
</tr>
<?php else: ?>
<tr><td colspan="9" align="center"><h4>------------- ไม่มีรายการ --------------</h4></td></tr>
<?php endif; ?>
</table>
</div>
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
		window.location.href="<?php echo $this->home."/qty_by_shop/rank/"; ?>"+from+"/"+to;
	}
}

function report(i){
	if(i =="x"){
		window.location.href="<?php echo $this->home."/qty_by_shop/this_month/"; ?>";
	}else{
		window.location.href="<?php echo $this->home."/qty_by_shop/day/"; ?>"+i+"/";
	}
}
</script>
<?php endif; ?>
</div>