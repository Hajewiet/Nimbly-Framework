<?php

function setup_contrib_modules_sc() {

	load_library('system-messages');

    /* change directory */

    $dir = $GLOBALS['SYSTEM']['file_base'] . '/contrib/modules';
    if (!file_exists($dir)) {
    	_scmout('ERROR. Path does not exists: ' . $dir);
    	return;
    }

    if (@chdir($dir) !== true) {
    	_scmout('ERROR. Could not change directory to ' . $dir);
        return;
    }

    /* initialize git */
    if (!file_exists($dir . '/.git')) {
    	_scmout('Initialize GIT repository');
    	_scmin('git init');
    	if (!file_exists($dir . '/.git')) {
    		_scmout('ERROR. Could not init git');
    		return;
    	}
    	_scmin('git remote add -f origin git@github.com:Volst/nimbly-modules.git');
    	_scmin('git config core.sparseCheckout true');
    }

    /* configure which modules to sparce checkout */
    $file = $dir . '/.git/info/sparse-checkout';
    if (!file_exists($file)) {
    	touch($file);
    	chmod($file, 0750);
    }
}

function _scmout($msg) {
	echo $msg . '<br />';
}

function _scmin($cmd) {
	_scmout($cmd);
	_scmout(shell_exec($cmd . ' 2>&1'));
}