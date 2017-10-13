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
	
	public function update_script($id_target)
	{
		$rs = $this->db->select("tbl_order.id_order, id_delivery")->from("tbl_order")->join("tbl_delivery_detail", "tbl_order.id_order = tbl_delivery_detail.id_order")->where("state", 4)->where("shipped", 0)->group_by("tbl_order.id_order")->get();
		if($rs->num_rows() > 0 )
		{
			$i = 0;
			$n = 0;
			$r = $rs->num_rows();
			foreach($rs->result() as $ro)
			{
				$rm = $this->db->where("id_order", $ro->id_order)->update("tbl_order", array("state"=>3));
				$rx = $this->db->where("id_order", $ro->id_order)->update("tbl_order_detail", array("state"=>3));
				if($rx)
				{
					$i++;
				}else{
					$n++;
				}				
				//echo "id_order = ".$ro->id_order." : id_delivery = ".$ro->id_delivery." <br/>";
			}
			echo  "UPDATE Complete <br/> Success : $i rows <br/> Fail : $n rows";
		}
	}
	
	public function add($id="")
	{
		$this->load->model("factory/delivery_model");
		$rs = $this->receive_model->get_delivery_order($id);
		$data['id_delivery'] = $id;
		$data['data']		= $rs;
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
		//$this->receive_model->update_received($id_delivery);
		//$this->db->where("id_delivery", $id_delivery)->update("tbl_delivery", array("shipped"=>1));
		//$this->db->where("id_order", $id)->update("tbl_order", array("state"=>4));
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