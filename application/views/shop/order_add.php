<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-file-o'></i>&nbsp; ออเดอร์</h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        <a href="<?php echo base_url(); ?>shop/order">
        		<button class='btn btn-danger' ><i class='fa fa-times'></i>&nbsp; ยกเลิก</button>
         </a>
         <a href="<?php echo base_url()."shop/customer"; ?>">
         <button type="button" id="add_customer" class="btn btn-primary"><i class="fa fa-plus"></i>เพิ่มลูกค้าใหม่</button>
         </a>
        		<button class='btn btn-success'<?php echo $access['add']; ?> id="btn_save"><i class='fa fa-save'></i>&nbsp; บันทึก</button>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<?php echo form_open(base_url()."shop/order/add_order"); ?>
<input type="hidden" name="id_shop" id="id_shop" value="<?php echo $this->session->userdata("id_shop"); ?>" />
<input type="hidden" name="id_employee" id="id_employee" value="<?php echo $this->session->userdata("id_employee"); ?>" />
<input type="hidden" id="item_selected" value="0"  />
<div class="row">
<div class="col-lg-12"><!-- col 1 -->
	<div class="row"><!-- row 1 -->
    	<div class="col-lg-4">
        	<div class="input-group">
                <span class="input-group-addon">เลือกลูกค้า</span>
                <input type="hidden" name="id_customer" id="id_customer" />
                <input name="customer" id="customer" class="form-control" placeholder="เลือกลูกค้า"  type="text"/>
       		</div><!--  input-group --> 
        </div><!--  col-lg-4 -->  
       <div class="col-lg-3">
        	<div class="input-group">
                <span class="input-group-addon">การจัดส่ง</span>
                <select name="id_shipping" id="id_shipping" class="form-control">
                	<?php echo selectShipping(); ?>
                </select>
       		</div><!--  input-group --> 
        </div><!--  col-lg-4 --> 
        <div class="col-lg-2">
        	<div class="input-group">
                <span class="input-group-addon">เงื่อนไข</span>
                <select name="id_urgent" id="id_urgent" class="form-control">
                	<?php echo selectUrgent(); ?>
                </select>
                <?php $day = urgent_day(); ?>
       		 <input type="hidden" id="urgen_1" value="<?php echo $day['1']; ?>" />
             <input type="hidden" id="urgen_2" value="<?php echo $day['2']; ?>" />
             <input type="hidden" id="urgen_3" value="<?php echo $day['3']; ?>" />
       		</div><!--  input-group --> 
        </div><!--  col-lg-4 --> 
		
        <div class="col-lg-3">
        	<div class="input-group">
                <span class="input-group-addon">กำหนดรับ</span>
                <input type="text" class="form-control" name="due_date" id="due_date" value="<?php echo date("d-m-Y", strtotime("+3 days")); ?>" />
       		</div><!--  input-group --> 
        </div><!--  col-lg-4 -->
        <div class="col-lg-12"><button type="button" id="btn_submit" style="display:none;">save</button> &nbsp;</div>
    	<div class="col-lg-9">
        	<div class="input-group">
                <span class="input-group-addon">หมายเหตุ</span>
                <input name="remark" id="remark" class="form-control" placeholder="ใส่หมายเหตุ (ถ้ามี)"  type="text" value=""/>
       		</div><!--  input-group --> 
        </div><!--  col-lg-8 --> 
        <div class="col-lg-3">
        	<div class="input-group">
                <span class="input-group-addon">กำหนดเสร็จ</span>
                <span class="form-control" id="ready_on"><?php echo date("d-m-Y", strtotime("+3 days")); ?></span>
       		</div><!--  input-group --> 
        </div><!--  col-lg-4 -->
	</div><!-- row2 --> 
</div>   <!--  col 1 --> 
</div><!-- row -->
<hr style='border-color:#CCC; margin-top: 15px; margin-bottom:15px;' />
<div class="row">
<div class='col-lg-12'>
	<ul class='nav nav-tabs' role='tablist' style='background-color:#EEE'>
<?php $category = $this->order_model->get_category(); ?>
<?php foreach($category as $ca) : ?>
    	<li class=''><a href='#cat-<?php echo $ca->id_category; ?>' tabindex='-1' role='tab' data-toggle='tab'><?php echo $ca->category_name; ?></a></li>
<?php endforeach; ?>  
    </ul>
</div>
</div> 

<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />	
<div class='tab-content'>
<?php $r = 0; ?>
<?php foreach($category as $cs) : ?>
<div class="tab-pane <?php if($r == 0){ echo "active"; } ?>" id="cat-<?php echo $cs->id_category; ?>">
<div class="row">
<?php $order_sheet = $this->order_model->get_product_by_category($cs->id_category); ?>
<?php foreach($order_sheet as $product) : ?>
<div class="col-lg-6" style="margin-bottom:10px; padding-left:0px; padding-bottom:10px; border-bottom:solid 1px #CCC">
    	<div class="col-lg-6" style="padding-left:5px; vertical-align:middle'"><?php echo $product->product_name; ?><input type="hidden" name="id_product[<?php echo $product->id_product; ?>]" id="id_product_<?php echo $product->id_product; ?>" value="<?php echo $product->id_product; ?>" /></div>
        <div class="col-lg-2" style="padding-left:0px;"><input type="text" class="form-control input-sm" name="price[<?php echo $product->id_product; ?>]" id="price_<?php echo $product->id_product; ?>" value="<?php echo $product->price; ?>" /></div>
        <div class="col-lg-2"><input type="text" class="form-control input-sm xs" name="qty[<?php echo $product->id_product; ?>]" id="qty_<?php echo $product->id_product; ?>" /></div>
        <div class="col-lg-2"><input type="text" id="amount_<?php echo $product->id_product; ?>" class="input-label" readonly="readonly" value="0" /></div>
       			 <script> 
        			$("#qty_<?php echo $product->id_product; ?>").keyup(function(e) {
						var qty = $(this).val();
						var price = $("#price_<?php echo $product->id_product; ?>").val();
						var amount = qty*price;
						$("#amount_<?php echo $product->id_product; ?>").val(amount);
					}).trigger("#qty_<?php echo $product->id_product; ?>");
				</script>
</div>
<?php $r++; ?>
<?php endforeach; ?>	
</div></div>
<?php endforeach; ?>
<?php echo form_close(); ?>
</div>

<div class='row'>

</div><!-- End row -->
<?php endif; ?>
</div>
<script>
	$("#due_date").datepicker({
	dateFormat: "dd-mm-yy", minDate: $("#urgen_1").val()
});
	
	$("#id_urgent").change(function() {
    var i = null;
	var x = null;
    $("#id_urgent option:selected").each(function() {
      i = $(this).val();
	  x = $("#urgen_"+i).val();  
    });
    $("#due_date").datepicker( "option", "minDate", x);
  })
  .trigger( "#id_urgent" );

	$(document).ready(function(e) {
		var id_shop = $("#id_shop").val();
    $("#customer").autocomplete({
		source:"<?php echo base_url(); ?>shop/customer/find/"+id_shop,
		autoFocus: true,
		close: function(event,ui){
			var data = $("#customer").val();
			var arr = data.split(" : ");
			var id = arr[0];
			var code = arr[1];
			var name = arr[2];
			var phone = arr[3];
			$("#id_customer").val(id);
			$("#customer").val(name);
		}
	});			
});
function detect_qty(){
	var total =0;
	$(".xs").each(function(index, element) {
		var i = parseInt($(this).val());
		if(isNaN(i)){ 
        	total += 0;
		}else{
			total += 1;
		}
    });
	return total;
}
$("#btn_save").click(function(e){
	detect_qty();
	var id_customer = $("#id_customer").val();
	var due_date = $("#due_date").val();
	var empty = detect_qty();
	if(id_customer ==""){
		alert("กรุณาเลือกลูกค้า");
	}else if(due_date ==""){
		alert("กรุณาตรวจสอบ วันที่กำหนดรับ");
	}else if(empty ==0){
		alert("ยังมีได้เพิ่มสินค้าใดๆในฟอร์ม");
	}else{
		$("#btn_submit").attr("type","submit");
		$("#btn_submit").click();
	}
});

 

</script>