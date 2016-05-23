<?php

function session_test_sc() {
    $sess_path = "data/tmp/sessions";
    $test = file_exists($sess_path) || @mkdir($sess_path, 0750, true);
    $test &= is_writable($sess_path);
    load_library("set");
    if ($test === false) {
        set_variable("require", "fail");
        set_variable("session_ok", "fail");
    } else {
        set_variable("require", "pass");
        set_variable("session_ok", "pass");
    }
}
