<?php
require_once '../library/config.php';
require_once '../library/functions.php';
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

checkUser();
$shop_id = $_COOKIE['shop_id'];
 		$profile_id = $_COOKIE['profile_id'];
		$Qtotalprofile = dbQuery("SELECT * FROM tbl_profile where profile_id = '$profile_id' ");
		$rsprofile=dbFetchArray($Qtotalprofile);
		$menu2 = $rsprofile['menu2'];
		if($menu2 == "1"){
$page = (isset($_GET['content'])&& $_GET['content'] !='')?$_GET['content']:'';
switch($page){
	case 'list_new':
		$content = 'listnew_delivery.php';
		$pageTitle = 'New Delivery';
		break;
	case 'new_shop':
		$content = 'new_delivery.php';
		$pageTitle = 'New Delivery';
		break;
	case 'new_factory':
		$content = 'new_delivery.php';
		$pageTitle = 'New Delivery';
		break;
	case 'list_Receive':
		$content = 'listreceive_delivery.php';
		$pageTitle = 'Receive Delivery';
		break;
	case 'Receive_shop':
		$content = 'receive_delivery.php';
		$pageTitle = 'Receive Delivery';
		break;
	case 'Receive_factory':
		$content = 'receive_delivery.php';
		$pageTitle = 'Receive Delivery';
		break;
	case 'edit':
		$content = 'edit_delivery.php';
		$pageTitle = 'Edit Delivery';
		break;
	case 'delete':
		$content = 'delete_delivery.php';
		$pageTitle = 'Delete Delivery';
		break;
	case 'history':
		$content = 'delivery_history.php';
		$pageTitle = 'Delivery History';
		break;
	case 'Edit':
		$content = 'from_edit_delivery.php';
		$pageTitle = 'Edit Delivery';
		break;
	case 'CheckCode':
		$content= 'check_code.php';
		$pageTitle = 'CheckCode';
		break;
	default:
		$content = 'delivery_list.php';
		$pageTitle = 'Delivery Order';
		break;
}
$script    = array('hub.js');
}else{
			header("location:../index.php");
		}
require_once 'template.php';
?>
