<?php  
	
	if(isset($_GET['order_id'])){
		$order_id =  $_GET['order_id'];
		
	}else{
		$order_id = "not define OrderID";
	}
	$query= dbQuery("select  order_no from tbl_order where order_id=".$order_id);
	 $qureyResult = dbFetchArray($query);
	 $order_no = $qureyResult['order_no'];
	 $status = 2;
	?>
<div class="container">
	
	<form method="post" action="submit_barcode.php?action=order" id="submit_order_code">
    <table border="0">
    	<tr>
        	<td width="20%"><h4><span class="alert alert-success"><? echo  "Order No :".$order_no;?></span></h4></td>
            <td width="50%"><input type="text" class="form-control" name="order_code" id="order_code">
        		<input type="hidden" name="order_id" id="order_id" value="<? echo $order_id; ?>"  /><input type="hidden" name="status"  value="<? echo $status; ?>"  /></td>
        	<td width="10%"><input type="submit" class="form-control"  value="Save"></td>
        </tr>
     </table>
     </form>
     <hr style="margin-top:10px; margin-bottom:10px;" />

        <table border="0" width="100%"><tr><td width="50%"><h4>Select Porduct</h4></td><td width="50%"><h4>Apply Barcode</h4></td></tr></table><hr style="margin-top:10px; margin-bottom:10px;" />
   
    <div class="row"> 
    
    <?php 
		$sql = "SELECT * FROM tbl_order_detail  WHERE order_id=".$order_id." AND tbl_order_detail.product_code='' ";
		$result = mysql_query($sql );
		$row = mysql_num_rows($result);	
		if($row<1){
							echo "<div class='col-sm-12'><h3><div class='alert alert-success'>No more product to apply barcode in this order.</div></h3></div>
									 <div class='col-sm-2 col-sm-offset-5'><input type='button' class='btn btn-default' onclick='applyBarcode()' value='Go Back' /></div>";
} else{ 
			echo "		<form method='post' action='submit_barcode.php?action=product' id='submit_product_code'>
							<div class=\"col-sm-6\"><div class='row'><div class=\"col-sm-9\">
							<input type=\"text\" name=\"product_code\" class=\"form-control\">
							<input type=\"hidden\" name=\"order_id\" value=\"".$order_id." \" />
							<input type='hidden' name='status'  value=".$status."  /></div>
							<div class=\"col-sm-3\"><input type=\"submit\"  class=\"form-control\" value=\"OK\"></div></div><hr style='margin-top:10px; margin-bottom:10px;' />
							<select multiple=\"multiple\" class=\"form-control\"  size='15' name=\"detail_id\" id=\"\detail_id\">";

    								  												
												$i=0;												
													while($i<$row){
														$option = dbFetchArray($result);
														$detail_id = $option['detail_id'];
														$product_id = $option['product_id'];
														$product =dbQuery("select product_name from tbl_product where product_id =".$option['product_id']);
														$products = dbFetchArray($product);
														$product_name = $products['product_name'];
														echo "<option value=\"".$detail_id."\">".$product_name."</option>";
														$i++;
													}
								echo "</select></div></form> "; 
												
											
                                            
  										echo"<div class=\"col-sm-6\"><div class=\"list-gorup\">
  											<div class='list-group-item' style=\"height:320px;\"><table width=\"100%\">";
													
													$query = "SELECT * FROM tbl_order_detail  WHERE order_id=".$order_id." AND product_code <>'' ";
													$data = mysql_query($query );
													$data_row = mysql_num_rows($data);	
													$is=0;												
													while($is<$data_row){
														$options = mysql_fetch_array($data);
														$detail_ids = $options['detail_id'];
														$product_id2 = $options['product_id'];
														$product_code = $options['product_code'];
														$product2 =dbQuery("select product_name from tbl_product where product_id =".$product_id2);
														$products2 = dbFetchArray($product2);
														$product_name2 = $products2['product_name'];
														echo "<tr><td width='85%' align='left' >".$detail_ids."    :   ".$product_code."     :     ".$product_name2."</td><td align='right' width='15%'><a href='#'  onclick='delete_product_code(".$detail_ids.",".$order_id.")'><button type='button' class='btn btn-default'>Delete</button></a></td></tr>";
														$is++;
													}

													
                                                  echo"  </table>";
}
													?>
                                                    </div>
                                                    </div>
    </div>                                        
                                      
   </div>

    </div><!-- /.container -->