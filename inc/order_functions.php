<?php

function genOrderInfo($access_token, $payment_token, $product_id, $price, $payway) {

	$lid = 0;
	global $CMEMBER;
	$member_uid = $CMEMBER->accessFromToken($access_token);
	$sql = "SELECT * FROM product WHERE price='".$price."' AND id='".$product_id."'";
	if($result = query($sql)) {
		if(mysqli_num_rows($result) > 0) {
			// 產生訂單編號
			$sql = 	"INSERT INTO orderinfo (user_uid,owner_uid,payment_token,".
				"product_id,price,payway) ".
				"VALUES ".
				"('".$member_uid."','".$member_uid."','".$payment_token.
				"','".$product_id."','".$price."','".$payway."') ".
				"ON DUPLICATE KEY UPDATE payment_token='".$payment_token.
				"'";
			$result = query($sql);
			if($result) {
			/*
				$sql = "select LAST_INSERT_ID() as lid";
				$result = mysql_query($sql,$conn);
				if($result) {
					if($row = mysql_fetch_row($result)) {
						$lid = $row[0];
					}
				}
				*/
				$lid = 1;
			}
			else {
				//echo(mysql_error());
			}
		}
	}
	
	return $lid;
}
function genOrderInfo2($access_token, $payment_token, $product_id, $price, $payway) {
	// 產生訂單編號 EC-6N018184KX731053YY
	$lid = 0;
	global $CMEMBER;
	$member_uid = $CMEMBER->accessFromToken($access_token);
	$sql = 	"INSERT INTO orderinfo (user_uid,owner_uid,payment_token,product_id,price,payway) ".
		"VALUES ('".$member_uid."','".$member_uid."','".$payment_token."','".$product_id.
		"','".$price."','".$payway."') ON DUPLICATE KEY UPDATE payment_token='".
		$payment_token."'";
//	echo($sql."<br>");
	$result = query($sql);
//	echo("result:".$result."<br>");
	if($result) {

		$lid = 1;
	}
	else {
		//echo(mysql_error());
	}
	return $lid;
}

function genOrderInfoBundles($user_uid, $payment_token, $bundle_id, $payway) {
	

	$lid = 0;
	$sql = 	"INSERT IGNORE INTO orderinfo (user_uid,owner_uid,payment_token,".
		"product_id,price,payway,detail,status) ".
		"SELECT '".$user_uid."','".$user_uid."','B".$payment_token.
		"', product_id ,0 ,'".$payway."','".$bundle_id.
		"',1 FROM bundles WHERE bundle_id ='".$bundle_id."'";

	$result = query($sql);
	if($result) {

		$lid = 1;
	}
	else {
	}
	return $lid;
	
}

function addBundlesToMyCollection($user_uid, $bundle_id) {

	$sql = "INSERT IGNORE INTO mycollection (user_uid,product_id) ".
	"SELECT '".$user_uid."', product_id FROM bundles WHERE bundle_id ='".$bundle_id."'";
	query($sql);

}

function genOrderInfoBundles2($payment_token) {
	$lid = 0;

	$sql = "SELECT O.* FROM orderinfo O, product P WHERE O.product_id = P.id AND O.payment_token = '".$payment_token."' AND P.category_id = 'Bundles'";
	$result = query($sql,$conn);
	if ($row = mysqli_fetch_array($result) ) {
		$user_uid = $row['user_uid'];
		$owner_uid = $row['owner_uid'];
		$bundle_id = str_replace("AST","",$row['product_id']);
		$payway = $row['payway'];

		addBundlesToMyCollection( getUserIdByMemberId($owner_uid), $bundle_id);


		$sql = "INSERT IGNORE INTO orderinfo (user_uid,owner_uid,payment_token,product_id,price,payway,detail,status) ".
		"SELECT '".$user_uid."','".$owner_uid."','B".$payment_token.
		"', product_id ,0 ,'".$payway."','".$bundle_id.
		"',1 FROM bundles WHERE bundle_id ='".$bundle_id."'";
	///	echo($sql."<br>");
		$result2 = query($sql);
	//	echo("result:".$result."<br>");
		if($result2) {
	
			$lid = 1;
		}
		else {
			//echo(mysql_error());
		}
	}
	return $lid;
	//return $sql;
	
}

function updatePaymentResult($payment_token, $status, $detail) {
	

	$date = new DateTime("now");
	$sql = "UPDATE orderinfo SET status= '".$status."',detail='".$detail."'".
	",pay_datetime='".$date->format('Y-m-d H:i:s')."' WHERE payment_token='".$payment_token."'";
	$result = query($sql);
	if($status < 99)
		tryAddCreditFromOrder($payment_token);
	return $result;
}

function updatePaymentResult2($payment_token, $status, $detail) {
	$date = new DateTime("now");
	$sql = "UPDATE orderinfo SET status= '".$status."',detail='".$detail."'".
	",pay_datetime='".$date->format('Y-m-d H:i:s')."' WHERE payment_token='".$payment_token."'";
	$result = query($sql);
	if($status < 99)
		tryAddCreditFromOrder($payment_token);
	return $result;
}

// status = 0 -> 尚未付款
// status = 1 -> 新購尚未指定使用者或送人
// status = 2 -> 已經指定使用者或送人
function isPurchased($user_uid, $product_id) {
	$sql = "SELECT uid FROM orderinfo WHERE owner_uid='".$user_uid."' AND product_id='".$product_id."' AND status=1";
	$result = query($sql);
	if(mysqli_num_rows($result) > 0)
		return 1;
	else
		return 0;
}

function ownsProduct($user_uid, $product_id) {
	$sql = "SELECT uid FROM orderinfo WHERE owner_uid='".$user_uid."' AND product_id='".$product_id."' AND status >= 1";
	$result = query($sql);
	$sql = " SELECT count(*) from bundles where bundle_id = '3' and product_id = '".$product_id."'";
	$result1 = query($sql);
	$row= mysqli_fetch_array($result1);
	if(mysqli_num_rows($result) > 0)
		return 1;
	elseif($row[0] >0 )
		return 1;
	else
		return 0;
}

function isPreloaded($bundle_id, $product_id) {
	$sql = "SELECT product_id FROM bundles WHERE bundle_id='$bundle_id' AND product_id='$product_id'";
	$result = query($sql);
	if(mysqli_num_rows($result) > 0)
		return 1;
	else
		return 0;
}

function completeOrderByCredit($access_token, $product_id, $price) {
	// 產生訂單編號
	$lid = 0;
	$date = new DateTime("now");
	$sql = "INSERT INTO orderinfo (user_uid,payment_token,product_id,price,payway,status,pay_datetime) ".
	"VALUES ((SELECT user_uid FROM access WHERE token='".$access_token."'),'TB_CREDIT','".$product_id."','".$price."','1','1','".$date->format('Y-m-d H:i:s')."')";
//	echo($sql."<br>");
	$result = query($sql);
//	echo("result:".$result."<br>");
	if($result) {
		return 1;
	}
	else {
		return 0;
	}
}

function transferOwnership($original_owner_uid, $new_owner_uid, $product_id) {
	$sql = "UPDATE orderinfo SET owner_uid='$new_owner_uid',status='2' WHERE user_uid='$original_owner_uid' AND owner_uid='$original_owner_uid' AND product_id='$product_id' AND status='1' ORDER BY pay_datetime DESC LIMIT 1"; 
	query($sql);
	return mysqli_affected_rows();
}

function claimOwnership($member_uid, $product_id) {
	$sql = "SELECT uid FROM orderinfo WHERE owner_uid='$member_uid' AND product_id='$product_id' AND status='2'";
	$result =query($sql);
	if(mysqli_num_rows($result) > 0)
		return 0;
	$sql = "UPDATE orderinfo SET status='2' WHERE owner_uid='$member_uid' AND product_id='$product_id' AND status='1' ORDER BY pay_datetime DESC LIMIT 1"; 
	query($sql);
	return mysqli_affected_rows();
}

// BUG!
// Add credit to user's account if the product type is 'Bear Coins'
function tryAddCreditFromOrder($payment_token) {
	

	$sql = 	" SELECT a.credit, a.type, b.user_uid FROM product as a, orderinfo as b ".
		" WHERE a.id=b.product_id and b.payment_token='".$payment_token."'";
	$result = query($sql);
	if ($row = mysqli_fetch_array($result) ) {
		$type = $row['type'];
		if($type=="TBC") { // Bear Coin
			$points = $row['credit'];
			$user_uid = $row['user_uid'];
			$sql = "UPDATE member SET credit=credit+".$points." where uid='".$user_uid."'";
			query($sql);
			//if(mysqli_affected_rows($dbConn) > 0) {
					return 1;
			//}
			
		}
	}
	return 0;
}

?>
