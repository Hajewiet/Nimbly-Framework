<?php

load_library("session");

/*
 * Implements feature based template loading
 * Usage: [feature-cond features=nameoffeature tpl=nameoftemplate]
 * Result: loads nameoftemplate if user has feature nameoffeature
 */

function feature_cond_sc($params) {
    $features = get_param_value($params, "features", current($params));
    $tpl = get_param_value($params, "tpl", null);
    $tpl_else = get_param_value($params, "tpl_else", null);
    $echo = get_param_value($params, "echo", null);
    $echo_else = get_param_value($params, "echo_else", null);

    if (empty($features) || empty($tpl) || !session_exists()) {
        return;
    }

    session_sc();
    $features_ls = explode(',', $features);

    if (!isset($_SESSION['features'])) {
        return;
    }

    $access = isset($_SESSION['features']['(all)']) && $_SESSION['features']['(all)'] === true;

    if ($access !== true) {
        foreach ($features_ls as $f) {
            if (!empty($_SESSION['features'][$f]) && $_SESSION['features'][$f] === true) {
                $access = true;
                break;
            }
        }
    }

    if ($access === true) {
        if ($tpl) {
            run_single_sc($tpl);
        }
        if ($echo) {
            echo $echo;
        }
    } else {
        if ($tpl_else) {
            run_single_sc($tpl_else);
        }
        if ($echo_else) {
            echo $echo_else;
        }
    }
}
