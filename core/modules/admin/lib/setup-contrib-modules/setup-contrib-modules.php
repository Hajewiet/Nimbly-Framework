<?php

function setup_contrib_modules_sc() {

	_scmout('Setup contrib modules', 'lightgray');

    /* change directory */

    $dir = $GLOBALS['SYSTEM']['file_base'] . 'contrib/modules';
    if (!file_exists($dir)) {
    	_scmout('ERROR. Path does not exists: ' . $dir, 'tomato');
    	return;
    }

    if (@chdir($dir) !== true) {
    	_scmout('ERROR. Could not change directory to ' . $dir, 'tomato');
        return;
    }

    /* initialize git */
    if (!file_exists($dir . '/.git')) {
    	_scmout('Initialize GIT repository', 'lightgray');
    	_scmin('git init');
    	if (!file_exists($dir . '/.git')) {
    		_scmout('ERROR. Could not init git', 'tomato');
    		return;
    	}
    	_scmin('git remote add -f origin git@github.com:Volst/nimbly-modules.git');
    	_scmin('git config core.sparseCheckout true');
    }

    /* configure which modules to sparse checkout */
    $file = $dir . '/.git/info/sparse-checkout';
    if (!file_exists($file)) {
    	touch($file);
    	chmod($file, 0750);
    }

    /* get modules from file */
    $modules = ['pull', 'blog'] // todo automatic
    $content = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($content as $c) {
    	_scmout($c, 'yellow');
    }

    _scmin('git pull origin master');
}

function _scmout($msg, $color='lime') {
	echo sprintf('<pre style="background-color: black; color: %s;">$ %s</pre>', $color, $msg);
}

function _scmin($cmd) {
	_scmout($cmd);
	_scmout(shell_exec($cmd . ' 2>&1'));
}