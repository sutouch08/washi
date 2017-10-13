
    <script src="<?php echo WEB_ROOT;?>library/jquery-1.9.1.js"></script> 

    <script src="<?php echo WEB_ROOT;?>library/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="<?php echo WEB_ROOT;?>dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_ROOT;?>library/css/jquery-ui-1.10.2.custom.css" />
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
	$order_code = $rs['order_code'];
	$note = $rs['note'];
	
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
<form name="autoSumForm"  method="post" action="submit_edit_order.php" onSubmit="JavaScript:return fncSubmit();" >

       <div class="container">
     


    <?php 
        //แสดงข้อมูลลูกค้า 
        $comma = ''; 
        $allEmp = ''; 
        $sql="SELECT * FROM tbl_customer where user_id = '$user_id' ORDER BY customer_name ASC"; 
        $result=mysql_query($sql) or die(mysql_error()." [$sql]"); 
        while ($row = mysql_fetch_array($result)) { 
            $allEmp .= $comma.'{customer_id: "'.$row['customer_id'].'",add: "'.$row['customer_address'].'",phone: "'.$row['customer_phone'].'",email: "'.$row['customer_email'].'",name: "'.$row['customer_name'].'",label: "'.$row['customer_name'].'"}'; 
            if($comma=='') $comma = ','; 
        } 
        //การใช้งานจริง ส่วนนี้จะถูกเขียนเป็นไฟล์ .js เพื่อเรียกใช้ใน javascript 
        $allEmp = '['. $allEmp . ']'; 
        //-- 
    ?>  
    	<table style="width:100%; margin-top:0px; border:none;">
        	<tr><!-------------  Start Row 1 ------------->
            	<!-- Start Colum 1 width = 50%  -->
            	<td width="10%" align="right">Customer ID:</td>
                <td width="25%" align="left">
            
                <input type="text" class="form-control" id="cus_id" placeholder="ค้นหาลูกค้า" value="<?=$customer_name;?>">
                <script type="text/javascript"> 
        $(function() {  

        //ถ้าใช้งานจริง ส่วนนี้จะถูกเขียนขึ้น เป็นไฟล์ .js เมื่อมีการเพิ่ม/แก้ไข ข้อมูลสมาชิก  
        var autoCompleteData = <?php echo $allEmp?>; 
        //-- 

        if(!autoCompleteData) var autoCompleteData = new Array(); 
        $( "#cus_id" ).autocomplete({ 
          minLength: 0, 
          source: autoCompleteData, 
          focus: function( event, ui ) { 
            $( "#cus_id" ).val( ui.item.label ); 
            return false; 
          }, 
          select: function( event, ui ) { 
            $( "#cus_id" ).val( ui.item.label ); 
            $( "#address" ).val( ui.item.add );
			 $( "#phone" ).val( ui.item.phone );
			  $( "#name" ).val( ui.item.name );
			  $( "#email" ).val( ui.item.email );   
			   $( "#customer_id" ).val( ui.item.customer_id );   
            return false; 
          } 
        }) 
        .data( "ui-autocomplete" )._renderItem = function( ul, item ) { 
          return $( "<li>" ) 
            .append( "<a>" + item.label + "</a>" ) 
            .appendTo( ul ); 
        }; 
        }); 
    </script> 
    </td><!--- ค้นหาข้อมูลเมือมีการพิมพ์ข้อความ --->
                <td width="5%" align="center"></td>
                <td width="10%" align="left">
             </td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Order No: 
                 
                 
                </td>
                <td width="15%"><div class="alert alert-success" ><?php echo $order_no; ?></div></td>
                <td width="10%">Tracking No:</td>
                <td width="15%"><div class="alert alert-info"><?php echo $tracking_no;?></div></td>
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 1 ------------->
            <tr><!-------------  Start Row 2 ------------->
            	<!-- Start Colum 1 width = 50%  -->
                <td width="10%" align="right">Cus Name:</td>
                <td colspan="3" align="left" style="padding-left:5px;">
                <input type="hidden" name="customer_id" id="customer_id" value="<?=$customer_id;?>" size="50"  />
                <input type="text"  name="customer_name" class="input-label"  id="name" size="50"  value="<?=$customer_name;?>" disabled="disabled"/></td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Shipping:</td>
                <td width="15%" align="left">  
                <select name="shipping_id" class="form-control" id="shipping_id" ><!-- วนลูปเอาค่ามาแสดง -->
                <option value="<?=$shipping_id;?>"><?=$shipping_name;?></option>
				<?php  
				
							$qr =dbQuery("SELECT * FROM tbl_shipping ");	
							$row =@mysql_num_rows($qr);
							 $i=0;
							while ($i<$row){
							$rs=mysql_fetch_array($qr);
							$shipping_id1 = $rs['shipping_id'];
							$shipping_name1 = $rs['shipping_name'];
				?>           								
    <option value="<? echo $shipping_id1;?>"><? echo $shipping_name1;?></option>
<?
$i++;
}

?></select>
                 </td>
				<td width="5%">Urgent:</td>
                <td width="20%" align="left">
                <select name="urgent_id" class="form-control" id="shipping_id" ><!-- วนลูปเอาค่ามาแสดง -->

               <option value="<? echo $urgent_id;?>"><? echo $urgent_name;?></option>
				<?php  
				
							$qr_urgent =dbQuery("SELECT * FROM tbl_urgent  ORDER BY urgent_name ASC");	
							$row =mysql_num_rows($qr_urgent);
							 $i=0;
							while ($i<$row){
							$rs_urgent=mysql_fetch_array($qr_urgent);
							$urgent_idd = $rs_urgent[urgent_id];
							$urgent_named = $rs_urgent[urgent_name];
				?>           								
    <option value="<? echo $urgent_idd;?>"><? echo $urgent_named;?></option>
<?
$i++;
}

?></select>
			</td>
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 2 ------------->
            <tr><!--------------  Start Row 3 ------------>
            	<!-- Start Colum 1 width = 50%  -->
                <td width="10%" align="right" valign="top">Address:</td>
                <td colspan="3" align="left" style="padding-left:5px;">   <textarea  id="address" class="input-label-textarea"   disabled="disabled"><?=$customer_address;?></textarea></td>
                <!--  End Colum 1 width = 50%  -->	
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Qty : </td>
                <td width="15%"><input type="text" name="order_qty" class="input-label" id="order_qty"  value="<?=$order_qty;?>"disabled="disabled" size="10">&nbsp;Items.
                </td><!---Echo จำนวนรวม ต่อท้ายด้วยคำว่า Item-->
                <td width="10%" align="right">Amount :</td>
                <td width="15%"><input type="text" name="order_amount"  class="input-label" id="order_amount" value="<?=$order_amount;?>"  disabled="disabled" size="10">&nbsp;THB.</td><!---Echo ราคารวม ต่อท้ายด้วยคำว่า THB-->
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 3 ------------->
            <tr><!-------------  Start Row 4 ------------->
            	<!-- Start Colum 1 width = 50%  -->
            	<td colspan="4" width="50%" >
                	<div class="row">
                    		<div class="col-sm-6">Phone No: <input type="text"  class="input-label" id="phone"  value="<?=$customer_phone;?>" disabled="disabled"></div>
                    		<div class="col-sm-6">Email: <input type="text"  class="input-label" id="email" value="<?=$customer_email;?>" size="30" disabled="disabled"></div>
                     </div>
                	
                 </td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">barcode:</td>
                <td><b><input type="text" class="form-control" name="order_code" value="<?=$order_code;?>" /></b></td><!--- echo กำหนดรับของ วัน/เดือน/ปี  --->
                <td>กำหนดรับ : </td>
					<script type="text/javascript">  
						$(function(){  
							// แทรกโค้ต jquery  
							$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });  
						});  
                    </script>  
			<td><input type="text" class="form-control" name="dateInput" id="dateInput" value="<?=$order_due;?>" /> </td>
                
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 4 ------------->  
			<tr>
			<td width="10%" align="right">หมายเหตุ : </td>
			<td colspan="3" align="left"><input type="text"name="note" cols="100%" rows="5" class="form-control" value='<?=$note;?>'></td>
			</tr>          
        </table>	
		<hr />
        
     
      
         <table width="100%"class="table table-bordered table-hover">
          <thead>
    <td colspan="6">รายการทั้งหมด</td>
  </thead>
  <thead>
    <td width="5%">#</td>
    <td width="20%">Barcode</td>
    <td width="50%">name</td>
    <td width="10%">จำนวน</td> 
    <td width="10%">ราคา</td>
	<td width="5%"> ลบ</td>
  </thead>
  
 <?
  $qr_dt =dbQuery("SELECT * FROM tbl_order_detail LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id where order_id = '$order_id'  ORDER BY detail_id ASC");	
							$row_dt =@mysql_num_rows($qr_dt);
							 $idt=0;
							while ($idt<$row_dt){
							$rs_dt=mysql_fetch_array($qr_dt);
							$detail_id = $rs_dt['detail_id'];
							$product_name_detail = $rs_dt['product_name'];
							$product_code = $rs_dt['product_code'];
							$qty_detail = $rs_dt['qty'];
							$detail_price = $rs_dt['detail_price'];
							$product_weight1 = $rs_dt['product_weight'];
							@$sum_weight = $sum_weight + $product_weight1;
							@$sumproductprice = $sumproductprice + $detail_price;
							@$loopdt = $loopdt + 1;
                           ?>
  <tr>
    <td><?=$loopdt;?></td>
    <td align="left"><?=$product_code;?></td>
    <td align="left"><?=$product_name_detail;?></td>
    <td><?=$qty_detail;?></td>
    <td><?=$detail_price;?></td>
    <td><a href="del_detail.php?order_id=<?=$order_id;?>&detail_id=<?=$detail_id;?>" onclick="return confirm('ต้องการลบ <?=$product_name_detail;?> หรือไม่');">
    <button type="button" class="btn btn-default btn-xs">Del</button></a></td>
  </tr>
   <?
					$idt++;
							}
					?>
<input type="hidden" name="sum_weight1" value="<?=$sum_weight;?>" />
<input type="hidden" name="loopdt" value="<?=$loopdt;?>" />
<input type="hidden" name="sumproductprice" value="<?=$sumproductprice;?>" />
</table>
        
        <hr/><!--------------------------------------------------------------- เส้นขั้น ----------------------------------------------------->
                  
    </div><!-- /.container -->
    <div class="container">


    <?
							$qr_c =dbQuery("SELECT * FROM tbl_process_category  ORDER BY process_category_no ASC");	
							$row_c =@mysql_num_rows($qr_c);
							 $ic=0;
							while ($ic<$row_c){
							$rs_c=mysql_fetch_array($qr_c);
							$process_category_id = $rs_c['process_category_id'];
							$process_category_name = $rs_c['process_category_name'];
						$ics = $ic+1;
						if($ics%2 == "1"){	
	
    	  					echo "<div class=row>";
						}
     ?>   	<div class="col-md-6">
    
            	<table class="table table-bordered table-hover">
                	<tr>
                    	<td colspan="5"><? echo $process_category_name;?></td>
                    </tr>
                    <tr>
                        <td width="5%"> ลำดับ</td><td width="47%">รายการสินค้า</td><td width="18%">ราคา</td><td width="15%">จำนวน</td><td width="15%">ยอดรวม</td>
                    </tr>

                    <?php  
							$qr_x =dbQuery("SELECT * FROM tbl_product where process_category_id = '$process_category_id' ORDER BY product_name ASC");	
							$row =@mysql_num_rows($qr_x);
							 $i=0;
							while ($i<$row){
							$rs_x=mysql_fetch_array($qr_x);
							$product_id = $rs_x['product_id'];
							$product_name = $rs_x['product_name'];
							$price = $rs_x['price'];
							$product_weight = $rs_x['product_weight'];	
							@$loop = $loop+1;
							
				?>                       
                     <tr>
                        <td width="5%"><? echo $i+1;?></td><td width="47%" align="left"><? echo $product_name;?></td><td width="18%">
                        <input type="hidden" name="product_id<?=$loop?>"   value="<? echo $product_id;?>" size="2" >
                        <input type="hidden" name="product_weight<?=$loop?>"   value="<? echo $product_weight;?>" size="2" >
                        <input type="text" name="price<?=$loop?>" class="form-control"  min="0" id="price<?=$loop?>" value="<? echo $price;?>" size="2" onfocus="startCalc<?=$loop?>()" onblur="stopCalc<?=$loop?>()"  ></td><td width="15%">
                        <input type="number" name="number<?=$loop?>" class="form-control" min="0" name="num" id="num<?=$loop?>" size="2" onfocus="startCalc<?=$loop?>()" onblur="stopCalc<?=$loop?>()" ></td><td width="15%">
                        <input type="text" name="sum_price<?=$loop?>" id="sum_price<?=$loop?>" class="input-label" size="2" value="0" onfocus="startCalc<?=$loop?>()" onblur="stopCalc<?=$loop?>()"  readonly="true">
                       </td>
                    </tr>
<SCRIPT Language="JavaScript">
function startCalc<?=$loop?>(){ 
interval = setInterval("calc<?=$loop?>()",1); 
} 

function calc<?=$loop?>(){ 
num<?=$loop?> = document.autoSumForm.num<?=$loop?>.value; 
price<?=$loop?> = document.autoSumForm.price<?=$loop?>.value; 

document.autoSumForm.sum_price<?=$loop?>.value = (num<?=$loop?>) * (price<?=$loop?>);

} 
function stopCalc<?=$loop?>(){ 
clearInterval(interval); 
} 
</SCRIPT>
              <?
					$i++;
							}
					?>
                </table>
            </div><!----- /.col-md-6 ------>   
        <? 
		if($ic=="$row_c"){
			echo "</div>";
		}
		if($ics%2 == "0"){
		echo "</div>";//<!-----/.row---->
		}
	    $ic++;
		}
		?>

    </div><!-- /.container -->        
    <input type="hidden" name="Line" value="<?=$loop;?>"> 
    <input type="hidden" name="order_id" value="<?=$order_id;?>"> 
    <input type="submit" class="btn btn-default"name="button" id="button" value="Update"  />
   </form>
   <div>&nbsp;</div>