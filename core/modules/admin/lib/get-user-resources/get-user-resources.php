<?php

load_library("set");
load_library("data");
load_library("access", "user");

function get_user_resources_sc($params) {
	$result = array();
    $rs = data_resources_list();
    $rs['files'] = ['name' => 'Files'];
    foreach ($rs as $k => $v) {
    	if (get_user_resources_access($k)) {
    		$result[$k] = ['key' => $k, 'name' => ucfirst(trim($k, '. '))];
    	}
    }
    set_variable("data.user-resources", $result);
}

function get_user_resources_access($k) {
	if (access_by_feature('get_' . $k)) {
		return true;
	}
	if (access_by_feature('(any)_' . $k)) {
		return true;
	}
	if (access_by_feature('manage-content')) {
		return $k !== 'roles' && $k[0] !== '.';
	}
	return false;
}