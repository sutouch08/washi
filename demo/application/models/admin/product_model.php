<?php 
class Product_model extends CI_Model
{
	public $table = "tbl_product";
	public $key = "id_product";
	public function __construct()
	{
		parent::__construct();
	}
	
	public function count_row()
	{
		$rs = $this->db->get($this->table);
		if($rs->num_rows() >0){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	
	public function get_data($id='',$per_page="", $total_row="")
	{
		if($id !="")
		{
			$rs = $this->db->get_where($this->table, array($this->key=>$id),1);
			if($rs->num_rows() ==1)
			{
				return $rs->result();
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->db->limit($per_page, $total_row);
			$rs = $this->db->get($this->table);
			if($rs->num_rows() >0)
			{
				return $rs->result();
			}
			else
			{
				return false;
			}
		}
	}
	
	public function add($data)
	{
			$rs = $this->db->insert($this->table, $data);
			if($rs)
			{
				return true;
			}else{
				return false;
			}		
	}
	
	public function edit($data, $id)
	{
		$this->db->where($this->key, $id);
		$rs = $this->db->update($this->table, $data);
		if($rs)
			{
				return true;
			}else{
				return false;
			}		
	}
	
	public function delete($id)
	{
		$rs = $this->db->delete($this->table, array($this->key=>$id));
		if($rs)
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
	
		/*************** ตรวจสอบรหัสซ้ำ ****************/
	public function valid_code($code, $id="")
	{
		$this->db->select("product_name");
		if($id !="")
		{
			$this->db->where("product_name", $code);
			$this->db->where($this->key." !=", $id);
		}
		else
		{
			$this->db->where("product_name", $code);
		}
		$rs = $this->db->get($this->table);
		if($rs->num_rows() >0)
		{
			return false;
		}else{
			return true;
		}
	}
	
	public function valid_transection($id)
	{
		$this->db->where($this->key, $id);
		$rs = $this->db->get("tbl_order_detail");
		if($rs->num_rows() >0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
}

?>