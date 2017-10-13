<?php
class Shop extends CI_Controller
{
	public $id_menu = 8;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/shop_view";
	public $add_view = "admin/add_shop_view";
	public $edit_view = "admin/edit_shop_view";
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/shop_model");
		$this->home = base_url()."admin/shop";
	}
	
	public function index()
	{
		$rs = $this->shop_model->get_data();
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
		$rs = $this->shop_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		if($this->shop_model->valid_transection($id))
		{
			$this->shop_model->delete($id);
			redirect($this->home);
		}
		else
		{
			$this->session->set_flashdata("error", "ไม่สามารถลบรายการได้ เนื่องจากมีทรานเซ็คชั่นในระบบแล้ว");
			redirect($this->home);
		}
	}
	
	public function insert_data()
	{
		if($this->input->post("shop_code") !=="")
		{
			$data = array(
				"shop_code"=>$this->input->post("shop_code"),
				"shop_name"=>$this->input->post("shop_name"),
				"shop_address"=>$this->input->post("shop_address"),
				"shop_phone"=>$this->input->post("shop_phone")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->shop_model->add($data);
			if($action)
			{
				redirect($this->home);
			}else{
				$this->session->set_flashdata("error", "เพิ่มข้อมูลไม่สำเร็จ");
				redirect($this->home);
			}
		}else{
			action_deny();
		}
	}
	
	public function  update_data()
	{
		if($this->input->post("shop_code") !=="")
		{
			$id = $this->input->post("id_shop");
			$data = array(
				"shop_code"=>$this->input->post("shop_code"),
				"shop_name"=>$this->input->post("shop_name"),
				"shop_address"=>$this->input->post("shop_address"),
				"shop_phone"=>$this->input->post("shop_phone")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->shop_model->edit($data, $id);
			if($action)
			{
				redirect($this->home);
			}else{
				$this->session->set_flashdata("error", "แก้ไขข้อมูลไม่สำเร็จข้อมูลไม่สำเร็จ");
				redirect($this->home);
			}
		}else{
			action_deny();
		}
	}
	
	public function valid_code($code, $id="")
	{
		$code = urldecode($code);
		if($this->shop_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
	
	public function valid_name($name, $id="")
	{
		$name = urldecode($name);
		if($this->shop_model->valid_name($name, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
	
}
?>