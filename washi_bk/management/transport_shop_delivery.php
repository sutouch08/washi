<?
include "report_function.php"; 
 $today = date('Y-m-d');
			if(isset($_POST['from_date'])){
			//$to_date= date('Y-m-d',strtotime($_POST['to_date']));
			$from = $_POST['from_date'];
			if($from == "เลือกวัน"){
				$from_date = $today;
			}else{$from_date = date('Y-m-d',strtotime($_POST['from_date']));}
			}else{
				//$to_date= '';
				$from_date = $today;
			}
			 ?>
<!--   Page title   --->
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">รายงานการขนส่งประจำวัน</h1>
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
	if(checked==0){
		alert ("คุณยังไม่ได้เลือกร้าน");
	}else{
		$("#form").submit();
	}
}	
      </script>
      <? 
$selected =0;
$view = 0;
if(isset($_POST['shop_id'])){
	$shop_id = $_POST['shop_id'];
	$selected = $_POST['shop_id'];

	$shop_name = getShopName($shop_id);
}
?>
 <? require "fillter_shop.php"; ?>
                    <hr />
			
				<div class="row">
				<div class="col-lg-8">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                            <h4>ส่งผ้า <?  if(isset($_POST['shop_id'])){
								$shop_id = $_POST['shop_id'];
						  $sql2 = "SELECT * FROM tbl_shop where shop_id = '$shop_id'";
						  $result2 = dbQuery($sql2);
						  $data2 = dbFetchArray($result2);
						 echo $data2['shop_name']; ?> : <?  if($from_date != "$today"){ echo date('d-m-Y',strtotime($from_date));} else { echo date('d-m-Y',strtotime($today));}} ?></h4>
                        </div>
						
                        <div class="panel-body">
                            <table width="100%" class="table table-bordered" >
                            <tr>
                            <td width="10%" align="center"><h4>ลำดับ</h4></td>
                            <td width="30%"><h4>ทะเบียน</h4></td>
                            <td width="15%" align="center"><h4>ผู้ขับ</h4></td>
                            <td width="15%" align="center"><h4>น้ำหนัก</h4></td>
                            <td width="20%" align="center"><h4>เวลารับ/ส่ง</h4></td>
                            </tr>
                         <? 
						 if(isset($_POST['from_date'])){
						  $shop_id = $_POST['shop_id'];
						  $sql = "SELECT * FROM tbl_delivery LEFT JOIN tbl_driver ON tbl_delivery.driver_id = tbl_driver.driver_id LEFT JOIN tbl_car ON tbl_delivery.car_id = tbl_car.car_id where shop_id = '$shop_id' and delivery_date LIKE '%$from_date%' and status IN (3,4) ";
						  $result = dbQuery($sql);
							$row = dbNumRows($result);
							$i=0;
							$n=1;
							while($i<$row){
							$data = dbFetchArray($result);
							$delivery_id = $data['delivery_id'];
							$car_plate= $data['car_plate'];
							$driver_name = $data['driver_name'];
							$delivery_date = $data['delivery_date'];
							$sql1 = "SELECT * FROM tbl_delivery_detail LEFT JOIN tbl_order ON tbl_delivery_detail.order_id = tbl_order.order_id where delivery_id = '$delivery_id'";
						  $result1 = dbQuery($sql1);
						  $row1 = dbNumRows($result1);
						  $i1=0;
						  $sum_qty = '';
							while($i1<$row1){
						  $data1 = dbFetchArray($result1);
						  $order_qty =$data1['order_qty'];
						  $sum_qty = $sum_qty + $order_qty;
						  
						   $i1++;
							}
						  ?>
                            <tr>
                            <td align="center"><?=$n;?></td>
                            <td><?=$car_plate;?></td>
                            <td align="center"><?=$driver_name;?></td>
                            <td align="center"><?=$sum_qty;?></td>
                            <td align="center"><?=$delivery_date;?></td>
                            </tr>
                            <?
                          $i++;
						  $n++;
							}
						 }
                           ?>
                            </table>
                        </div>
                        <div class="panel-footer">
                            Panel Footer
                        </div></div><br />
<br />

 <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>รับผ้า <?  if(isset($_POST['shop_id'])){
								$shop_id = $_POST['shop_id'];
						  $sql2 = "SELECT * FROM tbl_shop where shop_id = '$shop_id'";
						  $result2 = dbQuery($sql2);
						  $data2 = dbFetchArray($result2);
								 echo $data2['shop_name']; ?> : <?  if($from_date != "$today"){ echo date('d-m-Y',strtotime($from_date));} else { echo date('d-m-Y',strtotime($today));}} ?></h4>
                        </div>
						
                        <div class="panel-body">
                            <table width="100%" class="table table-bordered" >
                            <tr>
                            <td width="10%" align="center"><h4>ลำดับ</h4></td>
                            <td width="30%"><h4>ทะเบียน</h4></td>
                            <td width="15%" align="center"><h4>ผู้ขับ</h4></td>
                            <td width="15%" align="center"><h4>น้ำหนัก</h4></td>
                            <td width="20%" align="center"><h4>เวลารับ/ส่ง</h4></td>
                            </tr>
                         <? 
						 if(isset($_POST['from_date'])){
						  $shop_id = $_POST['shop_id'];
						  $sql = "SELECT * FROM tbl_delivery LEFT JOIN tbl_driver ON tbl_delivery.driver_id = tbl_driver.driver_id LEFT JOIN tbl_car ON tbl_delivery.car_id = tbl_car.car_id where shop_id = '$shop_id' and delivery_date LIKE '%$from_date%' and status IN (16) ";
						  $result = dbQuery($sql);
							$row = dbNumRows($result);
							$i=0;
							$n=1;
							while($i<$row){
							$data = dbFetchArray($result);
							$delivery_id = $data['delivery_id'];
							$car_plate= $data['car_plate'];
							$driver_name = $data['driver_name'];
							$delivery_date = $data['delivery_date'];
							$sql1 = "SELECT * FROM tbl_delivery_detail LEFT JOIN tbl_order ON tbl_delivery_detail.order_id = tbl_order.order_id where delivery_id = '$delivery_id'";
						  $result1 = dbQuery($sql1);
						  $row1 = dbNumRows($result1);
						  $i1=0;
						  $sum_qty = '';
							while($i1<$row1){
						  $data1 = dbFetchArray($result1);
						  $order_qty =$data1['order_qty'];
						  $sum_qty = $sum_qty + $order_qty;
						   $i1++;
							}
						  ?>
                            <tr>
                            <td align="center"><?=$n;?></td>
                            <td><?=$car_plate;?></td>
                            <td align="center"><?=$driver_name;?></td>
                            <td align="center"><?=$sum_qty;?></td>
                            <td align="center"><?=$delivery_date;?></td>
                            </tr>
                            <?
                          $i++;
						  $n++;
							}
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