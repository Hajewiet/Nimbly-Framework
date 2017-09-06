<?php

function resources_sc($params) {
    load_library("api", "api");
    api_method_switch("resources");
}

function resources_get() { // get all resources
    $resources = data_resources_list();
    return json_result(array('resources' => $resources, 'count' => count($resources)), 200);
}

function resources_post() { // create a new resource

    $data = json_input(false);
    if (empty($data['resource'])) {
        return json_result(array('message' => 'BAD_REQUEST'), 400);
    }

    $exists = data_exists($data['resource']);
    if (!empty($exists)) {
        return json_result(array('message' => 'RESOURCE_EXISTS'), 409);
    }

    $meta = resources_build_meta($data);

    if (empty($meta)) {
        $result = data_create($data['resource'], null, null);
    } else {
        $result = data_create($data['resource'], ".meta", $meta);
    }

    if ($result) {
        return json_result(array("resources" => $data, 'count' => 1, 'message' => 'RESOURCE_CREATED'), 201);
    }
    return json_result(array('message' => 'RESOURCE_CREATE_FAILED'), 500);
}

function resources_build_meta($data) {
    if (empty($data) || empty($data['field_names']) || empty($data['field_types'])) {
        return null;
    }
    $fns = $data['field_names'];
    $fts = $data['field_types'];
    if (is_string($fns) && is_string($fts)) {
        $fns = array($fns);
        $fts = array($fts);
    }
    if (count($fns) !== count($fts)) {
        return null;
    }
    $fields = array();
    $ft = current($fts);
    foreach ($fns as $fn) {
        $fields[$fn] = array('name' => $fn, 'type' => $ft);
        $ft = next($fts);
    }
    return array(
        "fields" => $fields
    );
}




