<?php
require_once '../library/config.php';
require_once '../library/functions.php';
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

checkUser();
   $shop_id = $_COOKIE['shop_id'];
   $user_id = $_COOKIE['user_id'];
   $profile_id = $_COOKIE['profile_id'];
		$Qtotalprofile = dbQuery("SELECT * FROM tbl_profile where profile_id = '$profile_id' ");
		$rsprofile=dbFetchArray($Qtotalprofile);
		$menu1 = $rsprofile['menu1'];
		if($menu1 == "1"){
$page = (isset($_GET['content'])&& $_GET['content'] !='')?$_GET['content']:'';
switch($page){
	case 'saleReport':
		$content = "sale_report.php";
		$pageTitle = "Sale Report";
		break;
	case 'saleTotalReport':
		$content = 'sale_total_report.php';
		$pageTitle = 'Sale Total Report';
		break;
	case 'saleByShop':
		$content = 'sale_by_shop.php';
		$pageTitle = 'Sale Report';
		break;
	case 'saleDetailByShop' :
		$content = "sale_detail_by_shop.php";
		$pageTitle = "Sale Detail";
		break;
	case 'receivedDetailByShop':
		$content = "received_detail_by_shop.php";
		$pageTitle = "Received Detail";
		break;
	case 'notrecievedDetailByShop':
		$content = "not_received_detail_by_shop.php";
		$pageTitle = "Recievable Detail";
		break;
	case 'Customer':
		$content = 'customer.php';
		$pageTitle = 'Sale Report';
		break;
	case 'TranSport':
		$content = 'transport_shop_report.php';
		$pageTitle = 'TranSport Report';
		break;
	case 'Delivery':
		$content = 'transport_shop_delivery.php';
		$pageTitle = 'Delivery Report';
		break;
	case 'Delivery1':
		$content = 'transport_shop_delivery1.php';
		$pageTitle = 'Delivery Report';
		break;
	case 'DeSum':
		$content = 'transport_shop_sum.php';
		$pageTitle = 'Delivery Report';
		break;
	case 'factory':
		$content = 'transport_factory.php';
		$pageTitle = 'Factory Report';
		break;
	case 'factory_delivery':
		$content = 'transport_factory_delivery.php';
		$pageTitle = 'Factory Report';
		break;
	case 'factory_delivery1':
		$content = 'transport_factory_delivery1.php';
		$pageTitle = 'Factory Report';
		break;
	case 'factory_delivery2':
		$content = 'transport_factory_delivery2.php';
		$pageTitle = 'Factory Report';
		break;
	case 'factory_process':
		$content = 'factory_process.php';
		$pageTitle = 'Factory Report';
		break;
	case 'factory_process_detail':
		$content = 'transport_process_detail.php';
		$pageTitle = 'Factory Report';
		break;
	case 'qtyReport':
		$content = 'sale_qty_report.php';
		$pageTitle = 'Quantity Report';
		break;
	case 'qtyByShop':
		$content = "sale_qty_by_shop.php";
		$pageTitle = "Quantity Report By Shop";
		break;
	case 'Car':
		$content = "transport_car.php";
		$pageTitle = "Quantity Report By Shop";
		break;
	case 'Issue':
		$content = "issue.php";
		$pageTitle = "ยอดชิ้นงานที่เกิดปัญหาระหว่าซัก";
		break;
	default:
		$content = 'dashboard.php';
		$pageTitle = 'Management Dashboard';
		break;
}
		}else{
			header("location:../index.php");
		}
require_once 'template.php';
?>
