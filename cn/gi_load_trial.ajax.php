<?php
include('inc.php');	

$y = $_REQUEST['p1'];
$m = $_REQUEST['p2'];
$age = $y * 12 + $m;
if($age > 72) $age = 72;

$sql = "select * from grow_index where grow_index.age_min <= '$age' and grow_index.age_max >= '$age' order by rand() limit 1";
$result = query($sql);
if($row = mysqli_fetch_array($result)) {
	$arr = array(
	'title' => $row['text'],
	'detail' => $row['detail'],
	'advice' => $row['advice'] 
	);
	echo(json_encode($arr));
}
?>
