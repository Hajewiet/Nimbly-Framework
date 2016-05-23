<?php

function post_sc($params) {
    if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_POST['form_key'])) {
        return; //not a valid post, do nothing
    }
    run_library("session");
    if (empty($_SESSION['key']) || $_SESSION['key'] != post_get('form_key')) {
        return; //suspicious, could be a CSRF attack.. do nothing.
    }
    load_library("validate");
    $id_suffix = "";
    if (isset($_POST['form_id'])) {
        load_library("sanitize");
        $id_suffix = '_' . sanitize_id(post_get("form_id"));
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

function post_get($input_name, $default=null) {
    if (isset($_POST[$input_name])) {
        return filter_input(INPUT_POST, $input_name, FILTER_SANITIZE_STRING);
    }
    return $default;
}

function post_get_all() {
    $result = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    unset($result["form_id"]);
    unset($result["form_key"]);
    return $result;
}