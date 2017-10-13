<style type="text/css" media="print">
@page 
    {
	size:auto;  /* กำหนดขนาดของหน้าเอกสารเป็นออโต้ครับ */
        margin:0 0 0 0mm;  /* กำหนดขอบกระดาษเป็น 0 มม. */
		
    }

    body 
    {
	size:auto;
    margin:0 0 0 0px;  /* เป็นการกำหนดขอบกระดาษของเนื้อหาที่จะพิมพ์ก่อนที่จะส่งไปให้เครื่องพิมพ์ครับ */
	
    }
</style>
<body onLoad="javascript:window.print();setFocus()">
<div class="hidden-print">
<input name="button" id="button" class="btn btn-primary btn-lg btn-block" value="Print" onClick="print();" type="button"   />
</div>
       <?
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
	$qr_u =dbQuery("SELECT * FROM tbl_urgent where urgent_id = '$urgent_id'");
			$rs_u=dbFetchArray($qr_u);	
			$charge_up = $rs_u['charge_up'];
			
		$qr_shop =dbQuery("SELECT * FROM tbl_user LEFT JOIN tbl_shop ON tbl_user.shop_id = tbl_shop.shop_id where user_id = '$user_id'");
			$rs_shop=dbFetchArray($qr_shop);	
			$shop_name = $rs_shop['shop_name'];	
			
                $qr_c =dbQuery("SELECT * FROM tbl_customer where customer_id = '$customer_id'");	
				$rs_c=dbFetchArray($qr_c);
				$customer_name = $rs_c['customer_name'];
				$customer_address = $rs_c['customer_address'];
				$customer_phone = $rs_c['customer_phone'];
				$customer_email = $rs_c['customer_email'];
				
                $qr_s =dbQuery("SELECT * FROM tbl_shipping where shipping_id = '$shipping_id'");	
				$rs_s=dbFetchArray($qr_s);
				$shipping_name = $rs_s['shipping_name'];
				
                $qr_u =dbQuery("SELECT * FROM tbl_urgent where urgent_id = '$urgent_id'");	
				$rs_u=dbFetchArray($qr_u);
				$urgent_name = $rs_u['urgent_name'];
				$urgent_date = $rs_u['urgent_date'];
				?>
     <h6>   
<table width="200" border="0" align="center" cellpadding="0" cellspacing="0" >
<tr align="center">
    <td colspan="2"><? echo $shop_name;?> <hr></td>
    </tr>
   <tr>
    <td align="left">CUSNAME :</td>
    <td align="left"><? echo $customer_name;?></td>
    </tr>
   <tr>
    <td align="left">DATE :</td>
    <td align="left"><? echo date("Y-m-d H:i:s");?></td>
    </tr>
   <tr>
    <td align="left">DUEDATE :</td>
    <td align="left"><? echo $order_due;?></td>
    </tr>
   <tr>
    <td align="left">ORDER NO :</td>
    <td align="left"><? echo $order_no;?></td>
    </tr>
 
 
</table>

      
         <hr>
        <hr>
    
<table width="229" border="0" align="center" cellpadding="0" cellspacing="0">
                	
                    <tr>
                        <td width="89">รายการสินค้า</td><td width="35">ราคา</td><td width="53">จำนวน</td><td width="52">ยอดรวม</td>
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
                        <td width="89" align="left"><? echo $product_name;?></td>
                        <td width="35"><? echo $detail_price;?></td>
                        <td width="53"><? echo $qty;?></td>
                        <td width="52"><? echo $sumprice;?></td>
                    </tr>
                     <?
					$i++;
							}
							$sum_price = (1+($charge_up/100))*$sum_amount;
					?>
                     <tr>
                        <td colspan="2" rowspan="5"></td><td width="53"><?=$sum_qty;?></td><td width="52"><?=$sum_amount;?></td>
                    </tr>
                     <tr>
                        <td width="53">Charge</td><td width="52"><?=$charge_up;?>%</td>
                    </tr>
                     <tr>
                        <td width="53">ยอดรวม</td><td width="52"><?=$sum_price;?></td>
                    </tr>
                   
                </table>
                <hr>  
   <center>  THANK YOU</center>
      <hr>  
     <center> ------- Tracking no -------- </center>
    <center> <? echo $tracking_no;?></center>



</h6>
</body>