<?php

load_library("find");

function sys_libraries_sc($params) {
    load_library("api", "api");
    api_method_switch("sys_libraries");
}

function sys_libraries_get() { // get all libraries
    $libs = sys_libraries_read();
    return json_result(array('sys-libraries' => $libs, 'count' => count($libs)), 200);
}

function sys_libraries_read() {
    global $SYSTEM;
    find_all_modules('lib');
    $result = array();
    $item = array();
    foreach ($SYSTEM['env_paths'] as $e) {
        foreach ($SYSTEM['modules'] as $m) {
            $path = $SYSTEM['file_base'] . $e . $m . 'lib/*';
            $libs = glob($path, GLOB_ONLYDIR);
            $mp = explode("/modules/", $m);
            $module_name = count($mp) < 2? 'root' : trim($mp[1], '/');
            foreach ($libs as $l) {
                $parts = explode("/lib/", $l);
                $lib = trim($parts[1], '/');
                $lib_file = $l . '/' . $lib . '.php';
                if (!file_exists($lib_file)) {
                    continue;
                }
                $item['env'] = $e;
                $item['module'] = $module_name;
                $item['lib'] = $lib;
                $item['doc'] = sys_libraries_doc($lib_file);
                $result[$lib] = $item;
            }
        }
    }
    return $result;
}

function sys_libraries_doc($lib_file) {
    load_library('markdown');
    $result = '';
    $file = file_get_contents($lib_file);  
    $n = explode("\n", $file);  
    foreach($n as $line){  
        $d = strpos($line, '@doc');
        if ($d === false) {
            continue;
        }
        $doc = substr($line, $d+5);
        //$doc = 
        $result .= $doc . "\n";
    }
    $result = markdown_to_html($result);
    $result = str_replace('[', '&#91;', $result);
    return $result;
}