<?php

load_library("set");
load_library("data");
load_library("access", "user");

function get_user_resources_sc($params) {
	$result = array();
    $rs = data_resources_list();
    $rs['files'] = ['name' => 'Files'];
    foreach ($rs as $k => $v) {
    	if (access_by_feature('get_' . $k) || access_by_feature('(any)_' . $k)) {
    		$result[$k] = ['key' => $k, 'name' => ucfirst(trim($k, '. '))];
    	}
    }
    set_variable("data.user-resources", $result);
}