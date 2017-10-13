
<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-user'></i>&nbsp; เพิ่ม พนักงานขับรถ</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/driver">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/driver/insert_data"); ?>
<div class='col-lg-4' style="text-align:right">เลือกพนักงาน</div><input type="hidden" id="valid_code" value="0"/>
<div class="col-lg-4"><select name="id_employee" id="id_employee" class="form-control"><?php echo selectEmployee(); ?></select></div><div class="col-lg-4"><span style="color:red">*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ทะเบียนรถ</div>
<div class="col-lg-4"><select name="id_car" id="id_car" class="form-control"><?php echo selectCar(); ?></select></div><div class="col-lg-4"><span style="color:red">*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เปิดใช้งาน</div>
<div class="col-lg-4">
<input type="radio" name="active" id="yes" value="1" checked /><label for="yes" style="padding-left:15px; padding-right:30px;">ใช่</label>
<input type="radio" name="active" id="no" value="0" /><label for="no" style="padding-left:15px; padding-right:30px;">ไม่ใช่</label>
</div><div class="col-lg-4"><span style="color:red"></span></div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="button" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>	
	$("#id_employee").change(function(e){
		var code = $(this).val();
		$.ajax({
			url:"<?php echo base_url()."admin/driver/valid_code/"; ?>"+code,
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
		var id_car = $("#id_car").val(); 
		if(code == 1){ 
			alert("พนักงานคนนี้เป็นพนักงานขับรถอยู่แล้ว กรุณาเลือกคนใหม่");
		}else if(id_car ==0){
			alert("กรุณาเลือกรถที่รับผิดชอบ");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>