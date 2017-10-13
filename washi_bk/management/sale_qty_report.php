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
                    <h1 class="page-header">รายงานสรุปยอดปริมาณงาน</h1>
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
                            รายงานสรุปยอดปริมาณแต่ละร้าน&nbsp;<? /* if(isset($_POST['view'])|| isset($_POST['from_date'])){*/ echo showRang($view,$from_date,$to_date); ?>
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
                <!-- /.col-lg-12 -->
</div>
       <!-- /.row -->