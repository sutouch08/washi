<?
include "report_function.php"; 
$today = date('Y-m-d');
			if(isset($_POST['from_date'])&& $_POST['to_date']){
				$to = $_POST['from_date'];
				$from = $_POST['from_date'];
				if($to == "เลือกวัน"){
					$to_date= $today;
				$from_date = $today;
					if($from == "เลือกวัน"){			
				$to_date= $today;
				$from_date = $today;
					}else{
					$to_date= date('Y-m-d',strtotime($_POST['to_date']));
			$from_date = date('Y-m-d',strtotime($_POST['from_date']));
					}
					}else{
			$to_date= date('Y-m-d',strtotime($_POST['to_date']));
			$from_date = date('Y-m-d',strtotime($_POST['from_date']));
					}
			}else if(isset($_GET['from_date'])&& $_GET['to_date']){
			$to_date= date('Y-m-d',strtotime($_GET['to_date']));
			$from_date = date('Y-m-d',strtotime($_GET['from_date']));
			}else{
				$to_date= $today;
				$from_date = $today;
			}
?>

<!--   Page title   --->
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">รายงานสรุปการขนส่ง</h1>
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
<div class="row">
              <form action="#" method="post" id="form">
<? echo "<div class='col-lg-2'>
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
				<div class='col-lg-1'>
					<button type='button' class='btn btn-default' onclick='validate()'>แสดง</button>
				</div>";?>
					</form>
                 <hr />
            
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
<div class="row">
				<div class="col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                           <h4> รายงานสรุปการขนส่ง </h4>
                        </div>
                        <div class="panel-body">
					<table width="100%" class="table table-bordered">
                    <tr>
                    <td width="10%" align="center"><h4>ลำดับ</h4></td>
                    <td width="50%" align="center"><h4>รายการ</h4></td>
                    <td width="40%" align="center"><h4>จำนวนรายการ</h4></td>
                    </tr>
                    <tr>
                    <td align="center">1</td>
                    <td><a href="index.php?content=factory_delivery2&cate=1&from_date=<?=$from_date;?>&to_date=<?=$to_date;?>">รายการที่รับมาทั้งหมด</a></td>
                    <td align="center"><?  
					$sql = "SELECT * FROM tbl_order where order_date_time BETWEEN '$from_date' AND '$to_date'";
						    $result = dbQuery($sql);
							$row = dbNumRows($result);
							echo $row;
							?>
                            </td>
                    </tr>
                    <tr>
                    <td align="center">2</td>
                    <td><a href="index.php?content=factory_delivery2&cate=2&from_date=<?=$from_date;?>&to_date=<?=$to_date;?>">รายการที่ส่งไปร้านแล้ว</a></td>
                    <td align="center"><?  
					
					$sql = "SELECT * FROM tbl_order where order_date_time BETWEEN '$from_date' AND '$to_date' and status IN (13,14,15,16,17) ";
						    $result = dbQuery($sql);
							$row = dbNumRows($result);
							echo $row;

							?></td>
                    </tr>
                    <tr>
                    <td align="center">3</td>
                    <td><a href="index.php?content=factory_delivery2&cate=3&from_date=<?=$from_date;?>&to_date=<?=$to_date;?>">รายการที่ค้างส่งไปร้าน</a></td>
                    <td align="center"><?  
							$sql = "SELECT * FROM tbl_order where order_date_time BETWEEN '$from_date' AND '$to_date' and status IN (6,7,8,9)";
						    $result = dbQuery($sql);
							$row = dbNumRows($result);
							echo $row;
	
							?></td>
                    </tr>
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
						$sql1 = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date'";
						$detail = "รายการที่รับมาทั้งหมด";
					}else if($cate == "2"){
						$sql1 = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date' and status IN (13,14,15,16,17)";
						$detail = "รายการที่ส่งไปร้านแล้ว";
					}else if($cate == "3"){
						$sql1 = "SELECT * FROM tbl_order LEFT JOIN tbl_customer ON tbl_order.customer_id = tbl_customer.customer_id where order_date_time BETWEEN '$from_date' AND '$to_date' and status IN (6,7,8,9)";
						$detail = "รายการที่ค้างส่งไปร้าน";
					}
					?>
           			
                <!-- /.col-lg-12 -->
                <div class="col-lg-7">
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
            </div>     </div>
            <!-- /.row -->