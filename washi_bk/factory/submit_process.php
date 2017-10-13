<?php
require_once '../library/config.php';
require_once '../library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
	case 'add_process':
		add_process();
		break;
	case 'addproduct':
		addproduct();
		break;
	case 'delproduct':
		delete_process();
		break;
	default :
	header("location:index.php?content=apply&order_id=".$order_id);
}
function get_processID(){
		$sql="select  * from fac_process order by  process_no DESC"; 
		$Qtotal = dbQuery($sql);
		$rs=dbFetchArray($Qtotal);
		$sumtdate = date("y");
		$m = date("m");
		$num = "0001";
		$str = "$rs[process_no];";
		$s = 6; // start from "0" (nth) char
		$l = 6; // get "3" chars
		$str2 = substr_unicode($str, $s ,10)+1;
		$str1 = substr_unicode($str, 0 ,$l);
		if($str1=="PO$sumtdate$m"){  
		$order_no = "PO$sumtdate$m".sprintf("%04d",$str2)."";
		}else{
		$order_no = "PO$sumtdate$m$num";
		}
		return $order_no;
}
function add_process()
{
	if(isset($_POST['em_code'])!='')
	{	
		$em_code = $_POST['em_code'];
		$sql="SELECT * FROM tbl_employee WHERE em_code = '$em_code'";
		$Qtotal = dbQuery($sql);
		$rs=dbFetchArray($Qtotal);
		$em_id = $rs['em_id'];
		if($em_id != ""){ 
		$order_no = get_processID();
		$sql_o = "insert into fac_process(process_no,em_id,status)VALUES('$order_no','$em_id','1')";
		$db_query=dbQuery($sql_o) or die ("$sql_o");
		$sql="SELECT * FROM fac_process WHERE process_no = '$order_no'";
		$Qtotal = dbQuery($sql);
		$rs1=dbFetchArray($Qtotal);
		$process_id = $rs1['process_id'];
		header("location:index.php?content=newprocess&process_id=".$process_id);
		}else{
		header("location:index.php?content=newprocess");	
		}
	}
}
function addproduct()
{
	if(isset($_POST['process_id']) && $_POST['product_code'] !='')
	{
		$process_id = $_POST['process_id'];
		$product_code = $_POST['product_code'];
		$Qtotal = dbQuery("SELECT * FROM tbl_order_detail WHERE product_code = '$product_code' and status = '6'");
		$rs1=dbFetchArray($Qtotal);
		$detail_id = $rs1['detail_id'];
		$order_id = $rs1['order_id'];
		if($detail_id != ''){
		$sql_o = "insert into fac_process_detail(process_id,detail_id,status)VALUES('$process_id','$detail_id','1')";
		$db_query=dbQuery($sql_o) or die ("$sql_o");
		$sql="UPDATE tbl_order_detail SET status = '7' WHERE detail_id = ".$detail_id;
		dbQuery($sql);
		$sql="UPDATE tbl_order SET status = '7' WHERE order_id = ".$order_id;
		dbQuery($sql);
		$qr = dbQuery("SELECT * FROM fac_process WHERE process_id = '$process_id'");
		$rs=dbFetchArray($qr);
		$qty = $rs['qty']+1;
		$sql="UPDATE fac_process SET qty = '$qty' WHERE process_id = ".$process_id;
		dbQuery($sql);
		header("location:index.php?content=newprocess&process_id=".$process_id);
		}else{
		$not_order = 'FAIL !!';
		header("location:index.php?content=newprocess&process_id=$process_id&not_order=$not_order");
		}
	}
	
}
function delete_process()
{
	if(isset($_GET['process_id'])&& $_GET['detail_id'] !='')
	{
		$process_id = $_GET['process_id'];
		$detail_id = $_GET['detail_id'];
		$process_detail_id = $_GET['process_detail_id'];	
		$sql="UPDATE tbl_order_detail SET status ='6' WHERE detail_id = ".$detail_id;
		dbQuery($sql);
		$sql_del_d = "delete from fac_process_detail where process_detail_id = '$process_detail_id'";
		dbQuery($sql_del_d);
		$qr = dbQuery("SELECT * FROM fac_process WHERE process_id = '$process_id'");
		$rs=dbFetchArray($qr);
		$qty = $rs['qty']-1;
		$sql="UPDATE fac_process SET qty = '$qty' WHERE process_id = ".$process_id;
		dbQuery($sql);
		header("location:index.php?content=newprocess&process_id=".$process_id);
	}
}
?>