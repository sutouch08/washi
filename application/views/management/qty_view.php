<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-dashboard'></i>&nbsp; ปริมาณชิ้นงาน</h3>
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
<div class="row"><div class="col-lg-12"><h4 style="text-align:center">รายงานปริมาณชิ้นงานรับมา วันที่ &nbsp; <?php echo thaiShortDate($from); ?>&nbsp; ถึงวันที่ &nbsp;<?php echo thaiShortDate($to); ?> </h4></div></div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
<div class="col-lg-12">
<?php if($category != false) : ?>
<table class="table table-striped">
<thead><th style="width:40%">สาขา</th>
<?php foreach($category as $ro) :?>
<th style="width:10%; text-align:right"><?php echo getCategoryName($ro->id_category); ?></th>
<?php endforeach; ?>
<th style="width:10%; text-align:right">รวม</th>
</thead>
<?php endif; ?>

<?php if($shop_list != false && $category != false) : ?>
<?php foreach($shop_list as $rs) : ?>
<tr>
<td><?php echo getShopName($rs->id_shop); ?></td>
<?php foreach($category as $ro) : ?>
<td align="right"><?php echo number($this->report_model->get_qty_by_shop($rs->id_shop, $ro->id_category, $from, $to)); ?></td>
<?php endforeach; ?>
<td align="right"><?php echo number($this->report_model->get_total_qty_by_shop($rs->id_shop, $from, $to)); ?></td>
</tr>
<?php endforeach; ?>
<?php if($category != false) : ?>
<tr>
<td align="right">รวม</td>
<?php foreach($category as $ro) :?>
<td align="right"><?php echo number($this->report_model->get_total_qty_by_category($ro->id_category, $from, $to)); ?></td>
<?php endforeach; ?>
<td align="right"><?php echo number($this->report_model->get_total_qty($from, $to)); ?></td>
</tr>
<?php endif; ?>
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
		window.location.href="<?php echo $this->home."/qty_report/rank/"; ?>"+from+"/"+to;
	}
}

function report(i){
	if(i =="x"){
		window.location.href="<?php echo $this->home."/qty_report/this_month/"; ?>";
	}else{
		window.location.href="<?php echo $this->home."/qty_report/day/"; ?>"+i+"/";
	}
}
</script>
<?php endif; ?>
</div>