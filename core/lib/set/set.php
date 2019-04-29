<?php

function set_sc($params) {
    global $SYSTEM;
    $if_exists = false;
    if (isset($params["append"])) {
        $if_exists = get_param_value($params, "append", false);
        unset($params["append"]);
    } else if (isset($params["overwrite"])) {
        $if_exists = true;
        unset($params["overwrite"]);
    }
    $session = false;
    if (isset($params["session"])) {
        $session = get_param_value($params, "session", false);
        unset($params["session"]);
    }
    foreach ($params as $key => $value) {
        if ($session) {
            persist_variable($key, $value, $if_exists);
        } else {
            set_variable($key, $value, $if_exists);
        }
    }
    return null;
}

function set_variable($rkey, $value, $if_exists = true) {
    global $SYSTEM;
    $key = preg_replace('/[^a-zA-Z0-9._-]/', '_', $rkey);
    if (empty($SYSTEM['variables'][$key]) || $if_exists === true) {
        $SYSTEM['variables'][$key] = $value;
    } else if (is_string($if_exists)) {
        $SYSTEM['variables'][$key] .= $if_exists . $value;
    }
}

// store variable in session or cookie
function persist_variable($key, $value, $if_exists=true) {
    load_library('session');
    if (session_resume() && isset($_SESSION['variables'])) {
        set_session_variable($key, $value, $if_exists);
    } else if (empty($_COOKIE[$key]) || $if_exists === true) {
        setcookie($key, $value, time() + (30*86400), "/");
    } else if (is_string($if_exists)) {
        setcookie($key, $_COOKIE[$key] . $if_exists . $value, time() + (30*86400), "/");
    }
}

function set_session_variable($rkey, $value, $if_exists=true) {
    run_library("session");
    $key = preg_replace('/[^a-zA-Z0-9._-]/', '_', $rkey);
    if (empty($_SESSION['variables'][$key]) || $if_exists === true) {
        $_SESSION['variables'][$key] = $value;
        return;
    } 
    if (is_string($if_exists)) {
        $_SESSION['variables'][$key] .= $if_exists . $value;
    }
}

function clear_variable($name) {
    global $SYSTEM;
    if (isset($SYSTEM['variables'][$name])) {
         unset($SYSTEM['variables'][$name]);
         return;
    }
    $prefix = $name;
    foreach($SYSTEM['variables'] as $k => $v) {
        if (substr($k, 0, strlen($prefix)) === $prefix) {
            unset($SYSTEM['variables'][$k]);
        }
    }
}

function set_variables($prefix, $vs, $if_exists = true) {
    foreach ($vs as $key => $value) {
        set_variable($prefix . $key, $value, $if_exists);
    }
}

function set_variable_dot($key, $value) {
    global $SYSTEM;
    if (is_scalar($value)) {
        $SYSTEM['variables'][$key] = $value;
        return;
    }
    if (is_array($value) || is_object($value)) {
        foreach($value as $k => $v) {
            set_variable_dot($key . '.' . $k, $v);
        }
    }
}

function clear_variable_dot($key) {
    clear_variable($key . '.');
}