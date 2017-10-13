<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-cloud-download'></i>&nbsp; เสร็จสิ้น</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo $this->home ?>">
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
             </a>
          <!--   <button type="button" class='btn btn-success' <?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button> -->
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<?php if(isset($order) && $order != false) : ?>
<div class="row">
<div class="col-lg-12">
<table width="100%" border="0px">
<?php foreach($order as $ro) : ?>
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
<?php endif; ?>

<div class="row">
<div class="col-lg-12">

<?php if(isset($detail) && $detail != false) : ?>
    <?php echo form_open($this->home."/add_to_finished"); ?>
    <input type="hidden" name="id_order" id="id_order" value="<?php echo $id_order; ?>"  />
    	<table class="table table-striped">
        <thead>
        	<tr>
            <th style="width:5%; text-align:center">ลำดับ</th><th style="width:50%;">รายการ</th><th style="width:15%; text-align:right">จำนวน</th>
            <th style="width:5%; text-align:center">เสร็จ</th><th style="width:15%; text-align:right">การกระทำ</th>
            </tr>
        </thead>
<?php $n = 1; ?>        
<?php foreach($detail as $rs ) : ?>
<?php 	$id_order_detail = $rs->id_order_detail; ?>
	<tr>
    <input type="hidden" id="id_delivery_<?php echo $id_order_detail; ?>" value="<?php echo $rs->id_delivery; ?>"  />
    <td align="center"><?php echo $n; ?></td>
    <td><?php echo $rs->product_name; ?></td>
    <td align="right"><?php echo number($rs->qty); ?></td>
    <td align="right"><input type="text" name="txt_<?php echo $rs->id_order_detail; ?>" id="txt_<?php echo $rs->id_order_detail; ?>" value="<?php echo $rs->qty; ?>" class="form-control" /></td>
    <td align="right"><button type="button" id="btn_<?php echo $rs->id_order_detail; ?>" onclick="add_to_finished(<?php echo $rs->id_order_detail; ?>);" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp; อัพเดต</button></td>
    </tr>
<?php $n++; ?>    
<?php endforeach; ?>  
</table>
<?php endif; ?>
<?php echo form_close(); ?>
</div>
</div>

<script>

	function add_to_finished(id){
		var qty = $("#txt_"+id).val();
		var id_delivery = $("#id_delivery_"+id).val();
		$.ajax({
			url:"<?php echo $this->home."/add_to_finished/"; ?>"+id+"/"+id_delivery+"/"+qty,
			cache:false, type:"POST",
			success: function(success){
				if(success ==1){
					$("#txt_"+id).attr("disabled", "disabled");
					$("#btn_"+id).attr("disabled","disabled");
				}else{
					alert("รับเข้าไม่สำเร็จ");
				}
			}
		});
	}
</script>
<?php endif; ?>
</div>