<?php
/*
	SEND EPAPER IN BULK
	!!! USE CAREFULLY !!!
*/

include('inc.php');	
// Allow only local calls
/*
if ($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']){
  $this->output->set_status_header(400, 'No Remote Access Allowed');
  die('No Remote Access Allowed'); //just for good measure
}
*/
global $_v_VERIFY_MAIL_SUBJECT,$_v_SITE_WWW,$_v_VERIFY_MAIL_FROM_FULL_NAME,$_v_VERIFY_MAIL_FROM;

$log_file = "../log/epaper_log".date("Y_m_d_H_i_s").".txt";
$url_base = $_v_SITE_WWW."/content/epaper/";

$sql = "select subject,date(now()) as today from epaper where pub_date = date(now()) order by uid desc limit 1";
$result = query($sql);
if($row = mysqli_fetch_array($result)) {
	$epaper_subject = $row[0];	
	$today = $row[1];
}

if(!isset($epaper_subject)) {
	$err = "No Issue Today!";
	write_log($log_file,$err);
	die($err);
}

$msg = file_get_contents('../content/epaper/ENews.html');
//$msg = str_replace("[EP_LINK]",$url_string_1,$msg);
$msg = str_replace("[ISSUE_DATE]",$today,$msg);
$msg = str_replace("[EPAPER_BASE]",$url_base,$msg);
$msg = str_replace("[EPAPER_SUBJECT]",$epaper_subject,$msg);

$_test_receiver = $_GET['test'];
if(isset($_test_receiver)) {
	sendEpaperEmail(1,$_test_receiver,$msg);
	die($msg);
}

// fetch member emails
$sql = "select uid, email from member where epaper='1'"; // TODO: add limit
$result = query($sql);
$sent = array();
$failed = array();
while($row = mysqli_fetch_array($result)) {
	$uid = $row["uid"];
	$email = $row["email"];
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		if(sendEpaperEmail($uid,$email,$msg)) {
			$sent[] = $row['uid'];
		}
		else {
			$failed[] = $row['uid'];
		}
	}
}

write_log("../log/epaper_log".date("Y_m_d_H_i_s").".txt",json_encode(array(	'timestamp'=>date("Y-m-d H:i:s"),
																			'delievered'=>array('count'=>count($sent),'uid'=>$sent),
																			'failed'=>array('count'=>count($failed),'uid'=>$failed)
																			)));
echo("成功發送 ".count($sent)." 筆 / 失敗 ".count($failed)."筆");

function write_log($fn,$content) {
	$fp = fopen($fn,"w");
    fputs($fp,$content); 
    fclose($fp);
}

?>
