<? 
checkPermission();
function em_list()
{
		$qr = "select em_id, em_name from tbl_employee where em_id !=1 ";
		$res = dbQuery($qr);
		$rs = dbNumRows($res);
		$n = 0;
		while($rs>$n){
		$data = dbFetchArray($res);
		$em_id =$data['em_id'];
		$em_name = $data['em_name'];	
		echo "<option value=$em_id>$em_name</option>";
		$n++;
		}  
}

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
?>
<script src="../library/js/jquery-1.9.1.js"></script>
<script src="../library/js/bootstrap.js"></script>
<script>
$(document).ready(function(){
	$("#user_name").keyup(function(){
		var user_name = $("#user_name").val();
		$.ajax({	
			type: "GET", 
			url:"user_process.php",
			cache:false, data:"user_name="+user_name,
			success: function(msg)	{
				if( $("#user_name").val().length >3){
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
	var password = $("#password").val().length;
	var username = $("#user_name").val().length;
	if(checked==1){
		alert ("User name already exist");
	}else if(username ==""){
		alert("Please fill out User name fild.");
	}else if(password<4){
		alert ("Password must be at least 4 digit");
	}else{
		$("#user_form").submit();
	}
}	
</script>
			
<div class="container">
<div class="col-sm-12">
<h1 style="margin-top:0px; margin-bottom:0px;"><? echo $pageTitle; ?></h1>
<hr />
<form action="user_process.php?add=y" method="post" id="user_form" autocomplete="off" >
<table width="100%" border="0px">
		<tr>
        	<td width="10%" align="right">User Name:&nbsp;&nbsp;</td><td width="15%" align="left"><input type="hidden" id="valid"  /><input type="text" class="form-control" name="user_name" id="user_name" required="required" autofocus="autofocus" /></td><td width="3%"  id="validate"><img src="../images/space.png" /></td>
            <td width="10%" align="right">Password :&nbsp;&nbsp;</td><td width="15%" align="left"><input type="password" class="form-control" name="password" id="password" required="required" /></td>
            <td width="10%" align="right">Employee : &nbsp;&nbsp;</td><td width="15%" align="left"><select class="form-control" name="em_id"><? em_list(); ?>	</select></td>
            <td width="10%" align="right">Shop :</td><td width="15%" align="left"><select class="form-control" name="shop_id"><? shop_list(); ?>	</select> </td>
         </tr>
         <tr>
         <td>&nbsp;&nbsp;</td>
         </tr>
         <tr>
              <td width="10%" align="right">Permission :&nbsp;&nbsp;</td>
              <td width="15%" align="left" colspan="2">&nbsp;<input type="radio" name="permission" id="permission1" value="USER" checked="checked" />&nbsp;&nbsp;User &nbsp;&nbsp;<input type="radio" name="permission" id="permission1" value="ADMIN"  />&nbsp;&nbsp;Admin</td><td align="left"><button type="button" class="btn btn-primary" onclick="validate()" >&nbsp;&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;&nbsp;</button></td>
             </tr>
</table></form><hr />
<table class="table table-hover">
<thead align="center"><td width="5%"><h4>#</h4></td><td width="15%"><h4>User Name</h4></td><td width="20%"><h4>Employee</h4></td><td width="20%"><h4>Shop</h4></td><td width="5%"><h4>Permission</h4></td><td width="15%"><h4>Last login</h4></td><td colspan="2"><h4>Action</h4></td></thead>
<?php 
	$query = "select * from tbl_user left join tbl_employee on tbl_user.em_id = tbl_employee.em_id left join tbl_shop on tbl_user.shop_id = tbl_shop.shop_id where tbl_user.user_name !='admin'";
	$rest =  dbQuery($query);
	$rst = dbNumRows($rest);
	$is = 0;
	$ns = 1;
	while($rst>$is){
		$datas = dbFetchArray($rest);
		$user_id =$datas['user_id'];
		$user_name = $datas['user_name'];
		$password = $datas['password'];
		$em_id2 = $datas['em_id'];
		$employee = $datas['em_name'];
		$shop_id2 = $datas['shop_id'];
		$shop = $datas['shop_name'];
		$permission = $datas['permission'];
		$login = date('d-m-Y H:i:s',strtotime($datas['user_last_login'])); 
		echo "<tr align='center'><td>$ns
		<div class='modal fade' id=\"myModal".$ns."\" tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  		 <div class='modal-dialog'>
        <div class='modal-content'>
       <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='myModalLabel".$ns."'>Edit User</h4>
      </div>
      <div class='modal-body'>";
	  ?>
	  <script>
			$(document).ready(function(){
				$("#user_name<? echo $ns; ?>").keyup(function(){
				var user_name<? echo $ns; ?> = $("#user_name<? echo $ns; ?>").val();
				$.ajax({	
				type: "GET", 
				url:"user_process.php",
				cache:false, data:"user_name="+user_name<? echo $ns; ?>,
				success: function(msg)	{
				if( $("#user_name<? echo $ns; ?>").val().length >3){
				if(msg==1){
					$("#valid<? echo $ns; ?>").val(msg);
					$("#validate<? echo $ns; ?>").html("<img src='../images/not.jpg'>");
				}else if(msg==0)	{
					$("#valid<? echo $ns; ?>").val(msg);
					$("#validate<? echo $ns; ?>").html("<img src='../images/checked.png'>");
					}
					}else{ 
					$("#validate<? echo $ns; ?>").html("<img src='../images/space.png'>");
							}
						}
					});
				});
			});
			function validate<? echo $ns; ?>(){
				var checked<? echo $ns; ?> = $("#valid<? echo $ns; ?>").val();
				var password<? echo $ns; ?> = $("#password<? echo $ns; ?>").val().length;
				var username<? echo $ns; ?> = $("#user_name<? echo $ns; ?>").val().length;
				if(checked<? echo $ns; ?>==1){
					alert ("User name already exist");
				}else if(username<? echo $ns; ?> ==""){
					alert("Please fill out User name fild.");
				}else if(password<? echo $ns; ?><4){
					alert ("Password must be at least 4 digit");
				}else{
					$("#user_form<? echo $ns; ?>").submit();
				}
			}	
</script>
<? echo "
	  <form action='user_process.php?edit=y' method='post' id='user_form".$ns."' autocomplete='off' >
	  <table width='100%' border='0px'><input type=\"hidden\" name=\"user_id\" value=\"".$user_id."\"  />
		<tr>
        	<td width='15%' align='right'>User Name:&nbsp;&nbsp;</td><td width='30%' align='left'><input type='hidden' id='valid".$ns."'  /><input type='text' class='form-control' name='user_name' id='user_name".$ns."'  value='".$user_name."' required='required' autofocus='autofocus' /></td><td width='5%'  id='validate".$ns."'><img src='../images/space.png' /></td>
            <td width='15%' align='right'>Password :&nbsp;&nbsp;</td><td width='25%' align='left'><input type='password' class='form-control' name='password' id='password".$ns."' value='".$password."'  required='required' /></td></tr><tr>
            <td width='15%' align='right'>Employee : &nbsp;&nbsp;</td><td width='30%' align='left'><select class='form-control' name='em_id'>";													
													$qrs = "select em_id, em_name from tbl_employee ";
													$ress = dbQuery($qrs);
													$rss = dbNumRows($ress);
													$ni = 0;
													while($rss>$ni){
														$datax = dbFetchArray($ress);
														$em_ids =$datax['em_id'];
														$em_names = $datax['em_name'];	
														echo "<option value='$em_ids'"; if($em_ids == $em_id2){echo "selected='selected'";} echo">$em_names</option>";
														$ni++;
													}  
													 echo"</select></td><td width=\"5%\"></td>
        
          <td width='15%' align='right'>Shop :</td><td width='25%' align='left'><select class='form-control' name='shop_id'>"; 
            										
													$sqls = "select shop_id, shop_name from tbl_shop ";
													$results = dbQuery($sqls);
													$rows = dbNumRows($results);
													$iss = 0;
													while($rows>$iss){
														$options = dbFetchArray($results);
														$shop_ids =$options['shop_id'];
														$shop_names = $options['shop_name'];	
														echo "<option value='$shop_ids'"; if($shop_ids == $shop_id2){echo "selected='selected'";} echo">$shop_names</option>";
														$iss++;
													}   
													
													 echo"</select>
                                                    </td>
         </tr>
         <tr>
         <td>&nbsp;&nbsp;</td>
         </tr>
         <tr>
              <td width='10%' align='right'>Permission :&nbsp;&nbsp;</td>
              <td width='15%' align='left' colspan='2'>&nbsp;<input type='radio' name='permission' id='permission1' value='USER' ";if($permission=='USER'){ echo "checked='checked'";} echo" />&nbsp;&nbsp;User &nbsp;&nbsp;<input type='radio' name='permission' id='permission1' value='ADMIN' ";if($permission=='ADMIN'){ echo "checked='checked'";} echo"  />&nbsp;&nbsp;Admin</td>
			  <td><button type='button' class='btn btn-default' data-dismiss='modal' aria-hidden='true'>Close</button></td>
			  <td align='left'><button type='button' class='form-control' onclick='validate".$ns."()' >Update</button></td>
             </tr>
</table></form>
	  
	  
	  
	   </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
		
		</td><td>$user_name</td><td>$employee</td><td>$shop</td><td>$permission</td><td>$login</td>
		<td><button class='btn btn-warning' data-toggle=\"modal\" data-target=\"#myModal".$ns."\"> Edit</button></td>
		<td><a href='user_process.php?delete=y&user_id=$user_id'> <button type='button' class='btn btn-danger'  onclick=\"return confirm('ต้องการลบ $user_name หรือไม่');\"  >Delete</button></a></td></tr>";
		$is++;
		$ns++;
	}
	?>
    </table>
        
    </div>
    </div>
    

                                                    