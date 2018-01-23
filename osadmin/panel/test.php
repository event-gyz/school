<?php
//define('SMARTY_DIR', '/var/www/kidsdna_store/sunnyschool/osadmin/include/lib/Smarty/');
//require_once(SMARTY_DIR . 'Smarty.class.php');
require ('../include/init.inc.php');
//$smarty = new Smarty();
//echo('hello');
//$user_info = UserSession::getSessionInfo();
//$menus = MenuUrl::getMenuByIds($user_info['shortcuts']);
//Template::assign ('menus' ,$menus);
Template::display ('test.tpl');
//echo(TEMPLATE_DIR);
?>
