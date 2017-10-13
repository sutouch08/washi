<?php 
class Permission extends CI_Controller
{
	public $id_menu = 1;
	public $home;
	public $layout = "include/admin_template";
	public $view = "admin/permission";
	
	public function __construct()
	{
		parent:: __construct();
		$this->home = base_url()."admin/permission";
		$this->load->model("admin/permission_model");
	}
	
	public function index()
	{
		$profile = $this->permission_model->get_profile();
		$data['id_menu'] = $this->id_menu;
		$data['view'] = $this->view;
		$data['profile'] = $profile;
		$this->load->view($this->layout, $data);		
	}
	
	public function update($id_profile)
	{
		if($this->input->post("id_access") !="")
		{
			$access = $this->input->post("id_access");
			$view = $this->input->post("view");
			$add = $this->input->post("add");
			$edit = $this->input->post("edit");
			$delete = $this->input->post("delete");
			foreach($access as $ac)
			{
				if(isset($view[$ac])){ $viewx = 1;	 }else{ $viewx = 0; }
				if(isset($add[$ac])){ $addx = 1; }else{ $addx = 0; }
				if(isset($edit[$ac])){ $editx = 1; }else{ $editx = 0; }
				if(isset($delete[$ac])){ $deletex = 1; }else{ $deletex = 0; }
				$data = array(
							"view"=>$viewx, 
							"add"=>$addx, 
							"edit"=>$editx, 
							"delete"=>$deletex
					);
				$this->permission_model->update($ac, $data)	;
			}
			$this->index();
		}
	}
	
}// end class

?>