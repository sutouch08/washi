<?
checkPermission();
function shop_list()
{
		$sql = "select shop_id, shop_name from tbl_shop ";
		$result = dbQuery($sql);
		$row = dbNumRows($result);
		$i = 0;
		while($row>$i){
		$option = dbFetchArray($result);
		$shop_id =$option['shop_id'];
		$shop_name = $option['shop_name'];	
		echo "<option value=$shop_id>$shop_name</option>";
		$i++;
		}  
}
function profile_list()
{
		$sql = "select * from tbl_profile ";
		$result = dbQuery($sql);
		$row = dbNumRows($result);
		$i = 0;
		while($row>$i){
		$option = dbFetchArray($result);
		$profile_id =$option['profile_id'];
		$profile_name = $option['profile_name'];	
		echo "<option value=$profile_id>$profile_name</option>";
		$i++;
		}  
}
?>
<script src="../library/js/jquery-1.9.1.js"></script>
<script src="../library/js/bootstrap.js"></script>
<script language="javascript">
$(document).ready(function(){
	$("#em_name").keyup(function(){
		var em_name = $("#em_name").val();
		$.ajax({	
			type: "GET", 
			url:"employee_process.php",
			cache:false, data:"em_name="+em_name,
			success: function(msg)	{
				if( $("#em_name").val().length >3){
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
	var emname = $("#em_name").val().length;
	if(checked==1){
		alert ("Employee name already exist");
	}else if(emname ==""){
		alert("Please fill out Employee name.");
	}else{
		$("#employee_form").submit();
	}
}	
</script>

<div class="container">
<div class="col-sm-12">
<h1 style="margin-top:0px; margin-bottom:0px;"><? echo $pageTitle; ?></h1>
<hr />
<form action="employee_process.php?add=y" method="post" id="employee_form" autocomplete="off" >
<table width="100%" border="0"><input type="hidden" id="valid"  />
	<tr>
    	<td width="5%" align="right">Name :&nbsp;</td><td ><input type="text" name="em_name" id="em_name" class="form-control" /></td>
        <td width="2%" id="validate"><img src="../images/space.png" /></td>
        <td width="5%" align="right">Shop :&nbsp;</td><td><select class="form-control" name="shop_id"><? shop_list(); ?></select></td>
        <td width="5%" align="right">Profile :&nbsp;</td><td><select class="form-control" name="profile_id"><? profile_list(); ?></select></td>
        <td width="7%" align="right">Barcode :&nbsp;</td><td><input type="text" name="em_code" class="form-control" /></td>
        <td><button type="button" class="btn btn-primary" onclick="validate()">ADD</button></td><td></td>
     </tr>
  </table>
  </form>
  <hr />
  <table class="table table-hover">
  		<thead>
        		<td width="5%"><h4>#</h4></td><td width="30%"><h4>Name</h4></td><td width="20%"><h4>Shop</h4></td><td width="20%"><h4>Profile</h4></td><td width="15%"><h4>Barcode</h4></td><td colspan="2"><h4>Action</h4></td>
        </thead>
        <? 
		$result = dbQuery("SELECT * FROM tbl_employee LEFT JOIN tbl_shop ON tbl_employee.shop_id = tbl_shop.shop_id LEFT JOIN tbl_profile ON tbl_employee.profile_id = tbl_profile.profile_id WHERE tbl_employee.em_id !=1");
		$row = dbNumRows($result);
		$i=0;
		$n=1;
		while($row>$i)
		{
			$data = dbFetchArray($result);
			$em_id = $data['em_id'];
			$em_name = $data['em_name'];
			$shop_id = $data['shop_id'];
			$shop_name = $data['shop_name'];
			$profile_id = $data['profile_id'];
			$profile_name  = $data['profile_name'];
			$em_code = $data['em_code'];
			echo"<tr align='center'><td>$n
													<div class='modal fade' id=\"myModal".$n."\" tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
													 <div class='modal-dialog' style='width:900px;'>
													<div class='modal-content' style='width:900px;'>
												   <div class='modal-header' style='width:900px;'>
													<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
													<h4 class='modal-title' id='myModalLabel".$n."'>Edit Employee</h4>
												    </div>
												    <div class='modal-body' style='width:900px;'>";?>
                                                    <script>
															$(document).ready(function(){
																$("#em_name<? echo $n; ?>").keyup(function(){
																	var em_name<? echo $n; ?> = $("#em_name<? echo $n; ?>").val();
																	$.ajax({	
																		type: "GET", 
																		url:"product_process.php",
																		cache:false, data:"em_name="+em_name<? echo $n; ?>,
																		success: function(msg)	{
																			if( $("#em_name<? echo $n; ?>").val().length >3){
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
																var emName<? echo $n; ?> = $("#em_name<? echo $n; ?>").val();
																if(checked<? echo $n; ?>==1){
																	alert ('Employee name already exist');
																}else if(emName<? echo $n; ?> ==''){
																	alert('Please fill out Employee name.');
																}else{
																	$("#employee_form<? echo $n; ?>").submit();
																}
															}	
															</script>
<? 
echo "<form action='employee_process.php?edit=y' method='post' id='employee_form".$n."' autocomplete='off' >
<table width='100%' border='0'><input type='hidden' id='valid".$n."'  /><input type='hidden' name='em_id' value='$em_id' />
	<tr>
    	<td width='10%' align='right'>Name :&nbsp;</td><td width='25%'><input type='text' name='em_name' id='em_name".$n."' class='form-control'  value='$em_name' /></td>
        <td width='5%' id='validate".$n."'><img src='../images/space.png' /></td>
        <td width='10%' align='right'>Shop :&nbsp;</td><td width='25%'><select class='form-control' name='shop_id'>";
        																					$sql = "select shop_id, shop_name from tbl_shop ";
																							$results = dbQuery($sql);
																							$rows = dbNumRows($results);
																							$is = 0;
																							while($rows>$is){
																							$options = dbFetchArray($results);
																							$shop_ids =$options['shop_id'];
																							$shop_names = $options['shop_name'];	
																							echo "<option value=$shop_ids";if($shop_ids=$shop_id){echo " selected='selected'";} echo">$shop_names</option>";
																							$is++;
																							}  
																							
        																				   echo"</select></td></tr><tr><td>&nbsp;</td></tr><tr>
        <td width='10%' align='right'>Profile :&nbsp;</td><td width='25%'><select class='form-control' name='profile_id'>";
																						 $sqlx = "select * from tbl_profile ";
																						$resultx = dbQuery($sqlx);
																						$rowx = dbNumRows($resultx);
																						$ix = 0;
																						while($rowx>$ix){
																						$optionx = dbFetchArray($resultx);
																						$profile_idx =$optionx['profile_id'];
																						$profile_namex = $optionx['profile_name'];	
																						echo "<option value=$profile_idx ";if($profile_idx==$profile_id){echo " selected='selected'";} echo">$profile_namex</option>";
																						$ix++;
																						}  
																						 echo "</select></td><td width='5%'></td>
        <td width='10%' align='right'>Barcode :&nbsp;</td><td width='25%'><input type='text' name='em_code' class='form-control' value='$em_code' /></td></tr><tr><td>&nbsp;</td><tr>
		<td colspan='3'></td>
		<td width='10%' align='right'><button type='button' class='btn btn-default' data-dismiss='modal' aria-hidden='true'>Close</button></td>
        <td width='10%'><button type='button' class='btn btn-primary' onclick='validate".$n."()'>Update</button></td>
     </tr>
  </table>
  </form>
  </div>
     
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal --></td>
		<td>$em_name</td><td>$shop_name</td><td>$profile_name</td><td>$em_code</td>
		<td width='10%'><button class='btn btn-warning' data-toggle=\"modal\" data-target=\"#myModal".$n."\"> Edit</button></td>
		<td><a href='employee_process.php?delete=y&em_id=$em_id'> <button type='button' class='btn btn-danger'  onclick=\"return confirm('ต้องการลบ $em_name หรือไม่');\"  >Delete</button></a></td></tr>";
		$i++;
		$n++;
		}
		?>
        </table>
  </div>
  </div>