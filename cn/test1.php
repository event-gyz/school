<?php
/*
$arr = array(245,123,227,532,109,123,243);
$idx = array_search(534,$arr);
if($idx !== FALSE)
	echo('item at '.$idx);
else
	die('not found');
*/	
include("inc.php"); 
include_once("../inc/GrowIndex.class.php");
?>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style type="text/css"> 
    h2 { 
      color:blue; 
    } 
    h3 {
	  color:green;
    }
  </style> 
</head>
<?php

define("AGE_MIN", 0);
define("AGE_MAX", 36);

$user_uid = 1;

echo("<H1>GrowIndex Function Tests</H1>");
echo('Testing data: Age from '.AGE_MIN.' to '.AGE_MAX.' months<p>');

$gi = new GrowIndex;

/*
$start = microtime(true);
$count = GrowIndex::loadItemsFromFile();
echo("<h2>loadItemsFromFile($count):</h2>".(json_encode(GrowIndex::$arr_text)));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');
*/

$start = microtime(true);
$count = GrowIndex::loadItems();
//foreach ( GrowIndex::$arr_text as $key => $value ) 	GrowIndex::$arr_text[$key] = urlencode ( $value );  
//echo('loadItems='.urldecode(json_encode(GrowIndex::$arr_text)));
echo("<h2>loadItems($count):</h2>".(json_encode(GrowIndex::$arr_text)));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');

$start = microtime(true);
$count = $gi->loadLearnedItems($user_uid);
echo("<h2>loadLearnedItems($count):</h2>".json_encode($gi->arr_learned_uid));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');

$start = microtime(true);
$data = $gi->getAllItemsByAge($user_uid,AGE_MIN,AGE_MAX);
$count = count($data);
echo("<h2>getAllItemsByAge($count):</h2>".json_encode($data));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');

$start = microtime(true);
$data = $gi->getAllItemsByAge($user_uid,AGE_MIN,AGE_MAX,1);
$count = count($data);
echo("<h2>Learned Items($count):</h2>".json_encode($data));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');

$start = microtime(true);
$data = $gi->getAllItemsByAge($user_uid,AGE_MIN,AGE_MAX,2);
$count = count($data);
echo("<h2>UnLearned Items($count):</h2>".json_encode($data));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');

$start = microtime(true);
echo('<h2>getLearnedItemsSQL</h2>'.$gi->getLearnedItemsSQL($user_uid,AGE_MIN,AGE_MAX));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');

$start = microtime(true);
echo('<h2>getUnlearnedItemsSQL</h2>'.$gi->getUnlearnedItemsSQL($user_uid,AGE_MIN,AGE_MAX));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');

$uid_to_learn = GrowIndex::$arr_uid[mt_rand(1,count(GrowIndex::$arr_uid))];
//$start = microtime(true);
//echo("<h2>setLeanedSQL(Learn uid $uid_to_learn)</h2>".$gi->setLeanedSQL($user_uid,1,$uid_to_learn,true));
//echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');

$start = microtime(true);
echo("<h2>getMore(uid $uid_to_learn)</h2>");
print_r(GrowIndex::getMore($uid_to_learn));
echo('<h3>elapsed:'.(microtime(true) - $start).'  ms</h3>');


?>
<p>===========================</p>
<?php
$birthday = new DateTime('2012-1-1');
$diff = $birthday->diff(new DateTime());
$months = $diff->format('%m') + 12 * $diff->format('%y');
$days = $diff->format('%d');
if($days >= 15)
	$months += 0.5;
echo("age test: birthday=".$birthday->format('Y-m-d').", age in months=$months");
?>