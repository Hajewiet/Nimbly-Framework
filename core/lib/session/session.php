<?php

$GLOBALS['SYSTEM']['session_base'] = $GLOBALS['SYSTEM']['file_base'] . 'data/tmp/sessions';
$GLOBALS['SYSTEM']['session_lifetime'] = 1800; //30 minutes

/**
 * Implements session sc
 * Start and validate a session
 * @return void
 */
function session_sc() {

    //1. initialize session
    static $session_started = false;
    if ($session_started) {
        return;
    } else {
        $session_started = true;
    }
    
    session_save_path($GLOBALS['SYSTEM']['session_base']);
    session_name("session_id");
    @session_start();

    //2. if it's a new session, just create and initialize it and done.
    if (empty($_SESSION)) { //a new session
        session_initialize();
        return;
    }

    //3. remove and restart session if it does not validate
    if (empty($_SESSION['modified']) 
            || empty($_SESSION['created']) 
            || $GLOBALS['SYSTEM']['request_time'] >= $_SESSION['modified'] + $GLOBALS['SYSTEM']['session_lifetime']) {
        session_unset();
        session_destroy();
        session_start();
        session_initialize();
        return;
    }

    //4. update session
    $_SESSION['modified'] = $_SERVER['REQUEST_TIME'];
}

function session_exists() {
    return !empty($_SESSION) || !empty($_COOKIE['session_id']);
}

function session_resume() {
    if (session_exists()) {
        session_sc();
    }
    return !empty($_SESSION);
}

function session_initialize() {
    session_regenerate_id(true);
    $_SESSION['created'] = $_SERVER['REQUEST_TIME'];
    $_SESSION['modified'] = time();
    $_SESSION['key'] = md5(uniqid(rand(), true));
    $_SESSION['roles'] = array("anonymous" => true);
}

function session_cleanup_files() {
    $time = $_SERVER['REQUEST_TIME'];
    $session_life_time = $GLOBALS['SYSTEM']['session_lifetime'];
    foreach (glob(session_save_path() . '/sess_*') as $filename) {
        if ($time >= filemtime($filename) + $session_life_time) {
            @unlink($filename);
        }
    }
}

function session_count_files() {
    return count(glob(session_save_path() . '/*'));
}

?>
