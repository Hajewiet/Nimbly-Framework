<?php

function group_access_sc($params) {
    $groupname = current($params);
    $group_access = user_in_group($groupname);
    if ($group_access !== true) {
        $redirect_url = get_param_value($params, "redirect", "errors/403");
        run_library("redirect");
        redirect($redirect_url);
    }
}

function load_user_groups($user=null) {
    if (empty($user)) {
        load_library("get-user", "user");
        $user = get_user();
    }
    load_library('data');
    if (empty($user['groups'])) {
        return [];
    }
    return explode(',', $user['groups']);
}

function user_in_group($groupname, $user = null) {
    $groups = load_user_groups($user);
    return is_array($groups) && in_array($groupname, $groups);
}

