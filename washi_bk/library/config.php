<?php
ini_set('display_errors', 'off');
//ob_start("ob_gzhandler");
//error_reporting(E_ALL);

// start the session
session_start();

 //database connection config
$dbHost = 'localhost';
$dbUser = 'washi_admin';
$dbPass = '3310101764121';
$dbName = 'washi_db';


// setting Company's name to show On template
$company = 'Washi';

// setting up the web root, server root and company's name
$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = $_SERVER['DOCUMENT_ROOT'];
$webRoot  = str_replace(array($docRoot, 'library/config.php'), '', $thisFile);
$srvRoot  = str_replace('library/config.php', '', $thisFile);
define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);
define('COMPANY',$company);


require_once 'database.php';

?>