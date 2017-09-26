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
$h = 0;
if (count($parts) === 3) {
    $h = $parts[2];
}

if ($h === 'large' || (is_numeric($h) && $h > 1080)) {
    $h = 1080;
} else if ($h === 'medium') {
    $h = 720;
} else if ($h === 'small') {
    $h = 480;
} else if (!is_numeric($h) || empty($h)) {
    $h = 240;
}

load_library("set");
load_library("get");
$ratio = get_variable("ratio", 0);
set_variable("ratio", $ratio);
set_variable("img-uuid", $uuid);
set_variable("img-height", $h);
load_module("images");
router_accept();
