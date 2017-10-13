<?php
class Finished_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data()
	{
		$rs = $this->db->get_where("tbl_order", array("id_shop"=>$this->session->userdata("id_shop"), "state"=>7));
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function order_data($id_order)
	{
		$rs = $this->db->get_where("tbl_order", array("id_order"=>$id_order),1);
		if($rs->num_rows() == 1 )
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function received_back_detail($id_order)
	{
		$rs = $this->db->get_where("tbl_received_back", array("id_order"=>$id_order, "valid"=>0));
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}
		else
		{
			return false;
		}
	}
	
	public function order_qty($id_order_detail, $id_product)
	{
		$rs = $this->db->select("qty")->get_where("tbl_order_detail", array("id_order_detail"=>$id_order_detail, "id_product"=>$id_product), 1);
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->qty;
		}
		else
		{
			return 0;
		}
	}
	
	public function check_out($id_order_detail, $qty, $id_shop, $id_employee)
	{
		$ro = $this->db->get_where("tbl_received_back", array("id_order_detail"=>$id_order_detail, "id_shop"=>$id_shop), 1);
		if($ro->num_rows() ==1)
		{
			$rd = $ro->row();
			$data['id_shop'] = $id_shop;
			$data['id_employee'] = $id_employee;
			$data['id_order_detail'] = $rd->id_order_detail;
			$data['id_order'] = $rd->id_order;
			$data['id_product'] = $rd->id_product;
			$data['product_name'] = $rd->product_name;
			$data['qty'] = $qty;
			$rs = $this->db->insert("tbl_check_out", $data);
			if($rs)
			{
				$this->db->where("id_order_detail", $id_order_detail)->update("tbl_order_detail", array("state"=>8));
				if($this->finished_model->is_complete($rd->id_order))
				{
					$this->db->where("id_order", $rd->id_order)->update("tbl_order", array("state"=>8));
				}
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
			
	public function is_complete($id_order)
	{
		$rs = $this->db->get_where("tbl_order_detail", array("id_order"=>$id_order, "state"=>7));
		if($rs->num_rows() == 0 )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}// End class

?>