<?php

function logout_sc($params) {
    run_library('session');
    load_libraries(['redirect', 'text', 'system-messages']);
    $_SESSION = array();
    session_initialize();
    system_message(text_sc(['text' => 'user_logged_out']));
    redirect(get_param_value($params, "redirect", ""));
}
