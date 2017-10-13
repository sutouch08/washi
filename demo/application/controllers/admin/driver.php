<?php 
class Driver extends CI_Controller
{
	public $id_menu = 15;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/driver_view";
	public $add_view = "admin/add_driver_view";
	public $edit_view = "admin/edit_driver_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/driver_model");
		$this->home = base_url()."admin/driver";
	}
	
	public function index()
	{
		$rs = $this->driver_model->get_data();
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
		$rs = $this->driver_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		if($this->verify->validate($this->id_menu, "delete"))
		{
			if($this->driver_model->valid_transection($id))
			{
				$this->driver_model->delete($id);
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
		if($this->input->post("id_employee") !=="")
		{
			$data = array(
				"id_employee"=>$this->input->post("id_employee"),
				"id_car"=>$this->input->post("id_car"),
				"active"=>$this->input->post("active")	
			);	
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->driver_model->add($data);
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
		if($this->input->post("id_driver") !=="")
		{
			$id = $this->input->post("id_driver");
			$data = array(
				"id_employee"=>$this->input->post("id_employee"),
				"id_car"=>$this->input->post("id_car"),
				"active"=>$this->input->post("active")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->driver_model->edit($data, $id);
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
		if($this->driver_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
		
}

?>