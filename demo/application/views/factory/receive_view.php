<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-cloud-download'></i>&nbsp; รับสินค้าเข้า</h3>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-12">
<table class="table table-striped">
<thead><tr><th style="width:5%; text-align:center">ลำดับ</th><th style="width:15%">เลขที่อ้างอิง</th><th style="width:15%">ต้นทาง</th><th style="width:15%">ทะเบียนรถ</th><th style="text-align:right">การกระทำ</th></tr></thead>
<?php if($data != false) : ?>
<?php $n = 1; ?>
<?php foreach( $data as $rs) : ?>
<tr><td align="center"><?php echo $n; ?></td><td><?php echo $rs->reference; ?></td><td><?php echo getShopName($rs->id_shop); ?></td><td><?php echo getCarPlate($rs->id_car); ?></td>
<td align="right"><a href="<?php echo base_url()."factory/receive/add/".$rs->id_delivery; ?>" ><button type="button" class="btn btn-success">รับเข้า</button></a></td></tr>
<?php endforeach; ?>
<?php else : ?>
<tr><td colspan="5" align="center"><h4>----------- ไม่มีรายการ  -------------</h4></td></tr>
<?php endif; ?>
</table>
<script>
	$("#btn_save").click(function(e) {
		var checked = $('input[name="id_order_detail[]"]:checked').length;
		alert(checked);
		if(checked <1){
			alert("ไม่มีรายการครบเลยใช่มั้ย");
		}else{
        $("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
		$("#btn_submit").attr("type","button");
		}
    });
	
	$("#btn_ok").click(function(){
		$("#btn_ok").attr("type", "submit");
		$("#btn_ok").click();
		$("#btn_ok").attr("type", "button");
	});
</script>
<?php endif; ?>
</div>