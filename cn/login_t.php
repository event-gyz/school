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
	$sql = "SELECT uid from member where email ='".$_ID."' and password= md5(lower('".$_PASS."'))";
	$result = query($sql);
	if($result==null) echo(genResponse(false, "NO RESULT: ".$sql));
	if(mysqli_num_rows($result)!=1)
	{	
		echo(genResponse(false, "NUN ROWS 0: ".$sql));
	}
	else
	echo(genResponse(false, "OK"));
}
?>
