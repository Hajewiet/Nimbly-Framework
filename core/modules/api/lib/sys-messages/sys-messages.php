<?php

function sys_messages_sc($params) {
    load_library("api", "api");
    api_method_switch("sys_messages");
}


function sys_messages_post() {
    $data = json_input(false);
    if (empty($data['message'])) {
        return json_result(array('message' => 'INVALID_DATA'), 400);
    }
    load_library("system-messages");
    system_message($data['message']);
    return json_result(array("system-messages" => $data['message'], 'count' => 1));
}
