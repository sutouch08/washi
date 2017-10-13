
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
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; เพิ่ม สำนักงาน</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/shop">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/shop/insert_data"); ?>
<div class='col-lg-4' style="text-align:right">รหัส</div><input type="hidden" id="valid_code" value="0"/>
<div class="col-lg-4"><input type="text" pattern="[A-Z]{2}" title="ตัวพิมพ์ใหญ่ 2 ตัวเท่านั้น" class="form-control" name="shop_code" id="shop_code" required="required" autocomplete="off"/></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ชื่อสาขา</div><input type="hidden" id="valid_name" value="0"/>
<div class="col-lg-4"><input type="text" class="form-control" name="shop_name" id="shop_name" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ที่อยู่</div>
<div class="col-lg-4"><textarea class="form-control" name="shop_address" ></textarea></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เบอร์โทรศัพท์</div>
<div class="col-lg-4"><input type="text" class="form-control" name="shop_phone" /></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#shop_code").keyup(function(e){
		var code = $(this).val();
		$.ajax({
			url:"<?php echo base_url()."admin/shop/valid_code/"; ?>"+code,
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
	$("#shop_name").keyup(function(e){
		var name = $(this).val();
		$.ajax({
			url:"<?php echo base_url()."admin/shop/valid_name/"; ?>"+name,
			cache:false,
			success: function(valid){
				if(valid !=''){
					$("#valid_name").val(valid);
				}else{
					$("#valid_name").val(0);
				}
			}
		});		
	});
	
	$("#btn_save").click(function(e) {
		var code = $("#valid_code").val();
		var name = $("#valid_name").val();
		if(code == 1){ 
			alert("รหัสซ้ำ รหัสนี้ถูกสาขาอื่นใช้ไปแล้ว");
		}else if(name == 1){
			alert("ชื่อสาขาซ้ำ มีสาขาชื่อเดียวกันอยู่แล้ว กรุณาเปลี่ยนใหม่");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>