<?php
class Permission_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_profile()
	{
		$rs = $this->db->get_where("tbl_profile", array("id_profile !="=>0));
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_permission($id_profile)
	{
		$this->db->select("id_access, menu_name, tbl_access.id_menu, id_profile, view, add, edit, delete");
		$this->db->join("tbl_access", "tbl_menu.id_menu = tbl_access.id_menu", "left")->where("id_profile", $id_profile);
		$rs = $this->db->get("tbl_menu");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function update($id_access, $data)
	{
		$this->db->where("id_access", $id_access)->update("tbl_access", $data);
	}
	
}//End class
?>