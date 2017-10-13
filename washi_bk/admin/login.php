<?php
require_once '../library/config.php';
require_once '../library/functions.php';

$errorMessage = '&nbsp;';

if (isset($_POST['txtUserName'])) {
	$result = adminLogin();
	
	if ($result != '') {
		$errorMessage = $result;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">

    <title>Sign in : ADMIN page</title>

    <!-- core CSS -->
    <link href="../library/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../library/css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form method="post" class="form-signin" role="form" autocomplete="off" >
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="form-control" name="txtUserName" placeholder="User Name" required autofocus>
        <input type="password" class="form-control" name="txtPassword" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        
      </form>
      </div>
      <div class="contrainer">
      <?
	  	if(isset($_GET['message'])){
			if($_GET['message']=='error'){
			echo "<div>&nbsp;</div><div  style='color:red;'><h4><div>Wrong User Name or Password</div><div><br>OR</div><div><br>You have no right to access Admin page </div></h4></div>";
			}else if($_GET['message']=='deny'){
				echo "<div>&nbsp;</div><div  style='color:red;'><h4><div><br>You have no right to access Admin page </div></h4></div>";
		}
		}
	  ?>
      </div> 
  </body>
</html>