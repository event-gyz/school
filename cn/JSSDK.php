<?php
class JSSDK
{
    private $appId;
    private $appSecret;

    public function __construct($appId='wxb87c1c8fcec6c6c2', $appSecret='bbd2828138fbd24fc5747ec370572fc0') {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();
        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        $data = isset($_SESSION['wx_jsapi_ticket'])?$_SESSION['wx_jsapi_ticket']:'';
        $jsapi_ticket_time = isset($_SESSION['wx_jsapi_ticket_time'])?$_SESSION['wx_jsapi_ticket_time']:'';
        if (!empty($data) && (time()-$jsapi_ticket_time<7000)) {
            $ticket = $data;
        } else {
            $accessToken = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $_SESSION['wx_jsapi_ticket'] = $ticket;
                $_SESSION['wx_jsapi_ticket_time'] = time();
            }
        }

        return $ticket;
    }

    private function getAccessToken() {
        $data = isset($_SESSION['wx_access_token'])?$_SESSION['wx_access_token']:'';
        $wx_access_token_time = isset($_SESSION['wx_access_token_time'])?$_SESSION['wx_access_token_time']:'';
        if (!empty($data) && (time()-$wx_access_token_time<7000)) {
            $access_token = $data;
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
//                $this->redis->setEx("wx_access_token", 7000, $access_token);
                $_SESSION['wx_access_token'] = $access_token;
                $_SESSION['wx_access_token_time'] = time();
            }
        }
        return $access_token;
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }
}
?>
