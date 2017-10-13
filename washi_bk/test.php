<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<? 
$dbHost = 'kongkaherb.co.th';
$dbUser = 'kongkaherb_admin';
$dbPass = '3310101764121';
$dbConn = mysql_connect ($dbHost, $dbUser, $dbPass) or die ('MySQL connect failed. ' . mysql_error());
mysql_select_db("kongkaherb_washi") or die(mysql_error());
?>
	<link href="../library/css/bootstrap.css" rel="stylesheet">
    <link href="../library/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../library/css/navbar-static-top.css" rel="stylesheet">
    <link href="../library/css/template.css" rel="stylesheet">
</head>

<body>
 <table class="table table-hover">
	<thead>
    		<td width="5%"><h4>#</h4></td><td width="50%"><h4>Name</h4></td><td width="15%"><h4>Phone</h4></td><td width="15%"><h4>Code</h4></td><td colspan="2"><h4>Action</h4></td>
    </thead><?
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
		<td width='5%'><a href='shop_process.php?delete=y&shop_id=$shop_id'> <button type='button' class='btn btn-danger'  onclick=\"return confirm('ต้องการลบ $shop_name หรือไม่');\"  >Delete</button></a></td></tr>";
		$i++;
		$n++;
	}
	?>
    </table>
</body>
</html>