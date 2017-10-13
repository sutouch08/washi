
<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu); ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-flash'></i>&nbsp; เพิ่ม โปรโมชั่น</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/promotion">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/promotion/insert_data"); ?>
<div class='col-lg-4' style="text-align:right">ชื่อโปรโมชั่น</div><input type="hidden" id="valid_code" value="0"/>
<div class="col-lg-4"><input type="text" class="form-control" name="promotion_name" id="promotion_name" required="required" autocomplete="off"/></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ใช้กับ</div>
<div class="col-lg-2">
<select name="id_shop" id="id_shop" class="form-control" ><?php echo selectShop(); ?></select>
</div><div class="col-lg-6"></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เริ่ม</div>
<div class="col-lg-2"><input type="text" class="form-control" name="start" id="start" autocomplete="off" /></div><div class="col-lg-6"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">สิ้นสุด</div>
<div class="col-lg-2"><input type="text" class="form-control" name="end" id="end" autocomplete="off" /></div><div class="col-lg-6"></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ระยะเวลา</div>
<div class="col-lg-2"><input type="text" name="duration" id="duration" class="form-control" /></div><div class="col-lg-6"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">พิเศษ</div>
<div class="col-lg-4"><div class="row"><div class="col-lg-6"><input type="text" name="num" id="num" class="form-control" /></div>
<div class="col-lg-6">
<select name="unit" id="unit" class="form-control" />
    <option value="0" >----- เลือกหน่วย -----</option>
    <option value="1" >ชิ้น</option>
    <option value="2" >บาท</option>
</select>
 </div></div></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ราคา</div>
<div class="col-lg-2"><input type="text" class="form-control" name="price" id="price" value="0.00" autocomplete="off" required /></div><div class="col-lg-6"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เปิดใช้งาน</div>
<div class="col-lg-4">
<input type="radio" name="active" id="yes" value="1" checked /><label for="yes" style="padding-left:15px; padding-right: 30px;">ใช่</label>
<input type="radio" name="active" id="no" value="0" /><label for="no" style="padding-left:15px; padding-right: 30px;">ไม่ใช่</label>
</div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="button" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
  $("#start").datepicker({
	  dateFormat: 'dd-mm-yy', onClose: function(selectedDate){
		  $("#end").datepicker("option", "minDate", selectedDate);
	  }
  });
  $("#end").datepicker({
	  dateFormat: "dd-mm-yy", onClose: function(selectedDate){
		  $("#start").datepicker("option", "maxDate", selectedDate);
	  }
  });
  
	$("#promotion_name").keyup(function(e){
		var code = $(this).val();
		$.ajax({
			url:"<?php echo base_url()."admin/promotion/valid_code/"; ?>"+code,
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
		var price = $("#price").val();
		var units = $("#unit").val();
		var num = $("#num").val(); 
		var c_price = isNaN(parseInt(price));
		var c_num = isNaN(parseInt(num));
		if(code == 1){ 
			alert("ชื่อซ้ำ ชื่อนี้ถูกใช้ไปแล้ว");
		}else if(price ==""){
			alert("กรุณาระบุราคา ถ้าไม่มีให้ใส่ 0.00");
		}else if(c_price == true){
			alert("กรุณาระบุราคาเป็นตัวเลขเท่านั้น");
		}else if(units == 0){
			alert("กรุณาเลือกหน่วย");
		}else if(c_num == true){
			alert("กรุณาระบุสิ่งที่ได้เป็นตัวเลขเท่านั้น");
		}else if(num =="" || num < 1){
			alert("กรุณาระบุสิ่งที่ได้");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>