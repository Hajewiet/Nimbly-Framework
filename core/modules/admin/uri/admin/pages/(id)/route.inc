<?php

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) !== 3 || $parts[0] !== 'admin' || $parts[1] !== 'pages') {
    return;
}
load_library("pages", "api");
$page = pages_find_by_key($parts[2]);
if (empty($page)) {
    return;
}
load_library("set");
set_variables("data.page.", current($page));
set_variable("data.page.uuid", $parts[2]);
load_module("admin");
router_accept();
