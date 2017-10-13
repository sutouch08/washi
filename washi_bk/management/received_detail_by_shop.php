
<?
include "report_function.php"; 
if(isset($_GET['shop_id'])){
								$shop_id = $_GET['shop_id'];
								$view = $_GET['view'];
								$from_date = $_GET['from'];
								$to_date = $_GET['to'];
								$shop_name = getShopName($shop_id);
								$page= $_GET['page'];
}

?>

<!--   Page title   --->
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">รายงานยอดขาย</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>รายละเอียดงานที่ส่งแล้ว &nbsp;ร้าน&nbsp;&nbsp;  <?  if(isset($shop_id)){ echo $shop_name;} ?>&nbsp;&nbsp; &nbsp; <?  if(isset($shop_id)){ echo showRang($view,$from_date,$to_date);} ?></h4>
                        </div>
                        <div class="panel-body">
						<table class="table table-bordered table-hover">
							<thead align="center">
								<td width="10%">ลำดับ</td><td width="15%">Order No.</td><td width="15%">จำนวน(ชิ้น)</td><td width="15%">จำนวนเงิน</td><td width="15%">ลูกค้า</td><td width="15%">วันที่รับงาน</td><td width="15%">วันที่นัดส่ง</td>
							</thead>
							<? 
								if(isset($_GET['shop_id'])){
								$shop_id = $_GET['shop_id'];
								$view = $_GET['view'];
								$from_date = $_GET['from'];
								$to_date = $_GET['to'];
								$query = getReceivedDetailByShop($shop_id, $view, $from_date, $to_date);
								$row = dbNumRows($query);
								$i = 0;
								$n = 1;
								while($i < $row){
									$data = dbFetchArray($query);
									$order_no = $data['order_no'];
									$order_qty = number_format($data['order_qty']);
									$order_amount = number_format($data['order_amount']);
									$customer_name = $data['customer_name'];
									$order_date = $data["order_date_time"];
									$order_due =  $data["order_due"];
									echo "<tr><td align='center'>$n</td><td align='center'>$order_no</td><td align='right'>$order_qty</td><td align='right'>$order_amount</td>
									<td>$customer_name</td><td align='center'>".date('d/m/Y',strtotime("$order_date"))."</td><td align='center'>".date('d/m/Y',strtotime("$order_due"))."</td></tr>";
									$i++;
									$n++;
								}
								}
								?>
							
						</table>    
                        </div><div class="panel-footer"><a href="<? echo"index.php?content=$page&shop_id=$shop_id&view=$view&from_date=$from_date&to_date=$to_date";?>"><button type="button" class="btn btn-primary">Go Back</button></a></div>
                        
                    </div>
                </div>
                
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->