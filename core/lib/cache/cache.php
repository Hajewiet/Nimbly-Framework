<?php

$GLOBALS['SYSTEM']['cache_base'] = $GLOBALS['SYSTEM']['file_base'] . 'data/tmp/cache/';

function cache_token($params) {
    $content = ob_get_contents();
    $file_ext = '.' . get_param_value($params, "type", "_cached_.html");
    $file_path = $GLOBALS['SYSTEM']['cache_base'] . $GLOBALS['SYSTEM']['request_uri'];
    if (substr_compare($file_path, $file_ext, strlen($file_path) - strlen($file_ext), strlen($file_ext)) !== 0) {
        $file_path .= $file_ext;
    }
    if ($file_ext == ".css" || $file_ext == ".js") {
        //strip comments (small yet safe optimization)
        $content = preg_replace('!/\*.*?\*/!s', '', $content);
    }
    @mkdir(dirname($file_path), 0755);
    @file_put_contents($file_path, $content, LOCK_EX);
}

?>
