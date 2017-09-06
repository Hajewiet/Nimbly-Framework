<?php

function logout_sc($params) {
    run_library('session');
    run_library('redirect');
    $_SESSION['roles'] = array('anonymous' => true);
    $_SESSION['features'] = array();
    $_SESSION['username'] = 'anonymous';
    $_SESSION['SYSTEM']['messages'][] = '[text user_logged_out]';
    $redirect_url = get_param_value($params, "redirect", "");
    redirect($redirect_url);
}
