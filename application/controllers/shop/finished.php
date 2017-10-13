<?php 
class Finished extends CI_Controller
{
	public $id_menu = 23;
	public $layout = "include/shop_template";
	public $home;
	public $id_shop;
	public $view = "shop/finished_view";
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."shop/finished";
		$this->id_shop = $this->session->userdata("id_shop");
		$this->load->model("shop/finished_model");
		$this->load->model("shop/order_model");
	}
	
	public function index()
	{
		$rs = $this->finished_model->get_data();
		$data['id_menu'] = $this->id_menu;
		$data['data'] = $rs;
		$data['view'] = $this->view;
		$this->load->view($this->layout, $data);
		
	}
	
	public function check_out($id_order)
	{
		$rs = $this->finished_model->received_back_detail($id_order);
		$ro = $this->finished_model->order_data($id_order);
		$data['view'] = "shop/finished_check_out";
		$data['id_menu'] = $this->id_menu;
		$data['order'] = $ro;
		$data['detail'] = $rs;
		$data['id_order'] = $id_order;
		$this->load->view($this->layout, $data);	
	}
	
	public function check_it_out($id_order_detail, $qty)
	{
		$id_employee = $this->session->userdata("id_employee");
		$id_shop = $this->id_shop;
		$rs = $this->finished_model->check_out($id_order_detail, $qty, $id_shop, $id_employee);
		if($rs)
		{
			$this->db->where("id_order_detail", $id_order_detail)->update("tbl_received_back", array("valid"=>1));
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
	
}// End class
?>