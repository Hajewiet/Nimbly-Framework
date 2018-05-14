<?php

/*
 * In-memory data lookup
 */
function reverse_lookup_sc($params) {
    if (count($params) < 3) {
        return '';
    }
    $resource = get_param_value($params, "resource", current($params));
    $value = get_param_value($params, "value", next($params));
    $key = get_param_value($params, "key", next($params));
    return lookup_data($resource, $value, $key);
}

function reverse_lookup_data($resource, $value, $key) {
    $var = "data." . $resource;
    if (!isset($GLOBALS['SYSTEM']['variables'][$var])) {
        load_library("data");
        data_sc(array("resource" => $resource));
    }
    $data = $GLOBALS['SYSTEM']['variables'][$var];
    foreach ($data as $uuid => $record) {
        if (!isset($record[$key]) ) {
            continue;
        }
        if ($record[$key] === $value) {
            return $uuid;
        }
    }
}
