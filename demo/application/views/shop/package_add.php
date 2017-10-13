<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-credit-card'></i>&nbsp; ซื้อ แพ็คเกจ</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/index">
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
             </a>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."shop/package/add_package"); ?>
<?php if($data != false) : ?>
<?php $n = 1; ?>
<?php foreach($data as $rs): ?>
<div class="col-lg-12"><h4 style="text-align:center"><?php echo $rs->promotion_name; ?></h4></div>
<div class="col-lg-12"><hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' /></div>
<input type="hidden" name="id_customer" id="id_customer" />
<input type="hidden" name="id_promotion" id="id_promotion" value="<?php echo $rs->id_promotion; ?>" />
<input type="hidden" name="price" id="price" value="<?php echo $rs->price; ?>" />
<input type="hidden" name="start" value="<?php echo $rs->start; ?>" />
<input type="hidden" name="end" value="<?php echo $rs->end; ?>" />
<input type="hidden" name="duration" value="<?php echo $rs->duration; ?>" />
<?php if($rs->pcs >0){ $credit = $rs->pcs; $credit_type = 1; }else if($rs->amount >0){ $credit = $rs->amount; $credit_type = 2; }else{ $credit = $rs->discount; $credit_type = 3; } ?>
<input type="hidden" name="credit" id="credit" value="<?php echo $credit; ?>" />
<input type="hidden" name="id_credit_type" value="<?php echo $credit_type; ?>" />
<input type="hidden" name="credit_add" id="credit_add" value="<?php echo $credit; ?>" />
<div class='col-lg-4' style="text-align:right">ลูกค้า </div><div class="col-lg-4"><input type="text" name="customer" id="customer" class="form-control" required="required" autocomplete="off" /></div>
<div class="col-lg-4"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>

<div class='col-lg-4' style="text-align:right">ราคาแพ็คเกจ</div><div class="col-lg-2"><input type="text" class="input-label" value="<?php echo $rs->price; ?>"  readonly="readonly" /></div>
<div class="col-lg-6"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>

<div class='col-lg-4' style="text-align:right">จำนวน </div><div class="col-lg-2"><input type="text" name="qty" id="qty" class="form-control" required="required" autocomplete="off" value="1" /></div>
<div class="col-lg-6"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>

<div class='col-lg-4' style="text-align:right">จำนวนเงิน </div><div class="col-lg-2"><input type="text" name="total" id="total" class="input-label"  value="<?php echo $rs->price; ?>" readonly="readonly" /></div>
<div class="col-lg-6"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>

<div class='col-lg-4' style="text-align:right">รับเงิน</div><div class="col-lg-2"><input type="text" name="receive" id="receive" class="form-control" required="required" autocomplete="off" /></div>
<div class="col-lg-6"><span style="color:red";>*</span></div>
<div class="col-lg-12">&nbsp;</div>

<div class='col-lg-4' style="text-align:right">เงินทอน</div><div class="col-lg-2"><input type="text" name="change" id="change" class="input-label" readonly="readonly" /></div>
<div class="col-lg-6"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>

<div class='col-lg-6' style="text-align:right"></div><div class="col-lg-2"><button type="button" id="btn_save" class="btn btn-success btn-block">ชำระเงิน</button> </div>
<div class="col-lg-4"><input type="hidden" id="hit" value="0" /><button type="button" id="btn_submit" style="display:none;">submit</button></div>
<div class="col-lg-12">&nbsp;</div>
        <?php endforeach; ?>
        <?php else : ?>
  <div class="col-lg-12"><h4>---------- ไม่มีเพ็จเกจ -----------</h4></div>
    <?php endif; ?>
<?php echo form_close(); ?>   
</div><!-- End row -->
<?php endif; ?>
</div>
<script>
$(document).ready(function(e) {
    $("#customer").autocomplete({
		source:"<?php echo base_url(); ?>shop/customer/find",
		autoFocus: true,
		close: function(event,ui){
			var data = $("#customer").val();
			var arr = data.split(" : ");
			var id = arr[0];
			var code = arr[1];
			var name = arr[2];
			var phone = arr[3];
			$("#id_customer").val(id);
			$("#customer").val(name);
		}
	});			
	$("#qty").keyup(function(){
		var qty = $(this).val();
		var price =$("#price").val()
		var credit = $("#credit").val();
		var amount = qty*price;
		var credit_add = qty*credit;
		$("#total").val(amount);	
		$("#credit_add").val(credit_add);	
	});

	$("#receive").keyup(function(e) {
		var get = $(this).val();
		var amount = $("#total").val();
		var change = get-amount;
		$("#change").val(change);
	});
	
	$("#customer").bind("enterKey",function(){
		if($(this).val() != ""){
			$("#qty").focus();
		}
	});
	$("#customer").keyup(function(e){
		if(e.keyCode == 13)
		{
			$(this).trigger("enterKey");
		}
	});
	
	$("#qty").bind("enterKey",function(){
		if($("#qty").val() != ""){
			$("#receive").focus();
		}
	});
	$("#qty").keyup(function(e){
		if(e.keyCode == 13)
		{
			$(this).trigger("enterKey");
		}
	});
	
	$("#receive").bind("enterKey",function(){
		if($("#receive").val() != ""){
			$("#btn_save").focus();
		}
	});
	$("#receive").keyup(function(e){
		if(e.keyCode == 13)
		{
			$(this).trigger("enterKey");
		}
	});
	
	$("#btn_save").bind("enterKey",function(){
		get_payment();
	});
	$("#btn_save").keyup(function(e){
		if(e.keyCode == 13)
		{
			$(this).trigger("enterKey");
		}
	});

});
$("#btn_save").click(function(){
	get_payment();
});

function get_payment(){
	var id_customer = $("#id_customer").val();
	var id_promotion = $("#id_promotion").val();
	var price = $("#price").val();
	var qty = $("#qty").val();
	var amount = $("#total").val();
	var receive = $("#receive").val();
	var change = $("#change").val();
	if(id_customer ==""){
		alert("กรุณาเลือกลูกค้า");
	}else if($("#customer").val() ==""){
		alert("กรุณาเลือกลูกค้า");
	}else if(id_promotion ==""){
		alert("เกิดข้อผิดพลาด!! ไม่พบ ID ของแพ็คเก็จ ยกเลิก แล้วลองใหม่ หากยังพบข้อผิดพลาดนี้อีก กรุณาติดต่อผู้ดูแลระบบ");
	}else if(price ==""){
		alert("ไม่พบราคาสินค้า กรุณาตรวจสอบ");
	}else if(qty =="" || qty ==0){
		alert("จำนวนขั้นต่ำในการซื้อแพ็คเกจอย่างน้อย 1 ");
		$("#qty").focus();
	}else if(amount ==""){
		alert("เกิดข้อผิดพลาด ระบบไม่สามารถคำนวณยอดเงินได้ ยกเลิก แล้วลองใหม่ หากยังพบข้อผิดพลาดนี้อีก กรุณาติดต่อผู้ดูแลระบบ");
	}else if(receive =="" || parseInt(receive) < parseInt(amount)){
		alert("ยอดชำระไม่ครบ");
		$("#receive").focus();
	}else if(change < 0){
		alert("ยอดชำระไม่ครบ");
		$("#receive").focus();
	}else{
		if($("#hit").val() ==0){
			$("#btn_submit").attr("type", "submit");
			$("#btn_submit").click();
			$("#hit").val(1);
			$("#qty").focus();
			$("#btn_submit").attr("type", "button");
		}
	}
}
</script>