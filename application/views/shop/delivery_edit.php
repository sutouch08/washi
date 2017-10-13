<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-users'></i>&nbsp; ส่งออเดอร์</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/delivery">
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
             </a>
             <button type="button" class='btn btn-success'<?php echo $access['edit']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."shop/delivery/update_data"); ?>
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<input type="hidden" name="id_shop" id="id_shop" value="<?php echo $this->session->userdata("id_shop"); ?>"  />
<input type="hidden" name="id_delivery" id="id_delivery" value="<?php echo $rs->id_delivery; ?>"  />
<div class='col-lg-3'>
	<div class="input-group">
    	<span class="input-group-addon">เลขที่อ้างอิง</span>
        <input type="text" class="form-control" value="<?php echo $rs->reference ?>" disabled  />
    </div>
</div>    
<div class='col-lg-3'>
	<div class="input-group">
    	<span class="input-group-addon">ปลายทาง</span>
        <select name="id_target" id="id_target" class="form-control" ><?php echo selectShop($rs->id_target); ?></select>
    </div>
</div> 
<div class='col-lg-3'>
	<div class="input-group">
    	<span class="input-group-addon">ทะเบียนรถ</span>
        <select name="id_car" id="id_car" class="form-control" ><?php echo selectCar($rs->id_car); ?></select>
    </div>
</div> 
<div class='col-lg-3'>
	<div class="input-group">
    	<span class="input-group-addon">พนักงานขับ</span>
        <select name="id_driver" id="id_driver" class="form-control" ><?php echo selectDriver($rs->id_driver); ?></select>
    </div>
</div> 
<div class="col-lg-12">&nbsp;</div>

<div class="col-lg-2 col-lg-offset-6"><button type="submit" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php endforeach; ?>
<?php endif; ?>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#btn_save").click(function(e) {
		var id_target = $("#id_target").val();
		var id_car = $("#id_car").val();
		var id_driver = $("#id_driver").val();
		if(id_target ==0){
			alert("กรุณาเลือกปลายทาง");
		}else if(id_car == 0){
			alert("กรุณาเลือกทะเบียนรถ");
		}else if(id_driver == 0){
			alert("กรุณาเลือกพนักงานขับรถ");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		$("#btn_submit").attr("type","button");
		}
    });
</script>
<?php endif; ?>
</div>