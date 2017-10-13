<?
echo"<div class='row'>
			<form  method='post' id='form'>
				<div class='col-lg-3 col-lg-offset-3'>
				<div class='input-group'>
					<span class='input-group-addon'> แสดงเป็น :</span>
					 <select class='form-control' name='view' id='view'>"; echo getViewList($view,$from_date);  echo "</select>
				</div>
				</div>
				<div class='col-lg-1'> หรือเลือก</div>
				<div class='col-lg-2'>
				<div class='input-group'>
					<span class='input-group-addon'> จาก :</span>
					<input type='text' class='form-control' name='from_date' id='from_date'  value='";
					 if(isset($_POST['from_date']) && $_POST['to_date'] && $_POST['from_date'] && $_POST['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($from_date));} elseif(isset($_GET['from_date']) && $_GET['to_date'] && $_GET['from_date'] && $_GET['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($from_date));} else { echo "เลือกวัน";} 
					 echo "'/>
				</div>			
				</div>
				<div class='col-lg-2'>
				<div class='input-group'>
					<span class='input-group-addon'>ถึง :</span>
				 <input type='test' class='form-control'  name='to_date' id='to_date' value='";
				  if(isset($_POST['from_date']) && $_POST['to_date'] && $_POST['from_date'] && $_POST['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($to_date));} elseif(isset($_GET['from_date']) && $_GET['to_date'] && $_GET['from_date'] && $_GET['to_date'] !="เลือกวัน"){ echo date('d-m-Y',strtotime($to_date));} else { echo "เลือกวัน";}  echo"' />
				</div>
				</div>
				<div class='col-lg-1'>
					<button type='button' class='btn btn-default' onclick='validate()'>แสดง</button>
				</div>
							
					</form>
                 
                </div>
                <!-- /.col-lg-12 -->
				<hr />";
?>