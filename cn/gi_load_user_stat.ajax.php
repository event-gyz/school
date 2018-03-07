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

// late
$sql = "select count(*) as late_count from grow_index where age_max < '$user_age' and uid not in (select item_uid from grow_log where user_uid='$uid')";
$row = M()->find($sql);
if($row['late_count']) {
	$late_count = $row['late_count'];
}else{
    $late_count = 0;
}
// early
$sql = "select count(*) as early_count from grow_log where user_uid='$uid' and early=1";
$row = M()->find($sql);
if($row['early_count']) {
	$early_count = $row['early_count'];
}else{
    $early_count = 0;
}
// all learned
$sql = "select count(*) as all_count from grow_log where user_uid='$uid'";
$row = M()->find($sql);
if($row['all_count']) {
	$all_count = $row['all_count'];
}else{
    $all_count = 0;
}
$arr = array('nickname'=>$nickname,'all'=>$all_count,'early'=>$early_count,'late'=>$late_count);
echo(json_encode($arr));
/*
echo('
	<h3>'.$nickname.'<b>进度记分板</b></h3>
	<ul class="clearfix">
        <li><b>完成项目</b><i>'.$all_count.'<small>/1200</small></i></li>
        <li><b>提前奖章</b><i>'.$early_count.'<small>枚</small></i></li>
        <li><b>落后项目</b><i>'.$late_count.'<small>项</small></i></li>
    </ul>
');
*/

?>