<?php
checkPermission(); 
//สร้าง dropdown seclet category
function categoryDropdown()
{
	$result = dbQuery("select * from tbl_process_category ");
	$row= dbNumRows($result);
	$i=0;
	while($row>$i)
	{
		$data = dbFetchArray($result);
		$cate_id = $data['process_category_id'];
		$cate_name = $data['process_category_name'];
		echo "<option value='$cate_id'>$cate_name</option>";
		$i++;
	}
}
function typeDropdown()
{
	$result = dbQuery("select * from tbl_type");
	$row= dbNumRows($result);
	$i=0;
	while($row>$i)
	{
		$data = dbFetchArray($result);
		$type_id = $data['type_id'];
		$type_name = $data['type_name'];
		echo "<option value='$type_id'>$type_name</option>";
		$i++;
	}
}
	
?>
<script src="../library/js/jquery-1.9.1.js"></script>
<script src="../library/js/bootstrap.js"></script>
<script>
$(document).ready(function(){
	$("#product_name").keyup(function(){
		var product_name = $("#product_name").val();
		$.ajax({	
			type: "GET", 
			url:"product_process.php",
			cache:false, data:"product_name="+product_name,
			success: function(msg)	{
				if( $("#product_name").val().length >3){
						if(msg==1){
							$("#valid").val(msg);
							$("#validate").html("<img src='../images/not.jpg'>");
						}else if(msg==0){
							$("#valid").val(msg);
							$("#validate").html("<img src='../images/checked.png'>");
						}
				}else{ 
					$("#validate").html("<img src='../images/space.png'>");
				}
			}
		});
	});
});
function validate()
{
	var checked = $("#valid").val();
	var productName = $("#product_name").val().length;
	var price = $("#price").val();
	if(checked==1){
		alert ("product name already exist");
	}else if(productName ==""){
		alert("Please fill out Product name fild.");
	}else if(productName<4){
		alert ("Product name must be at least 4 letters");
	}else if(price ==""){
		alert("Please fill out Price.");
	}else{
		$("#product_form").submit();
	}
}	
</script>
<div class="container">
<div class="col-sm-12">
<h1 style="margin-top:0px; margin-bottom:0px;"><? echo $pageTitle; ?></h1>
<hr />
<form action='product_process.php?add=y' method="post" id="product_form" autocomplete="off">
<table width="100%" border="0px"><input type="hidden" id="valid"  />
	<tr height="50">
		<td width="5%" align="right">สินค้า :&nbsp;</td>
		<td width="23%" align="left"><input type="text" class="form-control" name="product_name" id="product_name" placeholder="สินค้า" required="required" autofocus="autofocus" /></td>
		<td width="2%" id="validate"><img src="../images/space.png" /></td>
		<td width="5%">ราคา : &nbsp;&nbsp;</td>
		<td width="10%"><input type="text" class="form-control" name="price" id="price" placeholder="ราคา" required="required" /></td>
		<td width="5%" align="right">น้ำหนัก :&nbsp;</td>
		<td width="10%" align="left"><input type="text" class="form-control" name="weight" id="weight" placeholder="น้ำหนัก" /></td>
		<td width="10%" align="right">หมวดหมู่ :&nbsp; </td><td width="15%" align="left"><select class="form-control" name="category"><? categoryDropdown(); ?></select></td>
		<td width="10%" align="left"></td>
	</tr>
    <tr height="50">
    	<td width="5%" align="right">ประเภท : </td>
        <td width="23%"><select class="form-control" name="type_id"><? typeDropdown(); ?></select></td>
        <td colspan="6"></td>
        <td>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" onclick="validate()" >&nbsp;&nbsp;&nbsp;ADD&nbsp;&nbsp;&nbsp;</button></td>
    </tr>
</table>
</form>
<hr />
<!------------------------------------------------------------------- ตารางสินค้า--------------------------------------------------------------->
<table class="table table-hover">
	<thead>
			<td width="5%"><h4>#</h4></td><td width="35%"><h4>สินค้า</h4></td><td width="10%"><h4>ราคา</h4></td><td width="10%"><h4>น้ำหนัก</h4></td><td width="10%"><h4>หมวดหมู่</h4></td><td width="10%"><h4>ประเภท</h4></td><td colspan="2"><h4>Action</h4></td>
	</thead>
	<?php 
			$query=dbQuery("SELECT * FROM tbl_product LEFT JOIN tbl_process_category ON tbl_product.process_category_id = tbl_process_category.process_category_id LEFT JOIN tbl_type ON tbl_product.type_id = tbl_type.type_id");
			$rows = dbNumRows($query);
			$is=0;
			$n=1;
			while($rows>$is)
			{
				$datas = dbFetchArray($query);
				$product_id = $datas['product_id'];
				$product_name = $datas['product_name'];
				$price = $datas['price'];
				$weight = $datas['product_weight'];
				$category_id = $datas['process_category_id'];
				$type_id = $datas['type_id'];
				$type_name = $datas['type_name'];
				$category = $datas['process_category_name'];
				echo"<tr align='center'><td>$n
													<div class='modal fade' id=\"myModal".$n."\" tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
													 <div class='modal-dialog' style='width:900px;'>
													<div class='modal-content' style='width:900px;'>
												   <div class='modal-header' style='width:900px;'>
													<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
													<h4 class='modal-title' id='myModalLabel".$n."'>Edit Product</h4>
												    </div>
												    <div class='modal-body' style='width:900px;'>";?><script>
															$(document).ready(function(){
																$("#product_name<? echo $n; ?>").keyup(function(){
																	var product_name<? echo $n; ?> = $("#product_name<? echo $n; ?>").val();
																	$.ajax({	
																		type: "GET", 
																		url:"product_process.php",
																		cache:false, data:"product_name="+product_name<? echo $n; ?>,
																		success: function(msg)	{
																			if( $("#product_name<? echo $n; ?>").val().length >3){
																					if(msg==1){
																						$("#valid<? echo $n; ?>").val(msg);
																						$("#validate<? echo $n; ?>").html("<img src='../images/not.jpg'>");
																					}else if(msg==0){
																						$("#valid<? echo $n; ?>").val(msg);
																						$("#validate<? echo $n; ?>").html("<img src='../images/checked.png'>");
																					}
																			}else{ 
																				$("#validate<? echo $n; ?>").html("<img src='../images/space.png'>");
																			}
																		}
																	});
																});
															});
															function validate<? echo $n; ?>()
															{
																var checked<? echo $n; ?> = $("#valid<? echo $n; ?>").val();
																var productName<? echo $n; ?> = $("#product_name<? echo $n; ?>").val().length;
																var price<? echo $n; ?> = $("#price<? echo $n; ?>").val();
																if(checked<? echo $n; ?>==1){
																	alert ('product name already exist');
																}else if(productName<? echo $n; ?> ==""){
																	alert('Please fill out Product name fild.');
																}else if(productName<? echo $n; ?><4){
																	alert ('Product name must be at least 4 letters');
																}else if(price<? echo $n; ?> ==''){
																	alert('Please fill out Price.');
																}else{
																	$("#product_form<? echo $n; ?>").submit();
																}
															}	
															</script>
				<?
				echo"<form action='product_process.php?edit=y' method='post' id='product_form".$n."' autocomplete='off'>
				<table width='100%' border='0px'><input type='hidden' id='valid".$n."'  /><input type='hidden' name='product_id' value='$product_id' />
					<tr>
						<td width='5%' align='right'>สินค้า :</td>
						<td width='23%' align='left'><input type='text' class='form-control' name='product_name' id='product_name".$n."' value='$product_name' required='required' /></td>
						<td width='2%' id='validate".$n."'><img src='../images/space.png' /></td>
						<td width='5%'>ราคา :&nbsp;</td>
						<td width='10%'><input type='text' class='form-control' name='price' id='price".$n."' value='$price' required='required' /></td>
						<td width='10%' align='right'>น้ำหนัก :&nbsp;</td>
		<td width='10%' align='left'><input type='text' class='form-control' name='weight' id='weight' placeholder='น้ำหนัก' value='$weight' /></td>
						<td width='10%' align='right'>หมวดหมู่ :</td><td width='15%' align='left'><select class='form-control' name='category'>";
						
						$result = dbQuery("select * from tbl_process_category ");
						$row= dbNumRows($result);
						$i=0;
						while($row>$i)
						{
							$data = dbFetchArray($result);
							$cate_id = $data['process_category_id'];
							$cate_name = $data['process_category_name'];
							echo "<option value='$cate_id'";if($cate_id=="$category_id"){echo " selected='selected'";} echo">$cate_name</option>";
							$i++;
						}
						echo"</select></td></tr><tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
						<tr>
						<td width='5%' align='right'>type : </td><td width='23%'>";?><select class='form-control' name='type_id'><? 
						$result = dbQuery("select * from tbl_type");
						$row= dbNumRows($result);
						$i=0;
						while($row>$i)
						{
						$data = dbFetchArray($result);
						$ty_id = $data['type_id'];
						$type_name = $data['type_name'];
						echo "<option value='$type_id'";if($type_id=="$type_id"){echo " selected='selected'";} echo">$type_name</option>";
						$i++;
						}?></select><? echo "</td>
						<td colspan='5'></td>
						<td align='right'><button type='button' class='btn btn-default' data-dismiss='modal' aria-hidden='true'>&nbsp;&nbsp;Close&nbsp;&nbsp;</button></td>
						<td align='left'><button type='button' class='btn btn-primary' onclick='validate".$n."()' >&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;</button></td>
					</tr>
					<tr height='50'><td colspan='6'></td></tr>
				</table>
				</form>
				</div>
     
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal --></td>
		<td align='left'>$product_name</td><td>$price</td><td>$weight</td><td>$category</td><td>$type_name</td><td width='10%'><button class='btn btn-warning' data-toggle=\"modal\" data-target=\"#myModal".$n."\"> Edit</button></td>
		<td><a href='product_process.php?delete=y&product_id=$product_id'> <button type='button' class='btn btn-danger'  onclick=\"return confirm('ต้องการลบ $product_name หรือไม่');\"  >Delete</button></a></td></tr>";
		$is++;
		$n++;
			}
			?>
			</table>
			</div>
			</div>
													