<?php

include('inc.php');
include_once("../inc/GrowIndex.class.php");

$uid = $_REQUEST['p1']; // item uid
$type = $_REQUEST['p2'];// asking for 0 detail or 1 advice

GrowIndex::output_more($uid,$type);
?>