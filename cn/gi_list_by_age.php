<?php
session_start();
include('inc.php');	

function fetchContent($age, $type, $func) {
	global $cur_li_count;
	$htmlString = "";

	$a_name = $type.'_'.str_replace(".","_",$age);

	$user_uid = $_SESSION["CURRENT_KID_UID"];
	
	$sql = "select grow_index.uid,grow_index.text,grow_index.age_max,grow_log.early from grow_index LEFT JOIN grow_log on grow_log.item_uid=grow_index.uid and grow_log.user_uid='$user_uid' where grow_index.age_min <= '$age' and grow_index.age_max >= '$age' and grow_index.type='$type' ";
	
	$result = query($sql);
	$li_count = 0;
	while($row=mysqli_fetch_array($result)) {
		$uid = $row["uid"];
		$text = $row["text"];
		$age_max = $row["age_max"];
		$early = $row["early"];
		$checked = isset($row['early']);

		if(($func == 'b' && $checked) || ($func == 'c' && !$checked))
			continue;
			
		if($li_count > 4)	
			$htmlString .= ('<li name="'.$a_name.'" id="gi_'.$uid.'"');
		else 
			$htmlString .= ('<li id="gi_'.$uid.'"');
/*
		if(isset($early)) {
			if($early==true) {
				if($li_count > 4)
					$htmlString .= (' class="passmore" ');
				else 
					$htmlString .= (' class="pass" ');				
			}
		}
		else if($age_max < $_SESSION['CURRENT_KID_AGE']) {
			$htmlString .= (' class="out" ');
			if($li_count > 4)
				$htmlString .= (' class="outmore" ');
			else 
				$htmlString .= (' class="out" ');
		}
		else {
			if($li_count > 4)
				$htmlString .= (' class="more" ');
		}
*/
		if(isset($early)) {
			if($early==true) {
				$htmlString .= (' class="pass" ');				
			}
		}
		else if($age_max < $_SESSION['CURRENT_KID_AGE']) {
			$htmlString .= (' class="out" ');
		}
		if($li_count > 4)
			$htmlString .= (' style="display:none;" ');

		$htmlString .= ('>');
		$htmlString .= ('<i><img src="../theme/cn/images/content/item_rep01.jpg"></i>
	                <label>
	                    <input type="checkbox" class="ck" value="'.$uid.'"');
	    if($checked) $htmlString .= (' checked ');        
	    $htmlString .= ('>
	                    <span>'.$text.'</span>
	                </label>
	                <div class="tablinks">
	                	<a name="'.$uid.'" value="0" href="javascript:void(0)"><img src="../theme/cn/images/content/item_rep02.jpg"></a>
	                    <a name="'.$uid.'" value="1" href="javascript:void(0)"><img src="../theme/cn/images/content/item_rep03.jpg"></a>
	            	</div>
	            </li>');
	    $li_count++;
	}	
	$cur_li_count = $li_count;
	return $htmlString;
}

function echo_start($age, $type, $first) {
	global $cur_li_count;
	
	$type_names = array('语言','社交','粗大动作','细微动作','认知','自我帮助');
	$age_top = $age+0.5;
	$a_name = $type.'_'.str_replace(".","_",$age);

	if($first) {
		echo('<tr><th width="18%" rowspan="6"><div>');
		if($age == $_SESSION['CURRENT_KID_AGE'])
		echo('目前年龄');
		echo('<b>'.$age.'个月</b>~'.$age_top.'个月</div></th><td width="17%" class="title"><div>'.$type_names[$type]);
		if($cur_li_count > 5)
			echo('<a id="'.$a_name.'" href="javascript:showMoreInList(\''.$a_name.'\');">[+]</a>');
		echo('</div></td><td width="65%"><ul class="clearfix">');
	}	
	else {
		echo('<tr><td class="title"><div>'.$type_names[$type]);
		if($cur_li_count > 5)
			echo('<a id="'.$a_name.'" href="javascript:showMoreInList(\''.$a_name.'\');">[+]</a>');
		echo('</div></td><td><ul class="clearfix">');
	}
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
$page = $_REQUEST['p']; 
$func = $_REQUEST['f']; 
$age = $page /2.0 - 0.5;
$cur_li_count = 0;

if(($user_age+$age) > 72) {
	exit();
}

if(isset($user_age)) {// && $func!='b') {
	if($user_age > 0.5)
		$user_age -= 0.5;
	$age += $user_age;	
}

$age_top = $age+0.5;
for($i = 0; $i < 6; $i++) {
	$li = fetchContent($age, $i, $func);
//	if(strlen($li) > 0) {
		echo_start($age, $i, $i==0);
		if(strlen($li) > 0)
			echo($li);
		else
			echo('<li> - - </li>');
		echo_end();	
//	}
}
?>
