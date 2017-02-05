<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function router_run($uri) {
    $GLOBALS['SYSTEM']['route_found'] = false;
    load_library("data");
    $routes = data_list("routes");
    if (empty($routes)) {
        return false;
    }
    foreach ($routes as $route) {
        $r = data_load("routes", $route);
        $ep = $r['route'];
        if (router_handle($ep)) {
            return true;
        }
    }
    return false;
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
    run_uri($ep);
    return true;
}