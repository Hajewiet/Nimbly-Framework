<?php

$GLOBALS['SYSTEM']['data_base'] = $GLOBALS['SYSTEM']['file_base'] . 'data';

function crud_token($params) {
    
}

function data_load($cat, $key, $setting = null) {
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . $key;
    $result = @parse_ini_file($file);
    if (!empty($setting) && isset($result[$setting])) {
        return $result[$setting];
    } else if (!empty($setting)) {
        return null;
    } else {
        return $result;
    }
}
