<?php

function generateFullTokenNew()
{
	//input account, password
	//veryfy account password
	//prepare $UID, $TIMESTAMP
	 if(func_num_args()==1)
	 {
	 $UID=func_get_arg(0);
	 $TIMESTAMP=time();
	
	 $tok = genShortTokenNew($UID,$TIMESTAMP);
	 $tok = $tok.genUIDChecksum($UID,$tok);
	 $tok = $tok.genTTLChecksum($tok);
	 $tok = $tok.genFullTokChecksum($tok);  
	 if(VerifyTokenNew($tok)==1) return $tok;
	 else return generateFullTokenNew($UID);
	 }
	 else return -1;
}

function genShortTokenNew()
{
	    $args = func_num_args();

    if( $args == 1)
    {
		return md5(func_get_arg(0));
    }
    elseif($args == 2 )
    {
		$INPUT_1 = str_split(md5(func_get_arg(0)));
		$INPUT_2 = str_split(md5(func_get_arg(1)));
		$var = "";
		for($i = 0; $i < 32; $i ++)
		{
			$var = $var.$INPUT_1[$i].$INPUT_2[$i];
		}	
			return $var;
    }
    elseif( $args > 2) 
    {
		$arr = array_fill(0,$args-1, null);
		$var="";
    		for ($i = 0; $i < func_num_args(); $i++) 
			{
				$arr[$i] = func_get_arg($i);
				$var = $var.md5(func_get_arg($i));
			}
		return $var;
    }
    else
    {
    		return md5(date(time()));
    }

}

function genUIDChecksum()
{
$_v_GLOBAL_UID_DIGIT = 8;
$_v_GLOBAL_TOKEN_SECTION_LENGTH = 8;
	if(func_num_args()==2)
	{
		$str=func_get_arg(1);
		$uid=func_get_arg(0);
		$var="";
		for($i=0;$i<$_v_GLOBAL_UID_DIGIT;$i++)
		{
			$var = $var.calTokenChecksum(substr($str,$i*$_v_GLOBAL_TOKEN_SECTION_LENGTH,$_v_GLOBAL_TOKEN_SECTION_LENGTH));
		}
			
		$var = $var+$uid;
		if($var>99999999) $var=$var-99999999;
		return $var;
		//return abs(99999999-intval($uid)-intval($var));
	}
	else
	{
	return -1;
	}
}

function genTTLChecksum()
{
$_v_GLOBAL_UID_DIGIT = 8;
$_v_GLOBAL_TOKEN_SECTION_LENGTH = 8;
$_v_GLOBAL_TTL_SECTION = 8;
	if(func_num_args()==1)
	{
		$str=func_get_arg(0);
		$var="";
		for($i=0;$i<$_v_GLOBAL_UID_DIGIT;$i++)
		{
			$var = $var.calTokenChecksum(substr($str,$i*$_v_GLOBAL_TOKEN_SECTION_LENGTH,$_v_GLOBAL_TOKEN_SECTION_LENGTH));
		}
		$tme=(int)(time()/100)+900;
		$cks = abs($var-$tme);
		if($cks < 10000000) $cks = "0".$cks;
		return $cks;
	}

}

function genFullTokChecksum()
{
	if( func_num_args() == 1)
	{
		$str=func_get_arg(0);
		$len=strlen($str);
		if($len>0)
		{
			$arr= str_split(strtoupper($str));
			$var=0;
			for($i=0;$i<$len;$i++)
			{
			   $var = $var + ord($arr[$i]) + intval($arr[$i]);
			}
			$rnd=rand(11,99);
			$vmd=$var%$rnd;
			if($vmd<10)
				return $rnd."0".$vmd;
			else
				return $rnd.$vmd;
		}
	}
	else
	{
		return -1;
	}
}

function calTokenChecksum()
{
	if( func_num_args() == 1)
	{
		$str=func_get_arg(0);
		$len=strlen($str);
		if($len>0)
		{
			$arr= str_split(strtoupper($str));
			$var=0;
			for($i=0;$i<$len;$i++)
			{
			   //$var=$var.",".$arr[$i]."=".ord($arr[$i]);
			   $var = $var + ord($arr[$i]) + intval($arr[$i]);
			}
			return 9-($var%10);
		}
	}
	else
	{
		return -1;
		}
}

function VerifyTokenNew()
{
	if( func_num_args() == 1)
	{
		$str=func_get_arg(0);
		$len=strlen($str)-4;
		if($len==80)
		{
			$arr= str_split(strtoupper(substr($str,0,$len)));
			$var=0;
			for($i=0;$i<$len;$i++)
			{
			   $var = $var + ord($arr[$i]) + intval($arr[$i]);
		        }	
			$rnd = (int)(substr($str,-4,2));
			$mod = (int)(substr($str,-2,2));
			if($var % $rnd == $mod) return 1;
			else return -1;

		}
		else
		{
			return -1;
		}
	}
	else
	{
		return -1;
	}
}

function calUidFromToken()
{

$_v_GLOBAL_UID_DIGIT = 8;
$_v_GLOBAL_TOKEN_SECTION_LENGTH = 8;
	if(func_num_args()==1)
	{
		$str=func_get_arg(0);
		$var="";
		for($i=0;$i<$_v_GLOBAL_UID_DIGIT;$i++)
		{
			$var = $var.calTokenChecksum(substr($str,$i*$_v_GLOBAL_TOKEN_SECTION_LENGTH,$_v_GLOBAL_TOKEN_SECTION_LENGTH));
		}	
		$cks=substr($str,$_v_GLOBAL_UID_DIGIT*$_v_GLOBAL_TOKEN_SECTION_LENGTH,$_v_GLOBAL_TOKEN_SECTION_LENGTH);
		return (intval($cks)-intval($var));
	}
	else
	{
	return -1;
	}
}

function calTTLFromToken()
{
/* length 8x8 + 8 + 8 */
$_v_GLOBAL_UID_DIGIT = 8;
$_v_GLOBAL_TOKEN_SECTION_LENGTH = 8;
$_v_GLOBAL_TTL_SECTION = 8;
	if(func_num_args()==1)
	{
		$str=func_get_arg(0);
		$var="";
		for($i=0;$i<$_v_GLOBAL_UID_DIGIT;$i++)
		{
			$var = $var.calTokenChecksum(substr($str,$i*$_v_GLOBAL_TOKEN_SECTION_LENGTH,$_v_GLOBAL_TOKEN_SECTION_LENGTH));
		}	
		//$cks=substr($str,$_v_GLOBAL_UID_DIGIT*$_v_GLOBAL_TOKEN_SECTION_LENGTH ,$_v_GLOBAL_TOKEN_SECTION_LENGTH );
		$cks = substr($str,72,8);
		return abs($var - $cks)*100;
	}
}


function generateToken()
{

 

    $password_len = 20;
    $password = '';

//    $word = 'abcdefghijklmnopqrstuvwxyz!@#$%^&*()-=ABCDEFGHIJKLMNPQRSTUVWXYZ<>;{}[]0123456789';
	$word = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789';
    $len = strlen($word);

    for ($i = 0; $i < $password_len; $i++) {
        $password .= $word[rand() % $len];
    }

    return $password;
}

function verifyToken($token) {
	$sql = "SELECT user_uid FROM access WHERE token='".$token."'";
	$result = query($sql);// or die("server error:".mysql_error());
	if($result==null)
		return false;
	else if($row=mysql_fetch_row($result)) {
		return $row[0];
	}
	else {
		return false;
	}
}

function verifyUserToken($token) {
	$sql = "SELECT user_uid FROM user_access WHERE token='".$token."'";
	$result = query($sql);// or die("server error:".mysql_error());
	if($result==null)
		return false;
	else if($row=mysql_fetch_row($result)) {
		return $row[0];
	}
	else {
		return -1;
	}
}

function getUserIdByMemberToken( $token) {
	$member_id = verifyToken( $token);
	
	$sql = "SELECT user_uid FROM user_access WHERE member_id='".$member_id."' order by issue desc limit 1";
	$result = query($sql);// or die("server error:".mysql_error());
	if($result==null)
		return false;
	else if($row=mysql_fetch_row($result)) {
		return $row[0];
	}
	else {
		return false;
	}
}

function getUserIdByMemberId($member_id) {
	
	$sql = "SELECT user_uid FROM user_access WHERE member_id='".$member_id."' order by issue desc limit 1";
	$result = query($sql);// or die("server error:".mysql_error());
	if($result==null)
		return false;
	else if($row=mysql_fetch_row($result)) {
		return $row[0];
	}
	else {
		return false;
	}
}

/*
function create_token($conn, $_user_uid) {
	// check for existing token and move to expired table
	$sql = "SELECT uid FROM access WHERE user_uid='".$_user_uid."'";
	$result = mysql_query($sql,$conn);
	if(mysqli_num_rows($result) > 0) {
		// insert to log/ table: do this later
		// delete the entry
		$sql = "DELETE FROM access WHERE user_uid='".$_user_uid."'";
		mysql_query($sql,$conn);
	}
	// generatel new token
	$_new_token = generatorToken();
	// write new token to DB
	$date2 = new DateTime("tomorrow");
	$sql = "INSERT INTO access (user_uid,token,expire) VALUES ('".$_user_uid."','".$_new_token."','".$date2->format('Y-m-d H:i:s')."')";
	$result = mysql_query($sql,$conn);//  or die('failed because '.mysql_error());
	// return the new token
	return $_new_token;
}
*/
?>
