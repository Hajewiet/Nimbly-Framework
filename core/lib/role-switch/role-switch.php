<?php
/*
 * Implements role switch.
 * Usage: [role-switch tpl=nameoftemplate]
 * Result: loads nameoftemplate.anonymous, nameoftemplate.user or nameoftemplate.admin
 * depening upon the available user roles in session and the order
 */

function role_switch_sc($params) {
    load_library("session");
    $tpl = get_param_value($params, "tpl");
    if (!session_exists()) {
        run_single_sc($tpl . ".anonymous");
        return;
    }
    session_sc();
    if (!isset($_SESSION['roles'])) {
        run_single_sc($tpl . ".anonymous");
        return;
    }
    foreach ($_SESSION['roles'] as $role => $enabled) {
        if ($enabled !== true) {
            continue;
        }
        $tpl .= "." . strtolower($role);
        run_single_sc($tpl);
        break;
    } 
}