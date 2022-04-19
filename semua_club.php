<?php
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
$main->getEmpty();
	if($main->get('page')=='data'):
		$web->clubData();
	else:
		$web->club();
	endif;

$theme->footer();

?>
