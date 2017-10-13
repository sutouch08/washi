<?php
require_once '../library/config.php';
require_once '../library/functions.php';
$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];

checkUser();
$shop_id = $_COOKIE['shop_id'];
		$profile_id = $_COOKIE['profile_id'];
		$Qtotalprofile = dbQuery("SELECT * FROM tbl_profile where profile_id = '$profile_id' ");
		$rsprofile=dbFetchArray($Qtotalprofile);
		$menu3 = $rsprofile['menu3'];
		if($menu3 == "1"){
$page = (isset($_GET['content'])&& $_GET['content'] !='')?$_GET['content']:'';
switch($page){
	case 'Receive':
		$content = 'receive_delivery.php';
		$pageTitle = 'Receive Delivery';
		break;
	case 'NEW':
		$content = 'list_new.php';
		$pageTitle = 'NEW';
		break;
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
	case 'newprocess':
		$content = 'new_process.php';
		$pageTitle = 'NEW PROCESS';
		break;
	case 'QC':
		$content = 'qcprocess.php';
		$pageTitle = 'QC PROCESS';
		break;
	case 'Process':
		$content = 'process.php';
		$pageTitle = 'PROCESS';
		break;
	case 'listprocess':
		$content = 'listprocess.php';
		$pageTitle = 'PROCESS';
		break;
	case 'processlist':
		$content = 'process_list.php';
		$pageTitle = 'PROCESS';
		break;
	case 'finish':
		$content = 'finish.php';
		$pageTitle = 'PROCESS FINISH';
		break;
	case 'Finish':
		$content = 'finish_cus.php';
		$pageTitle = 'PROCESS FINISH';
		break;
	case 'detail':
		$content = 'order_detail_list.php';
		$pageTitle = ' Order Detail';
		break;
	case 'list':
		$content= 'order_list.php';
		$pageTitle = 'Order';
		break;
	case 'deliverylist':
		$content= 'delivery_list.php';
		$pageTitle = 'Delivery';
		break;
	case 'deliveryshop':
		$content= 'delivery.php';
		$pageTitle = 'Delivery SHOP';
		break;
	case 'deliveryhub':
		$content= 'delivery.php';
		$pageTitle = 'Delivery HUB';
		break;
	case 'deliverycus':
		$content= 'delivery.php';
		$pageTitle = 'Delivery Customer';
		break;
	case 'deliverypost':
		$content= 'delivery.php';
		$pageTitle = 'Delivery POST';
		break;
	case 'deliveryems':
		$content= 'delivery.php';
		$pageTitle = 'Delivery EMS';
		break;
	case 'deliveryEnd':
		$content= 'post_ems_list.php';
		$pageTitle = 'POST AND EMS';
		break;
	case 'checkbill':
		$content= 'check_bill.php';
		$pageTitle = 'CHECK BILL';
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
	case 'checkbilledit':
		$content= 'check_bill_edit.php';
		$pageTitle = 'CHECK BILL';
		break;
	case 'CheckCode':
		$content= 'check_code.php';
		$pageTitle = 'CheckCode';
		break;
	default:
		$content = 'factory.php';
		$pageTitle = 'Dash board';
		break;
}
$script = array('factory.js');
}else{
			header("location:../index.php");
		}
require_once 'template.php';
?>
