<!-- Page-Level Plugin CSS - Morris -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
<!-- Page-Level Plugin Scripts - Morris -->
    <script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>

<?
include "report_function.php"; 
			$view = "month";
			$from_date = "เลือกวัน";
			$to_date =   "เลือกวัน";
			$today = date('Y-m-d');
			$page = "saleReport";
			if(isset($_POST['from_date'])&& $_POST['to_date'] ){
			$to_date= $_POST['to_date'];
			$from_date = $_POST['from_date']; 
			$view = $_POST['view'];
			}elseif(isset($_GET['from_date'])&& $_GET['to_date'] ){
			$to_date= $_GET['to_date'];
			$from_date = $_GET['from_date']; 
			$view = $_GET['view'];
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

<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            รายงานสรุปยอดขายร้านแต่ละร้าน&nbsp;&nbsp; &nbsp; <? /* if(isset($_POST['view'])|| isset($_POST['from_date'])){*/ echo showRang($view,$from_date,$to_date); ?>
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
                <!-- /.col-lg-12 -->
</div>
       <!-- /.row -->
<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            สรุปยอดเงินที่เปิดบิล&nbsp;&nbsp; &nbsp; <? /* if(isset($_POST['view'])|| isset($_POST['from_date'])){*/ echo showRang($view,$from_date,$to_date); ?>
                        </div>
                        <div class="panel-body">
							<div id="sale-report-chart"></div>
						</div>
					</div>
				</div>
</div>				
<div class="row">				
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            สรุปยอดเงินที่รับสินค้าแล้ว&nbsp;&nbsp; &nbsp; <? /* if(isset($_POST['view'])|| isset($_POST['from_date'])){*/ echo showRang($view,$from_date,$to_date); ?>
                        </div>
                        <div class="panel-body">
							<div id="recieved-report-chart"></div>
						</div>
					</div>
				</div>
</div>				
<div class="row">				
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            สรุปยอดเงินที่ค้างรับสินค้า&nbsp;&nbsp; &nbsp; <? /* if(isset($_POST['view'])|| isset($_POST['from_date'])){*/ echo showRang($view,$from_date,$to_date); ?>
                        </div>
                        <div class="panel-body">
							<div id="notrecieve-report-chart"></div>
						</div>
					</div>
				</div>
</div>
<? 
	function reportView($view){
		switch($view){
			case "year" :
				for ($i = 1; $i<=12; $i++)
				{
					$month = monthname($i);
					echo "{ xtime : 'เดือน ".$i."', ".saleReportChart(date('Y-m-01',strtotime("$month this year")),date('Y-m-t',strtotime("$month this year")))." },";
				}
				break;
			case "month" :
				$rang = getMonth();
				$no = DateDiff($rang['from'],$rang['to'])+1;
				$date = date('Y-m-01',strtotime("this month"));
				$day = date('Y-m-01',strtotime("this month"));
				for ($i=1; $i<= $no; $i++){
					echo "{ xtime : '".date('d/m',strtotime("$day"))."', ".saleReportChart($date,$date)." },";
					$date = date('Y-m-d',strtotime("$date +1 day"));
					$day = date('Y-m-d',strtotime("$day +1 day"));
				}
				break;
		}
	}
		 ?>

			<script>
var xdata =  [
<? 
		for ($i = 1; $i<=12; $i++)
		{
			$month = monthname($i);
			echo "{ month : 'เดือน ".$i."', ".saleReportChart(date('Y-m-01',strtotime("$month this year")),date('Y-m-t',strtotime("$month this year")))." },";
		}
		 ?>
];
	
Morris.Line({
  element: 'sale-report-chart',
  data: xdata,
  xkey: 'month',
  ykeys: [<? echo saleReportLabel(); ?>],
  labels: [<? echo saleReportLabel(); ?>],
  smooth:false,
  parseTime: false,
  postUnits : ' THB'
});
</script>
<script>
var ydata =  [
	{ year : '2008', value : 20, HUB : 100 },
    { year : '2009', value : 10,HUB : 100},
    { year : '2010', value : 5 ,HUB : 100},
    { year : '2011', value : 5 ,HUB : 100},
    { year : '2012', value : 20,HUB : 100 }];
	
Morris.Line({
  
  element: 'recieved-report-chart',
  
  data: ydata,
  
  xkey: 'year',
 
  ykeys: ['value','HUB'],

  labels: ['Value','HUB'],
  smooth:false
});
</script><script>
var zdata =  [
	{ year: '2008', value: 20 },
    { year: '2009', value: 10 },
    { year: '2010', value: 5 },
    { year: '2011', value: 5 },
    { year: '2012', value: 20 }];
	
Morris.Line({
  
  element: 'notrecieve-report-chart',
  
  data: zdata,
  
  xkey: 'year',
 
  ykeys: ['value'],

  labels: ['Value'],
  smooth:false
});
</script>