<?php

function if_sc($params) {
    $condition = array();
    $negate = false;
    $action = array();
    foreach ($params as $key => $value) {
        if ($key === "tpl" || $key === "echo" || $key === "redirect") {
            $action[$key] = $value;
        } else if ($key === "not") {
            $negate = true;
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
        //loop through and test all conditions
        if (if_condition($key, $value, $negate) !== true) {
            $pass = false;
            break;
        }
    }
    if ($pass) {
        //perform the action
        if_action($action);
    }
}

function if_action($action) {
    foreach ($action as $key => $value) {
        switch ($key) {
            case 'tpl': //run a template
                run_single_sc($value);
                break;
            case 'echo': //echo a value
                echo $value;
                break;
            case 'redirect': //redirect to url
                load_library("redirect");
                redirect($value);
                break;
        }
    }
}

function if_condition($key, $value, $negate = false) {
    $result = null;
    if ($value === "(not-empty)") {
        $eval = get_sc($key);
        $result = !empty($eval);
    } else if ($value === "(empty)") {
        $eval = get_sc($key);
        $result = empty($eval);
    } else {
        $eval = get_sc($key);
        $result = $eval == $value;
    }
    if ($negate === false) {
        return $result;
    } else {
        return !$result;
    }
}
