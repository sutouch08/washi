<?php
class Order_model extends CI_Model
{
	public $main_table 	= "tbl_order";
	public $main_key 		= "id_order";
	public $detail_table 	= "tbl_order_detail";
	public $detail_key 		= "id_order_detail";
	
	public function count_row()
	{	
		$this->db->where("id_shop", $this->session->userdata("id_shop"));
		$rs = $this->db->get($this->main_table);
		if($rs->num_rows() >0){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	public function get_data($id="", $per_page="", $limit="") // main table
	{
		$id_shop = $this->session->userdata("id_shop");
		if($id !="")	{
			$rs = $this->db->get_where($this->main_table, array($this->main_key=>$id, "id_shop"=>$id_shop),1);
			if($rs->num_rows() ==1){
				return $rs->result();
			}else{
				return false;
			}
		}else if($per_page ==""){
			$this->db->order_by("id_urgent", "desc");
			$this->db->order_by("due_date", "desc");
			$rs = $this->db->get_where($this->main_table, array("id_shop"=>$id_shop));
			if($rs->num_rows() >0){
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$this->db->order_by("id_urgent", "desc");
			$this->db->order_by("due_date", "desc");
			$this->db->limit($per_page, $limit);
			$rs = $this->db->get_where($this->main_table, array("id_shop"=>$id_shop));
			if($rs->num_rows() >0){
				return $rs->result();
			}else{
				return false;
			}
		}
	}
		
	public function get_detail($id)
	{
		$rs = $this->db->get_where("tbl_order_detail", array("id_order"=>$id));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function delete_detail($id_order)
	{
		$rs = $this->db->delete("tbl_order_detail", array("id_order"=>$id_order));
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function delete_order($id_order)
	{
		$rs = $this->db->delete("tbl_order", array("id_order"=>$id_order));
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_credit($id_customer)
	{
		$this->db->select("tbl_credit_detail.id_promotion, promotion_name, credit, id_credit_type");
		$this->db->join("tbl_promotion", "tbl_credit_detail.id_promotion = tbl_promotion.id_promotion");
		$rs = $this->db->get_where("tbl_credit_detail", array("id_customer"=>$id_customer));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_payment($id_order)
	{
		$rs = $this->db->get_where("tbl_payment", array("id_order"=>$id_order), 1);
		if($rs->num_rows() == 1 )	{
			return $rs->result();
		}else{
			return false;
		}		
	}
	
	public function order_qty($id_order)
	{
		$qty = 0;
		$this->db->select_sum("qty");
		$rs = $this->db->get_where("tbl_order_detail", array("id_order"=>$id_order));
		if($rs->num_rows() ==1){
			$qty = $rs->row()->qty;
		}
		return $qty;
	}
	
	public function total_amount($id_order)
	{
		$amount = 0;
		$this->db->select_sum("total_amount");
		$rs = $this->db->get_where("tbl_order_detail", array("id_order"=>$id_order));
		if($rs->num_rows() ==1){
			$amount = $rs->row()->total_amount;
		}
		return $amount;
	}
		
	public function get_condition($id)
	{
		$urgent = "-";
		$this->db->select("urgent_name");
		$rs = $this->db->get_where("tbl_urgent", array("id_urgent"=>$id), 1);
		if($rs->num_rows() ==1 )	{
			$urgent = $rs->row()->urgent_name;
		}
		return $urgent;
	}
	
	public function get_state($id)
	{
		$state = "-";
		$this->db->select("state_name");
		$rs = $this->db->get_where("tbl_state", array("id_state"=>$id), 1 );
		if($rs->num_rows() ==1){
			$state = $rs->row()->state_name;
		}
		return $state;
	}
	
	public function get_category()
	{
		$rs = $this->db->get("tbl_category");
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_product_by_category($id_category)
	{
		$this->db->order_by("id_type");
		$rs = $this->db->get_where("tbl_product", array("id_category"=>$id_category));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function add($data)
	{
		$rs = $this->db->insert("tbl_order", $data);
		if($rs){
			$ro = $this->db->select("id_order")->get_where("tbl_order", array("order_no"=>$data['order_no']), 1);
			return $ro->row()->id_order;
		}else{
			return false;
		}
	}
	
	public function insert_detail($data)
	{
		$rs = $this->db->insert("tbl_order_detail", $data);
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function state_change($id_order, $id_state)
	{
		$this->db->where("id_order", $id_order);
		$rs = $this->db->update("tbl_order", array("state"=>$id_state));
		if($rs){
			$this->state_change_detail($id_order, $id_state);
			return true;
		}else{
			return false;
		}
	}
	
	public function state_change_detail($id_order, $id_state)
	{
		$this->db->where("id_order", $id_order);
		$rs = $this->db->update("tbl_order_detail", array("state"=>$id_state));
		return true;
	}
	
	public function package_used($data)
	{
		$rs = $this->db->insert("tbl_package_used", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
		
	public function update_credit($id_customer, $id_promotion, $data)
	{
		$this->db->where("id_customer", $id_customer);
		$this->db->where("id_promotion", $id_promotion);
		$rs = $this->db->update("tbl_credit_detail", $data);
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function valid_order($id_order)
	{
		$rs = $this->balance_payment($id_order);
		if(!$rs){
			$this->db->where("id_order", $id_order);
			$this->db->update("tbl_order", array("valid"=>1));
		}
		return true;
	}
	
	public function balance_payment($id_order) // ส่งค่า false กลับ ถ้าไม่มียดค้างชำระ   ///   ส่งค่า true กลับ ถ้าไม่มีรายการชำระ   /// ส่งยอดค้างชำระกลับ ถ้ามียอดค้างชำระ
	{
		$this->db->select_sum("final_amount");
		$this->db->select_sum("pay");
		$this->db->select_sum("balance");
		$rs = $this->db->get_where("tbl_payment", array("id_order"=>$id_order), 1);
		if($rs->num_rows() == 1 )	{
			$balance  = $rs->row()->balance;
			$pay = $rs->row()->pay;
			$final_amount = $rs->row()->final_amount;
			$value = $final_amount - $pay;
			if($final_amount == null){
				return true;
			}else if($balance == 0.00){
				return false;
			}else if($value == 0){
				return false;
			}else{
				return $balance;
			}
		}
	}
	
	public function get_balance_payment($id_order)
	{
		$rs = $this->db->get_where("tbl_payment", array("id_order"=>$id_order,"repay"=>1), 1);
		if($rs->num_rows() ==1){
			return $rs->result();
		}else{
			return false;
		}
	}
	
}

?>