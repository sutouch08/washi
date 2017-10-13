
<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; เพิ่ม ล็อกอิน</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/user">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/user/insert_data"); ?>
<div class='col-lg-4' style="text-align:right">ชื่อล็อกอิน</div><input type="hidden" id="valid_code" value="0" />
<div class="col-lg-4"><input type="text" class="form-control" name="user_name" id="user_name" required="required" autocomplete="off"/></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">รหัสผ่าน</div>
<div class="col-lg-4"><input type="password" class="form-control" name="password" id="password" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ยืนยันรหัสผ่าน</div>
<div class="col-lg-4"><input type="password" class="form-control"  id="confirm_password" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">พนักงาน</div>
<div class="col-lg-4"><select name="id_employee" id="id_employee" class="form-control"><?php echo selectEmployee(); ?></select></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">โปรไฟล์</div>
<div class="col-lg-4"><select name="id_profile" id="id_profile" class="form-control"><?php echo selectProfile(); ?></select></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">สังกัด</div>
<div class="col-lg-4">	<select name="id_shop" id="id_shop" class="form-control"><?php echo selectShop(); ?></select></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เห็นลูกค้าทั้งหมด</div>
<div class="col-lg-4">	
<input type="radio" name="show_all" id="no" value="0" checked />&nbsp;<label for="no" style="padding-left:15px; padding-right:35px;">ไม่ใช่ </label>
<input type="radio" name="show_all" id="yes" value="1" />&nbsp;<label for="yes" style="padding-left:15px; padding-right:15px;">ใช่ </label>
</div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เปิดใช้งาน</div>
<div class="col-lg-4">
<input type="radio" name="active" id="active" value="1" checked />&nbsp;<label for="no" style="padding-left:15px; padding-right:35px;">ใช่ </label>
<input type="radio" name="active" id="disactive" value="0" />&nbsp;<label for="yes" style="padding-left:15px; padding-right:15px;">ไม่ใช่ </label>
</div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	
	$("#user_name").keyup(function(e){
		var code = $(this).val();
		$.ajax({
			url:"<?php echo base_url()."admin/user/valid_code/"; ?>"+code,
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
		var password = $("#password").val();
		var length = $("#password").val().length;
		var confirm_password = $("#confirm_password").val();
		var employee = $("#id_employee").val();
		var profile = $("#id_profile").val();
		if(code == 1){ 
			alert("ชื่อล็อกอินซ้ำ ชื่อนี้ถูกใช้ไปแล้ว");
		}else if(length < 4){
			alert("กรุณากำหนดรหัสผ่าน อย่างน้อย 4 ตัวอักษร" +length);
		}else if(password != confirm_password){
			alert("คุณป้อนรหัสผ่าน 2 ครั้งไม่ตรงกัน");
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