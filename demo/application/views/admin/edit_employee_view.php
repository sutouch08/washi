
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
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; แก้ไข พนักงาน</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/employee">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['edit']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/employee/update_data"); ?>
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<div class='col-lg-4' style="text-align:right">รหัสพนักงาน</div><input type="hidden" id="valid_code" value="0"/><input type='hidden' name="id_employee" id="id_employee" value="<?php echo $rs->id_employee; ?>"/>
<div class="col-lg-4"><input type="text" class="form-control" name="employee_code" id="employee_code" value="<?php echo $rs->employee_code; ?>" required="required" autocomplete="off"/></div>
<div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ชื่อ</div>
<div class="col-lg-4"><input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $rs->first_name; ?>" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">นามสกุล</div>
<div class="col-lg-4"><input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $rs->last_name; ?>" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เบอร์โทรศัพท์</div>
<div class="col-lg-4"><input type="text" class="form-control" name="phone" value="<?php echo $rs->phone; ?>" /></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">สังกัด</div>
<div class="col-lg-4">
		<select name="shop" id="shop" class="form-control">
        <?php echo selectShop($rs->id_shop); ?>
        </select>
</div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php endforeach; ?>
<?php endif; ?>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#employee_code").keyup(function(e){
		var code = $(this).val();
		var id = $("#id_employee").val();
		$.ajax({
			url:"<?php echo base_url()."admin/employee/valid_code/"; ?>"+code+"/"+id,
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
		var shop = $("#shop").val();
		if(code == 1){ 
			alert("รหัสซ้ำ รหัสนี้ถูกใช้ไปแล้ว");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>