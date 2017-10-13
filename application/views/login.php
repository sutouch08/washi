<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">

    <title>Sign in</title>

    <!-- core CSS -->
   
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet"> 
    <link href="<?php echo base_url(); ?>assets/css/signin.css" rel="stylesheet">
  </head>

  <body>
 
<div class="wrapper">
    <form class="form-signin" action="<?php echo base_url()."authentication/validate_credentials"; ?>" method="post">       
      <h2 class="form-signin-heading">Please login</h2>
      <input type="text" class="form-control" name="username" placeholder="User Name" style="border-bottom-left-radius:4px; border-bottom-right-radius:4px;" required autofocus autocomplete="off" />
      <br/>
      <input type="password" class="form-control" name="password" placeholder="Password" required style="margin-bottom:25px;"/>      
      
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button> 
      <?php if($this->session->flashdata("error") != null) : ?>
      <br/>
      <span style="color: red;" ><?php echo $this->session->flashdata("error"); ?></span>
      <?php endif; ?>
    </form>
  </div>
  </body>
</html>