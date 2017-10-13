<?php
date_default_timezone_set('Asia/Bangkok');
function setError($message)
{
	$c =& get_instance();
	$c->session->set_flashdata("error", $message);
}

function number($value, $digit ="")
{
	if($digit =="")
	{
		return number_format($value);
	}
	else
	{
		return number_format($value, $digit);
	}
}

function numberOnly($value="")
{
	$n = 0;	
	if($value !=""){
		$n += $value;
	}
	return $n;
}
/*******************************************************  หาชื่อจาก id **************************************/

function getProductName($id)
{
	$value = "";
	$c =& get_instance();
	$rs = $c->db->select("product_name")->get_where("tbl_product", array("id_product"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->product_name;
	}
	return $value;
}

function getShopName($id_shop)
{
	$shop_name = "ทั้งหมด";
	$ci =& get_instance();
	$ci->db->select("shop_code, shop_name");
	$rs = $ci->db->get_where("tbl_shop", array("id_shop"=>$id_shop),1);
	if($rs->num_rows() == 1)
	{
		$shop_name = $rs->row()->shop_name;
	}
	return $shop_name;		
}

function getIdShopByCustomer($id_customer)
{
	$id_shop = 0;
	$ci =& get_instance();
	$ci->db->select("id_shop");
	$rs = $ci->db->get_where("tbl_customer", array("id_customer"=>$id_customer),1);
	if($rs->num_rows() == 1)
	{
		$id_shop = $rs->row()->id_shop;
	}
	return $id_shop;		
}

function getCategoryName($id)
{
	$name = "";
	$c =& get_instance();
	$c->db->select("category_name");
	$rs = $c->db->get_where("tbl_category", array("id_category"=>$id), 1);
	if($rs->num_rows() == 1)
	{
		$name = $rs->row()->category_name;
	}
	return $name;
}

function getTypeName($id)
{
	$name = "";
	$c =& get_instance();
	$c->db->select("type_name");
	$rs = $c->db->get_where("tbl_type", array("id_type"=>$id), 1);
	if($rs->num_rows() == 1)
	{
		$name = $rs->row()->type_name;
	}
	return $name;
}

function getCustomerName($id_customer)
{
	$customer_name = "";
	$c =& get_instance();
	$c->db->select("customer_name");
	$rs = $c->db->get_where("tbl_customer", array("id_customer"=>$id_customer), 1);	
	if($rs->num_rows() == 1)
	{
		$customer_name = $rs->row()->customer_name;
	}
	return $customer_name;
}

function getCustomerAddress($id_customer)
{
	$address = "";
	$c =& get_instance();
	$c->db->select("address");
	$rs = $c->db->get_where("tbl_customer", array("id_customer"=>$id_customer), 1);
	if($rs->num_rows() ==1)
	{
		$address = $rs->row()->address;
	}
	return $address;
}

function getCustomerId($id_order)
{
	$value = 0;
	$c =& get_instance();
	$c->db->select("id_customer");
	$rs = $c->db->get_where("tbl_order", array("id_order"=>$id_order), 1);
	if($rs->num_rows() == 1)
	{
		$value = $rs->row()->id_customer;
	}
	return $value;
}

function getCustomerEmail($id)
{
	$value = "";
	$c =& get_instance();
	$c->db->select("email");
	$rs = $c->db->get_where("tbl_customer", array("id_customer"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->email;
	}
	return $value;	
}

function getCustomerPhone($id)
{
	$value = "";
	$c =& get_instance();
	$c->db->select("phone");
	$rs = $c->db->get_where("tbl_customer", array("id_customer"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->phone;
	}
	return $value;	
}

function getShipping($id)
{
	$value = "";
	$c =& get_instance();
	$c->db->select("shipping_name");
	$rs = $c->db->get_where("tbl_shipping", array("id_shipping"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->shipping_name;
	}
	return $value;	
}

function getUrgent($id)
{
	$value = "";
	$c =& get_instance();
	$c->db->select("urgent_name");
	$rs = $c->db->get_where("tbl_urgent", array("id_urgent"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->urgent_name;
	}
	return $value;	
}

function getState($id)
{
	$value = "";
	$c =& get_instance();
	$c->db->select("state_name");
	$rs = $c->db->get_where("tbl_state", array("id_state"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->state_name;
	}
	return $value;	
}

function getEmployeeName($id_employee)
{
	$employee_name = "";
	$c =& get_instance();
	$rs = $c->db->get_where("tbl_employee", array("id_employee"=>$id_employee), 1);
	if($rs->num_rows() ==1)
	{
		$employee_name = $rs->row()->first_name." ".$rs->row()->last_name;
	}
	return $employee_name;
}

function getEmployeeFirstName($id_employee)
{
	$employee_name = "";
	$c =& get_instance();
	$rs = $c->db->get_where("tbl_employee", array("id_employee"=>$id_employee), 1);
	if($rs->num_rows() ==1)
	{
		$employee_name = $rs->row()->first_name;
	}
	return $employee_name;
}

function getCarPlate($id_car)
{
	$car_plate = "";
	$c =& get_instance();
	$rs = $c->db->get_where("tbl_car", array("id_car"=>$id_car), 1);
	if($rs->num_rows() ==1)
	{
		$car_plate = $rs->row()->car_plate;
	}
	return $car_plate;
}

function getDriverName($id)
{
	$driver = "";
	$c =& get_instance();
	$c->db->select("first_name, last_name");
	$c->db->join("tbl_employee", "tbl_driver.id_employee = tbl_employee.id_employee", "left");
	$rs = $c->db->get_where("tbl_driver", array("id_driver"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$driver = $rs->row()->first_name." ".$rs->row()->last_name;
	}
	return $driver;
}
/*********************************************   Select Options ******************************************/
function selectShop($id="")
{
	$option = "<option value='0' >------- เลือกสาขา -------</option>";
	$c =& get_instance();
	$rs = $c->db->get("tbl_shop");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_shop == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .="<option value='".$ro->id_shop."' ".$set.">".$ro->shop_name."</option>";
		}
	}
	return $option;
}

function selectEmployee($id="")
{
	$option = "<option value='0' >------- เลือกพนักงาน -------</option>";
	$c =& get_instance();
	$rs = $c->db->get("tbl_employee");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_employee == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .="<option value='".$ro->id_employee."' ".$set.">".$ro->first_name." ".$ro->last_name."</option>";
		}
	}
	return $option;
}

function selectShopEmployee($id="")
{
	$option = "<option value='0' >------- เลือกพนักงาน -------</option>";
	$c =& get_instance();
	$c->db->join("tbl_employee", "tbl_user.id_employee = tbl_employee.id_employee");
	$rs = $c->db->get_where("tbl_user", array("tbl_user.id_shop !="=>0));
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_employee == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .="<option value='".$ro->id_employee."' ".$set.">".$ro->first_name." ".$ro->last_name."</option>";
		}
	}
	return $option;
}


function selectProfile($id="")
{
	$option = "<option value='0' >------- เลือกโปรไฟล์ -------</option>";
	$c =& get_instance();
	$c->db->where("id_profile !=", 0);
	$rs = $c->db->get("tbl_profile");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_profile == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .="<option value='".$ro->id_profile."' ".$set.">".$ro->profile_name."</option>";
		}
	}
	return $option;
}

function selectCategory($id="")
{
	$option = "<option value='0' >------- เลือกหมวดหมู่ -------</option>";
	$c =& get_instance();
	$rs = $c->db->get("tbl_category");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_category == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .="<option value='".$ro->id_category."' ".$set.">".$ro->category_name."</option>";
		}
	}
	return $option;
}

function selectType($id="")
{
	$option = "<option value='0' >------- เลือกประเภท -------</option>";
	$c =& get_instance();
	$rs = $c->db->get("tbl_type");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_type == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .="<option value='".$ro->id_type."' ".$set.">".$ro->type_name."</option>";
		}
	}
	return $option;
}

function selectCar($id="")
{
	$option = "<option value='0' >---- เลือกทะเบียนรถ ----</option>";
	$c =& get_instance();
	$rs = $c->db->get("tbl_car");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_car == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .="<option value='".$ro->id_car."' ".$set.">".$ro->car_plate."</option>";
		}
	}
	return $option;
}

function selectDriver($id="")
{
	$option = "<option value='0' >---- เลือกพนักงานขับ ----</option>";
	$c =& get_instance();
	$c->db->select("id_driver, first_name, last_name");
	$c->db->join("tbl_employee", "tbl_driver.id_employee = tbl_employee.id_employee");
	$rs = $c->db->get("tbl_driver");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_driver == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .="<option value='".$ro->id_driver."' ".$set.">".$ro->first_name." ".$ro->last_name."</option>";
		}
	}
	return $option;
}

function selectShipping($id="")
{
	if($id ==""){ $id = 1; }
	$option = "";
	$c =& get_instance();
	$rs = $c->db->get("tbl_shipping");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_shipping == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .= "<option value='".$ro->id_shipping."' ".$set.">".$ro->shipping_name."</option>";
		}
	}
	return $option;
}

function selectUrgent($id="")
{
	if($id ==""){ $id = 1; }
	$option = "";
	$c =& get_instance();
	$rs = $c->db->get("tbl_urgent");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			if($ro->id_urgent == $id){ $set = "selected='selected'"; }else{ $set = ""; }
			$option .= "<option value='".$ro->id_urgent."' ".$set.">".$ro->urgent_name."</option>";
		}
	}
	return $option;
}

function urgent_day()
{
	$c =& get_instance();
	$rs = $c->db->get("tbl_urgent");
	if($rs->num_rows() >0)
	{
		$i = 1;
		foreach($rs->result() as $ro)
		{
			$data[$i] = $ro->day;
			$i++;
		}
	}
	return $data;
}
	
/****************************************  ฟังชั่นก์ ทั่วไป ********************************/
function NOW()
{
	return date("Y-m-d H:i:s");	
}
function thaiDate($date)
{
	$rs =  date('d-m-Y H:i:s', strtotime($date));
	if($rs =="01-01-1970 01:00:00")
	{
		$rs = "";
	}
	return $rs;
}

function thaiShortDate($date)
{
	$rs =  date('d-m-Y', strtotime($date));
	if($rs =="01-01-1970")
	{
		$rs = "";
	}
	return $rs;
}
function dbDate($date)
{
	$rs = date("Y-m-d H:i:s", strtotime($date));
	if($rs =="1970-01-01 01:00:00")
	{
		$rs = "";
	}
	return $rs;
}

function dbShortDate($date)
{
	$rs = date("Y-m-d", strtotime($date));
	if($rs =="1970-01-01")
	{
		$rs = "";
	}
	return $rs;
}

function isActived($value)
{
	$actived = "";
	if($value ==1)
	{
		$actived = "<i class='fa fa-check-square-o' style='color: green;'></i>";
	}
	else
	{
		$actived = "<i class='fa fa-remove' style='color: red;'></i>";
	}
	return $actived;
}

function isSelected($value, $select)
{
	$selected = "";
	if($value ==$select)
	{
		$selected = "selected='selected'";
	}
	
	return $selected;
}

function isChecked($value, $check)
{
	$checked = "";
	if($value ==$check)
	{
		$checked = "checked='checked'";
	}
	
	return $checked;
}

function radioCheck($value, $check)
{
	$rs = "";
	if($value == $check)
	{
		$rs = "checked ='checked'";
	}
	return $rs;	
}

function selectCheck($value, $select)
{
	$rs = "";
	if($value == $select)
	{
		$rs = "selected = 'selected'";
	}
	return $rs;
}

function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
function getOrderId()
{
	$c =& get_instance();
	$id_user = $c->session->userdata("id_user");
	$rs = $c->db->select("shop_code")->join("tbl_shop", "tbl_user.id_shop = tbl_shop.id_shop")->get_where("tbl_user", array("id_user"=>$id_user), 1);
	$shop_code = $rs->row()->shop_code;
	$ro = $c->db->select_max("order_no")->get_where("tbl_order", array("id_shop"=>$c->session->userdata("id_shop")), 1);
	$sumtdate = date("y");
	$m = date("m");
	$num = "0001";
	$str = $ro->row()->order_no;
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

function newDeliveryNumber()
{ 
	$reference = "";
	$c =& get_instance();
	$ro = $c->db->select_max("reference")->get("tbl_delivery");
	$sumtdate = date("y");
	$m = date("m");
	$num = "0001";
	$str = $ro->row()->reference;
	$s = 6; // start from "0" (nth) char
	$l = 6; // get "3" chars
	$str2 = substr_unicode($str, $s ,4)+1;
	$str1 = substr_unicode($str, 0 ,$l);
	if($str1=="DO$sumtdate$m"){  
	$reference = "DO$sumtdate$m".sprintf("%04d",$str2);
	}else{
	$reference = "DO$sumtdate$m$num";
	}
	return $reference;
}

function getOrderNumber($id)
{
	$value = 0;
	$c	=& get_instance();
	$rs = $c->db->select("order_no")->get_where("tbl_order", array("id_order"=>$id), 1);
	if($rs->num_rows() ==1 )
	{
		$value = $rs->row()->order_no;
	}
	return $value;
}

function getIdOrderByOrderNumber($order_no)
{
	$value = 0;
	$c =& get_instance();
	$rs = $c->db->select("id_order")->get_where("tbl_order", array("order_no"=>$order_no), 1);
	if($rs->num_rows() == 1){
		$value = $rs->row()->id_order;
	}
	return $value;
}

function getUrgentId($id)
{
	$value = "";
	$c =& get_instance();
	$c->db->select("id_urgent");
	$rs = $c->db->get_where("tbl_order", array("id_order"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->id_urgent;
	}
	return $value;	
}
function getPromotionName($id)
{
	$value = "No promotion apply";
	$c =& get_instance();
	$c->db->select("promotion_name");
	$rs = $c->db->get_where("tbl_promotion", array("id_promotion"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->promotion_name;
	}
	return $value;	
}

function getShopPhone($id)
{
	$value = "";
	$c =& get_instance();
	$c->db->select("shop_phone");
	$rs = $c->db->get_where("tbl_shop", array("id_shop"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->shop_phone;
	}
	return $value;	
}

function getUrgentCharg($id)
{
	$value = "";
	$c =& get_instance();
	$c->db->select("charge_up");
	$rs = $c->db->get_where("tbl_urgent", array("id_urgent"=>$id), 1);
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->charge_up;
	}
	return $value;	
}

function chargUp($id_order)
{
	$value = 0;
/*	$id_urgent = getUrgentId($id_order);
	$charge_up = getUrgentCharg($id_urgent)/100; */
	$c =& get_instance();
	$rs = $c->db->select_sum("charge_up")->get_where("tbl_order_detail", array("id_order"=>$id_order));
	if($rs->num_rows() ==1)
	{
		$value = $rs->row()->charge_up;
	}
	return  $value;
}
function urgentColor($id)
{
	$value ="";
	switch($id)
	{
		case 1 :
		$value = "#656D78";
		break;
		case 2 :
		$value = "#FC6E51";
		break;
		case 3 :
		$value = "#DA4453";
		break;
	}
	return $value;
}

function stateColor($state)
{
	$value = "";
	switch($state){
		case 1 :
			$value = "#D4F4FE";
			break;
		case 2 :
			$value = "#CDFFDD";
			break;
	}
	return $value;
}

function getUnit($id)
{
	$value = "";
	$c =& get_instance();
	$rs = $c->db->select("unit")->get_where("tbl_credit_type", array("id_credit_type"=>$id), 1);
	if($rs->num_rows() == 1)
	{
		$value =  $rs->row()->unit;
	}
	return $value;
}

function orderQty($id)
{
	$value = 0;
	$c =& get_instance();
	$rs = $c->db->select_sum("qty")->get_where("tbl_order_detail", array("id_order"=>$id));
	if($rs->num_rows() ==1){
		$value = $rs->row()->qty;
	}
	return $value;
}

function orderAmount($id)
{
	$value = 0;
	$c =& get_instance();
	$rs = $c->db->select_sum("total_amount")->get_where("tbl_order_detail", array("id_order"=>$id));
	if($rs->num_rows() ==1){
		$value = $rs->row()->total_amount;
	}
	return $value;
}

function orderWeight($id)
{
	$value = 0;
	$c =& get_instance();
	$rs = $c->db->select("qty, weight")->join("tbl_product", "tbl_order_detail.id_product = tbl_product.id_product")->get_where("tbl_order_detail", array("id_order"=>$id));
	if($rs->num_rows() >0){
		foreach($rs->result() as $ro){
			$weight = $ro->qty*$ro->weight;
			$value += $weight;
		}		
	}
	return $value;
}

function getPaymentBalance($id_order)
{
	$value = 0;
	$c =& get_instance();
	$c->db->order_by("repay","desc");
	$rs = $c->db->select("balance")->get_where("tbl_payment", array("id_order"=>$id_order, "repay"=>0),1);
	if($rs->num_rows() ==1){
		$value = $rs->row()->balance;
	}
	return $value;
}
	

?>