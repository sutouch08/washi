<?php 
class Promotion extends CI_Controller
{
	public $id_menu = 7;
	public $layout = "include/admin_template";
	public $home;
	public $view = "admin/promotion_view";
	public $add_view = "admin/add_promotion_view";
	public $edit_view = "admin/edit_promotion_view";
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("admin/promotion_model");
		$this->home = base_url()."admin/promotion";
	}
	
	public function index()
	{
		$rs = $this->promotion_model->get_data();
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
		$rs = $this->promotion_model->get_data($id);
		$data['view'] = $this->edit_view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete($id)
	{
		if($this->verify->validate($this->id_menu, "delete"))
		{
			if($this->promotion_model->valid_transection($id))
			{
				$this->promotion_model->delete($id);
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
		if($this->input->post("promotion_name") !=="")
		{
			$data['promotion_name'] = $this->input->post("promotion_name");
			$data['id_shop'] 			= $this->input->post("id_shop");
			$data['start'] 				= dbShortDate($this->input->post("start"));
			$data['end'] 					= dbShortDate($this->input->post("end"));
			$data['duration'] 			= $this->input->post("duration");
			$data['pcs'] 					= $this->input->post("unit") ==1? $this->input->post("num") : 0;
			$data['amount'] 				= $this->input->post("unit") ==2? $this->input->post("num") : 0;
			$data['discount'] 			= $this->input->post("unit") ==3? $this->input->post("num") : 0;
			$data['price'] 				= $this->input->post("price");
			$data['date_add'] 			= date("Y-m-d H:I:s");
			$data['active'] 				= $this->input->post("active");
		}
			
		if($this->verify->validate($this->id_menu, "add"))
		{
			$action = $this->promotion_model->add($data);
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
		if($this->input->post("id_promotion") !=="")
		{
			$id = $this->input->post("id_promotion");
			$data['promotion_name'] = $this->input->post("promotion_name");
			$data['id_shop'] 			= $this->input->post("id_shop");
			$data['start'] 				= dbShortDate($this->input->post("start"));
			$data['end'] 					= dbShortDate($this->input->post("end"));
			$data['duration'] 			= $this->input->post("duration");
			$data['pcs'] 					= $this->input->post("unit") ==1? $this->input->post("num") : 0;
			$data['amount'] 				= $this->input->post("unit") ==2? $this->input->post("num") : 0;
			$data['discount'] 			= $this->input->post("unit") ==3? $this->input->post("num") : 0;
			$data['price'] 				= $this->input->post("price");
			$data['date_add'] 			= date("Y-m-d H:I:s");
			$data['active'] 				= $this->input->post("active");
		}
			
		if($this->verify->validate($this->id_menu, "edit"))
		{
			$action = $this->promotion_model->edit($data, $id);
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
		if($this->promotion_model->valid_code($code, $id))
		{
			echo "0";
		}else{
			echo "1";
		}
	}
		
}

?>