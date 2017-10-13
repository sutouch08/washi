<?php 
class Category_model extends CI_Model
{
	public $table = "tbl_category";
	public $key = "id_category";
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
			$this->db->where("id_category !=", 0);
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
		$this->db->select("category_name");
		if($id !="")
		{
			$this->db->where("category_name", $code);
			$this->db->where($this->key." !=", $id);
		}
		else
		{
			$this->db->where("category_name", $code);
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
		$rs = $this->db->get("tbl_product");
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