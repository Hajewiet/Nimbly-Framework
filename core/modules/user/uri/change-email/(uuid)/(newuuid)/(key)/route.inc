<?php 

$parts = router_match(__FILE__);
if ($parts === false || count($parts) !== 3) {
    return;
}
load_library('data');
$uuid = $parts[0];
if (!(data_exists("users", $uuid))) {
    return;
}
$user = data_read("users", $uuid);
if (empty($user['new_email'])) {
	return;
}
$newuuid = $parts[1];
if ($newuuid !== md5($user['new_email'])) {
	return;
}
if (empty($user['change_email_token'])) {
	return;
}
$key = $parts[2];
if ($user['change_email_token'] !== $key) {
	return;
}

// logout
run_library('session');
$_SESSION = array();
session_initialize();

load_library('set');
set_variable('old_email', $user['email']);
set_variable('new_email', $user['new_email']);
set_variable('name', $user['name']);

load_library('uuid');
$user['change_email_token'] = uuid_sc();
$user['old_email'] = $user['email'];
$user['email'] = $user['new_email'];
data_update('users', $uuid, $user); //updates the pk too

// todo: update ownership (_created_by, _modified_by) of data and personal data like uploads/uuid/...

router_accept();