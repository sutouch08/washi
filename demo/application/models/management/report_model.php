<?php
class Report_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_shop_list()
	{
		$rs = $this->db->select("id_shop")->get("tbl_shop");
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_sale_each_shop($from, $to)
	{
		$where = "date_add BETWEEN '".$from."' AND '".$to."'";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$this->db->select("id_shop")->select_sum("total_amount")->where($where)->group_by("id_shop");
		$rs = $this->db->get("tbl_order_detail");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}		
	}
	
	public function sale_amount($id_shop, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail");
		if($rs->num_rows() == 1){
			return $rs->row()->total_amount;
		}else{
			return false;
		}
	}
	
	public function complete_amount($id_shop,$from, $to)
	{
		$where = "id_shop = ".$id_shop." AND tbl_order_detail.state = 8 AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->total_amount;
		}
		else
		{
			return false;
		}
	}
	
	public function incomplete_amount($id_shop, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND tbl_order_detail.state != 8 AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->total_amount;
		}
		else
		{
			return false;
		}
	}
	
	public function get_sale_last_days($i)
	{
		$data = array();
		$today = date("Y-m-d");
		while($i>0){
			$from = date("Y-m-d 00:00:00", strtotime("-$i day $today"));
			$to = date("Y-m-d 23:59:59", strtotime("-$i day $today"));
			$rs = $this->get_total_sale($from, $to);
			$arr = array("date"=>date("d/m", strtotime($from)), "amount"=>$rs);
			array_push($data, $arr);
			$i--;
		}
		return $data;		
	}
	
	public function total_sale_amount($from, $to)
	{
		$where = "(date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail");
		if($rs->num_rows() == 1){
			return $rs->row()->total_amount;
		}else{
			return false;
		}
	}
	
	public function sale_amount_by_shop_per_day($id_shop, $date)
	{
		$where = "id_shop = ".$id_shop." AND date_add LIKE '%".$date."%'";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail", 1);
		if($rs->num_rows() == 1){
			return $rs->row()->total_amount;
		}else{
			return 0;
		}
	}
	
	public function complete_amount_by_shop_per_day($id_shop, $date)
	{
		$where = "id_shop = ".$id_shop." AND tbl_order_detail.state = 8 AND date_add LIKE '%".$date."%'";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail", 1);
		if($rs->num_rows() == 1){
			return $rs->row()->total_amount;
		}else{
			return 0;
		}
	}
	
	public function incomplete_amount_by_shop_per_day($id_shop, $date)
	{
		$where = "id_shop = ".$id_shop." AND tbl_order_detail.state != 8 AND date_add LIKE '%".$date."%'";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail", 1);
		if($rs->num_rows() == 1){
			return $rs->row()->total_amount;
		}else{
			return 0;
		}
	}
	/****************  ปริมาณชิ้นงาน *******************/
	
	public function get_category()
	{
		$rs = $this->db->get("tbl_category");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	
	public function get_qty_by_shop($id_shop, $id_cate, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND id_category = ".$id_cate." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_product", "tbl_order_detail.id_product = tbl_product.id_product","left");
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order","left");
		$rs = $this->db->select_sum("qty")->where($where)->get("tbl_order_detail",1);
		if($rs->num_rows() ==1)
		{
			if($rs->row()->qty <1){
				return 0;
			}else{
				return $rs->row()->qty;
			}
		}else{
			return 0;
		}
	}	
	
	public function get_total_qty_by_category($id_cate, $from, $to)
	{
		$where = "id_category = ".$id_cate." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_product", "tbl_order_detail.id_product = tbl_product.id_product","left");
		$rs = $this->db->select_sum("qty")->where($where)->get("tbl_order_detail",1);
		if($rs->num_rows() ==1)
		{
			if($rs->row()->qty <1){
				return 0;
			}else{
				return $rs->row()->qty;
			}
		}else{
			return 0;
		}
	}	
	
	public function get_total_qty_by_shop($id_shop, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_product", "tbl_order_detail.id_product = tbl_product.id_product","left");
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order","left");
		$rs = $this->db->select_sum("qty")->where($where)->get("tbl_order_detail",1);
		if($rs->num_rows() ==1)
		{
			if($rs->row()->qty <1){
				return 0;
			}else{
				return $rs->row()->qty;
			}
		}else{
			return 0;
		}
	}	
	
	public function get_total_qty($from, $to)
	{
		$where = "date_add BETWEEN '".$from."' AND '".$to."'";
		$this->db->join("tbl_product", "tbl_order_detail.id_product = tbl_product.id_product","left");
		$rs = $this->db->select_sum("qty")->where($where)->get("tbl_order_detail",1);
		if($rs->num_rows() ==1)
		{
			if($rs->row()->qty <1){
				return 0;
			}else{
				return $rs->row()->qty;
			}
		}else{
			return 0;
		}
	}	
	
	public function get_qty_in_state($id_shop=0, $from, $to, array $id_state)
	{
		$where = "id_shop = ".$id_shop." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$this->db->select_sum("qty")->where($where)->where_in("tbl_order_detail.state", $id_state);
		$rs = $this->db->get("tbl_order_detail",1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->qty;
		}else{
			return 0;
		}
	}
	
	public function get_order_in_state($id_shop=0, array $id_state)
	{
		$this->db->join("tbl_order", "tbl_order_detail.id_order = tbl_order.id_order");
		$this->db->select_sum("qty")->where("id_shop", $id_shop)->where_in("tbl_order_detail.state", $id_state);
		$rs = $this->db->get("tbl_order_detail",1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->qty;
		}else{
			return 0;
		}
	}
	
	public function received_qty($id_shop=0, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_received_detail.id_order = tbl_order.id_order");
		$this->db->select_sum("qty")->where($where);
		$rs = $this->db->get("tbl_received_detail",1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->qty;
		}else{
			return 0;
		}
	}
	
	public function received_back_qty($id_shop=0, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		//$this->db->join("tbl_order", "tbl_received_back.id_order = tbl_order.id_order");
		$this->db->select_sum("qty")->where($where);
		$rs = $this->db->get("tbl_received_back",1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->qty;
		}else{
			return 0;
		}
	}
	
	public function on_process($id_shop=0, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_received.id_order = tbl_order.id_order");
		$this->db->select_sum("qty")->where($where);
		$rs = $this->db->get("tbl_received",1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->qty;
		}else{
			return 0;
		}
	}
	
	public function on_finished($id_shop=0, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_finished.id_order = tbl_order.id_order");
		$this->db->select_sum("qty")->where($where);
		$rs = $this->db->get("tbl_finished",1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->qty;
		}else{
			return 0;
		}
	}
	
	public function on_process_qty($id_shop, $from, $to)
	{
		$rs = $this->on_process($id_shop, $from, $to);
		$ro = $this->on_finished($id_shop, $from, $to);
		$rm = $rs + $ro;
		return $rm;
	}
	
	public function on_the_way_qty($id_shop, $from, $to)
	{
		$where = "id_shop = ".$id_shop." AND shipped = 0 AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$this->db->join("tbl_order", "tbl_delivery_detail.id_order = tbl_order.id_order");
		$this->db->select_sum("qty")->where($where);
		$rs = $this->db->get("tbl_delivery_detail",1);
		if($rs->num_rows() ==1)
		{
			return $rs->row()->qty;
		}else{
			return 0;
		}
	}
	
}// end class

?>