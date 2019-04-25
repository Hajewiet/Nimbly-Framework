<?php

function form_key_sc($params) { 
    $key = form_key_get();
    if (get_single_param_value($params, "plain", true, false)) {
        return $key;
    }
    $result = '<input type="hidden" name="form_key" value="' . $key . '" />';
    if (!empty($params)) {
        if (isset($params['name'])) {
            $name = $params['name'];
        } else {
            $name = current($params);
        }
        $result .= '<input type="hidden" name="form_id" value="' . $name . '" />';
    }
    return $result;
}

function form_key_get() {
    load_library('session');
     if (session_resume() && isset($_SESSION['key'])) {
        $key = $_SESSION['key'];
    } else if (isset($_COOKIE['key'])) {
        $key = $_COOKIE['key'];
    } else {
        $key = md5(uniqid(rand(), true));
        setcookie('key', $key, time() + (30*86400), "/");
    }
    return $key;
}
