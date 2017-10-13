<?php 
class Payment_model extends CI_Model
{
	public $table = "tbl_payment";
	public $key = "id_payment";
	public function add($data)
	{
		$rs = $this->db->insert($this->table, $data);
		if($rs)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function delete_payment($id_order)
	{
		$rs = $this->db->delete($this->table, array("id_order"=>$id_order));
		if($rs){
			return true;
		}else{
			return false;
		}
	}
}

?>