<?php
session_start();

include("inc.php"); 

$_ID = $_POST['p1'];
$_AUTH = $_POST['p2'];
$_PHONE = $_POST['p3'];
// 查询手机号和验证码
$select = "select  *  from message where phone ='{$_PHONE}' and message_code='{$_AUTH}' and status=0 ";
if(!query_result($select)){
    die(genResponse(false, "验证码错误"));
}

if(empty($_ID) || empty($_AUTH)) {
	die(genResponse(false, "请填写完整资料"));
}
else {
	// send email
	$log_file = "../log/send_forget_log".date("Y_m_d_H_i_s").".txt";
	$sql = "select uid,email from member where id='$_ID'";
	$row = M()->find($sql);
	if($row) {
		$uid = $row['uid'];
		$email = $row['email'];
                $update = "update member set password=md5(lower('".$_AUTH."')) where uid =".$row['uid'];
                if(query($update)){
                    // 更新手机验证码信息状态
                    $update ="update message set status=1 where phone ='{$_PHONE}' and message_code='{$_AUTH}'";
                    query($update);
                    echo(genResponse(true, "200 OK"));
                }
//		if(sendPwdResetEmail($uid,$email)){
//                    echo(genResponse(true, "200 OK"));
//                }
		else{
                    echo(genResponse(false, "重置失败，请稍后再试。"));  
                }
	}
	else {
		// response
		echo(genResponse(false, "无此帐号"));
	}
}

?>
