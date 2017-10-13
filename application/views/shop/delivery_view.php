<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-users'></i>&nbsp; เพิ่ม/แก้ไข การจัดส่ง</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/delivery/add">
        		<button class='btn btn-success'<?php echo $access['add']; ?>><i class='fa fa-plus'></i>&nbsp; เพิ่มใหม่</button>
             </a>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
	<div class='col-xs-12'>
    <table class='table table-striped'>
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%; text-align:center'>ลำดับ</th>
            <th style='width:10%;'>วันที่ส่ง</th>
            <th style='width:15%;'>เลขที่อ้างอิง</th>
            <th style='width:10%;'>ต้นทาง</th>
            <th style='width:10%;'>ปลายทาง</th>
            <th style='width:10%;'>ทะเบียนรถ</th>
            <th style='width:10%;'>พนักงานขับรถ</th>
            <th style='width:10%;'>สถานะ</th>
            <th style='width:10%; text-align:right'>การกระทำ</th>
         </tr>
      </thead>
      <tbody>
<?php if($data != false) : ?>
<?php $n = $this->uri->segment(4)+1; ?>
<?php foreach($data as $rs): ?>
  <tr style="font-size:12px;">
     <td style="cursor:pointer; vertical-align:middle;" align="center" onClick="document.location='<?php echo base_url()."shop/delivery/detail/".$rs->id_delivery; ?>' "><?php echo $n; ?></td>
     
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/delivery/detail/".$rs->id_delivery; ?>' "><?php echo thaiShortDate($rs->date_add); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/delivery/detail/".$rs->id_delivery; ?>' "><?php echo $rs->reference; ?></td>	    
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/delivery/detail/".$rs->id_delivery; ?>' "><?php echo getShopName($rs->id_shop); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/delivery/detail/".$rs->id_delivery; ?>' "><?php echo getShopName($rs->id_target); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/delivery/detail/".$rs->id_delivery; ?>' "><?php echo getCarPlate($rs->id_car); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/delivery/detail/".$rs->id_delivery; ?>' "><?php echo getDriverName($rs->id_driver); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/delivery/detail/".$rs->id_delivery; ?>' "><?php if($rs->valid ==1){ echo "ถึงปลายทางแล้ว"; }else{ echo "ระหว่างทาง"; } ?></td>

	 <td align="right">
     <?php if($rs->shipped ==0) : ?>
     	<a href="<?php echo base_url()."shop/delivery/edit/".$rs->id_delivery; ?>" <?php echo $access['edit']; ?> ><button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button></a>
        <a href="<?php echo base_url()."shop/delivery/delete/".$rs->id_delivery; ?>" <?php echo $access['delete']; ?> onclick="return confirm('รายละเอียกการจัดส่งจะถูกลบ สถานะออเดอร์จะย้อนกลับไปเป็น รอส่ง คุณแน่ใจว่าต้องการลบรายการขนส่งนี้');">
        	<button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
     <?php else : ?>
     -    
     <?php endif; ?>            
   </tr>
<?php $n++; ?>
<?php endforeach; ?>
<?php else : ?>
  <tr><td colspan="9" align="center" ><h4>---------- ไม่พบรายการใดๆ -----------</h4></td></tr>
<?php endif; ?>
</table>
</div><!-- End col-lg-12 -->
<div class="col-lg-12"><?php echo $this->pagination->create_links(); ?> </div>
</div><!-- End row -->
<?php endif; ?>
</div>