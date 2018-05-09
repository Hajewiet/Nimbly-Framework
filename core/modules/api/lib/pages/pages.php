<?php

function pages_sc($params) {
    load_library("api", "api");
    api_method_switch("pages");
}

function pages_get() { // get all pages
    $pages = pages_read();
    return json_result(array('pages' => $pages, 'count' => count($pages)), 200);
}

function pages_read() {
    global $SYSTEM;
    load_library("find");
    find_all_modules('uri');
    $result = array();
    $item = array();
    foreach ($SYSTEM['env_paths'] as $e) {
        foreach ($SYSTEM['modules'] as $m) {
            $path = $SYSTEM['file_base'] . $e . $m . 'uri/';
            $pages = pages_find($path . 'index.tpl');
            $mp = explode("/modules/", $m);
            $module_name = count($mp) < 2? 'root' : trim($mp[1], '/');
            foreach ($pages as $p) {
                $route_path = str_replace("/index.tpl", "/route.inc", $p);
                if (file_exists($route_path)) {
                    continue; // it's a route
                }
                $parts = explode("/uri/", $p);
                $url = trim(str_replace("/index.tpl", "", $parts[1]), '/');
                if (!empty($result[$url])) {
                    continue;
                }
                $item['env'] = $e;
                $item['module'] = $module_name;
                $item['url'] = $url;
                $result[$url] = $item;
            }
        }
    }
    return $result;
}

function pages_find($pattern, $flags = 0) {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, pages_find($dir . '/' . basename($pattern), $flags));
        }
        return $files;
}

function pages_find_by_key($key) {
    global $SYSTEM;
    load_library("find");
    $result = array();
    $item = array();
    $path = $SYSTEM['file_base'] . 'ext/uri/';
    $pages = pages_find($path . 'index.tpl');
    $key_upper = strtoupper($key);
    foreach ($pages as $p) {
        $route_path = str_replace("/index.tpl", "/route.inc", $p);
        if (file_exists($route_path)) {
            continue; // it's a route
        }
        $parts = explode("uri", $p);
        $url = trim(str_replace("/index.tpl", "", $parts[1]), '/');
        if (strtoupper(md5($url)) === $key_upper) {
            $item['env'] = 'ext';
            $item['module'] = '';
            $item['url'] = $url;
            $item['template'] = file_get_contents($p);
            $result[$url] = $item;
            return $result;
        }
    }
    return $result;
}

function pages_delete($uuid) {
    global $SYSTEM;
    load_library("md5");
    $page = pages_find_by_key(md5_uuid($uuid));
    if (!is_array($page) || count($page) !== 1) {
        return false;
    }
    $page = current($page);
    $path = sprintf("%s%s%s", $SYSTEM['file_base'] , 'ext/uri/', $page['url']);
    load_library("util");
    $result = rmfiles($path);
    while ($result !== false && @rmdir($path) === true) {
        $path = dirname($path); // removes last part of $path
    }
    if ($result) {
        return json_result(array('message' => 'RESOURCE_DELETED', 'count' => 1));
    }
    return json_result(array('message' => 'RESOURCE_DELETE_FAILED'), 500);
}

function pages_create($data_ls) {
    if (empty($data_ls["url"])) {
        return false;
    }
    $url = $data_ls['url'];
    $dir = $GLOBALS['SYSTEM']['file_base'] . '/ext/uri/' . $url;
    if (!file_exists($dir)) {
        @mkdir($dir, 0750, true);
    }
    $file = $dir . '/index.tpl';
    if (empty($data_ls['template'])) {
        $tpl = sprintf('[set page-title="%s"][html]', $data_ls['title']);
    } else {
        $tpl = $data_ls['template'];
    }
    return file_put_contents($file, $tpl) !== false && file_exists($file);
}

function pages_post() {
    $data = json_input(false);
    if (empty($data['url'])) {
        return json_result(array('message' => 'BAD_REQUEST'), 400);
    }
    $uuid = md5($data['url']);
    $exists = pages_find_by_key($uuid);
    if (!empty($exists)) {
        return json_result(array('message' => 'RESOURCE_EXISTS'), 409);
    }
    $page = false;
    if (pages_create($data)) {
        $page = pages_find_by_key($uuid);
    }
    if (!empty($page)) {
        return json_result(array("pages" => $page, 'count' => 1, 'message' => 'RESOURCE_CREATED'), 201);
    }
    return json_result(array('message' => 'RESOURCE_CREATE_FAILED'), 500);
}

function pages_update($uuid, $data) {
    $page = pages_find_by_key($uuid);
    if (empty($page)) {
        return false;
    }
    $merged = array_merge(current($page), $data);
    pages_create($merged);
    $page = pages_find_by_key($uuid);
    if ($page) {
        return json_result(array(
            $resource => array($uuid => $result),
            'count' => 1,
            'message' => 'RESOURCE_UPDATED'
        ), 201);
    }
    return json_result(array('message' => 'RESOURCE_UPDATE_FAILED'), 500);
}

function pages_id_get($resource, $uuid) { // get one
    $page = pages_find_by_key($uuid);
    if (!empty($page)) {
        return json_result(array("pages" => $page, 'count' => 1));
    }
}

function pages_id_delete($resource, $uuid) { // delete one
    if (pages_delete($uuid)) {
        return json_result(array('message' => 'RESOURCE_DELETED', 'count' => 1));
    }
    return json_result(array('message' => 'RESOURCE_DELETE_FAILED'), 500);
}

function pages_id_put($resource, $uuid) { // update one
    $data = json_input(false);
    $page = pages_update($uuid, $data);
    if (!empty($page)) {
        return json_result(array(
            "pages" => array($uuid => $result),
            'count' => 1,
            'message' => 'RESOURCE_UPDATED'
        ), 201);
    }
    return json_result(array('message' => 'RESOURCE_UPDATE_FAILED'), 500);
}