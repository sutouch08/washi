<?php 
class Index extends CI_Controller
{
	public $id_menu = 17;
	public $layout = "include/shop_template";
	public $home;
	public $view = "shop/index";
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."shop/index";
	}
	
	public function index()
	{
		$data['view'] = $this->view;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
}

?>