<?php 
class Config extends CI_Controller
{
	public $id_menu = 6;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/config_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/config_model");
		$this->home = base_url()."admin/config";
	}
	
	public function index()
	{
		$rs = $this->config_model->get_urgent_data();
		$ro = $this->config_model->get_remark_data();
		$data['view'] = $this->view;
		$data['urgent'] = $rs;
		$data['remark'] = $ro;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}	
	public function  update_data()
	{
		if($this->input->post("urgent_1") !="")
		{		
			$urgent1['day'] = $this->input->post("urgent_1");
			$urgent1['charge_up'] = $this->input->post("charge_1");
			$urgent2['day'] = $this->input->post("urgent_2");
			$urgent2['charge_up'] = $this->input->post("charge_2");
			$urgent3['day'] = $this->input->post("urgent_3");
			$urgent3['charge_up'] = $this->input->post("charge_3");
			$remark1['remark_text'] = $this->input->post("remark1");
			$remark2['remark_text'] = $this->input->post("remark2");
			if($this->verify->validate($this->id_menu, "edit"))
			{	
				$this->config_model->update_urgent(1, $urgent1);
				$this->config_model->update_urgent(2, $urgent2);
				$this->config_model->update_urgent(3, $urgent3);
				$this->config_model->update_remark(1, $remark1);
				$this->config_model->update_remark(2, $remark2);
				redirect($this->home);
			}else{
				action_deny($this->layout);
			}
		}
	}
	
}

?>