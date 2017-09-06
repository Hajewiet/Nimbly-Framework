<?php

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) !== 4 || $parts[0] !== 'api' || $parts[1] !== 'v1') {
    return;
}

$resource = $parts[2];
if (!data_exists($resource)) {
    return;
}

$uuid = $parts[3];
$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST' && !data_exists($resource, $uuid)) {
    return;
}

load_library('api', 'api');

return api_method_switch("resource_id", $resource, $uuid);
