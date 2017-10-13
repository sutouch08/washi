<?php 
$content = "";

$page = (isset($_GET['content'])&& $_GET['content'] !='')?$_GET['content']:'';
switch($page){
	/********** สารบัญ  ********/
		case "toc" :
		$content = "toc.php";
		$title = "Table of contents";
		break;
		
		case 'login':
		$content = "back_end/login.php";
		$title = "เข้าใช้งานระบบ";
		break;
		
		case 'pre_data':
		$content = "admin/pre_data.php";
		$title = "เตรียมข้อมูล";
		break;
		
		case 'profile':
		$content = "admin/profile.php";
		$title = "สร้างโปรไฟล์";
		break;
		
		case 'permission':
		$content = "admin/permission.php";
		$title = "กำหนดสิทธิ์";
		break;
		
		case 'employee':
		$content = "admin/employee.php";
		$title = "เพิ่ม/แก้ไข พนักงาน";
		break;
		
		case 'user':
		$content = "admin/user.php";
		$title = "เพิ่ม/แก้ไข ผู้ใช้งาน";
		break;
		
		/***************  SHOP  *******************/
		case "order" :
		$content = "shop/order.php";
		$title = "รับออเดอร์";
		break;
		
		case "delete_order" :
		$content = "shop/delete_order.php";
		$title = "ลบ ออเดอร์";
		break;
		
		case "change_status" :
		$content = "shop/change_status.php";
		$title = "เปลี่ยนสถานะออเดอร์";
		break;
		
		case "add_customer" :
		$content = "shop/add_customer.php";
		$title = "เพิ่ม/แก้ไข ลูกค้า";
		break;
		
		case "package" :
		$content = "shop/package.php";
		$title = "ขายแพ็คเกจ";
		break;
		
		case "send_order" :
		$content = "shop/send_order.php";
		$title = "ส่งสินค้าไปโรงงาน";
		break;
		
		case "return_order" :
		$content = "shop/return_order.php";
		$title = "รับสินค้าคืนจากโรงงาน";
		break;
		
		case "finished" :
		$content = "shop/finished.php";
		$title = "ส่งสินค้าคืนลูกค้า";
		break;
		
		
		default :
		$content = "main.php";
		$title = "ยินดีต้อนรับ";
		break;
}

require_once 'template.php';

?>