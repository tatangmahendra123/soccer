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
require_once 'config/database.php';
require_once 'app/core/class.input.php';
require_once 'app/core/class.public.query.php';
require_once 'app/core/class.settings.php';
require_once 'app/core/class.web.php';
require_once 'app/html/main.web.php';
require_once 'app/html/public.theme.php';

$theme = new publicTheme;
$main = new dataInput;
$web = new main_Web;

$theme->head();
$theme->css();
$theme->body();

$web->home();
$web->jadwal_beranda();
$web->berita_beranda();
    
$theme->footer();

?>
