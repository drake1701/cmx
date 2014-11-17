<?php
/**
 * @author		Dennis Rogers
 * @address		www.drogers.net
 */

if($_SERVER['PHP_SELF'] != '/phpliteadmin.php'):

require_once("app/Cmx.php");
$cmx = new Cmx_App();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>CMX Reader</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.css" />
	<link rel="stylesheet" href="../assets/css/default.css">
	<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="../assets/js/custom-init.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.3/jquery.mobile-1.4.3.min.js"></script>
</head>
<body>
<?php endif; ?>