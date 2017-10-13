<?php
class Delivery_model extends CI_Model
{
	public $table = "tbl_delivery";
	public $key = "id_delivery";
	public $detail_table = "tbl_delivery_detail";
	public function construct()
	{
		parent::__construct();
	}
	
	public function count_row()
	{
		$this->db->where("id_shop", $this->session->userdata("id_shop"));
		$rs = $this->db->get($this->table);
		if($rs->num_rows() >0){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	
	public function get_data($id="",$per_page="", $offset="")
	{
		$id_shop = $this->session->userdata("id_shop");
		if($id !=""){
			$rs = $this->db->get_where($this->table, array($this->key=>$id, "id_shop"=>$id_shop), 1);
			if($rs->num_rows() == 1){
				return $rs->result();
			}else{
				return false;
			}
		}else if($per_page == ""){
			$rs = $this->db->get_where($this->table, array("id_shop"=>$id_shop));
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$this->db->limit($per_page, $offset);
			$rs = $this->db->get_where($this->table, array("id_shop"=>$id_shop));
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
		}
	}
	
	public function get_order_detail($id_order)
	{
		$rs = $this->db->get_where("tbl_order_detail", array("id_order"=>$id_order));
		if($rs->num_rows() >0 )
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function get_detail()
	{
		$this->db->select("tbl_order.id_order, order_no, id_customer, id_urgent, id_delivery_detail");
		$this->db->join("tbl_delivery_detail", "tbl_order.id_order = tbl_delivery_detail.id_order", "left");
		$rs = $this->db->get_where("tbl_order", array("state"=>2, "id_shop"=>$this->session->userdata("id_shop")));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}		
	}
	
	public function get_detail_data($id)
	{
		$this->db->select("tbl_order.id_order, order_no, id_customer, id_urgent, id_delivery_detail");
		$this->db->join("tbl_delivery_detail", "tbl_order.id_order = tbl_delivery_detail.id_order", "left");
		$this->db->group_by("tbl_order.id_order");
		$rs = $this->db->get_where("tbl_order", array("tbl_delivery_detail.id_delivery"=>$id, "id_shop"=>$this->session->userdata("id_shop")));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}		
	}
	
	public function get_loaded_order($id)
	{
		$this->db->join("tbl_order", "tbl_delivery_detail.id_order = tbl_order.id_order");
		$this->db->group_by("tbl_order.id_order");
		$rs = $this->db->get_where("tbl_delivery_detail", array("id_delivery"=>$id, "tbl_delivery_detail.shipped"=>0));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_delivery_detail_data($id_delivery)
	{
		$rs = $this->db->select_sum("qty")->select("id_order")->group_by("id_order")->get_where("tbl_delivery_detail", array("id_delivery"=>$id_delivery));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}	
	}
	
	public function insert_data($data)
	{
		$rs = $this->db->insert($this->table, $data);
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function insert_detail($id_delivery, $data)
	{
		$id_order = $data['id_order'];
		$id_order_detail = $data['id_order_detail'];
		$rd = $this->db->get_where("tbl_delivery_detail", array("id_order"=>$id_order, "id_order_detail"=>$id_order_detail, "id_delivery"=>$id_delivery));
		if($rd->num_rows() == 0)
		{
			$rs = $this->db->insert($this->detail_table, $data);
		}
	}
	
	public function insert_to_temp($id_order, $id_delivery)
	{
		$data['id_delivery'] = $id_delivery;
		$data['id_order'] = $id_order;
		$this->db->insert("tbl_delivery_temp", $data);
	}
	
	public function get_temp($id_delivery)
	{
		$rs = $this->db->select("id_order")->get_where("tbl_delivery_temp", array("id_delivery"=>$id_delivery));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_delivery_detail($id)
	{
		$rs = $this->db->select("id_order")->group_by("id_order")->get_where("tbl_delivery_detail", array("id_delivery"=>$id));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function delete_temp($id_order, $id_delivery)
	{
		$this->db->delete("tbl_delivery_temp", array("id_delivery"=>$id_delivery, "id_order"=>$id_order));
	}
	
	public function delete_detail($id_order, $id_delivery)
	{
		$rs = $this->db->delete("tbl_delivery_detail", array("id_order"=>$id_order, "id_delivery"=>$id_delivery));
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function update_data($id, $data)
	{
		$this->db->where($this->key, $id);
		$rs = $this->db->update($this->table, $data);
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function delete_data($id)
	{
		$rs = $this->db->delete($this->table, array($this->key=>$id));
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	 
	public function get_id_by_reference($reference)
	{
		$this->db->select($this->key);
		$rs = $this->db->get_where($this->table, array("reference"=>$reference), 1);
		if($rs->num_rows() ==1 ){
			return $rs->row()->id_delivery;
		}else{
			return false;
		}
	}
	
	public function delete_delivery($id)
	{
		$rs = $this->db->delete("tbl_delivery", array("id_delivery"=>$id));
		if($rs){
			return true; 
		}else{
			return false;
		}
	}
	
	public function is_shipped($id)
	{
		$rs = $this->db->select("valid")->get_where("tbl_delivery", array("id_delivery"=>$id), 1);
		if($rs->num_rows() == 1){
			if($rs->row()->valid == 0){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function shipped($id)
	{
		$this->db->where("id_delivery", $id)->update("tbl_delivery", array("valid"=>1));
		return true;
	}
}

?>