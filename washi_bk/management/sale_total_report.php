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
			if(isset($_POST['from_date'])&& $_POST['to_date'] ){
			$to_date= $_POST['to_date'];
			$from_date = $_POST['from_date']; 
			$view = $_POST['view'];
			}
?>

<!--   Page title   --->
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">สรุปยอดขาย<? echo showRang($view,$from_date,$to_date); ?></h1>
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

<div class="row">
                <div class="col-lg-12"><form  method="post" id="form">
					<table width="100%" align="center">
						<tr>
							<td width="10%" align="right">แสดงเป็น : &nbsp;</td><td width="15%" align="left"><select class="form-control" name="view" id="view"><? if(isset($_POST['view'])){getViewList($view,$from_date);}else{ getViewList("",$from_date);}?></select></td>
							<td width="10%" align="right">หรือ&nbsp;&nbsp;&nbsp; จาก :&nbsp; </td>
							<td width="10%" align="left"><input type="text" class="form-control"  name="from_date" id="from_date"  value="<?  if(isset($_POST['from_date']) && $_POST['to_date'] && $_POST['from_date'] && $_POST['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($from_date));} else { echo "เลือกวัน";} ?>"/></td>
							<td width="3%" align="right">ถึง :&nbsp; </td><td width="10%" align="left"><input type="test" class="form-control"  name="to_date" id="to_date" value="<?  if(isset($_POST['from_date']) && $_POST['to_date'] && $_POST['from_date'] && $_POST['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($to_date));} else { echo "เลือกวัน"; } ?>" /></td>
							<td width="5%">&nbsp;</td><td align="left"><button type="button" class="btn btn-default" onclick="validate()">แสดง</button></td>
						</tr>
					</table>
					</form>
                 <hr />
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
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
							<div id="notrecieved-report-chart"></div>
						</div>
					</div>
				</div>
</div>

<script>
var xdata =  [ <?  ReportChart($view,$from_date,$to_date);  ?> ];
	
Morris.Line({
  element: 'sale-report-chart',
  data: xdata,
  xkey: 'xtime',
  ykeys: [<? echo saleReportLabel(); ?>],
  labels: [<? echo saleReportLabel(); ?>],
  smooth:false,
  parseTime: false,
  postUnits : ' THB'
});
</script>
<script>
var ydata =  [	<?  RecievedChart($view,$from_date,$to_date);  ?>	];
	
Morris.Line({
  element: 'recieved-report-chart',
  data: ydata,
  xkey: 'xtime',
  ykeys: [<? echo saleReportLabel(); ?>],
  labels: [<? echo saleReportLabel(); ?>],
  smooth:false,
  parseTime: false,
  postUnits : ' THB'
});
</script><script>
var zdata = [<?  NotRecievedChart($view,$from_date,$to_date);  ?>	];
	
Morris.Line({
  element: 'notrecieved-report-chart',
  data: zdata,
  xkey: 'xtime',
  ykeys: [<? echo saleReportLabel(); ?>],
  labels: [<? echo saleReportLabel(); ?>],
  smooth:false,
  parseTime: false,
  postUnits : ' THB'
});
</script>