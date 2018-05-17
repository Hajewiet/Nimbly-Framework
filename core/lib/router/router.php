<?php

function router_run($uri) {
    $GLOBALS['SYSTEM']['route_found'] = false;
    $GLOBALS['SYSTEM']['uri_parts'] = explode("/", $GLOBALS['SYSTEM']['request_uri']);
    load_library("data");
    $routes = data_read(".routes");
    $routes = data_sort($routes, 'order', SORT_NUMERIC);
    if (empty($routes)) {
        return false;
    }
    foreach ($routes as $r) {
        if (router_handle($r['route'])) {
            return true;
        }
    }
    return false;
}

function router_match($path) {
    $parts = $GLOBALS['SYSTEM']['uri_parts'];
    $path_parts = explode(DIRECTORY_SEPARATOR . "uri" . DIRECTORY_SEPARATOR, dirname($path));
    $file_parts = explode(DIRECTORY_SEPARATOR, $path_parts[1]);
    $result = array();
    for ($i = 0; $i < count($parts); $i++) {
        if ($file_parts[$i][0] === '(' || $parts[$i][0] === '(') {
            $result[] = $parts[$i];
        } else if ($parts[$i] !== $file_parts[$i]) {
            router_deny();
            return false;
        }
    }
    return $result;
}

function router_accept($accept = true) {
    $GLOBALS['SYSTEM']['route_found'] = $accept;
    return $accept;
}

function router_deny($accept = false) {
    $GLOBALS['SYSTEM']['route_found'] = $accept;
    return $accept;
}

function router_handle($ep) {
    $path = find_uri($ep, "route.inc");
    if ($path === false) {
        return false;
    }
    include_once($path);
    if ($GLOBALS['SYSTEM']['route_found'] !== true) {
        return false;
    }
    $file = find_uri($ep);
    if ($file !== false) {
        $GLOBALS['SYSTEM']['uri'] = $ep;
        $GLOBALS['SYSTEM']['uri_path'] = dirname($path);
        run($file);
        return true;
    }

    return false;
}
