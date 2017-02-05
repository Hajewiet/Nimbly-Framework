<?php

$GLOBALS['SYSTEM']['data_cache_base'] = $GLOBALS['SYSTEM']['file_base'] . 'data/tmp/data-cache/';

function data_cache_sc() {
    
}

function data_cache_save($key, $data) {
    load_library("data");
    $k = data_sanitize_key($key);
    $v = serialize($data);
    $file_path = $GLOBALS['SYSTEM']['data_cache_base'] . $k . '.data';
    @mkdir(dirname($file_path), 0755, true);
    @file_put_contents($file_path, $v, LOCK_EX);
    chmod($file_path, 0640);
}

function data_cache_retrieve($key, $max_age = INF) {
    load_library("data");
    $k = data_sanitize_key($key);
    $file_path = $GLOBALS['SYSTEM']['data_cache_base'] . $k . '.data';
    if (file_exists($file_path) === false) {
        return false;
    }
    $age = time() -  filemtime($file_path);
    if ($age >= $max_age) {
        unlink($file_path);
        return false;
    }
    $s = file_get_contents($file_path);
    $v = unserialize($s);
    return $v;
}
