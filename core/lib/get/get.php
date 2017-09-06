<?php

function get_sc($params, $default = null) {
    if (is_array($params)) {
        $key = current($params);
    } else {
        $key = $params;
    }
    $key = preg_replace('/[^a-zA-Z0-9._-]/', '_', $key);
    $echo = get_param_value($params, "echo", false);

    // get default value
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
    $result = $default;
    if (isset($_SESSION['variables'][$key])) {
        $result = $_SESSION['variables'][$key];
    } else if (isset($GLOBALS['SYSTEM']['variables'][$key])) {
        $result = $GLOBALS['SYSTEM']['variables'][$key];
    } else {
        $req_get = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
        if (isset($req_get)) {
            $result = $req_get;
        }
    }
    if ($echo) {
        echo $result;
        return;
    }
    return $result;
}

function get_variable($key, $default = null) {
    return get_sc($key, $default);
}
