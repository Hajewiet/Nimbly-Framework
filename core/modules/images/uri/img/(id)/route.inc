<?php

/*
 * Accept route if it follows the pattern /thumb/img-uuid/*
 */

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) < 2 || $parts[0] !== 'img') {
    return;
}
$uuid = $parts[1];
load_library("data");
if (!data_exists(".files", $uuid)) {
    return;
}
$size = $parts[count($parts) - 1] ?? 240;
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

session_cache_limiter(false);
header('Cache-Control: private');

$t = time();
$headers = apache_request_headers();

if (isset($headers['If-Modified-Since']) && strtotime($headers['If-Modified-Since']) < $t) {
    header('Last-Modified: '. gmdate('D, d M Y H:i:s', $t).' GMT', true, 304);
    exit();
}

load_library("thumbnail", "images");
$file = thumbnail_create($uuid, $size, $ratio, $mode);

if (empty($file)) {
    return;
}

$cache_time = 315360000; //10 years
header("Expires: " . gmdate("D, d M Y H:i:s", $t + $cache_time) . " GMT");
header('Last-Modified: '. gmdate('D, d M Y H:i:s', $t).' GMT');
header('Content-Length: '. filesize($file));
header('Content-Type: image/jpg');
readfile($file);
exit();