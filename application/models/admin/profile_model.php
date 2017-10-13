<?php 
class Profile_model extends CI_Model
{
	public $table = "tbl_profile";
	public $key = "id_profile";
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
			$this->db->where("id_profile !=", 0);
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
			$menus = $this->db->select("id_menu")->get("tbl_menu");
			
			
			if($rs)
			{
				$id_profile = $this->db->get_where("tbl_profile", array("profile_name"=>$data['profile_name']),1)->row()->id_profile;
				foreach($menus->result() as $menu)
				{
					$datax['id_menu'] = $menu->id_menu;
					$datax['id_profile'] = $id_profile;
					$this->db->insert("tbl_access", $datax);
				}
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
		$this->db->delete("tbl_access", array("id_profile"=>$id));
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
		$this->db->select("profile_name");
		if($id !="")
		{
			$this->db->where("profile_name", $code);
			$this->db->where($this->key." !=", $id);
		}
		else
		{
			$this->db->where("profile_name", $code);
		}
		$rs = $this->db->get($this->table);
		if($rs->num_rows() >0)
		{
			return false;
		}else{
			return true;
		}
	}
	
}

?>