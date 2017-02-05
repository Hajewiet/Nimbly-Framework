<?php

function if_sc($params) {
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
        //loop through and test all conditions
        if (if_condition($key, $value) !== true) {
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
        }
    }
}

function if_condition($key, $value) {
    if ($value === "(not-empty)") {
        $eval = get_sc($key);
        return !empty($eval);
    } else if ($value === "(empty)") {
        $eval = get_sc($key);
        return empty($eval);
    } else {
        $eval = get_sc($key);
        return $eval == $value;
    }
}
