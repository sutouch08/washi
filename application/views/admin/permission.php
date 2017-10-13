
<?php 
/***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/
$access = valid_access($id_menu); 
?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-unlock-alt'></i>&nbsp; กำหนดสิทธิ์</h3>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<div class="col-lg-12">
<?php if($profile != false) : ?>

            <div class="panel">
              <div class="tabbable tabs-left clearfix">
                <ul id="myTab1" class="nav nav-tabs">
                <?php $n = 1; ?>
                <?php foreach($profile as $pro) : ?>
                <?php if($n ==1 ){ $active = "active"; }else{ $active = ""; } ?>
                  <li class="<?php echo $active; ?>"><a href="#<?php echo $pro->id_profile; ?>" data-toggle="tab"><?php echo $pro->profile_name; ?></a></li>
                  <?php $n++; ?>
                  <?php endforeach; ?>
                </ul>
                <div id="myTabContent" class="tab-content">
                <?php $m = 1; ?>
                <?php foreach($profile as $rs) : ?>
                <?php if($m ==1 ){ $active = "active in"; }else{ $active = ""; } ?>
                  <div class="tab-pane fade <?php echo $active; ?>" id="<?php echo $rs->id_profile; ?>">
                  
                  <?php $pt = $this->permission_model->get_permission($rs->id_profile); ?>
                  <?php if($pt != false) : ?>
                  <?php echo form_open($this->home."/update/".$rs->id_profile); ?> 
                  <p class="pull-right"><button type="submit" class="btn btn-success">บันทึก</button></p><br/>
                  <table class="table table-condensed table-striped" style="width:85%">
                  <thead>
                  <th style="width:30%;">เมนู</th>
                  <th style="width:10%; text-align:center"><input type="checkbox" id="view_all" /><label for="view_all" style="padding-left:5px;">เข้า</label></th>
                  <th style="width:10%; text-align:center"><input type="checkbox" id="add_all" /><label for="add_all" style="padding-left:5px;">เพิ่ม</label></th>
                  <th style="width:10%; text-align:center"><input type="checkbox" id="edit_all" /><label for="edit_all" style="padding-left:5px;"> แก้ไข</label></th>
                  <th style="width:10%; text-align:center"><input type="checkbox" id="delete_all" /><label for="delete_all" style="padding-left:5px;">ลบ</label></th>
                  <th style="width:10%; text-align:center"><input type="checkbox" id="all" /><label for="all" style="padding-left:5px;">ทั้งหมด</label></th>
                  </thead>
                  <?php foreach($pt as $ro) : ?>
                  		<tr>
                        <td><?php echo $ro->menu_name; ?><input type="hidden" name="id_access[]" value="<?php echo $ro->id_access; ?>"  /></td>
                        <td align="center"><input type="checkbox" class="view" name="view[<?php echo $ro->id_access; ?>]" id="view<?php echo $ro->id_access; ?>" <?php echo isChecked(1, $ro->view); ?> value="1" /></td>
                        <td align="center"><input type="checkbox" class="add" name="add[<?php echo $ro->id_access; ?>]" id="add<?php echo $ro->id_access; ?>" <?php echo isChecked(1, $ro->add); ?> value="1" /></td>
                        <td align="center"><input type="checkbox" class="edit" name="edit[<?php echo $ro->id_access; ?>]" id="edit<?php echo $ro->id_access; ?>" <?php echo isChecked(1, $ro->edit); ?> value="1" /></td>
                        <td align="center"><input type="checkbox" class="delete" name="delete[<?php echo $ro->id_access; ?>]" id="delete<?php echo $ro->id_access; ?>" <?php echo isChecked(1, $ro->delete); ?> value="1" /></td>
                        <td align="center"><input type="checkbox" class="all" name="all[<?php echo $ro->id_access; ?>]" id="all<?php echo $ro->id_access; ?>" onclick="checkAll(<?php echo $ro->id_access; ?>);"  /></td>
                        </tr>
                        
                  <?php endforeach; ?>
                  <?php endif; ?>
                  </table>
                  </div>
                  <?php $m++; ?> 
                  <?php echo form_close(); ?>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
</div><!-- End row -->
<?php endif; ?>
<?php endif; ?>
</div>
<script> 
function checkAll(i){
	if($("#all"+i).is(":checked")){
		$("#view"+i).prop("checked", true);
		$("#add"+i).prop("checked", true);
		$("#edit"+i).prop("checked", true);
		$("#delete"+i).prop("checked", true);
	}else{
		$("#view"+i).prop("checked", false);
		$("#add"+i).prop("checked", false);
		$("#edit"+i).prop("checked", false);
		$("#delete"+i).prop("checked", false);
	}
}

$("#view_all").click(function(){
	if($(this).is(":checked")){
		$(".view").prop("checked", true);
	}else{
		$(".view").prop("checked", false);
	}
 });
 
 $("#add_all").click(function(){
	if($(this).is(":checked")){
		$(".add").prop("checked", true);
	}else{
		$(".add").prop("checked", false);
	}
 });
 
 $("#edit_all").click(function(){
	if($(this).is(":checked")){
		$(".edit").prop("checked", true);
	}else{
		$(".edit").prop("checked", false);
	}
 });
 
 $("#delete_all").click(function(){
	if($(this).is(":checked")){
		$(".delete").prop("checked", true);
	}else{
		$(".delete").prop("checked", false);
	}
 });
 
 $("#all").click(function(){
	if($(this).is(":checked")){
		$("input:checkbox").prop("checked", true);
	}else{
		$("input:checkbox").prop("checked", false);
	}
 });
</script>