<?php 

$__enc_dec__the_key__ = "IRmheURTXztxOeKF";

function my_encrypt($text) {
        return trim(base64_url_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $__enc_dec__the_key__, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}

function my_decrypt($text) {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $__enc_dec__the_key__, base64_url_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

function base64_url_encode($input)
{
    return strtr(base64_encode($input), '+/=', '-_,');
}
 
function base64_url_decode($input)
{
    return base64_decode(strtr($input, '-_,', '+/='));
}

function generateVerifyToken()
{
    $password_len = 8;
    $password = '';

	$word = '0123456789';
    $len = strlen($word);

    for ($i = 0; $i < $password_len; $i++) {
        $password .= $word[rand() % $len];
    }

    return $password;
}

function sendVerifyEmail($_ID) {
	global $_v_VERIFY_MAIL_SUBJECT,$_v_SITE_WWW,$_v_VERIFY_MAIL_FROM_FULL_NAME,$_v_VERIFY_MAIL_FROM;

	$action = "verify";
	$ver_code = generateVerifyToken();
	$payload = my_encrypt($action."|".$_ID."|".$ver_code);
	
	$url_string = $_v_SITE_WWW."/cn/index.php?t=".$payload;
	// write new token to DB
	$sql = "INSERT INTO reg_verify (member_id,ver_code) VALUES ('$_ID','$ver_code') ON DUPLICATE KEY UPDATE ver_code='$ver_code'";
	$result = query($sql);
	if($result) {
		$to = $_ID;
		$subject = $_v_VERIFY_MAIL_SUBJECT; //信件標題 
//		$msg = "亲爱的客户您好：\n\n欢迎您成为晴天学园用户。\n请点击下列连结以验证您的晴天学园帐号地址:\n\n$url_string\n\n谢谢您\n晴天学园团队敬上";
$msg = "Email 地址验证

$_ID 您好，
这封信是由 晴天学园 发送的。

您收到这封邮件，是由于在晴天学园进行了新会员注册，或会员修改Email 使用了这个信箱。如果您并没有访问过晴天学园，或没有进行上述操作，请忽略这封邮件。您不需要退订或进行其他进一步的操作。


----------------------------------------------------------------------
帐号激活说明
----------------------------------------------------------------------

如果您是晴天学园的新会员，或在修改您的注册Email 时使用了本地址，我们需要对您的地址有效性进行验证以避免垃圾邮件或地址被滥用。

您只需点击下面的连接即可激活您的帐号：
$url_string
(如果上面不是连接形式，请将该地址手工粘贴到浏览器地址栏再访问)

感谢您的访问，祝您使用愉快！

此致
晴天学园 管理团队.
http://www.sunnyschool.tv/";
		$email_from = $_v_VERIFY_MAIL_FROM;
		$full_name = $_v_VERIFY_MAIL_FROM_FULL_NAME;
		$from = $full_name.'<'.$email_from.'>';
		$headers = 'From: ' . $from . "\r\nReply-To: $from";

		if(mail($to, $subject, $msg, $headers))
			return true;
	}
	return false;
}

function sendEpaperEmail($uid, $email,$msg) {
	global $_v_VERIFY_MAIL_SUBJECT,$_v_SITE_WWW,$_v_VERIFY_MAIL_FROM_FULL_NAME,$_v_VERIFY_MAIL_FROM;
//	$url_string_1 = $_v_SITE_WWW."/cn/index.php?action=epaper&t=".$payload;
//	$url_string_2 = $_v_SITE_WWW."/cn/index.php?action=train&t=".$payload;
//	$url_base = $_v_SITE_WWW."/content/epaper/";

	$action = "epaper";
	$ver_code = generateFullTokenNew($uid);
	$payload = my_encrypt($action."|".$email."|".$ver_code);
	$url_string_1 = $_v_SITE_WWW."/cn/index.php?t=".$payload;
	$msg = str_replace("[EP_LINK]",$url_string_1,$msg);
	
	$today = date("Y/m/d");   
	$to = $email;
	$subject = "晴天学园会员电子报"; 

	$email_from = $_v_VERIFY_MAIL_FROM;
	$full_name = $_v_VERIFY_MAIL_FROM_FULL_NAME;
	$from = $full_name.'<'.$email_from.'>';
	$headers = "Content-type: text/html; charset=$sCharset\r\n" .'From: ' . $from . "\r\nReply-To: $from";

//echo($msg);

	if(mail($to, $subject, $msg, $headers))
		return true;
	else	
		return false;
}


function sendPwdResetEmail($uid,$_ID) {
	global $_v_VERIFY_MAIL_SUBJECT,$_v_SITE_WWW,$_v_VERIFY_MAIL_FROM_FULL_NAME,$_v_VERIFY_MAIL_FROM;
	
	$ver_code = generateVerifyToken();
	
	$sql = "INSERT INTO reset_password (member_id,code) VALUES ('$_ID','$ver_code') ON DUPLICATE KEY UPDATE code='$ver_code'";
	$result = query($sql);
	if($result) {
		$token = generateFullTokenNew($uid);
		$cur_date = date("YmdHis");
		$cur_date_formatted = date("Y-m-d H:i:s");
		$payload = my_encrypt("resetpw|".$cur_date."|".$ver_code."|".$token);	
		$url_string = $_v_SITE_WWW."/cn/index.php?t=".$payload;
		$to = $_ID;
		$subject = "晴天学园密码重设邮件";
		$msg = "
	亲爱的会员您好：
	
	您在 $cur_date_formatted 提交找回密码的请求，请点选下方连结设定新的密码，
	完成即可使用新密码登入会员。
	$url_string
	(该连结24小时内有效，并且仅可以使用一次！若同时收到多封验证信件，请以最新信件之验证码为主。)
	
	提醒您：如信件被归类为垃圾信，会造成连结失效，请将其移至收件匣后再尝试。如果您没有要求设置新密码，请您忽略本邮件，您的密码将维持不变。
		
	感谢您的访问，祝您使用愉快！
	
	此致
	晴天学园 管理团队.
	http://www.sunnyschool.tv/";
	
		$email_from = $_v_VERIFY_MAIL_FROM;
		$full_name = $_v_VERIFY_MAIL_FROM_FULL_NAME;
		$from = $full_name.'<'.$email_from.'>';
		$headers = 'From: ' . $from . "\r\nReply-To: $from";
	
		if(mail($to, $subject, $msg, $headers))
			return true;
	}

	return false;
}


?>
