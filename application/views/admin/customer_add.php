<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-users'></i>&nbsp; เพิ่ม ลูกค้า </h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>admin/customer">
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
             </a>
             <button type="button" class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/customer/insert_data"); ?>
<div class='col-lg-4' style="text-align:right">รหัสลูกค้า</div><input type="hidden" id="valid_code" value="0"/>
<div class="col-lg-4"><input type="text" class="form-control" name="customer_code" id="customer_code" placeholder="รหัสลูกค้า" required="required" autocomplete="off"/></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ชื่อลูกค้า</div>
<div class="col-lg-4"><input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="ชื่อลูกค้า" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เพศ</div>
<div class="col-lg-4">
<select name="gender" id="gender" class="form-control"><option value="undefine">ไมระบุ</option><option value="male">ผู้ชาย</option><option value="female">ผู้หญิง</option></select>
</div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">อีเมล์</div>
<div class="col-lg-4"><input type="text" class="form-control" name="email"  placeholder="อีเมล์"/></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เบอร์โทรศัพท์</div>
<div class="col-lg-4"><input type="text" class="form-control" name="phone" placeholder="โทรศัพท์" /></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ที่อยู่</div>
<div class="col-lg-4"><textarea name="address" id="address" class="form-control" placeholder="ที่อยู่"></textarea></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#customer_code").keyup(function(e){
		var code = $(this).val();
		$.ajax({
			url:"<?php echo base_url()."admin/customer/valid_code/"; ?>"+code,
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
		var customer_code = $("#customer_code").val();
		var customer_name = $("#customer_name").val();
		if(code == 1){ 
			alert("รหัสซ้ำ รหัสนี้ถูกใช้ไปแล้ว");
		}else if(customer_code == ""){
			alert("ต้องระบุรหัสลูกค้า");
		}else if(customer_name ==""){
			alert("ต้องระบุชื่อลูกค้า");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		$("#btn_submit").attr("type","button");
		}
    });
</script>
<?php endif; ?>
</div>