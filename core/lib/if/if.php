<?php

/*
 * Implements the if token
 */


function if_token($params) {
    $condition = array();
    $action = array();
    foreach ($params as $key => $value) {    
        if ($key == "tpl") {
            $action[$key] = $value;  
        } else if ($key == "echo") {
            $action[$key] = $value;  
        }  else {
            $condition[$key] = $value;
        }
    }
    if (empty($action)) {
        return;
    }
    $pass = true;
    load_library("get");
    foreach ($condition as $key => $value) {
        $val = get_token($key);
        if ($val != $value) {
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
            case 'tpl':
                run_single_token($value);
                break;
            case 'echo':
                echo $value;
                break;
        }
    }
}

?>
