<?php
function checkUserCredit($access_token) {

	global $CMEMBER;
	$member_uid = $CMEMBER->accessFromToken($access_token);
	$sql = "select credit from member where uid= '".$member_uid."'";
	$result = query($sql);
	if($row = mysql_fetch_row($result)) {
		return $row[0];
	}
	else return "0";
}

/*
 * Deduct credit from user account
 */
function deductCredit($access_token, $credit) {
	global $CMEMBER;
	$member_uid = $CMEMBER->accessFromToken($access_token);
	$sql = "update member set credit=credit-".$credit." where uid= '".$member_uid."' and credit>=".$credit;
	//echo("<br>".$sql."<br>");
	query($sql);
	//	if(mysqli_affected_rows($dbConn) == 0)
			return 1;
	//}
	return 0;
// TODO add LOG

}

function addCredit($user_uid, $credit) {
// TODO add LOG

}

function addCreditWithSerialNumber($access_token, $sn) {
	
	$sn = strtoupper($sn);
        global $CMEMBER;
        $member_uid = $CMEMBER->accessFromToken($access_token);


	$sql = "SELECT points FROM credit WHERE sn='".$sn."' AND status='0'";
	$result = query($sql);
	if ($row = mysqli_fetch_array($result) ) {
		$points = $row['points'];
		if(isset($points)) {
			$sql = " UPDATE member SET credit=credit+".$points." where uid= '".$member_uid."' ";
			if(query($sql)) {
				$sql = "UPDATE credit set status='1',member_uid='".$member_uid."',used_date=now() where sn ='".$sn."'";
					query($sql);
					return 1;
				
				}
				else {
					return -1;
				}
			
		}
	}
	return 0;
}


function genCreditSerialNumber($credit, $num_pairs) {
    $password_len = 10;

	$word = 'ABCDEFGHIJKLMNPQRSTUVWXYZ0123456789';
    $len = strlen($word);
    
	for($i = 0; $i < $num_pairs; $i++) {
	    $sn = '';
		// gen random
		for ($j = 0; $j < $password_len; $j++) {
        	$sn .= $word[rand() % $len];
    		}
    	// add to db
    		$sql = "INSERT INTO credit (sn,points,issue_date) VALUES ('".$sn."','".$credit."',now())";
    		$result = query($sql);
	}
}

// 取得點數與價錢對應表
function getCreditList() {
	//$sql = "SELECT * FROM product WHERE type='TBC'";
	global $Language;
	$sql = "select a.*,b.value from product a, language b where a.type = 'TBC' and a.name = b.name and b.lang = '".$Language."'";
	$result = query($sql);
	$json_string = "{\"bearcoins\":";
	$DATAS = array();
	while ($row = mysqli_fetch_array($result) ) {
		$ar = array(
		'id' => $row['id'],
		'name' => getString($Language,$row['name']),
		//'name' => $row['value'],
		'credit' => $row['credit'],
		'price' => $row['price'],
		);
		$DATAS[] = $ar;
	}
	$json_string = $json_string.json_encode($DATAS)."}";
	return $json_string;
}
?>
