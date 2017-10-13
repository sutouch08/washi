
<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu); ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-gear'></i>&nbsp; กำหนดค่าทั่วไป</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        		<button class='btn btn-success'<?php echo $access['edit']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/config/update_data"); ?>
<div class="col-lg-4"><hr/></div><div class="col-lg-4"><h3 style=" margin-top:0px; text-align:center">ระยะเวลา</h3></div><div class="col-lg-4"><hr/></div>
<div class="col-lg-12">&nbsp;</div>
<?php if($urgent != false) : ?>
<?php foreach($urgent as $rs) : ?>
<div class='col-lg-2' style="text-align:right"><?php echo $rs->urgent_name; ?></div><div class="col-lg-2">
<input type="text" class="form-control" name="<?php echo "urgent_".$rs->id_urgent; ?>" id="<?php echo "urgent_".$rs->id_urgent; ?>" value="<?php echo $rs->day; ?>" autocomplete="off" /></div><div class="col-lg-2">วัน</div>
<div class='col-lg-2' style="text-align:right">ชาร์จเพิ่ม</div><div class="col-lg-2">
<input type="text" class="form-control" name="<?php echo "charge_".$rs->id_urgent; ?>" id="<?php echo "charge_".$rs->id_urgent; ?>" value="<?php echo $rs->charge_up; ?>" autocomplete="off" /></div><div class="col-lg-2">%</div>
<div class="col-lg-12">&nbsp;</div>
<?php endforeach; ?>
<?php endif; ?>
<div class="col-lg-5"><hr/></div><div class="col-lg-2"><h3 style=" margin-top:0px; text-align:center">หมายเหตุ</h3></div><div class="col-lg-5"><hr/></div>
<div class="col-lg-12">&nbsp;</div>
<?php if($remark != false) : ?>
<?php $n = 1; ?>
<?php foreach($remark as $ro) : ?>
<div class='col-lg-2' style="text-align:right">หมายเหตุ <?php echo $n; ?></div>
<div class="col-lg-10"><input type="text" class="form-control" name="<?php echo $ro->remark_name; ?>" id="<?php echo $ro->remark_name; ?>" value="<?php echo $ro->remark_text; ?>" /></div>
<div class="col-lg-12">&nbsp;</div>

<?php $n++; ?>
<?php endforeach; ?>
<?php endif; ?>
<div class="col-lg-2 col-lg-offset-6"><button type="button" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#btn_save").click(function(e) {
		var urgent_1 = $("#urgent_1").val();
		var urgent_2 = $("#urgent_2").val();
		var urgent_3 = $("#urgent_3").val();
		var charge_1 = $("#charge_1").val();
		var charge_2 = $("#charge_2").val();
		var charge_3 = $("#charge_3").val();
		if(urgent_1 =="" || urgent_2 =="" || urgent_3 =="" || charge_1 =="" || charge_2 =="" || charge_3 ==""){
			alert("กรุณาระบุระยะเวลาให้ครบทุกช่อง");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>