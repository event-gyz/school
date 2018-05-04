<?php
session_start();

include('inc.php');
//include_once("../inc/GrowIndex.class.php");

$uid = $_SESSION['CURRENT_KID_UID'];
if(	!isset($_SESSION['CURRENT_KID_NICKNAME'])
	||!isset($_SESSION['CURRENT_KID_AGE'])
) {
	$sql = " select nick_name, birth_day from user where uid = '$uid'";
	$result = query($sql);
	if($row = mysqli_fetch_object($result)) {
		// find age in months
		$birthday = new DateTime($row->birth_day);
		$diff = $birthday->diff(new DateTime());
		$months = $diff->format('%m') + 12 * $diff->format('%y');
		$days = $diff->format('%d');
		if($days >= 15)
			$months += 0.5;
		$user_age = $months;
		$nickname = $row->nick_name;
		$_SESSION['CURRENT_KID_AGE'] = $user_age;
		$_SESSION['CURRENT_KID_NICKNAME'] = $nickname;
	}	
}
else {
	$user_age = $_SESSION['CURRENT_KID_AGE'];
	$nickname = $_SESSION['CURRENT_KID_NICKNAME'];
}


$user_age = $_SESSION['CURRENT_KID_AGE'];
$start_age = $user_age-1;
$end_age = $user_age+1;
$user_uid = $_SESSION["CURRENT_KID_UID"];

//fina
$sql = "select count(*) as cc from grow_index left join grow_log as log on log.item_uid=grow_index.uid where ((grow_index.age_min >= '$start_age' and grow_index.age_min<= '$end_age') or (grow_index.age_max <= '$end_age' and grow_index.age_max >= '$start_age')) and user_uid=$user_uid";
$res = M()->find($sql);
if(empty($res)){
    $res['cc'] = 0;
}
//all
$sql = "select count(*) as cc from grow_index where ((grow_index.age_min >= '$start_age' and grow_index.age_min<= '$end_age') or (grow_index.age_max <= '$end_age' and grow_index.age_max >= '$start_age'))";
$re = M()->find($sql);
if(empty($re)){
    $re['cc'] = 0;
}

$sql = "select count(DISTINCT grow_index.uid) as cc from grow_index left join grow_log on grow_index.uid = grow_log.item_uid where grow_index.age_max <= '$start_age' and( grow_log.user_uid != $user_uid or grow_log.uid is null)";
//        echo $sql;
$late = M()->find($sql);
if(empty($late)){
    $late['cc'] = 0;
}
$arr = array('nickname'=>$nickname,'all'=>$re['cc'],'fina'=>$res['cc'],'late'=>$late['cc']);
echo(json_encode($arr));


?>