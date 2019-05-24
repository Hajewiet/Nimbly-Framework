<?php

load_library('get-user', 'user');
load_library("json", "api");
$user = get_user();
if (empty($user)) {
	return json_result(['message' => 'You are not logged in'], 400);
}
load_libraries(['encrypt', 'data']);
$new_email = filter_input(INPUT_POST, 'newemail');
$current_pw = filter_input(INPUT_POST, 'password');
$validate_ok = empty($current_pw) && empty($user['password']);
$validate_ok |= hash_equals($user['password'], encrypt($current_pw, $user['salt']));
$validate_ok &= validate_field('email', 'newemail') === true;
$validate_ok &= data_exists('users', md5($new_email)) === false;
if (!$validate_ok) {
	load_library("text");
	return json_result(['message' => text_sc(['validate_invalid_email_or_password'])], 400);
}