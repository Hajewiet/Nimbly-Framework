<?php


register_shutdown_function('session_test_hard_fail');

function session_test_sc() {
    load_library("session");
    load_library("set");
    $sess_path = "ext/data/.tmp/sessions";
    $test = file_exists($sess_path) || @mkdir($sess_path, 0750, true);
    $test &= is_writable($sess_path);
    session_sc();
    $test = session_resume();
    if (empty($test)) {
        set_variable("session_ok", "fail");
    } else {
        set_variable("session_ok", "pass");
    }
}

function session_test_hard_fail() {
    $error = error_get_last();
    if ($error['type'] === 1) {
    	echo "<strong>Uh oh! Test failed</strong><br />";
    }
}
