<?php
session_start();

include("inc.php"); 

if(isset($_SESSION['user_token'])) {
	$member_uid = $CMEMBER->accessFromToken($_SESSION['user_token']);
}
if(isset($member_uid) && $member_uid > 0) {
	$CMEMBER->getUserInfo();
	$_SESSION['user_credit'] = !empty($credit)?$credit:'';
	$_SESSION['user_epaper'] = $CMEMBER->epaper;
	if(!isset($_SESSION['CURRENT_KID_UID']) || !isset($_SESSION['CURRENT_KID_AGE']) || !isset($_SESSION['CURRENT_KID_NICKNAME'])) {

		$kids_uid_array = $CMEMBER->getKidsUidArray();
		if(count($kids_uid_array) > 0) {
			$_SESSION['CURRENT_KID_UID'] = $kids_uid_array[0];
			$uid = $_SESSION['CURRENT_KID_UID'];
			if(	!isset($_SESSION['CURRENT_KID_NICKNAME'])
				||!isset($_SESSION['CURRENT_KID_AGE']) || !isset($_SESSION['CURRENT_KID_BIRTH_DAY'])) {
				$sql = " select nick_name, birth_day from user where uid = '$uid'";
                $row = M()->find($sql);
                // find age in months
                $birthday = new DateTime($row['birth_day']);
                $diff = $birthday->diff(new DateTime());
                $months = $diff->format('%m') + 12 * $diff->format('%y');
                $days = $diff->format('%d');
                if($days >= 15)
                    $months += 0.5;
                $user_age = $months;
                $nickname = $row['nick_name'];
                $_SESSION['CURRENT_KID_AGE'] = $user_age;
                $_SESSION['CURRENT_KID_NICKNAME'] = $nickname;
                $_SESSION['CURRENT_KID_BIRTH_DAY'] = $row['birth_day'];

			}
		}
	}
}
$ret = array(
'islogin' => isset($member_uid),
'haskid' => isset($_SESSION['CURRENT_KID_UID'])
);

echo(json_encode($ret));
?>