<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-dashboard'></i>&nbsp; รายงานยอดขายแยกตามสาขา</h3>
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
<div class="col-lg-2"><button class="btn btn-primary btn-block" onclick="sale_report(7);">7 วันล่าสุด</button></a></div>
<div class="col-lg-2"><button class="btn btn-success btn-block" onclick="sale_report(15);" >15 วันล่าสุด</button></a></div>
<div class="col-lg-2"><button class="btn btn-warning btn-block" onclick="sale_report(30);" >30 วันล่าสุด</button></a></div>
<div class="col-lg-2"><button class="btn btn-danger btn-block" onclick="sale_report(0);">เดือนนี้</button></a></div>

</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row"><div class="col-lg-12"><h4 style="text-align:center">ยอดขายสาขา <?php echo getShopName($id_shop); ?> วันที่ &nbsp; <?php echo thaiShortDate($from); ?>&nbsp; ถึงวันที่ &nbsp;<?php echo thaiShortDate($to); ?></h4></div></div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
<div class="col-lg-12">
<table class="table table-striped">
<thead>
<th style="width:25%">วันที่</th>
<th style="width:25%; text-align:right">ยอดเงินที่เปิดบิล</th>
<th style="width:25%; text-align:right">ยอดเงินที่รับสินค้าแล้ว</th>
<th style="width:25%; text-align:right">ยอดเงินที่ค้างรับสินค้า</th>
</thead>
<?php if($data != false) : ?>
<?php $total_amount =0; $total_complete = 0; $total_incomplete = 0; ?>
<?php foreach($data as $rs) :?>
<?php 
$amount = $this->report_model->sale_amount($id_shop, $rs['from'], $rs['to']);
$complete = $this->report_model->complete_amount($id_shop, $rs['from'], $rs['to']);
$incomplete = $this->report_model->incomplete_amount($id_shop, $rs['from'], $rs['to']);
?>
<tr>
<td><?php echo $rs['date']; ?></td>
<td align="right"><?php echo number($amount,2); ?></td>
<td align="right"><?php echo number($complete,2); ?></td>
<td align="right"><?php echo number($incomplete,2); ?></td>
</tr>
<?php $total_amount += $amount; $total_complete += $complete; $total_incomplete += $incomplete; ?>
<?php endforeach; ?>
<tr><td align="right"><strong>รวม </strong></td><td align="right"><?php echo number($total_amount,2); ?></td><td align="right"><?php echo number($total_complete,2); ?></td><td align="right"><?php echo number($total_incomplete,2); ?></td></tr>
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
	var shop = $("#id_shop").val();
	if(shop == 0){
		alert("คุณยังไม่ได้เลือกสาขา");
	}else if(from ==""){
		alert("คุณยังไม่ได้เลือวัน");
	}else if(to == ""){
		alert("คุณยังไม่ได้เลือกวัน");
	}else{
		window.location.href="<?php echo $this->home."/sale_by_shop/rank/"; ?>"+shop+"/"+from+"/"+to;
	}
}

function sale_report(i){
	var shop = $("#id_shop").val();
	if(shop == 0){
		alert("คุณยังไม่ได้เลือกสาขา");
	}else{
		if(i ==0){
			window.location.href="<?php echo $this->home."/sale_by_shop/this_month/"; ?>"+shop;
		}else{
			window.location.href="<?php echo $this->home."/sale_by_shop/day/"; ?>"+shop+"/"+i;
		}
	}
}
</script>
<?php endif; ?>
</div>