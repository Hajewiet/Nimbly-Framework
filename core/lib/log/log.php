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
    $path = $GLOBALS['SYSTEM']['file_base'] . 'ext/data/.tmp/logs';
    $file = $path . '/system.log';
    $msg = PHP_EOL . date("c") . ' ' . $str . PHP_EOL;
    if (file_exists($file)) {
        error_log($msg, 3, $file);
    } else {
        @mkdir($path, 0750, true);
        error_log(date("c") . " Created logfile" . PHP_EOL . PHP_EOL, 3, $file);
        error_log($msg, 3, $file);
        chmod($file, 0640);
    }
}
