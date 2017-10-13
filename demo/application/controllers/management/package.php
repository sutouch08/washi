<?php
class Package extends CI_Controller
{
	public $id_menu = 31;
	public $home;
	public $layout = "include/management_template";
	
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."management/package";
		$this->load->model("management/package_model");
	}
	
	public function index()
	{
		$rs = $this->package_model->get_data();
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "management/package_balance_view";
		$data['data'] = $rs;
		$data['page_title'] = "แพ็คเกจคงเหลือ";
		$this->load->view($this->layout, $data);
	}
	
	public function package_balance($id_shop = 0)
	{
		$rs = $this->package_model->get_data($id_shop);
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "management/package_balance_view";
		$data['data'] = $rs;
		$data['page_title'] = "แพ็คเกจคงเหลือ";
		$data['id_shop'] = $id_shop;
		$this->load->view($this->layout, $data);
	}
	
	public function package_used($type="", $id_shop="", $from="", $to="")
	{
		if($type=="rank")
		{
			$today = date("Y-m-d");
			$from = date("Y-m-d 00:00:00", strtotime($from));
			$to = date("Y-m-d 23:59:59", strtotime($to));	
		}else if($type == "this_month"){
			$today = date("Y-m-d");
			$from = date("Y-m-01 00:00:00", strtotime($today));
			$to = date("Y-m-d 23:59:59", strtotime($today));
		}else{
			$today = date("Y-m-d");
			if($from ==0){
				$to = date("Y-m-d 23:59:59", strtotime($today));
			}else{
				$to = date("Y-m-d 23:59:59", strtotime("-1 day $today"));
			}
			$from = date("Y-m-d 00:00:00", strtotime("-$from day $today"));
		}
		$rs = $this->package_model->package_used($id_shop, $from, $to);
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "management/package_used_view";
		$data['id_shop'] = $id_shop;
		$data['data'] = $rs;
		$data['from'] = $from;
		$data['to'] = $to;
		$this->load->view($this->layout, $data);
	}
	
	
}// end class
?>