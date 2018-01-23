<?php
$url = $_REQUEST['u'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$my_var = curl_exec($ch);
curl_close($ch);
?>