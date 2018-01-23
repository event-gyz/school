<?php
include_once("phpdemo_func.php");

//服务器参数设置

function send_message($phone,$code,$is_reset_password = false){
    $svr_url = 'http://112.74.76.186:8030/service/httpService/httpInterface.do';   // 服务器接口路径
    $svr_param = array();
    $svr_param['username'] = 'JSM42091';    // 账号
    $svr_param['password'] = 'uu1lmgir';    // 密码
    $svr_param['veryCode'] = 'q02zcet6g2er';    // 通讯认证Key
    $post_data = $svr_param;
    $post_data['method'] = 'sendMsg';
    $post_data['mobile'] = $phone;
    $post_data['content']= '@1@='.$code;
    $post_data['msgtype']= '2';             // 1-普通短信，2-模板短信
    $post_data['tempid'] = 'JSM42091-0001'; // 模板编号
    if($is_reset_password){
        $post_data['tempid'] = 'JSM42091-0002';// 重置密码模板
    }
    $post_data['code']   = 'utf-8';         // utf-8,gbk
    $res = request_post($svr_url, $post_data);  // 如果账号开了免审，或者是做模板短信，将会按照规则正常发出，而不会进人工审核平台
    $arr = xml_to_array($res);
    if($arr['sms']['mt']['status'] == 0){
        return true;
    }
    return false;
}
 
// 1、获得余额
 /*
    $post_data = $svr_param;
    $post_data['method'] = 'getAmount';
    $res = request_post($svr_url, $post_data);
    echo_xmlarr($res);

 */

// 2、发送即时普通短信
 /*

    $post_data = $svr_param;
    $post_data['method'] = 'sendMsg';
    $post_data['mobile'] = '******';
    $post_data['content']= '您好！您本次验证码为：1788，请勿告知他人';
    $post_data['msgtype']= '1';       // 1-普通短信，2-模板短信
    $post_data['code']   = 'utf-8';   // utf-8,gbk
    $res = request_post($svr_url, $post_data);  // 如果账号开了免审，或者是做模板短信，将会按照规则正常发出，而不会进人工审核平台
    echo_xmlarr($res);

 */

// 3、发送及时模板短信
//  短信模板管理中增加一个模板，编号为JSM40004-0000，内容为：尊敬的@1@你好,您在江苏美圣网站（www.jsmsxx.com），注册的手机验证码为@2@，请在验证页面及时输入。
//  成功发送后，收到的信息形如：尊敬的包先生你好,您在江苏美圣网站（www.jsmsxx.com），注册的手机验证码为874382，请在验证页面及时输入。
 
/*
    $post_data = $svr_param;
    $post_data['method'] = 'sendMsg';
    $post_data['mobile'] = '******';
    $post_data['content']= '@1@=1688';
    $post_data['msgtype']= '2';             // 1-普通短信，2-模板短信
    $post_data['tempid'] = '******'; // 模板编号
    $post_data['code']   = 'utf-8';         // utf-8,gbk
    $res = request_post($svr_url, $post_data);  // 如果账号开了免审，或者是做模板短信，将会按照规则正常发出，而不会进人工审核平台
    echo_xmlarr($res);
 */

// 4、获得状态报告
//  只能查询当天的，已获取的状态报告后续不会再获取
/*
    $post_data = $svr_param;
    $post_data['method'] = 'queryReport';
    $res = request_post($svr_url, $post_data);
    echo_xmlarr($res);
*/


// 5、获得上行短信
//  只能查询当天的，已获取的上行短信后续不会再获取
/*
    $post_data = $svr_param;
    $post_data['method'] = 'queryMo';
    $res = request_post($svr_url, $post_data);
    echo_xmlarr($res);
*/



?>