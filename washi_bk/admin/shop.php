<?php
checkPermission(); 
?>
<script src="../library/js/jquery-1.9.1.js"></script>
<script src="../library/js/bootstrap.js"></script>
<script>
$(document).ready(function(){
	$("#shop_name").keyup(function(){
		var shop_name = $("#shop_name").val();
		$.ajax({	
			type: "GET", 
			url:"shop_process.php",
			cache:false, data:"shop_name="+shop_name,
			success: function(msg)	{
				if( $("#shop_name").val().length >3){
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
	var productName = $("#shop_name").val().length;
	if(checked==1){
		alert ("shop name already exist");
	}else if(productName ==""){
		alert("Please fill out shop name.");
	}else{
		$("#shop_form").submit();
	}
}	
</script>
<div class="container">
<div class="col-sm-12">
<h1 style="margin-top:0px; margin-bottom:0px;"><? echo $pageTitle; ?></h1>
<hr />
<form action='shop_process.php?add=y' method="post" id="shop_form" autocomplete="off">
<table width="100%" border="0px"><input type="hidden" id="valid"  />
	<tr>
		<td width="10%" align="right">Shop Name :&nbsp;</td>
		<td width="25%" align="left"><input type="text" class="form-control" name="shop_name" id="shop_name" required="required" autofocus="autofocus" /></td>
		<td width="5%" align="left" id="validate"><img src="../images/space.png" /></td>
        <td width="5%" align="right">Phone :&nbsp; </td>
        <td width="25%" align="left"><input type="text" class="form-control" pattern="[0-9]" name="shop_phone" id="phone" /></td>
        <td width="5%" align="right">Code :&nbsp; </td>
        <td width="5%" align="left"><input type="text" class="form-control" name="shop_code" pattern="[A-Z] {2}"  /></td>
        <td></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
		<td width="10%" align="right">Address : &nbsp;&nbsp;</td>
		<td colspan="4"><textarea class="form-control" name="shop_address" id="address" rows="3" ></textarea></td>	<td></td>	
		<td width="10%" align="left">&nbsp;&nbsp;&nbsp;<button type="button" class="form-control btn-primary" onclick="validate()" >&nbsp;&nbsp;&nbsp;ADD&nbsp;&nbsp;&nbsp;</button></td>
	</tr>
</table>
</form>
<hr />
<!------------------------------------------------------------------- ตารางสินค้า--------------------------------------------------------------->
<table class="table table-hover">
	<thead>
    		<td width="5%"><h4>#</h4></td><td width="50%"><h4>Name</h4></td><td width="15%"><h4>Phone</h4></td><td width="15%"><h4>Code</h4></td><td colspan="2"><h4>Action</h4></td>
    </thead>
    <?
	$result = dbQuery("SELECT * FROM tbl_shop ");
	$row = dbNumRows($result);
	$i = 0;
	$n = 1;
	while($row>$i)
	{
		$data = dbFetchArray($result);
		$shop_id = $data['shop_id'];
		$shop_name = $data['shop_name'];
		$shop_address = $data['shop_address'];
		$shop_phone = $data['shop_phone'];
		$shop_code = $data['shop_code'];
		echo "<tr align='center'><td>$n
													<div class='modal fade' id=\"myModal".$n."\" tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
													 <div class='modal-dialog' style='width:900px;'>
													<div class='modal-content' style='width:900px;'>
												   <div class='modal-header' style='width:900px;'>
													<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
													<h4 class='modal-title' id='myModalLabel".$n."'>Edit Product</h4>
												    </div>
												    <div class='modal-body' style='width:900px;'>";?>
													<script>
															$(document).ready(function(){
																$("#shop_name<? echo $n; ?>").keyup(function(){
																	var shop_name<? echo $n; ?> = $("#shop_name<? echo $n; ?>").val();
																	$.ajax({	
																		type: "GET", 
																		url:"shop_process.php",
																		cache:false, data:"shop_name="+shop_name<? echo $n; ?>,
																		success: function(msg)	{
																			if( $("#shop_name<? echo $n; ?>").val().length >3){
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
																var productName<? echo $n; ?> = $("#shop_name<? echo $n; ?>").val().length;
																if(checked<? echo $n; ?>==1){
																	alert ('shop name already exist');
																}else if(productName<? echo $n; ?> ==''){
																	alert('Please fill Shop name.');
																}else{
																	$("#shop_form<? echo $n; ?>").submit();
																}
															}	
															</script>
<? echo"
<form action='shop_process.php?edit=y' method='post' id='shop_form".$n."' autocomplete='off'>
<table width='100%' border='0px'><input type='hidden' id='valid".$n."'  /><input type='hidden' name='shop_id' value='$shop_id'  />
	<tr>
		<td width='15%' align='right'>Shop Name :&nbsp;</td>
		<td width='25%' align='left'><input type='text' class='form-control' name='shop_name' id='shop_name".$n."' value=$shop_name /></td>
		<td width='5%' align='left' id='validate".$n."'><img src='../images/space.png' /></td>
        <td width='15%' align='right'>Phone :&nbsp; </td>
        <td width='25%' align='left'><input type='text'  pattern='[0-9]' class='form-control' name='shop_phone' id='phone".$n."' value='$shop_phone' /></td>
        <td width='10%' align='right'>Code :&nbsp; </td>
        <td width='5%' align='left'><input type='text' class='form-control' name='shop_code' pattern='[A-Z] {2}'  value='$shop_code' /></td>
        <td></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
		<td width='15%' align='right'>Address : &nbsp;&nbsp;</td>
		<td colspan='4'><textarea class='form-control' name='shop_address' id='address' rows='3'  >$shop_address</textarea></td>	
		<td width='10%'><button type='button' class='form-control btn-default' data-dismiss='modal' aria-hidden='true'>Close</button></td>	
		<td width='5%' align='left'><button type='button' class='form-control btn-primary' onclick='validate".$n."()' >Update</button></td>
	</tr>
</table>
</form>
</div>
     
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal --></td>
		<td align='left'>$shop_name</td><td>$shop_phone</td><td>$shop_code</td>
		<td width='5%'><button class='btn btn-warning' data-toggle=\"modal\" data-target=\"#myModal".$n."\"> Edit</button></td>
		<td width='5%'>";
		if($shop_id == "2"){ }else if($shop_id == "3"){}else{ echo "<a href='shop_process.php?delete=y&shop_id=$shop_id'> <button type='button' class='btn btn-danger'  onclick=\"return confirm('ต้องการลบ $shop_name หรือไม่');\"  >Delete</button></a></td>";} echo "</tr>";
		$i++;
		$n++;
	}
	?>
    </table>
    </div>
    </div>
