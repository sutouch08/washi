<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-cloud-download'></i>&nbsp; รับสินค้าเข้า</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <?php if( isset($detail) ) : ?>
        	<a href="<?php echo base_url(); ?>factory/receive/add/<?php echo $id_delivery; ?>">
        		<button class='btn btn-warning'><i class='fa fa-arrow-left'></i>&nbsp; กลับ</button>
             </a>
         <?php else : ?>
         	<a href="<?php echo base_url(); ?>factory/receive/">
        		<button class='btn btn-warning'><i class='fa fa-arrow-left'></i>&nbsp; กลับ</button>
             </a>
         <?php endif; ?>   
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php echo form_open(base_url()."factory/receive/receive_add/".$id_delivery); ?>
<input type="hidden" name="id_shop" id="id_shop" value="<?php echo $this->session->userdata("id_shop"); ?>"  />
<div class='col-lg-4'>
	<div class="input-group">
    	<span class="input-group-addon">บาร์โค้ดออเดอร์</span>
        <input type="text" class="form-control" name="order_no" id="order_no" />
    </div>   
</div>    
<div class="col-lg-1"><button class="btn btn-default" name="btn_ok" id="btn_ok">ตกลง</button></div>
<?php echo form_close(); ?>
</div><!-- End row -->
<hr style='border-color:#CCC; margin-top: 15px; margin-bottom:15px;' />
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
<div class="row">
<div class="col-lg-12">

<?php if(isset($detail) && $detail != false) : ?>
    <?php echo form_open(base_url()."factory/receive/receive_detail", array("id"=>"form_receive_detail")); ?>
    <input type="hidden" name="id_order" id="id_order" value="<?php echo $id_order; ?>"  />
    <input type="hidden" name="id_delivery" id="id_delivery" value="<?php echo $id_delivery; ?>"  />
    	<table class="table table-striped">
        <thead>
        	<tr>
            <th style="width:5%;">ลำดับ</th><th style="width:50%;">รายการ</th><th style="width:15%; text-align:center">จำนวนส่ง</th>
            <th style="width:10%; text-align:center">จำนวนเข้า</th><th style="width:15%; text-align:right">การกระทำ</th>
            </tr>
        </thead>
<?php $n = 1 ?>        
<?php foreach($detail as $rs ) : ?>
	<tr>
    <td align="center"><?php echo $n; ?></td>
    <td><label for="<?php echo $rs->id_order_detail; ?>"><?php echo $rs->product_name; ?></label></td>
    <td align="center"><?php echo number($rs->qty); ?></td>
    <td align="center"><input type="text" id="<?php echo $rs->id_order_detail; ?>" class="form-control" value="<?php echo $rs->qty; ?>" /></td>
    <td align="right"><button type="button" id="btn_<?php echo $rs->id_order_detail; ?>" class="btn btn-success" onclick="add_to_received(<?php echo $rs->id_order_detail; ?>);" ><i class="fa fa-plus"></i>&nbsp;รับสินค้าเข้า</button></td>
    </tr>
<?php $n++; ?>    
<?php endforeach; ?>  
</table>
<button type="button" id="btn_submit"  style="display:none;" >Submit</button>
<?php else : ?>
<div class="col-lg-6 col-lg-offset-3" style="margin-top:30px;"><div class="alert alert-success"><center><h3>รับเข้าแล้ว</h3></center></div></div>
<?php endif; ?>
<?php echo form_close(); ?>
</div>
</div>
<?php else : ?>
<table class="table table-striped">
<thead>
	<th style="width:5%; text-align:center">ลำดับ</th>
    <th style="width:50%">ออเดอร์</th>
    <th style="width: 20%; text-align:center">วันที่ออเดอร์</th>
    <th>สถานะ</th>
</thead>
<tbody>
	<?php if( $data != false ) : ?>
    <?php 	$n = 1; ?>
    <?php 	foreach($data as $rs) : ?>
    <tr>
    	<td align="center"><?php echo $n; ?></td>
        <td><?php echo $rs->order_no; ?></td>
        <td align="center"><?php echo thaiDate($rs->order_date); ?></td>
        <td><?php echo getState($rs->state); ?></td>
    </tr>
    <?php		$n++; ?>
    <?php 	endforeach; ?>
    <?php else : ?>
    <tr><td colspan="5"><center><h4>---------- ไม่มีรายการ  ----------</h4></center></td></tr>
    <?php endif; ?>
</tbody>
</table>
<?php endif; ?>


<script>
	function add_to_received(id){
		load_in();
		var qty = $("#"+id).val();
		var id_delivery = $("#id_delivery").val();
		$.ajax({
			url:"<?php echo $this->home."/add_to_received/"; ?>"+id+"/"+qty+"/"+id_delivery,
			cache:false, type:"POST",
			success: function(success){
				if(success ==1){
					load_out();
					$("#"+id).addClass("input-label");
					$("#"+id).attr("disabled", "disabled");
					$("#btn_"+id).attr("disabled","disabled");
				}else{
					load_out();
					alert("รับเข้าไม่สำเร็จ");
				}
			}
		});
	}

	$("#btn_save").click(function(e) {
		load_in();
		var checked = $('input[name="id_order_detail[]"]:checked').length;
		if(checked <1){
			load_out();
			alert("ไม่มีรายการครบเลยใช่มั้ย");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		$("#btn_submit").attr("type","button");
		load_out();
		}
    });
	
	$("#btn_ok").click(function(){
		$("#btn_ok").attr("type", "submit");
		$("#btn_ok").click();
		$("#btn_ok").attr("type", "button");
	});
</script>
<?php endif; ?>
</div>