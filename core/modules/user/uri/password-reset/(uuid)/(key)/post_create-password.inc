<?php

load_library('data');
$password = filter_input(INPUT_POST, 'password');
$user_uuid = get_variable('useruuid');
$user = data_read('users', $user_uuid);
load_library('salt');
load_library('encrypt');
$user['salt'] = salt_sc();
$user['password'] = encrypt($password, $user['salt']);
data_update('users', $user_uuid, $user);
load_library('system-messages');
system_message('New password created successfully!');
load_library('redirect');
redirect('login');