<?php

/*
 * @doc `[lookup resource uuid key]` gets value of field key for a specific resource, 
 * @doc e.g. `[lookup users admin@local.test fullname]` to get the fullname field
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

function lookup_data($resource, $uuid, $key, $default = '') {
    $var = "data." . trim($resource, '.');
    if (!isset($GLOBALS['SYSTEM']['variables'][$var])) {
        load_library("data");
        data_sc(array("resource" => $resource));
    }
    $data = $GLOBALS['SYSTEM']['variables'][$var];
    if (isset($data[$uuid][$key])) {
        return $data[$uuid][$key];
    }
    return $default;
}
