<?php 

function show_system_log_sc() {
	$file = $GLOBALS['SYSTEM']['file_base'] . 'ext/data/.tmp/logs/system.log';
	if (!file_exists($file)) {
		touch($file);
		chmod($file, 0640);
	}
    echo nl2br(file_get_contents($file));
}
