<?php
include_once("../../inc/inc_db.php");

$uid = $_POST["uid"];
$sql = "delete from articles where uid='$uid'";
$result = query($sql);
//echo(json_encode(array('result'=>mysqli_affected_rows()));
echo('{"result":true}');
?>
