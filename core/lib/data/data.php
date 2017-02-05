<?php

$GLOBALS['SYSTEM']['data_base'] = $GLOBALS['SYSTEM']['file_base'] . 'data';

function data_sc($params) {
    if (empty($params)) {
        return;
    }
    $cat = get_param_value($params, "cat", false);
    if ($cat === false) {
        data_run($params);
        return;
    }
    $op = get_param_value($params, "op", "read");
    if ($op === "read") {
        $key = get_param_value($params, "key");
        load_library('set');
        $data = data_load($cat, $key);
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                set_variable('data.' . data_sanitize_key($cat) . '.' . $key, $value, false, true);
            }
        }
    } else if ($op === "list") {
        load_library('set');
        $data = data_list($cat);
        set_variable('data-list.' . data_sanitize_key($cat), $data, false, true);
    }
    return "";
}

/**
 * Returns a list of all data objects
 * Example: data_list('users') returns an array of all users
 * @param type $cat category (table name)
 * @return array
 */
function data_list($cat) {
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat;
    $all = @scandir($path);
    if (!empty($all)) {
        $all = array_diff(@scandir($path), array('..', '.'));
        foreach ($all as $key => $value) {
            if (strpos($value, "^") !== false) {
                $all[$key] = data_load($cat, $value, "orig_key");
            }
        }
    }
    return $all;
}

/**
 * Returns a list of all data object with data
 * Example: data_load_all('users') returns an array of all users and their data
 * @param type $cat category (table name)
 * @return array
 */
function data_load_all($cat) {
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat;
    $all = @scandir($path);
    if (!empty($all)) {
        $all = array_diff(@scandir($path), array('..', '.'));
        foreach ($all as $key => $value) {
            $all[$key] = data_load($cat, $value);
        }
    }
    return $all;
}

function data_exists($cat, $key) {
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . $key;
    return file_exists($path);
}

/**
 * Returns a specific data object from file
 * @param type $cat category (table name)
 * @param type $key key (row)
 * @param type $setting optional setting to retrieve (column)
 * @return array or null
 */
function data_load($cat, $key, $setting = null) {
    if (empty($key)) {
        return null;
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . data_sanitize_key($key);
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
 * Updates a specific data object file
 * @param type $cat category (table name)
 * @param type $key key (row)
 * @param type $data_update_ls array with data to update
 */
function data_update($cat, $key, $data_update_ls) {
    if (empty($data_update_ls)) {
        return;
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . data_sanitize_key($key);
    $data_ls = @parse_ini_file($file);
    if (empty($data_ls)) {
        $data_merged_ls = $data_update_ls;
    } else {
        $data_merged_ls = array_merge($data_ls, $data_update_ls);
    }
    data_write_file($file, $data_merged_ls);
}

/**
 * Creates or rewrites a data object file
 * @param type $cat category (table name)
 * @param type $key key (row)
 * @param type $data_ls data array
 */
function data_create($cat, $key, $data_ls) {
    $dir = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/';
    if (!file_exists($dir)) {
        @mkdir($dir, 0750, true);
    }
    $sane_key = data_sanitize_key($key);
    if ($sane_key !== $key) {
        $data_ls['orig_key'] = $key;
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . $sane_key;
    data_write_file($file, $data_ls);
}

/**
 * Deletes a data object file
 * @param type $cat category (table name)
 * @param type $key key (row)
 */
function data_delete($cat, $key) {
    $dir = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/';
    if (!file_exists($dir)) {
        return false;
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . data_sanitize_key($key);
    return unlink($file);
}

/**
 * Deletes a specific item from a data object file
 * @param type $cat category (table name)
 * @param type $key key (row)
 * @param type $item_key item key
 * @param type $item_value specific value to delete (optional)
 */
function data_delete_item($cat, $key, $item_key, $item_value = null) {
    $dir = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/';
    if (!file_exists($dir)) {
        return false;
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $cat . '/' . data_sanitize_key($key);
    $data_ls = @parse_ini_file($file);
    $do_update = false;
    if (empty($data_ls[$item_key])) {
        //don't update
    } else if ($item_value === null) {
        $data_ls[$item_key] = "";
        $do_update = true;
    } else {
        $v_ls = split(",", $data_ls[$item_key]);
        $ix = array_search($item_value, $v_ls);
        if ($ix !== false) {
            unset($v_ls[$ix]);
            $data_ls[$item_key] = join(",", $v_ls);
            $do_update = true;
        }
    }
    if ($do_update) {
        data_write_file($file, $data_ls);
    }
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

function data_sanitize_key($key, $repl = '^') {
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";",
        ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
    $result = str_replace($special_chars, $repl, $key);
    return $result;
}

function data_run($params, $suffix = ".data.inc") {
    $paths = array(
        $GLOBALS['SYSTEM']['file_base'] . 'data/inc/',
        $GLOBALS['SYSTEM']['uri_path']);
    if (is_array($params)) {
        $tpl = current($params);
    } else if (is_string($params)) {
        $tpl = $params;
    } else {
        //log an error?
        return;
    }
    $file_name = $tpl . $suffix;
    foreach ($paths as $path) {
        $data_include_file = $path . $file_name;
        if (file_exists($data_include_file)) {
            $result = include($data_include_file);
            load_library("set");
            if (is_array($result)) {
                set_variable("data." . data_sanitize_key($tpl), $result);
            }
            return $result;
        }
    }
    return null;
}

function data_bootstrap($params) {
    return data_run($params, ".data.bootstrap.inc", true);
}
