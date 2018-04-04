<?php
session_start();

include("inc.php");
/**
 * Created by PhpStorm.
 * User: guanyazhuo
 * Date: 2018/3/28
 * Time: 下午2:43
 */
header("Content-type: text/html; charset=utf-8");
if(!isset($_GET['code'])){
    $APPID='wxb87c1c8fcec6c6c2';
    $REDIRECT_URI='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
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
    $user_info_sql = 'select * from `member` where wx_openid="'.$user_obj['openid'].'"';
    $user_info = M()->find($user_info_sql);
    if(empty($user_info)){
        $membership = time()+3888000;

        $headimg = '"'.$user_obj['headimgurl'].'"';
        $sql = "INSERT INTO member (password, nickname, city, image_url, wx_openid,membership) VALUES (md5(lower('123456')),'".$user_obj['nickname']."','".$user_obj['city']."','".$headimg."','".$user_obj['openid']."',$membership)";
//        $user_obj['province'].
        $result = M()->execute($sql);
    }

    if($CMEMBER->login_wx($user_obj['openid']) == -1) die(genResponse(false, $_v_ERROR_LOGIN_FAILED."(ER-000002)"));
    $CMEMBER->getUserInfo();
    $token = $CMEMBER->getUserToken();
    $credit= $CMEMBER->credit;
    if(isset($token)) {
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
        header("Location:/");
    } else {
        echo(genResponse(false, $_v_ERROR_LOGIN_FAILED));
    }
}