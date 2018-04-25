<?php
session_start();

include("inc.php"); 



$_PHONE = $_POST['p1'];
$_CODE = $_POST['p2'];

$parts = parse_url($_SERVER['HTTP_REFERER']);
$uid = (int)str_replace('uid=','',$parts['query']);

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
    $membership = time()+15552000;
	$sql = "INSERT INTO member (id,password,cellphone,membership) VALUES ('".$_PHONE."',md5('123456'),'".$_PHONE."',$membership)";
	$result = M()->execute($sql);
    if($result){
        if(!empty($uid)){
            $update = "update member set membership=membership+3888000 where uid =".$uid;
            query($update);
        }
    }
}

die(genResponse(true, "注册成功"));

?>
