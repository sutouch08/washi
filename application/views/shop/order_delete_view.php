<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-pencil'></i>&nbsp; แก้ไขออเดอร์ </h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/order">
        		<button class='btn btn-danger'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
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
            <th style='width:15%;'>เลขที่อ้างอิง</th>
            <th style='width:15%;'>ลูกค้า</th>
            <th style='width:8%; text-align:right'>จำนวน</th>
            <th style='width:8%; text-align:right'>ยอดเงิน</th>
            <th style='width:10%; text-align:center'>วันที่เพิ่ม</th>
            <th style='width:10%; text-align:center'>กำหนดรับ</th>
            <th style='width:8%; text-align:center'>เงื่อนไข</th>
            <th style='width:10%;'>สถานะ</th>
            <th style='width:10%; text-align:right'>การกระทำ</th>
            
         </tr>
      </thead>
      <tbody>
<?php if($data != false) : ?>
<?php $n = 1; ?>
<?php foreach($data as $rs): ?>
  <tr style="font-size:14px; color:<?php echo urgentColor($rs->id_urgent); ?>;">
     <td style="cursor:pointer; vertical-align:middle;" align="center" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo $n; ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo $rs->order_no; ?></td>	    
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo getCustomerName($rs->id_customer); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" align="right" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo number($this->order_model->order_qty($rs->id_order)); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" align="right" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo number($this->order_model->total_amount($rs->id_order),2); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" align="center" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo thaiShortDate($rs->order_date); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" align="center" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo thaiShortDate($rs->due_date); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" align="center" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo $this->order_model->get_condition($rs->id_urgent); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" onClick="document.location='<?php echo base_url()."shop/order/detail/".$rs->id_order; ?>' "><?php echo $this->order_model->get_state($rs->state); ?></td>
     <?php if($rs->state < 3) :  ?> 
     <td align="right">
         <a href="<?php echo base_url()."shop/order/delete_order/".$rs->id_order; ?>" onclick="return confirm('รายการและข้อมูลการชำระเงินของออเดอร์นี้จะถูกลบด้วย และไม่สามารถกู้คืนได้ คุณแน่ใจว่าต้องการจะลบออเดอร์นี้ ?');" <?php echo $access['delete']; ?>>
    	 <button type="button" class="btn btn-danger btn-block"><i class="fa fa-trash"></i>&nbsp; ลบออเดอร์</button>
         </a>
       </td>
     <?php else : ?>
     <td align="right">  
    	 <button type="button" class="btn btn-warning btn-block" disabled="disabled"><i class="fa fa-trash"></i>&nbsp; ลบไม่ได้</button>
       </td> 
      <?php endif; ?>        
   </tr>
<?php $n++; ?>
<?php endforeach; ?>
<?php else : ?>
  <tr><td colspan="10" align="center" ><h4>---------- ไม่พบรายการใดๆ -----------</h4></td></tr>
<?php endif; ?>
</table>
</div><!-- End col-lg-12 -->
</div><!-- End row -->
<?php endif; ?>
</div>