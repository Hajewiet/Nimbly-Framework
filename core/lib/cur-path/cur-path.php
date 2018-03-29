<?php

// @doc * `[cur-path]` returns the file path of the current template, e.g. /var/www/ext/uri/css/app.css

function cur_path_sc() {
    return $GLOBALS['SYSTEM']['uri_path'];
}
