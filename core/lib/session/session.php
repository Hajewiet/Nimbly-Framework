<?php

$GLOBALS['SYSTEM']['session_lifetime'] = 24 * 60 * 60; //24 hours
$GLOBALS['SYSTEM']['session_regentime'] = 24 * 60; //24 minutes
$GLOBALS['SYSTEM']['session_path'] = $GLOBALS['SYSTEM']['file_base'] . 'ext/data/.tmp/sessions';

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

    session_save_path($GLOBALS['SYSTEM']['session_path']);
    session_name("nb_session_id");
    @session_start();

    //2. if it's a new session, just create and initialize it and done.
    if (empty($_SESSION)) { //a new session
        session_initialize();
        return;
    }

    //3. remove and restart session if it does not validate
    if (empty($_SESSION['modified']) 
        || empty($_SESSION['created']) 
        || empty($_SESSION['pepper'])
        || $_SESSION['pepper'] != ($_SERVER['PEPPER'] ?? '(none)')
        || $GLOBALS['SYSTEM']['request_time'] >= $_SESSION['modified'] + $GLOBALS['SYSTEM']['session_lifetime']) {
        session_unset();
        session_destroy();
        session_start();
        session_initialize();
        return;
    }

    //4. regen session id
    if ($GLOBALS['SYSTEM']['request_time'] >= $_SESSION['modified'] + $GLOBALS['SYSTEM']['session_regentime']) {
        session_regenerate_id(true);
    }

    //5. update session
    $_SESSION['modified'] = $_SERVER['REQUEST_TIME'];
}

function session_exists() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        return true;
    }
    return isset($_COOKIE['nb_session_id']) 
        && file_exists($GLOBALS['SYSTEM']['session_path'] . '/sess_' . $_COOKIE['nb_session_id']);
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
    $_SESSION['features'] = array();
    $_SESSION['pepper'] = $_SERVER['PEPPER'] ?? '(none)';
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

function session_anon() {
    return session_resume() === false || empty($_SESSION['roles']['anonymous']) === false;
}

function session_user() {
    return session_resume() && empty($_SESSION['roles']['anonymous']);
}
