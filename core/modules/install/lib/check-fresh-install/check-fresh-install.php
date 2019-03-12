<?php

load_library('set');
load_library('get');

/*
 * Sets variable fresh_install to yes or no (or deny access)
 */

function check_fresh_install_sc($params) {
	if (empty($_SERVER['PEPPER'])) {
		set_variable('fresh_install', 'yes');
	} else {
		set_variable('fresh_install', 'no');
	}
}