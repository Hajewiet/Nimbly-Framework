<?php

function return_json($result) {
    load_library("header");
    header_sent("json");
    $result['memory_usage'] = memory_get_peak_usage() . " bytes";
    $result['execution_time'] = microtime(true) - $GLOBALS['SYSTEM']['request_time'] + " seconds";
    exit(json_encode($result));
}
