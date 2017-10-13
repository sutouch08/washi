<?
	require "../library/config.php";
	require "../library/functions.php";
	if(isset($_POST['add_pro'])){
		$promo_name = $_POST['promo_name'];
		$promo_start = $_POST['promo_start'];
		$promo_end = $_POST['promo_end'];
		$promo_duration = $_POST['promo_duration'];
		$unit = $_POST['unit'];
		$promo_price = $_POST['promo_price'];
		if($unit == "1"){
			$promo_money = $_POST['promo'];
			$promo_pcs = "";
			$promo_discount = "";
			}else if($unit == "2"){
			$promo_pcs = $_POST['promo'];
			$promo_money = "";
			$promo_discount = "";
			}else if($unit = "3"){
			$promo_discount = $_POST['promo'];
			$promo_pcs = "";
			$promo_money = "";
			}
		dbQuery("INSERT INTO tbl_promo  (promo_name, promo_start, promo_end, promo_duration,promo_pcs,promo_money,promo_discount,promo_price) VALUES ('$promo_name','$promo_start','$promo_end','$promo_duration','$promo_pcs','$promo_money','$promo_discount','$promo_price')");
		
		header("location:index.php?content=promo");
	}
	if(isset($_POST['edit_pro'])){
		$promo_id = $_POST['promo_id'];
		$promo_name = $_POST['promo_name'];
		$promo_start = $_POST['promo_start'];
		$promo_end = $_POST['promo_end'];
		$promo_duration = $_POST['promo_duration'];
		$unit = $_POST['unit'];
		$promo_price = $_POST['promo_price'];
		if($unit == "1"){
			$promo_money = $_POST['promo'];
			$promo_pcs = "";
			$promo_discount = "";
			}else if($unit == "2"){
			$promo_pcs = $_POST['promo'];
			$promo_money = "";
			$promo_discount = "";
			}else if($unit = "3"){
			$promo_discount = $_POST['promo'];
			$promo_pcs = "";
			$promo_money = "";
			}
		dbQuery("UPDATE tbl_promo SET promo_name='$promo_name', promo_start='$promo_start', promo_end='$promo_end',promo_duration='$promo_duration' , promo_pcs = '$promo_pcs', promo_money='$promo_money' ,promo_discount='$promo_discount',promo_price='$promo_price' WHERE promo_id='$promo_id'");
		
		header("location:index.php?content=promo");
	}
	if(isset($_GET['del'])){
		$promo_id = $_GET['promo_id'];
		dbQuery("delete from tbl_promo where promo_id = '$promo_id'");
		dbQuery("delete from tbl_member_detail where promo_id = '$promo_id'");
		header("location:index.php?content=promo");
	}
	?>