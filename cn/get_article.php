<?php
include('inc.php');
$__USE_CACHE__ = false;

$uid = $_REQUEST['uid'];
$from_page = $_REQUEST['from_page'];

if(!isset($from_page))
	$from_page = 'index';

if($__USE_CACHE__) {
//----BEGIN cache ----//
	// define the path and name of cached file
	$cachefile = 'cached-files/article_'.$uid.'_'.$from_page.'_'.date('M-d-Y').'.php';
	// define how long we want to keep the file in seconds. I set mine to 5 hours.
	$cachetime = 18000; // 5 * 60 * 60
	// Check if the cached file is still fresh. If it is, serve it up and exit.
	if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
		include($cachefile);
	    exit;
	}
	ob_start();
//----END cache ----//	
}
		
af_recommend_load_article($uid,$from_page);

if($__USE_CACHE__) {
//----BEGIN cache ----//
	// We're done! Save the cached content to a file
	$fp = fopen($cachefile, 'w');
	fwrite($fp, ob_get_contents());
	fclose($fp);
	// finally send browser output
	ob_end_flush();
//----END cache ----//
}
?>