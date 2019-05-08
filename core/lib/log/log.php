<?php

/**
 * @doc '[log text]' adds text to log file in data/.tmp/logs/system.log
 */
function log_sc($params) {
    log_system(current($params));
}

function log_system($str) {
    if (is_array($str)) {
        $str = print_r($str, true);
    }
    load_library('data');
    $uuid = md5($str);
    if (data_exists('.log-entries', $uuid)) {
        $data = data_read('.log-entries', $uuid);
        $data['count'] = isset($data['count']) ? (int)$data['count'] + 1 : 1;
        data_update('.log-entries', $uuid, $data);
    } else {
        data_create('.log-entries', $uuid, [
            'msg' => $str,
            'count' => 1
        ]);
    }
}
