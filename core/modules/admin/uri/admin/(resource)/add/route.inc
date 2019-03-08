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
load_library("access", "user");
load_library("get-user-resources", "admin");
if (access_by_feature('manage-content') && get_user_resources_access($resource)) {
	$_SESSION['features']['manage-' . $resource] = true;
}
load_module("admin");
router_accept();
