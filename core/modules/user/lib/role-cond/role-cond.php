<?php

/*
 * Implements role based template loading
 * Usage: [role-cond roles=admin,editor tpl=nameoftemplate]
 * Result: loads nameoftemplate if user role is admin or editor
 */

function role_cond_sc($params) {
    load_library("session");
    $roles = get_param_value($params, "roles", current($params));
    $tpl = get_param_value($params, "tpl", null);
    $tpl_else = get_param_value($params, "tpl_else", null);

    if (empty($roles) || empty($tpl)) {
        return;
    }

    session_sc();
    $roles_ls = explode(',', $roles);

    if (!isset($_SESSION['roles'])) {
        return;
    }

    foreach ($roles_ls as $r) {
        if (!empty($_SESSION['roles'][$r]) && $_SESSION['roles'][$r] === true) {
            run_single_sc($tpl);
            return;
        }
    }

    if (!empty($tpl_else)) {
        run_single_sc($tpl_else);
    }
}
