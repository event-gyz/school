<?php
include('inc.php');
//echo date('Y-m-d');
session_start();
//-- 顯示驗證碼 --//

$action = $_GET['action'];
if($action == 'verify') {
	$payload=@$_GET['t'];
	$dec_string = my_decrypt($payload);
	echo("<p>String=$dec_string");
	$idx = strpos($dec_string,"|");
	
	if($idx > 0) {
    	$member_id = substr($dec_string, 0, $idx);
    	$token = substr($dec_string, $idx+1);
    	$sql = "UPDATE reg_verify SET status='1' WHERE member_id='$member_id' AND ver_code='$token' AND status=0";
    	echo("<p>".$sql);
    	$result = query($sql) or die("server error:".mysql_error());
    	if(mysqli_affected_rows() > 0) {
    	echo("<p>done");
    	}
    	// TODO error handling
    	else
    	echo("<p>nothing changed");
	}
}
else {
	echo($_SESSION['auth_code']); 	
}

//-- 顯示 Access Token --//
//echo('token='.$_SESSION['user_token']);

//-- 新增文章 --//
/*
$title = $_POST['title'];
$description = $_POST['description'];
$content = $_POST['content'];
$image = $_POST['image'];
$tag = $_POST['tag'];
$type = $_POST['type'];
$pub_date = $_POST['pub_date'];

//add_new_article($title, $description, $content, $image, $tag, $type, $pub_date);
add_new_article('a','b','c','d','e','REC','2014-03-22');
get_articles('REC',10);
*/

//-- 顯示文章內容 --//
//echo(af_recommend_load_article(7,"index"));
/*
$sql = "select content from articles where uid='7'";
$result = query($sql);
$row = mysqli_fetch_array($result);
echo(stripcslashes($row['content']));
*/
?>
