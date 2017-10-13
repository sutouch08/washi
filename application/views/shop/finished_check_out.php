<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-truck'></i>&nbsp; Check out</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/finished">
        		<button class='btn btn-warning'><i class='fa fa-reply'></i>&nbsp; กลับ</button>
             </a>
            <!--  <button type="button" class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button> -->
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<?php if(isset($order) && $order != false) : ?>
<div class="row">
<div class="col-lg-12">
<table width="100%" border="0px">
<?php foreach($order as $ro) : ?>
<?php $valid = $ro->valid; ?>
<tr>
<td style="width:10%;" align="right">ชื่อลูกค้า</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerName($ro->id_customer); ?></strong></td>
<td style="width:10%;" align="right">เลขที่อ้างอิง</td><td style="width:15%; padding-left:10px;"><strong><?php echo $ro->order_no; ?></strong></td>
<td style="width:10%;" align="right">&nbsp;</td><td style="width:15%; padding-left:10px;">&nbsp;</td>
</tr>
<tr>
<td style="width:10%;" align="right">ที่อยู่</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerAddress($ro->id_customer); ?></strong></td>
<td style="width:10%;" align="right">การจัดส่ง</td><td style="width:15%; padding-left:10px;"><strong><?php echo getShipping($ro->id_shipping); ?></strong></td>
<td style="width:10%;" align="right">เงื่อนไข</td><td style="width:15%; padding-left:10px;"><strong><?php echo getUrgent($ro->id_urgent); ?></strong></td>
</tr>
<tr >
<td style="width:10%;" align="right">เบอร์โทร</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerPhone($ro->id_customer); ?></strong></td>
<td style="width:10%;" align="right">จำนวน</td><td style="width:15%; padding-left:10px;"><strong><?php echo number(orderQty($ro->id_order)); ?> ชิ้น</strong></td>
<td style="width:10%;" align="right">ยอดเงิน</td><td style="width:15%; padding-left:10px;"><strong><?php echo number(orderAmount($ro->id_order)); ?> บาท</strong></td>
</tr>
<tr>
<td style="width:10%;" align="right">อีเมล์</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerAddress($ro->id_customer); ?></strong></td>
<td style="width:10%;" align="right">วันที่รับ</td><td style="width:15%; padding-left:10px;"><strong><?php echo thaiShortDate($ro->order_date); ?></strong></td>
<td style="width:10%;" align="right">กำหนดส่ง</td><td style="width:15%; padding-left:10px;"><strong><?php echo thaiShortDate($ro->due_date); ?></strong></td>
</tr>
<?php endforeach; ?>
</table>
</div>
</div>
<hr style='border-color:#CCC; margin-top: 15px; margin-bottom:0px;' />
<?php if($valid == 1) : ?>
<h4 style="text-align:center; color:#8CC152;"><i class="fa fa-check-square"></i>&nbsp; ชำระเงินครบแล้ว</h4>
<?php else : ?>
<h4 style="text-align:center; color: #DA4453;"><i class="fa fa-exclamation-triangle"></i>&nbsp; มียอดค้างชำระ</h4>
<?php endif; ?>
<hr style='border-color:#CCC; margin-top: 15px; margin-bottom:0px;' />

<?php endif; ?>

<div class="row">
<div class="col-lg-12">

<?php if(isset($detail) && $detail != false) : ?>
<table class="table table-striped">
<thead>
<tr>
 <th style="width:5%; text-align:center">ลำดับ</th><th style="width:60%;">รายการ</th><th style="width:10%; text-align:center">ส่งมา</th><th style="width:10%; text-align:center">รับคืน</th><th>&nbsp;</th> 
 </tr>
 </thead>
<?php $n = 1; ?>        
<?php foreach($detail as $rs ) : ?>
	<tr>
    <td align="center"><?php echo $n; ?></td>
    <td><label for="<?php echo $rs->id_order_detail; ?>"><?php echo $rs->product_name; ?></label></td>
    <td align="center"><?php echo number($this->finished_model->order_qty($rs->id_order_detail, $rs->id_product)); ?></td><input type="hidden" id="qty_<?php echo $rs->id_order_detail; ?>" value="<?php echo $rs->qty; ?>" />
    <td align="center"><input type="text" id="txt_<?php echo $rs->id_order_detail; ?>" class="form-control" value="<?php echo $rs->qty; ?>" /></td>
    <td align="right">
    <button type="button" id="btn_<?php echo $rs->id_order_detail; ?>" class="btn btn-success" onclick="check_out(<?php echo $rs->id_order_detail; ?>);">
    	<i class="fa fa-check"></i>&nbsp; รับคืน</button></td>
    </tr>
<?php $n++; ?>    
<?php endforeach; ?>  
</table>
<button type="button" id="btn_submit"  style="display:none;" >Submit</button>
<?php else: ?>
<tr><td colspan="5" align="center"><h4 style="text-align:center">-----------------------  ไม่มีรายการค้างรับ  -------------------------</h4></td></tr>
</table>
<?php endif; ?>
</div>
</div>

<script>
function check_out(id){
		var qty = $("#txt_"+id).val();
		var order_qty = $("#qty_"+id).val();
		if(parseInt(qty) > parseInt(order_qty)){
			alert("ยอดรับเข้ามากกว่ายอดส่งไม่ได้");
		}else{
			$.ajax({
				url:"<?php echo $this->home."/check_it_out/"; ?>"+id+"/"+qty,
				cache:false, type:"POST",
				success: function(success){
					if(success ==1){
						$("#txt_"+id).attr("disabled", "disabled");
						$("#btn_"+id).attr("disabled","disabled");
					}else{
						alert("xxx");
					}
				}
			});
		}
	}
	
	$("#btn_save").click(function(e) {
		var id_order = $("#id_order").val();
		var id_delivery = $("#id_delivery").val();
		window.location.href="<?php echo $this->home."/order_finishedd/"; ?>"+id_order+"/"+id_delivery;
    });
	
	$("#btn_ok").click(function(){
		$("#btn_ok").attr("type", "submit");
		$("#btn_ok").click();
		$("#btn_ok").attr("type", "button");
	});
</script>
<?php endif; ?>
</div>