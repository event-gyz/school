<?php
$page = $_REQUEST['p'];

if($page > 1)
	exit();

$client_id = 'cctv_user';
$key = 'q9ds02xc1a';
$timestamp = time();
$checksum = md5($client_id . $timestamp . $key);
$url = 'http://www.weblive.com.tw/api/cctv/getcoutentlist.php';

$post = array('clientid' => $client_id, 'timestamp' => $timestamp, 'checksum' => $checksum);
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
		$arr_courses = $json->DATA->courses;
//		echo('<ul class="clearfix">');
		echo('<table width=100%>');
		for($i = 0;$i < count($arr_courses); $i++) {
			if($i%5 == 0) {
				if($i > 9)
					echo('</tr>');
				echo('<tr>');
			}
			echo('<td width=20%>');
			$courseid = $arr_courses[$i]->courseid;
			$coursname = $arr_courses[$i]->coursname;
			$courspics = $arr_courses[$i]->courspics;
			//echo('<li class="masli"><a name="course" id="'.$courseid.'" href="javascript:void(0)"><img src="'.$courspics.'"></a><div class="Txt clearfix"><i>课程编号：'.$courseid.'</i><p>'.$coursname.'</p></div></li>');
			echo('<a name="course" id="'.$courseid.'" href="javascript:void(0)"><img width="100px" height="100px" src="'.$courspics.'"></a><div class="Txt clearfix"><i>课程编号：'.$courseid.'</i><br>'.$coursname.'</br><p></p></div>');
			echo('<td>');
		}
//		echo("</ul>");
		echo('</table>');
	}	
	else echo('Data error:'+$json->MSG);
}
?>
