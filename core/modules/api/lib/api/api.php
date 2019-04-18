<?php

load_library("json", "api");
load_library("data");
load_library("access", "user");
load_library("get");

function api_method_switch($func_prefix, $resource = null, $uuid = null) {
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $perm = $resource ?? $func_prefix;
    $access_feature = sprintf("api_%s_%s,api_(any)_%s,api_(any)_(any)", $method, $perm, $perm);
    if (!api_access($access_feature, $perm)) {
        return json_result(array('message' => 'ACCESS_DENIED'), 403);
    }
    $func_name = "{$func_prefix}_{$method}";
    if (function_exists($func_name)) {
        return call_user_func($func_name, $resource, $uuid);
    }
    return json_result(array('message' => 'METHOD_NOT_ALLOWED'), 405);
 }

function api_access($feature='api', $resource=false) {
    return get_variable('api_public', false) || api_key_access($feature) || api_user_access($feature, $resource);
}

function api_key_access($feature) {
    $key = get_variable('key', false);
    if (empty($key)) {
        return false;
    }
    // todo: check if api key exists and allows feature
    return false;
}

function api_user_access($feature, $resource = false) {
    if (access_by_feature($feature)) {
        return true;
    }
    if (access_by_feature('manage-content') && $resource && !in_array($resource, ['users', 'roles'])) {
        return true;
    }
    return false;
}

/*
 * Creates data array from json input
 * + Resolves primary key field
 * + Encrypts fields
 */
function api_json_input($resource) {
    $meta = data_meta($resource);
    if (isset($meta['pk'])) {
        $data = json_input(true, $meta['pk']);
    } else {
        $data = json_input();
    }
    if (isset($meta['encrypt'])) {
        load_library('salt');
        load_library('encrypt');
        $data['salt'] = salt_sc();
        $fs = explode(',', $meta['encrypt']);
        foreach ($fs as $f) {
            $data[$f] = encrypt($data[$f], $data['salt']);
        }
    }
    return $data;
}

function api_check_csrf(&$data) {
    if (!isset($data['form_key'])) {
        load_library('log');
        log_system('api: no csrf key set');
        return null;
    }
    $key = $data['form_key'];
    load_library("session");
    $csrf_pass = false;
    if (session_resume()) {
        $csrf_pass = isset($_SESSION['key']) && $_SESSION['key'] === $key;
    } else {
        $csrf_pass = isset($_COOKIE['key']) && $_COOKIE['key'] === $key;
    }
    if ($csrf_pass !== true) {
        load_library("log");
        log_system("session key or cookie key does not match form key");
        return false; //suspicious, could be a CSRF attack.. do nothing.
    }
    unset($data['form_key']);
    if (isset($data['form_id'])) {
        unset($data['form_id']);
    }
    return true;
}

/*
 * Basic implementation on resource:
 */

function resource_get($resource, $final=true) { // get all
    $result = data_read($resource);
    return json_result(array($resource => $result, 'count' => count($result)), $final);
}

function resource_post($resource, $final=true) { // create new
    $data = api_json_input($resource);
    $csrf_check = api_check_csrf($data);
    if ($csrf_check === false) { //can also be null, if no key is set
        return json_result(array('message' => 'INVALID_DATA'), 400, $final);   
    }
    $uuid = $data['uuid'];
    if (data_exists($resource, $uuid)) {
        return json_result(array('message' => 'RESOURCE_EXISTS'), 409, $final);
    }

    if (data_create($resource, $uuid, $data)) {
        return json_result(array(
            $resource => array($uuid => $data),
            'count' => 1,
            'message' => 'RESOURCE_CREATED'),
        201, $final);
    }
    return json_result(array('message' => 'RESOURCE_CREATE_FAILED'), 500, $final);
}

function resource_put($resource, $final=true) { // update multiple
    $data = api_json_input($resource);
    $csrf_check = api_check_csrf($data);
    if ($csrf_check === false) { //can also be null, if no key is set
        return json_result(array('message' => 'INVALID_DATA'), 400, $final);   
    }
    $result = data_update($resource, null, $data);
    if (is_array($result)) {
        return json_result(array(
            $resource => $result,
            'count' => count($result),
            'message' => 'RESOURCE_UPDATED'
        ), 201, $final);
    }
    return json_result(array('message' => 'RESOURCE_UPDATE_FAILED'), 500, $final);
}

function resource_delete($resource, $final=true) { // delete all
    $delete_count = data_delete($resource);
    if ($delete_count !== false) {
        return json_result(array('message' => 'RESOURCE_DELETED', 'count' => (int)$delete_count), 200, $final);
    }
    return json_result(array('message' => 'RESOURCE_DELETE_FAILED'), 500, $final);
}

/*
 * Basic implementation on resource item:
 */

function resource_id_get($resource, $uuid, $final=true) { // read one
    return json_result(array($resource => array($uuid => data_read($resource, $uuid)), 'count' => 1), 200, $final);
}

function resource_id_post($resource, $uuid, $final=true) { // create new with uuid
    if (data_exists($resource, $uuid)) {
        return json_result(array('message' => 'RESOURCE_EXISTS'), 409, $final);
    }
    $data = api_json_input($resource);
    $csrf_check = api_check_csrf($data);
    if ($csrf_check === false) { //can also be null, if no key is set
        return json_result(array('message' => 'INVALID_DATA'), 400, $final);   
    }
    $data['uuid'] = $uuid;
    $result = data_create($resource, $uuid, $data);
    if ($result) {
        return json_result(array(
            $resource => array($uuid => $result),
            'count' => 1,
            'message' => 'RESOURCE_CREATED'
        ), 201, $final);
    }
    return json_result(array('message' => 'RESOURCE_CREATE_FAILED'), 500, $final);
}

function resource_id_put($resource, $uuid, $final=true) { // update one
    $data = api_json_input($resource);
    $csrf_check = api_check_csrf($data);
    if ($csrf_check === false) { //can also be null, if no key is set
        return json_result(array('message' => 'INVALID_DATA'), 400, $final);   
    }
    $data['uuid'] = $uuid;
    $result = data_update($resource, $uuid, $data);
    if (is_array($result)) {
        return json_result(array(
            $resource => array($uuid => $result),
            'count' => 1,
            'message' => 'RESOURCE_UPDATED'
        ), 201, $final);
    }
    return json_result(array('message' => 'RESOURCE_UPDATE_FAILED'), 500, $final);
}

function resource_id_delete($resource, $uuid, $final=true) { // delete one
    if (data_delete($resource, $uuid)) {
        return json_result(array('message' => 'RESOURCE_DELETED', 'count' => 1), 200, $final);
    }
    return json_result(array('message' => 'RESOURCE_DELETE_FAILED'), 500, $final);
}
