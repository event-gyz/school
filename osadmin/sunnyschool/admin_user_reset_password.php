<?php

include_once("../../inc/inc_db.php");

$uid = $_REQUEST['uid'];
$sql = "update member set password = 'e10adc3949ba59abbe56e057f20f883e' where uid='$uid'";
$result = query($sql);
if($result) {
	echo("重设密码为 123456");
}
else {
	echo("失敗（资料库异常）");
}

?>