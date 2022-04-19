<?php
/**

	| Kehidupan ini seperti mimpi, terasa sebentar,
	| seperti halnya mimpi yang terasanya nyata
	| berada dalam ingatan, ketika berlalu
	| semua hanya menjadi kenangan.
	| Hidup seperti tidak ada masa depan, karena setiap
	| masa depan hanya akan menjadi kenangan.
	| Dan kenangan ini mungkin ini terus hidup dimasa, depan - masa
	| depan yang akan menjadi kenangan :(
	|
    |----------------------------------------|
    | Author          			 			 |
	| name 			  : Benny maulana 			 | 
	| mail 			  : innupasha2@gmail.com  |
	| blog 			  : xdmultimedia.id         |  
	|----------------------------------------| 
**/
session_start();
require_once('../../app/core/session.php');
require_once '../../config/database.php';
require_once '../../app/core/class.input.php';
require_once '../../app/core/class.public.query.php';
require_once '../../app/core/class.settings.php';
require_once '../../app/core/class.admin.query.php';
require_once '../../app/core/class.liga.php';
require_once '../../app/html/main.form.admin.php';
require_once '../../app/html/main.form.liga.php';
require_once '../../app/html/theme.php';

$sesi = new sessionMain;
$theme = new themeProperty;
$main = new dataInput;
$pemain = new main_Admin;
$liga = new main_Liga;

if($sesi->pemain())header("location:../../login.php");

$theme->head();
$theme->css();
$theme->menuPemain();
$theme->topBar();

$main->getEmpty();

	if($main->get('page')=='home'):

		$pemain->dashboardPemain();

	elseif($main->get('page')=='daftar pemain'):

		$pemain->form_pemainSaya_pemainLihat();

	elseif($main->get('page')=='jadwal tanding'):

		$liga->jadwalPertandingan();

	elseif($main->get('page')=='profile'):

		$pemain->form_updateProfile_users();
		
	else:

		$pemain->dashboardPemain();

	endif;

$theme->footer();

?>