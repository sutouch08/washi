<?php
function getShopList($id)
{
	echo "<option value='0' >เลือกร้าน </option>";
	$result = dbQuery("select * from tbl_shop ");
	$row= dbNumRows($result);
	$i=0;
	while($row>$i)
	{
		$data = dbFetchArray($result);
		$shop_id = $data['shop_id'];
		$shop_name = $data['shop_name'];
		echo "<option value='$shop_id'"; if($id==$shop_id){echo "selected='selected'";} echo ">$shop_name</option>";
		$i++;
	}
	
}
function getViewList($view,$from_date)
{
	if($from_date != "เลือกวัน"){$view = "";}
	echo "<option value='0' "; if($view==""){echo "selected='selected'";} echo ">เลือกการแสดงผล</option>";
	echo "<option value='week' "; if($view == "week"){echo "selected='selected'";} echo ">แสดงเป็นสัปดาห์</option>";
	echo "<option value='month' "; if($view == "month"){echo "selected='selected'";} echo ">แสดงเป็นเดือน</option>";
	echo "<option value='year' "; if($view == 'year'){echo "selected='selected'";} echo ">แสดงเป็นปี</option>";
}

function categoryDropdown()
{
	$result = dbQuery("select * from tbl_process_category ");
	$row= dbNumRows($result);
	$i=0;
	while($row>$i)
	{
		$data = dbFetchArray($result);
		$cate_id = $data['process_category_id'];
		$cate_name = $data['process_category_name'];
		echo "<option value='$cate_id'>$cate_name</option>";
		$i++;
	}
}

function getWeek($today){
	$day = date("l",strtotime("$today"));
	$from_date ='';
	$to_date = '';
	switch ($day){
		case 'Monday':
		$from_date = $today;
		$to_date = date('Y-m-d',strtotime("+6 day",strtotime("$today")));
		break;
		case 'Tuesday' :
		$from_date = date('Y-m-d',strtotime("-1 day",strtotime("$today")));
		$to_date = date('Y-m-d',strtotime("+5 day",strtotime("$today")));
		break;
		case 'Wednesday' :
		$from_date = date('Y-m-d',strtotime("-2 day",strtotime("$today")));
		$to_date = date('Y-m-d',strtotime("+4 day",strtotime("$today")));
		break;
		case 'Thursday' :
		$from_date = date('Y-m-d',strtotime("-3 day",strtotime("$today")));
		$to_date = date('Y-m-d',strtotime("+3 day",strtotime("$today")));
		break;
		case 'Friday' :
		$from_date = date('Y-m-d',strtotime("-4 day",strtotime("$today")));
		$to_date = date('Y-m-d',strtotime("+2 day",strtotime("$today")));
		break;
		case 'Saturday' :
		$from_date = date('Y-m-d',strtotime("-5 day",strtotime("$today")));
		$to_date = date('Y-m-d',strtotime("+1 day",strtotime("$today")));
		break;
		case 'Sunday' :
		$from_date = date('Y-m-d',strtotime("-6 day",strtotime("$today")));
		$to_date =  $today;
		break;
		default :
		$from_date = $today;
		$to_date = date('Y-m-d',strtotime("+6 day",strtotime("$today")));
		break;
		
	}
	$array["from"] =$from_date;
	$array["to"] = $to_date;
	return $array;
}

function DateDiff($strDate1,$strDate2)
	{
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 
function getMonth(){
	$array["from"] = date('Y-m-01',strtotime('this month'));
	$array["to"] = date('Y-m-t',strtotime('this month'));
	return $array;
}

function getYear(){
	$array["from"] = date('Y-01-01',strtotime('this year'));
	$array["to"] = date('Y-12-31',strtotime('this year'));
	return $array;
}
function getMonthName()
{
	$date = date("m",strtotime("this month"));
	switch($date){
		case "01" :
		$month = "มกราคม";
		break;
		case "02" :
		$month = "กุมภาพันธ์";
		break;
		case "03" :
		$month = "มีนาคม";
		break;
		case "04" :
		$month = "เมษายน";
		break;
		case "05" :
		$month = "พฤษภาคม";
		break;
		case "06" :
		$month = "มิถุนายน";
		break;
		case "07" :
		$month = "กรกฎาคม";
		break;
		case "08" :
		$month = "สิงหาคม";
		break;
		case "09" :
		$month = "กันยายน";
		break;
		case "10" :
		$month = "ตุลาคม";
		break;
		case "11" :
		$month = "พฤษจิกายน";
		break;
		case "12" :
		$month = "ธันวาคม";
		break;
		default :
		$month = "เดือนไม่ถูกต้อง";
		break;
	}
	return $month;
}
function MonthName($no)
{
	switch($no){
		case "1" :
		$month = "January";
		break;
		case "2" :
		$month = "February";
		break;
		case "3" :
		$month = "March";
		break;
		case "4" :
		$month = "April";
		break;
		case "5" :
		$month = "May";
		break;
		case "6" :
		$month = "June";
		break;
		case "7" :
		$month = "July";
		break;
		case "8" :
		$month = "August";
		break;
		case "9" :
		$month = "September";
		break;
		case "10" :
		$month = "October";
		break;
		case "11" :
		$month = " November";
		break;
		case "12" :
		$month = "December";
		break;
		default :
		$month = "เดือนไม่ถูกต้อง";
		break;
	}
	return $month;
}
	
function showRang($view, $from, $to){
	$result = "";
	if($view=='day'){
		$result = "วันที่ : ".date("d-m-Y");
	}else if($view =="week"){
		$week = getWeek(date("Y-m-d"));
		$to_date = $week['to'];
		$from_date = $week['from'];
		$result = "ระหว่างวันที่ : ". date("d-m-Y",strtotime("$from_date"))."&nbsp;&nbsp;&nbsp;ถีงวันที่ : ".date("d-m-Y",strtotime("$to_date"));
	}else if($view == "month"){
		$result = "เดือน &nbsp;".getMonthName();
	}else if($view == "year"){
		$result = "ปี &nbsp;".date("Y");
	}else{
		$result = "ระหว่างวันที่ : ". $from ."&nbsp;&nbsp;&nbsp;ถีงวันที่ : ".$to;
	}
	return $result;
}
	/// คืนค่ารายงานยอดขายรวมแต่ละร้านตามช่วงเวลาที่เลือก//////	
function saleReportChart($from, $to){
	$data = "";
	$qr = dbQuery("select * from tbl_shop");
	$row = dbNumRows($qr);
	$i = 0;
	while($i<$row){
		$result = dbFetchArray($qr);
		$shop_id = $result['shop_id'];
		$shop_name = $result['shop_name'];
		$qs = dbFetchArray(dbQuery("SELECT SUM(order_amount) AS amount FROM tbl_order  WHERE shop_id = '$shop_id' AND (order_date_time BETWEEN '$from' AND '$to')"));
		$amount = $qs['amount'];
		if($amount ==""){
			$amount = 0; 
		}
		$xdata = $shop_name." : ".$amount ." ,";
		$data = "$data$xdata";
		$i++;
	}
	return $data;	
}
/// คืนค่ารายงานยอดขายรวมที่ส่งงานแล้วแต่ละร้านตามช่วงเวลาที่เลือก//////
function saleRecievedChart($from, $to){
	$data = "";
	$qr = dbQuery("select * from tbl_shop");
	$row = dbNumRows($qr);
	$i = 0;
	while($i<$row){
		$result = dbFetchArray($qr);
		$shop_id = $result['shop_id'];
		$shop_name = $result['shop_name'];
		$qs = dbFetchArray(dbQuery("SELECT SUM(order_amount) AS amount FROM tbl_order  WHERE shop_id = '$shop_id' AND status = 17 AND (order_date_time BETWEEN '$from' AND '$to')"));
		$amount = $qs['amount'];
		if($amount ==""){
			$amount = 0; 
		}
		$xdata = $shop_name." : ".$amount ." ,";
		$data = "$data$xdata";
		$i++;
	}
	return $data;	
}
/// คืนค่ารายงานยอดขายรวมที่ยังค้างส่งลูกค้าแต่ละร้านตามช่วงเวลาที่เลือก//////
function saleNotRecievedChart($from, $to){
	$data = "";
	$qr = dbQuery("select * from tbl_shop");
	$row = dbNumRows($qr);
	$i = 0;
	while($i<$row){
		$result = dbFetchArray($qr);
		$shop_id = $result['shop_id'];
		$shop_name = $result['shop_name'];
		$qs = dbFetchArray(dbQuery("SELECT SUM(order_amount) AS amount FROM tbl_order  WHERE shop_id = '$shop_id' AND status != 17 AND (order_date_time BETWEEN '$from' AND '$to')"));
		$amount = $qs['amount'];
		if($amount ==""){
			$amount = 0; 
		}
		$xdata = $shop_name." : ".$amount ." ,";
		$data = "$data$xdata";
		$i++;
	}
	return $data;	
}
///คืนค่า label 
function saleReportLabel(){
	$sumlabel = "";
	$qr = dbQuery("select * from tbl_shop");
	$row = dbNumRows($qr);
	$i = 0;
	while($i<$row){
		$result = dbFetchArray($qr);
		$shop_name = $result['shop_name'];
		$label = "'$shop_name', ";
		$sumlabel = "$sumlabel$label";
		$i++;
	}
	return $sumlabel;	
}

?>