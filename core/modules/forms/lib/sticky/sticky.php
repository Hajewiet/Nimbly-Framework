<?php

function sticky_sc($params) {
    if (empty($params)) {
        return;
    }
    $default = get_param_value($params, "default", false);
    unset($params["default"]);
    $key = current($params);
    $value = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
    if (empty($value)) {
        load_library("get");
        $value = get_sc("sticky." . $key);
    }
    if (!isset($value)) {
        $value = $default;
    }
    return $value;
}
