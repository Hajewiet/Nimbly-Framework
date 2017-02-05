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

function load_user_groups($username=null) {
    if ($username === null) {
        load_library("username", "user");
        $username = username_get();
    }
    load_library('data');
    $groups = data_load('users', $username, 'groups');
    if (!empty($groups)) {
        $result = explode(',', $groups);
    } else {
        $result = array();
    }
    return $result;
}

function user_in_group($groupname, $username = null) {
    $groups = load_user_groups($username);
    return is_array($groups) && in_array($groupname, $groups);
}

