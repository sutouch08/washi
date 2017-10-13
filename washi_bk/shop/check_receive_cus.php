     <script type="text/javascript" src="<?php echo WEB_ROOT;?>library/js/popup.js"></script>
       <script src="<?php echo WEB_ROOT;?>library/jquery-1.9.1.js"></script> 
  	<script src="<?php echo WEB_ROOT;?>library/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="<?php echo WEB_ROOT;?>dist/js/bootstrap.min.js"></script>
    <script>
function bill(){
var balance=document.checkbill.balance.value;
var money=document.checkbill.money.value;
	//alert('Y' + balance);
	if(parseInt(money)<parseInt(balance)){ 
	alert('คุณรับเงินไม่ครบ');
	return false;
	}
}
</script>
    <link rel="stylesheet" href="<?php echo WEB_ROOT;?>library/css/jquery-ui-1.10.2.custom.css" />
       <div class="container">
       <?
	$shop_id = $_COOKIE['shop_id'];
	$order_id = $_GET['order_id'];
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
	$status_amount = $rs['status_amount'];
	$note = $rs['note'];
			$remark1 = dbFetchArray(dbQuery("select config_value from tbl_config where config_name ='remark1'"));
			$remark2 = dbFetchArray(dbQuery("select config_value from tbl_config where config_name ='remark2'"));
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
    	<div class="col-md-12">
    <?  
				$date = date('Y-m-d');
				$qr_mem =dbQuery("SELECT * FROM tbl_member_detail LEFT JOIN tbl_promo ON tbl_member_detail.promo_id = tbl_promo.promo_id where detail_start <= '$date' and  detail_end >= '$date' and mem_id = '$mem_id' and credit_type = '3'");	
				$rs_mem=dbFetchArray($qr_mem);
				$promo_id = $rs_mem['promo_id'];
				$promo_discount = $rs_mem['promo_discount'];
				$credit_type = $rs_mem['credit_type'];
		
					$qr_p =dbQuery("SELECT *  FROM tbl_pament where order_id = '$order_id'");	
					$rs_p=mysql_fetch_array($qr_p);
					$payment_id = $rs_p['payment_id'];
				?>
            	<table class="table table-bordered">
                	<tr>
                    	<td colspan="5">รายการทั้งหมด</td>
                    </tr>
                    <tr>
                        <td width="5%"> ลำดับ</td><td width="55%">รายการสินค้า</td><td width="10%">ราคา</td><td width="15%">จำนวน</td><td width="15%">ยอดรวม</td>
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
                       </td><td width="15%">
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
                        <td colspan="3" style="border-bottom:none; border-top:none;"  >( <? echo bahtThai($sum_price);?> )</td><td width="15%"><?=$sum_qty;?></td><td width="15%"><?=$sum_amount;?></td>
                    </tr>
                     <tr>
                    	<td colspan="3" align="left" style="border-bottom:none; border-top:none;""><b>หมายเหตุ :&nbsp;</b><? echo $note;?></td><td width="15%">Up Charge</td><td width="15%"><?=$charge_up;?>%</td>
                     <tr>
                     	<td colspan="3" align="left" style="border-bottom:none; border-top:none;" > <? echo $remark1[0];?> </td><td width="15%">รวม</td><td width="15%"><?=$sum_price;?></td>
                    </tr>
                     <tr>
                     	<td colspan="3" rowspan="2" align="left" style="border-top:none;" ><? echo $remark2[0];?> </td>
                       	<td width="15%">ส่วนลด</td><td width="15%"><? if($promo_discount == ""){ echo "0";}else{ echo $promo_discount;}?> %</td>
                    </tr>
                    <? if($payment_id != ""){?>
                    <tr>
                       <td width="15%">ยอดคงเหลือ</td><td width="15%"><?=$sum_discount1;?></td>
                    </tr>
                    <? if($credit_type == "1"){if(isset($_GET['mem_detail_id'])){
						$sum_discount2 =($sum_discount1*$promo_discount1)/100;
						$sum_discount3 = $sum_discount1 - $sum_discount2;
						?>
                    
                   	<tr>
                    	<td colspan="3" rowspan="3" align="left" >package : <?=$promo_name;?></td>
                        <td width="15%">ส่วนลด</td><td width="15%"><? if($promo_discount1 == ""){ echo "0";}else{ echo $promo_discount1;}?> %</td>
                    </tr> 
                     <tr>
                       <td width="15%">ใช้ไป(<?=$credit_unit;?>)</td><td width="15%"><?=$sum_discount3;?></td>
                    </tr>
                    <tr>
                       <td width="15%">คงเหลือ(<?=$credit_unit;?>)</td><td width="15%"><?=$detail_credit;?></td>
                    </tr>
                    <? }}else if($credit_type == "2"){if(isset($_GET['mem_detail_id'])){?>
                    	<tr>
                        <td colspan="3" rowspan="2" align="left" >package : <?=$promo_name;?></td>
                       <td width="15%">ใช้ไป(<?=$credit_unit;?>)</td><td width="15%"><?=$sum_qty;?></td>
                    </tr> 
                    <tr>
                       <td width="15%">คงเหลือ(<?=$credit_unit;?>)</td><td width="15%"><?=$detail_credit;?></td>
                    </tr>
                    <? }}else if($status_amount == "1"){?>
                                        	<tr>
                        <td colspan="3" rowspan="2" align="left" >package : เงินสด</td>
                       <td width="15%">มัดจำ</td><td width="15%"><?=$rs_p['pament_deposit'];?></td>
                    </tr> 
                    <tr>
                       <td width="15%">ยอดคงเหลือ</td><td width="15%"><?=$sum_discount1-$rs_p['pament_deposit'];?></td>
                    </tr>
                    <? }else if($status_amount == "2"){
						if($rs_p['pament_deposit'] != "0"){?>
                         <td colspan="3" rowspan="4" align="left" >package : เงินสด</td>
                       <td width="15%">มัดจำ</td><td width="15%"><?=$rs_p['pament_deposit'];?></td>
                    </tr> 
                     <tr>
                       <td width="15%">คงเหลือ</td><td width="15%"><?=$sum_discount1-$rs_p['pament_deposit'];?></td>
                    </tr>
                    <tr>
                       <td width="15%">รับเพิ่ม</td><td width="15%"><?=$rs_p['paymet_received']-$rs_p['pament_deposit'];?></td>
                    </tr>
                    <tr>
                       <td width="15%">เงินทอน</td><td width="15%"><?=$rs_p['paymet_received']-$sum_discount1;?></td>
                    </tr>
                        <? }else{?>
                     <td colspan="3" rowspan="2" align="left" >package : เงินสด</td>
                       <td width="15%">รับเงิน</td><td width="15%"><?=$rs_p['paymet_received'];?></td>
                    </tr> 
                    <tr>
                       <td width="15%">เงินทอน</td><td width="15%"><?=$rs_p['paymet_received']-$sum_discount1;?></td>
                    </tr>
                    <? }}}else{?>
                    <tr>
                       <td width="15%"></td><td width="15%">ชำระเรียบร้อยเเล้ว</td>
                    </tr>
                    <? }?>
                </table>
				<? if($status_amount == "1"){?>
                <form method="post" name="checkbill" action="submit_receive.php?action=cus_delivery_check" onSubmit="return bill()" >
                <table width="50%" align="right">
                <tr>
                <td width="30%" align="right">ชำระ : </td>
                <td width="40%"><input type="text" name="money" placeholder="ชำระเงินสด" class="form-control" required autofocus ></td>
                <td width="3%"><input type="hidden" name="order_id" value="<?=$order_id;?>" /><input type="hidden" id="balance" value="<?=$sum_discount1-$rs_p['pament_deposit'];?>" /></td>
                <td width="27%" align="left"><input name="button" id="button"  class="btn btn-default" value="ตกลง"  type="submit"   /></td>
                </tr>
                </table>
                </form>
                <? }else if($status_amount == "2"){
					?>
                <form method="post" name="checkbill" action="submit_receive.php?action=cus_delivery" >
                <table width="50%" align="right">
                <tr>
                <td width="30%" align="right"></td>
                <td width="40%"><input type="hidden" name="order_id" value="<?=$order_id;?>" /></td>
                <td width="3%"></td>
                <td width="27%" align="left"><input name="button" id="button"  class="btn btn-default" value="รับแล้ว" type="submit"  /></td>
                </tr>
                </table>
                </form>
                <? }?>
            </div><!----- /.col-md-12 ------>  
    </div><!-- /.container -->        
<div class="hidden-print">

</div>

</h6>>>