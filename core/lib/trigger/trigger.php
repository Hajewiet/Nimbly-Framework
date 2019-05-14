<?php

function trigger_sc($params) {
	// todo: shortocde implementation
}

// trigger in all contrib and ext modules having a (modulename)-on-(eventname) lib function
function trigger($event, $data) {
        global $SYSTEM;
        $envs = $SYSTEM['env_paths'];
        foreach ($envs as $env_path) {
        	if ($env_path === 'core') {
        		continue;
        	}
        	$base_path = $SYSTEM['file_base'] . $env_path . '/modules/';
        	if (!file_exists($base_path)) {
        		continuie;
        	}

        	$modules = scandir($base_path);
                foreach ($modules as $module) {
                	if ($module[0] === '.') {
                		continue;
                	}
                	$hname = $module . '-on-' . $event;
                	$lib_path = $base_path . $module . '/lib/' . $hname;
                	if (!file_exists($lib_path)) {
                		continue;
                	}
                	$file = $lib_path . '/' . $hname . '.php';
                	if (!file_exists($file)) {
                		continue;
                	}
                	require_once($file);
                	$function_name = str_replace("-", "_", $hname);
                	if (!function_exists($function_name)) {
                		continue;
                	}
                	$function_name($data);
                }
        }
}