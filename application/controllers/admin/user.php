<?php 
class User extends CI_Controller
{
	public $id_menu = 11;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/user_view";
	public $add_view = "admin/add_user_view";
	public $edit_view = "admin/edit_user_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/user_model");
		$this->home = base_url()."admin/user";
	}
	
	public function index()
	{
		$rs = $this->user_model->get_data();
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
		$rs = $this->user_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		if($this->verify->validate($this->id_menu, "delete"))
		{
			$this->user_model->delete($id);
			redirect($this->home);
		}
		else
		{
			action_deny($this->layout);
		}
	}
	
	public function insert_data()
	{
		if($this->input->post("user_name") !=="")
		{
			$data['id_employee'] 		= $this->input->post("id_employee");
			$data['user_name'] 		= $this->input->post("user_name");
			$data['password']			= md5($this->input->post("password"));
			$data['id_profile'] 			= $this->input->post("id_profile");
			$data['id_shop']				= $this->input->post("id_shop");
			$data['show_all']			= $this->input->post("show_all");
			$data['active']				= $this->input->post("active");
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->user_model->add($data);
			if($action)
			{
				redirect($this->home);
			}else{
				$this->session->set_flashdata("error", "เพิ่มข้อมูลไม่สำเร็จ");
				redirect($this->home);
			}
		}else{
			action_deny($this->layout);
		}
	}
	
	public function  update_data()
	{
		if($this->input->post("id_user") !=="")
		{
			$id 							= $this->input->post("id_user");
			$data['id_employee'] 		= $this->input->post("id_employee");
			$data['user_name'] 		= $this->input->post("user_name");
			$data['id_profile'] 			= $this->input->post("id_profile");
			$data['id_shop']				= $this->input->post("id_shop");
			$data['show_all']			= $this->input->post("show_all");
			$data['active']				= $this->input->post("active");
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->user_model->edit($data, $id);
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
		if($this->user_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
	
	public function reset_password($id)
	{
		$rs = $this->user_model->get_data($id);
		$data['view'] = "admin/reset_password";
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	public function change_password()
	{
		if($this->input->post("id_user") != "")
		{
			$id = $this->input->post("id_user");
			$data['password'] = md5($this->input->post("password"));
			if($this->user_model->edit($data, $id))
			{
				redirect($this->home);
			}
			else
			{
				setError("เปลี่ยนรหัสผ่านไม่สำเร็จ");
				redirect($this->home);
			}
		}
	}
	
}

?>