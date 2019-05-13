<?php

function app_modified_sc() {
	static $result = false;
	if (!empty($result)) {
		return $result;
	}
	$base = $GLOBALS['SYSTEM']['file_base'];
	$paths = ['core/.git/index', 'contrib/modules/.git/index', 'ext/.git/index'];
	$result = 1500000001;
	foreach ($paths as $p) {
		$f = $base . $p;
		if (!file_exists($f)) {
			continue;
		}
		$t = filemtime($f);
		if ($t > $result) {
			$result = $t;
		}
	}
	$result = $result - 1500000000;
	echo $result;
}