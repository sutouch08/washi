<?php 
class Config_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function get_urgent_data()
	{
			$rs = $this->db->get("tbl_urgent");
			if($rs->num_rows() >0)
			{
				return $rs->result();
			}
			else
			{
				return false;
			}
	}
	
		public function get_remark_data()
	{
			$rs = $this->db->get("tbl_remark");
			if($rs->num_rows() >0)
			{
				return $rs->result();
			}
			else
			{
				return false;
			}
	}
	
	public function update_urgent($id, $data)
	{
		$this->db->where("id_urgent", $id);
		$rs = $this->db->update("tbl_urgent", $data);
		if($rs)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function update_remark($id, $data)
	{
		$this->db->where("id_remark", $id);
		$rs = $this->db->update("tbl_remark", $data);
		if($rs)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}

?>