<?php
/*
$data1 = array(
    'id' => 'MEB001',
    'category_id'  => 'MEBOOKS',
    'name' => array('en' => 'Book1'),
    'price' => 2.99,
    'credit' => 30,
    'description' => array('en'=>'A nice book'),
    'discount' => 1.0,
   	'type' => 'MEB',
   	'cover_image_url' => 'mebooks1.png',
   	'status' => 7,
   	'version' => 1,
   	'data' => null,
   	'favorite' => 0
);

$data2 = array(
    'id' => 'MEB002',
    'category_id'  => 'MEBOOKS',
    'name' => array('en' => 'Book2'),
    'price' => 2.99,
    'credit' => 30,
    'description' => array('en'=>'A nice book 2'),
    'discount' => 1.0,
   	'type' => 'MEB',
   	'cover_image_url' => 'mebooks2.png',
   	'status' => 7,
   	'version' => 1,
   	'data' => null,
   	'favorite' => 0
);

$data = array($data1,$data2);

$json = json_encode($data);
echo $json;
*/
/*
$date1 = new DateTime();
$date2 = new DateTime("20140811123249");
$interval = $date1->diff($date2);
echo "<p>difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
echo "<p>difference " . $interval->days; 
*/
include('inc.php');	
$token = "db4511da82ced6998cf30107bb260947ed998c0e0a949989e8c4f98743227aec87632212735525508619";
$member_uid = $CMEMBER->accessFromToken($token);
echo($member_uid);
?>