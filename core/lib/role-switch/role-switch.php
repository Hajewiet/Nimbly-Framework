<?php
/*
 * Implements role switch.
 * Usage: [role-switch tpl=nameoftemplate]
 * Result: loads nameoftemplate.anonymous, nameoftemplate.user or nameoftemplate.admin
 * depening upon the available user roles in session and the order
 */

function role_switch_token($params) {
    load_library("session");
    $tpl = get_param_value($params, "tpl");
    if (!session_exists()) {
        run_single_token($tpl . ".anonymous");
        return;
    }
    session_token();
    if (!isset($_SESSION['roles'])) {
        run_single_token($tpl . ".anonymous");
        return;
    }
    foreach ($_SESSION['roles'] as $role => $enabled) {
        if ($enabled !== true) {
            continue;
        }
        $tpl .= "." . strtolower($role);
        run_single_token($tpl);
        break;
    } 
}