<?php
include('inc.php');	

$y = $_REQUEST['p1'];
$m = $_REQUEST['p2'];
$age = $y * 12 + $m;
if($age > 72) $age = 72;

$sql = "select * from grow_index where grow_index.age_min <= '$age' and grow_index.age_max >= '$age' order by rand() limit 1";
$result = M()->find($sql);
if($result) {
	$arr = array(
	'title' => $result['text'],
	'detail' => $result['detail'],
	'advice' => $result['advice']
	);
	echo(json_encode($arr));
}
?>
