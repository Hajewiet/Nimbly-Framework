<?php

load_library("json", "api");

$email = filter_input(INPUT_POST, 'email');

// always show the same message, even if the email does not exist:
// we do not want to give away info on who is member of our site
$msg = 'Instructions to reset your password have been sent to ' . $email;

load_library('data');
$user = data_read('users', md5($email));
if (empty($user)) {
	return json_result(['message' => $msg] , 200);
}

load_library('email');
set_variable('name', $user['name']);
set_variable('email', $email);
set_variable('url', url_absolute('password-reset'));
$cfg = data_read('.settings', 'password-reset-email');
if (empty($cfg)) {
	log_system('Error: could not send email. setting `password-reset-email` is empty');
	return;
}
$cfg['recipient'] = $data['email'];
if (!email($cfg)) {
	log_system('Error: could not send email. Email function failed.');
}  
