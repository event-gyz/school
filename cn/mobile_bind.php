<?php
session_start();

include("inc.php"); 

$_AUTH = $_POST['p2'];
$_PHONE = $_POST['p3'];

if(empty($_AUTH)) {
	die(genResponse(false, "请填写验证码"));
}

// 查询手机号和验证码
$select = "select  *  from message where phone ='{$_PHONE}' and message_code='{$_AUTH}' and status=0 ";
if(!query_result($select)){
    die(genResponse(false, "验证码错误"));
}

else {
	// send email
	$log_file = "../log/mobile_bind_log".date("Y_m_d_H_i_s").".txt";
	$_token = $_SESSION['user_token'];
	$supervisor_uid = $CMEMBER->accessFromToken($_token);
	$sql = "select uid,email from member where cellphone='$_PHONE'";
	$row = M()->find($sql);
	//todo 如果手机号绑定过，将微信账号和手机账号进行关联
	if(!$row) {
		$update = "update member set cellphone='".$_PHONE."',membership=membership+3888000 where uid =".$supervisor_uid;
		if(query($update)){
			// 更新手机验证码信息状态
			$update ="update message set status=1 where phone ='{$_PHONE}' and message_code='{$_AUTH}'";
			query($update);
			echo(genResponse(true, "200 OK"));
		}else{
                    echo(genResponse(false, "绑定失败，请稍后再试。"));
                }
	}
	else {
		// response
		echo(genResponse(false, "该手机已经绑定过账号"));
	}
}

?>
