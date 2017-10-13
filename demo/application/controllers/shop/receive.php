<?php 
class Receive extends CI_Controller
{	
	public $id_menu = 22;
	public $layout = "include/shop_template";
	public $home;
	public $view = "shop/receive_view";
	public $add = "shop/receive_add";
	public $edit = "shop/receive_edit";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."shop/receive";
		$this->load->model("shop/receive_model");
	}
	
	public function index()
	{
		$rs = $this->receive_model->get_data();
		$data['id_menu'] = $this->id_menu;
		$data['data'] = $rs;
		$data['view'] = $this->view;
		$this->load->view($this->layout, $data);
	}
	
	public function add($id="")
	{
		$this->receive_model->shipped($id);
		$data['id_delivery'] = $id;
		$data['id_menu'] = $this->id_menu;
		$data['view'] = $this->add;
		$this->load->view($this->layout, $data);
	}
	
	public function receive_add($id_delivery)
	{
		$order_no = $this->input->post("order_no");
		$id = getIdOrderByOrderNumber($order_no);
		if($this->receive_model->is_mine($id))
		{
			$rs = $this->receive_model->get_loaded_detail($id, $id_delivery);	 // รายการสินค้าในออเดอร์
			$ro = $this->receive_model->get_order($id); // รายละเอียดของออเดอร์
		}
		else
		{
			$rs = false;
			$ro = false;
		}
		$data['id_menu'] = $this->id_menu;
		$data['id_order'] = $id;
		$data['id_delivery'] = $id_delivery;
		$data['order'] = $ro;
		$data['detail'] = $rs;
		$data['page_title'] = "รับสินค้าเข้า";
		$data['view'] = $this->add;
		$this->load->view($this->layout, $data);	
	}
	
	public function add_to_received($id, $qty, $id_delivery)
	{
		$rs = $this->receive_model->add_to_received($id, $qty, $id_delivery);
		if($rs){
			echo "1";
		}else{
			echo "0";
		}
	}
	
}// end class

?>