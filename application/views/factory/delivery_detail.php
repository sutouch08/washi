<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-truck'></i>&nbsp; การจัดส่ง</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>factory/delivery">
        		<button class='btn btn-warning'><i class='fa fa-reply'></i>&nbsp; กลับ</button>
             </a>
             <a href="<?php echo $this->home."/print_delivery/".$id_delivery; ?>">
             <button type="button" class='btn btn-success' id="btn_print"><i class='fa fa-print'></i>&nbsp; พิมพ์</button>
             </a>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php if($data != false) : ?>
<?php foreach($data as $rs) : ?>
<div class='col-lg-3'>เลขที่อ้างอิง : <?php echo $rs->reference; ?></div>    
<div class='col-lg-3'>วันที่ : <?php echo thaiDate($rs->date_add); ?></div>
<div class='col-lg-3'>ต้นทาง : <?php echo getShopName($rs->id_shop); ?></div>
<div class='col-lg-3'>ปลายทาง : <?php echo getShopName($rs->id_target); ?></div> 
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-3'>ทะเบียนรถ : <?php echo getCarPlate($rs->id_car); ?></div> 
<div class='col-lg-3'>พนักงานขับ : <?php echo getDriverName($rs->id_driver); ?></div> 
<div class="col-lg-12">&nbsp;</div>
</div><!-- End row -->
<?php endforeach; ?>
<?php endif; ?>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />

<div class="row">
<div class="col-lg-12">
<table class="table table-striped">
<thead>
<tr><th style="width:15%;">เลขที่อ้างอิง</th><th style="width:35%">ลูกค้า</th><th style="width:10%; text-align:right">จำนวน</th><th style="width:10%; text-align:center">เงื่อนไข</th></tr>
</thead>
<?php if($order != false) : ?>
<?php foreach($order as $or) : ?>
<tr>
	<td><?php echo $or->order_no; ?></td><td><?php echo getCustomerName($or->id_customer); ?></td>
    <td align="right"><?php echo $this->delivery_model->get_delivery_qty($or->id_order, $id_delivery); ?></td>
    <td align="center"><?php echo getUrgent($or->id_urgent); ?></td>
</tr>     
<?php endforeach; ?>
<?php endif; ?>    

</table>
</div>
</div>

<script>
function cancle(id_order){
	var id_delivery = $("#id_delivery").val();
	window.location.href="<?php echo base_url(); ?>factory/delivery/delete_detail/"+id_order+"/"+id_delivery+"/add";
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
			url:"<?php echo base_url(); ?>factory/delivery/insert_detail/"+id_delivery+"/"+order_number,
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