<?php

function active_if_sc($params) {
    global $SYSTEM;
    $url_prefix = current($params);
    $url_current = $SYSTEM['request_uri'];
    if (count($params) > 1 && next($params) === '=') {
        $active = $url_current === $url_prefix;
    } else {
        $active = !empty($url_prefix) && substr($url_current, 0, strlen($url_prefix)) === $url_prefix;
    }
    if ($active) {
        return " active ";
    } else {
        return "";
    }
}
