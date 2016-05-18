<?php

function set_token($params) {
    global $SYSTEM;
    $append = false;
    if (isset($params["append"])) {
        $append = get_param_value($params, "append", false);
        unset($params["append"]);
    }
    $overwrite = false;
    if (isset($params["overwrite"])) {
        $overwrite = $append == false && get_param_value($params, "overwrite", false);
        unset($params["overwrite"]);
    }
    $session = false;
    if (isset($params["session"])) {
        $session = get_param_value($params, "session", false);
        unset($params["session"]);
    }
    foreach ($params as $key => $value) {
        if ($session) {
            set_session_variable($key, $value, $append, $overwrite);
        } else {
            set_variable($key, $value, $append, $overwrite);
        }
    }

    return null;
}

function set_variable($key, $value, $append = "append", $overwrite = false) {
    global $SYSTEM;
    if (empty($SYSTEM['variables'][$key])) {
        $SYSTEM['variables'][$key] = $value;
        return;
    }
    if ($append == "append") {
        $SYSTEM['variables'][$key] .= ' ' . $value;
        return;
    }
    if (!empty($append) && $append !== false) {
        $SYSTEM['variables'][$key] .= $append . $value;
        return;
    }
    if (!empty($overwrite) && $overwrite !== false) {
        $SYSTEM['variables'][$key] = $value;
        return;
    }
}

function set_session_variable($key, $value, $append = "append", $overwrite = false) {
    run_library("session");
    if (empty($_SESSION['variables'][$key])) {
        $_SESSION['variables'][$key] = $value;
        return;
    }
    if ($append == "append") {
        $_SESSION['variables'][$key] .= ' ' . $value;
        return;
    }
    if (!empty($append) && $append !== false) {
        $_SESSION['variables'][$key] .= $append . $value;
        return;
    }
    if (!empty($overwrite) && $overwrite !== false) {
        $_SESSION['variables'][$key] = $value;
        return;
    }
}

?>
