<?php
include("inc.php");
include("../inc/send_message.php"); 
// 发送验证码
if(isset($_POST['type']) && $_POST['type'] == "send"){
    $phone = $_POST['phone'];
    $code = rand(1000,9999);
    // 查询手机号是否注册
    $select = "select  *  from member where cellphone ='{$phone}' ";

    if(query_result($select)){
        die(genResponse(false, "手机号已注册"));
    }
    // 发送短信
    if(send_message($phone, $code)){
        $sql = "INSERT INTO message (phone, message_code,create_time) VALUES ('".$phone."','".$code."','".time()."')";
        if(query($sql)){
            die(genResponse(true, "发送成功"));
        }else{
            die(genResponse(false, "发送失败"));
        }
    }else{
        die(genResponse(false, "发送失败"));
    }
}

if(isset($_POST['type']) && $_POST['type'] == "vali"){
    $phone = $_POST['phone'];
    $code = $_POST['code'];
    // 查询手机号是否注册
    $select = "select  *  from message where phone ='{$phone}' and message_code='{$code}' ";

    if(!query_result($select)){
        die(genResponse(false, "验证码错误"));
    }
    die(genResponse(true, "验证成功"));
}

if(isset($_POST['type']) && $_POST['type'] == "forget"){
    $phone = $_POST['phone'];
    $code = rand(100000,999999);
    // 查询手机号是否注册
    $select = "select  *  from member where cellphone ='{$phone}' ";

    if(!query_result($select)){
        die(genResponse(false, "手机号未注册，请更换手机号"));
    }
    
    // 发送短信
    if(send_message($phone, $code)){
        $sql = "INSERT INTO message (phone, message_code,create_time) VALUES ('".$phone."','".$code."','".time()."')";
        if(query($sql)){
            die(genResponse(true, "发送成功"));
        }else{
            die(genResponse(false, "发送失败"));
        }
    }else{
        die(genResponse(false, "发送失败"));
    }
}

if(isset($_POST['type']) && $_POST['type'] == "login"){
    $phone = $_POST['phone'];
    $code = rand(1000,9999);

    // 发送短信
    if(send_message($phone, $code)){
        $sql = "INSERT INTO message (phone, message_code,create_time) VALUES ('".$phone."','".$code."','".time()."')";
        if(query($sql)){
            die(genResponse(true, "发送成功"));
        }else{
            die(genResponse(false, "发送失败"));
        }
    }else{
        die(genResponse(false, "发送失败"));
    }
}


if(isset($_POST['type']) && $_POST['type'] == "old"){
    $phone = $_POST['phone'];
    $code = rand(100000,999999);
    // 查询手机号是否注册
    $select = "select  *  from member where cellphone ='{$phone}' ";

    if(!query_result($select)){
        die(genResponse(false, "此手机没有绑定,请选择新用户进入"));
    }

    // 发送短信
    if(send_message($phone, $code)){
        $sql = "INSERT INTO message (phone, message_code,create_time) VALUES ('".$phone."','".$code."','".time()."')";
        if(query($sql)){
            die(genResponse(true, "发送成功"));
        }else{
            die(genResponse(false, "发送失败"));
        }
    }else{
        die(genResponse(false, "发送失败"));
    }
}
 
?>
