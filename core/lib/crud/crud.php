<?php

$GLOBALS['SYSTEM']['data_base'] = $GLOBALS['SYSTEM']['file_base'] . 'data';

function crud_sc($params) {
    $op = get_param_value($params, "op", "read");
    if ($op === "read") {
        $cat = get_param_value($params, "cat");
        $key = get_param_value($params, "key");
        load_library('set');
        $data = data_load($cat, $key);
        foreach ($data as $key => $value) {
            set_variable('crud-obj.' . $key, $value, false, true);
        }
    } else if ($op === "list") {
        $cat = get_param_value($params, "cat");
        load_library('set');
        $data = data_list($cat);
        set_variable('crud-list-' . data_sanitize_key($cat), $data, false, true);
    }
    return "";
}

/**
 * Returns a list of all data objects
 * Example: data_list('users') returns an array of all users
 * The results are limited to 100
 * @param type $cat category (table name)
 * @return array
 */
function data_list($cat) {
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat;
    $all = @scandir($path);
    if (!empty($all)) {
        $all = array_diff(@scandir($path), array('..', '.'));
    }
    return $all;
}

function data_exists($cat, $key) {
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . $key;
    return file_exists($path);
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

/**
 * Updates a specific data object
 * @param type $cat category (table name)
 * @param type $key key (row)
 * @param type $data_update_ls array with data to update
 */
function data_update($cat, $key, $data_update_ls) {
    if (empty($data_update_ls)) {
        return;
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . $key;
    $data_ls = @parse_ini_file($file);
    if (empty($data_ls)) {
        $data_merged_ls = $data_update_ls;
    } else {
        $data_merged_ls = array_merge($data_ls, $data_update_ls);
    }
    data_write_file($file, $data_merged_ls);
}

/**
 * Creates or rewrites a data object
 * @param type $cat category (table name)
 * @param type $key key (row)
 * @param type $data_ls data array
 */
function data_create($cat, $key, $data_ls) {
    $dir = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/';
    if (!file_exists($dir)) {
        @mkdir($dir, 0750);
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . $key;
    data_write_file($file, $data_ls);
}

/**
 * Deletes a data object
 * @param type $cat category (table name)
 * @param type $key key (row)
 */
function data_delete($cat, $key) {
    $dir = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/';
    if (!file_exists($dir)) {
        return false;
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . $key;
    return unlink($file);
}

/**
 * Writes to an ini file
 * @param type $file full path
 * @param type $data_ls data array
 */
function data_write_file($file, $data_ls) {
    $data_formatted_ls = array();
    foreach ($data_ls as $key => $value) {
        if (is_array($value)) {
            $data_formatted_ls[] = "[$key]";
            $data_formatted_ls = array_merge($data_formatted_ls, _data_ini_lines($value));
        } else {
            $data_formatted_ls[] = _data_ini_line($key, $value);
        }
    }
    file_put_contents($file, implode("\r\n", $data_formatted_ls), LOCK_EX);
    chmod($file, 0640);
}

/**
 * Creates multiple key=value lines for an ini file from an array
 * @param type $values array of values
 * @return array with formatted ini strings: key=value
 */
function _data_ini_lines($values, $key_prefix = "") {
    $result = array();
    foreach ($values as $key => $val) {
        if (is_array($val)) {
            $result = array_merge($result, _data_ini_lines($val, $key_prefix . $key . "."));
        } else {
            $result[] = _data_ini_line($key_prefix . $key, $val);
        }
    }
    return $result;
}

/**
 * Creates one key=value line for an ini file
 * @param type $key key string, must be alphanumeric
 * @param type $value value string
 * @return string formatted ini string: key=value
 */
function _data_ini_line($key, $value) {
    $result = "$key=";
    if (ctype_alnum($value)) {
        $result .= $value;
    } else {
        $result .= '"' . addslashes($value) . '"';
    }
    return $result;
}

function data_sanitize_key($key) {
    $special_chars = array(" ", "?", "[", "]", "/", "\\", "=", "<", ">", ":", ";",
        ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
    $result = str_replace($special_chars, '-', $key);
    return $result;
}
