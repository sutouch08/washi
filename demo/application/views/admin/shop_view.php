
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
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-book'></i>&nbsp; เพิ่ม/แก้ไข สำนักงาน</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>admin/shop/add">
        		<button class='btn btn-success'<?php echo $access['add']; ?>><i class='fa fa-plus'></i>&nbsp; เพิ่มใหม่</button>
             </a>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
	<div class='col-xs-12'>
    <table class='table table-striped' id="ac_chart">
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%;'>รหัส</th>
            <th style='width:20%;'>ชื่อสาขา</th>
            <th style='width:50%;'>ที่อยู่</th>
            <th style='width:10%'>เบอร์โทรศัพท์</th> 
            <th style='text-align:center;'>การกระทำ</th>
           </tr>
      </thead>
      <tbody>
	<?php if(count($data)> 0) : ?>
        <?php foreach($data as $rs): ?>
        		<tr style="font-size:12px;">
                    <td style="vertical-align:middle;"><?php echo $rs->shop_code; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->shop_name; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->shop_address; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->shop_phone; ?></td>
                    <td align="right" style="vertical-align:middle;">
                    	<a href="<?php echo base_url(); ?>admin/shop/edit/<?php echo $rs->id_shop; ?>" >
                        	<button type="button" class="btn btn-warning" <?php echo $access['edit']; ?>><i class="fa fa-pencil"></i></button></a>
                    <?php if($rs->is_default != 1): ?>
                        <a href="<?php echo base_url(); ?>admin/shop/delete/<?php echo $rs->id_shop; ?>">
                            <button type="button" class="btn btn-danger" onclick="return confirm('คุณแน่ใจว่าต้องการลบ <?php echo $rs->shop_name; ?> ? โปรดจำไว้ว่าการกระทำนี้ไม่สามารถกู้คืนได้');" <?php echo $access['delete']; ?>>
                            <i class="fa fa-trash"></i></button></a>
                    <?php endif; ?>
                    </td>
                </tr>
        <?php endforeach; ?>
        <?php else : ?>
        <tr><td colspan="7" align="center" ><h1>---------- ไม่พบรายการใดๆ -----------</h1></td></tr>
    <?php endif; ?>
		</table>
</div><!-- End col-lg-12 -->
</div><!-- End row -->
<?php endif; ?>
</div>