
<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-user'></i>&nbsp; เพิ่ม/แก้ไข พนักงานขับรถ</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>admin/driver/add">
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
        	<th style='width:5%;'>ลำดับ</th>
            <th style='width:20%;'>พนักงานขับรถ</th>
            <th style='width:15%;'>ทะเบียนรถ</th>
            <th style='width:10%; text-align:center'>เปิดใช้งาน</th>
            <th style='text-align:right;'>การกระทำ</th>
         </tr>
      </thead>
      <tbody>
	<?php if($data != false) : ?>
    	<?php $n = 1; ?>
        <?php foreach($data as $rs): ?>
        		<tr style="font-size:12px;">
                	<td style="vertical-align:middle; text-align: center;"><?php echo $n; ?></td>
                    <td style="vertical-align:middle;"><?php echo getDriverName($rs->id_driver); ?></td>
                    <td style="vertical-align:middle;"><?php echo getCarPlate($rs->id_car); ?></td>     
                    <td style="vertical-align:middle; text-align:center"><?php echo isActived($rs->active); ?></td>                                  
                    <td align="right" style="vertical-align:middle;">
                    	<a href="<?php echo base_url(); ?>admin/driver/edit/<?php echo $rs->id_driver; ?>" >
                        	<button type="button" class="btn btn-warning" <?php echo $access['edit']; ?>><i class="fa fa-pencil"></i></button></a>
                        <a href="<?php echo base_url(); ?>admin/driver/delete/<?php echo $rs->id_driver; ?>">
                            <button type="button" class="btn btn-danger" onclick="return confirm('คุณแน่ใจว่าต้องการลบ <?php echo getDriverName($rs->id_driver); ?> ? โปรดจำไว้ว่าการกระทำนี้ไม่สามารถกู้คืนได้');" <?php echo $access['delete']; ?>>
                            <i class="fa fa-trash"></i></button></a>
                    </td>
                </tr>
               <?php $n++; ?>
        <?php endforeach; ?>
        <?php else : ?>
        <tr><td colspan="7" align="center" ><h4>---------- ไม่พบรายการใดๆ -----------</h4></td></tr>
    <?php endif; ?>
		</table>
</div><!-- End col-lg-12 -->
</div><!-- End row -->
<?php endif; ?>
</div>