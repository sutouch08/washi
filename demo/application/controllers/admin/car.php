<?php 
class Car extends CI_Controller
{
	public $id_menu = 14;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/car_view";
	public $add_view = "admin/add_car_view";
	public $edit_view = "admin/edit_car_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/car_model");
		$this->home = base_url()."admin/car";
	}
	
	public function index()
	{
		$rs = $this->car_model->get_data();
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
		$rs = $this->car_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		if($this->verify->validate($this->id_menu, "delete"))
		{
			if($this->car_model->valid_transection($id))
			{
				$this->car_model->delete($id);
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
		if($this->input->post("car_plate") !=="")
		{
			$data = array(
				"car_plate"=>$this->input->post("car_plate"),
				"car_brand"=>$this->input->post("car_brand"),
				"capacity"=>$this->input->post("capacity")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->car_model->add($data);
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
		if($this->input->post("id_car") !=="")
		{
			$id = $this->input->post("id_car");
			$data = array(
				"car_plate"=>$this->input->post("car_plate"),
				"car_brand"=>$this->input->post("car_brand"),
				"capacity"=>$this->input->post("capacity")
			);	
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->car_model->edit($data, $id);
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
		if($this->car_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
		
}

?>