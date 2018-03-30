<?php
session_start();

include("inc.php"); 

$beta=true;
if($beta)
{
	$_PHONE = $_REQUEST['p1'];
	$_CODE = $_REQUEST['p2'];
}
else
{
	$_PHONE = $_POST['p1'];
	$_CODE = $_POST['p2'];
}

if(!isset($_PHONE) || !isset($_CODE) ) {
	die(genResponse(false, $_v_ERROR_INVALID_PARAMETER."(ER-000001)"));
}
else {	
	if($CMEMBER->login_phone($_PHONE) == -1) die(genResponse(false, $_v_ERROR_LOGIN_FAILED."(ER-000002)"));
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
		$_SESSION['user_email'] = $CMEMBER->email;
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
}
?>
