<?php

/*
 * 1. Initialize global SYSTEM variable and
 * get the requested URI from the webserver
 */

$SYSTEM['request_time'] = microtime(true);
$SYSTEM['uri_base'] = trim(dirname($_SERVER['SCRIPT_NAME']), '\\') . '/';
if ($SYSTEM['uri_base'] === '//') {
    $SYSTEM['uri_base'] = '/';
}
$SYSTEM['file_base'] = dirname(__FILE__) . '/';
if (empty($_SERVER['REQUEST_URI'])) {
    //todo.. request_uri is not available on all webservers
}
$SYSTEM['request_uri'] = trim(substr($_SERVER['REQUEST_URI'], strlen($SYSTEM['uri_base'])), '/\ ');
if (!empty($_SERVER['QUERY_STRING'])) {
    $SYSTEM['request_uri'] = substr($SYSTEM['request_uri'], 0, strlen($SYSTEM['request_uri']) - 1 - strlen($_SERVER['QUERY_STRING']));
}

/*
 * 2. Locate and include the "find" library
 * The search order is: 1) EXT, 2) CORE.
 * Use the load_library function to load the "run" library
 * and execute the requested uri with the function run_uri.
 */

$SYSTEM['env_paths'] = array('ext', 'core');
foreach ($SYSTEM['env_paths'] as $env_path) {
    $path = $SYSTEM['file_base'] . $env_path . '/lib/find/find.php';
    if (file_exists($path)) {
        require($path);
        break;
    }
}
load_library('run');
run_uri($SYSTEM['request_uri']);

/*
 * 3. This point should never be reached.
 * If reached anyway, something went really, really, wrong.
 * Because the core functionality is broken, all that can be done
 * is returning a hardcoded internal server error.
 */

header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
echo '<h1>Oops. Something went wrong!</h1>';
