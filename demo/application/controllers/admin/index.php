<?php 
class Index extends CI_Controller
{
	public $id_menu = 1;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/index";
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."admin/index";
	}
	
	public function index()
	{
		$data['view'] = $this->view;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
}

?>