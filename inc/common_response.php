<?php
function genResponse($bSuccess, $respString) {
	$tag = $bSuccess?"success":"fail";
	$respArr = array(
	"result" => $tag,
	"message" => $respString
	);
	return json_encode($respArr);
}
?>