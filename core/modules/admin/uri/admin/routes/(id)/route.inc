<?php

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) !== 3 || $parts[0] !== 'admin' || $parts[1] !== 'routes') {
    return;
}

$uuid = $parts[2];
load_library("data");
$route = data_read('.routes', $uuid);
if (empty($route)) {
    return;
}
load_library("set");
set_variables("data.routes.", $route);
set_variable("data.routes.uuid", $uuid);
load_module("admin");
router_accept();
