
<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu); ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; แก้ไข ชื่อล็อกอิน</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/user">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['edit']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/user/update_data"); ?>
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<div class='col-lg-4' style="text-align:right">ชื่อล็อกอิน</div><input type="hidden" id="valid_code" value="0" /><input type="hidden" name="id_user" id="id_user" value="<?php echo $rs->id_user; ?>" />
<div class="col-lg-4"><input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $rs->user_name; ?>" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">พนักงาน</div>
<div class="col-lg-4"><select name="id_employee" id="id_employee" class="form-control"><?php echo selectEmployee($rs->id_employee); ?></select></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">โปรไฟล์</div>
<div class="col-lg-4"><select name="id_profile" id="id_profile" class="form-control"><?php echo selectProfile($rs->id_profile); ?></select></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">สังกัด</div>
<div class="col-lg-4">	<select name="id_shop" id="id_shop" class="form-control"><?php echo selectShop($rs->id_shop); ?></select></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เห็นลูกค้าทั้งหมด</div>
<div class="col-lg-4">
<input type="radio" name="show_all" id="no" value="0" <?php echo radioCheck(0,$rs->show_all); ?> />&nbsp;<label for="no" style="padding-left:15px; padding-right:35px;">ไม่ใช่ </label>
<input type="radio" name="show_all" id="yes" value="1" <?php echo radioCheck(1,$rs->show_all); ?> />&nbsp;<label for="yes" style="padding-left:15px; padding-right:15px;">ใช่ </label>
</div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เปิดใช้งาน</div>
<div class="col-lg-4">
<input type="radio" name="active" id="active" value="1" <?php echo radioCheck(1,$rs->active); ?> />&nbsp;<label for="no" style="padding-left:15px; padding-right:35px;">ใช่ </label>
<input type="radio" name="active" id="disactive" value="0" <?php echo radioCheck(0,$rs->active); ?> />&nbsp;<label for="yes" style="padding-left:15px; padding-right:15px;">ไม่ใช่ </label>
</div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php endforeach; ?>
<?php endif; ?>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	
	$("#user_name").keyup(function(e){
		var code = $(this).val();
		var id = $("#id_user").val();
		$.ajax({
			url:"<?php echo base_url()."admin/user/valid_code/"; ?>"+code+"/"+id,
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
		var id_shop = $("#id_shop").val();
		var employee = $("#id_employee").val();
		var profile = $("#id_profile").val();
		if(code == 1){ 
			alert("ชื่อล็อกอินซ้ำ ชื่อนี้ถูกใช้ไปแล้ว");
		}else if(employee == 0){
			alert("กรุณาเลือกพนักงาน");
		}else if(profile == 0){
			alert("กรุณาเลือกโปรไฟล์");
		}else if(id_shop == 0){
			alert("กรุณาเลือกสาขา");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>