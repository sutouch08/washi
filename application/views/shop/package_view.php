<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-credit-card'></i>&nbsp; ซื้อ แพ็คเกจ</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>shop/index">
        		<button class='btn btn-warning'><i class='fa fa-remove'></i>&nbsp; ยกเลิก</button>
             </a>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
	<div class='col-xs-12'>
    <table class='table table-hover'>
    <thead>
    	<tr style='font-size:12px;'>
        	<th style='width:5%; text-align:center'>ลำดับ</th>
            <th style='width:20%;'>เพ็คเกจ</th>
            <th style='width:10%;'>เริ่ม</th>
            <th style='width:10%;'>สิ้นสุด</th>
            <th style='width:10%; text-align:center'>ระยะเวลา</th> 
            <th style='width:9%; text-align:center'>ชิ้น</th>
            <th style='width:9%; text-align:right'>บาท</th>
            <th style='width:9%; text-align:right'>ส่วนลด</th>
            <th style='width:9%; text-align:right'>ราคา</th> 
            <th style='text-align:right;'>การกระทำ</th>
         </tr>
      </thead>
      <tbody>
	<?php if($data != false) : ?>
    	<?php $n = $this->uri->segment(4)+1; ?>
        <?php foreach($data as $rs): ?>
        		<tr style="font-size:12px;">
                	<td style="vertical-align:middle; text-align: center;"><?php echo $n; ?></td>
                    <td style="vertical-align:middle;"><?php echo $rs->promotion_name; ?></td>
                    <td style="vertical-align:middle;"><?php if($rs->start =="0000-00-00"){ echo "-"; }else{ echo thaiShortDate($rs->start); } ?></td>
                    <td style="vertical-align:middle;"><?php if($rs->end =="0000-00-00"){ echo "-"; }else{ echo thaiShortDate($rs->end); } ?></td>
                    <td style="vertical-align:middle; text-align:center"><?php echo $rs->duration; ?></td>
                    <td style="vertical-align:middle; text-align:center"><?php echo number_format($rs->pcs); ?></td>
                    <td style="vertical-align:middle; text-align:right"><?php echo number_format($rs->amount,2); ?></td>
                    <td style="vertical-align:middle; text-align:right"><?php echo $rs->discount; ?></td>
                    <td style="vertical-align:middle; text-align:right"><?php echo $rs->price; ?></td>
                    <td align="right" style="vertical-align:middle; text-align:right">
                    	<a href="<?php echo base_url(); ?>shop/package/add/<?php echo $rs->id_promotion; ?>" >
                        	<button type="button" class="btn btn-success" <?php echo $access['edit']; ?>><i class="fa fa-plus"></i>ซื้อเพ็คเกจ</button></a>
                    </td>
                </tr>
               <?php $n++; ?>
        <?php endforeach; ?>
        <?php else : ?>
        <tr><td colspan="11" align="center" ><h4>---------- ไม่มีเพ็จเกจ -----------</h4></td></tr>
    <?php endif; ?>
		</table>
</div><!-- End col-lg-12 -->
<div class="col-lg-12"><?php echo $this->pagination->create_links(); ?></div>
</div><!-- End row -->
<?php endif; ?>
</div>