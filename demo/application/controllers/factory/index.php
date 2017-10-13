<?php 
class Index extends CI_Controller
{
	public $id_menu = 25;
	public $layout = "include/factory_template";
	public $home;
	public $view = "factory/index";
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."factory/index";
	}
	
	public function index()
	{
		$data['view'] = $this->view;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
}

?>