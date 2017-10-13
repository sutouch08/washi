<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6' >
    	<h4 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-clock-o'></i>&nbsp; รายงานการบันทึกเวลา แยกตามพนักงาน</h4>
    </div>
     <div class='col-lg-6'>
    	<p class="pull-right" style="margin-bottom:0px; margin-top:0px;"><button type="button" class="btn btn-success" onclick="print_report();"><i class="fa fa-print"></i>&nbsp; พิมพ์</button></p>
    </div>
    
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
    <div class="col-lg-3">
    	<div class="input-group"><span class="input-group-addon">พนักงาน</span>
   		<select name="id_employee" id="id_employee" class="form-control"><?php echo selectShopEmployee($id_employee); ?></select>
    	</div>
    </div>
    <div class="col-lg-2">&nbsp;</div>
    <div class="col-lg-3"><div class="input-group"><span class="input-group-addon">จากวันที่</span><input type="text" id="from" name="from" class="form-control" value="<?php echo thaiShortDate($from); ?>" /></div></div>
    <div class="col-lg-3"><div class="input-group"><span class="input-group-addon">ถึงวันที่</span><input type="text" id="to" name="to" class="form-control" value="<?php echo thaiShortDate($to); ?>" /></div></div>
    <div class="col-lg-1"><button class="btn btn-default" onclick="get_report()">ตกลง</button></div>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<!--
<div class="row">
	<div class="col-lg-2"><button class="btn btn-info btn-block" onclick="payment_report(0);">วันนี้</button></div>
	<div class="col-lg-2"><button class="btn btn-primary btn-block" onclick="payment_report(7);">7 วันล่าสุด</button></div>
	<div class="col-lg-2"><button class="btn btn-success btn-block" onclick="payment_report(15);" >15 วันล่าสุด</button></div>
	<div class="col-lg-2"><button class="btn btn-warning btn-block" onclick="payment_report(30);" >30 วันล่าสุด</button></div>
	<div class="col-lg-2"><button class="btn btn-danger btn-block" onclick="payment_report('x');" >เดือนนี้</button></div>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
-->
<div class="row">
	<div class="col-lg-12">
		<h4 style="text-align:center" id="title">รายงานการบันทึกเวลา วันที่ &nbsp; <?php echo thaiShortDate($from); ?>&nbsp; ถึงวันที่ &nbsp;<?php echo thaiShortDate($to); ?>   <?php echo getEmployeeName($id_employee); ?></h4>
	</div>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />
<div class='row'>
    <div class="col-lg-12" id="report">
    <?php if($time_table != false) : ?>
        <table class="table table-striped table-bordered">
        <thead>
            <th style="width:10%; text-align:center">วันที่</th>
            <?php foreach($time_table as $rs) :?>
            <th style="text-align:center"><?php echo shortTime($rs->start)." - ".shortTime($rs->end); ?></th>
            <?php endforeach; ?> 
        </thead>
<?php if($diff != false) : ?>
<?php $i = 0; ?>
<?php while($i<=$diff) : ?>
<tr >
<td align="center"><?php echo thaiShortDate($from); ?></td>
<?php foreach($time_table as $rs) :?>
<?php $start = date("Y-m-d",strtotime($from))." ".$rs->start; $end = date("Y-m-d",strtotime($from))." ".$rs->end; ?>
	<td align="center"><?php echo $this->user_model->isRecorded($id_employee, $start, $end); ?></td>	
<?php endforeach; ?>  
</tr>
 <?php $from = date("Y-m-d", strtotime("+1 day $from")); $i++; ?>
<?php endwhile; ?>
<tr>
	<td colspan="9" ><span style="color:red;">***</span>&nbsp;&nbsp;&nbsp;
    	<i class='fa fa-circle' style='color: #8CC152'></i>&nbsp; บันทึกเวลา  &nbsp;&nbsp;&nbsp;<i class='fa fa-circle-thin' style='color: #AAB2BD'></i>&nbsp; ไม่ได้บันทึกเวลา
     </td>
</tr>
<?php else : ?>
<tr><td colspan="9" align="center"><h4>------------- ไม่มีรายการ --------------</h4></td></tr>
<?php endif; ?>
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
	var id_employee = $("#id_employee").val();
	if(id_employee == 0){
		alert("คุณยังไม่ได้เลือกพนักงาน");
	}else if(from ==""){
		alert("คุณยังไม่ได้เลือวัน");
	}else if(to == ""){
		alert("คุณยังไม่ได้เลือกวัน");
	}else{
		window.location.href="<?php echo $this->home."/time_recorded_report/"; ?>"+id_employee+"/"+from+"/"+to;
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