<?php 
class Customer extends CI_Controller
{
	public $id_menu 	= 5;
	public $layout 		= "include/admin_template";
	public $home;
	public $view 		= "admin/customer_view";
	public $add 			= "admin/customer_add";
	public $edit 			= "admin/customer_edit";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."admin/customer";
		$this->load->model("admin/customer_model");
	}
	
	public function index()
	{
		$row = $this->customer_model->count_row();
		$config 					= pagination_config();
		$config['base_url'] 		= $this->home."/index/";
		$config['per_page'] 	= 10;
		$config['total_rows'] 	=  $row != false ? $row : 200;
		$rs 						= $this->customer_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
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
	
	public function detail($id)
	{
		$rs 					= $this->customer_model->get_data($id);
		$data['view'] 		= "admin/customer_detail";
		$data['page_title'] 	= "ลูกค้า";
		$data['data'] 		= $rs;
		$data['id_menu'] 	= $this->id_menu;
		
		$this->load->view($this->layout, $data);
	}
	
	public function edit($id)
	{
		$rs 					= $this->customer_model->get_data($id);
		$data['view'] 		= $this->edit;
		$data['page_title'] 	= "ลูกค้า";
		$data['data'] 		= $rs;
		$data['id_menu'] 	= $this->id_menu;
		
		$this->load->view($this->layout, $data);
	}
	
	public function insert_data()
	{
		if($this->verify->validate($this->id_menu, "add"))
		{
			if($this->input->post("customer_code") !=""){
				$data['customer_code'] 	= $this->input->post("customer_code");
				$data['customer_name'] 	= $this->input->post("customer_name");
				$data['gender'] 				= $this->input->post("gender");
				$data['id_shop'] 			= $this->session->userdata("id_shop");
				$data['email'] 				= $this->input->post("email");
				$data['address'] 			= $this->input->post("address");
				$data['phone'] 				= $this->input->post("phone");
				$data['date_add'] 			= NOW();
				
				$rs = $this->customer_model->insert_data($data);
				if($rs){
					redirect($this->home);
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
	
	public function update_data()
	{
		if($this->verify->valid_date($this->id_menu, "edit"))
		{
			if($this->input->post("id_customer") != "" ){
				$id = $this->input->post("id_customer");
				$data['customer_code'] 	= $this->input->post("customer_code");
				$data['customer_name'] 	= $this->input->post("customer_name");
				$data['gender'] 				= $this->input->post("gender");
				$data['id_shop'] 			= $this->session->userdata("id_shop");
				$data['email'] 				= $this->input->post("email");
				$data['address'] 			= $this->input->post("address");
				$data['phone'] 				= $this->input->post("phone");
				
				$rs = $this->customer_model->update_data($id, $data);
				if($rs){
					redirect($this->home);
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
			if($this->customer_model->valid_transection($id)){
				$rs = $this->customer_model->delete_data($id);
				if($rs){
					redirect($this->home);
				}else{
					setError("ลบลูกค้าไม่สำเร็จ");
					redirect($this->home);
				}
			}else{
				setError("ไม่สามารถลบลูกค้าได้เนื่องจากมี transection ในระบบแล้ว");
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
			$this->customer_model->autoComplete($id_shop,$q);	
		}
	}
		
	
	
	public function valid_code($code, $id="")
	{
		$code = urldecode($code);
		if($this->customer_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
	
}

?>