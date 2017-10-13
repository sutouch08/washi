<?php 
class Index extends CI_Controller
{
	public $id_menu = 30;
	public $layout = "include/management_template";
	public $home;
	public $view = "management/index";
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."management/index";
		$this->load->model("management/index_model");
		$this->load->model("management/report_model");
	}
	
	public function index()
	{
		$today 							= date("Y-m-d");
		$from 							= date("Y-m-01 00:00:00", strtotime($today));
		$to 								= date("Y-m-t 23:59:59", strtotime($today));
		$data['view'] 					= $this->view;
		$data['id_menu'] 				= $this->id_menu;
		$data['total_amount'] 			= $this->index_model->get_total_sale($from, $to);
		$data['complete_amount'] 	= $this->index_model->get_complete_amount($from, $to);
		$data['incomplete_amount'] 	= $this->index_model->get_incomplete_amount($from, $to);
		$data['from'] 					= $from;
		$data['to']						= $to;
		$this->load->view($this->layout, $data);
	}
	
	public function print_report()
	{
		if($this->input->post("data") != "")
		{
			$data['data'] = $this->input->post("data");
			$data['title'] = $this->input->post("heading");
			$view = "management/print/print_report";
			$data['id_menu'] = $this->id_menu;
			$this->load->view($view, $data);
		}else{
			setError("ไม่พบข้อมูล");
			$this->payment_by_shop();
		}
	}
	
}

?>