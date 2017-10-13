<?php 
/***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/
$access = valid_access($id_menu); 
// ได้ค่าเป็น array("view"=>1 | 0, "add"=>"" | "style="display:none;", "edit"=>"" | "style="display:none;", "delete"=>"" | "style="display:none;", "print"
?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
	<div class="row">
    	<div class="col-lg-12">
        	<h1 style="text-align:center">Admin Dashboard</h1>
        </div>
    </div>
</div>
<?php endif; ?>