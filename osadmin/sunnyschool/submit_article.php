<?php
include_once("../../inc/inc_db.php");

$uid = $_POST["uid"];
$title = $_POST["title"];
$description = $_POST["description"];
$content = $_POST["content"];
$tag = $_POST["tag"];
$pub_date = $_POST["pub_date"];
$type = $_POST["type"];

if(isset($uid)) {
	$sql = "update articles set title='$title',description='$description',content='$content',tag='$tag',pub_date='$pub_date',type='$type' where uid='$uid'";	
}
else {
	$sql = "insert into articles (title,description,content,tag,pub_date,type) values ('$title','$description','$content','$tag','$pub_date','$type')";
}
$result = query($sql);
if(mysqli_affected_rows() > 0) {
	echo('{"result":1}');
}
else {
	echo('{"result":0}');	
}
//echo($sql);
?>
