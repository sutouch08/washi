<?php
$today = date('Y-m-d');
include "tool.php";
	if(isset($_POST['view'])){
		$view = $_POST['view'];
	}else{
		$selected =0;
		$view = "month";
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
		}else{
			$month = getMonth();
			$from_date = $month['from'];
			$to_date = $month['to'];
		}
	}else{
		$month = getMonth();
		$from_date = $month['from'];
		$to_date = $month['to'];
		$from = "เลือกวัน";
	}
	if(isset($_POST['carid'])){
		$carid = $_POST['carid'];
	}else{
		$carid = "";
	}
?>
<!--   Page title   --->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">การเดินทาง</h1>
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

<?php
if(isset($_POST['shop_id'])){
	$shop_id = $_POST['shop_id'];
	$selected = $_POST['shop_id'];
	$shop_name = getShopName($shop_id);
}
echo"<div class='row'>
			<form  method='post' id='form'>
				<div class='col-lg-3 col-lg-offset-3'>
				<div class='input-group'>
					<span class='input-group-addon'> แสดงเป็น :</span>
					 <select class='form-control' name='view' id='view'>"; 
					 if($from != "เลือกวัน"){$view = "";}
	echo "<option value='0' "; if($view==""){echo "selected='selected'";} echo ">เลือกการแสดงผล</option>";
	echo "<option value='week' "; if($view == "week"){echo "selected='selected'";} echo ">แสดงเป็นสัปดาห์</option>";
	echo "<option value='month' "; if($view == "month"){echo "selected='selected'";} echo ">แสดงเป็นเดือน</option>";
					echo "</select>
				</div>
				</div>
				<div class='col-lg-1'> หรือเลือก</div>
				<div class='col-lg-2'>
				<div class='input-group'>
					<span class='input-group-addon'> จาก :</span>
					<input type='text' class='form-control' name='from_date' id='from_date'  value='";
					 if(isset($_POST['from_date']) && $_POST['to_date'] && $_POST['from_date'] && $_POST['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($from_date));} elseif(isset($_GET['from_date']) && $_GET['to_date'] && $_GET['from_date'] && $_GET['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($from_date));} else { echo "เลือกวัน";} 
					 echo "'/>
				</div>			
				</div>
				<div class='col-lg-2'>
				<div class='input-group'>
					<span class='input-group-addon'>ถึง :</span>
				 <input type='test' class='form-control'  name='to_date' id='to_date' value='";
				  if(isset($_POST['from_date']) && $_POST['to_date'] && $_POST['from_date'] && $_POST['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($to_date));} elseif(isset($_GET['from_date']) && $_GET['to_date'] && $_GET['from_date'] && $_GET['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($to_date));} else { echo "เลือกวัน";}  echo"' />
				</div>
				</div>
				<input type='hidden' name='carid' value='$carid' />
				<div class='col-lg-1'>
					<button type='button' class='btn btn-default' onclick='validate()'>แสดง</button>
				</div>
							
					</form>
                 
                </div>
                <!-- /.col-lg-12 -->
				<hr />";
?>
                          <!-- /.col-lg-12 -->
           
            <!-- /.row -->
			
<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                            <h4>ตารางการเดินทาง <? if($from_date == ""){ echo date('d-m-Y',strtotime($today));}else{ echo "".date('d-m-Y',strtotime($from_date))." ถึง ".date('d-m-Y',strtotime($to_date));}?> </h4>
                        </div>
						
                        <div class="panel-body">
                        
						<table class="table table-bordered table-hover">
							<thead align="center">
								<td width="5%">NO.</td><td width="25%">ชิ้นงาน</td><td width="15%">เลขที่</td><td width="20%">ร้าน</td><td width="10%">ราคา</td><td width="25%">หมายเหตุ</td>
							</thead>
                             <? 
						  $sql = "SELECT * FROM tbl_issue LEFT JOIN tbl_order ON tbl_issue.id_order = tbl_order.order_id LEFT JOIN tbl_order_detail ON tbl_issue.id_order_detail = tbl_order_detail.detail_id LEFT JOIN tbl_problem ON tbl_issue.id_problem = tbl_problem.id_problem LEFT JOIN tbl_product ON tbl_order_detail.product_id = tbl_product.product_id LEFT JOIN tbl_shop ON tbl_order.shop_id = tbl_shop.shop_id where date_time BETWEEN '$from_date 00:00:00' and '$to_date 23:59:59'";
						  $result = dbQuery($sql);
							$row = dbNumRows($result);
							$i=0;
							$n=1;
							while($i<$row){
							$data = dbFetchArray($result);
							$shop_name= $data['shop_name'];
							$product_name = $data['product_name'];
							$order_no = $data['order_no'];
							$price = $data['price'];
							$problem_name = $data['problem_name'];
						echo "<tr><td>$n</td><td>$product_name</td><td>$order_no</td><td>$shop_name</td><td>$price</td><td>$problem_name</td></tr>";
                          $i++;
						  $n++;
							}
                           ?>
						</table>    
                        </div>
                        <div class="panel-footer">
                            Panel Footer
                        </div></div>
