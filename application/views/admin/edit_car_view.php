
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
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-turck'></i>&nbsp; แก้ไข รถ</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/car">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['edit']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/car/update_data"); ?>
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<div class='col-lg-4' style="text-align:right">ทะเบียนรถ</div><input type="hidden" id="valid_code" value="0"/><input type="hidden" name="id_car" id="id_car" value="<?php echo $rs->id_car; ?>" />
<div class="col-lg-4"><input type="text" class="form-control" name="car_plate" id="car_plate" value="<?php echo $rs->car_plate; ?>" required="required" autocomplete="off"/></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">รุ่น</div>
<div class="col-lg-4"><input type="text" class="form-control" name="car_brand" id="car_brand" value="<?php echo $rs->car_brand; ?>" /></div><div class="col-lg-4"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">น้ำหนักบรรทุก(กก.)</div>
<div class="col-lg-4"><input type="text" class="form-control" name="capacity" id="capacity" value="<?php echo $rs->capacity; ?>" required />	</div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="button" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php endforeach; ?>
<?php endif; ?>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#car_plate").keyup(function(e){
		var code = $(this).val();
		var id = $("#id_car").val();
		$.ajax({
			url:"<?php echo base_url()."admin/car/valid_code/"; ?>"+code+"/"+id,
			cache:false,
			success: function(valid){
				if(valid !=''){
					$("#valid_code").val(valid);
				}else{
					$("#valid_code").val(0);
				}
			}
		});		
	});
	
	$("#btn_save").click(function(e) {
		var code = $("#valid_code").val();
		var capacity = $("#capacity").val(); 
		var c_weight = isNaN(parseInt(capacity));
		if(code == 1){ 
			alert("ทะเบียนซ้ำ รถทะเบียนนี้มีในระบบแล้ว");
		}else if(c_weight == true){
			alert("กรุณาระบุน้ำหนักเป็นตัวเลขเท่านั้น");
		}else if(capacity ==""){
			alert("กรุณาระบุน้ำหนัก ถ้าไม่มีให้ใส่ 0.00");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>