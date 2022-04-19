<?php
session_start();
header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=$_GET[club].xls");
require_once '../../app/core/session.php';
require_once '../../config/database.php';
require_once '../../app/core/class.input.php';
require_once '../../app/core/class.public.query.php';
require_once '../../app/core/class.admin.query.php';
require_once '../../app/html/main.form.admin.php';
require_once '../../app/html/main.export.php';
$obj = new export;
$sesi = new sessionMain;
if($sesi->administrator())header("location:../../login.php");

?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Export Data</title>
			 <style type="text/css">
        		table td{text-transform:uppercase;}
   			 </style>
		</head>
		<body>
			<?php $obj->exportBy_club(); ?>
		</body>
		</html>





