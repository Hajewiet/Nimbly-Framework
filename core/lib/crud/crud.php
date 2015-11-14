<?php

$GLOBALS['SYSTEM']['data_base'] = $GLOBALS['SYSTEM']['file_base'] . 'data';

function crud_token($params) {
    
}

/**
 * Returns a list of all data objects
 * Example: data_list('users') returns an array of all users
 * @param type $cat category (table name)
 * @return array
 */
function data_list($cat) {
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat;
    $result = array_diff(scandir($path), array('..', '.'));
    var_dump($result);
}

/**
 * Returns a specific data object
 * @param type $cat category (table name)
 * @param type $key key (row)
 * @param type $setting optional setting to retrieve (column)
 * @return array or null
 */
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
