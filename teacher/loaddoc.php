<?php
// TODO: add security checks
//if(isset($_SESSION['teacher_token'])) {
	$f = $_GET['f'];
	$d = $_GET['d'];
	if(isset($f)) {
		$fileName = "../content/upload/teacher/$f";
		if(isset($d)) {
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=$f");			
		}
		else {
			header("Content-Type: application/pdf");
			header("Content-Disposition: inline; filename=$f");
		}
		readfile($fileName);	
	}
//}
?>
