<?php
$path = '../inc/';
set_include_path($path . PATH_SEPARATOR . get_include_path());
include_once("global_var.php");
include_once("inc_db.php");
include_once("language.php");
include_once("access_token.php");
include_once("user_functions.php");
include_once("common_response.php");
include_once("log.php");
include_once("article_functions.php");
include_once("enc_dec.php");
?>
