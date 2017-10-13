<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-money'></i>&nbsp; ชำระเงิน</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/order">
        		<button class='btn btn-warning'><i class='fa fa-reply'></i>&nbsp; กลับ</button>
             </a>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<?php if($order != false) : ?>
<?php $remark = ""; ?>
<?php foreach($order as $rx): ?>
<div class='row'>
<div class='col-xs-12'>
<table style="width:100%; border:0px;">
<?php $remark = $rx->remark; ?>
<tr>
<td style="width:10%;" align="right">ชื่อลูกค้า</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerName($rx->id_customer); ?></strong></td>
<td style="width:10%;" align="right">เลขที่อ้างอิง</td><td style="width:15%; padding-left:10px;"><strong><?php echo $rx->order_no; ?></strong></td>
<td style="width:10%;" align="right">&nbsp;</td><td style="width:15%; padding-left:10px;">&nbsp;</td>
</tr>
<tr>
<td style="width:10%;" align="right">ที่อยู่</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerAddress($rx->id_customer); ?></strong></td>
<td style="width:10%;" align="right">การจัดส่ง</td><td style="width:15%; padding-left:10px;"><strong><?php echo getShipping($rx->id_order); ?></strong></td>
<td style="width:10%;" align="right">เงื่อนไข</td><td style="width:15%; padding-left:10px;"><strong><?php echo getUrgent($rx->id_order); ?></strong></td>
</tr>
<tr >
<td style="width:10%;" align="right">เบอร์โทร</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerPhone($rx->id_customer); ?></strong></td>
<td style="width:10%;" align="right">จำนวน</td><td style="width:15%; padding-left:10px;"><strong><?php echo number($this->order_model->order_qty($rx->id_order)); ?> ชิ้น</strong></td>
<td style="width:10%;" align="right">ยอดเงิน</td><td style="width:15%; padding-left:10px;"><strong><?php echo number($this->order_model->total_amount($rx->id_order)); ?> บาท</strong></td>
</tr>
<tr>
<td style="width:10%;" align="right">อีเมล์</td><td style="width:40%; padding-left:10px;"><strong><?php echo getCustomerAddress($rx->id_customer); ?></strong></td>
<td style="width:10%;" align="right">วันที่รับ</td><td style="width:15%; padding-left:10px;"><strong><?php echo thaiShortDate($rx->order_date); ?></strong></td>
<td style="width:10%;" align="right">กำหนดส่ง</td><td style="width:15%; padding-left:10px;"><strong><?php echo thaiShortDate($rx->due_date); ?></strong></td>
</tr>
<?php endforeach; ?>
<?php else : ?>
  <tr><td colspan="9" align="center" ><h4>---------- ไม่พบรายการ -----------</h4></td></tr>
<?php endif; ?>
</table>
</div>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
	<div class='col-lg-8'>
    <table class='table table-striped'>
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%; text-align:center'>ลำดับ</th>
            <th style='width:35%;'>รายการ</th>
            <th style='width:15%; text-align:right'>ราคา</th>
            <th style='width:15%; text-align:right'>จำนวน</th>
            <th style='width:15%; text-align:right'>ชาร์จ</th>
            <th style='width:15%; text-align:right'>ยอดเงิน</th>
         </tr>
      </thead>
      <tbody>
<?php if($items != false) : ?>
<?php $n = 1; $total_qty = 0; $total_charge = 0; $total_amount = 0;?>
<?php foreach($items as $rs): ?>
  <tr style="font-size:12px;">
     <td align="center"><?php echo $n; ?></td>
     <td><?php echo $rs->product_name; ?></td>	    
     <td align="right"><?php echo number($rs->price,2); ?></td>
     <td align="right"><?php echo number($rs->qty); ?></td>
     <td align="right"><?php echo number($rs->charge_up,2); ?></td>
     <td align="right"><?php echo number($rs->total_amount,2); ?></td>                  
   </tr>
<?php $n++; $total_qty += $rs->qty; $total_charge += $rs->charge_up; $total_amount += $rs->total_amount; ?>
<?php endforeach; ?>
<tr> 
     <td colspan="3" align="right">รวม</td>	    
     <td align="right"><?php echo number($total_qty,2); ?></td>
     <td align="right"><?php echo number($total_charge,2); ?></td>
     <td align="right"><?php echo number($total_amount,2); ?></td>                  
   </tr>
<?php else : ?>
  <tr><td colspan="5" align="center" ><h4>---------- ไม่พบรายการใดๆ -----------</h4></td></tr>
<?php endif; ?>
</table>
</div><!-- End col-lg-12 -->
<div class="col-lg-4" style="border:solid 2px #ccc; padding-bottom:25px;">
<?php echo form_open(base_url()."shop/order/submit_payment"); ?>
<input type="hidden" name="id_order" value="<?php echo $id_order; ?>" />
<input type="hidden" name="id_customer" value="<?php echo $id_customer; ?>"  />
<div class="col-lg-12"><h4>ยอดที่ต้องชำระ</h4></div>
<div class="col-lg-12"><h3 id="label" style="color:red; margin-top:10px;"><?php echo number($total_amount,2); ?></h3></div>
<div class="col-lg-12" style="margin-bottom:10px;"><input type="radio" name="payment" id="cash" value="cash" checked /><label for="cash" style="padding-left:10px;">ชำระด้วยเงินสด</label></div>
<div class="col-lg-12" style="margin-bottom:10px;">
<div class="input-group"><span class="input-group-addon">รับเงิน </span>
<input type="text" name="cash_receive" id="cash_receive" class="form-control" placeholder="รับเงิน" autofocus />
</div>
</div>
<div class="col-lg-12">
<div class="input-group"><span class="input-group-addon">มัดจำ</span>
<input type="text" name="deposit" id="deposit" class="form-control" placeholder="มัดจำ" />
</div>
</div>

<div class="col-lg-12"><hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' /></div>
<input type="hidden" name="total_amount" id="total_amount" value="<?php echo $total_amount; ?>" />
<input type="hidden" name="amount" id="amount" value="<?php echo $total_amount; ?>" />
<input type="hidden" name="total_qty" id="total_qty" value="<?php echo $total_qty; ?>" />
<input type="hidden" name="qty" id="qty" value="<?php echo $total_qty; ?>" />
<input type="hidden" name="package" id="package" value="0" />
<input type="hidden" name="id_promotion" id="id_promotion" value="0"  />
<input type="hidden" name="credit" id="credit" value="0" />
<input type="text" style="display:none" />
<?php if($package != false) : ?>
<?php foreach($package as $ro) : ?>
<div class="col-lg-12" style="margin-bottom:10px;">
<input type="hidden" name="credit<?php echo $ro->id_promotion; ?>" id="credit<?php echo $ro->id_promotion; ?>" value="<?php echo $ro->credit; ?>" />
<input type="hidden" name="id_promotion<?php echo $ro->id_promotion; ?>" id="id_promotion<?php echo $ro->id_promotion; ?>" value="<?php echo $ro->id_promotion; ?>"  />
<input type="radio" name="payment" id="package<?php echo $ro->id_promotion; ?>" value="<?php echo $ro->id_credit_type; ?>" />
<label for="package<?php echo $ro->id_promotion; ?>" style="padding-left:10px;"><?php echo $ro->promotion_name; ?> : คงเหลือ <?php echo $ro->credit." ".getUnit($ro->id_credit_type); ?></label>
<script>
$("#package<?php echo $ro->id_promotion; ?>").change(function(){
	var type = <?php echo $ro->id_credit_type; ?>;
	if(type ==1){ /*  กรณี ใช้แพ็คเกจเป็นจำนวนชิ้น */
		var amount = $("#total_amount").val();
		var qty = $("#total_qty").val();
		var credit = $("#credit<?php echo $ro->id_promotion; ?>").val();
		var balance = credit - qty; /*** เอาแพ็คเกจคงเหลือที่มี ลบด้วยยอดที่สั่ง ***/
		if(balance >=0){ /* ถ้ายอดคงเหลือน้อยกว่า 0 แสดงว่าแพ็คเกจคงเหลือไม่พอใช้กับออเดอร์นี้ **/
			$("#label").html("0");
			$("#qty").val(0);
			$("#credit").val(credit);
		}else{
			$("#label").html(amount);
			$("#qty").val(qty);
			$("#credit").val(0);
			alert("แพ็คเกจคงเหลือไม่เพียงพอ");
		}	
		$("#cash_receive").val("");
		$("#change").html("");
		$("#package").val(1);
		$("#id_promotion").val(<?php echo $ro->id_promotion; ?>);
		$("#amount").val(amount);
		$("#deposit").val("");
	}else if(type ==2){
		$("#package").val(2);
		$("#cash_receive").val("");
		$("#deposit").val("");
		var amount = $("#total_amount").val();
		var credit = $("#credit<?php echo $ro->id_promotion; ?>").val();
		$("#id_promotion").val(<?php echo $ro->id_promotion; ?>);
		var balance = credit - amount;
		if(balance >=0){
			$("#label").html("0");
			$("#amount").val(0);
			$("#credit").val(credit);
		}else{
			var show = balance*-1;
			$("#label").html(show);
			$("#amount").val(show);
			$("#credit").val(credit);
		}
		$("#change").html("");	
	}
});
</script>
</div>
<?php endforeach; ?>
<?php else : ?>
<div class="col-lg-12">ไม่มีแพ็คเกจคงเหลือ</div>
<?php endif; ?>
<div class="col-lg-12"><hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' /></div>
<div class="col-lg-12"><h4>เงินทอน</h4></div>
<div class="col-lg-8"><h3 id="change" style="margin-top:10px;"></h3></div><div class="col-lg-4"><button type="button" id="btn_pay" class="btn btn-primary btn-lg" >ชำระเงิน</button></div>
<button type="button" id="btn_submit" style="display:none">submit</button>
<?php echo form_close(); ?>
</div>
</div><!-- End row -->
<?php endif; ?>
</div>
<script>
$("#cash").change(function(){
	var amount = $("#total_amount").val();
	$("#cash_receive").focus();
	$("#package").val(0);
	$("#id_promotion").val(0);
	$("#amount").val(amount);
	$("#label").html(amount);
});
$("#cash_receive").keyup(function(e) {
		var deposit = $("#deposit").val();
		var amount = $("#amount").val();
		var get = $(this).val();
		var change = (get - amount) - deposit;
		if(change >0){
			$("#change").html(change);
		}else{
			$("#change").html("");
		}
});

$("#deposit").keyup(function(e) {
	var get = $(this).val(); 
	if(get !=""){
		
    	var receive = $("#cash_receive").val(); 
		var amount = $("#amount");
		var package = $("#package").val();
		if(package == 0){ /***  ชำระด้วยเงินสด **/
			if(parseInt(get) >0){
				if((receive - get) >0){
					var change = (receive - get);
				}else{
					var change = "";
				}
			}else{
				var change = "";
			}
		}else if(package == 1){ /*** ใช้แพ็คเกจแบบชิ้น ***/
			var change = "";
		}else if(package ==2){  /** ใช้แพ็คเกจแบบเงิน **/
			if(parseInt(get) >0){
				if((receive - get) >0){
					var change = (receive - get);
				}else{
					var change = "";
				}
			}else{
				var change = "";
			}
		}
		$("#change").html(change);
		}else{
			$("#change").html("");
		}
});


function submit_payment(){
	$("#btn_submit").attr("type","submit");
	$("#btn_submit").click();
	$("#btn_submit").attr("type","button");
}

$("#btn_pay").click(function(){
	var package = $("#package").val();
	var total_qty = parseInt($("#total_qty").val());
	var deposit = parseInt($("#deposit").val());
	var dep = $("#deposit").val();
	var qty = parseInt($("#qty").val());
	var total_amount = $("#total_amount").val();
	var amount = parseInt($("#amount").val());
	var receive = parseInt($("#cash_receive").val());
	var rece = $("#cash_receive").val();
	if(package ==2){
		if((amount - rece) >0){ /* ถ้ายอดคงเหลือ - ยอดเงินที่จ่ายเพิ่มมากกว่า 0 */
			if(dep !=""){ /* ถ้ามัดจำถูกเลือก */
				if(receive < deposit){
					alert("รับเงินมาไม่ครบ"); 
				}else if(deposit ==0){
						alert("จ่ายไม่ครบ มัดจำไม่มี จะจ่ายทำไม ต้องมัดจำอย่างน้อย 1 บาท");
				}else{
				submit_payment();
				}
			}else{
				alert("รับเงินมาไม่ครบ"); 
			}
		}else{
			submit_payment();
		}
	}else if(package ==1){
		if(qty >0){
			alert("แพ็คเกจคงเหลือไม่เพียงพอ กรุณาเลือกการชำระแบบอื่น");
		}else{
			submit_payment();
		}
	}else if(package == 0){
		if(rece == ""){
			alert("คุณยังไม่ได้รับเงินจากลูกค้า");
		}else{
			if(receive < amount){
				if(dep !=""){ /* ถ้ามัดจำถูกเลือก */
						if(receive < deposit){
							alert("รับเงินมาไม่ครบ"); 
						}else if(deposit ==0 && receive>0){
							alert("เงินมัดจำเป็น 0 กรุณาตรวจสอบ : กรณียอดรับเงินมากกว่า 0 ต้องระบุเงินมัดจำมากกว่า 0");
						}else{
							submit_payment();
						}
					}else{
						alert("รับเงินมาไม่ครบ"); 
					}
			}else{
				submit_payment();
			}
		}
	}
});

$("#cash_receive").bind("enterKey",function(){
		if($(this).val() != ""){
			$("#deposit").focus();
		}
	});
	$("#cash_receive").keyup(function(e){
		if(e.keyCode == 13)
		{
			$(this).trigger("enterKey");
		}
	});
	
	$("#deposit").bind("enterKey",function(){
			$("#btn_pay").focus();
	});
	
	$("#deposit").keyup(function(e){
		if(e.keyCode == 13)
		{
			$(this).trigger("enterKey");
		}
	});
</script>