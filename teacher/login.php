<?php
session_start();

include("inc.php"); 

$beta=true;
if($beta)
{
	$_ID = $_REQUEST['p1'];
	$_PASS = $_REQUEST['p2'];
}
else
{
	$_ID = $_POST['p1'];
	$_PASS = $_POST['p2'];
}

if(!isset($_ID) || !isset($_PASS) ) {
	die(genResponse(false, $_v_ERROR_INVALID_PARAMETER."(ER-000001)"));
}
else {	
	$CMEMBER->admin = true;
	if($CMEMBER->login($_ID, $_PASS) == -1) die(genResponse(false, $_v_ERROR_LOGIN_FAILED."(ER-000002)"));
	$CMEMBER->getUserInfo();
	$token = $CMEMBER->getUserToken();

	if(isset($token)) {
		$arr = array(
			'token' => $token,
			'email' => $CMEMBER->email
		);
		
		$_SESSION['teacher_token'] = $token;
		$_SESSION['teacher_email'] = $CMEMBER->email;

		echo(genResponse(true, json_encode($arr)));
	}
	else
		echo(genResponse(false, $_v_ERROR_LOGIN_FAILED));
}
?>
