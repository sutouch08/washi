<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-file-o'></i>&nbsp; ออเดอร์พร้อมส่ง </h3>
    </div>
    
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
	<div class='col-xs-12'>
    <table class='table table-striped'>
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%; text-align:center'>ลำดับ</th>
            <th style='width:10%;'>เลขที่อ้างอิง</th>
            <th style='width:15%;'>ลูกค้า</th>
            <th style='width:5%; text-align:right'>จำนวน</th>
            <th style='width:8%; text-align:right'>ยอดเงิน</th>
            <th style='width:10%; text-align:center'>วันที่เพิ่ม</th>
            <th style='width:10%; text-align:center'>กำหนดรับ</th>
            <th style='width:8%; text-align:center'>เงื่อนไข</th>
            <th style='width:15%;'>สถานะ</th>
            <th style='width:10%;'>การกระทำ</th>
            
         </tr>
      </thead>
      <tbody>
<?php if($data != false) : ?>
<?php $n = $this->uri->segment(4)+1; ?>
<?php foreach($data as $rs): ?>
  <tr style="font-size:14px; color:<?php echo urgentColor($rs->id_urgent); ?>;">
     <td style="cursor:pointer; vertical-align:middle;" align="center"><?php echo $n; ?></td>
     <td style="cursor:pointer; vertical-align:middle;" ><?php echo $rs->order_no; ?></td>	    
     <td style="cursor:pointer; vertical-align:middle;" ><?php echo getCustomerName($rs->id_customer); ?></td>
     <td align="right" style="cursor:pointer; vertical-align:middle;" ><?php echo number($this->order_model->order_qty($rs->id_order)); ?></td>
     <td align="right" style="cursor:pointer; vertical-align:middle;" ><?php echo number($this->order_model->total_amount($rs->id_order),2); ?></td>
     <td align="center" style="cursor:pointer; vertical-align:middle;" ><?php echo thaiShortDate($rs->order_date); ?></td>
     <td align="center" style="cursor:pointer; vertical-align:middle;" ><?php echo thaiShortDate($rs->due_date); ?></td>
     <td align="center" style="cursor:pointer; vertical-align:middle;" ><?php echo $this->order_model->get_condition($rs->id_urgent); ?></td>
     <td style="cursor:pointer; vertical-align:middle;" ><?php echo $this->order_model->get_state($rs->state); ?></td>
     <?php if($rs->valid == 0) : ?> 
     <?php $ac = $this->order_model->balance_payment($rs->id_order); ?>
     <?php if($ac ==1) : ?>
     <td>
     	<a href="<?php echo base_url()."shop/order/payment/".$rs->id_order."/".$rs->id_customer; ?>" >
    	 ยังไม่ได้ชำระ
         </a>
       </td>
       <?php else : ?>
       <td>
     	<a href="<?php echo base_url()."shop/order/repay/".$rs->id_order."/".$rs->id_customer; ?>" >
    	 ค้างชำระ <?php echo $this->order_model->balance_payment($rs->id_order); ?>
         </a>
       </td>
       <?php endif; ?>
     <?php else : ?>
      <td><a href="<?php echo $this->home."/check_out/".$rs->id_order; ?>"><button type="button" class="btn btn-success" ><i class="fa fa-paper-plane"></i>&nbsp; ส่งคืนลูกค้า</button></a></td>    
      <?php endif; ?>        
   </tr>
<?php $n++; ?>
<?php endforeach; ?>
<?php else : ?>
  <tr><td colspan="10" align="center" ><h4>---------- ไม่พบรายการใดๆ -----------</h4></td></tr>
<?php endif; ?>
</table>
</div><!-- End col-lg-12 -->
<div class="col-lg-12"><?php echo $this->pagination->create_links(); ?></div>
</div><!-- End row -->
<?php endif; ?>
</div>
