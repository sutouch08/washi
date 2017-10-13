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
                          <? 
						$head_qr = dbQuery("select * from tbl_car order by car_id asc");
						$head_row = dbNumRows($head_qr);
						$head_i = 0;
						?>
						<table class="table table-bordered table-hover">
							<thead align="center">
								<td width="20%">วัน เวลา / ร้าน</td>
								<? 
									while($head_i<$head_row){
										$head = dbFetchArray($head_qr);
										$car_plate = $head['car_plate'];
										echo"<td align='center'>$car_plate</td>";
										$head_i++;
									}
									?>
							</thead>
							<? // if(isset($_POST['view']) || isset($_POST['from_date'])){
									$shop_qr = dbQuery("SELECT * FROM tbl_delivery where delivery_date BETWEEN '$from_date 00:00:00' and '$to_date 23:59:59'");
									$shop_row = dbNumRows($shop_qr);							
									$shop_i = 0;
									$shop_n = 1;
									while($shop_i<$shop_row){
										$data = dbFetchArray($shop_qr);
										$delivery_id = $data['delivery_id'];
										$delivery_date = $data['delivery_date'];
										$shop_id = $data['shop_id'];
										
										$shop = dbQuery("SELECT * FROM tbl_shop where shop_id = '$shop_id'");
										$data_shop = dbFetchArray($shop);
										$shop_name = $data_shop['shop_name'];
										$type_qr = dbQuery("SELECT * FROM tbl_car order by car_id asc");
										$type_row = dbNumRows($type_qr);
										$total_qty = 0;
										$type_i = 0;
										echo "<tr><td>$delivery_date / $shop_name</td>";
										while($type_i<$type_row){
										$data_type = dbFetchArray($type_qr);
										$car_id = $data_type['car_id'];
										$shop_qr1 = dbQuery("SELECT * FROM tbl_delivery where delivery_id = '$delivery_id' and car_id = '$car_id'");
										$shop_row1 = dbNumRows($shop_qr1);
										if($shop_row1 > "0"){
										echo "<td align='center'><span class='glyphicon glyphicon-ok'></span></td>";
										}else{
										echo "<td align='center'></span></td>";
										}
										$type_i++;
										}
										$shop_i++;
										$shop_n++;
									}
									?>	
							<tr>	
				
					
						</table>    
                        </div>
                        <div class="panel-footer">
                            Panel Footer
                        </div></div>
<hr />

<div class="row">
			<form  method="post" id="form" >
				<div class="col-lg-3">
				<div class="input-group">
					<span class="input-group-addon"> ทะเบียน :</span>
					 <select class="form-control" name="carid" id="carid" onChange="form.submit()">
                     <option value="">เลือกรถ</option>
                     <?
						$qr = dbQuery("select * from tbl_car order by car_id asc");
						$row = dbNumRows($qr);
						$i = 0;
                        while($i<$row){
										$head = dbFetchArray($qr);
										$car_plate = $head['car_plate'];
										$car_id = $head['car_id'];
										echo "<option value='$car_id'"; if($carid=="$car_id"){echo "selected='selected'";} echo ">$car_plate</option>";
										$i++;
									}
									?>
					</select>
                    <?php if($from == "เลือกวัน"){?>
                    <input type="hidden" name="view" value="<?=$view;?>" />
                    <input type="hidden" name="from_date" value="เลือกวัน" />
                    <input type="hidden" name="to_date" value="เลือกวัน"  />
                    <?php }else{?>
                    <input type="hidden" name="from_date" value="<?=$from_date;?>" />
                    <input type="hidden" name="to_date" value="<?=$to_date;?>"  />
                    <?php }?>
				</div>
				</div>
                </form>
                </div>
<hr />
</div>
<div class="col-lg-6">
 <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>ตารางการเดินทาง  <? if($from_date == ""){ echo date('d-m-Y',strtotime($today));}else{ echo "".date('d-m-Y',strtotime($from_date))." ถึง ".date('d-m-Y',strtotime($to_date));}?> </h4>
                        </div>
						
                        <div class="panel-body">
                    
                            <table width="50%"  class="table table-bordered" >
                            <tr>
                            <td width="50%" align="center"><h4>วัน / เวลา</h4></td>
                            <td width="50%" align="center"><h4>ร้าน</h4></td>
		                     </tr>
                   <? 
						  $sql = "SELECT * FROM tbl_delivery LEFT JOIN tbl_shop ON tbl_delivery.shop_id = tbl_shop.shop_id where delivery_date BETWEEN '$from_date 00:00:00' and '$to_date 23:59:59' and car_id = '$carid'";
						  $result = dbQuery($sql);
							$row = dbNumRows($result);
							$i=0;
							$n=1;
							while($i<$row){
							$data = dbFetchArray($result);
							$shop_name= $data['shop_name'];
							$delivery_date = $data['delivery_date'];
						  ?>
                            <tr>
                            <td align="center"><?=$delivery_date;?></td>
                            <td align="center"><?=$shop_name;?></td>
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