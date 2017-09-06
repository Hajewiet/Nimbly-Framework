<?php

router_deny();

$parts = $GLOBALS['SYSTEM']['uri_parts'];
if (count($parts) !== 3 || $parts[0] !== 'api' || $parts[1] !== 'v1') {
    return;
}

$resource = $parts[2];
if (!data_exists($resource)) {
    return;
}

load_library('api', 'api');

return api_method_switch("resource", $resource);
