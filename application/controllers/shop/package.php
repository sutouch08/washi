<?php 
class Package extends CI_Controller
{
	public $id_menu = 20;
	public $layout = "include/shop_template";
	public $home;
	public $view = "shop/package_view";
	public $add = "shop/package_add";
	public $edit = "shop/package_edit";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."shop/package";
		$this->load->model("shop/package_model");
	}
	
	public function index()
	{
		$row 						= $this->package_model->count_row();
		$config 					= pagination_config();
		$config['base_url'] 		= $this->home."/index/";
		$config['per_page'] 	= 20;
		$config['total_rows'] 	= $row !=false? $row : 200;
		$rs 						= $this->package_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
		$data['view'] 			= $this->view;
		$data['data'] 			= $rs;
		$data['id_menu'] 		= $this->id_menu;
		$this->pagination->initialize($config);
		$this->load->view($this->layout, $data);
	}
	
	public function add($id_promotion)
	{
		$rs 					= $this->package_model->get_data($id_promotion);
		$data['view'] 		= $this->add;
		$data['data'] 		= $rs;
		$data['id_menu'] 	= $this->id_menu;
		$this->load->view($this->layout, $data);	
	}
	public function add_package()
	{
		if($this->input->post("id_customer") !=""){	
			$data = array(
				"id_customer"=>$this->input->post("id_customer"),
				"id_promotion"=>$this->input->post("id_promotion"),
				"start"=>$this->input->post("start"),
				"end"=>$this->input->post("end"),
				"duration"=>$this->input->post("duration"),
				"credit"=>$this->input->post("credit_add"),
				"id_credit_type"=>$this->input->post("id_credit_type"),
				"active"=>1,
				"date_add"=>NOW()
			);	
			$price 			= $this->input->post("price");
			$qty 				= $this->input->post("qty");
			$amount 			= $price*$qty;
			$package_log 	= array(
				"id_customer"=>$this->input->post("id_customer"),
				"id_shop"=>$this->session->userdata("id_shop"),
				"id_user"=>$this->session->userdata("id_user"),
				"id_employee"=>$this->session->userdata("id_employee"),
				"id_promotion"=>$this->input->post("id_promotion"),
				"promotion_name"=>getPromotionName($this->input->post("id_promotion")),
				"price"=>$this->input->post("price"),
				"qty"=>$this->input->post("qty"),
				"amount"=>$amount
			);
			
			$payment = array(
				"id_shop"=>$this->session->userdata("id_shop"),
				"id_employee"=>$this->session->userdata("id_employee"),
				"id_user"=>$this->session->userdata("id_user"),
				"id_customer"=>$this->input->post("id_customer"),
				"id_order"=>0,
				"order_no"=>"",
				"order_amount"=>$this->input->post("total"),
				"id_promotion"=>$this->input->post("id_promotion"),
				"discount_amount"=>0.00,
				"final_amount"=>$this->input->post("total"),
				"deposit"=>0.00,
				"received"=>$this->input->post("receive"),
				"change"=>$this->input->post("change"),
				"balance"=>0.00
				);
		}
			
		$datax = $this->package_model->check_data($this->input->post("id_customer"), $this->input->post("id_promotion"));
		if($datax != false) // ถ้า true แสดงว่ามีอยู่แล้ว ให้ update
		{
			if($datax->duration ==0)
			{
				$new = $data['credit'] + $datax->credit;
				$data['credit'] = $new;
			}
			else
			{
				$d = date("Y-m-d", strtotime(NOW()));
				$da = date("Y-m-d",strtotime($datax->date_add));
				$du = $datax->duration;
				$valid = date("Y-m-d", strtotime("+$du days $da"));
				if($valid >= $d)
				{
					$data['date_add'] = $datax->date_add;
					$new = $data['credit'] + $datax->credit;
					$data['credit'] = $new;
				}		
			}
			$rs = $this->package_model->update_data($this->input->post("id_customer"), $this->input->post("id_promotion"), $data);
			if($rs)
			{
				$this->load->model("shop/payment_model");
				$this->payment_model->add($payment);
				$this->package_model->add_log($package_log);
				redirect($this->home);
			}
			else
			{
				setError("Update incomplete");
				redirect($this->home);
			}
		}
		else // ถ้า false แสดงว่าไม่มีในฐานข้อมูล ให้ insert
		{	
			$rs = $this->package_model->insert_data($data);
			if($rs)
			{
				$this->load->model("shop/payment_model");
				$this->payment_model->add($payment);
				$this->package_model->add_log($package_log);
				redirect($this->home);
			}
			else
			{
				setError("เพิ่มข้อมูลไม่สำเร็จ");
				redirect($this->home);
			}
		}
	}
	
	public function package_print($id)
	{
		
	}
	
	
}

?>