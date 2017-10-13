<?php 
class Delivery extends CI_Controller
{
	public $id_menu 	= 21;
	public $layout 		= "include/shop_template";
	public $home;
	public $view 		= "shop/delivery_view";
	public $add 			= "shop/delivery_add";
	public $edit 			= "shop/delivery_edit";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."shop/delivery";
		$this->load->model("shop/delivery_model");
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
	
	public function add_detail($id)
	{
		$rs = $this->delivery_model->get_data($id);
		$ro = $this->delivery_model->get_detail($id);
		$rd = $this->delivery_model->get_loaded_order($id);
		$data['view'] = "shop/delivery_add_detail";
		$data['page_title'] = "การจัดส่ง";
		$data['data'] = $rs;
		$data['order'] = $ro;
		$data['loaded'] = $rd;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function detail($id_delivery)
	{
		$rs 					= $this->delivery_model->get_data($id_delivery);
		$ro					= $this->delivery_model->get_delivery_detail_data($id_delivery);
		$data['view'] 		= "shop/delivery_detail";
		$data['page_title'] 	= "การจัดส่ง";
		$data['data'] 		= $rs;
		$data['order'] 		= $ro;
		$data['id_delivery']= $id_delivery;
		$data['id_menu'] 	= $this->id_menu;
		
		$this->load->view($this->layout, $data);
	}
	
	public function edit($id)
	{
		$rs 					= $this->delivery_model->get_data($id);
		$data['view'] 		= $this->edit;
		$data['page_title'] 	= "แก้ไขการจัดส่ง";
		$data['data'] 		= $rs;
		$data['id_menu'] 	= $this->id_menu;
		
		$this->load->view($this->layout, $data);
	}
	
	public function edit_detail($id)
	{
		$rs = $this->delivery_model->get_data($id);
		$ro = $this->delivery_model->get_detail($id);
		$rd = $this->delivery_model->get_loaded_order($id);
		$data['view'] = "shop/delivery_edit_detail";
		$data['id_menu'] = $this->id_menu;
		$data['page_title'] = "แก้ไขการจัดส่ง";
		$data['data'] = $rs;
		$data['order'] = $ro;
		$data['loaded'] = $rd;
		$this->load->view($this->layout, $data);
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
			$rs = $this->delivery_model->get_order_detail($id_order);
			if($rs != false)
			{
				foreach($rs as $ro)
				{
					$data['id_order_detail'] = $ro->id_order_detail;
					$data['id_product'] = $ro->id_product;
					$data['product_name'] = $ro->product_name;
					$data['qty'] = $ro->qty;
					$this->delivery_model->insert_detail($id_delivery, $data);
				}
				echo $id_order;
			}else{
				echo "x";
			}			
		}else{
			echo "x";
		}
	}
	
	public function delete_detail($id_order, $id_delivery, $page)
	{
		$rs = $this->delivery_model->delete_detail($id_order, $id_delivery);
		if($rs){
			$this->load->model("shop/order_model");
			$this->order_model->state_change($id_order, 2);
			if($page == "edit"){ 
				$ro = $this->delivery_model->insert_to_temp($id_order, $id_delivery);
			}
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
					$this->load->model("shop/order_model");
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
		$state = 3; // กำลังขนส่ง
		$rs = $this->delivery_model->get_delivery_detail($id_delivery);
		if($rs != false){
			$this->load->model("shop/order_model");
			foreach($rs as $ro){
				$this->order_model->state_change($ro->id_order, $state);
			}
			redirect($this->home);
		}else{
			setError("บันทึกไม่สำเร็จ ลองกดบันทึกอีกครั้ง");
			redirect($this->home."/add_detail/".$id_delivery);
		}
	}
	
	public function confirm_edit($id_delivery)
	{
		
		$state = 3; // กำลังขนส่ง
		$rs = $this->delivery_model->get_delivery_detail($id_delivery);
		if($rs != false){
			$this->load->model("shop/order_model");
			foreach($rs as $ro){
				$this->order_model->state_change($ro->id_order, $state);
			}
			redirect($this->home);
		}else{
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
		$view 					= "shop/print/delivery_print";
		$data['data'] 			= $rs;
		$data['detail'] 			= $ro;
		$this->load->view($view, $data);
	}
}

?>