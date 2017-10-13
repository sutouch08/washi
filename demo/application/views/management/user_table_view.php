<?php /***********************************   ระบบตรวจสอบสิทธิ์  ******************************************/ ?>
<?php $access = valid_access($id_menu);  ?>
<?php if($access['view'] != 1) : ?>
<?php access_deny();  ?>
<?php else : ?>
<div class="container">
<div class='row'>
	<div class='col-lg-6'>
    	<h3 style='margin-bottom:0px; margin-top:0px;'><i class='fa fa-clock-o'></i>&nbsp; รายการบันทึกเวลา</h3>
    </div>
    
</div><!-- End Row -->
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:15px;' />
<div class="row">
<div class="col-lg-12"><h4 style="text-align:center">รายการบันทึกเวลา ประจำวันที่ <?php echo date("d-m-Y"); ?> </h4></div>
</div>
<hr style='border-color:#CCC; margin-top: 10px; margin-bottom:0px;' />
<div class="row">
	<div class="col-lg-12">
    <?php if($time_table != false) : ?>
    <table class="table table-stripped table-bordered">
    	<thead style="font-size:12px">
        	<th style="width:5%; text-align:center">ลำดับ</th><th style="width:15%; text-align:center">พนักงาน</th>
            <?php foreach($time_table as $rs) : ?>
            <th style="text-align:center"><?php echo shortTime($rs->start)." - ".shortTime($rs->end); ?></th>
            <?php endforeach; ?> 
        </thead>
    <?php if($employee != false) : ?>
    	<?php $n = 1; ?>
    	<?php foreach($employee as $ro) : ?>
        <tr style="font-size:12px"><td align="center"><?php echo $n; ?></td><td><?php echo getEmployeeName($ro->id_employee); ?></td>
        <?php foreach($time_table as $rs) : ?>
        <?php $from = date("Y-m-d")." ".$rs->start; $to = date("Y-m-d")." ".$rs->end; ?>
            <td align="center"><?php echo $this->user_model->isRecorded($ro->id_employee, $from, $to); ?></td>
            <?php endforeach; ?> 
            </tr>
            <?php $n++; ?>
        <?php endforeach; ?>
    <?php else : ?>
    <tr><td colspan="20"><h4 style="text-align:center">---------- ไม่มีพนักงาน -------------</h4></td></tr>
    <?php endif; ?>
       </table>
     <?php else : ?>
     		<h4 style="text-align:center">---------- ยังไม่ได้กำหนดตารางเวลา -------------</h4>
    <?php endif; ?>
    </div>
</div>
<script>
setInterval(function(){ window.location.reload(); }, 300000);
</script>
<?php endif; ?>
</div>