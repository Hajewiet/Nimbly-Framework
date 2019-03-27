<?php

$module = post_get('module_name');
$path = post_get('module_path');
$file = $path . '/.install.inc';
$ok = require_once($file);
load_library('system-messages');

if ($ok) {
	system_message('Module `' . $module . '` installed succesfully');
} else {
	system_message('Could not install module `' . $module . '`. You might want to check the <a href="log">error log</a>');
}

load_library('redirect');
redirect($GLOBALS['SYSTEM']['request_uri']);