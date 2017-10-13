<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-file-o'></i>&nbsp; ออเดอร์</h3>
    </div>
<?php if($order != false) : ?>
<?php $remart = ""; ?>
<?php foreach($order as $rs): ?>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/order">
        		<button class='btn btn-warning'><i class='fa fa-reply'></i>&nbsp; กลับ</button>
             </a> 
             <a href="<?php echo base_url(); ?>shop/order/print_order/<?php echo $id_order; ?>">
        		<button class='btn btn-success'><i class='fa fa-print'></i>&nbsp; พิมพ์เอกสาร</button>
             </a>
        	
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
	<div class='col-xs-12'>
<table style="width:100%; border:0px;">

<?php $remark = $rs->remark; $state = $rs->state; ?>
<tr>
<td style="width:10%;" align="right">ชื่อลูกค้า</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerName($rs->id_customer); ?></strong></td>
<td style="width:10%;" align="right">เลขที่อ้างอิง</td><td style="width:15%; padding-left:10px;"><strong><?php echo $rs->order_no; ?></strong></td>
<td style="width:10%;" align="right">&nbsp;</td><td style="width:15%; padding-left:10px;">&nbsp;</td>
</tr>
<tr>
<td style="width:10%;" align="right">ที่อยู่</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerAddress($rs->id_customer); ?></strong></td>
<td style="width:10%;" align="right">การจัดส่ง</td><td style="width:15%; padding-left:10px;"><strong><?php echo getShipping($rs->id_shipping); ?></strong></td>
<td style="width:10%;" align="right">เงื่อนไข</td><td style="width:15%; padding-left:10px;"><strong><?php echo getUrgent($rs->id_urgent); ?></strong></td>
</tr>
<tr >
<td style="width:10%;" align="right">เบอร์โทร</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerPhone($rs->id_customer); ?></strong></td>
<td style="width:10%;" align="right">จำนวน</td><td style="width:15%; padding-left:10px;"><strong><?php echo number($this->order_model->order_qty($rs->id_order)); ?> ชิ้น</strong></td>
<td style="width:10%;" align="right">ยอดเงิน</td><td style="width:15%; padding-left:10px;"><strong><?php echo number($this->order_model->total_amount($rs->id_order)); ?> บาท</strong></td>
</tr>
<tr>
<td style="width:10%;" align="right">อีเมล์</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerAddress($rs->id_customer); ?></strong></td>
<td style="width:10%;" align="right">วันที่รับ</td><td style="width:15%; padding-left:10px;"><strong><?php echo thaiShortDate($rs->order_date); ?></strong></td>
<td style="width:10%;" align="right">กำหนดส่ง</td><td style="width:15%; padding-left:10px;"><strong><?php echo thaiShortDate($rs->due_date); ?></strong></td>
</tr>
<?php endforeach; ?>
<?php else : ?>
  <tr><td colspan="9" align="center" ><h4>---------- ไม่พบรายการใดๆ -----------</h4></td></tr>
<?php endif; ?>
</table>
<hr style='border-color:#CCC; margin-top: 15px; margin-bottom:15px;' />
<?php if($state < 4) : ?>
<div class="row">
<div class="col-lg-3 col-lg-offset-8">
<div class="input-group"><span class="input-group-addon">สถานะ</span>
<select class="form-control" name="state_change" id="state_change">
	<option value="1" <?php echo isSelected(1, $state); ?>>รับออเดอร์</option>
    <option value="2" <?php echo isSelected(2, $state); ?>>รอส่งโรงงาน</option>
</select>
</div></div>
<div class="col-lg-1"><button type="button" id="btn_change" class="btn btn-default">เปลี่ยน</button></div>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />   
<?php endif; ?> 
<table class="table table-striped">
<thead>
<tr>
<th style="width: 5%; text-align:center;">ลำดับ</th><th style="width:50%; text-align:center">รายการ</th><th style="width: 10%; text-align:right">ราคา</th>
<th style="width: 10%; text-align:right">จำนวน</th><th style="width: 10%; text-align:right">มูลค่า</th><th style="width: 15%; text-align:center">สถานะ</th>
</tr>
</thead>
<?php if($data != false) : ?>
<?php $n = 1; ?>
<?php $total_qty = 0; $total_amount = 0; ?>
<?php foreach( $data as $ro) : ?>
<tr>
<td align="center"><?php echo $n; ?></td>
<td><?php echo $ro->product_name; ?></td>
<td align="right"><?php echo number($ro->price,2); ?></td>
<td align="right"><?php echo number($ro->qty); ?></td>
<?php $amount = $ro->price*$ro->qty; ?>
<td align="right"><?php echo number($amount,2); ?></td>
<td align="center"><?php echo getState($ro->state); ?></td>
</tr>
<?php $total_qty += $ro->qty; $total_amount += $amount;  $n++; ?>
<?php endforeach; ?>
<tr>
<td colspan="3" align="right" style="padding-right:15px;"><strong>รวม</strong></td>
<td align="right"><?php echo number($total_qty); ?></td>
<td align="right"><?php echo number($total_amount, 2); ?></td><td>&nbsp;</td>
</tr>
<tr>
<td colspan="3" align="right" style="padding-right:15px;"><strong>ชาร์จเพิ่ม</strong></td><?php $charge_up = chargUp($id_order); ?>
<td colspan="2" align="right"><strong><?php echo number($charge_up,2); ?></strong></td><td>&nbsp;</td>
</tr>
<tr>
<td colspan="3" align="right" style="padding-right:15px;"><strong>รวมทั้งหมด</strong></td>
<td colspan="2" align="right"><strong><?php echo number($charge_up+$total_amount,2); ?></strong></td><td>&nbsp;</td>
</tr>
<tr><td colspan="6"><strong>หมายเหตุ : <?php echo $remark; ?></strong></td></tr>
<?php endif; ?>
</table>

</div><!-- End col-lg-12 -->
</div><!-- End row -->
<?php endif; ?>
</div>
<script>
$("#btn_change").click(function(){
	var state = $("#state_change").val();
	var id_order = <?php echo $id_order; ?>;
	window.location.href="<?php echo $this->home."/state_change/"; ?>"+id_order+"/"+state;
});
</script>