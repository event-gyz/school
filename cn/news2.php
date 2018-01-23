<?php
$path = '../inc/';
set_include_path($path . PATH_SEPARATOR . get_include_path());
include_once("inc_db.php");
include_once("article_functions.php");
$page = $_GET['p'];
if(!isset($page)) $page = 2;
af_news_list($page);
?>