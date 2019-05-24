<?php

run_single_sc('init-email');
load_library("json", "api");
load_library("get-user", "user");
load_libraries(["salt", "encrypt"]);
load_libraries(['url', 'email', 'log', 'uuid']);
$user = get_user();
$email = filter_input(INPUT_POST, 'newemail');
$token = $user['change_email_token'] ?? uuid_sc();
$user['change_email_token'] = $token;
data_update('users', $user['uuid'], [
	'new_email' => $email, 
	'change_email_token' => $token
]);

set_variable('name', $user['name']);
set_variable('email', $email);
set_variable('change-email-url', url_absolute('change-email/' . $user['uuid'] . '/' . md5($email) . '/' . $token));
$cfg = data_read('.settings', 'email-change-email');

if (empty($cfg)) {
	log_system('Error: could not send email. setting `email-change-email` is empty');
	return json_result(['message' => 'Uh oh. Email not configured'] , 400);
}

$cfg['recipient'] = $email;
if (!email($cfg)) {
	log_system('Error: could not send email. Email function failed.');
	return json_result(['message' => 'Uh oh. Sending email failed'] , 400);
}  

return json_result(['message' => 'Instructions on how to confirm your new email address have been sent to ' . $email] , 200);