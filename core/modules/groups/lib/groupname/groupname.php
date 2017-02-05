<?php

function groupname_sc($params) {
    $group = current($params);
    $groupdata = data_load("groups", $group);
    if (is_array($groupdata) && !empty($groupdata['groupname'])) {
        $group = $groupdata['groupname'];
    }
    return $group;
}
