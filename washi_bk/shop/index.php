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
	case 'new':
		$content = 'add_order.php';
		$pageTitle = 'New Order';
		break;
	case 'edit':
		$content = 'edit_order.php';
		$pageTitle = 'Edit Order';
		break;
	case 'delete':
		$content = 'delete_order.php';
		$pageTitle = 'Delete Order';
		break;
	case 'barcode':
		$content = 'add_barcode.php';
		$pageTitle = 'Apply Barcode';
		break;
	case 'confirm_order':
		$content = 'confirm_order.php';
		$pageTitle = 'confirm order';
		break;
	case 'apply':
		$content = 'apply_barcode.php';
		$pageTitle = 'Apply Barcode';
		break;
	case 'show':
		$content = 'show_order.php';
		$pageTitle = 'SHOW ORDER';
		break;
	case 'bill':
		$content = 'bill.php';
		$pageTitle = 'BILL';
		break;
	case 'add_customer':
		$content = 'add_customer1.php';
		$pageTitle = 'BILL';
		break;
	case 'Edit':
		$content = 'from_edit_order.php';
		$pageTitle = 'EDIT ORDER';
		break;
	case 'list':
		$content = 'order_list.php';
		$pageTitle = 'Order List';
		break;
	case 'detail':
		$content = 'order_detail_list.php';
		$pageTitle = ' Order Detail';
		break;
	case 'newDelivery':
		$content = '../delivery/new_delivery.php';
		$pageTitle = 'New Delivery';
		break;
	case 'receive':
		$content = 'receive_delivery.php';
		$pageTitle = 'Receive Delivery';
		break;
	case 'receivecus':
		$content = 'receive_customer.php';
		$pageTitle = 'Receive Customer';
		break;
	case 'checkbill':
		$content= 'check_bill.php';
		$pageTitle = 'CHECK BILL';
		break;
	case 'checkbilledit':
		$content= 'check_bill_edit.php';
		$pageTitle = 'CHECK BILL';
		break;
	case 'editdelivery':
		$content= 'edit_delivery.php';
		$pageTitle = 'EDIT DELIVERY';
		break;
	case 'deldelivery':
		$content= 'delete_delivery.php';
		$pageTitle = 'DELETE DELIVERY';
		break;
	case 'EDIT':
		$content= 'from_edit_delivery.php';
		$pageTitle = 'EDIT DELIVERY';
		break;
	case 'check':
		$content= 'check_receive_cus.php';
		$pageTitle = 'CHECK';
		break;
	case 'credit':
		$content= 'credit_buy.php';
		$pageTitle = 'CREDIT';
		break;
	case 'promo':
		$content= 'promotion.php';
		$pageTitle = 'PROMOTION';
		break;
	case 'showPro':
		$content= 'show_promo.php';
		$pageTitle = 'PROMOTION';
		break;
	case 'customer':
		$content= 'customer.php';
		$pageTitle = 'CUSTOMER';
		break;
	case 'customer_detail':
		$content= 'customer_detail.php';
		$pageTitle = 'CUSTOMER';
		break;
	case 'balance':
		$content= 'balance.php';
		$pageTitle = 'BALANCE';
		break;
	case 'CheckBillList':
		$content= 'check_bill_not_list.php';
		$pageTitle = 'CheckBill';
		break;
	case 'CheckCode':
		$content= 'check_code.php';
		$pageTitle = 'CheckCode';
		break;
	default:
		$content = 'shop.php';
		$pageTitle = 'SHOP';
		break;
}

$script    = array('shop.js');
		}else{
			header("location:../index.php");
		}
require_once 'template.php';
?>

