<?php 
class Payment extends CI_Controller
{
	public $home;
	public $id_menu = 31;
	public $layout = "include/management_template";
	public $view = "management/payment_view";
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."management/payment";
		$this->load->model("management/payment_model");
	}
	
	public function index()
	{
		$today = date("Y-m-d");
		$from = date("Y-m-01 00:00:00", strtotime($today));
		$to = date("Y-m-d 23:59:59", strtotime($today));
		$rs = $this->payment_model->get_data($from, $to);
		$data['id_menu'] = $this->id_menu;
		$data['view'] = $this->view;
		$data['data'] = $rs;
		$data['from'] = $from;
		$data['to'] = $to;
		$this->load->view($this->layout, $data);
		
	}
	
	public function payment_report($type="", $from="", $to="")
	{
		if($type=="rank")
			{
				$today = date("Y-m-d");
				$from = date("Y-m-d 00:00:00", strtotime($from));
				$to = date("Y-m-d 23:59:59", strtotime($to));
				$rs = $this->payment_model->get_data($from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_view";
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}else if($type == "this_month"){
				$today = date("Y-m-d");
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
				$rs = $this->payment_model->get_data($from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_view";
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date("Y-m-d");
				if($from ==0){
					$to = date("Y-m-d 23:59:59", strtotime($today));
				}else{
					$to = date("Y-m-d 23:59:59", strtotime("-1 day $today"));
				}
				$from = date("Y-m-d 00:00:00", strtotime("-$from day $today"));
				$rs = $this->payment_model->get_data($from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_view";
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}
		$this->load->view($this->layout, $data);
	}
	
	public function payment_by_shop($type="", $id_shop ="", $from="", $to="")
	{	
		if($id_shop != "")
		{
			if($type=="rank")
			{
				$today = date("Y-m-d");
				$from = date("Y-m-d 00:00:00", strtotime($from));
				$to = date("Y-m-d 23:59:59", strtotime($to));
				$rs = $this->payment_model->payment_by_shop($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_by_shop";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}else if($type == "this_month"){
				$today = date("Y-m-d");
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
				$rs = $this->payment_model->payment_by_shop($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_by_shop";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date("Y-m-d");
				if($from ==0){
					$to = date("Y-m-d 23:59:59", strtotime($today));
				}else{
					$to = date("Y-m-d 23:59:59", strtotime("-1 day $today"));
				}
				$from = date("Y-m-d 00:00:00", strtotime("-$from day $today"));
				$rs = $this->payment_model->payment_by_shop($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_by_shop";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}
		}else{
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "management/payment_by_shop";
			$data['data'] = false;
			$data['id_shop'] = 0;
			$data['from'] = $from;
			$data['to'] = $to;
		}
			$this->load->view($this->layout, $data);	
		
	}
	
	public function print_report()
	{
		if($this->input->post("data") != "")
		{
			$data['data'] = $this->input->post("data");
			$data['title'] = $this->input->post("heading");
			$view = "management/print/payment_report";
			$data['id_menu'] = $this->id_menu;
			$this->load->view($view, $data);
		}else{
			setError("ไม่พบข้อมูล");
			$this->payment_by_shop();
		}
	}
	
	public function payment_order($type="", $id_shop=0, $from="", $to="")
	{
		if($id_shop != 0)
		{
			if($type=="rank")
			{
				$today = date("Y-m-d");
				$from = date("Y-m-d 00:00:00", strtotime($from));
				$to = date("Y-m-d 23:59:59", strtotime($to));
				$rs = $this->payment_model->payment_order($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_order";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}else if($type == "this_month"){
				$today = date("Y-m-d");
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
				$rs = $this->payment_model->payment_order($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_order";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date("Y-m-d");
				if($from ==0){
					$to = date("Y-m-d 23:59:59", strtotime($today));
				}else{
					$to = date("Y-m-d 23:59:59", strtotime("-1 day $today"));
				}
				$from = date("Y-m-d 00:00:00", strtotime("-$from day $today"));
				$rs = $this->payment_model->payment_order($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_order";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}
		}else{
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "management/payment_order";
			$data['data'] = false;
			$data['id_shop'] = 0;
			$data['from'] = $from;
			$data['to'] = $to;
		}
			$this->load->view($this->layout, $data);		
	}
	
	public function payment_package($type="", $id_shop=0, $from="", $to="")
	{
		if($id_shop != 0)
		{
			if($type=="rank")
			{
				$today = date("Y-m-d");
				$from = date("Y-m-d 00:00:00", strtotime($from));
				$to = date("Y-m-d 23:59:59", strtotime($to));
				$rs = $this->payment_model->payment_package($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_package";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}else if($type == "this_month"){
				$today = date("Y-m-d");
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
				$rs = $this->payment_model->payment_package($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_package";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}else{
				$today = date("Y-m-d");
				if($from ==0){
					$to = date("Y-m-d 23:59:59", strtotime($today));
				}else{
					$to = date("Y-m-d 23:59:59", strtotime("-1 day $today"));
				}
				$from = date("Y-m-d 00:00:00", strtotime("-$from day $today"));
				$rs = $this->payment_model->payment_package($id_shop, $from, $to);
				$data['id_menu'] = $this->id_menu;
				$data['view'] = "management/payment_package";
				$data['id_shop'] = $id_shop;
				$data['data'] = $rs;
				$data['from'] = $from;
				$data['to'] = $to;
			}
		}else{
			$data['id_menu'] = $this->id_menu;
			$data['view'] = "management/payment_package";
			$data['data'] = false;
			$data['id_shop'] = 0;
			$data['from'] = $from;
			$data['to'] = $to;
		}
			$this->load->view($this->layout, $data);		
	}
	
	public function payment_balance($id_shop=0, $from="", $to="")
	{
		$from = date("Y-m-d 00:00:00", strtotime($from));
		$to = date("Y-m-d 23:59:59", strtotime($to));
		$rs = $this->payment_model->payment_balance($id_shop, $from, $to);
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "management/payment_balance";
		$data['id_shop'] = $id_shop;
		$data['data'] = $rs;
		$data['from'] = $from;
		$data['to'] = $to;
		$this->load->view($this->layout, $data);		
	}
	
}// End class

?>