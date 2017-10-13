<!-- Page-Level Plugin CSS - Morris -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
<!-- Page-Level Plugin Scripts - Morris -->
    <script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>
<?
include "report_function.php"; 
			$view = "week";
			$from_date = "เลือกวัน";
			$to_date =   "เลือกวัน";
			$today = date('Y-m-d');
			if(isset($_POST['from_date'])&& $_POST['to_date'] ){
			$to_date= $_POST['to_date'];
			$from_date = $_POST['from_date']; 
			$view = $_POST['view'];
			}
?>

<!--   Page title   --->
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dash Board</h1>
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
	var viewlist =$("#view").val();
	var from_date = $("#from_date").val();
	var to_date = $("#to_date").val();
	if(from_date =="เลือกวัน"){	
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
<? require "fillter.php"; ?>

			<?
						$total_amount = dbFetchArray(getTotalOrder($view,$from_date,$to_date));
						$total_recieved = dbFetchArray(getTotalRecieved($view,$from_date,$to_date));
						$total_notrecieved = dbFetchArray(getTotalNotRecieved($view,$from_date,$to_date));
			
					?>	
										
<div class="row">
				<div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">ยอดขาย</h3>
                        </div>
                        <div class="panel-body" style="text-align:right;">
						<h2><? echo number_format($total_amount['amount'])."  THB"; ?></h2>
						</div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
				<div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             <h3 class="panel-title">ส่งแล้ว</h3>
                        </div>
                        <div class="panel-body" style="text-align:right;">
					       <h2><? echo number_format($total_recieved['amount'])."  THB"; ?></h2>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
				<div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             <h3 class="panel-title">ค้างส่ง</h3>
                        </div>
                        <div class="panel-body" style="text-align:right;">
							<h2><? echo number_format($total_notrecieved['amount'])."  THB"; ?></h2>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
			
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                             รายงานสรุปยอดปริมาณแต่ละร้าน&nbsp;&nbsp; &nbsp; 
                        </div>
                        <div class="panel-body">
							<? 
						$head_qr = dbQuery("select * from tbl_type order by type_id asc");
						$head_row = dbNumRows($head_qr);
						$head_i = 0;
						?>
						<table class="table table-bordered table-hover">
							<thead align="center">
								<td width="5%">ลำดับ</td><td width="20%">ร้าน</td>
								<? 
									while($head_i<$head_row){
										$head = dbFetchArray($head_qr);
										$head_data = $head['type_name'];
										echo"<td align='center'>$head_data</td>";
										$head_i++;
									}
									?>
									<td align="center">รวม</td>
							</thead>
							<? // if(isset($_POST['view']) || isset($_POST['from_date'])){
									$shop_qr = dbQuery("SELECT * FROM tbl_shop");
									$shop_row = dbNumRows($shop_qr);							
									$shop_i = 0;
									$shop_n = 1;
									while($shop_i<$shop_row){
										$data = dbFetchArray($shop_qr);
										$shop_id = $data['shop_id'];
										$shop_name = $data['shop_name'];
										$type_qr = dbQuery("SELECT * FROM tbl_type ORDER BY type_id ASC");
										$type_row = dbNumRows($type_qr);
										$total_qty = 0;
										$type_i = 0;
										echo "<tr><td>$shop_n</td><td>$shop_name</td>";
										while($type_i<$type_row){
										$data_type = dbFetchArray($type_qr);
										$type_id = $data_type['type_id'];
										$data_qty = dbFetchArray(getQtyByShop($shop_id,$type_id,$view,$from_date,$to_date));
										$qty = $data_qty['qty'];
										if($qty != 0){
										echo "<td align='right'>$qty</td>";
										}else{
										echo "<td align='right'>-</td>";
										}
										$total_qty = $total_qty + $qty;
										$type_i++;
										}
										if($total_qty !=0){
										echo "<td align='right'>$total_qty</td></tr>";
										}else{
										echo "<td align='right'>-</td></tr>";
										}
										$shop_i++;
										$shop_n++;
									}
							//}
									?>	
							<tr><td colspan="2" align="right">รวม</td>		
							<?  
					//	if(isset($_POST['view']) || isset($_POST['from_date'])){
						$total_qr = dbQuery("select * from tbl_type order by type_id asc");
						$total_row = dbNumRows($total_qr);
						$total_i = 0;
						$all_total= 0;
						while($total_i<$total_row){
										$total = dbFetchArray($total_qr);
										$total_type = $total['type_id'];
										$data_total = dbFetchArray(getTotalQty($total_type,$view,$from_date,$to_date));
										$type_total = $data_total['qty'];
										if($type_total != 0){
										echo"<td align='right'>$type_total</td>";
										}else{
										echo "<td align='right'>0</td>";
										}
										$all_total = $all_total + $type_total;
										$total_i++;
						}
						echo "<td align='right'>$all_total</td>";
				//		}
						
						?>	
						</tr>	
						</table>   
						</div>
					</div>
				</div>
</div>
<div class="row">
					<div class="col-lg-7">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            รายงานสรุปยอดขายร้านแต่ละร้าน&nbsp;&nbsp; &nbsp; 
                        </div>
                        <div class="panel-body">
							<table class="table table-bordered table-hover">
							<thead align="center">
								<td width="5%">ลำดับ</td><td width="20%">รายการ</td><td width="25%">ยอดเงินที่เปิดบิล</td><td width="25%">ยอดเงินที่รับสินค้าแล้ว</td><td width="25%">ยอดเงินที่ค้างรับสินค้า</td>
							</thead>
							<? if(isset($_POST['view']) || isset($_POST['from_date'])){
									$sql = dbQuery("SELECT * FROM tbl_shop");
									$row = dbNumRows($sql);
									$sum_amount = 0;
									$sum_recieved = 0;
									$sum_notrecieved = 0;
									$i = 0;
									$n = 1;
									while($i<$row){
										$data = dbFetchArray($sql);
										$shop_id = $data['shop_id'];
										$shop_name = $data['shop_name'];
										$total_amount = dbFetchArray(getTotalAmountByShop($shop_id, $view,$from_date,$to_date));
										$total_recieved = dbFetchArray(getOrderRecievedByShop($shop_id,$view,$from_date,$to_date));
										$total_notrecieved = dbFetchArray(getOrderNotRecievedByShop($shop_id,$view,$from_date,$to_date));
										echo "<tr><td>$n</td><td>$shop_name</td>
										<td align='right'>"; if($total_amount['amount'] >0){echo"<a href='index.php?content=saleDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>";} echo number_format($total_amount['amount'])."</a></td>
										<td align='right'>"; if($total_recieved['amount'] >0){echo"<a href='index.php?content=receivedDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>";} echo number_format($total_recieved['amount'])."</a></td>
										<td align='right'>"; if($total_notrecieved['amount'] >0){echo"<a href='index.php?content=notrecievedDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>";} echo number_format($total_notrecieved['amount'])."</a></td></tr>";
										$sum_amount = $sum_amount + $total_amount['amount'];
										$sum_recieved = $sum_recieved + $total_recieved['amount'];
										$sum_notrecieved = $sum_notrecieved + $total_notrecieved['amount'];
										$i++;
										$n++;
									}
							}else{
									$sql = dbQuery("SELECT * FROM tbl_shop");
									$row = dbNumRows($sql);
									$sum_amount = 0;
									$sum_recieved = 0;
									$sum_notrecieved = 0;
									$i = 0;
									$n = 1;
									while($i<$row){
										$data = dbFetchArray($sql);
										$shop_id = $data['shop_id'];
										$shop_name = $data['shop_name'];
										$total_amount = dbFetchArray(getTotalAmountByShop($shop_id, $view,$from_date,$to_date));
										$total_recieved = dbFetchArray(getOrderRecievedByShop($shop_id,$view,$from_date,$to_date));
										$total_notrecieved = dbFetchArray(getOrderNotRecievedByShop($shop_id,$view,$from_date,$to_date));
										echo "<tr><td>$n</td><td>$shop_name</td>
										<td align='right'>"; if($total_amount['amount'] >0){echo"<a href='index.php?content=saleDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>";} echo number_format($total_amount['amount'])."</a></td>
										<td align='right'>"; if($total_recieved['amount'] >0){echo"<a href='index.php?content=receivedDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>";} echo number_format($total_recieved['amount'])."</a></td>
										<td align='right'>"; if($total_notrecieved['amount'] >0){echo"<a href='index.php?content=notrecievedDetailByShop&shop_id=$shop_id&view=$view&from=$from_date&to=$to_date&page=$page'>";} echo number_format($total_notrecieved['amount'])."</a></td></tr>";
										$sum_amount = $sum_amount + $total_amount['amount'];
										$sum_recieved = $sum_recieved + $total_recieved['amount'];
										$sum_notrecieved = $sum_notrecieved + $total_notrecieved['amount'];
										$i++;
										$n++;
									}
							}
							?>
							<tr><td colspan="2" align="right">รวม</td><td align="right"><? if(isset($_POST['view']) || isset($_POST['from_date'])){ echo number_format($sum_amount);} ?></td><td align="right"><? if(isset($_POST['view']) || isset($_POST['from_date'])){ echo number_format($sum_recieved);} ?></td><td align="right"><? if(isset($_POST['view']) || isset($_POST['from_date'])){ echo number_format($sum_notrecieved);} ?></td>
							</tr>																			
						</table>    
						</div>
					</div>
				</div>
	
	<div class="col-lg-5">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                          สรุปยอดซักของแต่ละร้าน&nbsp;&nbsp; &nbsp;
                        </div>
                        <div class="panel-body">
						<table class="table table-bordered">
	  <tr align="center">
      <td width="20%">ร้าน</td>
      <td width="13%">ยอดชิ้นงานที่รับมา</td>
      <td width="13%">ยอดชิ้นงานที่ส่งกลับเเล้ว</td>
      <td width="13%">ยอดชิ้นงานที่ค้างอยู่</td>
	</tr>
    <?
if(isset($_POST['view'])){
	$view = $_POST['view'];
}else{
	$selected =0;
$view = "";
}

			if(isset($_POST['from_date'])&& $_POST['to_date']){
			$to= $_POST['to_date'];
			$from = $_POST['from_date']; 
				if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$to_date= date('Y-m-d',strtotime($_POST['to_date']));
			$from_date = date('Y-m-d',strtotime($_POST['from_date']));
		}
		}else if($view =="day"){
		$from_date = $today;
		$to_date = $today;
		}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		}else if($view =="month"){
			$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		}else if($view =="year"){
			$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		}
			}else if(isset($_GET['from_date'])&& $_GET['to_date']){
			$to= $_GET['to_date'];
			$from = $_GET['from_date']; 
				if($from !="เลือกวัน"){
		if($to !="เลือกวัน"){
			$to_date= date('Y-m-d',strtotime($_GET['to_date']));
			$from_date = date('Y-m-d',strtotime($_GET['from_date']));
		}
		}else if($view =="day"){
		$from_date = $today;
		$to_date = $today;
		}else if($view =="week"){
		$week = getWeek($today);
		$from_date = $week["from"];
		$to_date = $week["to"];
		}else if($view =="month"){
			$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		}else if($view =="year"){
			$year = getYear();
		$from_date = $year['from'];
		$to_date = $year['to'];
		}
			}else{
				$to_date= '';
				$from_date = '';
			}
			?>
    <?
    $sql1 = "SELECT * FROM tbl_shop where shop_id != '2' and shop_id != '3'";
    $result1 = dbQuery($sql1);
	$row = dbNumRows($result1);
	$i=0;
	$n=1;
	while($i<$row){
	$data1 = dbFetchArray($result1);
	$shop_id= $data1['shop_id'];
	$shop_name = $data1['shop_name'];
	?>
    <tr align="center">
    <td><?=$shop_name;?></td>
    <td><a href="index.php?content=factory&cate=1&shop_id=<?=$shop_id;?>&from_date=<?=$from_date;?>&to_date=<?=$to_date;?>"><?
	$result2 = dbQuery("SELECT SUM(order_qty) FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date' and tbl_order.shop_id = '$shop_id' and status IN (6,7,8,9,10,11,12,13,14,15,16,17)");
	$data = dbFetchArray($result2);
	echo $data['SUM(order_qty)'];
	?></a></td>
    <td><a href="index.php?content=factory&cate=2&shop_id=<?=$shop_id;?>&from_date=<?=$from_date;?>&to_date=<?=$to_date;?>"><?  
	$result2 = dbQuery("SELECT SUM(order_qty) FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date' and tbl_order.shop_id = '$shop_id' and status IN (10,11,12,13,14,15,16,17)");
	$data = dbFetchArray($result2);
	echo $data['SUM(order_qty)'];
	?></a></td>
    <td><a href="index.php?content=factory&cate=3&shop_id=<?=$shop_id;?>&from_date=<?=$from_date;?>&to_date=<?=$to_date;?>"><?  
	$result2 = dbQuery("SELECT SUM(order_qty) FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date' and tbl_order.shop_id = '$shop_id' and status IN (6,7,8,9)");
	$data = dbFetchArray($result2);
	echo $data['SUM(order_qty)'];
	?></a></td>
	</tr>
	<?
    $i++;
	$n++;
	}
    ?>
	</table>
						</div>
					</div>
				</div>
				
</div>

