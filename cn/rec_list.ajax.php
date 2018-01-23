<?php
include('inc.php');
$tag = $_REQUEST["tag"];
echo(af_recommend_list($tag));
?>