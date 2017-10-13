<?php 
class Finish extends CI_Controller
{	
	public $id_menu = 28;
	public $layout = "include/factory_template";
	public $home;
	public $view = "factory/finish_view";
	public $add = "factory/finish_add";
	public $edit = "factory/finish_edit";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."factory/finish";
		$this->load->model("factory/finish_model");
	}
	
	public function index()
	{
		$rs = $this->finish_model->get_data();
		$data['id_menu'] = $this->id_menu;
		$data['data'] = $rs;
		$data['view'] = $this->view;
		$this->load->view($this->layout, $data);
	}
	
	public function finished($id)
	{
		$rs = $this->finish_model->get_order_detail($id);
		$ro = $this->finish_model->get_order($id);
		$data['id_menu'] = $this->id_menu;
		$data['view'] = $this->add;
		$data['id_order'] = $id;
		$data['order'] = $ro;
		$data['detail'] = $rs;
		$this->load->view($this->layout, $data);
	}
	
	public function add_to_finished($id_order_detail, $id_delivery, $qty)
	{
		$rs = $this->finish_model->add_to_finished($id_order_detail, $id_delivery, $qty);
		if($rs){
			echo "1";
		}else{
			echo "0";
		}
	}

}// end class

?>