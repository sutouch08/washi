<?
include "report_function.php"; 
?>
<!--   Page title   --->
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">สถิติลูกค้า</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<div class="row">
                <div class="col-lg-12">
					

                 <hr />
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			
<div class="row">
				<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>รายงานสถิติลูกค้า</h4>
                        </div>
                        <div class="panel-body">
                          <table width="100%" class="table table-bordered">
                          <tr>
                          <td width="10%" align="center"><h4>ลำดับ</h4></td>
                          <td width="15%"><h4>รายชื่อ</h4></td>
                          <td width="15%"><h4>ร้าน</h4></td>
                          <td width="20%"><h4>ที่อยู่</h4></td>
                          <td width="10%" align="right"><h4>จำนวนครั้ง</h4></td>
                          <td width="10%" align="right"><h4>ยอดเงินสะสม</h4></td>
                          </tr>
                          <? 
						  $sql = "SELECT * FROM tbl_customer ORDER BY customer_name ASC  ";
						  $result = dbQuery($sql);
							$row = dbNumRows($result);
							$i=0;
							$n=1;
							while($i<$row){
							$data = dbFetchArray($result);
							$customer_id = $data['customer_id'];
							$customer_name = $data['customer_name'];
							$customer_address = $data['customer_address'];
							$shop_id = $data['shop_id'];
							$sql2 = "SELECT * FROM tbl_shop where shop_id = '$shop_id'";
						    $result2 = dbQuery($sql2);
							$data2 = dbFetchArray($result2);
							$shop_name = $data2['shop_name'];
							$sql1 = "SELECT * FROM tbl_order where customer_id = '$customer_id'";
						    $result1 = dbQuery($sql1);
							$row1 = dbNumRows($result1);
							$i1=0;
							$sum_order_amout = '';
							while($i1<$row1){
							$data1 = dbFetchArray($result1);
							$order_amount =$data1['order_amount'];
							$sum_order_amout = $sum_order_amout + $order_amount;
							$i1++;
							}
						  ?>
                          <tr>
                          <td align="center"><?=$n;?></td>
                          <td><?=$customer_name;?></td>
                          <td><?=$shop_name;?></td>
                          <td><?=$customer_address;?></td>
                          <td align="right"><?=$row1;?></td>
                          <td align="right"><?=$sum_order_amout;?></td>
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