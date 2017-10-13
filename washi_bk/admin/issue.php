<? 
checkPermission();
?>
<script src="../library/js/jquery-1.9.1.js"></script>
<script src="../library/js/bootstrap.js"></script>
<script>
$(document).ready(function(){
	$("#problem_name").keyup(function(){
		var problem_name = $("#problem_name").val();
		$.ajax({	
			type: "GET", 
			url:"issue_process.php",
			cache:false, data:"problem_name="+problem_name,
			success: function(msg)	{
				if( $("#problem_name").val().length >3){
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
	var catename = $("#problem_name").val().length;
	if(checked==1){
		alert ("problem already exist");
	}else if(catename ==""){
		alert("Please fill out problem name fild.");
	}else if(catename<4){
		alert ("problem name must be at least 4 letters");
	}else{
		$("#problem_form").submit();
	}
}	
</script>
			
<div class="container">
<div class="col-sm-12">
<h1 style="margin-top:0px; margin-bottom:0px;"><? echo $pageTitle; ?></h1>
<hr />
<form action="issue_process.php?add=y" method="post" id="problem_form" autocomplete="off" >
<table width="100%" border="0px">
		<tr>
        	<td width="20%" align="right">ปัญหา:&nbsp;&nbsp;</td>
            <td width="30%" align="left"><input type="hidden" id="valid"  /><input type="text" class="form-control" name="problem_name" id="problem_name" required="required" autofocus="autofocus" /></td>
            <td width="3%"  id="validate"><img src="../images/space.png" /></td>
            <td width="15%" align="left"><button type="button" class="btn btn-default" onclick="validate()">Save</button></td>	<td></td>	
        </tr>									
    </table>
  </form><hr />
  <table class="table table-hover">
  		<thead>
        	<td width="10%"><h4>#</h4></td><td><h4>ปัญหา</h4></td><td width="10%" colspan="2"><h4>Action</h4></td>
        </thead>
        <?php 
					$result = dbQuery("select * from tbl_problem where id_problem != '1'");
					$row = dbNumRows($result);
					$i=0;
					$n=1;
					while($row>$i){
						$data = dbFetchArray($result);
						$id_problem = $data['id_problem'];
						$problem_name = $data['problem_name'];
						echo "<tr align='center'><td>$n
		<div class='modal fade' id=\"myModal".$n."\" tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  		 <div class='modal-dialog'>
        <div class='modal-content'>
       <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='myModalLabel".$n."'>แก้ไขปัญหา</h4>
      </div>
      <div class='modal-body'>
	  <script>
$(document).ready(function(){
	$(\"#problem_name".$n."\").keyup(function(){
		var problem_name".$n." = $(\"#problem_name".$n."\").val();
		$.ajax({	
			type: \"GET\", 
			url:\"issue_process.php\",
			cache:false, data:\"problem_name=\"+problem_name".$n.",
			success: function(msg)
			{
				if( $(\"#problem_name".$n."\").val().length >3)
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
	var username".$n." = $(\"#problem_name".$n."\").val().length;
	if(checked==1){
		alert (\"Category name already exist\");
	}else if(username ==\"\"){
		alert(\"Please fill out Category name fild.\");
	}else if(password<4){
		alert (\"Category name must be at least 4 digit\");
	}else{
		$(\"#user_form".$n."\").submit();
	}
}	
</script>
	  <form action='issue_process.php?edit=y' method='post' id='user_form".$n."' autocomplete='off' >
	 <table width='100%' border='0px'><input type=\"hidden\" name=\"id_problem\" value=\"".$id_problem."\"  />
		<tr>
        	<td width='20%' align='right'>ปันหา:&nbsp;&nbsp;</td>
            <td width='30%' align='left'><input type='hidden' id='valid".$n."'  />
					<input type='text' class='form-control' name='problem_name' id='problem_name".$n."' required='required' value='$problem_name'  autofocus='autofocus' />
			</td>
            <td width='3%'  id='validate".$n."'><img src='../images/space.png' /></td>
            <td width='15%' align='left'><button type='submit' class='btn btn-default' onclick='validate".$n."()'>Save</button></td>	<td></td>	
        </tr>									
    </table>
  </form>
  </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</td><td>$problem_name</td><td><button class='btn btn-default' data-toggle=\"modal\" data-target=\"#myModal".$n."\" >Edit</button></td>
		<td><a href='issue_process.php?delete=y&id_problem=$id_problem'> <button type='button' class='btn btn-default'  onclick=\"return confirm('ต้องการลบ $problem_name หรือไม่');\"  >Delete</button></a></td></tr>";
		$i++;
		$n++;
					}
					?>
                    </table>
        
    </div>
    </div>
    

                                                    