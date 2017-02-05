<?php

/*
 * Accept route if it follows the pattern /groupname
 */

$uri = $GLOBALS['SYSTEM']['request_uri'];
$parts = explode("/", $uri);
if (count($parts) === 1) {
    load_library("group-access", "groups");
    $group = $parts[0];
    $is_member = user_in_group($group);
    if (router_accept($is_member)) {
        load_library("set");
        set_variable("group", $group);
        $groupdata = data_load("groups", $group);
        if (is_array($groupdata) && !empty($groupdata['groupname'])) {
            set_variable("groupname", $groupdata['groupname']);
        } else {
            set_variable("groupname", $group);
        }
    }
}
