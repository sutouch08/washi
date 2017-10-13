<?php
include "classLogin.php";
/*
	Check if a session user id exist or not. If not set redirect
	to login page. If the user session id exist and there's found
	$_GET['logout'] in the query string logout the user
*/
function checkUser()
{
	$autoDetect = new userLogin();
	$autoDetect->permission(date('Y-m-d'));
	// if the session id is not set, redirect to login page
	if(!isset($_COOKIE['user_id'])){
		header('Location: ' . WEB_ROOT . 'login.php');
		exit;
		}
	
	// the user want to logout
	if (isset($_GET['logout'])) {
		doLogout();
	}
}
function checkPermission()
{
	// if the session id is not set, redirect to login page
		if(!isset($_COOKIE['Permission'])){
		header('Location: ' . WEB_ROOT . 'admin/login.php?message=deny');
		exit;
		}	
		
	// the user want to logout
	if (isset($_GET['logout'])) {
		adminLogout();
	}
}

function doLogin()
{
	// if we found an error save the error message in this variable
	$errorMessage = '';
	
	$userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];	
	// first, make sure the username & password are not empty
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	} else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} else {
		// check the database and see if the username and password combo do match
		$sql = "SELECT *
		        FROM tbl_user LEFT JOIN tbl_employee ON tbl_user.em_id = tbl_employee.em_id
				WHERE tbl_user.user_name = '$userName' AND tbl_user.password = '$password' ";
		$result = dbQuery($sql);
	
		if (dbNumRows($result) == 1) {
			$row = dbFetchAssoc($result);
			setcookie("user_id", $row['user_id'],time()+(3600*8)); // Expire in 8  hours
			setcookie("UserName",$row['em_name'],time()+(3600*8)); 
			setcookie("shop_id",$row['shop_id'],time()+(3600*8)); 
			setcookie("profile_id",$row['profile_id'],time()+(3600*8));
			// log the time when the user last login
			$sql = "UPDATE tbl_user 
			        SET user_last_login = NOW() 
					WHERE user_id = '{$row['user_id']}'";
			dbQuery($sql);

			// now that the user is verified we move on to the next page
            // if the user had been in the admin pages before we move to
			// the last page visited
			if (isset($_SESSION['login_return_url'])) {
				header('Location: ' . $_SESSION['login_return_url']);
				exit;
			} else {
				header('Location: index.php');
				exit;
			}
		} else {
			$errorMessage = 'Wrong username or password';			
		}
	}
	return $errorMessage;
}

function adminLogin()
{
	// if we found an error save the error message in this variable
	$errorMessage = '';
	
	$userName = $_POST['txtUserName'];
	$password = $_POST['txtPassword'];
	
	// first, make sure the username & password are not empty
	if ($userName == '') {
		$errorMessage = 'You must enter your username';
	} else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} else {
		// check the database and see if the username and password combo do match
		$sql = "SELECT *
		        FROM tbl_user LEFT JOIN tbl_employee ON tbl_user.em_id = tbl_employee.em_id
				WHERE tbl_user.user_name = '$userName' AND tbl_user.password = '$password' AND tbl_user.permission ='ADMIN' ";
		$result = dbQuery($sql);
	
		if (dbNumRows($result) == 1) {
			$row = dbFetchAssoc($result);
			setcookie("user_id",$row['user_id'],time()+(3600*8));//Expire in 8 hours
			setcookie("UserName",$row['em_name'],time()+(3600*8));
			setcookie("Permission",$row['permission'],time()+(3600*8));
			setcookie("profile_id",$row['profile_id'],time()+(3600*8));
			// log the time when the user last login
			$sql = "UPDATE tbl_user 
			        SET user_last_login = NOW() 
					WHERE user_id = '{$row['user_id']}'";
			dbQuery($sql);

			// now that the user is verified we move on to the next page
            // if the user had been in the admin pages before we move to
			// the last page visited
			if (isset($_SESSION['login_return_url'])) {
				header('Location: ' . $_SESSION['login_return_url']);
				exit;
			} else {
				header('Location: index.php');
				exit;
			}
		} else {
			$errorMessage = 'Wrong username or password';
			header('Location: ' . WEB_ROOT . 'admin/login.php?message=error');
		}		
			
	}
	
	return $errorMessage;
}
function doLogout()
{
	if (isset($_COOKIE['user_id'])) {
		setcookie("user_id","",-3600);
		setcookie("shop_id","",-3600);
		setcookie("UserName","",-3600);
		setcookie("Permission","",-3600);
		setcookie("profile_id","",-3600);
	}		
	header('Location: login.php');
	exit;
}
function adminLogout()
{
	if (isset($_COOKIE['user_id'])) {
		setcookie("user_id","",-3600);
		setcookie("shop_id","",-3600);
		setcookie("UserName","",-3600);
		setcookie("Permission","",-3600);
		setcookie("profile_id","",-3600);
	}
		
	header('Location: login.php');
	exit;
}

function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
function get_orderID(){
		$user_id = $_COOKIE['user_id'];
		$sql="SELECT *
		        FROM tbl_user LEFT JOIN tbl_shop ON tbl_user.shop_id = tbl_shop.shop_id
				WHERE tbl_user.user_id = '$user_id' ";
		$Qtotal = dbQuery($sql);
		$rs=dbFetchArray($Qtotal);
		$shop_code = $rs['shop_code'];
		$sql="select  * from tbl_order order by  order_no DESC"; 
		$Qtotal = dbQuery($sql);
		$rs=dbFetchArray($Qtotal);

		$sumtdate = date("y");
		$m = date("m");
		$num = "0001";
		$str = $rs['order_no'];
		$s = 6; // start from "0" (nth) char
		$l = 6; // get "3" chars
		$str2 = substr_unicode($str, $s ,4)+1;
		$str1 = substr_unicode($str, 0 ,$l);
		if($str1=="WH$sumtdate$m"){  
		$order_no = "WH$sumtdate$m".sprintf("%04d",$str2)."$shop_code";
		}else{
		$order_no = "WH$sumtdate$m$num$shop_code";
		}
		
		return $order_no;
}

function get_trackingNo($order_no, $user_id){	
	if(isset($order_no)){
		if(isset($user_id)){
		$sql="SELECT *
		        FROM tbl_user LEFT JOIN tbl_shop ON tbl_user.shop_id = tbl_shop.shop_id
				WHERE tbl_user.user_id = '$user_id' "; 
		$Qtotal = dbQuery($sql);
		$rs=dbFetchArray($Qtotal);
		$shop_code = $rs['shop_code'];
		$tracking1 = substr_unicode($order_no, 5);
		$tracking2 = substr_unicode($order_no, 0 ,10);
		$tracking3 = "TK". sprintf("%04d",$tracking1*2);
		
		$tracking_no = "$tracking3$shop_code";
		
		return $tracking_no;
		}else{
		return "error";
		}
	}else{ 
	return "error";
	}
}

/*===========  Place order ============*/
function placeOrder($sum_price1, $sum_num, $sum_weight)
	{		
			$user_id = $_COOKIE['user_id'];
			$sql="SELECT *
		        FROM tbl_user LEFT JOIN tbl_shop ON tbl_user.shop_id = tbl_shop.shop_id
				WHERE tbl_user.user_id = '$user_id' "; 
			$Qtotal = dbQuery($sql);
			$rs=dbFetchArray($Qtotal);
			$shop_id = $rs['shop_id'];
			$urgent_id = $_POST['urgent_id'];
			$qr_u =dbQuery("SELECT * FROM tbl_urgent where urgent_id = '$urgent_id'");
			$rs_u=dbFetchArray($qr_u);	
			$urgent_date = $rs_u['urgent_date'];
			$charge_up = $rs_u['charge_up'];
			$order_amount = (1+($charge_up/100))*$sum_price1;
			$order_date = date('Y-m-d');
			$order_no = get_orderID();
			$tracking_no = get_trackingNo(get_orderID(), $user_id);
			$customer_id = $_POST['customer_id'];
			$shipping_id = $_POST['shipping_id'];
			$dateInput = date('Y-m-d',strtotime($_POST['dateInput']));
			$order_qty = $sum_num;
			$weight = $sum_weight;
			$note = $_POST['note'];
			$sql = "insert into tbl_order(order_no,customer_id,shipping_id,user_id,shop_id,urgent_id,order_date_time,order_due,tracking_no,order_qty,order_amount,weight,status,note) 	VALUES('$order_no','$customer_id','$shipping_id','$user_id','$shop_id','$urgent_id','$order_date','$dateInput','$tracking_no','$order_qty','$order_amount','$weight','1','$note')";
			$db_query=dbQuery($sql) or die ("$sql");
			$qr =dbQuery("SELECT * FROM tbl_order where order_no = '$order_no'");
			$rs=dbFetchArray($qr);	
			$order_id = $rs['order_id'];
			return $order_id;
	}
	

  // ตัวเลขเป็นตัวหนังสือ (ไทย)
  function bahtThai($thb) {
   @list($thb, $ths) = explode('.', $thb);
   $ths = substr($ths.'00', 0, 2);
   $thaiNum = array('', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า');
   $unitBaht = array('บาท', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
   $unitSatang = array('สตางค์', 'สิบ');
   $THB = '';
   $j = 0;
   for ($i = strlen($thb) - 1; $i >= 0; $i--, $j++) {
    $num = $thb[$i];
    $tnum = $thaiNum[$num];
    $unit = $unitBaht[$j];
    switch (true) {
     case $j == 0 && $num == 1 && strlen($thb) > 1:
      $tnum = 'เอ็ด';
      break;
     case $j == 1 && $num == 1:
      $tnum = '';
      break;
     case $j == 1 && $num == 2:
      $tnum = 'ยี่';
      break;
     case $j == 6 && $num == 1 && strlen($thb) > 7:
      $tnum = 'เอ็ด';
      break;
     case $j == 7 && $num == 1:
      $tnum = '';
      break;
     case $j == 7 && $num == 2:
      $tnum = 'ยี่';
      break;
     case $j != 0 && $j != 6 && $num == 0:
      $unit = '';
      break;
    }
    $S = $tnum.$unit;
    $THB = $S.$THB;
   }
   if ($ths == '00') {
    $THS = 'ถ้วน';
   } else {
    $j = 0;
    $THS = '';
    for ($i = strlen($ths) - 1; $i >= 0; $i--, $j++) {
     $num = $ths[$i];
     $tnum = $thaiNum[$num];
     $unit = $unitSatang[$j];
     switch (true) {
      case $j == 0 && $num == 1 && strlen($ths) > 1:
       $tnum = 'เอ็ด';
       break;
      case $j == 1 && $num == 1:
       $tnum = '';
       break;
      case $j == 1 && $num == 2:
       $tnum = 'ยี่';
       break;
      case $j != 0 && $j != 6 && $num == 0:
       $unit = '';
       break;
     }
     $S = $tnum.$unit;
     $THS = $S.$THS;
    }
   }
   return $THB.$THS;
  }
  // ตัวเลขเป็นตัวหนังสือ (eng)
  
 function check_product_code($order_id)
{		
	$sql_c = dbQuery("SELECT * from tbl_order_detail where order_id = '$order_id' and product_code = ''");
	$rs_c=dbFetchArray($sql_c);
	$detail_id = $rs_c['detail_id'];
	$sql_co = dbQuery("SELECT * from tbl_order where order_id = '$order_id' and order_code = ''");
	$rs_co=dbFetchArray($sql_co);
	$order_id_co = $rs_co['order_id'];
	if($order_id_co == ""){
		if($detail_id == ""){
			$sql_s="UPDATE tbl_order SET status = '2' WHERE order_id = '$order_id'";
		dbQuery($sql_s);
		
		}else{
			$sql_s="UPDATE tbl_order SET status = '1' WHERE order_id = '$order_id'";
		dbQuery($sql_s);
		}
	}else{
		$sql_s="UPDATE tbl_order SET status = '1' WHERE order_id = '$order_id'";
		dbQuery($sql_s);
	}
}
function more($complete){
	if($complete == "2"){
		$more = "<font color='#FF0000'>(งานซ่อม)</font>";
	}else if($complete == "1"){
		$more = "<font color='#FF0000'>(ไม่ครบ)</font>";
	}else{
		$more = "";
	}
	return $more;
}

?>