<?php
class User_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_time_table()
	{
		$rs = $this->db->get("tbl_time_table");
		if($rs->num_rows()>0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function get_employee()
	{
		$rs = $this->db->get_where("tbl_employee", array("id_shop !="=>0));
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function isRecorded($id_employee, $start, $end)
	{
		$yes = "<i class='fa fa-circle' style='color: #8CC152'></i>";
		$no = "<i class='fa fa-circle-thin' style='color: #AAB2BD'></i>";
		$where = "id_employee = ".$id_employee." AND (date_add BETWEEN '".$start."' AND '".$end."')";
		$rs = $this->db->where($where)->get("tbl_em_check_in");
		if($rs->num_rows() >0)
		{
			return $yes;
		}else{
			return $no;
		}	
	}
	
	public function get_time_recorded($id_employee, $from, $to)
	{
		if($id_employee != 0)
		{
			$where = "id_employee = ".$id_employee." AND (date_add BETWEEN '".$from."' AND '".$to."')";
		}else{
			$where = "id_employee != 0 AND (date_add BETWEEN '".$from."' AND '".$to."')";
		}
		$this->db->order_by("id_employee", "ASC")->order_by("date_add", "ASC");
		$rs = $this->db->where($where)->get("tbl_em_check_in");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
}//End Class

?>