<?php 
// TODO: add spam limits, use database instead of txt
ob_start();
session_start(); 
include('inc.php');	

if(!isset($_SESSION['teacher_token'])) {
	header( 'Location: index.php' ) ;
	exit();
}	

$member_uid = $CMEMBER->accessFromToken($_SESSION['teacher_token']);
if($member_uid == -1) {
	header( 'Location: index.php' ) ;
	exit();
}
$CMEMBER->admin = true;
$CMEMBER->getUserInfo();
$teacher_name = $CMEMBER->id;
$_ITEMS_PER_PAGE = 50;

function obfuscate_username($username) {
    if (strlen($username) < 8) {
        return $username;
    }
    else {
        return substr($username, 0, 4).str_repeat('*', 6).substr($username, -4);
    }
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
<title>交流园地</title>
<style type="text/css">
<!--
body,td,th {
	font-family: 宋体;
	font-size: 9pt;
	color: #222;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
	line-height:20px;
}
a:link {
	color: #222;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #222;
}
a:hover {
	text-decoration: underline;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #999999;
}
-->
</style>
<script>
    function del(id){
		if(confirm("确定要删除吗？")){
			window.location='?id='+id;
			}
		}
</script>
<script language=javascript>
  function CheckPost()
 {
	 if((myform.title.value.indexOf("@") > -1)||
		 (myform.title.value.indexOf("%") > -1)
	 ) {
		 alert("标题不支持特殊字符");
		 return false;
	 }
	 if((myform.name.value.indexOf("@") > -1) ||
		 (myform.name.value.indexOf("%") > -1){
		 alert("昵称不支持特殊字符");
		 return false;
	 }
	 if(myform.content.value.indexOf("@") > -1) ||
		 (myform.content.value.indexOf("%") > -1){
		 alert("内容不支持特殊字符");
		 return false;
	 }
	if (myform.title.value.length<2)
	{
		alert("标题不能少于2个字符");
		myform.title.focus();
		return false;
	}
	if (myform.name.value=="")
	{
		alert("昵称不能为空");
		myform.name.focus();
		return false;
	}
	if (myform.content.value.length<10)
	{
		alert("内容不能少于10个字符");
		myform.content.focus();
		return false;
	}
 }
</script>
<?php 
/*

if($_POST['submit_admin']){
if($_POST['pwd']=="admin"){
$_SESSION['pwd']=$_POST['pwd'];
echo "<script language=javascript>alert('登陆成功！');window.location='bb_home.php'</script>";
}
  }
*/
?>
<?php
/*
	if($_GET['tj'] == 'logout'){
	session_start(); //开启session
	session_destroy();  //注销session
	header("location:bb_home.php"); //跳转到首页
	}
*/
?>
<?php

// DELETE //

if($_GET["id"]<>''){
$id = $_GET["id"];

$sql = "delete from bboard where uid='$id' and member_id='".$CMEMBER->id."'";
$result = query($sql);
if($result) {
	if(mysqli_affected_rows() > 0) {
		echo "<script language=javascript>";
		echo "window.location='bb_home.php'</script>";
	}
}
/*

$info = file_get_contents("bb_data.txt");
$column = explode("@@@",$info); unset($column[$id]);
$noinfo = implode("@@@",$column);
    file_put_contents("bb_data.txt",$noinfo);
	echo "<script language=javascript>";
	echo "window.location='bb_home.php'</script>";
*/
}
?>
</head>
<body>
<form  name="myform" method="post" onSubmit="return CheckPost()" action="" style="margin-bottom:5px;">
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td height="25" align="center" bgcolor="#EBEBEB"><a href="bb_home.php?tj=add">添加留言</a></td>
  </tr>
</table>
<?php 
if($_GET["tj"] == 'add'){
if($_POST[submit]){
$title = $_POST["title"];
$name = $_POST["name"];
$face = $_POST["face"];
$content = $_POST["content"];
$sql = "insert into bboard (face,subject,message,member_id) values ('$face','$title','$content','$name')";
$result = query($sql);
if(mysqli_affected_rows() > 0)
	echo "<script language=javascript>window.location='bb_home.php'</script>";
}
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="5"></td>
    </tr>
  </table>
  <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3" brder="1">
<tr>
    <td width="62" align="center" bgcolor="#FFFFFF">留言标题：</td>
    <td width="465" bgcolor="#FFFFFF"><input style='width:80%' type="text" name="title"/>
      &nbsp;*</td>
</tr>
<tr>
     <td align="center" bgcolor="#FFFFFF">网友帐号：</td>
     <td bgcolor="#FFFFFF"><input style='width:80%'  readonly="true" name="name" type="text" id="name" value="<?php echo($CMEMBER->id); ?>"/> 
       &nbsp;</td>    
</tr>
<tr>
  <td align="center" bgcolor="#FFFFFF">网友表情：</td>
  <td bgcolor="#FFFFFF"><input type="radio" value="1" name="face" checked="checked" />
                            <img src="face/pic1.gif" width="20" height="20" border="0" />
                            <input type="radio" value="2" name="face" />
                            <img src="face/pic2.gif" width="20" height="20" border="0" />
                            <input type="radio" value="3" name="face" />
                            <img src="face/pic3.gif" width="20" height="20" border="0" />
                            <input type="radio" value="4" name="face" />
                            <img src="face/pic4.gif" width="20" height="20" border="0" />
                            <input type="radio" value="5" name="face" />
                            <img src="face/pic5.gif" width="20" height="20" border="0" />
                            <input type="radio" value="6" name="face" />
                            <img src="face/pic6.gif" width="20" height="20" border="0" />
                            <input type="radio" value="7" name="face" />
                            <img src="face/pic7.gif" width="20" height="20" border="0" /></td>
</tr>
<tr>
     <td align="center" bgcolor="#FFFFFF">留言内容：</td>
     <td bgcolor="#FFFFFF"><textarea name="content" rows="5" cols="40"></textarea>
      &nbsp;不能少于10个字符</td>
</tr>
<tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF">
        <input name="submit" type="submit"value="提交" />&nbsp;&nbsp; 
        <input name="reset" type="reset"  value="重填"/>      </td>
    </tr>
</table>
</form>
<?php 
	}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>

<table style="table-layout: fixed; width: 100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
<tr>
<th width="60" bgcolor="#EBEBEB">留言表情</th>
<th width="76" bgcolor="#EBEBEB">留言标题</th>
<th width="77" bgcolor="#EBEBEB">网友帐号</th>
<th width="133" bgcolor="#EBEBEB">留言内容</th>
<th width="78" bgcolor="#EBEBEB">留言时间</th>
<th width='59' bgcolor='#EBEBEB'>操作</th>
</tr>
<?php
//这是分页文件
$page=(!empty($_GET['page'])) ? $_GET['page'] : 1;

//统计页码
$sql = "select count(*) from bboard";
$result = query($sql);
$cont = 0;
if($row = mysqli_fetch_array($result)) {
	$cont = $row[0];
}
$cont = $cont / $_ITEMS_PER_PAGE;

$sql = "select * from bboard order by bb_timestamp desc limit ".($page-1)*$_ITEMS_PER_PAGE." ,$_ITEMS_PER_PAGE";
$result = query($sql);
while($message=mysqli_fetch_array($result)) {
?>
<tr>
<td align="center" bgcolor="#FFFFFF"><img src="face/pic<?php echo $message['face'];?>.gif" width="20" height="20" /></td>
<td style="word-wrap: break-word" align="center" bgcolor="#FFFFFF"><?php echo $message['subject'];?></td>
<td style="word-wrap: break-word" align="center" bgcolor="#FFFFFF"><?php echo obfuscate_username($message['member_id']);?></td>
<td style="word-wrap: break-word" align="center" bgcolor="#FFFFFF"><?php echo $message['message'];?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo $message['bb_timestamp'];?>
<?php 
echo "<td align='center' bgcolor='#FFFFFF'>";

if($CMEMBER->id==$message['member_id']){
$pages=$message['uid'];
echo "<a href='javascript:del({$pages})'>删除</a>";
}

echo "</td>";
?>
</tr>
<?php
}
?>
</table>

<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><?php 
$linkstr="";
for($i=0;$i<$cont;$i++)
{
	if($page == ($i+1))
	    $linkstr.= "<a href=?page=".($i+1)."><font color=blue>第".($i+1)."页</font></a>|";
	else
	    $linkstr.= "<a href=?page=".($i+1).">第".($i+1)."页</a>|";
    if(($i+1)%20==0)
    $linkstr.= "<br>";
}
echo $linkstr; 
?></td>
  </tr>
</table>

<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>
</body>
</html>