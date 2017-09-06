<?php

router_deny();

$parts = explode("/", $GLOBALS['SYSTEM']['request_uri']);
if (count($parts) !== 4 || $parts[0] !== 'api' || $parts[1] !== 'v1' || $parts[2] !== '.pages') {
    return;
}
$uuid = $parts[3];
$method = $_SERVER['REQUEST_METHOD'];
load_library('api', 'api');
load_library('pages', 'api');
return api_method_switch("pages_id", 'pages', $uuid);

function pages_id_get($resource, $uuid) { // get one
    $page = pages_find_by_key($uuid);
    if (!empty($page)) {
        return json_result(array("pages" => $page, 'count' => 1));
    }
}

function pages_id_delete($resource, $uuid) { // delete one
    if (pages_delete($uuid)) {
        return json_result(array('message' => 'RESOURCE_DELETED', 'count' => 1));
    }
    return json_result(array('message' => 'RESOURCE_DELETE_FAILED'), 500);
}

function pages_id_put($resource, $uuid) { // update one
    $data = json_input(false);
    $page = pages_update($uuid, $data);
    if (!empty($page)) {
        return json_result(array(
            "pages" => array($uuid => $result),
            'count' => 1,
            'message' => 'RESOURCE_UPDATED'
        ), 201);
    }
    return json_result(array('message' => 'RESOURCE_UPDATE_FAILED'), 500);
}
