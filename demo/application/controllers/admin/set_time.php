<?php
class Set_time extends CI_Controller
{
	public $id_menu = 10;
	public $home;
	public $layout = "include/admin_template";
	public $view = "admin/time_table";
	public function __construct()
	{
		parent:: __construct();
		$this->load->model("admin/set_time_model");
		$this->home = base_url()."admin/set_time";
	}
	
	public function index()
	{
		$rs = $this->set_time_model->get_data();
		$data['id_menu'] = $this->id_menu;
		$data['view'] = $this->view;
		$data['data'] = $rs;
		$this->load->view($this->layout, $data);
	}
	
	public function add()
	{
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "admin/time_add";
		$this->load->view($this->layout, $data);
	}
	
	public function edit($id)
	{
		$rs = $this->set_time_model->get_data($id);
		$data['id_menu'] = $this->id_menu;
		$data['view'] = "admin/edit_time_table";
		$data['data'] = $rs;
		$this->load->view($this->layout, $data);
	}
	
	public function set_table()
	{
		if($this->verify->validate($this->id_menu, "add"))
		{
			if($this->input->post("name") !="")
			{
				$data['name'] = $this->input->post("name");
				$data['start'] = $this->input->post("start");
				$data['end'] = $this->input->post("end");
				$rs = $this->db->insert("tbl_time_table", $data);
				if($rs)
				{
					redirect($this->home);
				}
				else
				{
					setError("เพิ่มช่วงเวลาไม่สำเร็จ");
					redirect($this->home);
				}
			}
			else
			{
				setError("Can not retrive post data");
					redirect($this->home);
			}
		}
		else
		{
			action_deny();
		}
	}
	
	public function update_table($id)
	{
		if($this->verify->validate($this->id_menu, "edit"))
		{
			if($this->input->post("start") !="")
			{
				$data['name'] = $this->input->post("name");
				$data['start'] = $this->input->post("start");
				$data['end'] = $this->input->post("end");	
				$rs = $this->set_time_model->update($id, $data);
				if($rs)
				{
					redirect($this->home);
				}else{
					setError("แก้ไขข้อมูลไม่สำเร็จ");
					redirect($this->home);
				}
			}else{
					setError("Can not retrive post data");
					redirect($this->home);
				}
		}else{
			action_deny();
		}
	}
	
	public function delete($id)
	{
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$rs = $this->set_time_model->delete($id);
			if($rs)
			{
				redirect($this->home);
			}else{
				setError("ลบรายการไม่สำเร็จ");
				redirect($this->home);
			}
		}else{
			action_deny();
		}
	}
		
}
?>