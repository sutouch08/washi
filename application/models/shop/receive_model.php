<?php
class Receive_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data()
	{
		$id_shop = $this->session->userdata("id_shop");
		$rs = $this->db->get_where("tbl_delivery", array("id_target"=>$id_shop, "valid"=>0));
		if($rs->num_rows() >0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	
	public function get_order_detail($id)
	{
		$state = 6; // สถานะเป็นระหว่างทาง
		$rs = $this->db->get_where("tbl_order_detail", array("id_order"=>$id, "state"=>$state));
		if($rs->num_rows() > 0){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_loaded_detail($id_order, $id_delivery)
	{
		$id_shop = $this->session->userdata("id_shop");
		$rs = $this->db->get_where("tbl_delivery_detail", array("id_order"=>$id_order, "id_delivery"=>$id_delivery, "shipped"=>0));
		if($rs->num_rows() >0 ){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_order($id)
	{
		$rs = $this->db->get_where("tbl_order", array("id_order"=>$id), 1 );
		if($rs->num_rows() ==1){
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function change_delivery_to_received($id)
	{
		$this->db->where("id_delivery", $id)->update("tbl_delivery", array("valid"=>1));
		return true;
	}
	
	public function change_delivery_detail_to_received($id) // เปลี่ยนสถานะ delivery_detail เป็น valid =1 ออเดอร์นี้ถูกรับเข้าแล้ว ** ครบไม่ครบอีกเรื่องหนึ่ง
	{
		$this->db->where("id_delivery_detail", $id)->update("tbl_delivery_detail", array("valid"=>1));
		return true;	
	}
	
	public function change_state_to_received($id_order_detail)
	{
		$rs = $this->db->where("id_order_detail", $id_order_detail)->update("tbl_order_detail", array("state"=>7));
		if($rs){
			return true;
		}
	}
	
	public function change_order_to_received($id)
	{
		$rs = $this->db->where("id_order", $id)->update("tbl_order", array("state"=>7));
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_detail($id_order_detail)
	{
		$rs = $this->db->where("id_order_detail", $id_order_detail)->get("tbl_order_detail", 1);
		if($rs->num_rows() ==1){
			return $rs->row();
		}else{
			return false;
		}
	}
		
	public function is_complete($id_order)
	{
		$rs = $this->db->get_where("tbl_order_detail", array("id_order"=>$id_order, "state"=>6));
		if($rs->num_rows() == 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function shipped($id_delivery)
	{
		$this->db->where("id_delivery", $id_delivery)->update("tbl_delivery", array("shipped"=>1));
	}
	
	public function is_received($id_delivery)
	{
		$rs = $this->db->get_where("tbl_delivery_detail", array("id_delivery"=>$id_delivery, "shipped"=>0));
		if($rs->num_rows() == 0 ){
			return true;
		}else{
			return false;
		}
	}
	
	public function add_to_received($id_order_detail, $qty, $id_delivery) // add order_detail to tbl_received_detail
	{
		$rs = $this->db->get_where("tbl_order_detail", array("id_order_detail"=>$id_order_detail), 1);  /// ดึงข้อมูลต้นแบบ
		if($rs->num_rows() == 1)
		{
			$ro = $rs->row();
			$data['id_delivery'] = $id_delivery;
			$data['qty'] = $qty;
			$data['id_order_detail'] = $id_order_detail;
			$data['id_shop'] = $this->session->userdata("id_shop");
			$data['date_add'] = NOW();
			$data['id_order'] = $ro->id_order;
			$data['id_product'] = $ro->id_product;
			$data['product_name'] = $ro->product_name;
			$rd = $this->db->insert("tbl_received_back", $data); /// เพิ่มเข้าตารางรับคืนสินค้าเข้า 
			if($rd)
			{
				$this->db->where("id_order_detail", $id_order_detail)->where("id_delivery", $id_delivery)->update("tbl_delivery_detail", array("shipped"=>1)); //// อัพเดตสถานะการจัดส่งเป็นรับแล้ว
				$this->db->where("id_order_detail", $id_order_detail)->update("tbl_order_detail", array("state"=>7)); //// อัพเดตสถานะการจัดส่งเป็นรับแล้ว
				if($this->is_complete($ro->id_order))
				{
					$this->db->where("id_order", $ro->id_order)->update("tbl_order", array("state"=>7));
				}
			}
			if($this->is_received($id_delivery)) /// ตรวจสอบว่ารายการที่ส่งมาในการจัดส่งครั้งนี้ถูกรับเข้าหมดหรือยัง
			{
				$this->db->where("id_delivery", $id_delivery)->update("tbl_delivery", array("valid"=>1)); /// ถ้ารับเข้าหมดแล้วเปลี่ยนสถานะเป็นรับเสร็จแล้ว
			}
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	public function is_mine($id_order)
	{
		$id_shop = $this->session->userdata("id_shop");
		$rs = $this->db->get_where("tbl_order", array("id_order"=>$id_order, "id_shop"=>$id_shop), 1);
		if($rs->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	public function get_delivery_order($id_delivery)
	{
		$this->db->select("tbl_delivery_detail.id_order, tbl_order.order_no, tbl_order.state, tbl_order.order_date")->from("tbl_delivery_detail")->join("tbl_order", "tbl_delivery_detail.id_order = tbl_order.id_order");
		$this->db->where("id_delivery", $id_delivery)->group_by("tbl_order.id_order");
		$rs = $this->db->get();
		if($rs->num_rows() > 0 )
		{
			return $rs->result();
		}else{
			return false;
		}		
	}
}

?>