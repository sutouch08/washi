
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
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; เพิ่ม โปรไฟล์</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/profile">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/profile/insert_data"); ?>
<div class='col-lg-4' style="text-align:right">ชื่อโปรไฟล์</div><input type="hidden" id="valid_code" value="0"/>
<div class="col-lg-4"><input type="text" class="form-control" name="profile_name" id="profile_name" required="required" autocomplete="off"/></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#profile_name").keyup(function(e){
		var code = $(this).val();
		$.ajax({
			url:"<?php echo base_url()."admin/profile/valid_code/"; ?>"+code,
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
		if(code == 1){ 
			alert("ชื่อโปรไฟล์ซ้ำ ชื่อนี้ถูกใช้ไปแล้ว");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>