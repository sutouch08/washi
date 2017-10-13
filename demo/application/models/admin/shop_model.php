<?php
class Shop_model extends CI_Model
{
	public $table = "tbl_shop";
	public $key = "id_shop";
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_data($id="")
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
	
	
	/*************** ตรวจสอบรหัสสาขาซ้ำ ****************/
	public function valid_code($code, $id="")
	{
		$this->db->select("shop_code");
		if($id !="")
		{
			$this->db->where("shop_code", $code);
			$this->db->where($this->key." !=", $id);
		}
		else
		{
			$this->db->where("shop_code", $code);
		}
		$rs = $this->db->get($this->table);
		if($rs->num_rows() >0)
		{
			return false;
		}else{
			return true;
		}
	}
	/*************** ตรวจสอบชื่อสาขาซ้ำ ****************/
	public function valid_name($name, $id="")
	{
		$this->db->select("shop_name");
		if($id !="")
		{
			$this->db->where("shop_name", $name);
			$this->db->where($this->key." !=", $id);
		}
		else
		{
			$this->db->where("shop_name", $name);
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
		$rs = $this->db->get("tbl_order");
		if($rs->num_rows() >0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	
} /***** end class *****/

?>