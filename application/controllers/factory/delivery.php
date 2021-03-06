<?php 
class Delivery extends CI_Controller
{
	public $id_menu 	= 26;
	public $layout 		= "include/factory_template";
	public $home;
	public $view 		= "factory/delivery_view";
	public $add 			= "factory/delivery_add";
	public $edit 			= "factory/delivery_edit";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."factory/delivery";
		$this->load->model("factory/delivery_model");
	}
	
	public function index()
	{
		$row 						= $this->delivery_model->count_row();
		$config 					= pagination_config();
		$config['base_url'] 		= $this->home."/index/";
		$config['per_page'] 	= 20;
		$config['total_rows']	= $row != false? $row : $config['per_page'];	
		$rs 						= $this->delivery_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
		$data['view'] 			= $this->view;
		$data['data'] 			= $rs;
		$data['id_menu'] 		= $this->id_menu;
		$this->pagination->initialize($config);	
		$this->load->view($this->layout, $data);
	}
	
	public function add()
	{
		$data['view'] 		= $this->add;
		$data['id_menu'] 	= $this->id_menu;
		
		$this->load->view($this->layout, $data);
	}
	
	public function add_detail($id_delivery)
	{
		$rs = $this->delivery_model->get_data($id_delivery);
		$ro = $this->delivery_model->get_finished_order();
		$rd = $this->delivery_model->get_loaded_order($id_delivery);
		$data['view'] = "factory/delivery_add_detail";
		$data['page_title'] = "การจัดส่ง";
		$data['data'] = $rs;
		$data['order'] = $ro;
		$data['loaded'] = $rd;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function detail($id)
	{
		$rs 					= $this->delivery_model->get_data($id);
		$ro					= $this->delivery_model->get_loaded_order_detail($id);
		$data['view'] 		= "factory/delivery_detail";
		$data['page_title'] 	= "การจัดส่ง";
		$data['data'] 		= $rs;
		$data['order'] 		= $ro;
		$data['id_delivery']= $id;
		$data['id_menu'] 	= $this->id_menu;
		
		$this->load->view($this->layout, $data);
	}
	
	public function edit($id)
	{
		$rs 					= $this->delivery_model->get_data($id);
		$data['view'] 		= $this->edit;
		$data['page_title'] 	= "แก้ไขการจัดส่ง";
		$data['data'] 		= $rs;
		$data['id_delivery'] = $id;
		$data['id_menu'] 	= $this->id_menu;
		
		$this->load->view($this->layout, $data);
	}
	
	public function edit_detail($id)
	{
		if($this->delivery_model->is_shipped($id))
		{
			$rs = $this->delivery_model->get_data($id);
			$ro = $this->delivery_model->get_finished_order();
			$rd = $this->delivery_model->get_loaded_order($id);
			$data['view'] = "factory/delivery_edit_detail";
			$data['id_menu'] = $this->id_menu;
			$data['page_title'] = "แก้ไขการจัดส่ง";
			$data['data'] = $rs;
			$data['order'] = $ro;
			$data['loaded'] = $rd;
			$this->load->view($this->layout, $data);
		}else{
			setError("รายการนี้ถึงที่หมายแล้วไม่อนุญาติให้แก้ไข");
			$this->index();
		}
	}
	public function insert_data()
	{
		if($this->verify->validate($this->id_menu, "add"))
		{
			if($this->input->post("id_target") !=""){
				$data['reference'] 		= newDeliveryNumber();
				$data['id_shop'] 		= $this->input->post("id_shop");
				$data['id_target'] 		= $this->input->post("id_target");
				$data['id_car'] 			= $this->input->post("id_car");
				$data['id_driver'] 		= $this->input->post("id_driver");
				$data['date_add'] 		= NOW();
				
				$rs = $this->delivery_model->insert_data($data);
				if($rs){
					$id_delivery = $this->delivery_model->get_id_by_reference($data['reference']);
					redirect($this->home."/add_detail/".$id_delivery);
				}else{
					setError("เพิ่มลูกค้าไม่สำเร็จ");
					redirect($this->home);
				}
			}else{
				setError("ไม่สามารถเพิ่มข้อมูลได้ เนื่องจากไม่พบรหัสลูกค้า");
				redirect($this->home);
			}
		}else{
			action_deny();
		}
	}
	
	public function insert_detail($id_delivery, $order_no)
	{
		$id_order 				= getIdOrderByOrderNumber(trim($order_no));
		if($id_order != 0){
			$data['id_delivery'] 	= $id_delivery;
			$data['id_order'] 		= $id_order;
			$data['date_add'] 		= NOW();
			$rs = $this->delivery_model->get_finished_detail($id_order);
			if($rs != false)
			{
				foreach($rs as $ro)
				{
					$data['id_order_detail'] = $ro->id_order_detail;
					$data['id_product'] = $ro->id_product;
					$data['product_name'] = $ro->product_name;
					$data['qty'] = $ro->qty;
					$this->delivery_model->insert_detail($id_delivery, $data);
					$this->db->where("id_order_detail", $ro->id_order_detail)->update("tbl_order_detail", array("state"=>6)); // เปลี่ยนสถานะ เป็นกำลังส่ง
				}
			}
			echo $id_order;
		}else{
			echo "x";
		}
	}
	
	public function delete_detail($id_order, $id_delivery, $page)
	{
		$rs = $this->delivery_model->delete_detail($id_order, $id_delivery);
		if($rs){
			redirect($this->home."/".$page."_detail/".$id_delivery);
		}else{
			setError("ยกเลิกไม่สำเร็จ");
		}
	}
		
	public function update_data()
	{
		if($this->verify->validate($this->id_menu, "edit"))
		{
			if($this->input->post("id_delivery") != "" ){
				$id = $this->input->post("id_delivery");
				$data = array(
					"id_target"=>$this->input->post("id_target"),
					"id_car"=>$this->input->post("id_car"),
					"id_driver"=>$this->input->post("id_driver")
					);
				$rs = $this->delivery_model->update_data($id, $data);
				if($rs){
					redirect($this->home."/edit_detail/".$id);
				}else{
					setError("แก้ไขข้อมูลไม่สำเร็จ");
					redirect($this->home);
				}
			}else{
				setError("แก้ไขข้อมูลไม่สำเร็จ เนื่องจากไม่พบ ไอดีลูกค้า");
				redirect($this->home);
			}
		}else{
			action_deny();
		}
	}
	
	public function delete($id)
	{
		if($this->verify->validate($this->id_menu, "delete"))
		{
			if($this->delivery_model->is_shipped($id)){
				$rs = $this->delivery_model->get_delivery_detail($id);
				if($rs != false){
					$this->load->model("factory/order_model");
					$state = 2; //ย้อนกลับไปสถานะ รอส่ง
					foreach($rs as $order){
						$this->order_model->state_change($order->id_order, $state); // change status in order
						$this->delivery_model->delete_detail($order->id_order, $id); // deldte delivery details
					}
					$rd = $this->delivery_model->delete_delivery($id);
					if($rd){
						redirect($this->home);
					}else{
						setError("ลบรายการไม่สำเร็จ");
						redirect($this->home);
					}
				}else{
					setError("ไม่สามารถอ่านรายละเอียดการขนส่งจากฐานข้อมูลได้");
					redirect($this->home);
				}
					
			}else{
				setError("สินค้าจัดส่งแล้ว ไม่อนุญาติให้ลบรายการ");
				redirect($this->home);
			}
		}else{
			action_deny();
		}
	}
		
		
	public function find($id_shop)
	{
		if(isset($_GET['term'])){
			$q = strtolower($_GET['term']);
			$this->delivery_model->autoComplete($id_shop,$q);	
		}
	}
		
	public function confirm($id_delivery)
	{
		$state = 6; // กำลังขนส่ง
		$rs = $this->delivery_model->get_delivery_detail($id_delivery);
		if($rs != false){
			foreach($rs as $ro){
				$this->db->where("id_order", $ro->id_order)->update("tbl_order", array("state"=>$state));
				$this->db->where("id_order", $ro->id_order)->where("id_product",$ro->id_product)->where("shipped", 0)->update("tbl_finished_detail", array("shipped"=>1));
			}
			redirect($this->home);
		}else{
			setError("บันทึกไม่สำเร็จ ลองกดบันทึกอีกครั้ง");
			redirect($this->home."/add_detail/".$id_delivery);
		}
	}
	
	public function confirm_edit($id_delivery)
	{
		$state = 6; // กำลังขนส่งคืนร้าน
		$rs = $this->delivery_model->get_delivery_detail($id_delivery);
		if($rs != false)
		{
			foreach($rs as $ro)
			{
				$rd = $this->delivery_model->get_loaded_detail($id_delivery);
				if($rd != false)
				{
					foreach($rd as $re)
					{
						$this->delivery_model->change_order_detail_state($re->id_order_detail, $state);
					}
				}
				$this->delivery_model->change_order_state($ro->id_order, $state);								
			}
			redirect($this->home);
		}
		else
		{
			setError("บันทึกไม่สำเร็จ ลองกดบันทึกอีกครั้ง");
			redirect($this->home."/edit_detail/".$id_delivery);
		}
	}
	
	public function valid_code($code, $id="")
	{
		$code = urldecode($code);
		if($this->delivery_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
	
	public function print_delivery($id)
	{
		$rs 						= $this->delivery_model->get_data($id);
		$ro 						= $this->delivery_model->get_detail_data($id);
		$data['id_delivery'] 	= $id;
		$view 					= "factory/print/delivery_print";
		$data['data'] 			= $rs;
		$data['detail'] 			= $ro;
		$this->load->view($view, $data);
	}
}

?>