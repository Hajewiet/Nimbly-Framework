<?php

/**
 * @doc `[header (type)]` outputs a http header, possible header types: css, js, json, woff, 403, 404, 500, csv
 */
function header_sc($params) {
    $css = get_single_param_value($params, "css", true, false);
    if ($css) {
        header("Content-type: text/css");
        return;
    }
    $js = get_single_param_value($params, "js", true, false);
    if ($js) {
        header("Content-type: application/javascript");
        return;
    }
    $json = get_single_param_value($params, "json", true, false);
    if ($json) {
        header("Content-type: application/json");
        return;
    }
    $woff = get_single_param_value($params, "woff", true, false);
    if ($woff) {
        header("Content-type: application/x-font-woff");
        return;
    }
    $error_403 = get_single_param_value($params, "403", true, false);
    if ($error_403) {
        header('HTTP/1.0 403 Forbidden');
        return;
    }
    $error_404 = get_single_param_value($params, "404", true, false);
    if ($error_404) {
        header('HTTP/1.0 404 Not Found');
        return;
    }
    $error_500 = get_single_param_value($params, "500", true, false);
    if ($error_500) {
        header('HTTP/1.1 500 Internal Server Error');
        return;
    }
    $csv = get_single_param_value($params, "csv", true, false);
    if ($css) {
        header("Content-type: application/csv; charset=UTF-8");
        return;
    }
}

function header_sent($type) {
    header_sc(array($type => $type));
}