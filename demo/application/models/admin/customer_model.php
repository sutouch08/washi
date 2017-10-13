<?php
class Customer_model extends CI_Model
{
	public $table = "tbl_customer";
	public $key = "id_customer";
	public $name = "customer_name";
	public function construct()
	{
		parent::__construct();
	}
	
	public function count_row()
	{
		$rs = $this->db->get($this->table);
		if($rs->num_rows() >0 ){
			return $rs->num_rows();
		}else{
			return false;
		}
	}
	
	public function get_data($id="", $perpage="", $limit ="")
	{
		if($id !=""){
			$rs = $this->db->get_where($this->table, array($this->key=>$id), 1);
			if($rs->num_rows() == 1){
				return $rs->result();
			}else{
				return false;
			}
		}else{
			$rs = $this->db->limit($perpage, $limit)->get($this->table);
			if($rs->num_rows() >0 ){
				return $rs->result();
			}else{
				return false;
			}
		}
	}
	
	public function insert_data($data)
	{
		$rs = $this->db->insert($this->table, $data);
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function update_data($id, $data)
	{
		$this->db->where($this->key, $id);
		$rs = $this->db->update($this->table, $data);
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function delete_data($id)
	{
		$rs = $this->db->delete($this->table, array($this->key=>$id));
		if($rs){
			return true;
		}else{
			return false;
		}
	}
	
	public function autoComplete($id_shop, $q){
		 if($q =='*')
		 { 
			 $sql = "SELECT id_customer, customer_code, customer_name, id_shop, phone FROM tbl_customer WHERE id_shop = $id_shop";
		 }else{
			$sql = "SELECT id_customer, customer_code, customer_name, id_shop, phone FROM tbl_customer WHERE id_shop = $id_shop AND (customer_name LIKE'%".$q."%' OR phone LIKE'%".$q."%' OR customer_code LIKE'%".$q."%')";
		 }
			$qr = $this->db->query($sql);
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
	
	
			/*************** ตรวจสอบรหัสซ้ำ ****************/
	public function valid_code($code, $id="")
	{
		$this->db->select("customer_code");
		if($id !=""){
			$this->db->where("customer_code", $code);
			$this->db->where($this->key." !=", $id);
		}else{
			$this->db->where("customer_code", $code);
		}
		$rs = $this->db->get($this->table);
		if($rs->num_rows() >0){
			return false;
		}else{
			return true;
		}
	}
	
	public function valid_transection($id)
	{
		$this->db->where($this->key, $id);
		$rs = $this->db->get("tbl_order");
		if($rs->num_rows() >0){
			return false;
		}else{
			return true;
		}
	}
	
}

?>