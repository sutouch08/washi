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
                    <h1 class="page-header">สรุปการขนส่งของร้านค้า</h1>
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
                 <hr />                <!-- /.col-lg-12 -->
           
            <!-- /.row -->
			
<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                      <div class="panel-heading">
                            <h4>รายการค้างส่ง <?  if(isset($_POST['shop_id'])){
								$shop_id = $_POST['shop_id'];
						  $sql2 = "SELECT * FROM tbl_shop where shop_id = '$shop_id'";
						  $result2 = dbQuery($sql2);
						  $data2 = dbFetchArray($result2);
								 echo $data2['shop_name'];} ?> </h4>
                        </div>
						
                        <div class="panel-body">
                            <table width="100%"  class="table table-bordered" >
                            <tr>
                            <td width="10%" align="center"><h4>ลำดับ</h4></td>
                            <td width="30%"><h4>รายการ</h4></td>
                            <td width="15%" align="center"><h4>ปริมาณชิ้น</h4></td>
                            <td width="15%" align="center"><h4>น้ำหนัก</h4></td>
                            <td width="20%" align="center"><h4>วันที่ต้องการสินค้า</h4></td>
                            <td width="10%" align="center"><h4>ระยะเวลาทำงาน</h4></td>
                            </tr>
                         <? 
						 if(isset($_POST['from_date'])){
							 $shop_id = $_POST['shop_id'];
						  $sql = "SELECT * FROM tbl_order LEFT JOIN tbl_urgent ON tbl_order.urgent_id = tbl_urgent.urgent_id where status IN (6,7,8,9) and shop_id = '$shop_id' ORDER BY  `tbl_urgent`.`urgent_id` DESC ";
						  $result = dbQuery($sql);
							$row = dbNumRows($result);
							$i=0;
							$n=1;
							while($i<$row){
							$data = dbFetchArray($result);
							$order_no= $data['order_no'];
							$order_qty = $data['order_qty'];
							$weight = $data['weight'];
							$order_due = $data['order_due'];
							$order_date_time = $data['order_date_time'];
						  ?>
                            <tr>
                            <td align="center"><?=$n;?></td>
                            <td><?=$order_no;?></td>
                            <td align="center"><?=$order_qty;?></td>
                            <td align="center"><?=$weight;?></td>
                            <td align="center"><?=$order_due;?></td>
                            <td align="center"><? echo "".DateDiff("$today","$order_due");?></td>
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
                            <h4>รายการที่ส่งแล้ว <?  if(isset($_POST['shop_id'])){
								$shop_id = $_POST['shop_id'];
						  $sql2 = "SELECT * FROM tbl_shop where shop_id = '$shop_id'";
						  $result2 = dbQuery($sql2);
						  $data2 = dbFetchArray($result2);
								 echo $data2['shop_name']; ?> : <? if($from_date != "$today"){ echo date('d-m-Y',strtotime($from_date));} else { echo date('d-m-Y',strtotime($today));}} ?></h4>
                        </div>
						
                        <div class="panel-body">
                            <table width="100%"  class="table table-bordered" >
                            <tr>
                            <td width="10%" align="center"><h4>ลำดับ</h4></td>
                            <td width="30%"><h4>รายการ</h4></td>
                            <td width="15%" align="center"><h4>ปริมาณชิ้น</h4></td>
                            <td width="15%" align="center"><h4>น้ำหนัก</h4></td>
                            <td width="20%" align="center"><h4>วันที่ต้องการสินค้า</h4></td>
                            <td width="10%" align="center"><h4>ระยะเวลาทำงาน</h4></td>
                            </tr>
                         <? 
						 if(isset($_POST['from_date'])){
						 $shop_id = $_POST['shop_id'];
						  $sql = "SELECT * FROM tbl_delivery_detail LEFT JOIN tbl_delivery ON tbl_delivery_detail.delivery_id = tbl_delivery.delivery_id LEFT JOIN tbl_order ON tbl_delivery_detail.order_id = tbl_order.order_id where delivery_date LIKE '%$from_date%' and tbl_delivery.shop_id = '3' and tbl_order.shop_id = '$shop_id'";
						  $result = dbQuery($sql);
							$row = dbNumRows($result);
							$i=0;
							$n=1;
							while($i<$row){
							$data = dbFetchArray($result);
							$order_no= $data['order_no'];
							$order_qty = $data['order_qty'];
							$weight = $data['weight'];
							$order_due = $data['order_due'];
							$order_date_time = $data['order_date_time'];
						  ?>
                            <tr>
                            <td align="center"><?=$n;?></td>
                            <td><?=$order_no;?></td>
                            <td align="center"><?=$order_qty;?></td>
                            <td align="center"><?=$weight;?></td>
                            <td align="center"><?=$order_due;?></td>
                            <td align="center"><? echo "".DateDiff("$today","$order_due");?></td>
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