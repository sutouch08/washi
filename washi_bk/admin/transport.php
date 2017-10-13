<? 
checkPermission();
?>
<script src="../library/js/jquery-1.9.1.js"></script>
<script src="../library/js/bootstrap.js"></script>
<script>
$(document).ready(function(){
	$("#driver_name").keyup(function(){
		var driver_name = $("#driver_name").val();
		$.ajax({	
			type: "GET", 
			url:"transport_process.php",
			cache:false, data:"driver_name="+driver_name,
			success: function(msg)	{
				if( $("#driver_name").val().length >3){
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
	var catename = $("#driver_name").val().length;
	if(checked==1){
		alert ("Driver already exist");
	}else if(catename ==""){
		alert("Please fill out Driver name fild.");
	}else if(catename<4){
		alert ("Driver name must be at least 4 letters");
	}else{
		$("#transport_form").submit();
	}
}	
</script>
			
<div class="container"><h1 style="margin-top:0px; margin-bottom:0px;"><? echo $pageTitle; ?></h1>
<div class="col-sm-8">
<hr />
<h4>Driver</h4>
<hr />
<form action="transport_process.php?add=y" method="post" id="transport_form" autocomplete="off" >
<table width="100%" border="0px">
		<tr height="50">
        	<td width="20%" align="right">Driver Name:&nbsp;&nbsp;</td>
            <td width="30%" align="left"><input type="hidden" id="valid"  /><input type="text" class="form-control" name="driver_name" id="driver_name" required="required" autofocus="autofocus" /></td>
            <td width="3%"  id="validate"><img src="../images/space.png" /></td>
            <td width="15%" align="right">Phone:&nbsp;&nbsp; </td>	
            <td width="30%"><input type="text" class="form-control" name="driver_phone" required /> </td>	
        </tr>	
        <tr>
        	<td valign="top" align="right">Driver Address:</td>
            <td colspan="3" align="left" ><textarea name="driver_address" rows="3" cols="40" class="form-control"></textarea></td>	
			 <td valign="bottom" align="right"><button type="button" class="btn btn-default" onclick="validate()">Save</button></td>
            </tr>					
    </table>
  </form><hr />
  <table class="table table-hover">
  		<thead>
        	<td width="5%"><h4>#</h4></td><td width="30%"><h4>Driver Name</h4></td><td width="10%"><h4>Phone</h4></td><td width="45%"><h4>Address</h4></td><td width="10%" colspan="2"><h4>Action</h4></td>
        </thead>
        <?php 
					$result = dbQuery("select * from tbl_driver ");
					$row = dbNumRows($result);
					$i=0;
					$n=1;
					while($row>$i){
						$data = dbFetchArray($result);
						$driver_id = $data['driver_id'];
						$driver_name = $data['driver_name'];
						$driver_phone = $data['driver_phone'];
						$driver_address = $data['driver_address'];
						echo "<tr align='center'><td>$n
		<div class='modal fade' id=\"myModal".$n."\" tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  		 <div class='modal-dialog'>
        <div class='modal-content'>
       <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='myModalLabel".$n."'>Edit Category</h4>
      </div>
      <div class='modal-body'>
	  <script>
$(document).ready(function(){
	$(\"#user_name".$n."\").keyup(function(){
		var user_name".$n." = $(\"#user_name".$n."\").val();
		$.ajax({	
			type: \"GET\", 
			url:\"transport_process.php\",
			cache:false, data:\"driver_name=\"+user_name".$n.",
			success: function(msg)
			{
				if( $(\"#user_name".$n."\").val().length >3)
				{
						if(msg==1)
						{
							$(\"#valid".$n."\").val(msg);
							$(\"#validate".$n."\").html(\"<img src='../images/not.jpg'>\");
						}
						else if(msg==0)
						{
							$(\"#valid".$n."\").val(msg);
							$(\"#validate".$n."\").html(\"<img src='../images/checked.png'>\");
						}
				}
				else
				{ 
					$(\"#validate".$n."\").html(\"<img src='../images/space.png'>\");
				}
			}
		});
	});
});
function validate$n()
{
	var checked".$n." = $(\"#valid".$n."\").val();
	var username".$n." = $(\"#user_name".$n."\").val().length;
	if(checked==1){
		alert (\"Driver name already exist\");
	}else if(username ==\"\"){
		alert(\"Please fill out Driver name fild.\");
	}else if(password<4){
		alert (\"Driver name must be at least 4 digit\");
	}else{
		$(\"#user_form".$n."\").submit();
	}
}	
</script>
	  <form action='transport_process.php?edit=y' method='post' id='user_form".$n."' autocomplete='off' >
	 <table width='100%' border='0px'><input type=\"hidden\" name=\"user_id\" value=\"".$driver_id."\"  />
		<tr height='50'>
        	<td width='20%' align='right'>Driver Name:&nbsp;&nbsp;</td>
            <td width='30%' align='left'><input type='hidden' id='valid".$n."'  />
					<input type='text' class='form-control' name='driver_name' id='user_name".$n."' required='required' value='$driver_name'  autofocus='autofocus' />
			</td>
            <td width='3%'  id='validate".$n."'><img src='../images/space.png' /></td>
			<td width='15%' align='left'>Phone</td>	
			<td width='30%'><input type='text'  class='form-control' name='driver_phone' value='$driver_phone' required='required' /> </td>	
        </tr>	
		<tr>
		<td  valign='top' align='right'>Address :</td>
		<td colspan='3'><textarea name='driver_address'  rows='3' cols='40' class='form-control'>$driver_address</textarea></td>
		<td  valign='bottom' align='right'><button type='submit' class='btn btn-default' onclick='validate".$n."()'>Save</button>	</td>
		</tr>					
    </table>
  </form>
  </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</td><td align='left' >$driver_name</td><td align='left'>$driver_phone</td><td align='left'>$driver_address</td><td><button class='btn btn-default btn-xs' data-toggle=\"modal\" data-target=\"#myModal".$n."\" >Edit</button></td>
		<td><a href='transport_process.php?delete=y&driver_id=$driver_id'> <button type='button' class='btn btn-default btn-xs'  onclick=\"return confirm('ต้องการลบ $driver_name หรือไม่');\"  >Delete</button></a></td></tr>";
		$i++;
		$n++;
					}
					?>
                    </table>

    </div>
    <script>
$(document).ready(function(){
	$("#car_plate").keyup(function(){
		var car_plate = $("#car_plate").val();
		$.ajax({	
			type: "GET", 
			url:"transport_process.php",
			cache:false, data:"car_plate="+car_plate,
			success: function(msg)	{
				if( $("#car_plate").val().length >3){
						if(msg==1){
							$("#validc").val(msg);
							$("#validatec").html("<img src='../images/not.jpg'>");
						}else if(msg==0){
							$("#validc").val(msg);
							$("#validatec").html("<img src='../images/checked.png'>");
						}
				}else{ 
					$("#validatec").html("<img src='../images/space.png'>");
				}
			}
		});
	});
});
function validatec()
{
	var checked = $("#validc").val();
	var catename = $("#car_plate").val().length;
	if(checked==1){
		alert ("Car already exist");
	}else if(catename ==""){
		alert("Please fill out Car name fild.");
	}else if(catename<4){
		alert ("Car name must be at least 4 letters");
	}else{
		$("#car_form").submit();
	}
}	
</script>   <hr />
<h4>Car</h4>
<hr />
    <div class="col-sm-4" style="background: #F2F2F2">
 
    <form action="transport_process.php?caradd=1" method="post" id="car_form" autocomplete="off" >
    <table width="100%">
    <tr height="50">
    <td width="5%" align="left">Car Plate:</td>
    <td width="20%" ><input type="hidden" id="validc"  /><input type="text" class="form-control" name="car_plate" id="car_plate" required="required"  /></td>
    <td width="5%"  id="validatec"><img src="../images/space.png" /></td>
    </tr>
    <tr height="40">
    <td width="5%">Brand</td>
    <td width="20%"><input type="text" class="form-control" name="car_brand"  /></td>
    <td width="5%"></td>
    </tr>
     <tr height="40">
    <td width="5%">บรรทุกได้(กก.)</td>
    <td width="20%"><input type="text" class="form-control" name="capacity"  /></td>
    <td width="5%"></td>
    </tr>
     <tr>
    <td width="5%"></td>
    <td width="20%"></td>
    <td width="5%"><button type="button" class="btn btn-default" onclick="validatec()">Save</button></td>
    </tr>
    </table>
    </form>
    <hr  />
   
  <table class="table table-hover">
  		<thead>
        	<td width="3%"><h4>#</h4></td><td width="35%" align="left"><h4>Car plate</h4></td><td width="35%" align="left"><h4>Brand</h4></td><td width="10%"><h4>capacity</h4></td><td width="10%" colspan="2"><h4>Action</h4></td>
        </thead>
        <?php 
					$result = dbQuery("select * from tbl_car ");
					$row = dbNumRows($result);
					$i=0;
					$n=1;
					while($row>$i){
						$datac = dbFetchArray($result);
						$car_id = $datac['car_id'];
						$car_plate = $datac['car_plate'];
						$car_brand = $datac['car_brand'];
						$capacity = $datac['capacity'];
						echo "<tr align='center'><td>$n
		<div class='modal fade' id=\"myModalc".$n."\" tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  		 <div class='modal-dialog'>
        <div class='modal-content'>
       <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='myModalLabel".$n."'>Edit Category</h4>
      </div>
      <div class='modal-body'>
	  <script>
$(document).ready(function(){
	$(\"#user_namec".$n."\").keyup(function(){
		var user_namec".$n." = $(\"#user_namec".$n."\").val();
		$.ajax({	
			type: \"GET\", 
			url:\"transport_process.php\",
			cache:false, data:\"car_plate=\"+user_namec".$n.",
			success: function(msg)
			{
				if( $(\"#user_namec".$n."\").val().length >3)
				{
						if(msg==1)
						{
							$(\"#validc".$n."\").val(msg);
							$(\"#validatec".$n."\").html(\"<img src='../images/not.jpg'>\");
						}
						else if(msg==0)
						{
							$(\"#validc".$n."\").val(msg);
							$(\"#validatec".$n."\").html(\"<img src='../images/checked.png'>\");
						}
				}
				else
				{ 
					$(\"#validatec".$n."\").html(\"<img src='../images/space.png'>\");
				}
			}
		});
	});
});
function validatec$n()
{
	var checked".$n." = $(\"#validc".$n."\").val();
	var username".$n." = $(\"#user_namec".$n."\").val().length;
	if(checked==1){
		alert (\"Driver name already exist\");
	}else if(username ==\"\"){
		alert(\"Please fill out Car name fild.\");
	}else if(password<4){
		alert (\"Car name must be at least 4 digit\");
	}else{
		$(\"#car_formc".$n."\").submit();
	}
}	
</script>
	  <form action='transport_process.php?editcar=2' method='post' id='car_formc".$n."' autocomplete='off' >
	 <table width='100%' border='0px'><input type=\"hidden\" name=\"user_idc\" value=\"".$car_id."\"  />
		<tr height='50'>
        	<td width='20%' align='right'>Car Plate:&nbsp;&nbsp;</td>
            <td width='30%' align='left'><input type='hidden' id='validc".$n."'  />
					<input type='text' class='form-control' name='car_plate' id='user_namec".$n."' required='required' value='$car_plate'  autofocus='autofocus' />			</td>
            <td width='3%'  id='validatec".$n."'><img src='../images/space.png' /></td>
        </tr>
		<tr>
    <td width='5%' align='right'>Brand</td>
    <td width='20%'><input type='text' class='form-control' name='car_brand' id='car_brand".$n."' value='$car_brand'  /></td>
    <td width='5%'><button type='submit' class='btn btn-default' onclick='validatec".$n."()'>Save</button></td>
    </tr>
	 <tr height='40'>
    <td width='5%'>บรรทุกได้(กก.)</td>
    <td width='20%'><input type='text' class='form-control' name='capacity'  /></td>
    <td width='5%'></td>
    </tr>				
    </table>
  </form>
  </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</td><td align='left' >$car_plate</td><td align='left'>$car_brand</td><td>$capacity</td><td><button class='btn btn-default btn-xs' data-toggle=\"modal\" data-target=\"#myModalc".$n."\" >Edit</button></td>
		<td><a href='transport_process.php?deletecar=y&car_id=$car_id'> <button type='button'  class='btn btn-default btn-xs'  onclick=\"return confirm('ต้องการลบ $car_plate หรือไม่');\"  >Delete</button></a></td></tr>";
		$i++;
		$n++;
					}
					?>
                    </table>
    </div>
    </div>
    

                                                    