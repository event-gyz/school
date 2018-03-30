<?php
/**
 * Created by PhpStorm.
 * User: guanyazhuo
 * Date: 2018/3/28
 * Time: 下午2:43
 */
header("Content-type: text/html; charset=utf-8");
if(!isset($_GET['code'])){
    $APPID='wxb87c1c8fcec6c6c2';
    echo $_SERVER["HTTP_REFERER"];exit;
    $REDIRECT_URI='http://colavia.com.cn/cn/getOpenId.php';
//    $scope='snsapi_base';
    $scope='snsapi_userinfo';
    $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state=wx'.'#wechat_redirect';
    header("Location:".$url);
}else{
    $appid = "wxb87c1c8fcec6c6c2";
    $secret = "bbd2828138fbd24fc5747ec370572fc0";
    $code = $_GET["code"];
    $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';
//    $ch = curl_init();
//    curl_setopt($ch,CURLOPT_URL,$get_token_url);
//    curl_setopt($ch,CURLOPT_HEADER,0);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//    $res = curl_exec($ch);
//    curl_close($ch);
    $res = file_get_contents($get_token_url);
    $json_obj = json_decode($res,true);
    //根据openid和access_token查询用户信息
    $access_token = $json_obj['access_token'];
    $openid = $json_obj['openid'];
    $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';

//    $ch = curl_init();
//    curl_setopt($ch,CURLOPT_URL,$get_user_info_url);
//    curl_setopt($ch,CURLOPT_HEADER,0);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//    $res = curl_exec($ch);
//    curl_close($ch);
    $res = file_get_contents($get_user_info_url);
    //解析json
    $user_obj = json_decode($res,true);
//    $_SESSION['user'] = $user_obj;
//    unset($_SESSION['user']);
    print_r($user_obj);
}