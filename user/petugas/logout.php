<?php
session_start();
unset($_SESSION['id_user'], $_SESSION['role'], $_SESSION['nama_user']);
session_destroy();
header("location:../../login.php");

?>