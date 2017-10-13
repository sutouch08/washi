<?php
class Authentication extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->view("login");
	}
	
	public function validate_credentials()
	{
		$this->load->model("login_model");
		$rs = $this->login_model->validate();
		if($rs)
		{
			$ro = $this->login_model->get_profile($rs->id_user);
			$data = array(
				"id_user"=>$rs->id_user,
				"id_employee"=>$rs->id_employee,
				"user_name"=>$rs->user_name,
				"id_profile"=>$ro->id_profile,
				"id_shop"=>$rs->id_shop,
				"show_all"=>$ro->show_all
			);
			$this->session->set_userdata($data);
			redirect(base_url());
		}else{
			setError("ชื่อผู้ใช้งานผิด หรือ รหัสผ่านผิด หรือ คุณถูกระงับการใช้งาน");
			redirect(base_url());
		}
	}
	
	public function logout()
	{
		$data = array(
				"id_user"=>'',
				"id_employee"=>'',
				"user_name"=>'',
				"id_profile"=>'',
				"id_shop"=>"",
				"show_all"=>''
			);
		$this->session->unset_userdata($data);
		redirect("","refresh");	
	}
	
}

?>