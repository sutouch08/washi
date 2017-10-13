<?php 
function report_status($status,$number){
	$stage = 0;
	$qty = 0;
	switch($status){
	case 'shop':
	$stage = 2;
	break;
	case 'tohub':
	$stage = 3;
	break;	 
	case 'hub':
	$stage = 4;
	break;	 
	case 'tofac':
	$stage = 5;
	break;	 
	case 'onfac':
	$stage = 6;
	break;	 
	case 'onprocess':
	$stage = 7;
	break;	 
	case 'onqc':
	$stage = 8;
	break;	 
	case 'done':
	$stage = 9;
	break;	 
	case 'ondelivery':
	$stage = 10;
	break;	 
	}
}
?>