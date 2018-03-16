<?php
session_start();
include('inc.php');	

function fetchContent($age, $type, $func,$e) {
	global $cur_li_count;
	$htmlString = "";
	$user_uid = $_SESSION["CURRENT_KID_UID"];
	$start_age = $age-1;
	$end_age = $age+5;
	if(!empty($e) && ($start_age>=12)){
		$start_age -=12;
	}
    $sql = "select grow_index.uid,grow_index.text,grow_index.age_max,grow_index.age_min from grow_index where ((grow_index.age_min >= '$start_age' and grow_index.age_min<= '$end_age') or (grow_index.age_max <= '$end_age' and grow_index.age_max >= '$start_age')) and grow_index.type='$type' order by uid asc";
    $sql2 = "select early ,user_uid,item_uid from grow_log where user_uid=$user_uid";
    $resule = M()->select($sql);
    $result2 = M()->select($sql2);
    $a = array_column($result2,'early');
    $b = array_column($result2,'item_uid');
    $c = array_combine($b,$a);
    foreach($resule as &$value){
        $uid =$value['uid'];
        if(isset($c[$uid])){
            $value['early'] = $c[$uid];
        }else{
            $value['early'] = '';
        }
    }

//    echo '<pre>';print_r($resule);exit;
	$li_count = 0;
	foreach($resule as $row){
		$uid = $row["uid"];
		$text = $row["text"];
		$age_max = $row["age_max"];
        $age_min = $row["age_min"];
		$early = $row["early"];
		$checked = ($row['early']!='');
		if(($func == 'b' && $checked) || ($func == 'c' && !$checked))
			continue;

		$htmlString .= ('<li id="gi_'.$uid.'"');

		if(isset($early) && $early!='') {
			if($early) {
				$htmlString .= (' class="pass" ');
			}
		}
		else if($age_max < $_SESSION['CURRENT_KID_AGE']) {
			$htmlString .= (' class="out" ');
		}
//		if($li_count > 4)
//			$htmlString .= (' style="display:none;" ');
		$htmlString .= '>';
		$htmlString .= '<i><img src="../theme/cn/images/content/item_rep01.jpg"></i><p style="float:left">
	                    <input type="checkbox" class="new_ck" value="'.$uid.'"';
	    if($checked) $htmlString .= (' checked ');
	    $htmlString .= '>'.$age_min.'月-'.$age_max.'月</p><div class="detail">
                                            <p>'.$text.'</p>
                                        </div>
	                
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
if(empty($func)){
    $func = 'b';
}
$type = @$_REQUEST['t'];
$e = @$_REQUEST['e'];
//$age = $page /2.0 - 0.5;
$age = $user_age;
$cur_li_count = 0;
if(($user_age) > 72) {
	exit();
}
//a全部项目
//b还不会的项目
//c已经会的项目
	$li = fetchContent($age, $type, $func,$e);
		echo_start($age, $type, $type==0);
		if(strlen($li) > 0)
			echo($li);
		else
			echo('<li> - - </li>');
		echo_end();
?>
