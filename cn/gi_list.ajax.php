<?php

include('inc.php');
//include_once("../inc/GrowIndex.class.php");

function output_li($uid, $text, $is_learned, $is_early, $is_late) {
	echo('<li'); 
	if($is_early)
		echo(' class="pass" ');
	elseif($is_late) {
		echo(' class="late" ');
	}
	echo('>');
	echo('<i><img src="../theme/cn/images/content/item_rep01.jpg"></i>');
	echo('<label>');
	echo('<input type="checkbox" class="ck" ');
	if($is_learned) {
		echo('checked');
	}
	echo('>');
	echo("<span>$text</span>");
	echo("</label>");
	echo('<div class="tablinks">');
	echo("<a name='$uid' value='0' href='javascript:void(0)'><img src='../theme/cn/images/content/item_rep02.jpg'></a>");
	echo("<a name='$uid' value='1' href='javascript:void(0)'><img src='../theme/cn/images/content/item_rep03.jpg'></a>");
	echo('</div>');
	echo('</li>');
}

$age_min = $_REQUEST['p1']; 
$age_max = $_REQUEST['p2'];
$user_uid = $_SESSION['CURRENT_KID_UID'];
$user_age = $_SESSION['CURRENT_KID_AGE'];

$sql = "SELECT grow_index.*, grow_log.log_time, grow_log.early FROM grow_index WHERE (grow_index.age_min >= '$age_min') AND (grow_index.age_max <= '$age_max') LEFT JOIN grow_log ON grow_log.item_uid=grow_index.uid and grow_log.user_uid='$user_uid'";

$result = query($sql);
$ret = array();
while($row = mysqli_fetch_array($result)) {
	if(isset($row['log_time'])) {
		$is_learned = true;		
	}
	else $is_learned = false;
	if(isset($row['early']) && $row['early']==true) {
		$is_early = true;
	}
	else $is_early = false;
	$item = array(
	'uid' => $row['uid'],
	'type' => $row['type'],
	'text' => $row['text'],
	'age_min' => $row['age_min'],
	'age_max' => $row['age_max'],
								'time' => $learned_time,
							'early' => $learned_early

	);
	$ret[] = $item;
}


?>