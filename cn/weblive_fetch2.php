<?php
session_start(); 
include('inc.php');	
if(!isset($_SESSION['user_token'])) {
	die("请重新登入");
}
$client_id = 'cctv_user';
$course_id = $_REQUEST['c'];
$access_token = $_SESSION['user_token'];
$key = 'q9ds02xc1a';
$timestamp = time();
$checksum = md5($client_id.$course_id.$access_token.$timestamp.$key);
$url = 'http://www.weblive.com.tw/api/cctv/getcontent.php';

$post = array(	'clientid' => $client_id, 
				'courseid' => $course_id,
				'access_token' => $access_token,
				'timestamp' => $timestamp, 
				'checksum' => $checksum);
$ch = curl_init();
$options = array(
  CURLOPT_URL=>$url,
  CURLOPT_HEADER=>0,
  CURLOPT_VERBOSE=>0,
  CURLOPT_RETURNTRANSFER=>true,
  CURLOPT_USERAGENT=>"Mozilla/4.0 (compatible;)",
  CURLOPT_POST=>true,
  CURLOPT_POSTFIELDS=>http_build_query($post),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch); 
curl_close($ch);
//echo $result;

if($result!=null) {
	$json = json_decode($result);
	if($json->RET==0) {
		$course = $json->DATA->courses;
		$courseid = $course->courseid;
		$coursname = $course->coursname;
		$courspics = $course->courspics;
		$coursurl = $course->coursurl;
		$image_html = '<p><img src="'.$courspics.'"></p>';

//		$html = '<section class="fy-hd"><h2 class="title">'.$courseid.'. '.$coursname.'</h2></section><section class="fy-bd clearfix"> <iframe id="weblive_html" src="'.$coursurl.'"></iframe></section>';
		$html = $coursurl;
		echo($html);
		/*
		$ch = curl_init();
		$options = array(
		  CURLOPT_URL=>$coursurl,
		  CURLOPT_HEADER=>0,
		  CURLOPT_VERBOSE=>0,
		  CURLOPT_RETURNTRANSFER=>true,
		  CURLOPT_USERAGENT=>"Mozilla/4.0 (compatible;)",
		  CURLOPT_POST=>false
		);
		curl_setopt_array($ch, $options);
		$my_var = curl_exec($ch);
		curl_close($ch);
		echo($my_var);
		*/
		//echo("<iframe width='100%' height='100%' src='".$coursurl."'></iframe>");
//		header('Location:'.$coursurl.'');
	}	
//	else echo('Data error:'+$json->MSG);
}

?>
