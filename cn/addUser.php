<?php
session_start();

include("inc.php"); 

$_nick_name = $_REQUEST['p1'];
$_gender = $_REQUEST['p2'];
$_birthday = $_REQUEST['p3'];
$_token = $_SESSION['user_token'];

if(empty($_nick_name)) {
	die(genResponse(false, '暱稱有误'));
}
else if(!isset($_gender) || empty($_birthday)) {
	die(genResponse(false, '输入资料有误'));
}
else if(empty($_token)) {
	echo(genResponse(false, '登入状态有误'));
}
else {
	$_first_name = "";
	$_last_name = "";
	$_image_url = "";
	
	if ($supervisor_uid = $CMEMBER->accessFromToken($_token)) {
		$kids_uid_array = $CMEMBER->getKidsUidArray();
		// 目前只支援ㄧ個小孩
		if(count($kids_uid_array) == 0) {
			$sql = "INSERT INTO user ".
				" (first_name,last_name,nick_name,gender,".
				" birth_day,image_url,supervisor_uid) VALUES ".
				" ('".$_first_name."','".$_last_name."','".
				$_nick_name."','".$_gender."','".$_birthday."','".
				$_image_url."','".$supervisor_uid."')";		
			$result = query($sql);
			if($result!=null) {
				$UID = mysql_insert_id();
			}
		}
		else {
			$UID = $kids_uid_array[0];
			$sql = "update user set nick_name='$_nick_name',gender='$_gender' where uid='$UID'";
			query($sql);
			$sql = "update user set birth_day='$_birthday' where uid='$UID'";
			query($sql);
			if(mysqli_affected_rows() > 0) {
				// clean user logs
				$sql = "delete from grow_log where user_uid='$UID'";
				query($sql);
			}
		}
		//if UID exist, means this user has been created.
		if(isset($UID)) {			
			$resp = '{"uid":"'.$UID.'"}';
			$_SESSION['CURRENT_KID_UID'] = $UID;
			echo(genResponse(true,$resp));
			// set cur user age session
			$birthday = new DateTime($_birthday);
			$diff = $birthday->diff(new DateTime());
			$months = $diff->format('%m') + 12 * $diff->format('%y');
			$days = $diff->format('%d');
			if($days >= 15)
				$months += 0.5;
			$user_age = $months;
			$_SESSION['CURRENT_KID_AGE'] = $user_age;
			$_SESSION['CURRENT_KID_NICKNAME'] = $_nick_name;
		}
		else {
			echo(genResponse(false, '数据添加失败'));
		}
	}else{
		echo(genResponse(false, '登入状态有误'));
	}
}
?>
