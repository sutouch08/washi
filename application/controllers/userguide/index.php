<?php 
class Index extends CI_Controller
{
	public $layout = "include/userguide";
	public $home;
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."userguide/index";
	}
	
	public function index()
	{
		$data['page_title'] = "บทนำ";
		$data['view'] = "userguide/general";
		$this->load->view($this->layout, $data);
	}
	
	public function toc()
	{
		$data['page_title'] = "Table of content";
		$data['view'] = "userguide/toc";
		$this->load->view($this->layout, $data);
	}
	
	public function shop()
	{
		$data['page_title'] = "ส่วนของสาขา";
		$data['view'] = "userguide/shop/index";
		$this->load->view($this->layout, $data);
	}
}
?>