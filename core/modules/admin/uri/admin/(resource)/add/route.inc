<?php

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) !== 3 || $parts[0] !== 'admin' || $parts[2] !== 'add') {
    return;
}
$resource = $parts[1];
load_library("data");
if (!data_exists($resource)) {
    return;
}
$meta = data_meta($resource);

// store data and fields and render the page
load_library("set");
set_variable("data.resource", $resource);
set_variable("data.fields", $meta['fields']);
set_variables("data.field.", $meta['fields']);
load_module("admin");
router_accept();
