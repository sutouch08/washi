<?  checkPermission(); ?>
<script src="../library/js/jquery-1.9.1.js"></script>
<script src="../library/js/bootstrap.js"></script>		
<div class="container">
<div class="col-sm-12">
<h1 style="margin-top:0px; margin-bottom:0px;"><? echo $pageTitle; ?></h1>
<hr />
<form action="type_process.php?add=y" method="post" id="type_form" autocomplete="off" >
<table border="0px" align="center">
		<tr>
        	<td width="20%" align="right">ประเภทสินค้า:&nbsp;&nbsp;</td><td width="50%" align="left"><input type="text" class="form-control" name="type_name" id="type_name" required="required" autofocus="autofocus" /></td>
			<td align="left"><button type="button" class="btn btn-primary" onclick="validate()" >&nbsp;&nbsp;&nbsp;&nbsp;เพิ่ม&nbsp;&nbsp;&nbsp;&nbsp;</button></td><td><input type="hidden" id="valid"  /></td>
             </tr>
</table></form><hr />
<table class="table table-hover">
<thead align="center"><td width="5%"><h4>#</h4></td><td width="50%"><h4>ประเภทสินค้า</h4></td><td width="10%" colspan="2"><h4>การกระทำ</h4></td></thead>
<?php 
	$query = "select * from tbl_type";
	$result =  dbQuery($query);
	$row = dbNumRows($result);
	$i = 0;
	$n = 1;
	while($row>$i){
		$data = dbFetchArray($result);
		$type_id = $data['type_id'];
		$type_name = $data['type_name'];
		echo "<tr align='center'><td>$n
		<div class='modal fade' id=\"myModal".$n."\" tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  		 <div class='modal-dialog'>
        <div class='modal-content'>
       <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        <h4 class='modal-title' id='myModalLabel".$n."'>Edit Type</h4>
      </div>
      <div class='modal-body'>
	  <form action='type_process.php?edit=y' method='post' id='type_form".$n."' autocomplete='off' >
	  <table width='100%' border='0px'><input type=\"hidden\" name=\"type_id\" value=\"".$type_id."\"  />
		<tr>
        	<td width='20%' align='right'>ประเภทสินค้า	:&nbsp;&nbsp;</td>
			<td width='50%' align='left'><input type='text' class='form-control' name='type_name' id='type_name".$n."'  value='".$type_name."' required='required' autofocus='autofocus' /></td> 
			<td width='10%' >&nbsp;</td>
			<td><button type='button' class='btn btn-default' data-dismiss='modal' aria-hidden='true'>Close</button></td>
			<td align='left'><button type='submit' class='form-control'  >Update</button></td>
        </tr>
</table></form>
	   </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
		
		</td><td>$type_name</td>
		<td><button class='btn btn-warning' data-toggle=\"modal\" data-target=\"#myModal".$n."\"> Edit</button></td>
		<td><a href='type_process.php?delete=y&type_id=$type_id'> <button type='button' class='btn btn-danger'  onclick=\"return confirm('ต้องการลบ $type_name หรือไม่');\"  >Delete</button></a></td></tr>";
		$i++;
		$n++;
	}
	?>
    </table>
        
    </div>
    </div>
    

                                                    