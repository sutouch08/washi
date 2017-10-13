<div class="contrainer">
<div class="row">
<?php 
$id_shop = $this->session->userdata("id_shop");
$shop_name = getShopName($id_shop);
$id_employee = $this->session->userdata("id_employee");
$employee = getEmployeeName($id_employee);
$id_user = $this->session->userdata("id_user");
$user_name = $this->session->userdata("user_name");
?>

<div class="col-lg-12"><h1 style="text-align:center" >Welcome to <?php echo $shop_name; ?> </h1></div>
<div class="col-lg-12"><h1 style="text-align:center" >Shop ID is <?php echo $id_shop; ?> </h1></div>
<div class="col-lg-12"><h1 style="text-align:center" >My name is  <?php echo $employee; ?> </h1></div>
<div class="col-lg-12"><h1 style="text-align:center" >My User ID is <?php echo $id_user; ?> </h1></div>
<div class="col-lg-12"><h1 style="text-align:center" >My User Name is <?php echo $user_name; ?> </h1></div>
</div>


</div><!-- end of container -->