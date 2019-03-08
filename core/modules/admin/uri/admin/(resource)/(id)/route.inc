<?php

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) !== 3 || $parts[0] !== 'admin') {
    return;
}
$resource = $parts[1];
$uuid = $parts[2];
load_library("data");
if (!data_exists($resource, $uuid)) {
    return;
}
$meta = data_meta($resource);
$record = data_read($resource, $uuid);

// store data and fields and render the page
load_library("set");
set_variable("data.uuid", $uuid);
set_variable("data.resource", $resource);
set_variable("data.fields", $meta['fields']);
set_variables("data.field.", $meta['fields']);
set_variable_dot('record', $record);
load_library("access", "user");
load_library("get-user-resources", "admin");
if (access_by_feature('manage-content') && get_user_resources_access($resource)) {
	$_SESSION['features']['manage-' . $resource] = true;
}
load_module("admin");
router_accept();
