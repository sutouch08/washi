<?php 
class Package_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data($id_shop)
	{
		if($id_shop !=0)
		{
			$this->db->join("tbl_customer", "tbl_credit_detail.id_customer = tbl_customer.id_customer");
			$this->db->where("id_shop", $id_shop)->order_by("id_promotion", "ASC");
		}else{
			$this->db->order_by("id_promotion", "ASC");
		}
		$rs = $this->db->get("tbl_credit_detail");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function package_used($id_shop, $from, $to)
	{
		if($id_shop != 0)
		{
			$where = "id_shop = 	".$id_shop." AND (date_upd BETWEEN '".$from."' AND '".$to."')";
		}else{
			$where = "id_shop != 0 AND (date_upd BETWEEN '".$from."' AND '".$to."')";
		}
		$rs = $this->db->where($where)->get("tbl_package_used");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
}// End Class

?>