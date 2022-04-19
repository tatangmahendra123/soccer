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
$admin = new main_Admin;
$liga = new main_Liga;

if($sesi->administrator())header("location:../../login.php");

$theme->head();
$theme->css();
$theme->sidebar();
$theme->topBar();

$main->getEmpty();

	if($main->get('page')=='home'):

		$admin->dashboard();	

	elseif($main->get('page')=='administrator'):

		$admin->administrator();
	
	elseif($main->get('page')=='buat akun admin'):

		$admin->form_addUser();	

	elseif($main->get('page')=='petugas'):

		$admin->Petugas();	

	elseif($main->get('page')=='edit petugas'):

		$admin->editPetugas();
				
	elseif($main->get('page')=='buat akun petugas'):

		$admin->form_addPetugas();	

	elseif($main->get('page')=='delete petugas'):

		$admin->form_deletePetugas();

	elseif($main->get('page')=='buat akun adminclub'):

		$admin->form_addAdm_club();

	elseif($main->get('page')=='admin club'):

		$admin->admClub();

	elseif($main->get('page')=='edit admin club'):

		$admin->form_editAdm_club();

	elseif($main->get('page')=='delete admin club'):

		$admin->form_deleteAdmin_club();	

	elseif($main->get('page')=='club'):

		$admin->club();

	elseif($main->get('page')=='tambah club'):
		
		$admin->form_addClub();

	elseif($main->get('page')=='edit club'):

		$admin->form_editClub();

	elseif($main->get('page')=='delete club'):

		$admin->form_deleteClub();

	elseif($main->get('page')=='pemain'):

		$admin->pemain();

	elseif($main->get('page')=='buat akun pemain'):
	
		$admin->form_addPemain();

	elseif($main->get('page')=='edit pemain'):

		$admin->form_editPemain();

	elseif($main->get('page')=='delete pemain'):

		$admin->form_deletePemain();

	elseif($main->get('page')=='detail pemain'):

		$admin->form_detailPemain();

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

		$admin->form_limitBerita();

	elseif($main->get('page')=='buat berita'):

		$admin->form_addBerita();

	elseif($main->get('page')=='edit berita'):

		$admin->form_editBerita();

	elseif($main->get('page')=='lihat berita'):

		$admin->form_lihatBerita();

	elseif($main->get('page')=='delete berita'):

		$admin->form_deleteBerita();

	elseif($main->get('page')=='kategori'):

		$admin->kategori();

	elseif($main->get('page')=='delete kategori'):

		$admin->form_deleteKategori();
		
	elseif($main->get('page')=='halaman'):

		$admin->form_pages();
		
	elseif($main->get('page')=='tambah halaman'):

		$admin->form_addPages();

	elseif($main->get('page')=='lihat halaman'):

		$admin->form_lihatPages();

	elseif($main->get('page')=='edit halaman'):

		$admin->form_editPages();

	elseif($main->get('page')=='delete halaman'):

		$admin->form_deletePages();

	elseif($main->get('page')=='pengaturan'):

		$admin->form_updateSetting();

	elseif($main->get('page')=='pengaturan menu'):

		$admin->form_addMenu();

	elseif($main->get('page')=='edit menu'):

		$admin->form_editMenu();

	elseif($main->get('page')=='delete menu'):

		$admin->form_deleteMenu();

	elseif($main->get('page')=='profile'):

		$admin->form_updateProfile_users();

	else:

		 $admin->dashboard();

	endif;

$theme->footer();

?>