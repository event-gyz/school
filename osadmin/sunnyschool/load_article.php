<?php
include_once("../../inc/inc_db.php");

$uid = $_REQUEST['uid'];
$sql = "select * from articles where uid='$uid'";
$result = query($sql);
$row = mysqli_fetch_object($result);

$cdata = $row->content;
if(!base64_decode($cdata,true))
	$content = base64_encode($cdata);
else
	$content = $cdata;
$data = array(
'title' => $row->title,
'description' => $row->description,
'content' => $content,
'tag' => $row->tag,
'type' =>$row->type,
'pub_date' => $row->pub_date
);
echo(json_encode($data));
?>
