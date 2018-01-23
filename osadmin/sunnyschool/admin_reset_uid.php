<?php
include_once("../../inc/inc_db.php");

function resetTableUid($table) {
	query("SET @num=0");
	query("UPDATE $table SET uid=(@num:=@num+1)");
}

$t = $_GET['t'];
if($t==1) {
	$table = 'bboard';
}
if(isset($table)) {
}

?>