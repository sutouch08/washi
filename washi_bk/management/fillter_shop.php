<?
echo"<div class='row'>
			<form  method='post' id='form'>
				<div class='col-lg-3'>
				<div class='input-group'>
					<span class='input-group-addon'> ร้าน :</span>
					<select class='form-control' name='shop_id' id='shop_id'>"; echo getShopList($shop_id) ; echo "</select>
				</div>	
				</div>
				<div class='col-lg-3'>
					<div class='input-group'>
					<span class='input-group-addon'> เลือกวัน :</span>
					<input type='text' class='form-control' name='from_date' id='from_date'  value='"; if($from_date != "$today"){ echo date('d-m-Y',strtotime($from_date));} else { echo "เลือกวัน";} ; echo "'/>
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