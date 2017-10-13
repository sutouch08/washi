<?php 
class Employee extends CI_Controller
{
	public $id_menu = 9;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/employee_view";
	public $add_view = "admin/add_employee_view";
	public $edit_view = "admin/edit_employee_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/employee_model");
		$this->home = base_url()."admin/employee";
	}
	
	public function index()
	{
		$rs = $this->employee_model->get_data();
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
		$rs = $this->employee_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		if($this->employee_model->valid_transection($id))
		{
			$this->employee_model->delete($id);
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
		if($this->input->post("employee_code") !="")
		{
			$data = array(
				"employee_code"=>$this->input->post("employee_code"),
				"first_name"=>$this->input->post("first_name"),
				"last_name"=>$this->input->post("last_name"),
				"phone"=>$this->input->post("phone"),
				"id_shop"=>$this->input->post("shop")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->employee_model->add($data);
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
		if($this->input->post("id_employee") !=="")
		{
			$id = $this->input->post("id_employee");
			$data = array(
				"employee_code"=>$this->input->post("employee_code"),
				"first_name"=>$this->input->post("first_name"),
				"last_name"=>$this->input->post("last_name"),
				"phone"=>$this->input->post("phone"),
				"id_shop"=>$this->input->post("shop")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->employee_model->edit($data, $id);
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
		if($this->employee_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
		
}

?>