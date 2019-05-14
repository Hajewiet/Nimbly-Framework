<?php 

$parts = router_match(__FILE__);
if ($parts === false || count($parts) !== 2) {
    return;
}

load_library('data');
$uuid = $parts[0];
if (!(data_exists("users", $uuid))) {
    return;
}

$user = data_read("users", $uuid);
$key = $parts[1];
if ($user['password_reset_token'] !== $key) {
	return;
}

load_library('get-user', 'user');
$loggedin_user = get_user();
if (!empty($loggedin_user['email'])) {
	return; //user already logged in
}

load_library('set');
set_variable('username', $user['name']);
set_variable('useruuid', $uuid);

router_accept();