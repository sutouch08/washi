<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-heartbeat'></i>&nbsp; Moniter</h3>
    </div>
    
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
	<div class="col-lg-4">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<h3 class="panel-title"><i class="fa fa-home"></i>&nbsp; หน้าร้าน</h3>
            </div>
            <div class="panel-body">
            <table class="table table-striped">
            <thead><th style="width:35%">สาขา</th><th style="text-align:right">รอส่งโรงงาน</th><th style="text-align:right">รอส่งลูกค้า</th></thead>
            <?php if($shop != false) : ?>
            <?php $total_1 = 0; $total_2 =0; ?>
            <?php foreach($shop as $rs) : ?>
            <tr>
            	<td><?php echo getShopName($rs->id_shop); ?></td>
                <td align="right"><?php $qty_1 = $this->report_model->get_order_in_state($rs->id_shop, array(1,2)); if($qty_1 ==0){ echo "-"; }else{ echo number($qty_1); }   $total_1 += $qty_1; ?></td>
                <td align="right"><?php $qty_2 = $this->report_model->get_order_in_state($rs->id_shop, array(7)); if($qty_2 ==0){ echo "-"; }else{ echo number($qty_2); } $total_2 += $qty_2; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr><td align="right">รวม</td><td align="right"><?php echo number($total_1); ?></td><td align="right"><?php echo number($total_2); ?></td></tr>
            <?php endif; ?>
            </table>
            </div>
        </div><!-- end panel -->
     </div><!-- end col -->
     
      <div class="col-lg-4">
    	<div class="panel panel-danger">
        	<div class="panel-heading">
            	<h3 class="panel-title"><i class="fa fa-truck"></i>&nbsp; ระหว่างทาง</h3>
            </div>
            <div class="panel-body">
            <table class="table table-striped">
            <thead><th style="width:35%">สาขา</th><th style="text-align:right">ส่งโรงงาน</th><th style="text-align:right">ส่งร้าน</th></thead>
            <?php if($shop != false) : ?>
            <?php $total_1 = 0; $total_2 =0; ?>
            <?php foreach($shop as $rs) : ?>
            <tr>
            	<td><?php echo getShopName($rs->id_shop); ?></td>
                <td align="right"><?php $qty_1 = $this->report_model->get_order_in_state($rs->id_shop, array(3)); if($qty_1 ==0){ echo "-"; }else{ echo number($qty_1); }   $total_1 += $qty_1; ?></td>
                <td align="right"><?php $qty_2 = $this->report_model->get_order_in_state($rs->id_shop, array(6)); if($qty_2 ==0){ echo "-"; }else{ echo number($qty_2); }  $total_2 += $qty_2; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr><td align="right">รวม</td><td align="right"><?php echo number($total_1); ?></td><td align="right"><?php echo number($total_2); ?></td></tr>
            <?php endif; ?>
            </table>
            </div>
        </div><!-- end panel -->
     </div><!-- end col -->
        
        <div class="col-lg-4">
    	<div class="panel panel-info">
        	<div class="panel-heading">
            	<h3 class="panel-title"><i class="fa fa-university"></i>&nbsp; โรงงาน</h3>
            </div>
            <div class="panel-body">
            <table class="table table-striped">
            <thead><th style="width:35%">สาขา</th><th style="text-align:right">รอซัก</th><th style="text-align:right">รอส่ง</th></thead>
            <?php if($shop != false) : ?>
            <?php $total_1 = 0; $total_2 =0; ?>
            <?php foreach($shop as $rs) : ?>
            <tr>
            	<td><?php echo getShopName($rs->id_shop); ?></td>
                <td align="right"><?php $qty_1 = $this->report_model->get_order_in_state($rs->id_shop, array(4)); if($qty_1 ==0){ echo "-"; }else{ echo number($qty_1); }  $total_1 += $qty_1; ?></td>
                <td align="right"><?php $qty_2 = $this->report_model->get_order_in_state($rs->id_shop, array(5)); if($qty_2 ==0){ echo "-"; }else{ echo number($qty_2); } $total_2 += $qty_2; ?></td>
            </tr>
            <?php endforeach; ?>
            <tr><td align="right">รวม</td><td align="right"><?php echo number($total_1); ?></td><td align="right"><?php echo number($total_2); ?></td></tr>
            <?php endif; ?>
            </table>
            </div>
        </div><!-- end panel -->
     </div><!-- end col -->
</div>
<script>
setInterval(function(){ window.location.reload(); }, 300000);
</script>
<?php endif; ?>
</div>