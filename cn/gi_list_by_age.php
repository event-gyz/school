<?php
session_start();
include('inc.php');	

function fetchContent($age, $type, $func) {
	global $cur_li_count;
	$htmlString = "";
	$user_uid = $_SESSION["CURRENT_KID_UID"];
	$end_age = ceil($age/12)*12;
	$start_age = intval($age/12)*12;
//	$end_age = $age;
	$sql = "select grow_index.uid,grow_index.text,grow_index.age_max,grow_index.age_min,grow_log.early from grow_index LEFT JOIN grow_log on grow_log.item_uid=grow_index.uid and grow_log.user_uid='$user_uid' where grow_index.age_min <= '$start_age' and grow_index.age_max <= '$end_age' and grow_index.type='$type' ";
	$resule = M()->select($sql);
	$li_count = 0;
	foreach($resule as $row){
		$uid = $row["uid"];
		$text = $row["text"];
		$age_max = $row["age_max"];
		$early = $row["early"];
		$checked = isset($row['early']);
		if(($func == 'b' && $checked) || ($func == 'c' && !$checked))
			continue;

		$htmlString .= ('<li id="gi_'.$uid.'"');

		if(isset($early)) {
			if($early==true) {
				$htmlString .= (' class="pass" ');
			}
		}
		else if($age_max < $_SESSION['CURRENT_KID_AGE']) {
			$htmlString .= (' class="out" ');
		}
//		if($li_count > 4)
//			$htmlString .= (' style="display:none;" ');

		$htmlString .= '>';
		$htmlString .= '<i><img src="../theme/cn/images/content/item_rep01.jpg"></i>
	                <p>
	                    <input type="checkbox" class="ck" value="'.$uid.'"';
	    if($checked) $htmlString .= (' checked ');
	    $htmlString .= '>
	                    <span>'.$text.'</span>
	                </p>
	                <div class="tablinks">
	                	<a name="'.$uid.'" value="0" href="javascript:void(0)"><img src="../theme/cn/images/content/item_rep02.jpg"></a>
	                    <a name="'.$uid.'" value="1" href="javascript:void(0)"><img src="../theme/cn/images/content/item_rep03.jpg"></a>
	            	</div>
	            </li>';
	    $li_count++;
	}
	$cur_li_count = $li_count;
	return $htmlString;
}

function echo_start() {
    echo('<tr><td width="65%"><ul class="clearfix">');
}

function echo_end() {
	echo('
	        </ul>
	    </td>
	</tr>
	');
}

/**********************
 * 
 * MAIN PROCESS
 *
**********************/
$user_age = $_SESSION['CURRENT_KID_AGE'];
$func = @$_REQUEST['f'];
$type = $_REQUEST['t'];
//$age = $page /2.0 - 0.5;
$age = $user_age;
$cur_li_count = 0;
if(($user_age) > 72) {
	exit();
}

	$li = fetchContent($age, $type, $func);
		echo_start($age, $type, $type==0);
		if(strlen($li) > 0)
			echo($li);
		else
			echo('<li> - - </li>');
		echo_end();
?>
