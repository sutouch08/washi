<?php 
class Finish_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data()
	{
		$this->db->join("tbl_order", "tbl_received.id_order = tbl_order.id_order");
		$this->db->group_by("tbl_received.id_order");
		$rs = $this->db->get("tbl_received");
		if($rs->num_rows() > 0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_order($id_order)
	{
		$rs = $this->db->get_where("tbl_order", array("id_order"=>$id_order), 1);
		if($rs->num_rows() ==1){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_detail($id_order_detail, $id_delivery)
	{
		$rs = $this->db->get_where("tbl_received_detail", array("id_order_detail"=>$id_order_detail, "id_delivery"=>$id_delivery), 1);
		if($rs->num_rows() ==1){
			return $rs->row();
		}else{
			return false;
		}
	}
	
	public function get_order_detail($id_order)
	{
		$rs = $this->db->where("id_order", $id_order)->where("valid", 0)->get("tbl_received");
		if($rs->num_rows() > 0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function update_received($id_order_detail, $id_delivery, $qty)
	{
		$o_qty = $this->db->get_where("tbl_received", array("id_order_detail"=>$id_order_detail, "id_delivery"=>$id_delivery), 1)->row()->qty;
		$new_qty = $o_qty - $qty;
		if($new_qty <= 0)
		{
			$this->db->delete("tbl_received", array("id_order_detail"=>$id_order_detail, "id_delivery"=>$id_delivery));
		}
		else
		{
			$this->db->where("id_order_detail", $id_order_detail)->where("id_delivery", $id_delivery)->update("tbl_received", array("qty"=>$new_qty));
		}
	}
	public function add_to_finished($id_order_detail, $id_delivery, $qty) // เพิ่มรายการเข้าตาราง finished
	{
			$rd = $this->get_detail($id_order_detail, $id_delivery);
			if($rd != false){
				$id_order = $rd->id_order;
				$data['id_order_detail'] = $rd->id_order_detail;
				$data['id_order'] = $rd->id_order;
				$data['id_product'] = $rd->id_product;
				$data['product_name'] = $rd->product_name;
				$data['qty'] = $qty;
				$data['date_add'] = NOW();
				$is = $this->db->select("id_finished_detail, qty")->get_where("tbl_finished", array("id_order_detail"=>$rd->id_order_detail),1);
				if($is->num_rows() == 1)
				{
					$new_qty = $is->row()->qty+$qty;
					$rs = $this->db->where("id_finished_detail", $is->row()->id_finished_detail)->update("tbl_finished", array("qty"=>$new_qty));
				}
				else
				{
					$rs = $this->db->insert("tbl_finished", $data);  /// เพิ่มข้อมูลเข้าตาราง
				}
				$this->db->insert("tbl_finished_detail", $data);  /// เพิ่มข้อมูลเข้าตาราง
				$this->update_received($id_order_detail, $id_delivery, $qty); /// อัพเดตข้อมูลรับสินค้าเข้า 
				if($this->is_all($id_order_detail, $id_delivery)){ // ถ้ายอดรับเข้า เท่ากับยอดเสร็จสิ้น
					$this->db->where("id_order_detail",$id_order_detail)->update("tbl_order_detail", array("state"=>5));; // เปลี่ยนสถานะของรายการในตาราง order_detail เป็นรอส่งคืนร้าน
					if($this->is_complete($id_order)){ //ถ้าครบตามออเดอร์
						$this->db->where("id_order",$id_order)->update("tbl_order", array("state"=>5)); // เปลี่ยนสถานะออเดอร์เป็น รอส่งคืนร้าน
					}
				}
				if($rs){
					return true;
				}else{
					return false;
				}
			}
	}
	
	public function is_all($id_order_detail)
	{
		$rs = $this->db->get_where("tbl_received", array("id_order_detail"=>$id_order_detail));
		if($rs->num_rows() == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function is_complete($id_order)
	{
		$rs = $this->db->get_where("tbl_received", array("id_order"=>$id_order));
		if($rs->num_rows() == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}//end class
?>