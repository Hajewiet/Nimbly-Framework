<?php 

function get_path_sc() {
	$stack = $GLOBALS['SYSTEM']['sc_stack'];

	if (!is_array($stack) || count($stack) < 2) {
		load_library('uri_path');
		return uri_path_sc();
	}	
	$result = $stack[count($stack)-2];
	$result = current($result);
	$result = dirname($result);
	return $result;
}