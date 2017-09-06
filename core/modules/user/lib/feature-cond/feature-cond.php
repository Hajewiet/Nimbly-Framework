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

    if (empty($features) || empty($tpl) || !session_exists()) {
        return;
    }

    session_sc();
    $features_ls = explode(',', $features);

    if (!isset($_SESSION['features'])) {
        return;
    }

    if (isset($_SESSION['features']['(all)']) && $_SESSION['features']['(all)'] === true) {
        run_single_sc($tpl);
        return;
    }

    foreach ($features_ls as $f) {
        if (!empty($_SESSION['features'][$f]) && $_SESSION['features'][$f] === true) {
            run_single_sc($tpl);
            return;
        }
    }

    if (!empty($tpl_else)) {
        run_single_sc($tpl_else);
    }
}
