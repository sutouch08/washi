<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(isset($page_title)){ echo $page_title; }else{ echo "User Guide"; } ?></title>

<style type='text/css' media='all'>@import url('<?php echo base_url(); ?>user_guide/nav/userguide.css');</style>
<link rel='stylesheet' type='text/css' media='all' href='<?php echo base_url(); ?>user_guide/nav/userguide.css' />

<script type="text/javascript" src="<?php echo base_url(); ?>user_guide/nav/nav.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>user_guide/nav/prototype.lite.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>user_guide/nav/moo.fx.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>user_guide/nav/user_guide_menu.js"></script>

<meta http-equiv='expires' content='-1' />
<meta http-equiv= 'pragma' content='no-cache' />
<meta name='robots' content='all' />
<meta name='author' content='ExpressionEngine Dev Team' />
<meta name='description' content='CodeIgniter User Guide' />

</head>
<body>

<!-- START NAVIGATION -->
<div id="nav"><div id="nav_inner"><script type="text/javascript">create_menu('null');</script></div></div>
<div id="nav2"><a name="top"></a><a href="javascript:void(0);" onclick="myHeight.toggle();"><img src="<?php echo base_url(); ?>user_guide/images/nav_toggle_darker.jpg" width="154" height="43" border="0" title="Toggle Table of Contents" alt="Toggle Table of Contents" /></a></div>
<div id="masthead">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%">
<tr>
<td><h1>User Guide Version 2.0</h1></td>
<td id="breadcrumb_right"><a href="<?php echo base_url();?>userguide/index/toc">Table of Contents</a></td>
</tr>
</table>
</div>
<!-- END NAVIGATION -->

<!-- START CONTENT -->
<div id="content">
<?php $this->load->view($view); ?>
</div>
<!-- END CONTENT -->


<div id="footer">
<p><a href="#top">Top of Page</a></p>
</div>



</body>
</html>