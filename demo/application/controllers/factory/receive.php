<?php 
class Receive extends CI_Controller
{	
	public $id_menu = 27;
	public $layout = "include/factory_template";
	public $home;
	public $view = "factory/receive_view";
	public $add = "factory/receive_add";
	public $edit = "factory/receive_edit";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."factory/receive";
		$this->load->model("factory/receive_model");
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
		$this->load->model("factory/delivery_model");
		//$this->receive_model->change_delivery_to_received($id);
		$data['id_delivery'] = $id;
		$data['id_menu'] = $this->id_menu;
		$data['view'] = $this->add;
		$this->load->view($this->layout, $data);
	}
	
	
	
	public function receive_add($id_delivery)
	{
		$order_no = $this->input->post("order_no");
		$id = getIdOrderByOrderNumber($order_no);
		$rs = $this->receive_model->get_order_detail($id);	 // รายการสินค้าในออเดอร์
		$ro = $this->receive_model->get_order($id); // รายละเอียดของออเดอร์
		//$id_delivery_detail = $this->receive_model->get_delivery_detail_id($id_delivery, $id);  /// ได้ id_delivery_detail มาเพื่อเปลี่ยนสถานะเป็นรับแล้ว ( valid = 1)
		$this->db->where("id_delivery", $id_delivery)->update("tbl_delivery", array("shipped"=>1));
		$this->db->where("id_order", $id)->update("tbl_order", array("state"=>4));
		$data['id_menu'] = $this->id_menu;
		$data['id_delivery'] = $id_delivery;
		$data['id_order'] = $id;
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