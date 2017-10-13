<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$self = WEB_ROOT . 'index.php';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><? echo $pageTitle ?></title>

    <!-- Core CSS - Include with every page -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	<script src="<?php echo WEB_ROOT;?>library/js/jquery-1.9.1.js"></script> 
<script src="<?php echo WEB_ROOT;?>library/js/jquery-ui-1.10.2.custom.min.js"></script>
<link rel="stylesheet" href="<?php echo WEB_ROOT;?>library/css/jquery-ui-1.10.2.custom.css" />

    <!-- Page-Level Plugin CSS - Blank -->

    <!-- SB Admin CSS - Include with every page -->
    <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Management</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $self; ?>?logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

        </nav>
        <!-- /.navbar-static-top -->

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                   
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> ยอดขาย<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
							<li>
                                <a href="index.php?content=saleTotalReport">รายงานสรุปยอดขาย</a>
                            </li>
                            <li>
                                <a href="index.php?content=saleReport">สรุปยอดขาย แต่ละร้าน</a>
                            </li>
                            <li>
                                <a href="index.php?content=saleByShop">สรุปยอดขายดูเป็นร้าน</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-table fa-fw"></i> ปริมาณชิ้นงาน<span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
                            <li>
                                <a href="index.php?content=qtyReport">รายงานสรุปยอดปริมาณ</a>
                            </li>
                            <li>
                                <a href="index.php?content=qtyByShop">รายงานสรุปยอดปริมาณ แต่ละร้าน</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="index.php?content=Customer"><i class="fa fa-edit fa-fw"></i> ลูกค้า</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-wrench fa-fw"></i> การขนส่งของร้านค้า<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="index.php?content=TranSport">สรุปการขนส่งของร้านค้า</a>
                            </li>
                            <li>
                                <a href="index.php?content=Delivery">รายงานการขนส่งประจำวัน</a>
                            </li>
                            <li>
                                <a href="index.php?content=Delivery1">รายงานสรุปการขนส่ง</a>
                            </li>
                            <li>
                                <a href="index.php?content=DeSum">รายงานสรุปการขนส่งแต่ละร้าน</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> ส่วนของโรงงาน<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="index.php?content=factory">รายงานสรุปยอดซักแต่ละร้าน</a></li>
							<li> <a href="index.php?content=factory_delivery">สรุปรายการการขนส่งของโรงงาน</a></li>
							<li> <a href="index.php?content=factory_delivery1">รายงานสรุปการขนส่งประจำวัน</a></li>
							<li> <a href="index.php?content=factory_delivery2">รายงานสรุปการขนส่งของโรงงาน</a></li>
							<li> <a href="index.php?content=factory_process">รายงานสรุปยอดการซัก</a></li>
							<li> <a href="index.php?content=factory_process_detail">รายงานความคืบหน้าการซัก</a></li>
                            
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="index.php?content=Car"><i class="fa fa-table fa-fw"></i> ตารางการขนส่ง</a>
                    </li>
                    <li>
                        <a href="index.php?content=Issue"><i class="fa fa-table fa-fw"></i> ตารางการเกิดปัญหา</a>
                    </li>
                    </li>
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->

        <div id="page-wrapper">
            <?php
			include $content;	 
		?>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Core Scripts - Include with every page -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <!-- Page-Level Plugin Scripts - Blank -->
    <!-- SB Admin Scripts - Include with every page -->
    <script src="js/sb-admin.js"></script>
    <!-- Page-Level Demo Scripts - Blank - Use for reference -->

</body>

</html>