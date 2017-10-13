<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<style>
	th { 
		border-bottom: solid 2px #ccc;
		 }
</style>
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
             <button type="button" class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<?php echo form_open(base_url()."shop/delivery/confirm_edit/".$rs->id_delivery, array("id"=>"delivery_form")); ?>
<input type="hidden" name="id_shop" id="id_shop" value="<?php echo $this->session->userdata("id_shop"); ?>"  />
<input type="hidden" name="id_delivery" id="id_delivery" value="<?php echo $rs->id_delivery; ?>" />
<?php echo form_close(); ?>
<div class='col-lg-3'>
	<div class="input-group">
    	<span class="input-group-addon">เลขที่อ้างอิง</span>
        <input type="text" class="form-control" value="<?php echo $rs->reference; ?>" disabled  />
    </div>
</div>    
<div class='col-lg-3'>
	<div class="input-group">
    	<span class="input-group-addon">ปลายทาง</span>
        <select name="id_target" id="id_target" class="form-control" disabled ><?php echo selectShop($rs->id_target); ?></select>
    </div>
</div> 
<div class='col-lg-3'>
	<div class="input-group">
    	<span class="input-group-addon">ทะเบียนรถ</span>
        <select name="id_car" id="id_car" class="form-control" disabled ><?php echo selectCar($rs->id_car); ?></select>
    </div>
</div> 
<div class='col-lg-3'>
	<div class="input-group">
    	<span class="input-group-addon">พนักงานขับ</span>
        <select name="id_driver" id="id_driver" class="form-control" disabled ><?php echo selectDriver($rs->id_driver); ?></select>
    </div>
</div> 
<div class="col-lg-12">&nbsp;</div>
</div><!-- End row -->
<?php endforeach; ?>
<?php endif; ?>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-4 col-lg-offset-4">
<div class="input-group">
<span class="input-group-addon">ยิงบาร์โค้ด</span><input type="text" name="barcode" id="barcode" class="form-control" />
<span class="input-group-btn"><button type="button" id="btn_ok" class="btn btn-default" ><span id="load">ตกลง</span></button></span>
</div>
</div>
</div>

<h4>รอโหลด</h4>
<hr style='border-color:#CCC; margin-top: 15px; margin-bottom:0px;' />
<div class="row">
<div class="col-lg-12">
<table class="table table-striped">
<tr id="head1"><th style="width:15%;">เลขที่อ้างอิง</th><th style="width:35%">ลูกค้า</th><th style="width:10%; text-align:right">จำนวน</th><th style="width:10%; text-align:right">ยอดเงิน</th><th style="width:10%; text-align:right">น้ำหนัก</th><th style="width:10%; text-align:center">เงื่อนไข</th><th></th></tr>
<?php if($order != false) : ?>
<?php foreach($order as $or) : ?>
<?php if($or->id_delivery_detail == "") : ?>
<tr id="row<?php echo $or->id_order; ?>">
	<td><?php echo $or->order_no; ?></td><td><?php echo getCustomerName($or->id_customer); ?></td>
    <td align="right"><?php echo orderQty($or->id_order); ?></td><td align="right"><?php echo orderAmount($or->id_order); ?></td>
    <td align="right"><?php echo orderWeight($or->id_order); ?> กก.</td><td align="center"><?php echo getUrgent($or->id_urgent); ?></td>
    <td align="right"><button type="button" class="btn btn-danger" id="btn_<?php echo $or->id_order; ?>" onclick="cancle(<?php echo $or->id_order; ?>);" style="display:none;" ><i class="fa fa-trash"></i>&nbsp; ยกเลิก</button></td>
</tr>     
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>   

</table>
</div>
</div>
<div class="col-lg-12">&nbsp;</div>
<h4>บนรถ</h4>
<hr style='border-color:#CCC; margin-top: 15px; margin-bottom:0px;' />
<div class="row">
<div class="col-lg-12">
<table class="table table-striped">
<tr id="head2"><th style="width:15%;">เลขที่อ้างอิง</th><th style="width:35%">ลูกค้า</th><th style="width:10%; text-align:right">จำนวน</th><th style="width:10%; text-align:right">ยอดเงิน</th><th style="width:10%; text-align:right">น้ำหนัก</th><th style="width:10%; text-align:center">เงื่อนไข</th><th></th></tr>
<?php if($loaded != false) : ?>
<?php foreach($loaded as $or) : ?>

<tr id="row<?php echo $or->id_order; ?>">
	<td><?php echo $or->order_no; ?></td><td><?php echo getCustomerName($or->id_customer); ?></td>
    <td align="right"><?php echo orderQty($or->id_order); ?></td><td align="right"><?php echo orderAmount($or->id_order); ?></td>
    <td align="right"><?php echo orderWeight($or->id_order); ?> กก.</td><td align="center"><?php echo getUrgent($or->id_urgent); ?></td>
    <td align="right"><button type="button" class="btn btn-danger" id="btn_<?php echo $or->id_order; ?>" onclick="cancle(<?php echo $or->id_order; ?>);"><i class="fa fa-trash"></i>&nbsp; ลบ</button></td>
</tr>     

<?php endforeach; ?>
<?php endif; ?>    

</table>
</div>
</div>

<script>
function cancle(id_order){
	var id_delivery = $("#id_delivery").val();
	window.location.href="<?php echo base_url(); ?>shop/delivery/delete_detail/"+id_order+"/"+id_delivery+"/edit";
}
$("#barcode").bind("enterKey", function(e){
	
	$("#btn_ok").click();

});
$("#barcode").keyup(function(e){
	if(e.keyCode == 13){
		$(this).trigger("enterKey");
	}
});

$("#btn_ok").click(function(){
	var id_delivery = $("#id_delivery").val();
	var order_number = $("#barcode").val();
	if(order_number !=""){
		$("#barcode").val("");
		$("#load").html("<i class='fa fa-spinner fa-spin'></i>");
		$.ajax({
			url:"<?php echo base_url(); ?>shop/delivery/insert_detail/"+id_delivery+"/"+order_number,
			type:"POST",
			cache:false,
			success: function(result){
				if(result !="x"){
					$("#row"+result).insertAfter($("#head2"));
					$("#btn_"+result).css("display","");
					$("#load").html("ตกลง");
					$("#barcode").focus();
				}else{
					alert("บาร์โค้ดไม่ถูกต้อง");
					$("#barcode").focus();
					$("#load").html("ตกลง");
				}
			}
		});	
	}
	$("#barcode").focus();
});

$("#btn_save").click(function(){
	$("#delivery_form").submit();
});
</script>
<?php endif; ?>
</div>