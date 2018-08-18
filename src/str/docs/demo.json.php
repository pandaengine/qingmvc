<?php

/**
 *
 * @param string $json
 * @param string $assoc 当该参数为 TRUE 时，将返回 array 而非 object 。
 * @return array
 */
function jsondecode($json,$assoc=true){
	return json_decode($json,$assoc);
}
/**
 *
 * @param array $value
 * @return string
 */
function jsonencode(array $value){
	return json_encode($value,JSON_UNESCAPED_UNICODE);
}

?>