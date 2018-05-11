<?php

function setup_modules_sc() {
	global $SYSTEM;
	foreach ($SYSTEM['env_paths'] as $env_path) {
        $path = $SYSTEM['file_base'] . $env_path . '/modules';
        if (file_exists($path)) {
            $modules = scandir($path);
            unset($modules[0]);
            unset($modules[1]);
            foreach ($modules as $module) {
            	$install_file = $path . '/' . $module . '/.install.inc';
                if (file_exists($install_file)) {
                	echo "Module {$module}: ";
                    $ok = require_once($install_file);
                    echo $ok? 'ok' : 'error';
                    echo '<br />';
                }
            }
        }
    }
}