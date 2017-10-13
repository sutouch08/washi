<?
include "tool.php";
$today = date('Y-m-d');


?>

<!--   Page title   --->
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">สรุปการขนส่งของเเต่ละร้าน</h1>
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
 if(isset($_POST['view'])){
	$view = $_POST['view'];
}else{
	$selected =0;
$view = "";
} if(isset($_POST['from_date'])&& $_POST['to_date']){
			$from_date = $_POST['from_date']; 
 } require "fillter.php";
			if(isset($_POST['from_date'])&& $_POST['to_date']){
			$to= $_POST['to_date'];
			$from = $_POST['from_date']; 
			$from_date = $_POST['from_date']; 
			
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
			}else{
				$to_date= '';
				$from_date = '';
			}
			 ?>	
<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>สรุปการขนส่งของเเต่ละร้าน&nbsp;&nbsp; &nbsp; <?  if(isset($_POST['shop_id'])){ echo $shop_name;} ?></h4>
                        </div>
                        <div class="panel-body">
						<table class="table table-bordered">
							<tr align="center">
								<td width="10%"><h4>ลำดับ</h4></td>
                                <td width="20%"><h4>ร้าน</h4></td>
                                <td width="13%"><h4>รับทั้งหมด</h4></td>
                                <td width="13%"><h4>ส่งไปโรงงานแล้ว</h4></td>
                                <td width="13%"><h4>ค้างสงไปโรงงาน</h4></td>
                                <td width="13%"><h4>รับจากโรงงาน</h4></td>
                                <td width="13%"><h4>ค้างรับจากโรงงาน</h4></td>
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
                                <td><a href="index.php?content=Delivery1&cate=1&shop_id=<?=$shop_id;?>&from_date=<?=$from_date;?>&to_date=<?=$to_date;?>"><?=$shop_name;?></a></td>
                                <td><?  
						    $result = dbQuery("SELECT * FROM tbl_order where order_date_time BETWEEN '$from_date' AND '$to_date' and shop_id = '$shop_id'");
							$row = dbNumRows($result);
							echo $row;
							?></td>
                                <td><?  
						    $result = dbQuery("SELECT * FROM tbl_order where order_date_time BETWEEN '$from_date' AND '$to_date' and shop_id = '$shop_id' and status IN (3,4,5,6,7,8) ");
							$row = dbNumRows($result);
							echo $row;
							?></td>
                                <td><?  
						    $result = dbQuery("SELECT * FROM tbl_order where order_date_time BETWEEN '$from_date' AND '$to_date' and shop_id = '$shop_id' and status = '2'");
							$row = dbNumRows($result);
							echo $row;
							?></td>
                                <td><?  
						    $result = dbQuery("SELECT * FROM tbl_order where order_date_time BETWEEN '$from_date' AND '$to_date' and shop_id = '$shop_id' and status IN (16,17)");
							$row = dbNumRows($result);
							echo $row;
							?></td>
                                <td><?  
							$sql = "SELECT * FROM tbl_order where order_date_time BETWEEN '$from_date' AND '$to_date' and shop_id = '$shop_id' and status IN (9,10,11,12,13,14,15)";
						    $result = dbQuery($sql);
							$row = dbNumRows($result);
							echo $row;
							?></td>
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
                
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->