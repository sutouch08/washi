
<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; รีเซ็ตรหัสผ่าน</h3>
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
<?php echo form_open(base_url()."admin/user/change_password"); ?>
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<div class='col-lg-4' style="text-align:right">ชื่อล็อกอิน</div><input type="hidden" name="id_user" id="id_user" value="<?php echo $rs->id_user; ?>" />
<div class="col-lg-4"><input autocomplete="off" type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $rs->user_name; ?>" disabled /></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">รหัสผ่านใหม่</div>
<div class="col-lg-4"><input type="password" class="form-control" name="password" id="password" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ยืนยันรหัสผ่าน</div>
<div class="col-lg-4"><input type="password" class="form-control"  id="confirm_password" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php endforeach; ?>
<?php endif; ?>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#btn_save").click(function(e) {
		var password = $("#password").val();
		var length = $("#password").val().length;
		var confirm_password = $("#confirm_password").val();
		if(length < 4){
			alert("กรุณากำหนดรหัสผ่าน อย่างน้อย 4 ตัวอักษร" +length);
		}else if(password != confirm_password){
			alert("คุณป้อนรหัสผ่าน 2 ครั้งไม่ตรงกัน");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>