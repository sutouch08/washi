   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add customer</h4>
      </div>
      <div class="modal-body">
   <?php require_once('add_customer.php'); 
 ?>	
        </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
              

       <script src="<?php echo WEB_ROOT;?>library/js/jquery-1.9.1.js"></script> 
  	<script src="<?php echo WEB_ROOT;?>library/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="<?php echo WEB_ROOT;?>dist/js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="<?php echo WEB_ROOT;?>library/css/jquery-ui-1.10.2.custom.css" />
 
  
 <script type="text/javascript">
		$(document).ready(function(){

					function displayVals() {
					  var singleValues = $("#urgent_id").val();
					$("select").change(displayVals);
					displayVals();
					return singleValues;

		});
</script>  <script language="javascript">
function fncSubmit()
{
	if(document.autoSumForm.customer_id.value == "")
	{
		alert('คุณยังไม่ได้ใส่ชื่อลูกค้า');
		document.autoSumForm.customer_name.focus();
		return false;
	}
	
	document.autoSumForm.submit();
}
</script> <div class="container">
    <?php 
        //แสดงข้อมูลลูกค้า
		$shop_id= $_COOKIE['shop_id']; 
        $comma = ''; 
        $allEmp = ''; 
        $sql="SELECT * FROM tbl_customer where shop_id = '$shop_id' ORDER BY customer_name ASC"; 
        $result=mysql_query($sql) or die(mysql_error()." [$sql]"); 
        while ($row = mysql_fetch_array($result)) { 
            $allEmp .= $comma.'{customer_id: "'.$row['customer_id'].'",add: "'.$row['customer_address'].'",phone: "'.$row['customer_phone'].'",email: "'.$row['customer_email'].'",name: "'.$row['customer_name'].'",label: "'.$row['customer_name'].'  -  '.$row['customer_phone'].'"}'; 
            if($comma=='') $comma = ','; 
        } 
        //การใช้งานจริง ส่วนนี้จะถูกเขียนเป็นไฟล์ .js เพื่อเรียกใช้ใน javascript 
        $allEmp = '['. $allEmp . ']';
        //-- 
    ?>  

<table width="70%">
<tr>
<td width="15%"><form method="post" name="name" action="index.php?content=new"  ><input type="text" name="customer_code" class="form-control" placeholder="Code" /></form></td>
<td width="3%" >OR</td>
<td width="20%"><input type="text" class="form-control" id="cus_id" placeholder="ค้นหาชื่อลูกค้าหรือเบอร์โทร" value="">
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
    </script> </td> <td width="5%" align="center">OR</td>
                <td width="10%" align="left">


    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal" >New</button></td>
</tr>
</table>
				<?php  
							if(isset($_POST['customer_code'])){
							$customer_code = $_POST['customer_code'];
							$qr_cus =dbQuery("SELECT * FROM tbl_customer where customer_code = '$customer_code'");	
							$rs_cus=mysql_fetch_array($qr_cus);
							$customer_id = $rs_cus['customer_id'];
							$customer_name = $rs_cus['customer_name'];
							$customer_phone = $rs_cus['customer_phone'];
							$customer_address = $rs_cus['customer_address'];
							$customer_email = $rs_cus['customer_email'];
							}
							if(isset($_GET['customer_code'])){
							$customer_code = $_GET['customer_code'];
							$qr_cus =dbQuery("SELECT * FROM tbl_customer where customer_code = '$customer_code'");	
							$rs_cus=mysql_fetch_array($qr_cus);
							$customer_id = $rs_cus['customer_id'];
							$customer_name = $rs_cus['customer_name'];
							$customer_phone = $rs_cus['customer_phone'];
							$customer_address = $rs_cus['customer_address'];
							$customer_email = $rs_cus['customer_email'];
							}
				?> 
<br /> 
</div>
<form name="autoSumForm"  method="post" action="index.php?content=confirm_order" onSubmit="JavaScript:return fncSubmit();" >
 	<div class="container"><table style="width:100%; margin-top:0px; border:none;">
        	<tr><!-------------  Start Row 1 ------------->
            	<!-- Start Colum 1 width = 50%  -->
            	<td width="10%" align="right">Cus Name:</td>
                <td width="25%" align="left">
            	 <input type="hidden" name="customer_id" id="customer_id"  size="50"  value="<? if(isset($_POST['customer_code'])){echo $customer_id;}else if(isset($_GET['customer_code'])){echo $customer_id;}?>" />
                <input type="text"  name="customer_name" class="input-label" value="<? if(isset($_POST['customer_code'])){echo $customer_name;}else if(isset($_GET['customer_code'])){echo $customer_name;}?>"  id="name" size="50"  disabled="disabled"/>
               
    </td><!--- ค้นหาข้อมูลเมือมีการพิมพ์ข้อความ --->
                <td width="5%" align="center"></td>
                <td width="10%" align="left">


   </td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Order No: 
                 
                 
                </td>
                <td width="15%"><div class="alert alert-success" ><?php echo get_orderID(); ?></div></td>
                <td width="10%">Tracking No:</td>
                <td width="15%"><div class="alert alert-info"><?php echo get_trackingNo(get_orderID(), $_COOKIE['user_id']);?></div></td>
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 1 ------------->
            <tr><!-------------  Start Row 2 ------------->
            	<!-- Start Colum 1 width = 50%  -->
                <td width="10%" align="right" valign="top">Address:</td>
                <td colspan="3" align="left" style="padding-left:5px;"><textarea  id="address" class="input-label-textarea"  disabled="disabled"><? if(isset($_POST['customer_code'])){echo $customer_address;}else if(isset($_GET['customer_code'])){echo $customer_address;}?></textarea>
               </td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Shipping:</td>
                <td width="15%" align="left">  
                 <select name="shipping_id" class="form-control" id="shipping_id" ><!-- วนลูปเอาค่ามาแสดง -->
             <option value="5">มารับที่โรงงาน</option>
				<?php  
							$qr =dbQuery("SELECT * FROM tbl_shipping ORDER BY `default`  DESC");	
							$row =@mysql_num_rows($qr);
							$i=0;
							while ($i<$row){
							$rs=mysql_fetch_array($qr);
							$shipping_id = $rs[shipping_id];
							$shipping_name = $rs[shipping_name];
				?>           								
    <option value="<? echo $shipping_id;?>"><? echo $shipping_name;?></option>
<?
$i++;
}
?></select></select>
                 </td>
				<td width="5%"> Urgent:</td>
                <td width="20%" align="left">
                <select name="urgent_id" class="form-control" id="urgent_id"  ><!-- วนลูปเอาค่ามาแสดง -->
                   <?
							$qr_ur =dbQuery("SELECT * FROM tbl_urgent where `default` = '1'");	
							$rs_ur=mysql_fetch_array($qr_ur);
							$urgent_idd = $rs_ur['urgent_id'];
							$urgent_named = $rs_ur['urgent_name'];
							$urgent_dated = $rs_ur['urgent_date'];
				?>           								
    <option value="<? echo $urgent_idd;?>"><? echo $urgent_named;?></option>
		  <?
				
							$qr_urgent =dbQuery("SELECT * FROM tbl_urgent where `default` != '1'  ORDER BY urgent_name ASC");	
							$row =mysql_num_rows($qr_urgent);
							 $i=0;
							while ($i<$row){
							$rs_urgent=mysql_fetch_array($qr_urgent);
							$urgent_id = $rs_urgent[urgent_id];
							$urgent_name = $rs_urgent[urgent_name];
							$urgent_date = $rs_urgent['urgent_date'];
				?>           								
    <option value="<? echo $urgent_id;?>"><? echo $urgent_name;?></option>
<?
$i++;
}

?></select>
 <?
				
							$qr_urgent =dbQuery("SELECT * FROM tbl_urgent  ORDER BY urgent_name ASC");	
							$row =mysql_num_rows($qr_urgent);
							 $i=0;
							while ($i<$row){
							$rs_urgent=mysql_fetch_array($qr_urgent);
							$id = $rs_urgent['urgent_id'];
							$urgent_date = $rs_urgent['urgent_date'];
							
				          								
 echo " <input type='hidden' id='hiden".$id."' value='".$urgent_date."' />";

$i++;
}
?>
			</td>
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 2 ------------->
            <tr><!--------------  Start Row 3 ------------>
            	<!-- Start Colum 1 width = 50%  -->
               
                <td colspan="4" align="left" > 	<div class="row">
                    		<div class="col-sm-6">Phone No: <input type="text"  class="input-label" id="phone" value="<? if(isset($_POST['customer_code'])){echo $customer_phone;}else if(isset($_GET['customer_code'])){echo $customer_phone;}?>"  disabled="disabled"></div>
                    		<div class="col-sm-6">Email: <input type="text"  class="input-label" id="email" size="30" value="<? if(isset($_POST['customer_code'])){echo $customer_email;}else if(isset($_GET['customer_code'])){echo $customer_email;}?>" disabled="disabled"></div>
                     </div>  </td>
                <!--  End Colum 1 width = 50%  -->	
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right">Qty : </td>
                <td width="15%"><input type="text" name="order_qty" class="input-label" id="order_qty"  disabled="disabled" size="10">&nbsp;Items.
                </td><!---Echo จำนวนรวม ต่อท้ายด้วยคำว่า Item-->
                <td width="10%" align="right">Amount :</td>
                <td width="15%"><input type="text" name="order_amount"  class="input-label" id="order_amount"  disabled="disabled" size="10">&nbsp;THB.</td><!---Echo ราคารวม ต่อท้ายด้วยคำว่า THB-->
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 3 ------------->
            <tr><!-------------  Start Row 4 ------------->
            	<!-- Start Colum 1 width = 50%  -->
                <td width="10%" align="right">หมายเหตุ :</td>
            	<td colspan="3">
                 <input type="text" name="note" cols="100%"  class="form-control" />
                	
                 </td>
                <!--  End Colum 1 width = 50%  -->
                <!--  Start Colum 2 width = 50%  -->
                <td width="10%" align="right" valign="middle">Ready On:</td>
                <td><b><div class="alert alert-danger">
				<? 
				echo date('d-m-Y', strtotime("+$urgent_dated day"));
				?>
                
                </div></b></td><!--- echo กำหนดรับของ วัน/เดือน/ปี  --->
                <td>กำหนดรับ :      
</td>

 <script>
 $(function(){
 $("#dateInput").datepicker({dateFormat:'dd-mm-yy',minDate:<? echo $urgent_dated; ?>});
 });
 /*
function setMindate(){
	var i = document.getElementById('urgent_id').value;
	var Mindate = document.getElementById('hiden'+i).value;
	
	document.getElementById('dateInput').setAttribute('min',Mindate);
}*/
     </script>
            <script type="text/javascript">  
			$( "#urgent_id" )
  .change(function() {
    var i = null;
	var x = null;
    $( "#urgent_id option:selected" ).each(function() {
      i = $( this ).val();
	  x = $("#hiden"+i).val();
	  
    });
    $( "#dateInput" ).datepicker( "option", "minDate", x);
  })
  .trigger( "#urgent_id" );
						
	</script>
			<td><input type="text" class="form-control" name="dateInput" id="dateInput" value="<? echo date('d-m-Y', strtotime("+$urgent_dated day")); ?>"   required /> </td>
               
                <!--  End Colum 2 width = 50%  -->
            </tr><!-------------  End Row 4 ------------->    
			    
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
    
            	<table class="table table-bordered">
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
							$product_weight = $rs_x['product_weight'];
							$price = $rs_x['price'];	
							@$loop = $loop+1;
				?>                       
                     <tr>
                        <td width="5%"><? echo $i+1;?></td><td width="47%" align="left"><? echo $product_name;?></td><td width="18%">
                        <input type="hidden" name="product_id<?=$loop?>"   value="<? echo $product_id;?>" size="2" >
                         <input type="hidden" name="product_weight<?=$loop?>"   value="<? echo $product_weight;?>" size="2" >
                        <input type="text" name="price<?=$loop?>" class="form-control input-sm" id="price<?=$loop?>" value="<? echo $price;?>"  onfocus="startCalc<?=$loop?>()" onblur="stopCalc<?=$loop?>()"  ></td><td width="15%">
                        <input type="text" name="number<?=$loop?>"  name="num" id="num<?=$loop?>" size="2" onfocus="startCalc<?=$loop?>()" onblur="stopCalc<?=$loop?>()" ></td><td width="15%">
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
<script>
 $("#num<?=$loop?>").spinner({numberFormat:"n", min:0 });

</script>
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
<table width="100%" >
<tr>
<td width="100%">
    <input type="hidden" name="Line" value="<?=$loop;?>"> 
    <input type="submit" name="button" id="button" value="เสร็จสิ้น" class="btn btn-default btn-lg"/>
</td>
</tr>
</table>
<br />
<br />
    </div><!-- /.container -->        
   
   </form>>>