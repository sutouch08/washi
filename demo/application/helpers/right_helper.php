<?php
function valid_menu($id_menu, $url)
{	
	$c =& get_instance();
	$id_profile = $c->session->userdata("id_profile");
	if($id_profile == 0)
	{
		$url = base_url().$url;
	}else{
		$c->db->select("view");
		$ro = $c->db->get_where("tbl_access", array("id_profile"=>$id_profile, "id_menu"=>$id_menu), 1);
		if($ro->num_rows() ==1)
		{
			$rs = $ro->row();
			if($rs->view == 1)
			{ 
				$url = base_url().$url;
			}else{
				$url = "#";
			}
		}else{
			$url = "#";
		}
	}
	return $url;
}

function valid_access($id_menu)
{
	$c =& get_instance();
	$id_profile = $c->session->userdata("id_profile");
	$result = null;
	if($id_profile ==0)
	{
		$result['view'] = 1;
		$result['add'] = "";
		$result['edit'] = "";
		$result['delete'] = "";
	}else{
		$limit = 1; // Limit 1 row
		$ro = $c->db->get_where("tbl_access", array("id_profile"=>$id_profile, "id_menu"=>$id_menu), $limit);
		if($ro->num_rows() ==1)
		{
			$rs = $ro->row();
			$result['view'] = $rs->view;
			$result['add'] = $rs->add ==1? "" : "style='display:none;'";
			$result['edit'] = $rs->edit ==1? "" : "style='display:none;'";
			$result['delete'] = $rs->delete ==1? "" : "style='display:none;'";
		}else{
			$result['view'] 	= 0;
			$result['add'] 	= "style='display:none;'";
			$result['edit'] 	= "style='display:none;'";
			$result['delete'] ="style='display:none;'";
		}
	}
	return $result;
}

function action_deny($page)
{
	$data = array( "view"=>"deny_action", "page_title"=>"Action deny");
	$c =& get_instance();
	return $c->load->view($page, $data);
}

function access_deny()
{
	$data = array("page_title"=>"Access deny");
	$c =& get_instance();
	return $c->load->view("deny_page", $data );	
}

function must_check_in()
{
	$date = date("Y-m-d");
	$c =& get_instance();
	$id_shop = $c->session->userdata("id_shop");
	$id_employee = $c->session->userdata("id_employee");
	$session = check_time();
	if($session != false){
		$start = $date." ".$session['start'];
		$end = $date." ".$session['end'];
		$sql = "SELECT * FROM tbl_em_check_in WHERE id_employee = ".$id_employee." AND id_shop = ".$id_shop." AND ( date_add BETWEEN '".$start."' AND '".$end."' )";
		$rs = $c->db->query($sql);
		if($rs->num_rows() == 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}else{
		return false;
	}		
}

function check_time()
{
	$c =& get_instance();
	$time = NOW();
	$sql = "SELECT start, end FROM tbl_time_table WHERE start <= '".$time."' AND end >= '".$time."' LIMIT 1";
	$rs = $c->db->query($sql);
	if($rs->num_rows() >0 )
	{
			$rd = $rs->row();
			$md['start'] = $rd->start;
			$md['end'] = $rd->end;
			return $md;
	}
	else
	{
		return false;
	}
}

function time_checked($id_employee, $id_shop, $from, $to)
{
	$c =& get_instance();
	$time = NOW();
	$sql = "SELECT * FROM tbl_em_check_in WHERE id_employee = $id_employee AND id_shop = $id_shop AND ( date_add BETWEEN '$from' AND '$to' )";
	$rs = $c->db->query($sql);
	if($rs->num_rows() >0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>