<?php 
function pagination_config()
{		
		$config['full_tag_open'] 		= "<nav><ul class='pagination'>";
		$config['full_tag_close'] 		= "</ul></nav>";
		$config['first_link'] 				= 'First';
		$config['first_tag_open'] 		= "<li>";
		$config['first_tag_close'] 		= "</li>";
		$config['next_link'] 				= 'Next';
		$config['next_tag_open'] 		= "<li>";
		$config['next_tag_close'] 	= "</li>";
		$config['prev_link'] 			= 'prev';
		$config['prev_tag_open'] 	= "<li>";
		$config['prev_tag_close'] 	= "</li>";
		$config['last_link'] 				= 'Last';
		$config['last_tag_open'] 		= "<li>";
		$config['last_tag_close'] 		= "</li>";
		$config['cur_tag_open'] 		= "<li class='active'><a href='#'>";
		$config['cur_tag_close'] 		= "</a></li>";
		$config['num_tag_open'] 		= '<li>';
		$config['num_tag_close'] 		= "</li>";
		$config['uri_segment'] 		= 4;
		return $config;
}

function get_finished_qty($id_order)
{
	$qty = 0;
	$c =& get_instance();
	$rs = $c->db->select_sum("qty")->where("id_order", $id_order)->where("shipped",0)->get("tbl_finished_detail");
	if($rs->num_rows() == 1)
	{
		$qty = $rs->row()->qty;
	}
	return $qty;
}

function get_finished_amount($id_order) //ส่งคืนยอดเงินรวมของสินค้าทีกำลังขนส่งตามออเดอร์
{
	$amount = 0;
	$c =& get_instance();
	$rs = $c->db->select("id_product, qty")->where("id_order", $id_order)->where("shipped",0)->get("tbl_finished_detail");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			$qty = $ro->qty;
			$price = product_price_by_order($ro->id_product, $id_order);
			$total = $qty*$price;
			$amount += $total;
		}
	}
	return $amount;	
}

function get_finished_weight($id_order)
{
	$total_weight = 0;
	$c =& get_instance();
	$rs = $c->db->select("id_product, qty")->where("id_order", $id_order)->where("shipped",0)->get("tbl_finished_detail");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			$qty = $ro->qty;
			$weight = product_weight($ro->id_product);
			$total = $qty*$weight;
			$total_weight += $total;
		}
	}
	return $total_weight;		
}

function get_delivery_qty_by_order($id_delivery, $id_order) /// คืนค่าเป็นจำนวนสินค้าที่กำลังขนส่งตามออเดอร์
{
	$qty = 0;
	$c =& get_instance();
	$rs = $c->db->select_sum("qty")->where("id_order", $id_order)->where("id_delivery", $id_delivery)->get("tbl_delivery_detail");
	if($rs->num_rows() == 1)
	{
		$qty = $rs->row()->qty;
	}
	return $qty;	
}

function get_delivery_amount_by_order($id_delivery, $id_order) //ส่งคืนยอดเงินรวมของสินค้าทีกำลังขนส่งตามออเดอร์
{
	$amount = 0;
	$c =& get_instance();
	$rs = $c->db->select("id_product, qty")->where("id_order", $id_order)->where("id_delivery", $id_delivery)->get("tbl_delivery_detail");
	if($rs->num_rows() >0)
	{
		foreach($rs->result() as $ro)
		{
			$qty = $ro->qty;
			$price = product_price_by_order($ro->id_product, $id_order);
			$total = $qty*$price;
			$amount += $total;
		}
	}
	return $amount;	
}

function get_delivery_weight_by_order($id_delivery, $id_order)
{
	$total_weight = 0;
	$c =& get_instance();
	$rs = $c->db->select("id_product, qty")->where("id_order", $id_order)->where("id_delivery", $id_delivery)->get("tbl_delivery_detail");
	if($rs->num_rows() > 0)
	{
		foreach($rs->result() as $ro)
		{
			$qty = $ro->qty;
			$weight = product_weight($ro->id_product);
			$total = $qty*$weight;
			$total_weight += $total;
		}
	}
	return $total_weight;
}

function product_price_by_order($id_product, $id_order)
{
	$price = 0;
	$c =& get_instance();
	$rs = $c->db->select("price")->where("id_product", $id_product)->where("id_order", $id_order)->get("tbl_order_detail",1);
	if($rs->num_rows() == 1 )
	{
		$price = $rs->row()->price;
	}
	return $price;
}

function product_weight($id_product)
{
	$weight = 0;
	$c =& get_instance();
	$rs = $c->db->select("weight")->where("id_product", $id_product)->get("tbl_product", 1);
	if($rs->num_rows() == 1 )
	{
		$weight = $rs->row()->weight;
	}
	return $weight;
}
?>