<?php 
class Verify extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function validate($id_menu, $action)
	{
		if($this->session->userdata("id_profile") == 0)
		{
			return true;
		}else{
			$this->db->select($action);
			$rs = $this->db->get_where("tbl_access", array("id_menu"=>$id_menu , "id_profile"=> $this->session->userdata("id_profile")), 1);
			$ro = $rs->row_array();
			if($ro[$action] == 1){
				return true;
			}else{
				return false;
			}
		}
	}
}
?>