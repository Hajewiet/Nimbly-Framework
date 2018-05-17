<?php

function files_sc($params) {
    load_library("api", "api");
    api_method_switch("files");
}

function files_get() { // get all files (list)
    $files = data_read(".files_meta");
    return json_result(array('files' => $files, 'count' => count($files)), 200);
}

function files_post() { // create a new file and it's meta data
    if (empty($_FILES) || empty($_FILES['file']['tmp_name'])) {
        return json_result(array('message' => 'BAD_REQUEST'), 400);
    }
    $from = $_FILES['file']['tmp_name'];
    $uuid = hash_file('md5', $from); // use checksum as uuid
    if (data_exists('.files', $uuid)) {
        return json_result(array("files" => data_read(".files_meta", $uuid), 'count' => 1, 'message' => 'RESOURCE_EXISTS'), 409);
    }
    $dir = $GLOBALS['SYSTEM']['data_base'] . '/.files/';
    if (!file_exists($dir)) {
        @mkdir($dir, 0750, true);
    }
    $meta = array(
        "name" => $_FILES['file']['name'],
        "uuid" => $uuid,
        "type" => $_FILES['file']['type'],
    );
    if (data_create('.files_meta', $uuid, $meta) && move_uploaded_file($from, $dir . $uuid) === true) {
        return json_result(array("files" => $meta, 'count' => 1, 'message' => 'RESOURCE_CREATED'), 201);
    }
    return json_result(array('message' => 'RESOURCE_CREATE_FAILED'), 500);
}

function files_delete() {  // delete all files
    $delete_count = data_delete('.files_meta');
    if ($delete_count !== false) {
        data_delete('.files');
        return json_result(array('message' => 'RESOURCE_DELETED', 'count' => (int)$delete_count));
    }
    return json_result(array('message' => 'RESOURCE_DELETE_FAILED'), 500);
}

/*
 *  Implementation on files item:
 */

function files_id_get($resource=".files_meta", $uuid) { // read one
    return resource_id_get($resource, $uuid);
}

function files_id_put($resource=".files_meta", $uuid) { // update one
    return resource_id_put($resource, $uuid);
}

function files_id_delete($resource=".files_meta", $uuid) { // delete one
    if (data_delete($resource, $uuid)) {
        data_delete(".files", $uuid);
        return json_result(array('message' => 'FILE RESOURCE_DELETED', 'count' => 1));
    }
    return json_result(array('message' => 'FILE RESOURCE_DELETE_FAILED'), 500);
}