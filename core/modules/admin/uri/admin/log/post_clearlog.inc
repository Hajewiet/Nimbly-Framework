<?php

$file = $GLOBALS['SYSTEM']['file_base'] . 'ext/data/.tmp/logs/system.log';
unlink($file);

load_library('log');
log_system('Cleared log file');

load_library('system-messages');
system_message('Log cleared');