<?php

function get_sc($params, $default = null) {
    if (is_array($params)) {
        $key = current($params);
    } else {
        $key = $params;
    }

    //get default value
    if ($default === null && is_array($params) && count($params) >= 2) {
        $d = get_param_value($params, "default");
        if ($d === null) {
            $d = next($params);
            $k = key($params);
            if ($k === $d) {
                $default = $d;
            }
        } else {
            $default = $d;
        }
    }
    if (isset($_SESSION['variables'][$key])) {
        return $_SESSION['variables'][$key];
    }
    if (isset($GLOBALS['SYSTEM']['variables'][$key])) {
        return $GLOBALS['SYSTEM']['variables'][$key];
    }
    $req_get = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
    if (isset($req_get)) {
        return $req_get;
    }
    return $default;
}

function get_variable($key, $default = null) {
    return get_sc($key, $default);
}
