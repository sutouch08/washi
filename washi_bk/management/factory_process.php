<?
include "report_function.php"; 
				$today = date("Y-m-d");
				$view = "month";
if(isset($_POST['view'])){
	$view = $_POST['view'];
	}
if(isset($_POST['from_date'])&& $_POST['to_date']){
			$from_date = $_POST['from_date']; 
			$to_date = $_POST['to_date'];
 } 
	
?>

			<!--   Page title   --->
			<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">สรุปยอดซัก</h1>
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
 <? require "fillter.php"; 
 if(isset($view)&&$view !="0"){
				switch($view){
					case "week" :
					$date = getWeek($today);
					$from_date = $date['from'];
					$to_date = $date['to'];
					break;
					case "month" :
					$date = getMonth($today);
					$from_date = $date['from'];
					$to_date = $date['to'];
					break;
					case "year" :
					$date = getYear($today);
					$from_date = $date['from'];
					$to_date = $date['to'];
					break;
					default :
					$date = getMonth($today);
					$from_date = $date['from'];
					$to_date = $date['to'];
					break;
				}
			}else{
			if(isset($_POST['from_date'])&& $_POST['to_date'] ){
			$to_date= dbDate($_POST['to_date']);
			$from_date = dbDate($_POST['from_date']); 
			
			}else if(isset($_GET['from_date'])&& $_GET['to_date'] ){
			$to_date= dbDate($_GET['to_date']);
			$from_date = dbDate($_GET['from_date']); 
			
			}else{
				$to_date= '';
				$from_date = '';
			} }

 ?>

			
			<div class="row">
				<div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>ปริมาณการซัก&nbsp;&nbsp;: &nbsp; <? echo showRang($view, $from_date, $to_date); /*if($from_date == ""){ echo date('d-m-Y',strtotime($today));}else{ echo "".date('d-m-Y',strtotime($from_date))." ถึง ".date('d-m-Y',strtotime($to_date));}*/?></h4>
                        </div>
                        <div class="panel-body">
	<table class="table table-bordered">
	  <tr align="center">
	  <td width="10%"><h4>ลำดับ</h4></td>
      <td width="20%"><h4>รายการ</h4></td>
      <td width="13%"><h4>ปริมาณ</h4></td>
      <td width="13%"><h4>น้ำหนัก</h4></td>
	</tr>
    <?
    $sql1 = "SELECT * FROM tbl_type ORDER BY  `tbl_type`.`type_id` ASC ";
    $result1 = dbQuery($sql1);
	$row = dbNumRows($result1);
	$i=0;
	$n=1;
	$row2 = "";
	$sumweight1 = "";
	while($i<$row){
	$data1 = dbFetchArray($result1);
	$type_id= $data1['type_id'];
	$type_name = $data1['type_name'];
	$sql = "SELECT * FROM tbl_order_detail LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN fac_process_detail ON tbl_order_detail.detail_id = fac_process_detail.detail_id LEFT JOIN fac_process ON fac_process_detail.process_id = fac_process.process_id where type_id = '$type_id' and datetime  BETWEEN '$from_date 00:00:01' and '$to_date  23:59:59'";
	$result = dbQuery($sql);
    $row1 = dbNumRows($result);
	$i1=0;
	$sumweight = "";
	while($i1<$row1){
	$data = dbFetchArray($result);
	$weight = $data['product_weight'];
	$sumweight = $sumweight+$weight;
	
	$i1++;
	}if($sumweight == "" ){
		$sumweight = 0;
	}
	?>
   <tr>
   <td><?=$n;?></td>
   <td><?=$type_name;?></td>
   <td align="center"><?=$row1;?></td>
   <td align="center"><?=$sumweight;?></td>
   </tr>
	<?
	$row2 = $row2 + $row1;
	$sumweight1 = $sumweight1 + $sumweight;
    $i++;
	$n++;
	}
    ?>
    <tr>
    <td colspan="2" align="right">รวม</td>
    <td align="center"><?=$row2;?></td>
    <td align="center"><?=$sumweight1;?></td>
    </tr>
	</table>
                        </div>
                        
                    </div>
                </div>
                  <? if(isset($_GET['cate'])){
					$cate = $_GET['cate'];
					
					if($cate == "1"){
						$sql1 = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date' and tbl_order.shop_id = '$shop_id' and status IN (6,7,8,9,10,11,12,13,14,15,16,17)";
						$detail = "ยอดชิ้นงานที่รับมา";
					}else if($cate == "2"){
						$sql1 = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date' and tbl_order.shop_id = '$shop_id' and status IN (10,11,12,13,14,15,16,17)";
						$detail = "ยอดชิ้นงานที่ส่งกลับเเล้ว";
					}else if($cate == "3"){
						$sql1 = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date' and tbl_order.shop_id = '$shop_id' and status = '2' and status IN (6,7,8,9)";
						$detail = "ยอดชิ้นงานที่ค้างอยู่";
					}
					?>
                <div class="col-lg-6">
                                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h4> รายละเอียด  <? if(isset($_GET['cate'])){ echo $detail;}?></h4>
                        </div>
                        <div class="panel-body">
                        <?
                        if(isset($_GET['cate'])){?>
                          <table width="100%" class="table table-bordered" >
                            <tr>
                            <td width="10%" align="center"><h4>ลำดับ</h4></td>
                            <td width="25%"><h4>รายการ</h4></td>
                            <td width="15%" align="center"><h4>ชื่อลูกค้า</h4></td>
                            <td width="15%" align="center"><h4>ปริมาณชิ้น</h4></td>
                            <td width="20%" align="center"><h4>วันที่ต้องการสินค้า</h4></td>
                            <td width="15%" align="center"><h4>ระยะเวลาทำงาน</h4></td>
                            </tr>
                         <? 

						  $result1 = dbQuery($sql1);
							$row = dbNumRows($result1);
							$i=0;
							$n=1;
							while($i<$row){
							$data1 = dbFetchArray($result1);
							$order_no= $data1['order_no'];
							$order_qty = $data1['order_qty'];
							$weight = $data1['weight'];
							$order_due = $data1['order_due'];
							$order_date_time = $data1['order_date_time'];
							$customer_name = $data1['customer_name'];
						  ?>
                            <tr>
                            <td align="center"><?=$n;?></td>
                            <td><?=$order_no;?></td>
                            <td><?=$customer_name;?></td>
                            <td align="center"><?=$order_qty;?></td>
                            <td align="center"><?=$order_due;?></td>
                            <td align="center"><? echo "".DateDiff("$today","$order_due");?></td>
                            </tr>
                            <?
                          $i++;
						  $n++;
							}
                           ?>
                            </table>
                        <? }?>
                        </div>
                       
                        </div>
                </div>
              <?
				}
				?>
            </div>   
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->