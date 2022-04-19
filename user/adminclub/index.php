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
$adminclub = new main_Admin;
$liga = new main_Liga;

if($sesi->adminclub())header("location:../../login.php");

$theme->head();
$theme->css();
$theme->menuadminclub();
$theme->topBar();

$main->getEmpty();

	if($main->get('page')=='home'):

		$adminclub->dashboard_adminClub();

	elseif($main->get('page')=='pemain'):

		$adminclub->form_pemainSaya();

	elseif($main->get('page')=='tambah pemain'):
	
		$adminclub->form_pemainSaya_add();

	elseif($main->get('page')=='edit pemain'):

		$adminclub->form_pemainSaya_edit();

	elseif($main->get('page')=='delete pemain'):

		$adminclub->form_deletePemain();

	elseif($main->get('page')=='detail pemain'):

		$adminclub->form_detailPemain();

	elseif($main->get('page')=='club saya'):

		$adminclub->form_clubSaya();

	elseif($main->get('page')=='jadwal tanding'):

		$liga->jadwalPertandingan();

	elseif($main->get('page')=='profile'):

		$adminclub->form_updateProfile_users();
		
	else:

		$adminclub->dashboard_adminClub();

	endif;

$theme->footer();

?>