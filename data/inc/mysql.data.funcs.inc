<?php

define("QUERYLOG", defined("ENV-DEV"));

function mysqli_run_query($dbc, $query) {
    $query_result = mysqli_try_query($dbc, $query);
    if ($query_result === false) {
        load_library("redirect");
        redirect("errors/500");
    }
    return $query_result;
}

function mysqli_try_query($dbc, $query) {
    if (QUERYLOG) {
        load_library("log");
        log_system("query: " . $query);
    }
    $query_result = mysqli_query($dbc, $query);
    if ($query_result === false) {
        load_library("log");
        log_system("query returned false: " . $query);
        $error = mysqli_error($dbc);
        log_system("mysql errror: " . $error);
    }
    return $query_result;
}

function mysqli_create_table($dbc, $tbl_name, $col_defs, $pk = "") {
    $col_defs_txt = join(",", array_map(function($k, $v) {
                return sprintf("`%s` %s", $k, strtoupper($v));
            }, array_keys($col_defs), array_values($col_defs)));
    $query = sprintf("CREATE TABLE IF NOT EXISTS `%s` (%s%s) ", $tbl_name, $col_defs_txt, empty($pk) ? "" : "," . $pk);
    return mysqli_run_query($dbc, $query);
}

function mysqli_insert($dbc, $tbl_name, $values) {
    $cols = join(",", array_map(function($k) {
                return sprintf("`%s`", $k);
            }, array_keys($values)));
    $vals = join(",", array_map(function($v) {
                return sprintf("'%s'", $v);
            }, array_values($values)));
    $query = sprintf("INSERT IGNORE INTO `%s` (%s) VALUES (%s)", $tbl_name, $cols, $vals);
    return mysqli_run_query($dbc, $query);
}

function mysqli_update($dbc, $tbl_name, $values, $conditions) {
    $set_vals = join(",", array_map(function($k, $v) {
                return sprintf("`%s`=%s", $k, is_numeric($v) ? $v : "'" . $v . "'");
            }, array_keys($values), array_values($values)));
    $query = sprintf("UPDATE `%s` SET %s %s", $tbl_name, $set_vals, mysqli_where_clause($conditions));
    return mysqli_run_query($dbc, $query);
}

function mysqli_delete($dbc, $tbl_name, $conditions) {
    $query = sprintf("DELETE FROM `%s` %s", $tbl_name, mysqli_where_clause($conditions));
    return mysqli_run_query($dbc, $query);
}

function mysqli_store_tags($dbc, $tbl_name, $tags, $uuid, $id, $weight) {
    static $stop_words = array('the', 'in', 'on', 'for', 'an', 'na', 'n/a');
    $values = array('uuid' => $uuid, 'weight' => $weight, 'type' => $id, 'tag' => '');
    foreach ($tags as $t) {
        $t = trim($t);
        if (empty($t) || strlen($t) < 2 || (strlen($t) >= 32 && strpos($t, ' ') === false) || stripos($t, ".jpg") !== false) {
            continue;
        }
        if (strpos($t, ' ') !== false) {
            $words = explode(' ', $t);
            mysqli_store_tags($dbc, $tbl_name, $words, $uuid, $id, $weight - 1);
            continue;
        }
        $t = strtolower($t);
        if (in_array($t, $stop_words)) {
            continue;
        }
        $values['tag'] = mysqli_escape_string($dbc, $t);
        mysqli_insert($dbc, $tbl_name, $values);
        $clean_tag = preg_replace('/[^a-z0-9]/', '', $t);
        if (strcmp($clean_tag, $t)) {
            $values['tag'] = $clean_tag;
            mysqli_insert($dbc, $tbl_name, $values);
        }
    }
}

function mysqli_where_clause($conditions) {
    $result = "";
    $parts = array();
    foreach ($conditions as $k => $v) {

        if ($k[0] === '!') {
            $k = substr($k, 1);
            $cond = "NOT (";
        } else {
            $cond = "(";
        }

        if (strpos($k, ".") !== false) {
            $key = $k;
        } else {
            $key = "`" . $k . "`";
        }

        if (is_numeric($v) && is_int($v)) {
            $cond .= sprintf("%s=%d", $key, $v);
        } else if (is_array($v) && count($v) > 0) {
            $vs = "'" . implode("','", $v) . "'";
            $cond .= sprintf("%s IN (%s)", $key, $vs);
        } else if (strpos($v, ",") !== false) {
            $vs = "'" . implode("','", explode(",", $v)) . "'";
            $cond .= sprintf("%s IN (%s)", $key, $vs);
        } else if (strpos($v, "+") !== false) {
            $vs = "'" . implode("','", explode("+", $v)) . "'";
            $cond .= sprintf("%s IN (%s)", $key, $vs);
        } else {
            $cond .= sprintf("%s='%s'", $key, $v);
        }

        $parts[] = $cond . ")";
    }
    if (count($parts) > 0) {
        $result = "WHERE " . implode(" AND ", $parts);
    }
    return $result;
}
