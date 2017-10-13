
<?
include "report_function.php"; 
			$today = date('Y-m-d');
			$page="saleByShop";			
			if(isset($_POST['from_date'])&& $_POST['to_date'] ){
			$to_date= $_POST['to_date'];
			$from_date = $_POST['from_date']; 
			}else{
			if(isset($_GET['from_date'])&& $_GET['to_date'] ){
			$to_date=  $_GET['to_date'];
			$from_date = $_GET['from_date']; 
			}
			}
?>

<!--   Page title   --->
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">รายงานยอดขาย</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<script language="javascript">  
$(function() {
    $( "#from_date" ).datepicker({
      dateFormat: 'dd-mm-yy', onClose: function( selectedDate ) {
        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to_date" ).datepicker({
      dateFormat: 'dd-mm-yy',   onClose: function( selectedDate ) {
        $( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  function validate()
{
	var checked = $("#shop_id").val();
	var viewlist =$("#view").val();
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();
	if(checked==0){
		alert ("คุณยังไม่ได้เลือกร้าน");	
		}else if(from_date =="เลือกวัน"){	
		if(viewlist==0){	
		alert("คุณยังไม่ได้เลือกช่วงเวลา");
		}else{
			$("#form").submit();
		}
			}else if(to_date ==""){
				alert("คุณยังไม่ได้เลือกวันสุดท้าย");	
	}else{
		$("#form").submit();
	}
}	
      </script>
	  <script>
$(document).ready(function(){
  $("#view").change(function(){
    $("#from_date").val("เลือกวัน");
	$("#to_date").val("เลือกวัน");
  });
});
$(document).ready(function(){
  $("#from_date").change(function(){
    $("#view").val("0");
  });
});
</script>
<? 
$view = "";
if(isset($_POST['shop_id'])){
	$shop_id = $_POST['shop_id'];
	$view = $_POST['view'];
	$shop_name = getShopName($shop_id);
	$total_amount = dbFetchArray(getTotalAmountByShop($shop_id, $view,$from_date,$to_date));
	$total_recieved = dbFetchArray(getOrderRecievedByShop($shop_id,$view,$from_date,$to_date));
	$total_notrecieved = dbFetchArray(getOrderNotRecievedByShop($shop_id,$view,$from_date,$to_date));
}else{
if(isset($_GET['shop_id'])){
	$shop_id = $_GET['shop_id'];
	$view = $_GET['view'];
	$shop_name = getShopName($shop_id);
	$total_amount = dbFetchArray(getTotalAmountByShop($shop_id, $view,$from_date,$to_date));
	$total_recieved = dbFetchArray(getOrderRecievedByShop($shop_id,$view,$from_date,$to_date));
	$total_notrecieved = dbFetchArray(getOrderNotRecievedByShop($shop_id,$view,$from_date,$to_date));
}
}
?>	 
<? require "fillter_by_shop.php"; ?>
<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            รายงานสรุปยอดขายร้าน&nbsp;&nbsp; &nbsp; <?  if(isset($_POST['shop_id'])){ echo $shop_name;} ?>&nbsp;&nbsp; &nbsp; <?  if(isset($_POST['shop_id'])){ echo showRang($view,$from_date,$to_date);} ?>
                        </div>
                        <div class="panel-body">
						<table class="table table-bordered">
							<tr align="center">
								<td width="10%">ลำดับ</td><td width="50%">รายการ</td><td width="20%">จำนวนเงิน</td><td>การกระทำ</td>
							</tr>
							<tr>
								<td>1</td><td>ยอดเงินที่เปิดบิล</td><td align="right"><? if(isset($total_amount)){echo number_format($total_amount['amount']);} ?></td><td><? if(isset($_POST['shop_id'])){ echo "<a href='index.php?content=saleDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>รายละเอียด</a>";} elseif(isset($_GET['shop_id'])){ echo "<a href='index.php?content=saleDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>รายละเอียด</a>";}?></td>
							</tr>
							<tr>
								<td>2</td><td>ยอดเงินที่รับสินค้าแล้ว</td><td align="right"><? if(isset($total_amount)){echo number_format($total_recieved['amount']);} ?></td><td><? if(isset($_POST['shop_id'])){ echo "<a href='index.php?content=receivedDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>รายละเอียด</a>";} elseif(isset($_GET['shop_id'])){ echo "<a href='index.php?content=receivedDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>รายละเอียด</a>";}?></td>
							</tr>
							<tr>
								<td>3</td><td>ยอดเงินที่ค้างรับสินค้า</td><td align="right"><? if(isset($total_amount)){echo number_format($total_notrecieved['amount']);} ?></td><td><? if(isset($_POST['shop_id'])){ echo "<a href='index.php?content=notrecievedDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>รายละเอียด</a>";} elseif(isset($_GET['shop_id'])){ echo "<a href='index.php?content=notrecievedDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>รายละเอียด</a>";}?></td>
							</tr>
							
						</table>    
                        </div>
                        
                    </div>
                </div>
                
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<?
	