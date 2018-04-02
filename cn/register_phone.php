<?php
session_start();

include("inc.php"); 



$_PHONE = $_POST['p1'];
$_CODE = $_POST['p2'];

if(empty($_PHONE)) {
	die(genResponse(false, "请填写手机号"));
}
if(empty($_CODE)) {
	die(genResponse(false, "请填写验证码"));
}

// 查询手机号和验证码
$select = "select  *  from message where phone ='{$_PHONE}' and message_code='{$_CODE}' and status=0 ";
if(!query_result($select)){
	die(genResponse(false, "验证码错误"));
}
// 更新手机验证码信息状态
$update ="update message set status=1 where phone ='{$_PHONE}' and message_code='{$_CODE}'";
query($update);

$user_info_sql = 'select * from `member` where cellphone='.$_PHONE;
$user_info = M()->find($user_info_sql);
if(empty($user_info)){
	$sql = "INSERT INTO member (id,password,cellphone) VALUES ('".$_PHONE."',md5('123456'),'".$_PHONE."')";
	$result = M()->execute($sql);
}

if($CMEMBER->login_phone($_PHONE) == -1) {
	die(genResponse(false, $_v_ERROR_LOGIN_FAILED."(ER-000002)"));
};
$CMEMBER->getUserInfo();
$token = $CMEMBER->getUserToken();
$credit= $CMEMBER->credit;
if(isset($token)) {
	$email = '';
	if($CMEMBER->email){
		$email = $CMEMBER->email;
	}elseif($CMEMBER->cellphone){
		$email = $CMEMBER->cellphone;
	}elseif($CMEMBER->nickname){
		$email = $CMEMBER->nickname;
	}
	$arr = array(
		'token' => $token,
		'credit' => !empty($credit)?$credit:'',
		'email' => $email
	);

	$_SESSION['user_token'] = $token;
	$_SESSION['user_credit'] = $credit;
	$_SESSION['user_email'] = $email;
	$_SESSION['user_epaper'] = $CMEMBER->epaper;
	$sql = 'select * from `user` where supervisor_uid='.$CMEMBER->uid;
	$kid = M()->find($sql);
	$_SESSION['CURRENT_KID_BIRTH_DAY'] = $kid['birth_day'];
	$_SESSION['CURRENT_KID_UID'] = $kid['uid'];
	$_SESSION['CURRENT_KID_NICKNAME'] = $kid['nick_name'];
	$_birthday = $kid['birth_day'];
	$birthday = new DateTime($_birthday);
	$diff = $birthday->diff(new DateTime());
	$months = $diff->format('%m') + 12 * $diff->format('%y');
	$days = $diff->format('%d');
	if($days >= 15)
		$months += 0.5;
	$user_age = $months;
	$_SESSION['CURRENT_KID_AGE'] = $user_age;
	echo(genResponse(true, json_encode($arr)));
} else {
	echo(genResponse(false, $_v_ERROR_LOGIN_FAILED));
}

?>
