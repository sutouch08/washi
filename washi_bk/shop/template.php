<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$self = WEB_ROOT . 'index.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">

    <title><? echo $pageTitle ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo WEB_ROOT;?>library/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo WEB_ROOT;?>library/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo WEB_ROOT;?>library/css/navbar-static-top.css" rel="stylesheet">
    <link href="<?php echo WEB_ROOT;?>library/css/template.css" rel="stylesheet">
    <?php
$n = count($script);
for ($i = 0; $i < $n; $i++) {
	if ($script[$i] != '') {
		echo '<script language="JavaScript" type="text/javascript" src="' . WEB_ROOT. 'library/' . $script[$i]. '"></script>';
	}
}
?>

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

     <!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        <a class="navbar-brand" href="<?php echo WEB_ROOT.'index.php';?>">HOME</a>
        </div>
        <div class="navbar-collapse collapse">
        <ul class="nav  navbar-nav">
                    <? if($pageTitle=='SHOP'){ echo "<li ></li>";} else { echo "<li><a href='index.php'><img src='../images/UI/back.png' ></a></li>";} ?>
                    <? if($pageTitle=='New Order'){ echo "<li class='active'><a href='#'>New Order</a></li>";} else { echo "<li ><a href='index.php?content=new'>New Order</a></li>";} ?>
                  	<? if($pageTitle=='Apply Barcode'){ echo "<li class='active'><a href='#'>Apply Barcode</a></li>";} else { echo "<li ><a href='index.php?content=barcode'>Apply Barcode</a></li>";}?>
                    <? if($pageTitle=='Edit Order'){ echo "<li class='active'><a href='#'>Edit Order</a></li>";} else { echo "<li ><a href='index.php?content=edit'>Edit Order</a></li>";}?>
                    <? if($pageTitle=='Delete Order'){ echo "<li class='active'><a href='#'>Delete Order</a></li>";} else { echo "<li ><a href='index.php?content=delete'>Delete Order</a></li>";}?>
                    <? if($pageTitle=='Order List'){ echo "<li class='active'><a href='#'>Order History</a></li>";} else { echo "<li ><a href='index.php?content=list'>Order History</a></li>";}?>
                    <? if($pageTitle=='New Delivery'){ echo "<li class='active'><a href='#'>New Delivery</a></li>";} else { echo "<li ><a href='index.php?content=newDelivery'>New Delivery</a></li>";}?>
                </ul>
          
          <p class="navbar-text navbar-right"><a href="<?php echo $self; ?>?logout" class="navbar-link">Sign Out</a></p>
          <p class="navbar-text navbar-right">Sign in as <?php echo $_COOKIE['UserName']; ?></p>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    
<div class="starter-template">
  <?php
  if($content != "check_bill.php"){
 require_once('check_bill_not.php'); 
  }
			include $content;	 
		?>
        </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="../dist/js/bootstrap.min.js"></script>
    <script src="../dist/js/bootstrap.js"></script>
  </body>
</html>
