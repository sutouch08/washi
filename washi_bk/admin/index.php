<?php
require_once '../library/config.php';
require_once '../library/functions.php';
//$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

checkPermission();
$page = (isset($_GET['content'])&& $_GET['content'] !='')?$_GET['content']:'';
switch($page){
	case 'user':
		$content = 'user.php';
		$pageTitle = 'Manage User';
		break;
	case 'editUser':
		$content = 'edit_user.php';
		$pageTitle = 'Edit User';
		break;
	case 'product':
		$content = 'product.php';
		$pageTitle = 'Manage Products';
		break;
	case 'category':
		$content = 'category.php';
		$pageTitle = 'Manage Category';
		break;
	case 'transport':
		$content = 'transport.php';
		$pageTitle = 'Manage Transport';
		break;
	case 'employee':
		$content = 'employee.php';
		$pageTitle = 'Manage Employee';
		break;
	case 'shop';
		$content = 'shop.php';
		$pageTitle = 'Manage Shop';
		break;
	case 'config':
		$content = 'configuration.php';
		$pageTitle = "Preference";
		break;
	case 'promo':
		$content = 'promotion.php';
		$pageTitle = "PROMOTION";
		break;
	case 'type':
		$content = 'type.php';
		$pageTitle = "Product Type";
		break;
	case 'Balance':
		$content = 'balance.php';
		$pageTitle = "Balance";
		break;	
	case 'Issue':
		$content = 'issue.php';
		$pageTitle = "ปัญหาการซัก";
		break;	
	default:
		$content = 'admin.php';
		$pageTitle = 'Dash Board';
		break;
}

$script    = array('admin.js');

require_once  'template.php';
 
 ?>

