
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
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; แก้ไข สินค้า</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>admin/product">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
             </a>
        		<button class='btn btn-success'<?php echo $access['edit']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."admin/product/update_data"); ?>
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<div class='col-lg-4' style="text-align:right">ชื่อสินค้า</div><input type="hidden" id="valid_code" value="0"/><input type="hidden" name="id_product" id="id_product" value="<?php echo $rs->id_product; ?>" />
<div class="col-lg-4"><input type="text" class="form-control" name="product_name" id="product_name" value="<?php echo $rs->product_name; ?>" required="required" autocomplete="off"/></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ราคา</div>
<div class="col-lg-4"><input type="text" class="form-control" name="price" id="price" value="<?php echo $rs->price; ?>" autocomplete="off" required /></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">หมวดหมู่</div>
<div class="col-lg-4"><select name="id_category" id="id_category" class="form-control"><?php echo selectCategory($rs->id_category); ?></select></div><div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ประเภท</div>
<div class="col-lg-4"><select name="id_type" id="id_type" class="form-control"><?php echo selectType($rs->id_type); ?></select></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">น้ำหนัก</div>
<div class="col-lg-4"><input type="text" class="form-control" name="weight" id="weight" value="<?php echo $rs->weight; ?>" autocomplete="off" required />	
</div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-2 col-lg-offset-6"><button type="button" id="btn_submit" class="form-control" style="display:none">Save</button></div>
<?php endforeach; ?>
<?php endif; ?>
<?php echo form_close(); ?>
</div><!-- End row -->
<script>
	$("#product_name").keyup(function(e){
		var code = $(this).val();
		var id = $("#id_product").val();
		$.ajax({
			url:"<?php echo base_url()."admin/product/valid_code/"; ?>"+code+"/"+id,
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
		var price = $("#price").val();
		var id_category = $("#id_category").val();
		var id_type = $("#id_type").val();
		var weight = $("#weight").val(); 
		var c_price = isNaN(parseInt(price));
		var c_weight = isNaN(parseInt(weight));
		if(code == 1){ 
			alert("ชื่อสินค้าซ้ำ ชื่อนี้ถูกใช้ไปแล้ว");
		}else if(price ==""){
			alert("กรุณาระบุราคา ถ้าไม่มีให้ใส่ 0.00");
		}else if(c_price == true){
			alert("กรุณาระบุราคาเป็นตัวเลขเท่านั้น");
		}else if(id_category == 0){
			alert("กรุณาเลือกหมวดหมู่");
		}else if(id_category == 0){
			alert("กรุณาเลือกประเภท");
		}else if(c_weight == true){
			alert("กรุณาระบุน้ำหนักเป็นตัวเลขเท่านั้น");
		}else if(weight ==""){
			alert("กรุณาระบุน้ำหนัก ถ้าไม่มีให้ใส่ 0.00");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		}
    });
</script>
<?php endif; ?>
</div>