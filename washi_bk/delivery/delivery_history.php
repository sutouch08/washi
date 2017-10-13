    <div class="container">
   
     <?
							$qr_c =dbQuery("SELECT * FROM tbl_car ORDER BY car_id ASC");	
							$row_c =@mysql_num_rows($qr_c);
							 $ic=0;
							while ($ic<$row_c){
							$rs_c=mysql_fetch_array($qr_c);
							$car_id = $rs_c['car_id'];
							$car_plate = $rs_c['car_plate'];
						$ics = $ic+1;
						if($ics%2 == "1"){	
	
    	  					echo "<div class=row>  <hr>";
						}
     ?> 
     	<div class="col-md-6">
    <table class="table table-hover">
    <thead>
    <tr>
                    	<td colspan="8"><? echo $car_plate;?></td>
                    </tr>
    <tr ><td width="5%">#</td><td width="20%">Order No.</td><td width="5%">Qty.</td><td width="5%">Amount</td><td width="25%">Order Date</td>
    <td width="25%">Due Date</td><td width="15%">Target</td></tr></thead>
     <?php  
							$qr_x =dbQuery("SELECT * FROM tbl_delivery_detail  LEFT JOIN tbl_delivery ON tbl_delivery_detail.delivery_id = tbl_delivery.delivery_id LEFT JOIN tbl_order ON tbl_delivery_detail.order_id = tbl_order.order_id where tbl_delivery.car_id = '$car_id'   ORDER BY delivery_detail_id DESC");	
							$row =@mysql_num_rows($qr_x);
							 $i=0;
							
							while ($i<$row){
							$rs_x=mysql_fetch_array($qr_x);
							$order_no = $rs_x['order_no'];
							$order_qty = $rs_x['order_qty'];
							$order_amount = $rs_x['order_amount'];
							$order_due = $rs_x['order_due'];
							$urgent_id = $rs_x['urgent_id'];
							$order_date_time = $rs_x['order_date_time'];
							$target_id = $rs_x['target_id'];
							$qr_t =dbQuery("SELECT * FROM tbl_target where target_id = '$target_id'");	
							$rs_t=mysql_fetch_array($qr_t);
							$target_name = $rs_t['target_name'];
							$qr_u =dbQuery("SELECT * FROM tbl_urgent where urgent_id = '$urgent_id'");	
							$rs_u=mysql_fetch_array($qr_u);
							$urgent_name = $rs_u['urgent_name'];
							
				?><tr >
                <td><?=$i+1;?></td>
                <td><?=$order_no;?></td>
                <td><?=$order_qty;?></td>
                <td><?=$order_amount;?></td>
                <td><?=$order_date_time;?></td>
   				<td><?=$order_due;?></td>
                <td><?=$target_name;?></td>
                </tr>
                    <?
					$i++;
							}
					?>
                </table>
            </div><!----- /.col-md-6 ------>   
    
    
    
    
     <? 
		if($ic=="$row_c"){
			echo "</div>";
		}
		if($ics%2 == "0"){
		echo "</div>";//<!-----/.row---->
		}
	    $ic++;
		}
		?>

    
    </div>