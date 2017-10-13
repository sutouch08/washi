<?php 
class Sale_by_shop extends CI_Controller
{
	public $home;
	public $id_menu = 31;
	public $layout = "include/management_template";
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."management/sale_by_shop";
		$this->load->model("management/report_model");
	}
	
	public function index($type="", $id_shop=0, $from="", $to="")
	{
		$rs = array();
		if($id_shop !=""){
			if($type =="rank")
			{
				$fr = date("Y-m-d", strtotime($from));
				$to 	= date("Y-m-d", strtotime($to));
				while($fr <= $to){
					$date = date("d-m-Y", strtotime($fr));
					$f = date("Y-m-d 00:00:00", strtotime($fr));
					$t = date("Y-m-d 23:59:59", strtotime($fr));
					$arr = array("date"=>$date, "from"=>$f, "to"=>$t);
					array_push($rs, $arr);
					$fr = date("Y-m-d", strtotime("+1 day $fr"));
				}
			}else if($type =="this_month"){
				$today = date("Y-m-d");
				$fr = date("Y-m-01", strtotime($today));
				$to 	= date("Y-m-d", strtotime($today));
				while($fr <= $to){
					$date = date("d-m-Y", strtotime($fr));
					$f = date("Y-m-d 00:00:00", strtotime($fr));
					$t = date("Y-m-d 23:59:59", strtotime($fr));
					$arr = array("date"=>$date, "from"=>$f, "to"=>$t);
					array_push($rs, $arr);
					$fr = date("Y-m-d", strtotime("+1 day $fr"));
				}
				$from = date("Y-m-01", strtotime($today));
			}else{
				$today = date("Y-m-d");
				$fr = date("Y-m-d", strtotime("-$from day $today"));
				$to 	= date("Y-m-d", strtotime("-1 day $today"));
				while($fr <= $to){
					$date = date("d-m-Y", strtotime($fr));
					$f = date("Y-m-d 00:00:00", strtotime($fr));
					$t = date("Y-m-d 23:59:59", strtotime($fr));
					$arr = array("date"=>$date, "from"=>$f, "to"=>$t);
					array_push($rs, $arr);
					$fr = date("Y-m-d", strtotime("+1 day $fr"));
				}
				$from = date("Y-m-d", strtotime("-$from day $today"));
			}
			$data['id_menu'] = $this->id_menu;
			$data['id_shop'] = $id_shop;
			$data['data'] = $rs;
			$data['from'] = $from;
			$data['to'] = $to;
			$data['view'] = "management/sale_by_shop";
			$this->load->view($this->layout, $data);
		}else{
			$data['id_menu'] = $this->id_menu;
			$data['id_shop'] = $id_shop;
			$data['data'] = false;
			$data['from'] = $from;
			$data['to'] = $to;
			$data['view'] = "management/sale_by_shop";
			$this->load->view($this->layout, $data);
		}
		
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
}// End class

?>