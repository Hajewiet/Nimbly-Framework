<?php

load_library('get-user', 'user');
load_library("json", "api");
$user = get_user();
if (empty($user)) {
	return json_result(['message' => 'You are not logged in'], 400);
}
load_library('encrypt');
$current_pw = filter_input(INPUT_POST, 'password');
$validate_ok = empty($current_pw) && empty($user['password']);
$validate_ok |= hash_equals($user['password'], encrypt($current_pw, $user['salt']));
$current_pw = false;
$validate_ok &= validate_field('password', 'newpw1') === true;
$validate_ok &= validate_field('password', 'newpw2') === true;
$validate_ok &= filter_input(INPUT_POST, 'newpw1') === filter_input(INPUT_POST, 'newpw2');
if (!$validate_ok) {
	load_library("text");
	return json_result(['message' => text_sc(['validate_invalid_password'])], 400);
}