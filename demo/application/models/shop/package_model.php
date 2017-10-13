<?php
class Package_model extends CI_Model
{
	public $table = "tbl_promotion";
	public $key = "id_promotion";
	public function __construct()
	{
		parent::__construct();
	}
	
	public function count_row()
	{
		$this->db->where("id_shop", $this->session->userdata("id_shop"));
		$this->db->or_where("id_shop", 0);
		$rs = $this->db->get($this->table);
		if($rs->num_rows() >0){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	
	public function get_data($id="", $per_page="", $offset="")
	{
		if($id !=""){
			$rs = $this->db->get_where($this->table, array($this->key=>$id),1);
			if($rs->num_rows() ==1){
				return $rs->result();
			}else{
				return false;
			}
		}else if($per_page ==""){
			$this->db->where("active", 1);
			$this->db->where_in("id_shop", array($this->session->userdata("id_shop"), 0));
			$rs = $this->db->get($this->table);
			if($rs->num_rows() >0){
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$this->db->limit($per_page, $offset);
			$this->db->where("active", 1);
			$this->db->where_in("id_shop", array($this->session->userdata("id_shop"), 0));
			$rs = $this->db->get($this->table);
			if($rs->num_rows() >0){
				return $rs->result();
			}else{
				return false;
			}
		}
	}
	
	public function insert_data($data)
	{
		$rs = $this->db->insert("tbl_credit_detail", $data);
		if($rs)
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	public function add_log($data)
	{
		$rs = $this->db->insert("tbl_package_log", $data);
		if($rs)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	public function update_data($id_customer, $id_promotion, $data)
	{
		$this->db->where("id_customer", $id_customer);
		$this->db->where("id_promotion", $id_promotion);
		$rs = $this->db->update("tbl_credit_detail", $data);
		if($rs)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function check_data($id_customer, $id_promotion)
	{
		$this->db->select("credit, duration, date_add");
		$rs = $this->db->get_where("tbl_credit_detail", array("id_customer"=>$id_customer, "id_promotion"=>$id_promotion), 1);
		if($rs->num_rows()==1 )
		{
			return $rs->row();
		}
		else
		{
			return false;
		}
	}
	
	public function autoComplete($q){
		 if($q =='*')
		 {
			 $this->db->select("id_customer, customer_code, customer_name, phone");
			 $this->db->where("id_shop", $this->session->userdata("id_shop"));
		 }else{
			$this->db->select("id_customer, customer_code, customer_name, phone");
			$this->db->like("customer_code", $q);
			$this->db->or_like("customer_name", $q);
			$this->db->or_like("phone", $q);
			$this->db->where("id_shop", $this->session->userdata("id_shop"));
		 }
		$qr = $this->db->get("tbl_customer");
		if($qr->num_rows() > 0){
			foreach($qr->result_array() as $rs){
				$dataset[] = $rs['id_customer']." : ".$rs['customer_code']." : ".$rs['customer_name']." : ".$rs['phone'];
			}
			echo json_encode($dataset);
		}else{
			$data[] = array("data"=>"nodata");
			echo json_encode($data);
		}
	}
	
}

?>