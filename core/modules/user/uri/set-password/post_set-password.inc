<?php

/*
 * Update password
 */


load_libraries(array("salt", "url", "data", "system-messages", "encrypt", "redirect", "get", "log"));
$salt = salt_sc();
$user_data = array(
    "salt" => $salt,
    "password" => encrypt($pw1, $salt),
    "password-reset-key" => ""
);
data_update("users", $user, $user_data);
system_message("Password set success");

/*
 * Login
 */

persist_login($user, $pw2);
$url = filter_input(INPUT_POST, 'go');
if (empty($url)) {
	$url = get_variable("login-url");
}
redirect($url);
