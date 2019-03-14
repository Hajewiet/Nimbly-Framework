<?php

$GLOBALS['SYSTEM']['cache_base'] = $GLOBALS['SYSTEM']['file_base'] . 'ext/data/.tmp/cache/';

/**
 * @doc * `[cache type=html|css|js]` minifies current output buffer and writes it to a static cached file
 */
function cache_sc($params) {
    $content = ob_get_contents();
    $file_ext = '.' . get_param_value($params, "type", "_cached_.html");
    $file_path = $GLOBALS['SYSTEM']['cache_base'] . $GLOBALS['SYSTEM']['request_uri'];
    if (substr_compare($file_path, $file_ext, strlen($file_path) - strlen($file_ext), strlen($file_ext)) !== 0) {
        $file_path .= $file_ext;
    }
    if ($file_ext === ".css") {
        //strip comments (small yet safe optimization)
        $content = "/* cached */ " . preg_replace('!/\*.*?\*/!s', '', $content);
        //strip whitepaces, newlines, tabs
        $content = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $content);
    } else if ($file_ext === ".js") {
        include_once(realpath(dirname(__FILE__)) . "/Minifier.php");
        $content = "/* cached */" . Minifier::minify($content);
    }
    @mkdir(dirname($file_path), 0755, true);
    @file_put_contents($file_path, $content, LOCK_EX);
}

/**
 * @doc * function `cache_clear()` deletes all cached files
 */
function cache_clear() {
    cache_rmdirr($GLOBALS['SYSTEM']['cache_base']);
}

function cache_rmdirr($dir) {
    foreach (glob($dir . '/*') as $file) {
        if (is_dir($file)) {
            cache_rmdirr($file);
        } else {
            unlink($file);
        }
    }
    @rmdir($dir);
}
