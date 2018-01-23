<?php
include("inc.php"); 
$_EMAIL = 'bclin087+sunnyschool@gmail.com';//$_GET['email'];
$result = sendVerifyEmail($_EMAIL);
if($result) {
	echo('alert("Mail sent!")');
}
else {
	echo('alert("Error occurred")');
}
?>
