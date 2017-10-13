<?php 
class Payment_model extends CI_Model
{
	public function __construct()
	{
		parent:: __construct();
	}
	
	public function get_data($from = "",  $to = "")
	{
		$where = "date_upd BETWEEN '".$from."' AND '".$to."'";
		$rs = $this->db->where($where)->get("tbl_payment");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	public function payment_by_shop($id_shop = "", $from="", $to="")
	{
		$where = "id_shop = ".$id_shop." AND (date_upd BETWEEN '".$from."' AND '".$to."' )";
		$rs = $this->db->where($where)->get("tbl_payment");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	/******************************* รายงานการรับเงิน (เฉพาะออเดอร์) *****************************/
	public function payment_order($id_shop = "", $from="", $to="") 
	{
		$where = "id_shop = ".$id_shop." AND id_order != 0 AND (date_upd BETWEEN '".$from."' AND '".$to."' )";
		$rs = $this->db->where($where)->get("tbl_payment");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	/******************************* รายงานการรับเงิน (เฉพาะแพ็คเกจ) *****************************/
	public function payment_package($id_shop = "", $from="", $to="")
	{
		$where = "id_shop = ".$id_shop." AND id_order = 0 AND (date_upd BETWEEN '".$from."' AND '".$to."' )";
		$rs = $this->db->where($where)->get("tbl_payment");
		if($rs->num_rows() >0)
		{
			return $rs->result();
		}else{
			return false;
		}
	}
	
	/******************************* รายงานการยอดเงินค้างรับ *****************************/
	public function payment_balance($id_shop = 0, $from="", $to="")
	{
		$data = array();
		if($id_shop !=0)
		{
			$where = "id_shop = ".$id_shop." AND (date_upd BETWEEN '".$from."' AND '".$to."' ) AND balance > 0";
		}else{
			$where = "id_shop != 0 AND (date_upd BETWEEN '".$from."' AND '".$to."' ) AND balance > 0";
		}
		$rs = $this->db->where($where)->get("tbl_payment");
		if($rs->num_rows() >0)
		{
			foreach($rs->result() as $ro)
			{
				$b_amount = $ro->balance; 
				$repay = $this->payment_repay($ro->id_order, $ro->id_promotion, $ro->id_customer);
				if($repay >0)
				{
					$result = $b_amount - $repay;
					if($result >0)
					{
						$arr = array("date_upd"=>$ro->date_upd, "id_shop"=>$ro->id_shop, "id_order"=>$ro->id_order, "id_promotion"=>$ro->id_promotion, "id_customer"=>$ro->id_customer, "final_amount"=>$ro->final_amount, "balance"=>$result);
						array_push($data, $arr);
					}
				}else{
					$arr = array("date_upd"=>$ro->date_upd, "id_shop"=>$ro->id_shop, "id_order"=>$ro->id_order, "id_promotion"=>$ro->id_promotion, "id_customer"=>$ro->id_customer, "final_amount"=>$ro->final_amount, "balance"=>$b_amount);
					array_push($data, $arr);
				}
			}
			return $data;				
		}else{
			return false;
		}
	}
	
	public function payment_repay($id_order, $id_promotion, $id_customer)
	{
		$this->db->select_sum("pay")->where("id_order", $id_order)->where("id_promotion", $id_promotion)->where("id_customer", $id_customer)->where("repay", 1); 
		$rs = $this->db->get("tbl_payment", 1);
		if($rs->row()->pay !="")
		{
			return $rs->row()->pay;
		}else{
			return 0;
		}
	}
}// end class
?>