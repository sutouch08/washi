<?php
function thaiMonthName($i="")
{
	$value = array( "01"=>"มกราคม", "02"=>"กุมภาพันธ์", "03"=>"มีนาคม", "04"=>"เมษายน", "05"=>"พฤษภาคม", "06"=>"มิถุนายน", "07"=>"กรกฏาคม", "08"=>"สิงหาคม", "09"=>"กันยายน", "10"=>"ตุลาคม", "11"=>"พฤศจิกายน", "12"=>"ธันวาคม");
	if($i ==""){
		$m = date("m");
	}else{
		$m = $i;
	}
	return $value[$m];
}

function shortTime($time)
{
	$value = date("H:i", strtotime($time));
	//$value = "-";
		return $value;
}
function dateDiff($strDate1,$strDate2)
	{
		return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
?>