<?
			include "report_function.php"; 
			$today = date('Y-m-d');
			$view = "month";
			$from_date = "เลือกวัน";
			$to_date =   "เลือกวัน";
			
			
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
if(isset($_POST['shop_id'])){
	$shop_id = $_POST['shop_id'];
	$view = $_POST['view'];
	$shop_name = getShopName($shop_id);
	}else{
if(isset($_GET['shop_id'])){
	$shop_id = $_GET['shop_id'];
	$view = $_GET['view'];
	$shop_name = getShopName($shop_id);
	
}
}
?>	 
<? require "fillter_by_shop.php"; ?>
			<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">

                        <div class="panel-heading">
                            รายงานสรุปยอดปริมาณร้าน&nbsp;<?  if(isset($_POST['shop_id'])){ echo $shop_name;} ?>&nbsp;&nbsp; &nbsp; <?  if(isset($_POST['shop_id'])){ echo showRang($view,$from_date,$to_date);} ?>
                        </div>
                        <div class="panel-body">
						<? 
						$head_qr = dbQuery("select * from tbl_type order by type_id asc");
						$head_row = dbNumRows($head_qr);
						$head_i = 0;
						?>
						<table class="table table-bordered table-hover">
							<thead align="center">
								<td width="5%">ลำดับ</td><td width="35%">รายการ</td><td width="15%">จำนวน</td>
							</thead>
							<?		 $total_qty =0;
									// if(isset($_POST['view']) || isset($_POST['from_date'])){
										$type_qr = dbQuery("SELECT * FROM tbl_type ORDER BY type_id ASC");
										$type_row = dbNumRows($type_qr);
										$total_qty = 0;
										$type_i = 0;
										$type_n = 1;
										while($type_i<$type_row){
										$data_type = dbFetchArray($type_qr);
										$type_id = $data_type['type_id'];
										$type_name = $data_type['type_name'];
										$data_qty = dbFetchArray(getQtyByShop($shop_id,$type_id,$view,$from_date,$to_date));
										$qty = $data_qty['qty'];
										echo "<tr><td>$type_n</td><td>$type_name</td><td align='right'>"; if($qty !=0){echo $qty; }else{ echo "-";} echo "</td></tr>";
										$total_qty = $total_qty + $qty;
										$type_i++;
										$type_n++;
										}
										
									//}
									?>	
							<tr><td colspan="2" align="right">รวม</td>		
							<?  
					//	if(isset($_POST['view']) || isset($_POST['from_date'])){
										if($total_qty != 0){
										echo"<td align='right'>$total_qty</td></tr>";
										}else{
										echo "<td align='right'>0</td></tr>";
										}
					//	}
						?>	
						</tr>	
						</table>    
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
</div>
       <!-- /.row -->
			