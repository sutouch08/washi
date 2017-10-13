<?php 
class Type extends CI_Controller
{
	public $id_menu = 4;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/type_view";
	public $add_view = "admin/add_type_view";
	public $edit_view = "admin/edit_type_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/type_model");
		$this->home = base_url()."admin/type";
	}
	
	public function index()
	{
		$rs = $this->type_model->get_data();
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
		$rs = $this->type_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		
		if($this->verify->validate($this->id_menu, "delete"))
		{
			if($this->type_model->valid_transection($id))
			{
					$this->type_model->delete($id);
					redirect($this->home);
				}
				else
				{
					setError("ไม่สามารถลบรายการได้ เนื่องจากมีการอ้างอิงจากสินค้าอยู่");
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
		if($this->input->post("type_name") !=="")
		{
			$data = array(
				"type_name"=>$this->input->post("type_name"),
				"date_add"=>date("Y-m-d H:i:s")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->type_model->add($data);
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
		if($this->input->post("id_type") !=="")
		{
			$id = $this->input->post("id_type");
			$data = array(
				"type_name"=>$this->input->post("type_name")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->type_model->edit($data, $id);
			if($action)
			{
				redirect($this->home);
			}else{
				setError("แก้ไขข้อมูลไม่สำเร็จข้อมูลไม่สำเร็จ");
				redirect($this->home);
			}
		}else{
			action_deny($this->layout);
		}
	}
	
	public function valid_code($code, $id="")
	{
		$code = urldecode($code);
		if($this->type_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
		
}

?>