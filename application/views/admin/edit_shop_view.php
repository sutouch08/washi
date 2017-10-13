
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
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; แก้ไข สำนักงาน</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/shop">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['edit']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/shop/update_data"); ?>
<?php foreach($data as $rs) : ?>
<input name="id_shop" id="id_shop" type="hidden" value="<?php echo $rs->id_shop; ?>" />
<div class='col-lg-4' style="text-align:right">รหัส</div><input type="hidden" id="valid_code" value="0"/>
<div class="col-lg-4">
	<input type="text" pattern="[A-Z]{2}" title="ตัวพิมพ์ใหญ่ 2 ตัวเท่านั้น" class="form-control" name="shop_code" id="shop_code" value="<?php echo $rs->shop_code; ?>" required="required" /></div>
    <div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ชื่อสาขา</div><input type="hidden" id="valid_name" value="0"/>
<div class="col-lg-4"><input type="text" class="form-control" name="shop_name" id="shop_name" value="<?php echo $rs->shop_name; ?>" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ที่อยู่</div>
<div class="col-lg-4"><textarea class="form-control" name="shop_address" ><?php echo $rs->shop_address; ?></textarea></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เบอร์โทรศัพท์</div>
<div class="col-lg-4"><input type="text" class="form-control" name="shop_phone" value="<?php echo $rs->shop_phone; ?>"/></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php endforeach; ?>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#shop_code").keyup(function(e){
		var code = $(this).val();
		var id = $("#id_shop").val();
		$.ajax({
			url:"<?php echo base_url()."admin/shop/valid_code/"; ?>"+code+"/"+id,
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
		var id = $("#id_shop").val();
		$.ajax({
			url:"<?php echo base_url()."admin/shop/valid_name/"; ?>"+name+"/"+id,
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