<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-users'></i>&nbsp; เพิ่ม/แก้ไข ลูกค้า </h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/customer/add">
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
            <th style='width:15%;'>รหัสลูกค้า</th>
            <th style='width:20%;'>ชื่อลูกค้า</th>
            <th style='width:15%;'>เบอร์โทรศัพท์</th>
            <th style='width:20%;'>อีเมล์</th>
            <th style='width:15%; text-align:center'>แก้ไขล่าสุด</th>
            <th style='width:10%; text-align:right'>การกระทำ</th>
         </tr>
      </thead>
      <tbody>
<?php if($data != false) : ?>
<?php $n = $this->uri->segment(4)+1; ?>
<?php foreach($data as $rs): ?>
  <tr style="font-size:12px;">
     <td style="cursor:pointer; vertical-align:middle;" align="center" onClick="document.location='<?php echo base_url()."shop/customer/detail/".$rs->id_customer; ?>' "><?php echo $n; ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/customer/detail/".$rs->id_customer; ?>' "><?php echo $rs->customer_code; ?></td>	    
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/customer/detail/".$rs->id_customer; ?>' "><?php echo $rs->customer_name; ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/customer/detail/".$rs->id_customer; ?>' "><?php echo $rs->phone; ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/customer/detail/".$rs->id_customer; ?>' "><?php echo $rs->email; ?></td>
     <td style="cursor:pointer; vertical-align:middle;" align="center" onClick="document.location='<?php echo base_url()."shop/customer/detail/".$rs->id_customer; ?>' "><?php echo thaiDate($rs->date_upd); ?></td>
	 <td align="right">
     	<a href="<?php echo base_url()."shop/customer/edit/".$rs->id_customer; ?>" <?php echo $access['add']; ?> ><button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button></a>
        <a href="<?php echo base_url()."shop/customer/delete/".$rs->id_customer; ?>" <?php echo $access['delete']; ?> onclick="return confirm('คุณแน่ใจว่าต้องการลบลูกค้ารายนี้');">
        	<button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
   </tr>
<?php $n++; ?>
<?php endforeach; ?>
<?php else : ?>
  <tr><td colspan="10" align="center" ><h4>---------- ไม่พบรายการใดๆ -----------</h4></td></tr>
<?php endif; ?>

</table>
<?php echo $this->pagination->create_links(); ?>
</div><!-- End col-lg-12 -->
</div><!-- End row -->
<?php endif; ?>
</div>