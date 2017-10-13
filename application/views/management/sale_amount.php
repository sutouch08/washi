<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-dashboard'></i>&nbsp; รายงานยอดขาย</h3>
    </div>
    
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-2"><a href="<?php echo base_url()."management/report/sale_report/0"; ?>" ><button class="btn btn-info btn-block" >วันนี้</button></a></div>
<div class="col-lg-2"><a href="<?php echo base_url()."management/report/sale_report/7"; ?>" ><button class="btn btn-primary btn-block" >7 วันล่าสุด</button></a></div>
<div class="col-lg-2"><a href="<?php echo base_url()."management/report/sale_report/15"; ?>" ><button class="btn btn-success btn-block" >15 วันล่าสุด</button></a></div>
<div class="col-lg-2"><a href="<?php echo base_url()."management/report/sale_report/30"; ?>" ><button class="btn btn-warning btn-block" >30 วันล่าสุด</button></a></div>
<div class="col-lg-2"><a href="<?php echo base_url()."management/report/sale_report"; ?>" ><button class="btn btn-danger btn-block" >เดือนนี้</button></a></div>

</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row"><div class="col-lg-12"><h4 style="text-align:center">รายงานยอดขาย วันที่ &nbsp; <?php echo date("d/m/Y",strtotime(thaiShortDate($from))); ?>&nbsp; ถึงวันที่ &nbsp;<?php echo date("d/m/Y",strtotime(thaiShortDate($to))); ?></h4></div></div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
<div class="col-lg-12">
<table class="table table-striped">
<thead>
<th style="width:5%; text-align:center">ลำดับ</th>
<th style="width:25%">สาขา</th>
<th style="width:25%; text-align:right">ยอดเงินที่เปิดบิล</th>
<th style="width:25%; text-align:right">ยอดเงินที่รับสินค้าแล้ว</th>
<th style="width:25%; text-align:right">ยอดเงินที่ค้างรับสินค้า</th>
</thead>
<?php if($data != false) : ?>
<?php $n = 1; $total_amount =0; $total_complete = 0; $total_incomplete = 0; ?>
<?php foreach($data as $rs) :?>
<?php 
$amount = $this->report_model->sale_amount($rs->id_shop, $from, $to);
$complete = $this->report_model->complete_amount($rs->id_shop, $from, $to);
$incomplete = $this->report_model->incomplete_amount($rs->id_shop, $from, $to);
?>
<tr>
<td align="center"><?php echo $n; ?></td><td><?php echo getShopName($rs->id_shop); ?></td>
<td align="right"><?php echo number($amount,2); ?></td>
<td align="right"><?php echo number($complete,2); ?></td>
<td align="right"><?php echo number($incomplete,2); ?></td>
</tr>
<?php $total_amount += $amount; $total_complete += $complete; $total_incomplete += $incomplete; ?>
<?php $n++; ?>
<?php endforeach; ?>
<tr><td colspan="2" align="right"><strong>รวม </strong></td><td align="right"><?php echo number($total_amount,2); ?></td><td align="right"><?php echo number($total_complete,2); ?></td><td align="right"><?php echo number($total_incomplete,2); ?></td></tr>
<?php endif; ?>
</table>
</div>
</div><!-- End Row -->

<?php endif; ?>
</div>