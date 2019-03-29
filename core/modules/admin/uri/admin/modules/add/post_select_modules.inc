<?php

load_library('system-messages');

$file = $GLOBALS['SYSTEM']['file_base'] . 'contrib/modules/.git/info/sparse-checkout';
if (!file_exists($file)) {
	system_message('ERROR. File does not exist: ' . $file);
} else {
	$modules = filter_input(INPUT_POST, 'modules', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
	$content = "";
	foreach ($modules as $m) {
		$content .= $m . '/' . PHP_EOL;		
	}
	file_put_contents($file, $content);
}

load_library('redirect');
redirect($GLOBALS['SYSTEM']['request_uri']);
