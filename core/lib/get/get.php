<?php

function get_token($params, $default=null) {
    if (is_array($params)) {
        $key = current($params);
    } else {
        $key = $params;
    }
    if (isset($_SESSION['variables'][$key])) {
        return $_SESSION['variables'][$key];
    }
    if (isset($GLOBALS['SYSTEM']['variables'][$key])) {
        return $GLOBALS['SYSTEM']['variables'][$key];
    }
    return $default;
}

?>