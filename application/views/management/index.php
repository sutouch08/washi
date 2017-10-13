<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<?php $m = date("m"); ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-dashboard'></i>&nbsp; Dash Board</h3>
    </div>
    
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class='row'>
	<div class="col-lg-4">
		<div class="panel panel-success">
			<div class="panel-heading"><h3 class="panel-title">ยอดขาย &nbsp; (<?php echo thaiMonthName($m); ?>)</h3></div>
			<div class="panel-body" style="background:#A0D468">
            	<i class="fa fa-money fa-3x" style="color:white; opacity:0.5; float:left; margin-right:5px;"></i>
				<span style="color:white; display:block; text-align:right; font-size:2.1em; font-weight:600"><?php echo number($total_amount,2); ?></span>
			</div>
		</div>
	</div>
	<div class="col-lg-4">
		<div class="panel panel-primary">
			<div class="panel-heading"><h3 class="panel-title">ส่งแล้ว &nbsp; (<?php echo thaiMonthName($m); ?>)</h3></div>
			<div class="panel-body" style="background:#4FC1E9">
            	<i class="fa fa-money fa-3x" style="color:white; opacity:0.5; float:left; margin-right:5px;"></i>
				<span style="color:white; display:block; text-align:right; font-size:2.1em; font-weight:600"><?php echo number($complete_amount,2); ?></span>
			</div>
		</div>
	</div>
    
    <div class="col-lg-4">
		<div class="panel panel-warning">
			<div class="panel-heading"><h3 class="panel-title">ค้างส่ง &nbsp; (<?php echo thaiMonthName($m); ?>)</h3></div>
			<div class="panel-body" style="background:#FFCE54">
            	<i class="fa fa-money fa-3x" style="color:white; opacity:0.5; float:left; margin-right:5px;"></i>
				<span style="color:white; display:block; text-align:right; font-size:2.1em; font-weight:600"><?php echo number($incomplete_amount,2); ?></span>
			</div>
		</div>
	</div>
</div><!-- End Row -->
<div class="row">
          <div class="col-lg-4">
            <div class="panel panel-success">
              <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-tag"></i>&nbsp;&nbsp; ยอดขาย &nbsp;  (<?php echo thaiMonthName($m); ?>)</h4></div>
              <div class="panel-body">
              <table class="table table-striped">
              <?php $shops = $this->report_model->get_shop_list(); ?>
              <?php if($shops != false) : ?>
              <?php foreach($shops as $rs) : ?>
              <tr><td><?php echo getShopName($rs->id_shop); ?></td><td align="right"><?php echo number($this->report_model->sale_amount($rs->id_shop, $from, $to),2); ?></td></tr>
              <?php endforeach; ?>
              <?php endif; ?>
              </table>
              </div> 
            </div>
       	 </div>
         
         <div class="col-lg-4">
            <div class="panel panel-primary">
              <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-tag"></i>&nbsp;&nbsp; ยอดส่งแล้ว &nbsp;  (<?php echo thaiMonthName($m); ?>)</h4></div>
              <div class="panel-body">
              <table class="table table-striped">
              <?php $shops = $this->report_model->get_shop_list(); ?>
              <?php if($shops != false) : ?>
              <?php foreach($shops as $rs) : ?>
              <tr><td><?php echo getShopName($rs->id_shop); ?></td><td align="right"><?php echo number($this->report_model->complete_amount($rs->id_shop, $from, $to),2); ?></td></tr>
              <?php endforeach; ?>
              <?php endif; ?>
              </table>
              </div> 
            </div>
       	 </div>
         
         <div class="col-lg-4">
            <div class="panel panel-warning">
              <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-tag"></i>&nbsp;&nbsp; ยอดค้างส่ง &nbsp;  (<?php echo thaiMonthName($m); ?>)</h4></div>
              <div class="panel-body">
              <table class="table table-striped">
              <?php $shops = $this->report_model->get_shop_list(); ?>
              <?php if($shops != false) : ?>
              <?php foreach($shops as $rs) : ?>
              <tr><td><?php echo getShopName($rs->id_shop); ?></td><td align="right"><?php echo number($this->report_model->incomplete_amount($rs->id_shop, $from, $to),2); ?></td></tr>
              <?php endforeach; ?>
              <?php endif; ?>
              </table>
              </div> 
            </div>
       	 </div>
<!-- ************************************************  ปริมาณ ค้างรับ ค้างส่ง *******************************************-->
	<div class="col-lg-4">
    	<div class="panel panel-primary">
        	<div class="panel-heading">
            	<h3 class="panel-title"><i class="fa fa-home"></i>&nbsp; หน้าร้าน</h3>
            </div>
            <div class="panel-body">
            <table class="table table-striped">
            <thead><th style="width:35%">สาขา</th><th style="text-align:right">รอส่งโรงงาน</th><th style="text-align:right">รอส่งลูกค้า</th></thead>
            <?php $shops = $this->report_model->get_shop_list(); ?>
            <?php if($shops != false) : ?>
            <?php $total_1 = 0; $total_2 =0; ?>
            <?php foreach($shops as $rs) : ?>
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
             <?php $shops = $this->report_model->get_shop_list(); ?>
            <?php if($shops != false) : ?>
            <?php $total_1 = 0; $total_2 =0; ?>
            <?php foreach($shops as $rs) : ?>
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
             <?php $shops = $this->report_model->get_shop_list(); ?>
            <?php if($shops != false) : ?>
            <?php $total_1 = 0; $total_2 =0; ?>
            <?php foreach($shops as $rs) : ?>
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

  <!-- ************************************************  ปริมาณ ค้างรับ ค้างส่ง *******************************************-->       
         <div class="col-lg-12">
            <div class="panel panel-success">
              <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-tag"></i>&nbsp;&nbsp; ปริมาณชิ้นงาน &nbsp;  (<?php echo thaiMonthName($m); ?>)</h4></div>
              <div class="panel-body">
              <?php $category = $this->report_model->get_category(); ?>
              <?php if($category != false) : ?>
                    <table class="table table-striped">
                    <thead><th style="width:20%">สาขา</th>
                    <?php foreach($category as $ro) :?>
                    <th style="width:10%; text-align:right"><?php echo getCategoryName($ro->id_category); ?></th>
                    <?php endforeach; ?>
                    <th style="width:10%; text-align:right">รวม</th>
                    </thead>
                    <?php endif; ?>
                    
                    <?php if($shops != false && $category != false) : ?>
                    <?php foreach($shops as $rs) : ?>
                    <tr>
                    <td><?php echo getShopName($rs->id_shop); ?></td>
                    <?php foreach($category as $ro) : ?>
                    <td align="right"><?php echo number($this->report_model->get_qty_by_shop($rs->id_shop, $ro->id_category, $from, $to)); ?></td>
                    <?php endforeach; ?>
                    <td align="right"><?php echo number($this->report_model->get_total_qty_by_shop($rs->id_shop, $from, $to)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if($category != false) : ?>
                    <tr>
                    <td align="right">รวม</td>
                    <?php foreach($category as $ro) :?>
                    <td align="right"><?php echo number($this->report_model->get_total_qty_by_category($ro->id_category, $from, $to)); ?></td>
                    <?php endforeach; ?>
                    <td align="right"><?php echo number($this->report_model->get_total_qty($from, $to)); ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php endif; ?>
                    </table>
              </div> 
            </div>
       	 </div>
 </div>
<div class="row">
          <div class="col-lg-6">
            <div class="panel panel-info">
              <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bar-chart"></i>&nbsp;&nbsp; ยอดขาย 15 วันล่าสุด</h4></div>
              <div class="panel-body"><div id="morris-chart-line" style="height:150px;"></div></div> 
            </div>
        </div>
        
         <div class="col-lg-6">
            <div class="panel panel-warning">
              <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bar-chart"></i>&nbsp;&nbsp; ปริมาณชิ้นงาน 15 วันล่าสุด</h4></div>
              <div class="panel-body"><div id="qty_chart" style="height:150px;"></div></div> 
            </div>
        </div>
 </div>
 <h3>&nbsp;</h3>
<?php $data = $this->index_model->get_sale_last_days(15); ?>
<?php $total_qty = $this->index_model->get_qty_last_days(15); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/morris-0.4.3.min.css"/>
<script src="<?php echo base_url(); ?>assets/js/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/morris-0.4.3.min.js"></script> 
<script>
var line = new Morris.Bar({
  element: 'morris-chart-line',
  data: [	
  <?php foreach($data as $rs) { echo "{ d: '".$rs['date']."', amount: '".numberOnly($rs['amount'])."' },"; } ?>
  ],
  xkey: 'd' ,
  ykeys:['amount'],
  labels: ['จำนวนเงิน'],
  smooth: false, 
  parseTime: false,
  hideHover: 'auto',
  lineWidth: 1,
  pointSize: 3,
  yLabelFormat: function(y){ return y = Math.round(y); },
  xLabelMargin:2
});

var qty = new Morris.Bar({
  element: 'qty_chart',
  data: [	
  <?php foreach($total_qty as $rs) { echo "{ d: '".$rs['date']."', amount: '".numberOnly($rs['amount'])."' },"; } ?>
  ],
  xkey: 'd' ,
  ykeys:['amount'],
  labels: ['ชิ้น'],
  smooth: false, 
  parseTime: false,
  hideHover: 'auto',
  lineWidth: 1,
  pointSize: 3,
  yLabelFormat: function(y){ return y = Math.round(y); },
  xLabelMargin:2
});
</script>
<script>
setInterval(function(){ window.location.reload(); }, 300000); /// update every 5 min
</script>
<?php endif; ?>
</div>