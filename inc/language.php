<?php
function getString($language, $name) {
	$sql = "SELECT lang as l, value as v FROM language WHERE lang IN (SELECT primary_language FROM language_group WHERE area = '".$language."' UNION SELECT secondary_language FROM language_group WHERE area ='".$language."') AND name = '".$name."'";
	$result = query($sql);
	$DATAS = array();
	while($row = mysql_fetch_assoc($result)) {
	foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
		$DATAS[] = $row;
	}
	return json_encode($DATAS);
}

function getStr($language, $name) {
	$sql = "SELECT value FROM language WHERE lang='".$language."' AND name = '".$name."'";
	$result = query($sql);
	if($row = mysql_fetch_row($result)) {
		return $row[0];
	}
	else return "";
}
?>
