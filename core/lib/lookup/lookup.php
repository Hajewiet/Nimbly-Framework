<?php

/*
 * In-memory data lookup
 */
function lookup_sc($params) {
    if (count($params) < 3) {
        return;
    }

    $resource = get_param_value($params, "resource", current($params));
    $uuid = get_param_value($params, "uuid", next($params));
    $key = get_param_value($params, "key", next($params));

    $v = lookup_data($resource, $uuid, $key);
    echo $v;
}

function lookup_data($resource, $uuid, $key) {
    $var = "data." . $resource;
    if (!isset($GLOBALS['SYSTEM']['variables'][$var])) {
        load_library("data");
        data_sc(array("resource" => $resource));
    }
     $data = $GLOBALS['SYSTEM']['variables'][$var];
    if (isset($data[$uuid][$key])) {
        return $data[$uuid][$key];
    } else {
        return get_param_value($params, "default", "");
    }
}
