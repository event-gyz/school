<?php
session_start();

include("inc.php"); 

$_EMAIL = $_POST['p1'];
$_PASS 	= $_POST['p2'];
$_AUTH = $_POST['p3'];
$_PHONE = $_POST['p4'];
$_birthday = $_POST['p5'];
$_gender = $_POST['p6'];
$_nickname = $_POST['p7'];

// 查询手机号和验证码
$select = "select  *  from message where phone ='{$_PHONE}' and message_code='{$_AUTH}' and status=0 ";
if(!query_result($select)){
    die(genResponse(false, $_v_ERROR_REGISTER_FAILED."，请获取验证码"));
}
// 更新手机验证码信息状态
$update ="update message set status=1 where phone ='{$_PHONE}' and message_code='{$_AUTH}'";
query($update);

if(empty($_EMAIL) || empty($_PASS) || empty($_AUTH)) {
	die(genResponse(false, $_v_ERROR_REGISTER_FAILED."，请填写完整资料"));
}
else {
	$CMEMBER->resetCuser();
	if($CMEMBER->exist( $_EMAIL ))   die(genResponse(false, $_v_ERROR_REGISTER_FAILED."，此帐号已存在"));
	elseif($CMEMBER->register( $_EMAIL, $_PASS, '', '', $_PHONE ))
	{
            $member_id = mysqli_insert_id();
		$CMEMBER->getUserInfo();
                $token = $CMEMBER->getUserToken();
		$credit= $CMEMBER->credit;
		tlog("REGISTER> ".$_EMAIL." > UID = ".$CMEMBER->uid);
                // 加入宝宝信息
                $supervisor_uid = $CMEMBER->accessFromToken($token);
                $sql = "INSERT INTO user (first_name,last_name,nick_name,gender,birth_day,image_url,supervisor_uid) VALUES (' ',' ','".$_nickname."','".$_gender."','".$_birthday."',' ','".$supervisor_uid."')";		
		$result = query($sql);
                if($result == null) {
                    $sql = "delete from member where uid=".$CMEMBER->uid;
                    query($sql);
                    die(genResponse(false, $_v_ERROR_REGISTER_FAILED."，注册失败"));
                }
	}
	else 
	{
		die(genResponse(false, "$_v_ERROR_REGISTER_FAILED.(系统错误)"));
		tlog("REGISTER FAILED> ".$_EMAIL);
	}	
	if(isset($token)) {

		$arr = array(
			'token' => $token,
			'credit' => $credit,
			'email' => $CMEMBER->email
		);

		$_SESSION['user_token'] = $token;
		$_SESSION['user_credit'] = $credit;
		$_SESSION['user_email'] = $CMEMBER->email;

// KidsDNA 決定不要激活帳號功能
		echo(genResponse(true, json_encode($arr)));
/*
		// send verification email
		if(sendVerifyEmail($_EMAIL))
			echo(genResponse(true, json_encode($arr)));
		else
			echo(genResponse(false, $_v_ERROR_REGISTER_FAILED."(郵件错误)"));
*/
	}
	else {
		echo(genResponse(false, $_v_ERROR_REGISTER_FAILED."(系统错误)"));
	}
}
?>
