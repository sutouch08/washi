
<?php 
/***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/
$access = valid_access($id_menu); 
?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<?php if($data_view != false){ 
echo "<pre>";
print_r($data_view);
}
echo "</pre>";
?>
<?php endif; ?>
</div>