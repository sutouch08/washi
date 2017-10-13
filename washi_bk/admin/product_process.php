<?php
	require "../library/config.php";
	require "../library/functions.php";
	
	if(isset($_GET['product_name'])){
	$product_name = $_GET['product_name'];
	$result = dbQuery("SELECT product_name FROM tbl_product WHERE product_name='$product_name'");
	$row = dbNumRows($result);
	if($row >0){
		$message ="1";
		echo $message;
	}else{
		$message ="0";
		echo $message;
	}
}

if(isset($_GET['add'])){
		$product_name = $_POST['product_name'];
		$price = $_POST['price'];
		$weight = $_POST['weight'];
		$category = $_POST['category'];
		$type_id = $_POST['type_id'];
		dbQuery("INSERT INTO tbl_product (product_name, price, product_weight, process_category_id,type_id) VALUES ('$product_name','$price','$weight','$category','$type_id')");
		header("location:index.php?content=product");
	}
	
	if(isset($_GET['edit']))	{		
		$product_id = $_POST['product_id'];		
		$product_name = $_POST['product_name'];
		$price = $_POST['price'];
		$weight = $_POST['weight'];
		$category = $_POST['category'];
		$type_id = $_POST['type_id'];
		$result = dbQuery("UPDATE tbl_product SET product_name='$product_name', price='$price', product_weight='$weight', process_category_id='$category' ,type_id = '$type_id' WHERE product_id = $product_id");
		header("location:index.php?content=product");		
}
	if(isset($_GET['delete'])){
		$product_id = $_GET['product_id'];
		dbQuery("DELETE FROM tbl_product WHERE product_id = $product_id");
		header("location:index.php?content=product");
	}
		
?>