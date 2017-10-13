<script src="<?php echo base_url()."assets/js/plugins/timepicker/jquery.timepicker.min.js"; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url()."assets/js/plugins/timepicker/jquery.timepicker.css"; ?>"  />
<?php 
/***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/
$access = valid_access($id_menu); 
?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; เพิ่ม/แก้ไข ตารางเวลา</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	
        		<button class='btn btn-success' id="btn_save" <?php echo $access['add']; ?> onclick="set_time();"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
  
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<form id="set_time_form" action="<?php echo base_url(); ?>admin/set_time/set_table" method="post" >
<div class='row'>
<div class="col-lg-5" style="text-align:right">ชื่อช่วง</div>
<div class="col-lg-2"><input type="text" name="name" id="name" class="form-control" placeholder="ชื่อสำหรับเรียกช่วงเวลา" required="required" autofocus="autofocus" /></div>
<div class="col-lg-5"><span style="color:red">*</span></div>
<div class="col-lg-12">&nbsp </div>

<div class="col-lg-5" style="text-align:right">ตั้งแต่</div>
<div class="col-lg-2"><input type="text" name="start" id="start" class="form-control" placeholder="กำหนดเวลาเริ่มต้น" required="required" /></div>
<div class="col-lg-5"><span style="color:red">*</span></div>
<div class="col-lg-12">&nbsp </div>

<div class="col-lg-5" style="text-align:right">ถึง</div>
<div class="col-lg-2"><input type="text" name="end" id="end" class="form-control" placeholder="กำหนดเวลาสิ้นสุด" required /></div>
<div class="col-lg-5"><span style="color:red">*</span></div>
<div class="col-lg-12">&nbsp </div>
<button type="button" id="btn_submit" style="display:none">submit</button>
</form>
</div><!-- End row -->
<script>
	$("#start").timepicker({	'timeFormat':'H:i:s', 'minTime': '06:00:00', 'maxTime' : '23:00:00'});
	$("#end").timepicker({ 'timeFormat':'H:i:s', 'minTime': '06:00:00', 'maxTime' : '23:00:00'});
	
	function set_time()
	{
		var start = $("#start").val();
		var end = $("#end").val();
		if(end < start){
			alert("ไม่สามารถกำหนดเวลาสิ้นสุดให้น้อยกว่าเวลาเริ่มต้นได้");
		}else{
			$("#btn_submit").attr("type","submit");
			$("#btn_submit").click();
			$("#btn_submit").attr("type","button");
		}
	}
</script>
<?php endif; ?>
</div>