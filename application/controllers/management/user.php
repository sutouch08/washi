<?php 
class User extends CI_Controller
{
	public $id_menu = 31;
	public $home;
	public $layout = "include/management_template";
	
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."management/user";
		$this->load->model("management/user_model");
	}
	
	public function index()
	{
		$rs = $this->user_model->get_time_table();
		$ro = $this->user_model->get_employee();
		$data['view'] = "management/user_table_view";
		$data['id_menu'] = $this->id_menu;
		$data['time_table'] = $rs;
		$data['employee'] = $ro;
		$this->load->view($this->layout, $data);
	}
	
	public function time_recorded_report($id_employee=0, $from="", $to="")
	{
		if($id_employee != 0)
		{
			$from = date("Y-m-d 00:00:00", strtotime($from));
			$to = date("Y-m-d 23:59:59", strtotime($to));
			$rs = $this->user_model->get_time_recorded($id_employee, $from, $to);
			$ro = $this->user_model->get_time_table();
			$data['id_menu'] = $this->id_menu;
			$data['id_employee'] = $id_employee;
			$data['view'] = "management/time_record_view";
			$data['from'] = $from;
			$data['to'] = $to;
			$data['diff'] = dateDiff(date("Y-m-d",strtotime($from)), date("Y-m-d",strtotime($to)));
			$data['data'] = $rs;
			$data['time_table'] = $ro;
		}else{
			$today = date("Y-m-d");
			
			$ro = $this->user_model->get_time_table();
			$data['id_menu'] = $this->id_menu;
			$data['id_employee'] = $id_employee;
			$data['view'] = "management/time_record_view";
			$data['from'] = $from;
			$data['to'] = $to;
			$data['time_table'] = $ro;
			$data['diff'] = dateDiff(date("Y-m-d",strtotime($from)), date("Y-m-d",strtotime($to)));
			$data['data'] = false;
		}
		$this->load->view($this->layout, $data);
	}
}// End class
?>