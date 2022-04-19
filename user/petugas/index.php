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
$petugas = new main_Admin;
$liga = new main_Liga;

if($sesi->petugas())header("location:../../login.php");

$theme->head();
$theme->css();
$theme->menuPetugas();
$theme->topBar();

$main->getEmpty();

	if($main->get('page')=='home'):

		$petugas->dashboardPetugas();	

	elseif($main->get('page')=='liga'):

		$liga->liga();

	elseif($main->get('page')=='buat liga'):

		$liga->form_addLiga();

	elseif($main->get('page')=='edit liga'):

		$liga->form_editLiga();

	elseif($main->get('page')=='delete liga'):

		$liga->form_deleteLiga();

	elseif($main->get('page')=='tambah peserta liga'):

		$liga->form_addPeserta();
		
	elseif($main->get('page')=='delete peserta'):
		
		$liga->form_deletePeserta();
		
	elseif($main->get('page')=='jadwal liga'):
		
		$liga->form_addJadwal();

	elseif($main->get('page')=='jadwal tanding'):

		$liga->jadwalPertandingan();

	elseif($main->get('page')=='berita'):

		$petugas->form_limitBerita();

	elseif($main->get('page')=='buat berita'):

		$petugas->form_addBerita();

	elseif($main->get('page')=='edit berita'):

		$petugas->form_editBerita();

	elseif($main->get('page')=='lihat berita'):

		$petugas->form_lihatBerita();

	elseif($main->get('page')=='delete berita'):

		$petugas->form_deleteBerita();

	elseif($main->get('page')=='kategori'):

		$petugas->kategori();

	elseif($main->get('page')=='delete kategori'):

		$petugas->form_deleteKategori();

	elseif($main->get('page')=='profile'):

		$petugas->form_updateProfile_users();

	else:

		$petugas->dashboardPetugas();

	endif;

$theme->footer();

?>