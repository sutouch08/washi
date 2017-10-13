<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-users'></i>&nbsp; ลูกค้า </h3>
    </div>
    <div class="col-lg-6">
    	<p class='pull-right'>
        	<a href="<?php echo base_url(); ?>admin/customer">
        		<button class='btn btn-warning'><i class='fa fa-reply'></i>&nbsp; กลับ</button>
             </a>
         </p>
    </div>
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 0px; margin-bottom:15px;' />
<div class='row'>
<?php if($data !=false) : ?>
<?php foreach($data as $rs) : ?>
<div class='col-lg-4' style="text-align:right">รหัสลูกค้า</div><input type="hidden" id="valid_code" value="0"/>
<div class="col-lg-4"><?php echo $rs->customer_code; ?></div><div class="col-lg-4"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ชื่อลูกค้า</div>
<div class="col-lg-4"><?php echo $rs->customer_name; ?></div><div class="col-lg-4"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เพศ</div>
<div class="col-lg-4"><?php if($rs->gender == "male"){ $gender = "ชาย"; }else if($rs->gender== "female"){ $gender = "หญิง"; }else{ $gender = "ไม่ระบุ"; } ?>
<?php echo $gender; ?>
</div><div class="col-lg-4"><span style="color:red";></span></div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">อีเมล์</div>
<div class="col-lg-4"><?php echo $rs->email; ?></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">เบอร์โทรศัพท์</div>
<div class="col-lg-4"><?php echo $rs->phone; ?></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class='col-lg-4' style="text-align:right">ที่อยู่</div>
<div class="col-lg-4"><?php echo $rs->address; ?></div><div class="col-lg-4">&nbsp;</div>
<div class="col-lg-12">&nbsp;</div>
<div class="col-lg-4 col-lg-offset-4">***  แก้ไขข้อมูลล่าสุด <?php echo thaiDate($rs->date_upd); ?> ***</button></div>
<?php endforeach; ?>
<?php endif; ?>
</div><!-- End row -->

<?php endif; ?>
</div>