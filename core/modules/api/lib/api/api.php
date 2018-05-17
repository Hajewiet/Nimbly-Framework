<?php

load_library("json", "api");
load_library("data");
load_library("access", "user");
load_library("get");

function api_method_switch($func_prefix, $resource = null, $uuid = null) {
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $perm = $resource ?? $func_prefix;
    $access_feature = sprintf("api_%s_%s,api_(any)_%s,api_(any)_(any)", $method, $perm, $perm);
    if (!api_access($access_feature)) {
        return json_result(array('message' => 'ACCESS_DENIED'), 403);
    }
    $func_name = "{$func_prefix}_{$method}";
    if (function_exists($func_name)) {
        return call_user_func($func_name, $resource, $uuid);
    }
    return json_result(array('message' => 'METHOD_NOT_ALLOWED'), 405);
 }

 function api_access($feature='api') {
    return get_variable('api_public', false) || api_key_access($feature) || api_user_access($feature);
}

function api_key_access($feature) {
    $key = get_variable('key', false);
    if (empty($key)) {
        return false;
    }
    // todo: check if api key exists and allows feature
    return false;
}

function api_user_access($feature) {
    return access_by_feature($feature);
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

/*
 * Basic implementation on resource:
 */

function resource_get($resource) { // get all
    $result = data_read($resource);
    return json_result(array($resource => $result, 'count' => count($result)));
}

function resource_post($resource) { // create new
    $data = api_json_input($resource);
    $uuid = $data['uuid'];
    if (data_exists($resource, $uuid)) {
        return json_result(array('message' => 'RESOURCE_EXISTS'), 409);
    }

    if (data_create($resource, $uuid, $data)) {
        return json_result(array(
            $resource => array($uuid => $data),
            'count' => 1,
            'message' => 'RESOURCE_CREATED'),
        201);
    }
    return json_result(array('message' => 'RESOURCE_CREATE_FAILED'), 500);
}

function resource_put($resource) { // update multiple
    $data = api_json_input($resource);
    $result = data_update($resource, null, $data);
    if (is_array($result)) {
        return json_result(array(
            $resource => $result,
            'count' => count($result),
            'message' => 'RESOURCE_UPDATED'
        ), 201);
    }
    return json_result(array('message' => 'RESOURCE_UPDATE_FAILED'), 500);
}

function resource_delete($resource) { // delete all
    $delete_count = data_delete($resource);
    if ($delete_count !== false) {
        return json_result(array('message' => 'RESOURCE_DELETED', 'count' => (int)$delete_count));
    }
    return json_result(array('message' => 'RESOURCE_DELETE_FAILED'), 500);
}

/*
 * Basic implementation on resource item:
 */

function resource_id_get($resource, $uuid) { // read one
    return json_result(array($resource => array($uuid => data_read($resource, $uuid)), 'count' => 1));
}

function resource_id_post($resource, $uuid) { // create new with uuid
    if (data_exists($resource, $uuid)) {
        return json_result(array('message' => 'RESOURCE_EXISTS'), 409);
    }
    $data = api_json_input($resource);
    $data['uuid'] = $uuid;
    $result = data_create($resource, $uuid, $data);
    if ($result) {
        return json_result(array(
            $resource => array($uuid => $result),
            'count' => 1,
            'message' => 'RESOURCE_CREATED'
        ), 201);
    }
    return json_result(array('message' => 'RESOURCE_CREATE_FAILED'), 500);
}

function resource_id_put($resource, $uuid) { // update one
    $data = api_json_input($resource);
    $data['uuid'] = $uuid;
    $result = data_update($resource, $uuid, $data);
    if (is_array($result)) {
        return json_result(array(
            $resource => array($uuid => $result),
            'count' => 1,
            'message' => 'RESOURCE_UPDATED'
        ), 201);
    }
    return json_result(array('message' => 'RESOURCE_UPDATE_FAILED'), 500);
}

function resource_id_delete($resource, $uuid) { // delete one
    if (data_delete($resource, $uuid)) {
        return json_result(array('message' => 'RESOURCE_DELETED', 'count' => 1));
    }
    return json_result(array('message' => 'RESOURCE_DELETE_FAILED'), 500);
}
