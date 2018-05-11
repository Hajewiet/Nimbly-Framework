<?php

load_library('set');
load_library('get');

/*
 * Sets variable fresh_install to yes or no (or deny access)
 */

function check_fresh_install_sc($params) {
	if (get_variable('force_fresh_install') === 'yes') {
		set_variable('fresh_install', 'yes');
	} else if (empty($_SERVER['PEPPER'])) {
		set_variable('fresh_install', 'yes');
	} else if (!file_exists($GLOBALS['SYSTEM']['file_base'] . '.htaccess')) {
		set_variable('fresh_install', 'yes');
	} else {
		load_library('access', 'user');
		if (access_by_feature('install')) {
			set_variable('fresh_install', 'no');
		} else {
			run_uri('errors/404');
		}
	}
}