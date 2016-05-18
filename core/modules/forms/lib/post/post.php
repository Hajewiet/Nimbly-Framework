<?php

function post_token($params) {
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_POST['form_key'])) {
        return; //not a valid post, do nothing
    }
    run_library("session");
    if (empty($_SESSION['key']) || $_SESSION['key'] != $_POST['form_key']) {
        return; //suspicious, could be a CSRF attack.. do nothing.
    }
    load_library("validate");
    $id_suffix = "";
    if (isset($_POST['form_id'])) {
        load_library("sanitize");
        $id_suffix = '_' . sanitize_id($_POST['form_id']);
    }
    
    $validate_include_file = $GLOBALS['SYSTEM']['uri_path'] . '/validate' . $id_suffix . '.inc';
    if (!file_exists($validate_include_file)) {
        //force handling validation by ensuring the validation file existst
        $GLOBALS['SYSTEM']['validation_errors']['_global'][] = "[msg validate_missing]";
        return;
    }
    include_once($validate_include_file);
    if (validate_error_count() == 0) {
        //only handle the form post if there are no validation errors
        @include_once($GLOBALS['SYSTEM']['uri_path'] . '/post' . $id_suffix . '.inc');
    }
}

function post_get_value($input_name, $default=null) {
    if (isset($_POST[$input_name])) {
        return $_POST[$input_name];
    }
    return $default;
}

?>
