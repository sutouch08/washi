<?php 
class Report extends CI_Controller
{
	public $home;
	public $id_menu = 31;
	public $layout = "include/management_template";
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."management/report";
		$this->load->model("management/report_model");
	}
	
	public function index()
	{
		$today = date("Y-m-d");
		$from = date("Y-m-01 00:00:00", strtotime($today));
		$to = date("Y-m-t 23:59:59", strtotime($today));
		$rs = $this->report_model->get_shop_list();
		$data['id_menu'] = $this->id_menu;
		$data['data'] = $rs;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['view'] = "management/sale_amount";
		$this->load->view($this->layout, $data);
		
	}
	
	public function sale_report($i ="")
	{
		$today 	= date("Y-m-d");
		if($i =="")
		{	
			$from 	= date("Y-m-01 00:00:00", strtotime($today));
			$to 		= date("Y-m-t 23:59:59", strtotime($today));
		}else if($i==0){
			$from 	= date("Y-m-d 00:00:00", strtotime("$today"));
			$to 		= date("Y-m-d 23:59:59", strtotime("$today"));
		}else{
			$from 	= date("Y-m-d 00:00:00", strtotime("-$i day $today"));
			$to 		= date("Y-m-d 23:59:59", strtotime("-1 day $today"));
		}
		$rs = $this->report_model->get_shop_list();
		$data['id_menu'] = $this->id_menu;
		$data['data'] = $rs;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['view'] = "management/sale_amount";
		$this->load->view($this->layout, $data);
	}
	
	public function sale_amount_by_shop($from, $to)
	{	
		$rs = $this->report_model->get_sale_each_shop($from, $to);
		$data['id_menu'] = $this->id_menu;
		$data['data'] = $rs;
		$data['view'] = "management/sale_amount";
		$this->load->view($this->layout, $data);
		
	}
	
	public function qty_report($type="",$from="", $to="")
	{
		$today = date("Y-m-d");
			if($type =="rank")
			{
				$from = date("Y-m-d 00:00:00", strtotime($from));
				$to = date("Y-m-d 23:59:59", strtotime($to));			
			}else if($type =="this_month"){
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
			}else if($type == "day"){
				if($from == 0){
					$to = date("Y-m-d 23:59:59", strtotime($today));
				}else{
					$to = date("Y-m-d 23:59:59", strtotime("-1 day $today"));
				}
				$from = date("Y-m-d 00:00:00", strtotime("-$from day $today"));
			}else{
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
			}
		$rs = $this->report_model->get_shop_list();
		$ro = $this->report_model->get_category();	
		$data['id_menu'] = $this->id_menu;
		$data['shop_list'] = $rs;
		$data['category'] = $ro;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['view'] = "management/qty_view";
		$this->load->view($this->layout, $data);			
	}
	
	public function moniter()
	{
		$rs = $this->report_model->get_shop_list();
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "management/moniter_view";
		$data['shop'] = $rs;
		$this->load->view($this->layout, $data);
	}
	
	public function qty_by_shop($type="",$from="", $to="")  /// รายงานปริมาณชิ้นงาน ส่วนของโรงงาน
	{
		$today = date("Y-m-d");
			if($type =="rank")
			{
				$from = date("Y-m-d 00:00:00", strtotime($from));
				$to = date("Y-m-d 23:59:59", strtotime($to));			
			}else if($type =="this_month"){
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
			}else if($type == "day"){
				if($from == 0){
					$to = date("Y-m-d 23:59:59", strtotime($today));
				}else{
					$to = date("Y-m-d 23:59:59", strtotime("-1 day $today"));
				}
				$from = date("Y-m-d 00:00:00", strtotime("-$from day $today"));
			}else{
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
			}
		$rs = $this->report_model->get_shop_list();
		$data['id_menu'] = $this->id_menu;
		$data['shop_list'] = $rs;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['view'] = "management/qty_by_shop_view";
		$this->load->view($this->layout, $data);			
	}
	
	
	public function qty_shop_report($type="",$from="", $to="") /// รายงานปริมาณชิ้นงาน ส่วนของสาขา
	{
		$today = date("Y-m-d");
			if($type =="rank")
			{
				$from = date("Y-m-d 00:00:00", strtotime($from));
				$to = date("Y-m-d 23:59:59", strtotime($to));			
			}else if($type =="this_month"){
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
			}else if($type == "day"){
				if($from == 0){
					$to = date("Y-m-d 23:59:59", strtotime($today));
				}else{
					$to = date("Y-m-d 23:59:59", strtotime("-1 day $today"));
				}
				$from = date("Y-m-d 00:00:00", strtotime("-$from day $today"));
			}else{
				$from = date("Y-m-01 00:00:00", strtotime($today));
				$to = date("Y-m-d 23:59:59", strtotime($today));
			}
		$rs = $this->report_model->get_shop_list();
		$data['id_menu'] = $this->id_menu;
		$data['shop_list'] = $rs;
		$data['from'] = $from;
		$data['to'] = $to;
		$data['view'] = "management/qty_by_shop";
		$this->load->view($this->layout, $data);			
	}
	
}// End class

?>