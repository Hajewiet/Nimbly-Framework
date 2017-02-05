<?php

global $SYSTEM;
$SYSTEM['modules']['root'] = '/';

function find_uri($name, $tpl_name = "index.tpl") {
    $result = find_path($name, 'uri', $tpl_name);
    if ($result == false && count($GLOBALS['SYSTEM']['modules']) == 1) {
        global $SYSTEM;
        $modules_temp = $SYSTEM['modules'];
        find_all_modules('uri');
        foreach ($modules_temp as $key => $module) {
            unset($SYSTEM['modules'][$key]);
        }
        $result = find_path($name, 'uri', $tpl_name);
        $SYSTEM['modules'] = $modules_temp;
    }
    return $result;
}

function find_template($name, $dir = null) {
    global $SYSTEM;

    if (isset($dir)) {
        foreach ($SYSTEM['env_paths'] as $env_path) {
            foreach ($SYSTEM['modules'] as $module_path) {
                $path = $SYSTEM['file_base'] . $env_path . $module_path . $dir . '/' . $name . ".tpl";
                if (file_exists($path)) {
                    return $path;
                }
            }
        }
    }

    $path = find_path($SYSTEM['uri'], 'uri', $name . ".tpl");
    if ($path !== false) {
        return $path;
    }
    $path = find_path($name, 'tpl');
    if ($path !== false) {
        return $path;
    }
    if (!empty($SYSTEM['sc_stack']) && count($SYSTEM['sc_stack']) > 0) {
        foreach ($SYSTEM['sc_stack'] as $sc_stack_item) {
            $sc_name = key($sc_stack_item);
            $path = find_path($sc_name, 'tpl', $name . ".tpl");
            if ($path !== false) {
                return $path;
            }
        }
    }
    return false;
}

function find_library($name) {
    return find_path($name, 'lib', $name . ".php");
}

function infinite_loop($path) {
    global $SYSTEM;
    if (!empty($SYSTEM['sc_stack'])) {
        foreach ($SYSTEM['sc_stack'] as $sc_level) {
            $parent_path = current($sc_level);
            if ($parent_path == $path) {
                return true;
            }
        }
    }
    return false;
}

function find_path($name, $path, $target = "index.tpl") {
    global $SYSTEM;
    foreach ($SYSTEM['env_paths'] as $env_path) {
        foreach ($SYSTEM['modules'] as $module_path) {
            $result = $SYSTEM['file_base'] . $env_path . $module_path
                    . $path . '/' . $name . '/' . $target;
            if (file_exists($result) && !infinite_loop($result)) {
                return $result;
            }
        }
    }
    return false;
}

function find_all_modules($sub = '') {
    global $SYSTEM;
    foreach ($SYSTEM['env_paths'] as $env_path) {
        $path = $SYSTEM['file_base'] . $env_path . '/modules';
        if (file_exists($path)) {
            $modules = scandir($path);
            unset($modules[0]);
            unset($modules[1]);
            foreach ($modules as $module) {
                if (empty($sub) || file_exists($path . '/' . $module . '/' . $sub)) {
                    $SYSTEM['modules'][$module] = '/modules/' . $module . '/';
                }
            }
        }
    }
}

function load_library($name, $mod = null) {
    static $loaded = [];
    if (!empty($loaded[$name])) {
        return;
    }
    if (!empty($mod)) {
        load_module($mod);
    }
    $path = find_library($name);
    if ($path !== false) {
        require_once($path);
    }
    $loaded[$name] = true;
    return $path;
}

function load_libraries($libs) {
    if (is_string($libs)) {
        return load_library($libs);
    }
    foreach ($libs as $lib) {

        if (is_string($lib)) {
            load_library($lib);
        } else if (is_array($lib) && isset($lib['name']) && isset($lib['mod'])) {
            load_library($lib['name'], $lib['mod']);
        }
    }
}

function load_module($name) {
    $GLOBALS['SYSTEM']['modules'][$name] = '/modules/' . $name . '/';
}

function find_sc($params) {
    $dir = "";
    $name = "";
    foreach ($params as $key => $value) {
        if ($key == "dir") {
            $dir = $value;
        } else {
            $name = $value;
        }
    }
    return find_template($name, $dir);
}
