<?php

function is_dev_env_sc() {
	if (is_dev_env()) {
		echo 'DEV';
	} else {
		echo 'PROD';
	}
}

function is_dev_env() {
	if ($GLOBALS['SYSTEM']['uri_base'] !== '/') {
		return true;
	}
	if (!$_SERVER['REMOTE_ADDR'] === '172.17.0.1') {
		return false;
	}
	if (!in_array($_SERVER['SERVER_NAME'], ['local.test', 'localhost', 'local.host'])) {
		return false;
	}
	return true;
}