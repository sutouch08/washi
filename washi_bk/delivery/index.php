<?php
require_once '../library/config.php';
require_once '../library/functions.php';
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

checkUser();
$shop_id = $_COOKIE['shop_id'];
$page = (isset($_GET['content'])&& $_GET['content'] !='')?$_GET['content']:'';
switch($page){
	case 'new':
		$content = 'new_delivery.php';
		$pageTitle = 'New Delivery';
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
	default:
		$content = 'delivery_list.php';
		$pageTitle = 'Delivery Order';
		break;
}

$script    = array('delivery.js');

require_once 'template.php';
?>
