<?php
session_start();

include("inc.php"); 

$_nick_name = $_REQUEST['p1'];
$_phone = $_REQUEST['p2'];
$_password = $_REQUEST['p3'];
$_token = $_SESSION['user_token'];

if(empty($_nick_name)) {
	die(genResponse(false, '输入资料有误'));
}
else if(empty($_token)) {
	echo(genResponse(false, '登入状态有误'));
}
else {
	if ($member_uid = $CMEMBER->accessFromToken($_token)) {
		$sql = "update member set first_name='$_nick_name'";
		if(!empty($_phone))	$sql .=",cellphone='$_phone'";
		if(!empty($_password))	$sql .=",password=md5(lower('".$_password."'))";
		$sql .=" where uid='$member_uid'";
		query($sql);
		if(mysqli_affected_rows() > 0) {
			echo(genResponse(true,"OK"));			
		}
		else {
			echo(genResponse(false, '数据添加失败'));
		}
	}else{
		echo(genResponse(false, '登入状态有误'));
	}
}
?>
