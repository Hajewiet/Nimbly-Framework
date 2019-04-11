<?php

$GLOBALS['SYSTEM']['data_base'] = $GLOBALS['SYSTEM']['file_base'] . 'ext/data';
load_library('data-sort');

/**
 * Implements [data] shortcode
 * Example: [data resource=users op=read]
 * @doc * `[data users]` loads all users in variable _data.users_
 * @doc * `[data users var=all_users]` use custom variable name. This example loads all users in variable named all_users
 * @doc * `[data projects sort=date|desc,title|asc]` sorted on a) date (descending) and b) title (ascending)
 * @doc * `[data blog-items filter=published:yes]` simple field filter (field permission set to yes)
 * @doc * `[data blog-items search=nimbly]` filters data with any field matching the search term (in this example: nimbly)
 * @doc * `[data users uuid=20345]` loads one single user with id 20345 in variable _data.users.20345_
 */
function data_sc($params) {
    if (empty($params)) {
        return;
    }
    $resource = get_param_value($params, "resource", current($params));
    if (empty($resource)) {
        return;
    }
    $op = get_param_value($params, "op", "read");
    $uuid = get_param_value($params, "uuid", null);
    $var_id = get_param_value($params, "var", null);
    $function_name = sprintf("data_%s", $op);
    $result = call_user_func($function_name, $resource, $uuid);

    $sort = get_param_value($params, "sort", false);
    if ($sort) {
        $result = data_sort_param($result, $sort);
    }

    $search = get_param_value($params, "search", false);
    if ($search !== false) {
        $result = data_search($result, $search);
    }

    $filter = get_param_value($params, "filter", false);
    if ($filter !== false) {
        $result = data_filter($result, $filter);
    }

    load_library("set");
    $data_var = data_var($resource, $uuid, $op);
    set_variable($data_var, $result);
    if (!empty($uuid) && !empty($var_id)) {
        set_variable_dot($var_id, $result);
    }
}

function data_var($resource, $uuid = "", $op = "read") {
    return sprintf("data.%s%s%s", trim($resource, '.'), empty($uuid)? "" : '.' . $uuid, ($op === "read")? "" : '.' . $op);
}

/**
 * Returns true if a resource exists.
 * Example: data_exists('users') or data_exists('users', 1)
 * @return boolean
 */
function data_exists($resource, $uuid = "") {
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource . '/';
    return file_exists($path . $uuid);
}

/**
 * Returns a list of id's for a certain resource
 * Example: data_list('users') returns an array of all user id's
 * @return array or null
 */
function data_list($resource, $uuid = null) {
    if (!empty($uuid)) {
        return data_exists($resource, $uuid)? array($uuid) : array();
    }
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource;
    $all = @scandir($path);
    if (empty($all)) {
        return null;
    }
    return preg_grep('/^([^.])/', $all);
}

/**
 * Implements read operation
 * Example: data_read('users') returns data for all users
 * Example: data_read('users', 1) returns data for user 1
 * @return array or null
 */
function data_read($resource, $uuid = null, $field = null) {
    if (empty($uuid)) {
        return _data_read_all($resource, $field);
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource . '/' . $uuid;
    if (!file_exists($file) || is_dir($file)) {
        $file =  $GLOBALS['SYSTEM']['data_base'] . '/' . $resource . '/' . $uuid;
        if (!file_exists($file) || is_dir($file)) {
            return null;
        }
    }
    $contents = file_get_contents($file);
    $result = json_decode($contents, true);
    if (!isset($result['_modified'])) {
        $result['_modified'] = filemtime($file);
    }
    if (!isset($result['_created'])) {
        $result['_created'] = filectime($file);
    }
    if (!empty($field)) {
        if (is_string($field) && isset($result[$field])) {
            return $result[$field];
        } else if (is_array($field)) {
            $filtered_result = array();
            foreach ($field as $f) {
                $filtered_result[$f] = $result[$f];
            }
            unset($result);
            return $filtered_result;
        }
        return null;
    }
    return $result;
}

function data_cached_read($resource, $uuid = null, $field = null) {
    load_library("get");
    $data_var = data_var($resource, $uuid);
    $result = get_variable($data_var);
    if (empty($result)) {
        $result = data_read($resource, $uuid);
    }
    return $result;
}

/**
 * Returns a list of all data object with data
 * Example: _data_read_all('users') returns an array of all users and their data
 */
function _data_read_all($resource, $setting = null) {
    $result = array();
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource;
    if (!file_exists($path)) {
        return $result;
    }
    $all = @scandir($path);
    if (is_array($all)) {
        foreach ($all as $uuid) {
            if ($uuid[0] === '.') {
                continue;
            }
            if (is_dir($path . '/' . $uuid)) {
                continue;
            }
            $result[$uuid] = data_read($resource, $uuid, $setting);
        }
    }
    return $result;
}

function data_read_index($resource, $index_name, $index_uuid) {
    $result = array();
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource;
    $ix_path = $path . '/' . $index_name . '/' . $index_uuid;
    if (!file_exists($ix_path)) {
        return $result;
    }
    $ixs = @scandir($ix_path);
    if (!is_array($ixs)) {
        return $result;
    }
    foreach ($ixs as $ix) {
        if ($ix[0] === '.') {
            continue;
        }
        if (is_dir($path . '/' . $ix)) {
            continue;
        }
        $result[$ix] = data_read($resource, $ix);
    }
    return $result;
}

/**
 * Updates a specific data object file
 */
function data_update($resource, $uuid, $data_update_ls) {
    if (empty($data_update_ls) || !data_exists($resource, $uuid)) {
        return false;
    }
    if (empty($uuid)) { // update multiple
        $result = array();
        foreach ($data_update_ls as $pk => $updates) {
            $id = empty($pk)? $updates['uuid'] : $pk;
            if (empty($id)) {
                continue;
            }
            $r = data_update($resource, $id, $updates);
            if (!is_array($r)) {
                return false;
            }
            $result[$id] = $r;
        }
        return $result;
    }

    $data_ls = data_read($resource, $uuid);

    if (empty($data_ls)) {
        $data_merged_ls = $data_update_ls;
    } else {
        $data_merged_ls = array_merge($data_ls, $data_update_ls);
    }

    // additional handling if PK field changed
    $pk_field =  $data_update_ls['pk-field-name'] ?? false;
    if ($pk_field) {
        $pk_value = $data_update_ls[$pk_field] ?? false;
        $uuid = data_update_pk($resource, $uuid, $pk_value);
        if (empty($uuid)) {
            return false;
        }
        $data_merged_ls['uuid'] = $uuid;
        if (isset($data_merged_ls['_fkrefs'])) {
            // update fks for all references
        } 
    }

    // add _modified_by info
    load_library('md5');
    load_library('username', 'user');
    $data_merged_ls['_modified_by'] = md5_uuid(username_get());
    $data_merged_ls['_modified'] = time();

    if (data_create($resource, $uuid, $data_merged_ls)) {
        return $data_merged_ls;
    }
    return false;
}

function data_update_pk($resource, $uuid, $pk_value) {
    if (empty($pk_value)) {
        return $uuid;
    }
    $new_uuid = md5($pk_value);
    if ($new_uuid === $uuid) {
        return $uuid;
    }
    if (data_exists($resource, $new_uuid)) {
        return false;
    }
    $path = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource . '/';
    if (rename($path . $uuid, $path . $new_uuid) === true) {
        return $new_uuid;
    }
    return false;
}


/**
 * Creates or rewrites a data object file
 */
function data_create($resource, $uuid, $data_ls) {
    $dir = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource . '/';
    if (!file_exists($dir)) {
        @mkdir($dir, 0750, true);
    }
    if (empty($uuid)) {
        return file_exists($dir);
    }
    $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource . '/' . $uuid;
    if (isset($data_ls['form-key'])) {
        unset($data_ls['form-key']);
    }
    if (!isset($data_ls['_created_by'])) {
        load_library('md5');
        load_library('username', 'user');
        $data_ls['_created_by'] = md5_uuid(username_get());
    }
    if (!isset($data_ls['_created'])) {
        $data_ls['_created'] = time();
        $data_ls['_modified'] = time();
    }
    $json_data = json_encode($data_ls, JSON_UNESCAPED_UNICODE);
    if (@file_put_contents($file, $json_data) !== false) {
        $meta = data_meta($resource);
        if (isset($meta['index']) && is_array($meta['index'])) {
            foreach($meta['index'] as $index_name) {
                if (empty($data_ls[$index_name])) {
                    continue;
                }
                $index_uuid = md5($data_ls[$index_name]);
                if ($index_uuid === $uuid) {
                    continue; // no need to index
                }
                _data_create_index($file, $index_name, $index_uuid);
            }
        }
        return true;
    }
    return false;
}

function _data_create_index($file, $index_name, $index_uuid) {
    $path = dirname($file) . '/' . $index_name . '/' . $index_uuid . '/';
    if (!file_exists($path)) {
        @mkdir($path, 0750, true);
    }
    touch($path . basename($file)); //better than symlink (?) because original file should be opened with data_read 
}

function _data_delete_index($file, $index_name, $index_uuid) {
    $path = dirname($file) . '/' . $index_name . '/' . $index_uuid . '/' . basename($file);
    if (!file_exists($path)) {
        return 0;
    }
    return (int) unlink($path);
}

/**
 * Deletes resource/id or resource/*
 */
function data_delete($resource, $uuid = null) {
    $result = 0;
    $dir = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource . '/';
    if (!file_exists($dir)) {
        return $result;
    }
    if (!empty($uuid)) {
        $file = $GLOBALS['SYSTEM']['data_base'] . '/' . $resource . '/' . $uuid;
        if (!file_exists($file)) {
            return $result;
        }
        $meta = data_meta($resource);
        if (isset($meta['index']) || isset($meta['children'])) {
            $data_ls = data_read($resource, $uuid);
            if (isset($meta['index']) && is_array($meta['index'])) {
                foreach($meta['index'] as $index_name) {
                    if (empty($data_ls[$index_name])) {
                        continue;
                    }
                    $index_uuid = md5($data_ls[$index_name]);
                    $result += _data_delete_index($file, $index_name, $index_uuid);
                }
            }   
            if (isset($meta['children']) && is_array($meta['children'])) {
                foreach($meta['children'] as $child_name) {
                    $result += _data_delete_children($resource, $uuid, $child_name);
                }        
            }
        }
        $result += (int) unlink($file);
        return $result;
    }
    $files = @scandir($dir);
    foreach($files as $file) {
        if ($file[0] === '.' && $file !== ".meta") {
            continue;
        }
        $f = $dir . $file;
        if (!is_file($f)) {
            continue;
        }
        $result += (int) unlink($f);
    }
    @rmdir($dir);
    return $delete_count;
}

function _data_delete_children($resource, $uuid, $child_name) {
    $result = 0;
    $meta = data_meta($child_name);
    if (!isset($meta['parent']['resource'])) {
        return $result;
    }
    if ($meta['parent']['resource'] !== $resource) {
        return result;
    }
    $field = $meta['parent']['field'];
    // todo: has index? should maybe always have an index for this relation
    $children = data_filter(data_read($child_name), $field . ':' . $uuid);
    if (is_array($children)) {
        foreach ($children as $uuid => $child) {
            $result += data_delete($child_name, $uuid);
        }
    }
    return $result;
}


/*
 * Simple search on all fields, given a search term
 */
function data_search($data, $term, $level = 0) {
    if ($level === 0) {
        $result = array();
    }
    if (empty($term) || strlen($term) < 2) {
        return $result;
    }
    foreach ($data as $key => $record) {
        $score = 0;
        foreach ($record as $field_name => $field_value) {
            if (is_scalar($field_value)) {
                $v = trim($field_value);
                $p = stripos($v, $term);
                if ($p === false) {
                    // nothing
                } else if ($p === 0) {
                    $score += 2;
                } else {
                    $score += 1;
                }
            } else if (is_array($field_value)){
                $score += data_search($field_value, $term, $level + 1);
            }
            if ($score > 0 && $level === 0) {
                $result[$key] = $record;
                $result[$key]['search_score'] = $score;
            } else if ($score > 0 && $level > 0) {
                return $score;
            }
        }
    }
    if ($level === 0) {
        $result = data_sort_numeric($result, 'search_score', SORT_DESC);
        return $result;
    }
    return 0;
}

/*
 * Simple field filter e.g. permission:yes
 */
function data_filter($data, $filter_str) {
    $filter_str_parts =  explode(',', $filter_str);
    $filters = array();
    foreach ($filter_str_parts as $f) {
        $parts = explode(':', $f);
        if (count($parts) !== 2) {
            continue;
        }
        $filters[$parts[0]] = $parts[1];
    }
    foreach ($data as $key => $record) {
        foreach ($filters as $k => $val) {
            $vs = explode('||', $val);
            $pass = false;
            foreach ($vs as $v) {

                // pass if value exists
                if ($v === '(exists)' && isset($record[$k])) {
                    $pass = true;
                    break;
                }

                // pass if value is numeric
                if ($v === '(num)' && isset($record[$k]) && is_numeric($record[$k])) {
                    $pass = true;
                    break;
                }

                // pass if value matches (e.g. permission=yes)
                if (isset($record[$k]) && $record[$k] == $v) {
                    $pass = true;
                    break;
                }

                // pass if value matches negated (e.g permission=!no)
                if ($v[0] === '!' && isset($record[$k]) && $record[$k] != substr($v, 1)) {
                    $pass = true;
                    break;
                }
            }

            if (!$pass) {
                unset($data[$key]);
            }
        }
    }
    return $data;
}


/*
 * Get all resource types
 */
function data_resources_list() {
    $rs = @scandir($GLOBALS['SYSTEM']['data_base']);
    $result = array();
    if (is_array($rs)) {
        foreach ($rs as $r) {
            if ($r[0] === '.') {
                continue;
            }
            $dir = $GLOBALS['SYSTEM']['data_base'] . '/' . $r;
            if (!is_dir($dir)) {
                continue;
            }
            $entities = data_list($r);
            $result[$r] = array(
                "name" => $r,
                "count" => count($entities)
            );
        }
    }
    return $result;
}

/*
 * Get meta data about a resource
 */
function data_meta($resource, $items = null) {
    static $meta_result = [];
    if (!empty($meta_result[$resource])) {
        return $meta_result[$resource];
    }
    if (data_exists($resource, ".meta")) {
        $meta = data_read($resource, ".meta");
    } else {
        if ($items === null) {
            $items = data_read($resource);
        }
        $meta = _data_meta_build($items);
        if ($meta !== false) {
            data_create($resource, ".meta", $meta);
        }
    }
    $meta_result[$resource] = $meta;
    return $meta;
}

/*
 * Create a new resource 
 */
function data_create_resource($resource, $meta) {
    return data_exists($resource, ".meta") || data_create($resource, ".meta", $meta);
}

/*
 * Build meta data by inspecting the entities (not ideal)
 */
function _data_meta_build($items) {
   if (empty($items)) {
        return false;
    }
    $meta = array();
    $fields = array_keys(current($items));
    $exclude = array("uuid", "salt", "_created_by", "_modified", "_created");
    $fields = array_diff($fields, $exclude);
    $fields = array_fill_keys($fields, array('type' => 'text', 'name' => ''));
    foreach ($fields as $k => $v) {
        if (!empty($k) && $k[0] === '_') {
            unset($fields[$k]);
            continue;
        }
        $fields[$k]['name'] = $k;
    }
    $meta['fields'] = $fields;
    return $meta;
}

/*
 * Exclude records based on field value
 */
function data_exclude($records, $key, $value) {
    foreach ($records as $i => $r) {
        if (isset($r[$key]) && $r[$key] === $value) {
            unset($records[$i]);
        }
    }
    return $records;
}

/*
 * Replace special / invalid characters
 */
function data_sanitize_key($key, $repl = '^') {
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";",
        ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
    $result = str_replace($special_chars, $repl, $key);
    return $result;
}

function data_field_contains($object, $field_name, $val) {
    if (empty($object[$field_name])) {
        return false;
    }
    $field_value = $object[$field_name];
    if ($field_value === $val) {
        return true;
    }
    if (is_array($field_value) && in_array($val, $field_value)) {
        return true;
    }
    return false;
}