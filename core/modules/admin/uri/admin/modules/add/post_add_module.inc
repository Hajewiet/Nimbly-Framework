<?php

load_library('system-messages');

$module = post_get('module_name');
$repost = post_get('module_repository');


load_library('redirect');
redirect($GLOBALS['SYSTEM']['request_uri']);
