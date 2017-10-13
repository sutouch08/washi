<?php 
class Check_in extends CI_Controller
{
	public $home;
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."shop/check_in";
	}
	
	public function index($id_employee, $id_shop)
	{
		$from = date("Y-m-d")." 00:00:00";
		$to = date("Y-m-d")." 23:59:59";
		$sql = "SELECT * FROM tbl_time_table";
		$rs = $this->db->query($sql)->result();
		$data['id_employee'] = $id_employee;
		$data['id_shop'] = $id_shop;
		$data['view'] = "shop/check_in";
		$data['page_title'] = "บันทึกเวลา";
		$data['data'] = $rs;
		$this->load->view("include/shop_template", $data);
	}
	
	public function insert_to_table($id_employee, $id_shop)
	{
		$data['id_employee'] = $id_employee;
		$data['id_shop'] = $id_shop;
		$data['date_add'] = NOW();
		$rs = $this->db->insert("tbl_em_check_in", $data);
		$this->index($id_employee, $id_shop);
	}
	
	public function isCheckIn()
	{
		if(must_check_in())
		{
			echo "1";
		}else{
			echo "0";
		}
	}
	
}// End class

?>