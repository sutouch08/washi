<?php 
class Product extends CI_Controller
{
	public $id_menu = 2;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/product_view";
	public $add_view = "admin/add_product_view";
	public $edit_view = "admin/edit_product_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/product_model");
		$this->home = base_url()."admin/product";
	}
	
	public function index()
	{
		$row = $this->product_model->count_row();
		$config = pagination_config();
		$config['base_url'] = $this->home."/index/";
		$config['per_page'] = 10;
		$config['total_rows'] =  $row != false ? $row : 200;
		$this->pagination->initialize($config);
		$rs = $this->product_model->get_data("", $config['per_page'], $this->uri->segment(4));
		$data['view'] = $this->view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function add()
	{
		$data['view'] = $this->add_view;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);	
	}
	
	public function edit($id)
	{
		$rs = $this->product_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		if($this->verify->validate($this->id_menu, "delete"))
		{
			if($this->product_model->valid_transection($id))
			{
				$this->product_model->delete($id);
				redirect($this->home);
			}
			else
			{
				setError("ไม่สามารถลบรายการได้ เนื่องจากมีทรานเซ็คชั่นในระบบแล้ว");
				redirect($this->home);
			}
		}
		else
		{
			action_deny($this->layout);
		}
	}
	
	public function insert_data()
	{
		if($this->input->post("product_name") !=="")
		{
			$data = array(
				"product_name"=>$this->input->post("product_name"),
				"price"=>$this->input->post("price"),
				"id_category"=>$this->input->post("id_category"),
				"id_type"=>$this->input->post("id_type"),
				"weight"=>$this->input->post("weight")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->product_model->add($data);
			if($action)
			{
				redirect($this->home);
			}else{
				setError("เพิ่มข้อมูลไม่สำเร็จ");
				redirect($this->home);
			}
		}else{
			action_deny($this->layout);
		}
	}
	
	public function  update_data()
	{
		if($this->input->post("id_product") !=="")
		{
			$id = $this->input->post("id_product");
			$data = array(
				"product_name"=>$this->input->post("product_name"),
				"price"=>$this->input->post("price"),
				"id_category"=>$this->input->post("id_category"),
				"id_type"=>$this->input->post("id_type"),
				"weight"=>$this->input->post("weight")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->product_model->edit($data, $id);
			if($action)
			{
				redirect($this->home);
			}else{
				$this->session->set_flashdata("error", "แก้ไขข้อมูลไม่สำเร็จข้อมูลไม่สำเร็จ");
				redirect($this->home);
			}
		}else{
			action_deny($this->layout);
		}
	}
	
	public function valid_code($code, $id="")
	{
		$code = urldecode($code);
		if($this->product_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
		
}

?>