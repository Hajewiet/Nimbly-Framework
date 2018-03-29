<?php

/*
 * Accept route if it follows the pattern /thumb/img-uuid/*
 */

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) < 2 || count($parts) > 3 || $parts[0] !== 'img') {
    return;
}
$uuid = $parts[1];
load_library("data");
if (!data_exists(".files", $uuid)) {
    return;
}
$size = $parts[2] ?? 240;
$ratio = get_variable("ratio", 0);
$m = substr($size, -1);
if ($m === 'f' || $m === 'c') { // fit, crop
	$mode = $m;
	$size = rtrim($size, 'fc');
} else if ($m === 'w' || $m === 'h') { 
	$mode = $m;
	$size = rtrim($size, 'wh');
} else {
	$mode = 'h';
}

if (is_numeric($size)) { //max to full hd
	if ($mode === 'h' && $size > 1080) {
		$size = 1080;
	} else if ($mode === 'w' && $size > 1920) {
		$size = 1920;
	}
} else if ($size === 'large') {
    $size = 1080;
} else if ($size === 'medium') {
    $size = 720;
} else if ($size === 'small') {
    $size = 480;
} else if ($mode !== 'f' && $mode !== 'c') {
	$size = 240;
} else {
	$parts = explode('x', $size, 2);
	if (count($parts) == 2 && is_numeric($parts[0]) && is_numeric($parts[1])) {
		$size = $parts[0] + 0;
		$ratio = $size / ($parts[1] + 0);
	}
	if ($mode === 'c') {
		$mode = 'w';
	}
}

load_library("set");
load_library("get");
set_variable("img-ratio", $ratio);
set_variable("img-mode", $mode);
set_variable("img-uuid", $uuid);
set_variable("img-size", $size);
load_module("images");
router_accept();
