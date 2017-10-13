<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-star'></i>&nbsp; รายการเสร็จสิ้น</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	
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
            <th style='width:15%;'>ออเดอร์</th>
            <th style='width:15%;'>ลูกค้า</th>
            <th style='width:15%;'>สาขา</th>
            <th style='width:15%;'>กำหนดส่ง</th>
            <th style="width:15%;">เงื่อนไข</th>
            <th style='text-align:right'>การกระทำ</th>
         </tr>
      </thead>
      <tbody>
<?php if($data != false) : ?>
<?php $n = $this->uri->segment(4)+1; ?>
<?php foreach($data as $rs): ?>
<?php if($rs->id_urgent >1){ $color = "color: #DA4453"; }else{ $color = ""; } ?>
  <tr style="font-size:12px; <?php echo $color; ?>">
     <td align="center"><?php echo $n; ?></td>
     <td><?php echo $rs->order_no; ?></td>
     <td><?php echo getCustomerName($rs->id_customer); ?></td>
     <td><?php echo getShopName($rs->id_shop); ?></td>
     <td><?php echo thaiShortDate($rs->due_date); ?></td>	  
     <td><?php echo getUrgent($rs->id_urgent); ?></td>
     <td align="right"><a href="<?php echo $this->home."/finished/".$rs->id_order; ?>"><button type="button" class="btn btn-primary" >แก้ไขรายการ</button></a></td> 
   </tr>
<?php $n++; ?>
<?php endforeach; ?>
<?php else : ?>
  <tr><td colspan="7" align="center" ><h4>---------- ไม่พบรายการใดๆ -----------</h4></td></tr>
<?php endif; ?>
</table>
</div><!-- End col-lg-12 -->
<div class="col-lg-12"><?php echo $this->pagination->create_links(); ?> </div>
</div><!-- End row -->
<?php endif; ?>
</div>