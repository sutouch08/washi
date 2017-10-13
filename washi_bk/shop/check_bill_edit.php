     <script type="text/javascript" src="<?php echo WEB_ROOT;?>library/js/popup.js"></script>
       <script src="<?php echo WEB_ROOT;?>library/jquery-1.9.1.js"></script> 
  	<script src="<?php echo WEB_ROOT;?>library/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="<?php echo WEB_ROOT;?>dist/js/bootstrap.min.js"></script>
<script>
function check(i){
var sum_discount1=document.getElementById("sum_discount1");
var detail_credit=document.getElementById("detail_credit"+i);
var sum_qty=document.getElementById("sum_qty");
var credit_type_mem=document.getElementById("credit_type_mem"+i);

if(credit_type_mem.value == "1"){
	if(parseInt(detail_credit.value)<parseInt(sum_discount1.value)){
	alert('จำนวนเงินคงเหลือ' + detail_credit.value +' บาท ไม่พอสำหรับชำระครั้งนี้'); // แจ้งเตือน
	return false;
	}
	
}else if(credit_type_mem.value == "2"){
	if(parseInt(detail_credit.value)<parseInt(sum_qty.value)){ 
	alert('จำนวนคงเหลือ' + detail_credit.value +' ชิ้น ไม่พอสำหรับชำระครั้งนี้');
	return false;
	}	
	}
}
</script>
<script>
function bill(){
var sum_discount1=document.getElementById("sum_discount1");
var money=document.checkbill.money.value;
	//alert('Y' + money);
	if(parseInt(money)<parseInt(sum_discount1.value)){ 
	alert('คุณรับเงินไม่ครบ');
	return false;
	}
}
</script>
    <link rel="stylesheet" href="<?php echo WEB_ROOT;?>library/css/jquery-ui-1.10.2.custom.css" />
    
       <div class="container">
       <?
	   $order_id = $_GET['order_id'];
	   $shop_id = $_COOKIE['shop_id'];
    $qr =dbQuery("SELECT * FROM tbl_order where order_id = '$order_id'");	
	$rs=dbFetchArray($qr);
	$order_no = $rs['order_no'];
	$customer_id = $rs['customer_id'];
	$shipping_id = $rs['shipping_id'];
	$user_id = $rs['user_id'];
	$urgent_id = $rs['urgent_id'];
	$order_date_time = $rs['order_date_time'];
	$order_due = $rs['order_due'];
	$tracking_no = $rs['tracking_no'];
	$order_qty = $rs['order_qty'];
	$order_amount = $rs['order_amount'];
	$qr_u =dbQuery("SELECT * FROM tbl_urgent where urgent_id = '$urgent_id'");
			$rs_u=dbFetchArray($qr_u);	
			$charge_up = $rs_u['charge_up'];
		$qr_shop =dbQuery("SELECT * FROM tbl_user LEFT JOIN tbl_shop ON tbl_user.shop_id = tbl_shop.shop_id where user_id = '$user_id'");
			$rs_shop=dbFetchArray($qr_shop);	
			$shop_name = $rs_shop['shop_name'];	
	   ?><h6>
    	<table style="width:100%; margin-top:0px; border:none;">
        	<tr><!-------------  Start Row 1 ------------->
            	<!-- Start Colum 1 width = 50%  -->
            	<td width="12%" align="right">SHOP NAME:</td>
                <td width="23%" align="left"> <?=$shop_name;?>
                
    </td><!--- ค้นหาข้อมูลเมือมีการพิมพ์ข้อความ --->
                <td width="5%" align="center"></td>
                <td width="10%" align="left"></td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Order No: 
                 
                 
                </td>
                <td width="15%"><?=$order_no;?></td>
                <td width="10%">Tracking No:</td>
                <td width="15%"><?=$tracking_no;?></td>
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 1 ------------->
            <tr><!-------------  Start Row 2 ------------->
            	<!-- Start Colum 1 width = 50%  -->
                <?
                $qr_c =dbQuery("SELECT * FROM tbl_customer where customer_id = '$customer_id'");	
				$rs_c=dbFetchArray($qr_c);
				$customer_name = $rs_c['customer_name'];
				$customer_address = $rs_c['customer_address'];
				$customer_phone = $rs_c['customer_phone'];
				$customer_email = $rs_c['customer_email'];
				$mem_id = $rs_c['mem_id'];
				
				?>
                <td width="10%" align="right">Cus Name:</td>
                <td colspan="3" align="left" style="padding-left:5px;"><?=$customer_name;?></td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Shipping:</td>
                <td width="15%" >  
                 <?
                $qr_s =dbQuery("SELECT * FROM tbl_shipping where shipping_id = '$shipping_id'");	
				$rs_s=dbFetchArray($qr_s);
				$shipping_name = $rs_s['shipping_name'];
				echo $shipping_name;
				?>
                 </td>
				<td width="5%"  align="right">Urgent :&nbsp;</td>
                <td width="20%" >
                <?
                $qr_u =dbQuery("SELECT * FROM tbl_urgent where urgent_id = '$urgent_id'");	
				$rs_u=dbFetchArray($qr_u);
				$urgent_name = $rs_u['urgent_name'];
				$urgent_date = $rs_u['urgent_date'];
				echo $urgent_name;
				?>
			</td>
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 2 ------------->
            <tr><!--------------  Start Row 3 ------------>
            	<!-- Start Colum 1 width = 50%  -->
                <td width="10%" align="right" valign="top">Address:</td>
                <td colspan="3" align="left" style="padding-left:5px;">  <?=$customer_address;?></td>
                <!--  End Colum 1 width = 50%  -->	
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Qty : </td>
                <td width="15%"><?=$order_qty;?>&nbsp;Items.
                </td><!---Echo จำนวนรวม ต่อท้ายด้วยคำว่า Item-->
                <td width="10%" align="right">Amount :</td>
                <td width="15%"><?=$order_amount;?>&nbsp;THB.</td><!---Echo ราคารวม ต่อท้ายด้วยคำว่า THB-->
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 3 ------------->
            <tr><!-------------  Start Row 4 ------------->
            	<!-- Start Colum 1 width = 50%  -->
            	<td colspan="4" width="50%" >
                	<div class="row">
                    		<div class="col-sm-6">Phone No: <?=$customer_phone;?></div>
                    		<div class="col-sm-6">Email: <?=$customer_email;?></div>
                     </div>
                	
                 </td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right"></td>
                <td><b>
				
                </b></td><!--- echo กำหนดรับของ วัน/เดือน/ปี  --->
                <td align="right">กำหนดรับ : </td>
			<td><?=$order_due;?></td>
               
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 4 ------------->            
        </table>	
        <hr/><!--------------------------------------------------------------- เส้นขั้น ----------------------------------------------------->
                  
    </div><!-- /.container -->
    <div class="container">
    	<div class="col-md-6">
        
    			<?  
				$date = date('Y-m-d');
				$qr_mem =dbQuery("SELECT * FROM tbl_member_detail LEFT JOIN tbl_promo ON tbl_member_detail.promo_id = tbl_promo.promo_id where detail_start <= '$date' and  detail_end >= '$date' and mem_id = '$mem_id' and credit_type = '3'");	
				$rs_mem=dbFetchArray($qr_mem);
				$promo_id = $rs_mem['promo_id'];
				$promo_discount = $rs_mem['promo_discount'];
				$credit_type = $rs_mem['credit_type'];
				?>
            	<table class="table table-bordered">
                <tr>
                <td>
                <table width="100%">
                	<tr>
                    	<td colspan="5">รายการทั้งหมด</td>
                    </tr>
                    <tr>
                        <td width="5%"> ลำดับ</td><td width="55%">รายการสินค้า</td><td width="10%">ราคา</td><td width="15%">จำนวน</td><td width="15%" align="right">ยอดรวม</td>
                    </tr>
                    <?php  
							
							$qr_d =dbQuery("SELECT SUM(qty),product_id,detail_price  FROM tbl_order_detail where order_id = '$order_id' GROUP BY  product_id ORDER BY product_id ASC");	
							$row =@mysql_num_rows($qr_d);
							 $i=0;
							while ($i<$row){
							$rs_d=mysql_fetch_array($qr_d);
							$product_id = $rs_d['product_id'];
							$qty = $rs_d['SUM(qty)'];
							$detail_price = $rs_d['detail_price'];
							$qr_u =dbQuery("SELECT * FROM tbl_product where product_id = '$product_id'");	
							$rs_u=dbFetchArray($qr_u);
							$product_name = $rs_u['product_name'];
							$sumprice = $qty * $detail_price;
							@$sum_qty = $sum_qty + $qty;
							@$sum_amount = $sum_amount + $sumprice;
				?>                       
                     <tr>
                        <td width="5%"><? echo $i+1;?></td><td width="55%" align="left"><? echo $product_name;?></td>
                        <td width="10%"><? echo $detail_price;?></td><td width="15%"><? echo $qty;?>
                       </td><td width="15%" align="right">
                       <? echo $sumprice;?>
                       </td>
                    </tr>
                  <?
					$i++;
							}
							$sum_price = (1+($charge_up/100))*$sum_amount;
							$sum_discount = ($sum_price*$promo_discount)/100; 
							$sum_discount1 = $sum_price - $sum_discount; 
					?>
                     <tr>
                        <td colspan="3" rowspan="7">( <? echo bahtThai($sum_discount1);?> )</td><td width="15%" ><?=$sum_qty;?></td><td width="15%" align="right"><?=$sum_amount;?></td>
                    </tr>
                     <tr>
                       <td width="15%">Up Charge</td><td width="15%" align="right"><?=$charge_up;?>%</td>
                    </tr>
                     <tr>
                       <td width="15%">ยอดรวม</td><td width="15%" align="right"><?=$sum_price;?></td>
                    </tr>
                    <tr>
                       <td width="15%">ส่วนลด</td><td width="15%" align="right"><? if($promo_discount == ""){ echo "0";}else{ echo $promo_discount;}?>%</td>
                    </tr>
                     <tr>
                       <td width="15%">ยอดคงเหลือ</td><td width="15%" align="right"><? echo $sum_discount1;?></td>
                    </tr>
                    <?	$qr_d =dbQuery("SELECT * FROM tbl_pament where order_id = '$order_id'");	
						$row2 =@mysql_num_rows($qr_d);
						if($row2 > "0"){
							$rs_p=dbFetchArray($qr_d);
							$payment_change = $rs_p['payment_change'];
							$paymet_received = $rs_p['paymet_received'];
							$paid = $paymet_received - $payment_change; 
							$balance = $sum_discount1 - $paid;
							$balance1 = $balance*(-1);
					echo "<tr>
                    <td>ชำระแล้ว</td><td align='right'>$paid</td>
                    </tr>";
						if($balance > "0"){
							echo "<tr>
                    <td>ชำระเพิ่ม</td><td align='right'>$balance</td>
                    </tr>";	
						}else{
							echo "<tr>
                    <td>คืนเงิน</td><td align='right'> $balance1</td>
                    </tr>";	
						}
						}else{
							$qr_d =dbQuery("SELECT * FROM tbl_promo_log where order_id = '$order_id'");	
							$rs_p=dbFetchArray($qr_d);
							$promo_id =$rs_p['promo_id'];
							$amount = $rs_p['amount'];
							$qty1 = $rs_p['qty'];
							if($qty1 == "0"){
								$credit_type1 = "1";
								$balance = $sum_discount1 - $amount;
								$balance1 = $balance*(-1);
								echo "<tr>
                    <td>ชำระแล้ว</td><td align='right'>$amount</td>
                    </tr>";
						if($balance > "0"){
							echo "<tr>
                    <td>ชำระเพิ่ม</td><td align='right'>$balance</td>
                    </tr>";	
						}else{
							echo "<tr>
                    <td>คืนเงิน</td><td align='right'> $balance1</td>
                    </tr>";	
						}
							}else{
								$credit_type1 = "2";
								$balance = $sum_qty - $qty1;
								$balance1 = $balance*(-1);
								echo "<tr>
                    <td>ชำระแล้ว</td><td align='right'>$qty1 ชิ้น</td>
                    </tr>";
						if($balance > "0"){
							echo "<tr>
                    <td>ชำระเพิ่ม</td><td align='right'>$balance ชิ้น</td>
                    </tr>";	
						}else{
							echo "<tr>
                    <td>คืน</td><td align='right'> $balance1 ชิ้น</td>
                    </tr>";	
						}
							}
						}
					?>
                    <input type="hidden" id="sum_discount1" value="<?=$balance;?>" /><input type="hidden" id="sum_qty" value="<?=$sum_qty;?>"  />
                </table>
                </td>
                </tr>
                </table>
            </div><!----- /.col-md-6 ------>  
<div class="col-md-6">
<table class="table table-bordered">
<tr>
<td width="100%">
<table width="100%">
<?php if($row2 > "0"){
	if($balance > "0"){?>
<tr>
<td width="70%">
<form method="post" name="checkbill" action="submit_checkbill_edit.php"  onSubmit="return bill()" ><div class="col-md-7"><input type="text" name="money" id="money" class="form-control"  placeholder="ชำระเงินสด" required autofocus ><input type="hidden" name="order_id" value="<?=$order_id;?>"  ></div><div class="col-md-2"></div><div class="col-md-3"> <input type="submit" value="ชำระเงินสด" class="form-control" ></div></form></td> 
</tr>
 							<?php 
	}else{
	?>
    <form method="post" name="checkbill" action="submit_checkbill_edit.php"  onSubmit="return bill()" ><div class="col-md-7"><input type="hidden" name="money" id="money" class="form-control" value="<?=$balance;?>" ><input type="hidden" name="order_id" value="<?=$order_id;?>"  ></div><div class="col-md-2"></div><div class="col-md-3"> <input type="submit" value="คือเงิน" class="form-control" ></div></form>
    <?	
	}
}else{	

	
							$qr_m =dbQuery("SELECT * FROM tbl_member_detail LEFT JOIN tbl_member ON tbl_member_detail.mem_id = tbl_member.mem_id LEFT JOIN tbl_promo ON tbl_member_detail.promo_id = tbl_promo.promo_id LEFT JOIN tbl_credit_type ON tbl_member_detail.credit_type = tbl_credit_type.credit_type where tbl_member_detail.mem_id = '$mem_id' and tbl_member_detail.credit_type = '$credit_type1' and ((detail_start <= '$date' and detail_end >= '$date') or detail_start = '0000-00-00') ORDER BY tbl_promo.promo_id ASC");	
							$row =@mysql_num_rows($qr_m);
							 $i=0;
							while ($i<$row){
							$rs_m=mysql_fetch_array($qr_m);
							$mem_detail_id = $rs_m['mem_detail_id'];
							$credit_type_mem = $rs_m['credit_type'];							
							?>
<tr height="50">
<td width="70%"><? if($credit_type_mem == "$credit_type"){?><div class="col-md-8"><input type="button" class="form-control" value="<?=$rs_m['promo_name'];?>" disabled="disabled" ></div>
<? }else{?><a href="submit_checkbill_edit.php?mem_detail_id=<?=$mem_detail_id;?>&order_id=<?=$order_id;?>&mem_id=<?=$mem_id;?>" onclick="return check('<?=$mem_detail_id;?>')" ><div class="col-md-8"><input type="button" class="form-control"  value="<?=$rs_m['promo_name'];?>"></div></a>
<? }?>
<div class="col-md-4" align="left">คงเหลือ <?=$rs_m['detail_credit'];?> <?=$rs_m['credit_unit'];?><input type="hidden" id="detail_credit<?=$mem_detail_id;?>" value="<?=$rs_m['detail_credit'];?>" /><input type="hidden" id="credit_type_mem<?=$mem_detail_id;?>" value="<?=$credit_type_mem;?>" /></div></td>
</tr>
<? $i++;
	}
}

	?>
</table>
</td>
</tr>
</table>

</div>
    </div><!-- /.container -->        


</h6>