<?
			include "tool.php";
			$today = date('Y-m-d');
			$view = "month";


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
<?
if(isset($_POST['view'])){
	$view = $_POST['view'];

}if(isset($_POST['from_date'])&& $_POST['to_date']){
			$from_date = $_POST['from_date']; 
			$to_date = $_POST['to_date'];
 } require "fillter.php";

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
                 <hr />
  
			
			<div class="row">
				<div class="col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>สรุปยอดซักของแต่ละร้าน&nbsp;&nbsp;: &nbsp; <?php echo showRang($view, $from_date, $to_date); ?></h4>
                        </div>
                        <div class="panel-body">
	<table class="table table-bordered">
	  <tr align="center">
	  <td width="10%"><h4>ลำดับ</h4></td>
      <td width="20%"><h4>ร้าน</h4></td>
      <td width="13%"><h4>ยอดชิ้นงานที่รับมา</h4></td>
      <td width="13%"><h4>ยอดชิ้นงานที่ส่งกลับเเล้ว</h4></td>
      <td width="13%"><h4>ยอดชิ้นงานที่ค้างอยู่</h4></td>
	</tr>
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
	<td><?=$n;?></td>
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
                        <div class="panel-footer">
                            Panel Footer
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
                        <div class="panel-footer">
                            Panel Footer
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