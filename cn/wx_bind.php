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
	$log_file = "../log/wx_bind_log".date("Y_m_d_H_i_s").".txt";
	$_token = $_SESSION['user_token'];
	$supervisor_uid = $CMEMBER->accessFromToken($_token);
	$sql = "select uid,email from member where cellphone='$_PHONE'";
	$row = M()->find($sql);
	//判断手机号是否绑定过微信
	if(!empty($row['wx_openid'])){
        die(genResponse(false, "该手机号已经绑定过微信，请修改手机号"));
	}
    $user_obj = $_SESSION['wx_info'];
    if(!isset($_SESSION['wx_info']) || empty($_SESSION['wx_info'])){
        die(genResponse(false, "数据有误"));
    }
    if(empty($user_obj['openid'])){
        die(genResponse(false, "数据有误"));
    }

	if(!$row) {
		$update = "update member set wx_openid='".$user_obj['openid']."' where uid =".$supervisor_uid;
		if(query($update)){
			// 更新手机验证码信息状态
			$update ="update message set status=1 where phone ='{$_PHONE}' and message_code='{$_AUTH}'";
			query($update);
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
                die(genResponse(true, json_encode($arr)));
            } else {
                die(genResponse(false, $_v_ERROR_LOGIN_FAILED));
            }
		}else{
            die(genResponse(false, "绑定失败，请稍后再试。"));
        }
	}
	else {
		// response
        die(genResponse(false, "该手机号已经绑定过账号"));
	}
}

?>
