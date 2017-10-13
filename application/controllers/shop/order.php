<?php 
class Order extends CI_Controller
{
	public $id_menu = 18;
	public $layout = "include/shop_template";
	public $home;
	public $view = "shop/order_view";
	public $add = "shop/order_add";
	public $edit = "shop/order_edit";
	
	public function __construct()
	{
		parent::__construct();
		$this->home = base_url()."shop/order";
		$this->load->model("shop/order_model");
	}
	
	public function index()
	{
		$row = $this->order_model->count_row();
		$config = pagination_config();
		$config['base_url'] = $this->home."/index";
		$config['total_rows'] = $row != false? $row : 0;
		$config['per_page'] = 20;
		$this->pagination->initialize($config);
		$rs = $this->order_model->get_data("", $config['per_page'], $this->uri->segment($config['uri_segment']));
		$data['view'] = $this->view;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function delete()
	{
		$rs = $this->order_model->get_data();
		$data['view'] = "shop/order_delete_view";
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
		
	}
	public function delete_order($id_order)
	{
		$this->load->model("shop/payment_model");
		$dp = $this->payment_model->delete_payment($id_order);
		if($dp){
			$dt = $this->order_model->delete_detail($id_order);
			if($dt){
				$do = $this->order_model->delete_order($id_order);
				if(!$do){
					setError("ลบออเดอร์ไม่สำเร็จ");
				}
			}else{
				setError("ลบรายการไม่สำเร็จ");
			}
		}else{
			setError("ไม่สามารถลบออเดอร์ได้ เนื่องจากลบข้อมูลการชำระเงินไม่สำเร็จ");
		}
		redirect($this->home."/delete");
	}
		
	public function detail($id)
	{
		$ro = $this->order_model->get_data($id);
		$rs = $this->order_model->get_detail($id);
		$data['view'] = "shop/order_detail";
		$data['id_order'] = $id;
		$data['order'] = $ro;
		$data['data'] = $rs;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	public function order_sheet($id_category)
	{
		$rs = $this->order_model->get_product_by_category($id_category);
		if($rs)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}
	public function add()
	{
		$data['view'] = $this->add;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	
	public function add_order()
	{
		if($this->input->post("id_customer") !="")
		{
			$order_no = getOrderId();
			$id_customer = $this->input->post("id_customer");
			$data = array(
				"order_no"=>$order_no,
				"id_customer"=>$this->input->post("id_customer"),
				"id_shipping"=>$this->input->post("id_shipping"),
				"id_employee"=>$this->input->post("id_employee"),
				"id_shop"=>$this->input->post("id_shop"),
				"id_urgent"=>$this->input->post("id_urgent"),
				"remark"=>$this->input->post("remark"),
				"order_date"=>NOW(),
				"due_date"=>dbDate($this->input->post("due_date")),
				"state"=>1,
				"valid"=>0
			);
			$products = $this->input->post("id_product");
			$qtys = $this->input->post("qty");
			$price = $this->input->post("price");
			
		}
			if($this->verify->validate($this->id_menu, "add"))
			{
				$action = $this->order_model->add($data);
				$charge_rate = getUrgentCharg($this->input->post("id_urgent"))/100;
				if($action != false)
				{	
					$id_order = $action;	
					
					foreach($qtys as $n=>$qty)
					{
						if($qty !="")
						{
							$datail['id_order'] 			= $id_order;
							$datail['id_product'] 		= $products[$n];
							$datail['product_name'] 	= getProductName($products[$n]);
							$datail['qty'] 					= $qty;
							$datail['price'] 				= $price[$n];
							$total 							= $qty*$price[$n];
							$charge_up 				= $total*$charge_rate;
							$datail['charge_up'] 		= $charge_up;
							$datail['total_amount'] 		= $total+$charge_up;
							$datail['date_add'] 			= NOW();
							$this->order_model->insert_detail($datail);
						}	
					}
					redirect(base_url()."shop/order/payment/".$id_order."/".$id_customer);
				}
				else
				{
					setError("เพิ่มออเดอร์ไม่สำเร็จ");
					redirect($this->home);
				}
			}
			else
			{
				action_deny();
			}
	}

	public function get_category()
	{
		$rs = $this->order_model->get_category();
		if($rs)
		{
			return $rs;
		}
		else
		{
			return false;
		}
	}
	
	public function state_change($id_order, $id_state)
	{
		$this->order_model->state_change($id_order, $id_state);
		redirect(base_url()."shop/order/detail/".$id_order);
	}
		
	public function print_order($id_order)
	{
		$rs = $this->order_model->get_data($id_order);
		$ro = $this->order_model->get_detail($id_order);
		$pd = $this->order_model->get_payment($id_order);
		$data['head'] = $rs;
		$data['item'] = $ro;
		$data['payment'] = $pd;
		$this->load->view("shop/print/order_print", $data);
	}	
	
	public function print_order_repay($id_order)
	{
		$rs = $this->order_model->get_data($id_order);
		$ro = $this->order_model->get_detail($id_order);
		$pd = $this->order_model->get_balance_payment($id_order);
		$data['head'] = $rs;
		$data['item'] = $ro;
		$data['payment'] = $pd;
		$this->load->view("shop/print/order_repay_print", $data);
	}	
	
	public function payment($id_order, $id_customer)
	{
		$rx = $this->order_model->get_data($id_order);
		$rs = $this->order_model->get_detail($id_order);
		$ro = $this->order_model->get_credit($id_customer);
		$data['view'] = "shop/order_payment";
		$data['items'] = $rs;
		$data['order'] =$rx;
		$data['package'] = $ro;
		$data['id_order'] = $id_order;
		$data['id_customer'] = $id_customer;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
	}
	public function repay($id_order, $id_customer)
	{
		$rx = $this->order_model->get_data($id_order);
		$rs = $this->order_model->get_detail($id_order);
		$ro = $this->order_model->get_credit($id_customer);
		$rb = $this->order_model->get_payment($id_order);
		$data['view'] = "shop/order_repay";
		$data['items'] = $rs;
		$data['order'] =$rx;
		$data['package'] = $ro;
		$data['payment'] = $rb;
		$data['id_order'] = $id_order;
		$data['id_customer'] = $id_customer;
		$data['id_menu'] = $this->id_menu;
		$this->load->view($this->layout, $data);
		
	}
	
	public function submit_payment()
	{
		if($this->input->post("id_order") != ""){
			
			$id_promotion 			= $this->input->post("id_promotion");	
			$promotion_name 		= getPromotionName($id_promotion); 
			$id_customer 			= $this->input->post("id_customer");	
			$id_order				= $this->input->post("id_order");	
			$credit 					= $this->input->post("credit");
			$qty 						= $this->input->post("qty");
			$total_qty 				= $this->input->post("total_qty");
			$amount 					= $this->input->post("amount");
			$total_amount 			= $this->input->post("total_amount");
			$package 				= $this->input->post("package");
			$receive 				= $this->input->post("cash_receive");
			$deposit 				= $this->input->post("deposit");
			
			$data['id_shop'] 		= $this->session->userdata("id_shop");
			$data['id_user'] 		= $this->session->userdata("id_user");
			$data['id_employee'] 	= $this->session->userdata("id_employee");
			$data['id_order'] 		= $this->input->post("id_order");
			$data['id_customer'] 	= $this->input->post("id_customer");
			$data['order_no'] 		= getOrderNumber($id_order);
			$data['order_amount'] = $this->input->post("total_amount");
			$data['id_promotion']	= $id_promotion;
			$data['charge_up'] 	= chargUp($this->input->post("id_order"));
						
			switch($package)
			{
				case 0 :     				/* ชำระด้วยเงินสดอย่างเดียว */
					$pay 						= ($deposit == 0 ? ($receive == 0? 0: $total_amount) : $deposit);
					$data['final_amount'] 	= $total_amount;
					$data['deposit'] 		= $deposit;
					$data['pay'] 				= $pay;
					$data['received'] 		= $receive;
					$data['change'] 		= $receive - $pay;
					$data['balance'] 		= $total_amount - $pay;
					break;
				case 1 :					/* ใช้แพ็คเกจแบบชิ้น */
					$data['discount_amount'] = $total_amount;
					$data['final_amount'] 		= 0;
					$data['deposit'] 			= 0;
					$data['pay'] 					= 0;
					$data['received'] 			= 0;
					$data['change'] 			= 0;
					$data['balance'] 			= 0;
					$c_data['credit'] 			= $credit - $total_qty;
					// ********* ข้อมูลสำหรับบันทึก แพ็คเกจใช้ไป *****//
					$used['id_customer'] 		= $this->input->post("id_customer");
					$used['id_shop']			= $this->session->userdata("id_shop");
					$used['id_employee']		= $this->session->userdata("id_employee");
					$used['id_order'] 			= $id_order;	
					$used['id_promotion'] 		= $id_promotion;
					$used['promotion_name'] = $promotion_name;
					$used['qty']					= $total_qty;
					$used['amount']				= $total_amount;
					// ********* ข้อมูลสำหรับบันทึก แพ็คเกจใช้ไป *****//
					break;
				case 2 :			/* ใช้แพ็คเกจแบบเงิน */
					$discount 					= $total_amount - $amount;
					$final_amount 				= $total_amount - $discount;		
					$pay 							= ($deposit == 0 ? $final_amount : $deposit);
					$data['discount_amount'] = $discount;
					$data['final_amount'] 		= $final_amount;
					$data['deposit'] 			= $deposit;
					$data['pay'] 					= $pay;
					$data['received'] 			= $receive;
					$data['change'] 			= $receive - $pay;
					$data['balance'] 			= $final_amount - $pay;
					$c_data['credit'] 			= $credit - $discount;
					// ********* ข้อมูลสำหรับบันทึก แพ็คเกจใช้ไป *****//
					$used['id_customer'] 		= $this->input->post("id_customer");
					$used['id_shop']			= $this->session->userdata("id_shop");
					$used['id_employee']		= $this->session->userdata("id_employee");
					$used['id_order'] 			= $id_order;	
					$used['id_promotion'] 		= $id_promotion;
					$used['promotion_name'] = $promotion_name;
					$used['qty']					= 0;
					$used['amount']				= $discount;
					// ********* ข้อมูลสำหรับบันทึก แพ็คเกจใช้ไป *****//
					break;
			}
			
			switch($package)
			{
				case 0 :
					$this->load->model("shop/payment_model");
					$rs = $this->payment_model->add($data);
					if($rs){
						$this->order_model->valid_order($id_order);
						$this->print_order($id_order);
					}else{
						setError("ชำระเงินไม่สำเร็จ กรุณาลองใหม่อีกครั้ง");
						redirect("","refresh");
					}
					break;
				case 1 :
					$this->load->model("shop/payment_model");
					$rs = $this->payment_model->add($data);
					if($rs){
						$ro = $this->order_model->update_credit($id_customer, $id_promotion, $c_data);
						if($ro)	{
							$this->order_model->package_used($used);
							$this->order_model->valid_order($id_order);
							$this->print_order($id_order);
						}else{
							setError("Update credit balance fail");
							redirect($this->home);
						}
					}else{
						setError("ชำระเงินไม่สำเร็จ กรุณาลองใหม่อีกครั้ง");
						redirect("","refresh");
					}
					break;
				case 2 :
					$this->load->model("shop/payment_model");
					$rs = $this->payment_model->add($data);
					if($rs){
						$ro = $this->order_model->update_credit($id_customer, $id_promotion, $c_data);
						if($ro){
							$this->order_model->package_used($used);
							$this->order_model->valid_order($id_order);
							$this->print_order($id_order);
						}else{
							setError("Update credit balance fail");
							redirect($this->home);
						}
					}else{
						setError("ชำระเงินไม่สำเร็จ กรุณาลองใหม่อีกครั้ง");
						redirect("","refresh");
					}
					break;
			}	// end switch
		}else{
			setError("ข้อมูลไม่ครบถ้วน กรุณาทำการชำระเงินใหม่อีกครั้ง");
			redirect($this->home);
		}// end if	
	} //end function
	
	public function submit_repay()
	{
		if($this->input->post("id_order") != ""){	
			$id_promotion 			= $this->input->post("id_promotion");	
			$id_customer 			= $this->input->post("id_customer");	
			$id_order				= $this->input->post("id_order");	
			$credit 					= $this->input->post("credit");
			$qty 						= $this->input->post("qty");
			$total_qty 				= $this->input->post("qty");
			$amount 					= $this->input->post("amount");
			$total_amount 			= $this->input->post("total_amount");
			$package 				= $this->input->post("package");
			$receive 				= $this->input->post("cash_receive");
			$pay						="";
			$data['id_shop'] 		= $this->session->userdata("id_shop");
			$data['id_user'] 		= $this->session->userdata("id_user");
			$data['id_employee'] 	= $this->session->userdata("id_employee");
			$data['id_order'] 		= $this->input->post("id_order");
			$data['id_customer'] 	= $this->input->post("id_customer");
			$data['order_no'] 		= getOrderNumber($id_order);
			$data['order_amount'] = 0;
			$data['id_promotion']	= $id_promotion;
			$data['charge_up'] 	= 0;
						
			switch($package)
			{
				case 0 :     				/* ชำระด้วยเงินสดอย่างเดียว */
					$pay 						= $total_amount;
					$data['pay'] 				= $pay;
					$data['received'] 		= $receive;
					$data['change'] 		= $receive - $pay;
					$data['balance'] 		= $total_amount - $pay;
					$data['repay'] 			= 1;
					break;
				case 2 :			/* ใช้แพ็คเกจแบบเงิน */
					$discount 					= $total_amount - $amount;
					$final_amount 				= $total_amount - $discount;		
					$pay 							=  $final_amount;
					$data['discount_amount'] = $discount;
					$data['final_amount'] 		= $final_amount;
					$data['pay'] 					= $pay;
					$data['received'] 			= $receive;
					$data['change'] 			= $receive - $pay;
					$data['balance'] 			= $final_amount - $pay;
					$data['repay']				= 1;
					$c_data['credit'] 			= $credit - $discount;
					break;
			}
			
			switch($package)
			{
				case 0 :
					$this->load->model("shop/payment_model");
					$rs = $this->payment_model->add($data);
					if($rs){
						$this->order_model->valid_order($id_order);
						$this->print_order_repay($id_order);
					}else{
						setError("ชำระเงินไม่สำเร็จ กรุณาลองใหม่อีกครั้ง");
						redirect("","refresh");
					}
					break;
				case 2 :
					$this->load->model("shop/payment_model");
					$rs = $this->payment_model->add($data);
					if($rs){
						$ro = $this->order_model->update_credit($id_customer, $id_promotion, $c_data);
						if($ro){
							$this->order_model->valid_order($id_order);
							$this->print_order_repay($id_order);
						}else{
							setError("Update credit balance fail");
							redirect($this->home);
						}
					}else{
						setError("ชำระเงินไม่สำเร็จ กรุณาลองใหม่อีกครั้ง");
						redirect("","refresh");
					}
					break;
			}	// end switch
		}else{
			setError("ข้อมูลไม่ครบถ้วน กรุณาทำการชำระเงินใหม่อีกครั้ง");
			redirect($this->home);
		}// end if	
	} //end function
	
	
} /// End class

?>