<?php

load_library('get-user', 'user');

function userfield_sc($params) {
	$field = get_param_value($params, 'field', current($params));
	$uuid = get_param_value($params, 'uuid', end($params));
	return userfield($field, $uuid);
}

function userfield($field, $uuid=false) {
	if (empty($uuid) || $uuid === $field) {
		$user = get_user();
	} else {
		$user = get_user($uuid);
	}
	return $user[$field] ?? '';
}