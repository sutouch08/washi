<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
	case 'order':
		add_order_code();
		break;
	case 'product':
		add_product_code();
		break;
	case 'delete_code':
		delete_product_code();
		break;
	default :
	header("location:index.php?content=apply&order_id=".$order_id);
}

function add_order_code()
{
	if(isset($_POST['order_id'])&&$_POST['order_code'] !='')
	{	
		$order_id = $_POST['order_id'];
		$order_code = $_POST['order_code'];
		$status = $_POST['status'];
		$sql = "UPDATE tbl_order SET order_code ='".$order_code."' ,status=".$status." WHERE order_id = ".$order_id;
		dbQuery($sql);
		check_product_code($order_id);
		header("location:index.php?content=apply&order_id=".$order_id);
	}
}

function add_product_code()
{
	if(isset($_POST['detail_id']) && $_POST['product_code'] !='' && $_POST['order_id'] !='')
	{
		$order_id = $_POST['order_id'];
		$detail_id = $_POST['detail_id'];
		$product_code = $_POST['product_code'];
		$status = $_POST['status'];
		$sql = "UPDATE tbl_order_detail SET product_code = '".$product_code."' , status =".$status." WHERE detail_id = ".$detail_id;
		dbQuery($sql);
		check_product_code($order_id);
		header("location:index.php?content=apply&order_id=".$order_id);
	
	}
}

function delete_product_code()
{
	if(isset($_GET['detail_id'])&& $_GET['detail_id'] !='')
	{
		$order_id = $_GET['order_id'];
		$detail_id = $_GET['detail_id'];
		$status = 1;		
		$sql="UPDATE tbl_order_detail SET product_code = '' , status =".$status." WHERE detail_id = ".$detail_id;
		dbQuery($sql);
		check_product_code($order_id);
		header("location:index.php?content=apply&order_id=".$order_id);
	}
}

	
?>