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
	
	public function get_finished_order()
	{
		$this->db->join("tbl_order", "tbl_finished.id_order = tbl_order.id_order");
		$this->db->group_by("tbl_finished.id_order");
		$rs = $this->db->get("tbl_finished");
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}		
	}
	
	public function get_finished_detail($id_order)
	{
		$rs = $this->db->get_where("tbl_finished", array("id_order"=>$id_order, "valid"=>0));
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function get_loaded_order($id)
	{
		$this->db->join("tbl_order", "tbl_delivery_detail.id_order = tbl_order.id_order");
		$this->db->group_by("tbl_delivery_detail.id_order");
		$rs = $this->db->get_where("tbl_delivery_detail", array("id_delivery"=>$id, "tbl_delivery_detail.shipped"=>0));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_loaded_order_detail($id) // สำหรับดูรายละเอียดการจัดส่ง ** ดูเท่านั้น
	{
		$this->db->join("tbl_order", "tbl_delivery_detail.id_order = tbl_order.id_order");
		$this->db->group_by("order_no");
		$rs = $this->db->get_where("tbl_delivery_detail", array("id_delivery"=>$id));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	public function get_loaded_detail($id_delivery)
	{
		$this->db->join("tbl_delivery_detail", "tbl_finished_detail.id_order = tbl_delivery_detail.id_order");
		$rs = $this->db->get_where("tbl_finished_detail", array("id_delivery"=>$id_delivery, "tbl_finished_detail.valid"=>1));
		if($rs->num_rows() >0 ){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_delivery_qty($id_order, $id_delivery) /// หาว่าส่งสินค้ารอบนี้กี่ตัว (เป็นออเดอร์ ๆ)
	{
		//$sql = "SELECT SUM(qty) AS qty FROM tbl_finished_detail LEFT JOIN tbl_delivery_detail ON tbl_finished_detail.id_order_detail = tbl_delivery_detail.id_order_detail WHERE id_delivery =".$id_delivery." AND "
		$this->db->select_sum("qty");
		$rs = $this->db->where("id_order", $id_order)->where("id_delivery", $id_delivery)->get("tbl_delivery_detail");
		
		if($rs->num_rows() ==1){
			return $rs->row()->qty;
		}else{
			return 0;
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
		$qty = $data['qty'];
		$rd = $this->db->get_where("tbl_delivery_detail", array("id_order"=>$id_order, "id_order_detail"=>$id_order_detail, "id_delivery"=>$id_delivery));
		if($rd->num_rows() == 0)
		{
			$this->db->insert($this->detail_table, $data); // เพิ่มเข้าตารางจัดส่ง
			$old_qty = $this->db->select("qty")->get_where("tbl_finished", array("id_order_detail"=>$id_order_detail))->row()->qty; 
			$new_qty = $old_qty - $qty; // ถ้ายอดเสร็จ ลบด้วย ยอดส่ง แล้วได้เท่ากับ 0 ให้ลบออกจากตาราง ถ้าไม่ ให้แก้ไขจำนวนคงเหลือ
			if($new_qty <= 0)
			{
				$this->db->delete("tbl_finished", array("id_order_detail"=>$id_order_detail)); //ลบรายการออก
			}
			else
			{
				$this->db->where("id_order_detail", $id_order_detail)->update("tbl_finished", array("qty"=>$new_qty)); /// แก้ไขจำนวน
			}
		}
	}

	public function get_delivery_detail($id)
	{
		$rs = $this->db->select("id_order, id_product")->get_where("tbl_delivery_detail", array("id_delivery"=>$id));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
		public function get_detail_data($id)
	{
		$this->db->select("id_delivery, tbl_order.id_order, order_no, id_customer, id_urgent, id_delivery_detail");
		$this->db->join("tbl_delivery_detail", "tbl_order.id_order = tbl_delivery_detail.id_order", "left");
		$this->db->group_by("tbl_order.id_order");
		$rs = $this->db->get_where("tbl_order", array("tbl_delivery_detail.id_delivery"=>$id));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}		
	}

	public function delete_detail($id_order, $id_delivery)
	{
		$rd = $this->db->get_where("tbl_delivery_detail", array("id_order"=>$id_order, "id_delivery"=>$id_delivery, "shipped"=>0));
		foreach($rd->result() as $ro)
		{
			$data['id_order'] = $id_order;
			$data['id_order_detail'] = $ro->id_order_detail;
			$data['id_product'] = $ro->id_product;
			$data['product_name'] = $ro->product_name;
			$data['qty'] = $ro->qty;
			$data['date_add'] = NOW();
			/*******  เพิ่มรายการกลับไปที่ ตาราง เสร็จสิ้น ********************/
			$is = $this->db->select("id_finished_detail, qty")->get_where("tbl_finished", array("id_order_detail"=>$ro->id_order_detail),1);
			if($is->num_rows() ==1)
			{
				$new_qty = $is->row()->qty+$ro->qty;
				$this->db->where("id_finished_detail", $is->row()->id_finished_detail)->update("tbl_finished", array("qty"=>$new_qty));
			}
			else
			{
				$this->db->insert("tbl_finished", $data);
			}
			$this->db->where("id_order_detail", $ro->id_order_detail)->update("tbl_order_detail", array("state"=>5));
		}
			/********************* จบการเพิ่มข้อมูล กลับ **********************/
			/********************* ลบ รายการออกจาก ตารางการจัดส่ง  ***************/
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
	
	public function change_order_state($id_order, $id_state)
	{
		$rs = $this->db->where("id_order", $id_order)->update("tbl_order", array("state"=>$id_state));
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function change_order_detail_state($id_order_detail, $id_state)
	{
		$rs = $this->db->where("id_order_detail", $id_order_detail)->update("tbl_order_detail", array("state"=>$id_state));
		if($rs){
			return true;
		}else{
			return false;
		}
	}
}

?>