<?php
class Index_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_total_sale($from, $to) // ยอดขายรวม
	{
		$where = "date_add BETWEEN '".$from."' AND '".$to."'";
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->total_amount;
		}
		else
		{
			return false;
		}
	}
	
	
	public function get_complete_amount($from, $to)
	{
		$where = "state = 8 AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->total_amount;
		}
		else
		{
			return false;
		}
	}
	
	public function get_incomplete_amount($from, $to)
	{
		$where = "state != 8 AND (date_add BETWEEN '".$from."' AND '".$to."')";
		$rs = $this->db->select_sum("total_amount")->where($where)->get("tbl_order_detail");
		if($rs->num_rows() == 1 )
		{
			return $rs->row()->total_amount;
		}
		else
		{
			return false;
		}
	}
	
	public function get_sale_last_days($i)
	{
		$data = array();
		$today = date("Y-m-d");
		while($i>0){
			$from = date("Y-m-d 00:00:00", strtotime("-$i day $today"));
			$to = date("Y-m-d 23:59:59", strtotime("-$i day $today"));
			$rs = $this->get_total_sale($from, $to);
			$arr = array("date"=>date("d/m", strtotime($from)), "amount"=>$rs);
			array_push($data, $arr);
			$i--;
		}
		return $data;		
	}
	
	public function get_qty_last_days($i)
	{
		$this->load->model("management/report_model");
		$data = array();
		$today = date("Y-m-d");
		while($i>0){
			$from = date("Y-m-d 00:00:00", strtotime("-$i day $today"));
			$to = date("Y-m-d 23:59:59", strtotime("-$i day $today"));
			$rs = $this->report_model->get_total_qty($from, $to);
			$arr = array("date"=>date("d/m", strtotime($from)), "amount"=>$rs);
			array_push($data, $arr);
			$i--;
		}
		return $data;		
	}
}// End class

?>