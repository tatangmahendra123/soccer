<?php
session_start();
if(isset($_SESSION['role']))
{
	$array = array('administrator','adminclub','petugas','pemain');
	if(!in_array($_SESSION['role'], $array))header("location:../../login.php");

}

header("Content-type: application/octet-stream");
header("Pragma: no-cache");
header("Expires: 0");
header("Content-Disposition: attachment; filename=jadwal.xls");
require_once '../../config/database.php';
require_once '../../app/core/class.input.php';
require_once '../../app/core/class.public.query.php';
require_once '../../app/core/class.liga.php';
require_once '../../app/html/main.form.liga.php';
$liga = new main_Liga;




$liga->saveLiga();
?>

