<?php

/* Change the defination of the site */
$https=false;
$beta=true;
$Language="cn";

$_v_DEV = true;
$_v_ENABLE_LANG = false;

$_v_SITE_NAME="SunnySchool";
$_v_HTTP="http://";
if($https)
{
	$_v_HTTP="https://";
}
$_v_SITE_ADDRESS=$_v_HTTP."101.227.63.143/sunnyschool";
$_v_SITE_DOMAIN="sunnyschool.tv";

if($beta)
{
	$_v_SITE_ADDRESS=$_v_HTTP."101.227.63.143/sunnyschool";
 	$_v_SITE_DOMAIN="101.227.63.143/sunnyschool";
}

$_v_SITE_WWW=$_v_SITE_ADDRESS;//$_v_HTTP."www.".$_v_SITE_DOMAIN;

$_v_RESOURCE_COVER_IMAGE_PATH="/Resource/store/covers/small/";
$_v_RESOURCE_ICON_IMAGE_PATH="/Resource/store/icons/";
$_ROOT_DIR = "/var/www/kidsdna_store/sunnyschool";

$_v_VERIFY_MAIL_SUBJECT="晴天学园 Email 地址验证";
//"Telly Bear Registration Verification";
$_v_VERIFY_MAIL_FROM="registration@cn.kidsdna.org";
//service@family.tellybear.co";
$_v_VERIFY_MAIL_FROM_FULL_NAME="晴天学园";
$_v_VERIFY_MAIL_BODY="亲爱的客户您好：

    欢迎您成为晴天学园用户。
    您的晴天学园开通序号是：8888
    请将序号输入至晴天学园注册序号栏位上。

谢谢您
晴天学园团队敬上";

$_v_CHANGE_PASSWORD_MAIL_SUBJECT="晴天学园 密码变更通知函";
$_v_CHANGE_PASSWORD_MAIL_FROM="registration@cn.kidsdna.org";
$_v_CHANGE_PASSWORD_MAIL_FROM_FULL_NAME="iQPad Customer Service";
$_V_CHANGE_PASSWORD_MAIL_BODY="亲爱的客户您好：

        您的密码变更为 %s
        
谢谢您
晴天学园团队敬上";        

$_w_SITE_CHAR_NAME="SunnySchool";
$_w_SITE_FAMILY_NAME="SunnySchool";



//folloing var should keep still

$_v_GLOBAL_UID_DIGIT = 8;
$_v_GLOBAL_TOKEN_SECTION_LENGTH = 8;

//current token Time To Live setting = 86400 seconds = 1 day
$_v_TTL=86400;
$_v_STORY_DOWNLOAD_COUNT = 1;
//default value for ProductID
$_v_DEFAULT_APPSYSTEM_PRODUCTID = "APPSYSTEM01";

$_v_ERROR_LOGIN_FAILED 		= "Login Failed";
$_v_ERROR_ADDUSER_FAILED 	= "User already existed";
$_v_ERROR_REGISTER_FAILED 	= "註冊失敗";
$_v_ERROR_INVALID_USER 		= "User Not Existed";
$_v_ERROR_INVALID_PARAMETER 	= "Invalid Parameter";
$_v_ERROR_INVALID_TOKEN 	= "Access denied, please sign in again";
$_v_ERROR_EMPTY_TOKEN		= "Access failed, please sign in again";
$_v_ERROR_EXPIRED_TOKEN		= "Login expired, please sign in again";
$_v_ERROR_INVALID_PRODUCTID 	= "Invalid PRODUCT ID";
$_v_ERROR_ALREADY_PURCHASED	= "You already have this book";



function list_image_options($type, $default)
{
	global $_v_RESOURCE_COVER_IMAGE_PATH;
	global $_v_RESOURCE_ICON_IMAGE_PATH;
	global $_ROOT_DIR;
        $root_dir = $_ROOT_DIR;
        if($type=="cover")
                $dir = dir($root_dir.$_v_RESOURCE_COVER_IMAGE_PATH);
        elseif($type=="icon")
                $dir = dir($root_dir.$_v_RESOURCE_ICON_IMAGE_PATH);

        echo "<option>"; 
        $dirFiles = array();
        while (($file = $dir->read()) !== false) {
                if(strcmp($file, ".")==0 || strcmp($file,"..")==0 || strcmp($file,".svn")==0)
                        continue;
                $dirFiles[] = $file;
        }
        $dir->close();
        sort($dirFiles);
        foreach($dirFiles as $file) {
                echo "<option value='".$file."'";
                if($file == $default) echo "selected";
                echo ">".$file."</option>";
        }
}




function list_age_options($default)
{
        $cnt=0;
        for($yy = 3; $yy<=6 ; $yy++)
        {
                for($mm = 0; $mm<12 ; $mm++)
                {
			if($mm<10)$value= $yy.".0".$mm;
			else $value = $yy.".".$mm;
                        echo "<option value='".$value."'";
			if($value == $default) echo "selected";
			echo ">". $yy." 歲 ".$mm." 月 ";
                        $cnt++;
                        if($cnt > 42) break;
                }
        }
}

function parse_age_to_yymm($age)
{
	$yy = (int)($age);
	$mm = (int)(($age*100) %100);
	echo $yy." 歲 ".$mm." 月 ";
}

?>
