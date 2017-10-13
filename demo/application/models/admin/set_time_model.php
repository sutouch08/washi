<?php 
class Set_time_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data($id ="")
	{
		if($id !="")
		{
			$rs = $this->db->get_where("tbl_time_table", array("id"=>$id), 1);
			if($rs->num_rows() == 1)
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
			$rs = $this->db->get("tbl_time_table");
			if($rs->num_rows() >0 )
			{
				return $rs->result();
			}
			else
			{
				return false;
			}
		}
	}
	
	public function update($id, $data)
	{
		$this->db->where("id", $id);
		$rs = $this->db->update("tbl_time_table", $data);
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
	public function delete($id)
	{
		$rs = $this->db->delete("tbl_time_table", array("id"=>$id));
		if($rs)
		{
			return true;
		}else{
			return false;
		}
	}
	
}//End class
?>