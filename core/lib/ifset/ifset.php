<?php

function ifset_sc($params) {
    load_library("if");
    $condition = array();
    $action = array();
    foreach ($params as $key => $value) {
        if ($key == "tpl") {
            $action[$key] = $value;
        } else if ($key == "echo") {
            $action[$key] = $value;
        } else {
            $condition[$key] = $value;
        }
    }
    if (empty($action)) {
        return;
    }
    $pass = true;
    load_library("get");
    foreach ($condition as $key => $value) {
        $val = get_sc($key);
        if (empty($val)) {
            $pass = false;
            break;
        }
    }
    if ($pass) {
        if_action($action);
    }
}


