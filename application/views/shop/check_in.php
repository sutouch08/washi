<div class="container">
<div class="row">
<?php if(isset($id_employee)&&isset($id_shop)) : ?>
<div class="col-lg-4 col-lg-offset-4" style="margin-top:15px;">
	<a href="<?php echo $this->home."/insert_to_table/".$id_employee."/".$id_shop; ?>">
	<button type="button" class="btn btn-primary btn-lg btn-block" ><h1><i class="fa fa-clock-o"></i>&nbsp; บันทึกเวลา</h1></button>
    </a>
 </div>
 </div>
 <hr>
 <div class="row">
 <div class="col-lg-12">
 <table class="table table-striped">
 <thead><th style="width:20%;">ช่วงเวลา</th><th style="width:20%;">เริ่มต้น</th><th style="width:20%;">สิ้นสุด</th><th style="width:20%;">สถานะ</th></thead>
 <?php if($data != "") : ?>
 <?php foreach($data as $rs) : ?>
 <tr><td><?php echo $rs->name; ?></td><td><?php echo $rs->start; ?></td><td><?php echo $rs->end; ?></td>
 <td>
 <?php if(time_checked($id_employee, $id_shop, date("Y-m-d")." ".$rs->start, date("Y-m-d")." ".$rs->end)) : ?>
		 <span style="color:#8CC152;">บันทึกแล้ว</span>
<?php else: ?>
         <span style="color:#DA4453;">ยังไม่บันทึก</span>
<?php endif; ?>
</td>						
 </tr>
 <?php endforeach; ?>
 <?php endif; ?>
    
<?php else: ?>
<h4>------------- ไม่มีข้อมูล ------------</h4>    
<?php endif; ?> 
</div>    
</div>
</div>