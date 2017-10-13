<?php 
class Profile extends CI_Controller
{
	public $id_menu = 12;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/profile_view";
	public $add_view = "admin/add_profile_view";
	public $edit_view = "admin/edit_profile_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/profile_model");
		$this->home = base_url()."admin/profile";
	}
	
	public function index()
	{
		$rs = $this->profile_model->get_data();
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
		$rs = $this->profile_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		if($this->verify->validate($this->id_menu, "delete"))
		{
			$this->profile_model->delete($id);
			redirect($this->home);
		}
		else
		{
			action_deny($this->layout);
		}
	}
	
	public function insert_data()
	{
		if($this->input->post("profile_name") !=="")
		{
			$data = array(
				"profile_name"=>$this->input->post("profile_name"),
				"date_add"=>date("Y-m-d H:i:s")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->profile_model->add($data);
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
		if($this->input->post("id_profile") !=="")
		{
			$id = $this->input->post("id_profile");
			$data = array(
				"profile_name"=>$this->input->post("profile_name")	
			);	
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->profile_model->edit($data, $id);
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
		if($this->profile_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
		
}

?>