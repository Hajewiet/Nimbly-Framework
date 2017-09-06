<?php

load_library("data");
load_library("set");
load_library("username");


//validate password reset key and user are set
$key = filter_input(INPUT_POST, 'key');
$user = filter_input(INPUT_POST, 'user');
$key_ok = validate('name', $user) === true 
	&& validate('alphanumeric', 'key') === true 
	&& data_exists("users", $user)
	&& data_load("users", $user, 'password-reset-key') === $key
	&& (username_get() === 'anonymous' || username_get() === $user);

if (!$key_ok) {
	$GLOBALS['SYSTEM']['validation_errors']['_global'][] = '[text validate_invalid_key]';
}

if (validate_error_count() === 0) {
	 $pw1 = filter_input(INPUT_POST, 'password1');
	 $pw2 = filter_input(INPUT_POST, 'password2');
	 if ($pw1 !== $pw2) {
	 	$GLOBALS['SYSTEM']['validation_errors']['_global'][] = '[text validate_password_not_equal]';
	 }
}