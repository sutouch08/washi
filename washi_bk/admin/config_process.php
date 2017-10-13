<? 
require "../library/config.php";
require "../library/functions.php";
checkPermission();

if(isset($_GET['update_config'])){
	//อัพเดต urgent status
	dbQuery("UPDATE tbl_urgent SET urgent_date =".$_POST['urgent1'].", charge_up =".$_POST['charge_up1']." where urgent_id ='1'");
	$qr2= dbQuery("update tbl_urgent set urgent_date =".$_POST['urgent2'].", charge_up =".$_POST['charge_up2']." where urgent_id = 2");
	$qr3= dbQuery("update tbl_urgent set urgent_date =".$_POST['urgent3'].", charge_up =".$_POST['charge_up3']." where urgent_id = 3");
	//อัพเดต หมายเหตุ	
	$qr4= dbQuery("update tbl_config set config_value = '".$_POST['remark1']."' where config_name = 'remark1'");
	$qr5= dbQuery("update tbl_config set config_value ='".$_POST['remark2']."' where config_name = 'remark2'");
	$qr6= dbQuery("update tbl_promo set promo_discount ='".$_POST['promo_discount']."' where promo_id = '1'");
	//------------ return true if sucess
	header("location:index.php?content=config&update=success");
	}else{
	header("location:index.php?content=config&update=fail");
	}
	
	

?>