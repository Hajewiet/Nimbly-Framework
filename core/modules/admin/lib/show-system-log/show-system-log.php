<?php 

function show_system_log_sc() {
	$file = $GLOBALS['SYSTEM']['file_base'] . 'ext/data/.tmp/logs/system.log';
    echo nl2br(file_get_contents($file));
    print($doesnotexist);
}
