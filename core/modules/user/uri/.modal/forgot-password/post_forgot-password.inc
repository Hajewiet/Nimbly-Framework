<?php

load_library("json", "api");

$email = filter_input(INPUT_POST, 'email');

// always show the same message, even if the email does not exist:
// we do not want to give away info on who is member of our site
$msg = 'Instructions to reset your password have been sent to ' . $email;

load_library('data');
$user = data_read('users', md5($email));
if (empty($user)) {
	sleep(2);
	return json_result(['message' => $msg] , 200);
}

if ($user['email'] !== $email) {
	log_system('Error: entered email does not match user email');
	sleep(2);
	return json_result(['message' => $msg] , 200);
}

run_template('[init-email]');
load_libraries(['url', 'email', 'log', 'uuid']);
$reset_token = $user['password_reset_token'] ?? uuid_sc();
$user['password_reset_token'] = $reset_token;
$user_uuid = md5($email);
data_update('users', $user_uuid, $user);
set_variable('name', $user['name']);
set_variable('email', $email);
set_variable('reset-url', url_absolute('password-reset/' . $user_uuid . '/' . $reset_token));
$cfg = data_read('.settings', 'email-password-reset');
if (empty($cfg)) {
	log_system('Error: could not send email. setting `email-password-reset` is empty');
	sleep(2);
	return json_result(['message' => $msg] , 200);
}

$cfg['recipient'] = $email;
if (!email($cfg)) {
	sleep(1);
	log_system('Error: could not send email. Email function failed.');
}  

return json_result(['message' => $msg] , 200);