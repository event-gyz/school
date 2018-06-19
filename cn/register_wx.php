<?php
session_start();

include("inc.php");


if(!isset($_SESSION['wx_info']) || empty($_SESSION['wx_info'])){
    die(genResponse(false, "数据有误"));
}
$user_obj = $_SESSION['wx_info'];
if(empty($user_obj['openid'])){
    die(genResponse(false, "数据有误"));
}
$membership = time()+7776000;

$headimg = '"'.$user_obj['headimgurl'].'"';

$user_info_sql = 'select * from `member` where wx_openid="'.$user_obj['openid'].'"';
$user_info = M()->find($user_info_sql);
if(empty($user_info)){
	if(isset($_SESSION['agency_id']) && !empty($_SESSION['agency_id'])){
		$agency_id = $_SESSION['agency_id'];
	}else{
		$agency_id = 0;
	}

    $sql = "INSERT INTO member (password, nickname, city, image_url, wx_openid,membership,agency_id) VALUES (md5(lower('123456')),'".$user_obj['nickname']."','".$user_obj['city']."','".$headimg."','".$user_obj['openid']."',$membership,$agency_id)";
    $result = M()->execute($sql);
}



if($CMEMBER->login_wx($user_obj['openid']) == -1) {
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
