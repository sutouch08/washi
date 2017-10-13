<?php 
class Login_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function validate()
	{
		$this->db->where("user_name", $this->input->post("username"));
		$this->db->where("password", md5($this->input->post("password")));
		$this->db->where("active", 1);
		$rs = $this->db->get("tbl_user");
		if($rs->num_rows() == 1)
		{
			$this->update_login($rs->row()->id_user);
			return $rs->row();
		}			
	}
	
	public function update_login($id_user)
	{
		$now = date("Y-m-d H:i:s");
		$this->load->helper("date");
		$this->db->where("id_user", $id_user);
		$this->db->set("last_login", $now);
		$rs = $this->db->update("tbl_user");
	}
	
	public function get_profile($id_user)
	{
		$this->db->select("id_employee, id_profile, show_all");
		$rs = $this->db->get_where("tbl_user", array("id_user"=>$id_user), 1);
		return $rs->row();
	}
}
?>