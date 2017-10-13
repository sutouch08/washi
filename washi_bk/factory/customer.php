<div class="container">
<div class="col-sm-12">
    <table class="table table-hover">
    <thead>
    <tr ><td width="5%"><h4>#</h4></td><td width="30%"><h4>ชื่อลูกค้า</h4></td><td width="10%"><h4>code</h4></td><td width="10%"><h4>เบอร์โทร</h4></td><td width="5%"></td></tr></thead>   
      <?php 
	  $shop_id = $_COOKIE['shop_id'];
	    $sql = "SELECT * FROM tbl_customer where shop_id = '$shop_id' ORDER BY customer_name ASC";
		$result = dbQuery($sql);
		$row = dbNumRows($result);
		if($row<1){
							echo "<tr><td colspan='9'><h3><div class='alert alert-success'>No more product to apply barcode in this order.</div></h3></td></tr>
									 <tr><td colspan='9'><button type='button' class='btn btn-default' onclick='backHome()' value='Go Back' />Go back</td></tr>";
} else{ 
		$i=0;
		$no=1;
		while($i<$row){
		$data = dbFetchArray($result);
		$customer_id = $data['customer_id'];
		$customer_name = $data['customer_name'];
		$customer_phone = $data['customer_phone'];
		$customer_address = $data['customer_address'];
		$customer_email = $data['customer_email'];
		$customer_code = $data['customer_code'];
		
		
		echo  "<tr><td>";
		echo "".$no."</td><td  align=left>".$customer_name."</td><td>".$customer_code."</td><td>".$customer_phone."</td><td><a style='color:red;' href='index.php?content=customer_detail&customer_id=$customer_id' ><button type=\"button\" name=\"button\" id=\"button\"  class=\"btn btn-default btn-xs\" >รายละเอียด</button></a></td></tr>";																										
	$i++;
	$no++;
																		}
}
																																	
		?>
        </table>
     
</div>
</div>