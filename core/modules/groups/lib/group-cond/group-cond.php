<?php

/*
 * Implements group based template loading
 * Usage: [group-cond vips  tpl=nameoftemplate]
 * Result: loads nameoftemplate if user is member of group vips
 */

function group_cond_sc($params) {

    $tpl = get_param_value($params, "tpl", null);
    if (empty($tpl)) {
        load_library("log");
        log_system("[group-cond] used without tpl=nameoftemplate");
        return;
    }

    load_library("group-access");
    load_library("username", "user");
    $user = get_param_value($params, "user", username_get());
    $group = get_param_value($params, "group", current($params));
    $group_ls = load_user_groups($user);

    if ($group === "(none)" && empty($group_ls)) {
        run_single_sc($tpl);
        return;
    }

    if (empty($group_ls)) {
        return;
    }

    if ($group === "(any)" || in_array($group, $group_ls)) {
        run_single_sc($tpl);
        return;
    }

    if ($group === "(non-public)" && (count($group_ls) > 1 || current($group_ls) !== "public")) {
        run_single_sc($tpl);
        return;
    }


}
