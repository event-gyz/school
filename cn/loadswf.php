<?php
//if(isset($_SESSION['user_token'])) {
	$f = $_GET['f'];
	if(isset($f)) {
		$fileName = "../content/upload/training/".date('d_m_Y')."/$f";
//		chdir("../content/upload/training/".date('d_m_Y'));				$fileName = $f;
		header("Content-Type: application/x-shockwave-flash",true);
		readfile($fileName);	
	}
//}
?>