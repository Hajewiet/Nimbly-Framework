<?php

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) !== 2 || $parts[0] !== 'admin') {
    return;
}
$resource = $parts[1];
load_library("data");
if (!data_exists($resource)) {
    return;
}

$items = data_read($resource);
if (empty ($items)) {
    $items = null;
}

$meta = data_meta($resource, $items);

if (isset($meta['sort'])) {
    $items = data_sort_meta($items, $meta['sort']);
}

// store data and fields and render the page
load_library("set");
set_variable("data.resource", $resource);
set_variable("data.records", $items);
$meta['fields'] = data_exclude($meta['fields'], 'admin_col', false);
set_variable("data.fields", $meta['fields']);
load_module("admin");
router_accept();
