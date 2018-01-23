<?php
session_start();
include('inc.php');
	
$item_uid = $_REQUEST['p1'];
$is_learned = $_REQUEST['p2'];
$user_uid = $_SESSION['CURRENT_KID_UID'];	
$user_age = $_SESSION['CURRENT_KID_AGE'];

// TODO check params

// insert or delete
$sql = "SELECT age_min, age_max, type FROM grow_index WHERE uid='$item_uid'";
$result = query($sql);
if($row=mysqli_fetch_array($result)) {
	$age_min = $row['age_min'];
	$age_max = $row['age_max'];
	$type = $row['type'];	
	$ret = 0;	
	if(!$is_learned) {
		$is_late = ($user_age > $age_max);
		$sql = "DELETE FROM grow_log WHERE user_uid='$user_uid' AND item_uid='$item_uid'";
		$result = query($sql);
		$ret = mysqli_affected_rows();
		$arr = array('uid'=>$item_uid,'is_late'=>$is_late);//,'age_max'=>$age_max,'user_age'=>$user_age);
		die(genResponse($ret>0, json_encode($arr)));
	}
	else {
		$is_early = ($user_age < $age_min);
		$sql = "INSERT INTO grow_log (user_uid, item_uid, early,type) values ('$user_uid','$item_uid','$is_early','$type') on duplicate key update item_uid=item_uid";
		$result = query($sql);	
		$ret = mysqli_affected_rows();
		$arr = array('uid'=>$item_uid,'is_early'=>$is_early);
		die(genResponse($ret>0, json_encode($arr)));
	}
}

echo(genResponse(false,'Nothing changed.'));


?>